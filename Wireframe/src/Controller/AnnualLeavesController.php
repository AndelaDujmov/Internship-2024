<?php

namespace App\Controller;

use App\Entity\RequestForAL;
use App\Form\AddVacationFormType;
use App\Security\TemplateVoters;
use Exception;
use App\Service\AnnualLeaveService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class AnnualLeavesController extends AbstractController
{
    private $annualLeaveService;
    private $authorizationChecker;

    public function __construct(AnnualLeaveService $annualLeaveService, AuthorizationCheckerInterface $authorizationChecker) {
        $this->annualLeaveService = $annualLeaveService;
        $this->authorizationChecker = $authorizationChecker;
    }

    #[Route('/annual/leaves', name: 'app_annual_leaves')]
    public function index(): Response
    {
        $user = $this->getUser();

        $annualRequests = $this->annualLeaveService->getAll($user);
        if ($this->authorizationChecker->isGranted(TemplateVoters::VIEW))
            return $this->render('annual_leaves/indexLeaders.html.twig', [
                'controller_name' => 'AnnualLeavesController',
                'requests' => $annualRequests,
            ]);
        
        return $this->render('annual_leaves/index.html.twig', [
            'controller_name' => 'AnnualLeavesController',
            'requests' => $annualRequests,
        ]);
    }

    #[Route('/annual/leaves/request/create', name: 'app_annual_leaves_create', methods: ['GET', 'POST'])]
    public function createRequest(Request $request) : Response {
        $annualLeave = new RequestForAL();
        $form = $this->createForm(AddVacationFormType::class, $annualLeave);
        $form->handleRequest($request);
        $userId = $this->getUser()->getUserIdentifier();
        $totalDays = null;
        $error = null;

        if ($form->isSubmitted() && $form->isValid()) {
            if ($annualLeave->getStart() && $annualLeave->getEnd()){
                $totalDays = $this->annualLeaveService->calculateVacationDays($annualLeave->getStart(), $annualLeave->getEnd());
                $value = $this->annualLeaveService->createRequestForAL($userId, $annualLeave, $totalDays);
            }
            if ($value){
                return $this->redirectToRoute('app_annual_leaves_create');
            }
        }
            
        return $this->render('annual_leaves/create.html.twig', [
            'form' => $form->createView(),
            'vacationDays' => $this->annualLeaveService->returnUsersVacationDays($userId),
            'totalDays' => $totalDays ?? null,
            'error' => $error,
        ]);
    }

    #[Route('/annual/leaves/request/{requestId}', name:'app_annual_leaves_check')]
    public function checkRequest(Request $request, string $requestId) : Response {
        try{
            $annualLeave = $this->annualLeaveService->getAnnualRequest($requestId);
            return $this->render('annual_leaves/request.html.twig', [
                'controller_name' => 'AnnualLeavesController',
                'leave' => $annualLeave
            ]);
        } catch (Exception $e) {
            return $this->render('error/error.html.twig', [
                'controller_name' => 'TeamController',
                'error' => $e->getMessage(),
            ]);
        }
    }

    #[Route('/annual/leaves/accept/{id}', name: 'app_annual_leaves_accept')]
    public function accept(string $id) : Response {
       
        $userID = $this->getUser()->getUserIdentifier();
        
        $this->annualLeaveService->validateRequestForAL( $id, $userID );
        
        return $this->redirectToRoute('app_annual_leaves_check', ['requestId' => $id]);
    }

    #[Route('/annual/leaves/decline/{id}', name: 'app_annual_leaves_decline')]
    public function decline(string $id) : Response {
        $this->annualLeaveService->validateRequestForAL( $id );
        
        return $this->redirectToRoute('app_annual_leaves_check', ['requestId' => $id]);
    }

    #[Route('/annual/leave/cancel/{id}', name:'app_cancel_annual_leave')]
    public function cancelAnnualLeave(string $id) : Response {
        $this->annualLeaveService->declineRequest( $id );
        return $this->redirectToRoute('app_annual_leaves');
    }

}
