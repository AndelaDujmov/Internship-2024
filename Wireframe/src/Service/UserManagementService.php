<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;

class UserManagementService {

    private $userRepository;
    private $roleRepository;

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository) {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function getUsers() : array {
        return $this->userRepository->findAll();
    }

    public function getUserById(int $id) : ?User {
        return $this->userRepository->find($id);
    }

    public function getUsersByRole(int $roleId) : array {
        return $this->userRepository->findAllByRole($roleId);
    }

}