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


        $allowedImageTypes = ['image/png', 'image/jpeg', 'image/webp', 'image/gif'];
        $allowedVideoTypes = ['video/mp4', 'video/webm', 'video/ogg'];

        if (!in_array($file->getClientMimeType(), [...$allowedImageTypes, ...$allowedVideoTypes], true)) {
            return $this->json(['error' => 'Type de fichier non autorisé'], 400);
        }


        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);


        $safeBase = preg_replace('/[\/\\\\:*?"<>|]/', '-', $originalName);
        $safeBase = trim(preg_replace('/\s+/', ' ', $safeBase));


        $ext = $file->guessExtension() ?? $file->getClientOriginalExtension() ?? 'bin';


        $filename = sprintf('%s-%s.%s', $safeBase, substr(uniqid('', true), -6), $ext);

        $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/media';


        $file->move($uploadDir, $filename);


        $media = new Media();
        $media->setTitre($safeBase);
        $media->setTypeImg($file->getClientMimeType());
        $media->setLien('/uploads/media/' . $filename);

        /** @var User $user */
        $user = $this->getUser();
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
