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
        $this->teamRepository = $teamRepository;
        $this->userRepository = $userRepository;
        $this->teamLeadersRepository = $teamLeadersRepository;
    }

    public static function getAll() : array {
        $teams = self::$teamRepository->findAll();

        return !$teams ? new \Exception("No teams found") : $teams;
    }

    public static function showAllTeammates(string $idTeam) : array {
        $team = self::$teamRepository->find($idTeam);
        $teammates = self::$teamRepository->showAllWorkers($team);

        return !$teammates ? new \Exception("Team has no teammates") : $teammates;
    }

    public static function showLeaders(string $idTeam) : array {
        $team = self::$teamRepository->find($idTeam);
        $team
    }

    public function getById(mixed $id) : ?Team {
        $team = $this->teamRepository->find($id);

        return !$team ? new \Exception("Team not found") : $team;
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