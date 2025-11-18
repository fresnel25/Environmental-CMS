<?php

namespace App\Controller;

use App\Entity\Dataset;
use App\Form\DatasetType;
use App\Repository\DatasetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dataset')]
final class DatasetController extends AbstractController
{
    #[Route(name: 'app_dataset_index', methods: ['GET'])]
    public function index(DatasetRepository $datasetRepository): Response
    {
        return $this->render('dataset/index.html.twig', [
            'datasets' => $datasetRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_dataset_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dataset = new Dataset();
        $form = $this->createForm(DatasetType::class, $dataset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dataset);
            $entityManager->flush();

            return $this->redirectToRoute('app_dataset_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dataset/new.html.twig', [
            'dataset' => $dataset,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dataset_show', methods: ['GET'])]
    public function show(Dataset $dataset): Response
    {
        return $this->render('dataset/show.html.twig', [
            'dataset' => $dataset,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dataset_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dataset $dataset, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DatasetType::class, $dataset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dataset_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dataset/edit.html.twig', [
            'dataset' => $dataset,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dataset_delete', methods: ['POST'])]
    public function delete(Request $request, Dataset $dataset, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dataset->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($dataset);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dataset_index', [], Response::HTTP_SEE_OTHER);
    }
}
