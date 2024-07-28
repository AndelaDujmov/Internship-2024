<?php

namespace App\DataFixtures;

use App\Entity\AnnualLeave;
use App\Entity\RequestForAL;
use App\Entity\Team;
use App\Entity\Worker;
use App\Enum\Status;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeamFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        for ($i = 1; $i < 3; $i++) {
            $team = new Team();
            $team->setMemberNumber(mt_rand(1, 6));
            $team->setName("Team " . (string)($i));

            $worker = new Worker();
            $worker->setName("Worker Name" . (string)($i));
            $worker->setSurname("Worker Surname" . (string)($i));
            $worker->setTeam($team);

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
            $alRequest->setTeamLeadApprove(null);
            $alRequest->setProjectLeadApproveal(null);
            $alRequest->setWorker($worker);
            $alRequest->setDateOfProcessing(new DateTime());
            $alRequest->setReason("idk");

            $manager->persist($team);
            $manager->persist($worker);
            $manager->persist($al);
            $manager->persist($alRequest);
        }

        $manager->flush();
    }
}
