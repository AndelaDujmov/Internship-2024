<?php

namespace App\Service;

use App\Repository\TeamRepository;

class TeamService {
    
    private $teamRepository;

    public function __construct(TeamRepository $teamRepository) {
        $this->teamRepository = $teamRepository;
    }

    public function getAll() {
        return $this->teamRepository->getAll();
    }

    public function getById($id) {
        return $this->teamRepository->getById($id);
    }

}