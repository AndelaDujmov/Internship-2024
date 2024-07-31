<?php

namespace App\DataFixtures;

use App\Entity\AnnualLeave;
use App\Entity\RequestForAL;
use App\Entity\Role;
use App\Entity\Team;
use App\Entity\TeamLeaders;
use App\Entity\User;
use App\Entity\Worker;
use App\Enum\Status;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeamFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $teamLeader = new User();
        $teamLeader->setUsername("TeamLeader1");
        $teamLeader->setEmail("t1@gmail.com");
        $teamLeader->setPassword("A1232131.");
        $teamLeader->setRoles([\App\Enum\Role::TEAMLEADER->value]);

        for ($i = 1; $i < 3; $i++) {
            // $worker = new User();
            // $worker->setUsername("Worker Name" . (string)($i));
            // $worker->setEmail("worker" . (string)($i). "@gmail.com");
            // $worker->setPassword("23454");

            $team = new Team();
            $teamLeaders = new TeamLeaders();
            $team->setName("Team " . (string)($i));  
            $teamLeaders->setTeam($team);
            $teamLeaders->setTeamLead($teamLeader);
            $teamLeaders->setProjectLeader($teamLeader);
            
            $manager->persist($team);
            $manager->persist($teamLeader);
            $manager->persist($teamLeaders);
      
        }

        $manager->flush();
    }
}
