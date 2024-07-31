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

    public function getUsersByRole(int $roleId) : array {
        return $this->userRepository->findAllByRole($roleId);
    }

    public function registrateUser(User $user){
        
    }

    public function loginUser(){

    }

}