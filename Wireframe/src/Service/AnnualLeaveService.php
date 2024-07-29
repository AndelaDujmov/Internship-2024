<?php

namespace App\Service;

use App\Entity\AnnualLeave;
use App\Entity\RequestForAL;
use App\Repository\AnnualLeaveRepository;
use App\Repository\RequestForALRepository;

class AnnualLeaveService {

    private $annualLeaveRepository;
    private $requestForALRepository;

    public function __construct(AnnualLeaveRepository $alRepo, RequestForALRepository $alReqRepo) {
        $this->annualLeaveRepository = $alRepo;
        $this->requestForALRepository = $alReqRepo;
    }

    public function getAll() : array {
        return $this->annualLeaveRepository->findAll();
    }

    public function findById(mixed $id) : ?RequestForAL {
        return $this->requestForALRepository->find($id);
    }
    
}