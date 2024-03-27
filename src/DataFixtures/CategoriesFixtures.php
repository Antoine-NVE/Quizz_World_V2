<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{
    private static $categoryCounter = 1;

    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->create('Applications web', '.jpg', $manager);

        $manager->flush();
    }

    // Fonction qui crée une catégorie
    public function create(string $name, string $extension, ObjectManager $manager): void
    {
        $category = new Categories();
        $category->setTitle($name);
        $category->setSlug($this->slugger->slug($category->getTitle())->lower());
        $category->setImage($category->getSlug() . $extension);

        $this->addReference('category-' . self::$categoryCounter, $category);
        self::$categoryCounter++;

        $manager->persist($category);
    }
}
