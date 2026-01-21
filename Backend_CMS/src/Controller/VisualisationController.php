<?php

namespace App\Controller;

use App\Entity\Dataset;
use App\Entity\User;
use App\Entity\Visualisation;
use App\Form\VisualisationType;
use App\Repository\VisualisationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class VisualisationController extends AbstractController
{
    #[Route('/api/visualisations', methods: ['POST'])]
    #[IsGranted('ROLE_EDITEUR')]
    public function createVisualisation(
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $data = json_decode($request->getContent(), true);

        if (empty($data['dataset']) || empty($data['type_visualisation'])) {
            return $this->json(['error' => 'Données manquantes'], 400);
        }

        $dataset = $em->getRepository(Dataset::class)
            ->find(basename($data['dataset']));

        if (!$dataset) {
            return $this->json(['error' => 'Dataset introuvable'], 404);
        }

        $visualisation = new Visualisation();
        $visualisation->setDataset($dataset);
        $visualisation->setTypeVisualisation($data['type_visualisation']);
        $visualisation->setCorrespondanceJson($data['correspondance_json'] ?? []);
        $visualisation->setStyleJson($data['style_json'] ?? null);
        $visualisation->setNote($data['note'] ?? null);

        /** @var User $user */
        $user = $this->getUser();
        $visualisation->setTenant($user->getTenant());
        $visualisation->setCreatedBy($user);

        // Validation métier
        $this->validateVisualisation($visualisation, $dataset);

        $em->persist($visualisation);
        $em->flush();

        return $this->json($visualisation, 201);
    }

    private function validateVisualisation(
        Visualisation $visu,
        Dataset $dataset
    ): void {
        $type = $visu->getTypeVisualisation();
        $map = $visu->getCorrespondanceJson();

        match ($type) {
            'bar', 'line' => $this->validateXY($map),
            'scatter'     => $this->validateScatter($map),
            'pie'         => $this->validatePie($map),
            'histogram'   => $this->validateHistogram($map),
            default       => throw new \RuntimeException("Type inconnu")
        };
    }

    private function validateXY(array $map): void
    {
        if (!isset($map['x'], $map['y'])) {
            throw new \RuntimeException('x et y requis');
        }
    }

    private function validateScatter(array $map): void
    {
        if (!isset($map['x'], $map['y'])) {
            throw new \RuntimeException('scatter : x et y requis');
        }
    }

    private function validatePie(array $map): void
    {
        if (!isset($map['label'], $map['value'])) {
            throw new \RuntimeException('pie : label et value requis');
        }
    }

    private function validateHistogram(array $map): void
    {
        if (!isset($map['value'])) {
            throw new \RuntimeException('histogram : value requis');
        }
    }


    #[Route('/api/visualisations/{id}/data', methods: ['GET'])]
    public function visualisationData(
        int $id,
        EntityManagerInterface $em
    ): Response {
        $visualisation = $em->getRepository(Visualisation::class)->find($id);

        if (!$visualisation) {
            return $this->json(['error' => 'Visualisation introuvable'], 404);
        }

        $dataset = $visualisation->getDataset();

        if ($dataset->getTypeSource() === 'csv') {
            $data = $this->buildChartFromCsv($dataset, $visualisation);
        } else {
            throw new \RuntimeException('Source API non implémentée');
        }

        return $this->json($data);
    }

    private function buildChartFromCsv(
        Dataset $dataset,
        Visualisation $visu
    ): array {
        $delimiter = $dataset->getDelimiter() ?: ',';
        $mapping = $visu->getCorrespondanceJson();
        $type = $visu->getTypeVisualisation();

        $handle = fopen($dataset->getUrlSource(), 'r');
        if (!$handle) {
            throw new \RuntimeException('Impossible de lire le CSV');
        }

        $headers = fgetcsv($handle, 0, $delimiter);
        if (!$headers) {
            throw new \RuntimeException('CSV vide');
        }

        $headers = array_map(
            fn($h) => trim(preg_replace('/^\xEF\xBB\xBF/', '', $h)),
            $headers
        );

        $indexMap = array_flip($headers);

        $labels = [];
        $values = [];

        while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {

            if ($type === 'pie') {
                if (!isset($mapping['label'], $mapping['value'])) {
                    throw new \RuntimeException('Mapping pie invalide');
                }

                $labels[] = $row[$indexMap[$mapping['label']]] ?? null;
                $values[] = (float) ($row[$indexMap[$mapping['value']]] ?? 0);
            }

            if (in_array($type, ['bar', 'line', 'scatter'])) {
                if (!isset($mapping['x'], $mapping['y'])) {
                    throw new \RuntimeException('Mapping x/y invalide');
                }

                $labels[] = $row[$indexMap[$mapping['x']]] ?? null;
                $values[] = (float) ($row[$indexMap[$mapping['y']]] ?? 0);
            }
        }

        fclose($handle);

        return [
            'type' => $type,
            'labels' => $labels,
            'datasets' => [[
                'label' => ucfirst($mapping['y'] ?? $mapping['value'] ?? 'Valeur'),
                'data' => $values,
            ]]
        ];
    }
}
