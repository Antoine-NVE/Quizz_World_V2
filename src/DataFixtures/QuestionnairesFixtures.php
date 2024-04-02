<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Questionnaires;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuestionnairesFixtures extends Fixture implements DependentFixtureInterface
{
    private const DIFFICULTIES = ['facile', 'moyen', 'difficile'];

    private static $categoryCounter = 1;
    private static $questionnaireCounter = 1;

    public function load(ObjectManager $manager): void
    {
        $this->create($this->getReference('category-' . self::$categoryCounter), self::DIFFICULTIES, $manager);
        $this->create($this->getReference('category-' . self::$categoryCounter), self::DIFFICULTIES, $manager);
        $this->create($this->getReference('category-' . self::$categoryCounter), self::DIFFICULTIES, $manager);
        $this->create($this->getReference('category-' . self::$categoryCounter), self::DIFFICULTIES, $manager);
        $this->create($this->getReference('category-' . self::$categoryCounter), self::DIFFICULTIES, $manager);
        $this->create($this->getReference('category-' . self::$categoryCounter), self::DIFFICULTIES, $manager);
        $this->create($this->getReference('category-' . self::$categoryCounter), self::DIFFICULTIES, $manager);
        $this->create($this->getReference('category-' . self::$categoryCounter), self::DIFFICULTIES, $manager);
        $this->create($this->getReference('category-' . self::$categoryCounter), self::DIFFICULTIES, $manager);

        $manager->flush();
    }

    // Fonction qui crée les 3 questionnaires d'une catégorie
    public function create(Categories $category, array $difficulties, ObjectManager $manager): void
    {
        foreach ($difficulties as $difficulty) {
            $questionnaire = new Questionnaires();
            $questionnaire->setDifficulty($difficulty);
            $questionnaire->setCategory($category);

            $this->addReference('questionnaire-' . self::$questionnaireCounter, $questionnaire);
            self::$questionnaireCounter++;

            $manager->persist($questionnaire);
        }

        self::$categoryCounter++;
    }

    public function getDependencies()
    {
        return [CategoriesFixtures::class];
    }
}
