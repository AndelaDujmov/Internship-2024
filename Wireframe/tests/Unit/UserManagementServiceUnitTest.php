<?php

use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Service\UserManagementService;
use Monolog\Test\TestCase;

class UserManagementServiceUnitTest extends TestCase {
    protected $userService;
    protected $roleRepository;
    protected $userRepository;

    protected function setUp() : void {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->roleRepository = $this->createMock(RoleRepository::class);
        $this->userService = new UserManagementService($this->userRepository, $this->roleRepository);
    }

    public function testGetUsers() {
        $users = [['id' => '3dff8729-c89f-484c-90df-f95b6c56b786', 'name'=> 'Andela', 'surname' => 'Dujmov', 'role_id' => '3bc0f9fa-bdb8-404f-8321-d92b69d47fcd', 'team_id' => '3bc0f9fa-bdb8-404f-8321-d92b69d47fwd']];

        $this->userRepository->method('findAll')
            ->willReturn($users);
        
        $usersServ = $this->userService->getUsers();

        $this->assertEquals($users, $usersServ);
    }

}