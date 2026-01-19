<?php

namespace App\DataFixtures;

use App\Entity\{
    Plan,
    Tenant,
    User,
    Article,
    Bloc,
    Dataset,
    ColonneDataset,
    Media,
    Note,
    Theme,
    Visualisation
};
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $faker;
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->faker = Factory::create('fr_FR');
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // --------------------------------------------------
        // 1) PLANS
        // --------------------------------------------------
        $plans = [];
        foreach (['Basic', 'Pro', 'Enterprise'] as $name) {
            $plan = new Plan();
            $plan->setNom($name);
            $plan->setPrix($this->faker->numberBetween(10, 100));
            $plan->setLimite(['max_users' => 20]);
            $plan->setDescription("Offre $name");

            $manager->persist($plan);
            $plans[] = $plan; // on garde les objets
        }

        // --------------------------------------------------
        // 2) TENANTS
        // --------------------------------------------------
      
        $tenants = [];
        for ($i = 1; $i <= 4; $i++) {
            $tenant = new Tenant();
            $tenant->setNom("Tenant $i");
            $tenant->setSlug("tenant-$i");
            $tenant->setStatus(true);
            // Assigner un Plan existant
            $tenant->setPlan($plans[array_rand($plans)]);
            $manager->persist($tenant);
            $tenants[] = $tenant;
        }

        // --------------------------------------------------
        // 3) USERS (4 admins + 4 users)
        // --------------------------------------------------
        $admins = [];
        $users = [];

        for ($i = 1; $i <= 4; $i++) {
            // ADMIN
            $admin = new User();
            $admin->setEmail("admin$i@example.com");
            $admin->setNom($this->faker->lastName());
            $admin->setPrenom($this->faker->firstName());
            $admin->setRoles(["ROLE_ADMINISTRATEUR"]);
            $admin->setStatut(true);
            $admin->setTelephone("60000000$i");
            $admin->setTenant($tenants[$i - 1]);
            $admin->setPassword($this->hasher->hashPassword($admin, "1234"));

            $manager->persist($admin);
            $admins[] = $admin;

            // USER
            $user = new User();
            $user->setEmail("user$i@example.com");
            $user->setNom($this->faker->lastName());
            $user->setPrenom($this->faker->firstName());
            $user->setRoles(["ROLE_USER"]);
            $user->setStatut(true);
            $user->setTelephone("61000000$i");
            $user->setTenant($tenants[$i - 1]);
            $user->setPassword($this->hasher->hashPassword($user, "1234"));

            $manager->persist($user);
            $users[] = $user;
        }

        // --------------------------------------------------
        // 4) DATASETS
        // --------------------------------------------------
        $datasets = [];
        foreach ($tenants as $tenant) {
            for ($i = 0; $i < 2; $i++) {
                $dataset = new Dataset();
                $dataset->setTitre("Dataset " . $this->faker->word());
                $dataset->setDescription($this->faker->sentence(10));
                $dataset->setTypeSource("csv");
                $dataset->setUrlSource("https://drive.google.com/file/d/13u5N-aVc8NtH77tZ2Jl_oQyD1wKgVgjh/view?usp=drive_link");
                $dataset->setDelimiter(";");
                $dataset->setTenant($tenant);
                $dataset->setCreatedBy($admins[array_rand($admins)]);

                $manager->persist($dataset);
                $datasets[] = $dataset;
            }
        }

        // --------------------------------------------------
        // 5) COLONNE DATASET
        // --------------------------------------------------
        foreach ($datasets as $dataset) {
            $admin = $admins[array_rand($admins)];

            // Colonne "quantity" → numérique
            $colQuantity = new ColonneDataset();
            $colQuantity->setNomColonne("quantity");
            $colQuantity->setTypeColonne("numeric");
            $colQuantity->setDataset($dataset);
            $colQuantity->setTenant($dataset->getTenant());
            $colQuantity->setCreatedBy($admin);
            $manager->persist($colQuantity);

            // Colonne "product.partNumber" → catégoriel / string
            $colPartNumber = new ColonneDataset();
            $colPartNumber->setNomColonne("product.partNumber");
            $colPartNumber->setTypeColonne("string");
            $colPartNumber->setDataset($dataset);
            $colPartNumber->setTenant($dataset->getTenant());
            $colPartNumber->setCreatedBy($admin);
            $manager->persist($colPartNumber);
        }

        // --------------------------------------------------
        // 7) VISUALISATIONS
        // --------------------------------------------------
        $visuals = [];
        foreach ($datasets as $dataset) {
            $vis = new Visualisation();
            $vis->setTypeVisualisation("bar");
            $vis->setCorrespondanceJson(['x' => 'quantity', 'y' => 'product.partNumber']);
            $vis->setStyleJson([]);
            $vis->setFilterJson([]);
            $vis->setNote("Exemple de visualisation");
            $vis->setDataset($dataset);
            $vis->setTenant($dataset->getTenant());
            $vis->setCreatedBy($admins[array_rand($admins)]);

            $manager->persist($vis);
            $visuals[] = $vis;
        }

        // --------------------------------------------------
        // 9) MEDIA
        // --------------------------------------------------
        foreach ($tenants as $tenant) {
            for ($i = 0; $i < 3; $i++) {
                $media = new Media();
                $media->setLien("https://picsum.photos/800/600?random=" . rand(1, 9999));
                $media->setTypeImg("image");
                $media->setTitre("Image " . $this->faker->word());
                $media->setTenant($tenant);
                $media->setCreatedBy($admins[array_rand($admins)]);

                $manager->persist($media);
            }
        }

        // --------------------------------------------------
        // 6) ARTICLES + BLOCS
        // --------------------------------------------------
        $articles = [];

        for ($a = 0; $a < 4; $a++) {

            $article = new Article();
            $article->setTitre($this->faker->sentence(3));
            $article->setResume($this->faker->paragraph(2));
            $article->setSlug("article-$a");  // FIX ICI
            $article->setCategorie("dashboard");
            $article->setTenant($tenants[array_rand($tenants)]);
            $article->setCreatedBy($admins[array_rand($admins)]);

            $manager->persist($article);
            $articles[] = $article;

            // blocs
            for ($i = 0; $i < 2; $i++) {

                $bloc = new Bloc();
                $type = $this->faker->randomElement(['text', 'title', 'media', 'visualisation']);
                $bloc->setTypeBloc($type);
                // $bloc->setTitre($this->faker->sentence(2));
                $bloc->setArticle($article);
                $bloc->setPosition($i);
                $bloc->setTenant($article->getTenant());
                $bloc->setCreatedBy($admins[array_rand($admins)]);

                // Contenu JSON selon type
                switch ($type) {
                    case 'text':
                        $bloc->setContenuJson(['text' => $this->faker->paragraph(2)]);
                        break;

                    case 'title':
                        $bloc->setContenuJson(['title' => $this->faker->sentence(1)]);
                        break;

                    case 'media':
                        if (!empty($medias)) {
                            $media = $medias[array_rand($medias)];
                            $bloc->setContenuJson(['lien' => $media->getLien(), 'titre' => $media->getTitre()]);
                        } else {
                            $bloc->setContenuJson(['lien' => null]);
                        }
                        break;

                    case 'visualisation':
                        if (!empty($visuals)) {
                            // prendre une visualisation qui n’a pas encore de bloc
                            $vis = array_shift($visuals);
                            $bloc->setVisualisation($vis);
                        }
                        break;
                }

                $manager->persist($bloc);
            }
        }


        // --------------------------------------------------
        // 10) NOTES
        // --------------------------------------------------
        foreach ($users as $user) {
            foreach ($articles as $article) {
                if (rand(0, 1)) {
                    $blocs = $article->getBlocs();
                    if (!$blocs->isEmpty()) {
                        $note = new Note();
                        $note->setValeur(rand(1, 5));
                        $note->setCreatedBy($user);
                        $note->setTenant($user->getTenant());
                        // assigner un bloc aléatoire existant
                        $note->setBloc($blocs->first());

                        $manager->persist($note);
                    }
                }
            }
        }

        // --------------------------------------------------
        // 11) THEMES
        // --------------------------------------------------
        foreach ($tenants as $tenant) {
            $theme = new Theme();
            $theme->setNomTheme("Thème " . $tenant->getNom());
            $theme->setDescription("Thème appliqué au tenant.");
            $theme->setVariableCss(['primary' => '#000']);
            $theme->setActive(true);
            $theme->setTenant($tenant);
            $theme->setCreatedBy($admins[array_rand($admins)]);

            $manager->persist($theme);
        }

        // --------------------------------------------------
        $manager->flush();
    }
}
