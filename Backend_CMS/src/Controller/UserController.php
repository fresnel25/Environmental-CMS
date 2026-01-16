<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Plan;
use App\Entity\Tenant;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserController extends AbstractController
{
    // Création d'un utilisateur (déjà existant)
    public function __invoke(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher
    ) {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setEmail($data['email']);
        $user->setRoles(['ROLE_USER']);
        $user->setNom($data['nom']);
        $user->setPrenom($data['prenom']);
        $user->setTelephone($data['telephone']);
        $user->setStatut(true);

        $user->setPassword(
            $hasher->hashPassword($user, $data['password'])
        );

        // Tenant
        if (isset($data['tenant'])) {
            $tenantId = basename($data['tenant']);
            $tenant = $em->getRepository(Tenant::class)->find($tenantId);
            $user->setTenant($tenant);
        }

        $em->persist($user);
        $em->flush();

        return new JsonResponse(['message' => 'User created'], 201);
    }

    // Nouveau : récupération de l'utilisateur connecté
    #[Route('/api/me', name: 'api_me', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function me(): JsonResponse
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return new JsonResponse(['error' => 'Unauthorized'], 401);
        }

        return new JsonResponse([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'tenant' => $user->getTenant() ? [
                'id' => $user->getTenant()->getId(),
                'nom' => $user->getTenant()->getNom(),
                'slug' => $user->getTenant()->getSlug()
            ] : null,
        ]);
    }

    #[Route('/api/tenants/users', name: 'tenant_create_user', methods: ['POST'])]
    #[IsGranted('ROLE_ADMINISTRATEUR')]
    public function createUserForTenant(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher,
        Security $security
    ): JsonResponse {
        /** @var User $admin */
        $admin = $security->getUser();

        if (!$admin || !$admin->getTenant()) {
            return new JsonResponse(['error' => 'Tenant introuvable'], 400);
        }

        $tenant = $admin->getTenant();

        $data = json_decode($request->getContent(), true);

        foreach (['email', 'password', 'nom', 'prenom', 'role'] as $field) {
            if (empty($data[$field])) {
                return new JsonResponse([
                    'error' => "Le champ '$field' est requis"
                ], 400);
            }
        }

        $allowedRoles = [
            'ROLE_ADMINISTRATEUR',
            'ROLE_EDITEUR',
            'ROLE_AUTEUR',
            'ROLE_ABONNE'
        ];

        if (!in_array($data['role'], $allowedRoles, true)) {
            return new JsonResponse(['error' => 'Rôle invalide'], 400);
        }

        $user = new User();
        $user->setEmail($data['email']);
        $user->setNom($data['nom']);
        $user->setPrenom($data['prenom']);
        $user->setTelephone($data['telephone'] ?? null);
        $user->setStatut(true);

        // Toujours ROLE_USER + rôle métier
        $user->setRoles(['ROLE_USER', $data['role']]);

        // EXPLICITE (comme subscribe)
        $user->setTenant($tenant);

        $user->setPassword(
            $hasher->hashPassword($user, $data['password'])
        );

        $em->persist($user);
        $em->flush();

        return new JsonResponse([
            'message' => 'Utilisateur créé avec succès',
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles(),
                'tenant' => $tenant->getSlug()
            ]
        ], 201);
    }





    // Création de tenant plus user avec le role Administrateur lors de la création du organisation(tenant)
    #[Route('/api/tenants/register', name: 'tenant_register', methods: ['POST'])]
    public function tenant_register(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher,
        SluggerInterface $slugger
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        // Récupération du plan
        $plan = $em->getRepository(Plan::class)->findOneBy([
            'nom' => $data['plan']
        ]);

        // Validation simple
        foreach (['nom', 'prenom', 'telephone', 'tenant', 'email', 'password', 'plan'] as $field) {
            if (empty($data[$field])) {
                return new JsonResponse([
                    'error' => "Le champ '$field' est requis"
                ], 400);
            }
        }


        if (!$plan) {
            return new JsonResponse(['error' => 'Plan invalide'], 400);
        }

        // Création du tenant
        $tenant = new Tenant();
        $tenant->setNom($data['tenant']);
        $tenant->setPlan($plan);
        $tenant->setStatus(true);
        $tenant->setSlug(strtolower($slugger->slug($data['tenant'])));

        // Création de l'admin
        $user = new User();
        $user->setEmail($data['email']);
        $user->setNom($data['nom']);
        $user->setPrenom($data['prenom']);
        $user->setTelephone($data['telephone']);
        $user->setStatut(true);
        $user->setRoles(['ROLE_ADMINISTRATEUR']);
        $user->setTenant($tenant);
        $user->setPassword(
            $hasher->hashPassword($user, $data['password'])
        );

        $em->persist($tenant);
        $em->persist($user);
        $em->flush();

        return new JsonResponse([
            'message' => 'Tenant created',
            'tenant' => [
                'id' => $tenant->getId(),
                'slug' => $tenant->getSlug()
            ]
        ], 201);
    }


    // Création d'un user abonné à une organisation(tenant)
    #[Route('/api/tenants/{slug}/subscribe', name: 'tenant_subscribe', methods: ['POST'])]
    public function tenant_subscribe(
        string $slug,
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher
    ): JsonResponse {
        $tenant = $em->getRepository(Tenant::class)->findOneBy([
            'slug' => $slug
        ]);

        if (!$tenant) {
            return new JsonResponse(['error' => 'Tenant pas trouvé'], 404);
        }

        $data = json_decode($request->getContent(), true);

        foreach (['email', 'password'] as $field) {
            if (empty($data[$field])) {
                return new JsonResponse([
                    'error' => "Le champ '$field' est requis"
                ], 400);
            }
        }

        $user = new User();
        $user->setEmail($data['email']);
        $user->setNom($data['nom']);
        $user->setPrenom($data['prenom']);
        $user->setTelephone($data['telephone']);
        $user->setStatut(true);
        $user->setRoles(['ROLE_ABONNE']);
        $user->setTenant($tenant);
        $user->setPassword(
            $hasher->hashPassword($user, $data['password'])
        );

        $em->persist($user);
        $em->flush();

        return new JsonResponse([
            'message' => 'Subscribed successfully',
            'tenant' => $tenant->getSlug()
        ], 201);
    }

    // 
    #[Route('/api/public/{slug}/articles', name: 'public_tenant_articles', methods: ['GET'])]
    public function public_tenant_articles(
        string $slug,
        EntityManagerInterface $em
    ): JsonResponse {
        $tenant = $em->getRepository(Tenant::class)->findOneBy([
            'slug' => $slug
        ]);

        if (!$tenant) {
            return new JsonResponse(['error' => 'Tenant pas trouvé'], 404);
        }

        $articles = $em->getRepository(Article::class)->findBy([
            'tenant' => $tenant,
            'published' => true
        ], ['createdAt' => 'DESC']);

        $data = array_map(fn(Article $article) => [
            'id' => $article->getId(),
            'titre' => $article->getTitre(),
            /* 'excerpt' => $article->getExcerpt(),
            'createdAt' => $article->getCreatedAt()->format('Y-m-d'), */
        ], $articles);

        return new JsonResponse([
            'tenant' => $tenant->getNom(),
            'articles' => $data
        ]);
    }
}
