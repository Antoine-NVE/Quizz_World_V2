<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture implements DependentFixtureInterface
{
    private static $categoryCounter = 1;

    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->create('Applications web', '.jpg', $manager);
        $this->create('JavaScript', '.png', $manager);
        $this->create('Le XXième Siècle', '.jpg', $manager);
        $this->create('Nintendo', '.jpg', $manager);
        $this->create('Trouver le Nombre', '.jpg', $manager);
        $this->create('Microsoft', '.jpg', $manager);
        $this->create('PHP', '.jpg', $manager);
        $this->create('Méandres d\'Internet', '.jpg', $manager);
        $this->create('Star Wars', '.jpg', $manager);

        $manager->flush();
    }

    // Fonction qui crée une catégorie
    public function create(string $name, string $extension, ObjectManager $manager): void
    {
        $category = new Categories();
        $category->setTitle($name);
        $category->setSlug($this->slugger->slug($category->getTitle())->lower());
        $category->setImage($category->getSlug() . $extension);
        $category->setUser($this->getReference('admin'));
        $category->setIsActive(true);

        $this->addReference('category-' . self::$categoryCounter, $category);
        self::$categoryCounter++;

        $manager->persist($category);
    }

    public function getDependencies()
    {
        return [UsersFixtures::class];
    }
}
