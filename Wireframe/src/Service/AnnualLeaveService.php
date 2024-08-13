<?php

namespace App\Service;

use App\Entity\AnnualLeave;
use App\Entity\Notification;
use App\Entity\RequestForAL;
use App\Entity\User;
use App\Message\MailNotification;
use App\Repository\AnnualLeaveRepository;
use App\Repository\NotificationRepository;
use App\Repository\RequestForALRepository;
use App\Repository\TeamLeadersRepository;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Notifier\Message\EmailMessage;
use Symfony\Component\Security\Core\User\UserInterface;

class AnnualLeaveService {
    private $userRepository;
    private $teamRepository;
    private $teamService;
    private $requestForALRepository;
    private $teamLeadersRepository;
    private $mailerService;
    private $notificationRepository;
    private $bus;

    public function __construct(RequestForALRepository $alReqRepo, UserRepository $userRepository, TeamRepository $teamRepository, TeamLeadersRepository $teamLeadersRepository, NotificationRepository $notificationRepository, MailerInterface $mailerInterface, MessageBusInterface $messageBusInterface, TeamService $teamService) {
        $this->requestForALRepository = $alReqRepo;
        $this->userRepository = $userRepository;
        $this->teamRepository = $teamRepository;
        $this->teamLeadersRepository = $teamLeadersRepository;
        $this->notificationRepository = $notificationRepository;
        $this->mailerService = $mailerInterface;
        $this->bus = $messageBusInterface;
        $this->teamService = $teamService;
    }

    public function getAll(UserInterface $currentUser) : array {
        $roles = $currentUser->getRoles();
        $user = $this->userRepository->getUserByIdentifier($currentUser->getUserIdentifier());
        $annualLeaves = [];

        if (in_array(\App\Enum\Role::ADMIN->value, $roles)) 
            $annualLeaves = $this->requestForALRepository->findAll();
        else if (in_array(\App\Enum\Role::TEAMLEADER->value, $roles) || in_array(\App\Enum\Role::PROJECTLEADER->value, $roles)){
            $teams = $this->returnLeavesByLeader($user);
            
            return $teams;
        }
        else{
            $annualLeaves = $this->requestForALRepository->findByUser($user->getId());
        }
           
        return $annualLeaves;
    }

    public function getAnnualRequest(string $id) : RequestForAL {
        return $this->requestForALRepository->findById($id) ?: throw new \Exception("Unable to find request");
    }

    public function createRequestForAL(string $userId, RequestForAL $requestForAL, ?int $total) : bool {
        $user = $this->userRepository->getUserByIdentifier($userId) ?: new \Exception("User not found");

        if($user->getVacationDays() < $total){
            return false;
        }

        $vacationsNow = $user->getVacationDays() - $total;
        $this->userRepository->update($vacationsNow, $user->getEmail());
        $requestForAL->setWorker($user);
        $requestForAL->setStatus(\App\Enum\Status::PENDING->value);
        $this->requestForALRepository->create($requestForAL);

        return true;
    }

    public function declineRequest($id) {
        $request = $this->requestForALRepository->findById($id);
        
        $this->updateUser($request);

        if($request->getStatus() == \App\Enum\Status::PENDING->value) 
            $this->requestForALRepository->delete($request);
    }

    public function returnUsersVacationDays(string $userIdentificator) : ?int {
        $user = $this->userRepository->getUserByIdentifier($userIdentificator);

        return $user->getVacationDays();
    }

    public function calculateVacationDays(\DateTimeInterface $start, \DateTimeInterface $end) : int {
        $startDate = Carbon::instance($start);
        $endDate = Carbon::instance($end);

        if ($start > $end) {
            return 0;
        }

        if ($startDate > $endDate)
            return 0;

        $period = CarbonPeriod::create($startDate, $endDate);
        
        return $period->filter(fn(Carbon $date) => $date->isWeekday())->count();
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
            $this->sendMail('sopifof940@biscoine.com', "ACCEPTED",  $notification->getMessage());

        }
           
        if  ($alRequest->getTeamLeader() == null && $alRequest->getProjectLeader() == null) {
            $alRequest->setStatus(\App\Enum\Status::CANCELLED->value);

            $notification = new Notification();
            $notification->setCreatedAt(new \DateTime());
            $notification->setMessage('Your request for vacation for period '. $alRequest->getEnd()->format('d-m-y') . ' - ' . $alRequest->getStart()->format('d-m-y') . ' has been rejected!');
            $notification->setUser($alRequest->getWorker());
            $notification->setClosed(false);
            $this->notificationRepository->add($notification);
            $this->updateUser($alRequest);
            $this->sendMail('sopifof940@biscoine.com', "DECLINED",  $notification->getMessage());
        }

        $alRequest->setDateOfProcessing(new \DateTime());

        $this->requestForALRepository->update($alRequest);
    }

    private function sendMail(string $email, string $subject, string $message): void {
        $message = new MailNotification($email, $subject, $message);
        $this->bus->dispatch($message);
    }

    private function updateUser(RequestForAL $request): void {
        $user = $this->userRepository->getUserById($request->getWorker()->getId());
        $user->setVacationDays($user->getVacationDays() + $this->calculateVacationDays($request->getStart(), $request->getEnd()));

        $this->userRepository->update($user->getVacationDays(), $user->getEmail());
    }

    private function returnLeavesByLeader(User $user) : array {
        if (in_array(\App\Enum\Role::TEAMLEADER->value, $user->getRoles())){
            $teams = $this->teamLeadersRepository->findAll();
            $annualLeaves = [];

            foreach ($teams as $teamLeader) {
                if ($teamLeader->getTeamLead()->getId() === $user->getId()) {
                    $teamName = $teamLeader->getTeam()->getName();
                    $teamMembers = $teamLeader->getTeam()->getMembers()->toArray();
                   
                    
                    foreach ($teamMembers as $member){
                        $annualLeaves[] = $this->teamService->getUsersVacation($member->getId());
                    }

                    $teamLeaders[$teamName] = $teamMembers;
                }
            }
            return $annualLeaves;   
        }

        $teams = $this->teamLeadersRepository->findAll();
        $annualLeaves = [];

        foreach ($teams as $teamLeader) {
            if ($teamLeader->getProjectLeader()->getId() === $user->getId()) {
                $teamName = $teamLeader->getTeam()->getName();
                $teamMembers = $teamLeader->getTeam()->getMembers()->toArray();
               
                
                foreach ($teamMembers as $member){
                    $annualLeaves[] = $this->teamService->getUsersVacation($member->getId());
                }

                $teamLeaders[$teamName] = $teamMembers;
            }
        }
        return $annualLeaves; 
    }

}