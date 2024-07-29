<?php

namespace App\Service;

use App\Entity\Team;
use App\Repository\TeamRepository;

class TeamService {
    
    private $teamRepository;

    public function __construct(TeamRepository $teamRepository) {
        $this->teamRepository = $teamRepository;
    }

    public function getAll() : array {
        return $this->teamRepository->findAll();
    }

    public function getById(mixed $id) : ?Team {
        return $this->teamRepository->find($id);
    }

}