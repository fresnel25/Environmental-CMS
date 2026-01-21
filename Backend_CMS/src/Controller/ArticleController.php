<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Theme;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\TenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleController extends AbstractController
{
    #[Route('/api/public/{tenantSlug}/articles', methods: ['GET'])]
    public function publicArticlesByTenant(
        string $tenantSlug,
        ArticleRepository $articleRepo,
        TenantRepository $tenantRepo
    ): Response {
        $tenant = $tenantRepo->findOneBy(['slug' => $tenantSlug]);

        if (!$tenant) {
            return $this->json(['error' => 'Tenant introuvable'], 404);
        }

        $articles = $articleRepo->findBy([
            'tenant' => $tenant,
            /* 'status' => false  */
        ]);

        return $this->json($articles, 200, [], [
            'groups' => ['article:read', 'bloc:read']
        ]);
    }

    #[Route('/api/articles/{id}/theme', name: 'article_theme', methods: ['PATCH'])]
    public function updateTheme(
        Article $article,
        Request $request,
        EntityManagerInterface $em
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        // Vérifie si l'article a déjà un thème
        $theme = $article->getTheme();
        if (!$theme) {
            $theme = new Theme();
            $theme->setNomTheme("Article " . $article->getId());
            $theme->setActive(true);
            $article->setTheme($theme);
            $em->persist($theme);
        }

        // Applique les styles envoyés
        $theme->setVariableCss($data['variable_css'] ?? []);

        $em->persist($article);
        $em->flush();

        return new JsonResponse([
            'message' => 'Thème sauvegardé',
            'theme' => $theme->getVariableCss(),
        ]);
    }
}
