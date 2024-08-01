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

        $projectLeader = new User();
        $projectLeader->setUsername("ProjectLeader1");
        $projectLeader->setEmail("t4@gmail.com");
        $projectLeader->setPassword("A1232131.");
        $projectLeader->setRoles([\App\Enum\Role::PROJECTLEADER->value]);

        $teamMember = new User();
        $teamMember->setUsername("TeamMember1");
        $teamMember->setEmail("tm1@gmail.com");
        $teamMember->setPassword("A1232131.");
        $teamMember->setRoles([\App\Enum\Role::WORKER->value]);

        $teamMember2 = new User();
        $teamMember2->setUsername("TeamMember2");
        $teamMember2->setEmail("tm2@gmail.com");
        $teamMember2->setPassword("A1232131.");
        $teamMember2->setRoles([\App\Enum\Role::WORKER->value]);

        $teamMember3 = new User();
        $teamMember3->setUsername("TeamMember3");
        $teamMember3->setEmail("tm3@gmail.com");
        $teamMember3->setPassword("A1232131.");
        $teamMember3->setRoles([\App\Enum\Role::WORKER->value]);

        for ($i = 1; $i < 3; $i++) {
            // $worker = new User();
            // $worker->setUsername("Worker Name" . (string)($i));
            // $worker->setEmail("worker" . (string)($i). "@gmail.com");
            // $worker->setPassword("23454");

            $team = new Team();
            $teamLeaders = new TeamLeaders();
            $team->setName("Team " . (string)($i));  
            $team->setNumberOfMemers(4);
            $team->addMember($teamMember);
            $team->addMember($teamMember2);
            $team->addMember($teamMember3);
            $teamLeaders->setTeam($team);
            $teamLeaders->setTeamLead($teamLeader);
            $teamLeaders->setProjectLeader($projectLeader);
                        
            $manager->persist($team);
            $manager->persist($teamMember);
            $manager->persist($teamMember2);
            $manager->persist($teamMember3);
            $manager->persist($teamLeader);
            $manager->persist($teamLeaders);
            $manager->persist($projectLeader);
        }

        $manager->flush();
    }
}
