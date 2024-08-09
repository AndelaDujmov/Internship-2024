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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AnnualLeaveService {
    private $userRepository;
    private $teamRepository;
    private $requestForALRepository;
    private $teamLeadersRepository;
    private $mailerService;
    private $notificationRepository;

    public function __construct(RequestForALRepository $alReqRepo, UserRepository $userRepository, TeamRepository $teamRepository, TeamLeadersRepository $teamLeadersRepository, NotificationRepository $notificationRepository, MailerInterface $mailerInterface) {
        $this->requestForALRepository = $alReqRepo;
        $this->userRepository = $userRepository;
        $this->teamRepository = $teamRepository;
        $this->teamLeadersRepository = $teamLeadersRepository;
        $this->notificationRepository = $notificationRepository;
        $this->mailerService = $mailerInterface;
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

    public function declineRequest($id) {
        $request = $this->requestForALRepository->findById($id);
        $daysDiff = (int)$request->getEnd()->diff($request->getStart(), true)->days;

        $user = $this->userRepository->getUserById($request->getWorker()->getId());
        $user->setVacationDays($user->getVacationDays() + $daysDiff);

        $this->userRepository->update($user->getVacationDays(), $user->getEmail());

        if($request->getStatus() == \App\Enum\Status::PENDING->value) 
            $this->requestForALRepository->delete($request);
    }

    public function returnUsersVacationDays(string $userIdentificator) : ?int {
        $user = $this->userRepository->getUserByIdentifier($userIdentificator);

        return $user->getVacationDays();
    }

    public function validateRequestForAL(string $requestId, ?string $id=null ) : void {
    
        $alRequest = $this->requestForALRepository->findById($requestId);
        $member1 = $id ? $this->userRepository->getUserByIdentifier($id) : null;
       
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
            $notification->setMessage('Your request for vacation for period '. $alRequest->getEnd()->format('d-m-y') . ' - ' . $alRequest->getStart()->format('d-m-y') . ' has been approved!');
            $notification->setUser($alRequest->getWorker());
            $notification->setClosed(false);
            $this->notificationRepository->add($notification);
            $this->sendMail($notification->getMessage(), $alRequest->getWorker()->getEmail());

        }
           
        if  ($alRequest->getTeamLeader() == null && $alRequest->getProjectLeader() == null) {
            $alRequest->setStatus(\App\Enum\Status::CANCELLED->value);

            $notification = new Notification();
            $notification->setCreatedAt(new \DateTime());
            $notification->setMessage('Your request for vacation for period '. $alRequest->getEnd()->format('d-m-y') . ' - ' . $alRequest->getStart()->format('d-m-y') . ' has been rejected!');
            $notification->setUser($alRequest->getWorker());
            $notification->setClosed(false);
            $this->notificationRepository->add($notification);
            $this->sendMail($notification->getMessage(), $alRequest->getWorker()->getEmail());
        }

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

    private function sendMail(string $email, string $message) : void {
        $this->sendMail($email, $message);
    }

}