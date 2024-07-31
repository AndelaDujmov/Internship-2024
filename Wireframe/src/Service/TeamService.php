<?php

namespace App\Service;

use App\Entity\Team;
use App\Entity\TeamLeaders;
use App\Entity\User;
use App\Repository\TeamLeadersRepository;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;

class TeamService {
    
    private static $teamRepository;
    private $userRepository;
    private $teamLeadersRepository;

    public function __construct(TeamRepository $teamRepository, UserRepository $userRepository, TeamLeadersRepository $teamLeadersRepository) {
        self::$teamRepository = $teamRepository;
        $this->userRepository = $userRepository;
        $this->teamLeadersRepository = $teamLeadersRepository;
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

        return $this->teamLeadersRepository->showLeaders($team) ?: throw new \Exception("No leaders found");
    }

    public function getById(mixed $id) : ?Team {
        $team = $this->teamRepository->find($id);

        return $team ?: throw new \Exception("Team not found");
    }

    public function addWorkerToTeam(string $idUser, string $idTeam) : void {
        $team = $this->getById($idTeam);

        if (!$team)
            throw new \Exception("Team not found");

        $worker = $this->userRepository->find($idUser);

        if (!$worker)
            throw new \Exception("Worker not found");

        if ($worker->hasRole(\App\Enum\Role::WORKER->value))
            $this->teamRepository->addWorkerToTeam($worker, $team);
    }

    public function removeWorkerFromTeam(string $teamId) : void {
        $team = $this->getById($teamId);

        if (!$team) 
            throw new \Exception("Team not found");

        $this->teamRepository->removeWorkerFromTeam($team);
    }

}