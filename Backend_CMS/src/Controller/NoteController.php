<?php

namespace App\Controller;

use App\Entity\Bloc;
use App\Entity\Note;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class NoteController extends AbstractController
{
    #[IsGranted('ROLE_ABONNE')]
    #[Route('/api/blocs/{id}/note', name: 'api_bloc_noter', methods: ['POST'])]
    public function noterBloc(
        Bloc $bloc,
        Request $request,
        EntityManagerInterface $em,
        Security $security
    ): JsonResponse {
        $user = $security->getUser();
        if (!$user) {
            return new JsonResponse(['message' => 'Unauthorized'], 401);
        }

        $data = json_decode($request->getContent(), true) ?? [];
        $valeur = $data['valeur'] ?? null;

        // Validation forte
        if (!is_numeric($valeur)) {
            return new JsonResponse(['message' => 'Valeur manquante ou invalide'], 400);
        }
        $valeur = (int) $valeur;
        if ($valeur < 1 || $valeur > 5) {
            return new JsonResponse(['message' => 'Note invalide (1 à 5)'], 400);
        }

        // 1 abonné = 1 note (aligner la propriété: createdBy vs user)
        $note = $em->getRepository(Note::class)->findOneBy([
            'bloc' => $bloc,
            'createdBy' => $user, // <-- adapte si ta propriété est 'user'
        ]);

        if (!$note) {
            $note = new Note();
            $note->setBloc($bloc);
            $note->setCreatedBy($user); // <-- adapte si 'setUser'
        }

        $note->setValeur($valeur);
        $em->persist($note);
        $em->flush();

        // Calcul de la moyenne (arrondi à 2 décimales)
        $avg = (float) $em->createQuery(
            'SELECT AVG(n.valeur) FROM App\Entity\Note n WHERE n.bloc = :bloc'
        )->setParameter('bloc', $bloc)->getSingleScalarResult();

        return new JsonResponse([
            'success' => true,
            'note'    => $valeur,
            'moyenne' => round($avg, 2),
        ]);
    }

    #[Route('/api/bloc/{id}', name: 'get_bloc_note', methods: ['GET'])]
    public function getNote(Bloc $bloc,  EntityManagerInterface $em): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'Utilisateur non connecté'], 401);
        }

        $note = $em->getRepository(Note::class)->findOneBy([
            'bloc' => $bloc,
            'createdBy' => $user, // attention au champ exact selon ton entité
        ]);

        return $this->json([
            'ma_note' => $note ? $note->getValeur() : null
        ]);
    }
}
