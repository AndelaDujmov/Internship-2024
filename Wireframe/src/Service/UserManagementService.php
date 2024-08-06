<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;

class UserManagementService {

    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function getUsers() : array {
        return $this->userRepository->findAll();
    }

    public function getUserById(int $id) : ?User {
        return $this->userRepository->find($id);
    }

    public function deleteUser(int $id) : void {
        $user = $this->getUserById($id);
        $this->userRepository->delete($user);
    }

    public function getUsersByRole(int $roleId) : array {
        return $this->userRepository->findAllByRole($roleId);
    }

    public function getRoles() : array {
        return [\App\Enum\Role::WORKER->value, \App\Enum\Role::TEAMLEADER->value, \App\Enum\Role::PROJECTLEADER->value];
    }

}