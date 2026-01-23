<?php

namespace App\DataFixtures;

use App\Entity\Plan;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private \Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $plans = ['Basic', 'Pro', 'Enterprise'];

        foreach ($plans as $name) {
            $plan = new Plan();
            $plan->setNom($name);
            $plan->setPrix($this->faker->numberBetween(10, 100));
            $plan->setLimite([
                'max_users' => match ($name) {
                    'Basic' => 5,
                    'Pro' => 20,
                    'Enterprise' => 100,
                }
            ]);
            $plan->setDescription("Offre $name");

            $manager->persist($plan);

        $manager->flush();
    }
}
}
