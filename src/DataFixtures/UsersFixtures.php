<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class UsersFixtures extends Fixture
{
    private static $userCounter = 1;

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $admin = new Users();
        $admin->setEmail('admin@quizzworld.fr');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin'));
        $admin->setPseudo('Quizz World');
        $admin->setIsVerified(true);

        $this->addReference('user-' . self::$userCounter, $admin);
        self::$userCounter++;
        $manager->persist($admin);

        for ($i = 0; $i < 4; $i++) {
            $user = new Users();
            $user->setEmail($faker->email());
            $user->setPassword($this->hasher->hashPassword($user, 'password'));
            $user->setPseudo($faker->firstName());
            $user->setIsVerified(true);

            $this->addReference('user-' . self::$userCounter, $user);
            self::$userCounter++;
            $manager->persist($user);
        }

        $manager->flush();
    }
}
