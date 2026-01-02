<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\User;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class MediaController extends AbstractController
{
    #[IsGranted('ROLE_AUTEUR')]
    #[Route('/api/media/upload', methods: ['POST'])]
    public function upload(Request $request, EntityManagerInterface $em): Response
    {
        $file = $request->files->get('file');

        if (!$file) {
            return $this->json(['error' => 'Aucun fichier reçu'], 400);
        }

        //  Types autorisés (optionnel mais recommandé)
        $allowedMimeTypes = [
            'image/png',
            'image/jpeg',
            'image/webp',
            'image/gif',
        ];

        if (!in_array($file->getClientMimeType(), $allowedMimeTypes, true)) {
            return $this->json(['error' => 'Type de fichier non autorisé'], 400);
        }

        // Nom de fichier unique
        $filename = uniqid('media_', true) . '.' . $file->guessExtension();

        //  Déplacement du fichier
        $file->move(
            $this->getParameter('kernel.project_dir') . '/public/uploads/media',
            $filename
        );

        // Entité Media
        $media = new Media();
        $media->setTitre($filename);
        $media->setTypeImg($file->getClientMimeType()); // IMPORTANT
        $media->setLien('/uploads/media/' . $filename);

        /** @var User $user */
        $user = $this->getUser();

        // Si tu as tenant + createdBy
        if ($user) {
            $media->setCreatedBy($user);

            if (method_exists($media, 'setTenant') && method_exists($user, 'getTenant')) {
                $media->setTenant($user->getTenant());
            }
        }

        $em->persist($media);
        $em->flush();

        return $this->json($media, Response::HTTP_CREATED);
    }

    #[Route('/api/public/tenant/{tenantId}/media', methods: ['GET'])]
    public function publicTenantMedia(
        int $tenantId,
        MediaRepository $mediaRepository
    ): Response {
        $medias = $mediaRepository->findBy([
            'tenant' => $tenantId
        ]);

        return $this->json($medias, 200, [], [
            'groups' => ['media:read']
        ]);
    }
}
