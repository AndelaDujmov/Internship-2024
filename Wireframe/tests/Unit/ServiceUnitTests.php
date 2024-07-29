<?php

namespace App\Tests\Unit;

use App\Repository\TeamRepository;
use App\Service\TeamService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Monolog\Test\TestCase;

class ServiceUnitTests extends TestCase {
    protected $teamService;
    protected $teamRepository;

    public function testGetAllTeams(){
        $managerRegistry = $this->createMock(ManagerRegistry::class);
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $service = new TeamService(new TeamRepository());
    }
}