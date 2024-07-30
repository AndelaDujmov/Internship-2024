<?php

namespace App\Service;

use App\Entity\AnnualLeave;
use App\Entity\RequestForAL;
use App\Repository\AnnualLeaveRepository;
use App\Repository\RequestForALRepository;
use App\Repository\UserRepository;

class AnnualLeaveService {

    private $annualLeaveRepository;
    private $userRepository;
    private $requestForALRepository;

    public function __construct(AnnualLeaveRepository $alRepo, RequestForALRepository $alReqRepo, UserRepository $userRepository) {
        $this->annualLeaveRepository = $alRepo;
        $this->requestForALRepository = $alReqRepo;
        $this->userRepository = $userRepository;
    }

    public function getAll() : array {
        return $this->annualLeaveRepository->findAll();
    }

    public function findById(mixed $id) : ?RequestForAL {
        return $this->requestForALRepository->find($id);
    }

    /*
    public function createRequest(string $start, string $end, string $workerId, string $reason) : void {
        $user = $this->
    }
    */
}