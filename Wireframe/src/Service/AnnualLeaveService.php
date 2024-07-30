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

    public function createRequestForAL(string $userId, string $start, string $end, ?string $reason=null) : bool {
        $user = $this->userRepository->find($userId);
        $currentMonth = (new \DateTime())->format('F');
        $al = $this->annualLeaveRepository->getALBy($user, $currentMonth);
        $requestForAL = new RequestForAL();

        //provjera u al je li ostalo dana vise od trazenog za godisnji odmor

        $requestForAL->setStart($this->parseToDatetime($start));
        $requestForAL->setEnd($this->parseToDatetime($end));
        $requestForAL->setReason($reason);
        $requestForAL->setWorker($user);
        $requestForAL->setStatus(\App\Enum\Status::PENDING->value);

        $this->requestForALRepository->create($requestForAL);

        return true;
    }

    public function validateRequestForAL(string $requestId, ?string $teamLeadId=null, ?string $projectLeadId=null) : void {
        $alRequest = $this->requestForALRepository->findById($requestId);
        $teamlead = $teamLeadId != null ? $this->userRepository->find($teamLeadId) : null;
        $projectlead = $projectLeadId != null ? $this->userRepository->find($projectLeadId) : null;

        if ($teamlead){
            $alRequest->setTeamLeader($teamlead);
        }

        if ($projectLeadId){
            $alRequest->setProjectLeader($projectlead);
        }

        if ($alRequest->getTeamLeader() != null && $alRequest->getProjectLeader() != null){
            $alRequest->setStatus(\App\Enum\Status::COMPLETED->value);
            $al = new AnnualLeave();
            $al->setWorker($alRequest->getWorker());
            $al->setTotalDays($alRequest->getEnd()->diff($alRequest->getStart())->days);
        }
           
        
        if  ($alRequest->getTeamLeader() != null && $alRequest->getProjectLeader() != null) 
            $alRequest->setStatus(\App\Enum\Status::CANCELLED->value);
        
        $alRequest->setDateOfProcessing(new \DateTime());

        $this->requestForALRepository->update($alRequest);
    }

    private function parseToDatetime(string $date) : \DateTimeInterface {
        try{

            $todatetime = new \DateTime($date);

            return $todatetime;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException("Invalid date format");
        }
    }

}