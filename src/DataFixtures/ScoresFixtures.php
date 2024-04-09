<?php

namespace App\DataFixtures;

use App\Entity\Scores;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ScoresFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 27; $i++) {
            for ($j = 0; $j < 5; $j++) {
                if ($faker->numberBetween(0, 2) === 1) {
                    $score = new Scores();
                    $score->setQuestionnaire($this->getReference('questionnaire-' . $i + 1));
                    $score->setUser($this->getReference('user-' . $j + 1));
                    $score->setScore($faker->numberBetween(0, 10));

                    $manager->persist($score);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            QuestionnairesFixtures::class,
            UsersFixtures::class
        ];
    }
}
