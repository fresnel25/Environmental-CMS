<?php

namespace App\Controller;

use App\Entity\Visualisation;
use App\Form\VisualisationType;
use App\Repository\VisualisationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/visualisation')]
final class VisualisationController extends AbstractController
{
    #[Route(name: 'app_visualisation_index', methods: ['GET'])]
    public function index(VisualisationRepository $visualisationRepository): Response
    {
        return $this->render('visualisation/index.html.twig', [
            'visualisations' => $visualisationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_visualisation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $visualisation = new Visualisation();
        $form = $this->createForm(VisualisationType::class, $visualisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($visualisation);
            $entityManager->flush();

            return $this->redirectToRoute('app_visualisation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('visualisation/new.html.twig', [
            'visualisation' => $visualisation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_visualisation_show', methods: ['GET'])]
    public function show(Visualisation $visualisation): Response
    {
        return $this->render('visualisation/show.html.twig', [
            'visualisation' => $visualisation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_visualisation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Visualisation $visualisation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VisualisationType::class, $visualisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_visualisation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('visualisation/edit.html.twig', [
            'visualisation' => $visualisation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_visualisation_delete', methods: ['POST'])]
    public function delete(Request $request, Visualisation $visualisation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$visualisation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($visualisation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_visualisation_index', [], Response::HTTP_SEE_OTHER);
    }
}
