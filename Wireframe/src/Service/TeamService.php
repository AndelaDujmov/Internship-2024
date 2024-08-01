<?php

namespace App\Service;

use App\Entity\Team;
use App\Entity\TeamLeaders;
use App\Entity\User;
use App\Repository\TeamLeadersRepository;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;

class TeamService {
    
    protected static $teamRepository;
    private $userRepository;
    protected static $teamLeadersRepository;

    public function __construct(TeamRepository $teamRepository, UserRepository $userRepository, TeamLeadersRepository $teamLeadersRepository) {
        self::$teamRepository = $teamRepository;
        $this->userRepository = $userRepository;
        self::$teamLeadersRepository = $teamLeadersRepository;
    }

    public static function getAll() : array {
        $teams = self::$teamRepository->findAll();

        return $teams ?: throw new \Exception("Teams not found");
    }

    public static function showAllTeammates(string $idTeam) : array {
        $team = self::$teamRepository->find($idTeam);
        $teammates = self::$teamRepository->showAllWorkers($team);

        return $teammates ?: throw new \Exception("Teammates not found");
    }

    public function showLeaders(string $idTeam) : array {
        $team = self::$teamRepository->find($idTeam);

        if (!$team)
            throw new \Exception("Team not found");

        return self::$teamLeadersRepository->showLeaders($team) ?: throw new \Exception("No leaders found");
    }

    public function getById(mixed $id) : ?Team {
        $team = self::$teamRepository->find($id);

        return $team ?: throw new \Exception("Team not found");
    }

    public function create(string $name, int $memberNumber) : void {
        if (!$name || !$memberNumber)
            throw new \Exception("Team member number or team name should not be empty");

        $team = new Team();
        $team->setName(trim($name));
        $team->setNumberOfMembers($memberNumber);

        $this->userRepository->create($team);
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

    public function showWorkerData (string $userId) : User {
        return $this->userRepository->find($userId) ?: throw new \Exception("User not found!");
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