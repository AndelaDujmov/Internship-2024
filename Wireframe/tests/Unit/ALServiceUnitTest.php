<?php

namespace App\Tests\Unit;

use App\Entity\RequestForAL;
use App\Repository\AnnualLeaveRepository;
use App\Repository\RequestForALRepository;
use App\Service\AnnualLeaveService;
use Monolog\Test\TestCase;

class ALServiceUnitTest extends TestCase {

    protected $alService;
    protected $alRepository;
    protected $requestAlRepository;
 
    protected function setUp(): void {
        $this->alRepository = $this->createMock(AnnualLeaveRepository::class);
        $this->requestAlRepository = $this->createMock(RequestForALRepository::class);
        $this->alService = new AnnualLeaveService($this->alRepository, $this->requestAlRepository);
    }

    public function testGetAllAnnualLeaves() : void {
        $expected = [
            ['id' => '84b62734-5e78-48b4-98af-0d47aaff224e', 'year' => 2024, 'total_days' => 21, 'month' => 'July', 'worker_id' => '910b6ff2-e1df-461d-a2fd-65ff9b4ef497'],
            ['id' => '20d2f5f7-0549-481c-a2e2-a0183929a56c', 'year' => 2024, 'total_days' => 11, 'month' => 'July', 'worker_id' => '3dff8729-c89f-484c-90df-f95b6c56b786']
        ];

        $this->alRepository->method('findAll')
            ->willReturn($expected);

        $leaves = $this->alService->getAll();

        $this->assertEquals($expected, $leaves);
    }

    public function testGetRequestById() : void {
        $AL = $this->createMock(RequestForAL::class);

        $this->requestAlRepository->method('find')
            ->with("1")
            ->willReturn($AL);

        $teamServ = $this->alService->findById("1");

        $this->assertEquals($AL, $teamServ);
    }

}