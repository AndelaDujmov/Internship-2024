<?php

namespace App\Service;

use App\Entity\RequestForAL;
use App\Entity\Team;
use App\Entity\TeamLeaders;
use App\Entity\User;
use App\Repository\RequestForALRepository;
use App\Repository\TeamLeadersRepository;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;

class TeamService {
    
    protected static $teamRepository;
    private $userRepository;
    protected static $teamLeadersRepository;
    private $annualLeaveRepository;

    public function __construct(TeamRepository $teamRepository, UserRepository $userRepository, TeamLeadersRepository $teamLeadersRepository, RequestForALRepository $annualLeaveRepository) {
        self::$teamRepository = $teamRepository;
        $this->userRepository = $userRepository;
        self::$teamLeadersRepository = $teamLeadersRepository;
        $this->annualLeaveRepository = $annualLeaveRepository;
    }

    public function create(Team $team) : void {
        self::$teamRepository->create($team);
    }

    public static function getAll() : array {
        $teams = self::$teamRepository->findAll();

        return $teams ?: throw new \Exception("Teams not found");
    }

    public static function showAllTeammates(string $idTeam) : array {
        $team = self::$teamRepository->find($idTeam);
        $teammates = self::$teamRepository->showAllWorkers($team);

        return $teammates;
    }

    public function getUsersVacation(string $userId) : array|null {
        return $this->annualLeaveRepository->findByUser($userId);
    }


    public function showLeaders(string $idTeam) : array {
        $team = self::$teamRepository->find($idTeam);

        if (!$team)
            throw new \Exception("Team not found");

        return self::$teamLeadersRepository->showLeaders($team);
    }

    public function getById(mixed $id) : ?Team {
        $team = self::$teamRepository->find($id);

        return $team;
    }

    public function addWorkerToTeam(string $idUser, string $idTeam) : void {
        $team = $this->getById($idTeam);

        if (!$team)
            throw new \Exception("Team not found");

        $worker = $this->userRepository->find($idUser);

        if (!$worker)
            throw new \Exception("Worker not found");

        if ($worker->hasRole(\App\Enum\Role::WORKER->value))
            self::$teamRepository->addWorkerToTeam($worker, $team);
    }

    public function addLeadersToTeam(TeamLeaders $teamLeaders) : void {
        self::$teamLeadersRepository->addLeaders($teamLeaders);
    }

    public function showWorkerData (string $userId) : User {
        return $this->userRepository->find($userId) ?: throw new \Exception("User not found!");
    }

    public function showWorkers(string $teamId) : ?array {
        $workers = $this->userRepository->getUsersByRole(\App\Enum\Role::WORKER->value);

        if (is_array($workers)){
            return array_filter($workers, function(User $worker) use ($teamId) {
                return $worker->getTeam() == NULL || $worker->getTeam()->getId() !== $teamId;
            });
        }

        return null;
    }

    public function removeWorkerFromTeam(string $teamId, string $idWorker) : void {
        $team = $this->getById($teamId);
        $worker = $this->userRepository->find($idWorker);   

        if (!$team || !$worker) 
            throw new \Exception("Team not found");

        self::$teamRepository->removeWorkerFromTeam($worker, $team);
    }

    public static function deleteTeam(string $teamId) : void {
        $team = self::$teamRepository->find($teamId);

        if (!$team) 
            throw new \Exception("Team not found");

        self::$teamLeadersRepository->deleteLeaders($team);
        self::$teamRepository->delete($team);
    }

}