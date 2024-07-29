<?php

namespace App\Tests\Unit;

use App\Entity\Team;
use App\Repository\TeamRepository;
use App\Service\TeamService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Monolog\Test\TestCase;

class TeamServiceUnitTest extends TestCase {

    protected $teamService;
    protected $teamRepository;
 
    protected function setUp(): void {
        $this->teamRepository = $this->createMock(TeamRepository::class);
        $this->teamService = new TeamService($this->teamRepository);
    }

    public function testGetAllTeams() : void {
        $expected = [
            ['id' => '84b62734-5e78-48b4-98af-0d47aaff224e', 'name' => 'Team 1'],
            ['id' => '20d2f5f7-0549-481c-a2e2-a0183929a56c', 'name' => 'Team 2']
        ];

        $this->teamRepository->method('findAll')
            ->willReturn($expected);

        $teams = $this->teamService->getAll();

        $this->assertEquals($expected, $teams);
    }

    public function testGetTeamById() : void {
        $team = $this->createMock(Team::class);

        $this->teamRepository->method('find')
            ->with("1")
            ->willReturn($team);

        $teamServ = $this->teamService->getById("1");

        $this->assertEquals($team, $teamServ);
    }

}