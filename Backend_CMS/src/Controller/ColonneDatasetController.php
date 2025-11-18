<?php

namespace App\Controller;

use App\Entity\ColonneDataset;
use App\Form\ColonneDatasetType;
use App\Repository\ColonneDatasetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/colonne/dataset')]
final class ColonneDatasetController extends AbstractController
{
    #[Route(name: 'app_colonne_dataset_index', methods: ['GET'])]
    public function index(ColonneDatasetRepository $colonneDatasetRepository): Response
    {
        return $this->render('colonne_dataset/index.html.twig', [
            'colonne_datasets' => $colonneDatasetRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_colonne_dataset_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $colonneDataset = new ColonneDataset();
        $form = $this->createForm(ColonneDatasetType::class, $colonneDataset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($colonneDataset);
            $entityManager->flush();

            return $this->redirectToRoute('app_colonne_dataset_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('colonne_dataset/new.html.twig', [
            'colonne_dataset' => $colonneDataset,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_colonne_dataset_show', methods: ['GET'])]
    public function show(ColonneDataset $colonneDataset): Response
    {
        return $this->render('colonne_dataset/show.html.twig', [
            'colonne_dataset' => $colonneDataset,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_colonne_dataset_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ColonneDataset $colonneDataset, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ColonneDatasetType::class, $colonneDataset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_colonne_dataset_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('colonne_dataset/edit.html.twig', [
            'colonne_dataset' => $colonneDataset,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_colonne_dataset_delete', methods: ['POST'])]
    public function delete(Request $request, ColonneDataset $colonneDataset, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$colonneDataset->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($colonneDataset);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_colonne_dataset_index', [], Response::HTTP_SEE_OTHER);
    }
}
