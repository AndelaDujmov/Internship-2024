<?php

namespace App\DataFixtures;

use App\Entity\AnnualLeave;
use App\Entity\RequestForAL;
use App\Entity\Role;
use App\Entity\Team;
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

        $role = new Role();
        $role->setName("Worker");
        for ($i = 1; $i < 3; $i++) {
            $worker = new User();
            $worker->setName("Worker Name" . (string)($i));
            $worker->setSurname("Worker Surname" . (string)($i));
            $worker->setRole($role);

            $team = new Team();
            $team->addMember($worker);
            $team->setName("Team " . (string)($i));

            $al = new AnnualLeave();
            $al->setMonth("Month " . (string)($i));
            $al->setYear(mt_rand(2023, 2025));
            $al->setWorker($worker);
            $al->setTotalDays(mt_rand(10, 30));

            $alRequest = new RequestForAL();
            $alRequest->setStart(new DateTime());
            $date = new DateTime();
            $alRequest->setEnd($date->modify('+1 week'));
            $alRequest->setStatus(Status::PENDING);
            $alRequest->setTeamLeader(null);
            $alRequest->setProjectLeader(null);
            $alRequest->setWorker($worker);
            $alRequest->setDateOfProcessing(new DateTime());
            $alRequest->setReason("idk");  

            $manager->persist($role);
            $manager->persist($team);
            $manager->persist($worker);
            $manager->persist($al);
            $manager->persist($alRequest);
        }

        $manager->flush();
    }
}
