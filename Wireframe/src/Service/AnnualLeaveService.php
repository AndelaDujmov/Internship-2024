<?php

namespace App\Service;

use App\Entity\AnnualLeave;
use App\Entity\Notification;
use App\Entity\RequestForAL;
use App\Repository\AnnualLeaveRepository;
use App\Repository\NotificationRepository;
use App\Repository\RequestForALRepository;
use App\Repository\TeamLeadersRepository;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class AnnualLeaveService {
    private $userRepository;
    private $teamRepository;
    private $requestForALRepository;
    private $teamLeadersRepository;
    private $notificationRepository;

    public function __construct(RequestForALRepository $alReqRepo, UserRepository $userRepository, TeamRepository $teamRepository, TeamLeadersRepository $teamLeadersRepository, NotificationRepository $notificationRepository) {
        $this->requestForALRepository = $alReqRepo;
        $this->userRepository = $userRepository;
        $this->teamRepository = $teamRepository;
        $this->teamLeadersRepository = $teamLeadersRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function getAll(UserInterface $currentUser) : array {
        $roles = $currentUser->getRoles();
        $user = $this->userRepository->getUserByIdentifier($currentUser->getUserIdentifier());
        $annualLeaves = [];

        if (in_array(\App\Enum\Role::PROJECTLEADER->value, $roles) || in_array(\App\Enum\Role::ADMIN->value, $roles)) 
            $annualLeaves = $this->requestForALRepository->findAll();
        /*else if (in_array(\App\Enum\Role::TEAMLEADER->value, $roles)){
            $teams = $this->teamLeadersRepository->getTeamsByTeamLeader($user->getId());
            $memberIds = [];
           
            foreach ($teams as $team){
                $teamVar = $this->teamRepository->find($team);
                #var_dump($team);
                $members = $teamVar->getMembers();

                foreach ($members as $member){
                    $memberIds[] = $member->getId();
                }
            }
            return $teams;
        }*/
        else{
            $annualLeaves = $this->requestForALRepository->findByUser($user->getId());
        }
           
        return $annualLeaves;
    }

    public function getAnnualRequest(string $id) : RequestForAL {
        return $this->requestForALRepository->findById($id) ?: throw new \Exception("Unable to find request");
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

    public function validateRequestForAL(string $requestId, ?string $id=null ) : void {
    
        $alRequest = $this->requestForALRepository->findById($requestId);
        $member1 = $this->userRepository->getUserByIdentifier($id);
       
        if ($member1 && !$alRequest->getTeamLeader() && in_array(\App\Enum\Role::TEAMLEADER->value, $member1->getRoles())){
            $alRequest->setTeamLeader($member1);
        }

        else if ($member1 && !$alRequest->getTeamLeader() && in_array(\App\Enum\Role::PROJECTLEADER->value, $member1->getRoles())){
            $alRequest->setProjectLeader($member1);
        }

        if ($alRequest->getTeamLeader() != null && $alRequest->getProjectLeader() != null){
            $alRequest->setStatus(\App\Enum\Status::COMPLETED->value);

            $notification = new Notification();
            $notification->setCreatedAt(new \DateTime());
            $notification->setMessage('Your request for vacation has been approved!');
            $notification->setUser($alRequest->getWorker());
            $this->notificationRepository->add($notification);
        }
           
        if  ($alRequest->getTeamLeader() == null && $alRequest->getProjectLeader() == null) 
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