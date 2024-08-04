<?php

namespace App\DataFixtures;

use App\Entity\AnnualLeave;
use App\Entity\Team;
use App\Entity\User;
use App\Entity\Worker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $administrator = new User();

        $administrator->setFirstName("Andjela");
        $administrator->setLastName("Dujmov");
        $administrator->setEmail("andjeladujmov@gmail.com");
        $administrator->setRoles([\App\Enum\Role::ADMIN->value]);
        $administrator->setUsername("admin12");
        $administrator->setPassword("123456");
        $administrator->setVerified(true);

        $manager->persist($administrator);
        $manager->flush();
    }
}
