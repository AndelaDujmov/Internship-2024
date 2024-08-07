<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\NotificationRepository;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;

class UserManagementService {

    private $userRepository;
    private $notificationRepository;

    public function __construct(UserRepository $userRepository, NotificationRepository $notificationRepository) {
        $this->userRepository = $userRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function getUsers() : array {
        return $this->userRepository->findAll();
    }

    public function getUserById(string $id) : ?User {
        return $this->userRepository->find($id);
    }

    public function deleteUser(string $id) : void {
        $user = $this->getUserById($id);
        $this->userRepository->delete($user);
    }

    public function getUsersByRole(int $roleId) : array {
        return $this->userRepository->findAllByRole($roleId);
    }

    public function updateUser(User $user, ?string $password, ?string $role) : void {
        $user->setPassword($password ?? $user->getPassword());
        $user->getRoles()[] = $role ?? null;
        $this->userRepository->updateUser();
    }

    public function getNotifications(string $userIdentificator) : array {
        $user = $this->userRepository->getUserByIdentifier($userIdentificator);
        return $this->notificationRepository->getAllByUser($user);    
    }

    public function getRoles() : array {
        return [\App\Enum\Role::WORKER->value, \App\Enum\Role::TEAMLEADER->value, \App\Enum\Role::PROJECTLEADER->value];
    }

}