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
        EntityManagerInterface $em
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

        if ($type === 'csv') {
            $dataset->setDelimiter($data['delimiter'] ?? ';');
        }

        /** @var User $user */
        $user = $this->getUser();
        $dataset->setTenant($user->getTenant());
        $dataset->setCreatedBy($user);

        $em->persist($dataset);

        if ($type === 'csv') {
            $this->analyseCsv($dataset, $em);
        }

        $em->flush();

        return $this->json($dataset, Response::HTTP_CREATED);
    }




    private function analyseCsv(Dataset $dataset, EntityManagerInterface $em): void
    {
        $url = $dataset->getUrlSource();
        $delimiter = $dataset->getDelimiter() ?? ';';

        // 🔹 Déterminer le handle
        if (str_starts_with($url, 'http')) {
            $handle = @fopen($url, 'r');
        } else {
            $path = $this->getParameter('kernel.project_dir') . '/public' . $url;

            if (!file_exists($path)) {
                throw new \RuntimeException("CSV introuvable : $path");
            }

            $handle = fopen($path, 'r');
        }

        if (!$handle) {
            throw new \RuntimeException("Impossible d’ouvrir le CSV");
        }

        // 🔹 Lecture de l’en-tête
        $headers = fgetcsv($handle, 0, $delimiter);

        if (!$headers || count($headers) === 0) {
            fclose($handle);
            throw new \RuntimeException("CSV vide ou invalide");
        }

        // 🔹 Lecture d’un échantillon
        $sampleRow = fgetcsv($handle, 0, $delimiter) ?: [];

        foreach ($headers as $index => $header) {
            $value = $sampleRow[$index] ?? null;

            $type = $this->guessType($value);

            $colonne = new ColonneDataset();
            $colonne->setNomColonne(trim($header));
            $colonne->setTypeColonne($type);
            $colonne->setDataset($dataset);

            $em->persist($colonne);
        }

        fclose($handle);
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
    private function guessType(?string $value): string
    {
        if ($value === null || $value === '') {
            return 'string';
        }

        if (is_numeric($value)) {
            return 'number';
        }

        // Date simple YYYY-MM-DD
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return 'date';
        }

        return 'string';
    }
}
