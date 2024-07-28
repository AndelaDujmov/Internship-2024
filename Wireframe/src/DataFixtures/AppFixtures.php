<?php

namespace App\DataFixtures;

use App\Entity\AnnualLeave;
use App\Entity\Team;
use App\Entity\Worker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        for ($i = 1; $i < 3; $i++) {
            $team = new Team();
            $team->setMemberNumber(mt_rand(1, 6));
            $team->setName("Team " . (string)($i));
            $manager->persist($team);
        }

        $manager->flush();
    }
}
