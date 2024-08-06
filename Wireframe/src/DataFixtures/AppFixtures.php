<?php

namespace App\DataFixtures;

use App\Entity\AnnualLeave;
use App\Entity\Team;
use App\Entity\User;
use App\Entity\Worker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $administrator = new User();

        $administrator->setFirstName("Andjela");
        $administrator->setLastName("Dujmov");
        $administrator->setEmail("andjeladujmov@gmail.com");
        $administrator->setRoles([\App\Enum\Role::ADMIN->value, \App\Enum\Role::USER]);
        $administrator->setUsername("admin12");
        $hashedPassword = $this->passwordHasher->hashPassword(
            $administrator,
            '123456'
        );
        $administrator->setPassword($hashedPassword);
        $administrator->setVerified(true);

        $manager->persist($administrator);
        $manager->flush();
    }
}
