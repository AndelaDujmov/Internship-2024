<?php

namespace App\Service;

use App\Entity\AnnualLeave;
use App\Entity\RequestForAL;
use App\Repository\AnnualLeaveRepository;
use App\Repository\RequestForALRepository;
use App\Repository\UserRepository;

class AnnualLeaveService {
    private $userRepository;
    private $requestForALRepository;

    public function __construct(RequestForALRepository $alReqRepo, UserRepository $userRepository) {
        $this->requestForALRepository = $alReqRepo;
        $this->userRepository = $userRepository;
    }

    public function getAll(){
        return $this->requestForALRepository->findAll();
    }

    public function createRequestForAL(string $userId, string $start, string $end, ?string $reason=null) : bool {
        $user = $this->userRepository->getUserByIdentifier($userId) ?: new \Exception("User not found");
        $requestForAL = new RequestForAL();

        $startDate = $this->parseToDatetime($start);
        $endDate = $this->parseToDatetime($end);
        $diff = $startDate->diff($endDate);

        if($user->getVacationDays() < (int)$diff->format("%r%a")){
            return false;
        }

        $vacationsNow = $user->getVacationDays() - (int)$diff->format("%r%a");
        $this->userRepository->update($vacationsNow, $user->getEmail());
        $requestForAL->setStart($startDate);
        $requestForAL->setEnd($endDate);
        $requestForAL->setReason($reason);
        $requestForAL->setWorker($user);
        $requestForAL->setStatus(\App\Enum\Status::PENDING->value);
        $this->requestForALRepository->create($requestForAL);

        return true;
    }

    public function returnUsersVacationDays(string $userIdentificator) : ?int {
        $user = $this->userRepository->getUserByIdentifier($userIdentificator);

        return $user->getVacationDays();
    }

    public function validateRequestForAL(string $requestId, ?string $teamLeadId=null, ?string $projectLeadId=null) : void {
    
        $alRequest = $this->requestForALRepository->findById($requestId);
        $teamlead = $teamLeadId != null ? $this->userRepository->find($teamLeadId) : null;
        $projectlead = $projectLeadId != null ? $this->userRepository->find($projectLeadId) : null;

        if ($teamlead && !$alRequest->getTeamLeader()){
            $alRequest->setTeamLeader($teamlead);
        }

        if ($projectLeadId && !$alRequest->getProjectLeader()){
            $alRequest->setProjectLeader($projectlead);
        }

        if ($alRequest->getTeamLeader() != null && $alRequest->getProjectLeader() != null){
            $alRequest->setStatus(\App\Enum\Status::COMPLETED->value);
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