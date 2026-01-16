<?php

namespace App\Controller;

use App\Entity\Dataset;
use App\Entity\ColonneDataset;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DatasetController extends AbstractController
{
    #[Route('/api/datasets/analyse', methods: ['POST'])]
    #[IsGranted('ROLE_EDITEUR')]
    public function analyseDataset(
        Request $request,
        EntityManagerInterface $em,
        HttpClientInterface $httpClient
    ): Response {
        $data = json_decode($request->getContent(), true);

        $type = $data['type_source'] ?? null;

        if (!$type || !in_array($type, ['csv', 'api'], true)) {
            return $this->json(['error' => 'Type de source invalide'], 400);
        }

        $dataset = new Dataset();
        $dataset->setTitre($data['titre'] ?? 'Dataset');
        $dataset->setDescription($data['description'] ?? '');
        $dataset->setTypeSource($type);
        $dataset->setUrlSource($data['url_source'] ?? null);

        /** @var User $user */
        $user = $this->getUser();
        $dataset->setTenant($user->getTenant());
        $dataset->setCreatedBy($user);

        $em->persist($dataset);

        if ($type === 'csv') {
            $this->analyseCsv($dataset, $data, $em);
        }

        if ($type === 'api') {
            $this->analyseApi($dataset, $data, $httpClient, $em);
        }

        $em->flush();

        return $this->json($dataset, Response::HTTP_CREATED);
    }


    private function analyseCsv(Dataset $dataset, array $data, EntityManagerInterface $em): void
    {
        $delimiter = $data['delimiter'] ?? null;

        $handle = @fopen($dataset->getUrlSource(), 'r');

        if (!$handle) {
            throw new \RuntimeException('Impossible d’ouvrir la source CSV');
        }

        // 🔹 Lire la première ligne brute
        $firstLine = fgets($handle);

        if (
            str_contains($firstLine, '<html')
            || str_contains($firstLine, '<!DOCTYPE')
        ) {
            fclose($handle);
            throw new \RuntimeException(
                'La source ne retourne pas un CSV mais du HTML'
            );
        }

        // 🔥 Supprimer BOM UTF-8
        $firstLine = preg_replace('/^\xEF\xBB\xBF/', '', $firstLine);

        // 🔎 Auto-détection du delimiter si absent ou incorrect
        if (!$delimiter) {
            $delimiter = str_contains($firstLine, ';') ? ';' : ',';
        }

        $dataset->setDelimiter($delimiter);

        // 🔹 Interpréter l’en-tête CSV
        $headers = str_getcsv($firstLine, $delimiter);

        if (!$headers || count($headers) < 1) {
            fclose($handle);
            throw new \RuntimeException('En-tête CSV invalide');
        }

        // 🔹 Lire des échantillons (20 lignes max)
        $samples = [];
        for ($i = 0; $i < 20 && ($row = fgetcsv($handle, 0, $delimiter)); $i++) {
            foreach ($row as $index => $value) {
                $samples[$index][] = $value;
            }
        }

        fclose($handle);

        // 🔹 Créer les colonnes
        foreach ($headers as $index => $name) {
            $name = trim($name);
            $name = mb_substr($name, 0, 200); // sécurité DB

            if ($name === '') {
                continue;
            }

            $col = new ColonneDataset();
            $col->setNomColonne($name);
            $col->setTypeColonne(
                $this->detectType($samples[$index] ?? [])
            );
            $col->setDataset($dataset);
            $col->setTenant($dataset->getTenant());

            $em->persist($col);
        }
    }



    private function analyseApi(
        Dataset $dataset,
        array $data,
        HttpClientInterface $client,
        EntityManagerInterface $em
    ): void {
        $config = $data['api_config'] ?? [];
        $dataset->setApiConfig($config);

        $response = $client->request(
            $config['method'] ?? 'GET',
            $dataset->getUrlSource(),
            ['headers' => $config['headers'] ?? []]
        );

        $json = $response->toArray();

        // Extraire les données (ex: data.items)
        $items = $json;
        if (!empty($config['data_path'])) {
            foreach (explode('.', $config['data_path']) as $key) {
                $items = $items[$key] ?? [];
            }
        }

        if (!isset($items[0]) || !is_array($items[0])) {
            return;
        }

        foreach ($items[0] as $key => $value) {
            $col = new ColonneDataset();
            $col->setNomColonne($key);
            $col->setTypeColonne(is_numeric($value) ? 'number' : 'string');
            $col->setDataset($dataset);
            $col->setTenant($dataset->getTenant());

            $em->persist($col);
        }
    }

    private function detectType(array $values): string
    {
        $values = array_filter($values, fn($v) => $v !== null && $v !== '');

        if (empty($values)) {
            return 'string';
        }

        $isNumeric = true;
        $isDate = true;

        foreach ($values as $value) {
            if (!is_numeric($value)) {
                $isNumeric = false;
            }

            if (strtotime($value) === false) {
                $isDate = false;
            }
        }

        if ($isNumeric) {
            return 'number';
        }

        if ($isDate) {
            return 'date';
        }

        return 'string';
    }
}
