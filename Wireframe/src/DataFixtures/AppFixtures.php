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

       
        $manager->flush();
    }
}
