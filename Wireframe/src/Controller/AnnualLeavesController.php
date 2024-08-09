<?php

namespace App\Controller;

use Exception;
use App\Service\AnnualLeaveService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnnualLeavesController extends AbstractController
{
    private $annualLeaveService;

    public function __construct(AnnualLeaveService $annualLeaveService) {
        $this->annualLeaveService = $annualLeaveService;
    }

    #[Route('/annual/leaves', name: 'app_annual_leaves')]
    public function index(): Response
    {
        $user = $this->getUser();

        $annualRequests = $this->annualLeaveService->getAll($user);
        
        return $this->render('annual_leaves/index.html.twig', [
            'controller_name' => 'AnnualLeavesController',
            'requests' => $annualRequests,
        ]);
    }

    #[Route('/annual/leaves/request/create', name: 'app_annual_leaves_create', methods: ['GET', 'POST'])]
    public function createRequest(Request $request) : Response {
        $userId = $this->getUser()->getUserIdentifier();
        $start = $request->get('start');
        $end = $request->get('end');
        $reason = $request->get('reason');

        if ($start && $end && $reason){
            $value = $this->annualLeaveService->createRequestForAL($userId, $start, $end, $reason);

            if ($value){
                return $this->redirectToRoute('app_annual_leaves');
            }
        }

        try{
            return $this->render('annual_leaves/create.html.twig', [
                'controller_name' => 'AnnualLeavesController',
                'vacation_days' => $this->annualLeaveService->returnUsersVacationDays($userId),
            ]);
        }catch (Exception $e) {
            return $this->render('error/error.html.twig', [
                'controller_name' => 'TeamController',
                'error' => $e->getMessage(),
            ]);
        }
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
        $this->annualLeaveService->validateRequestForAL( $id );
        return $this->redirectToRoute('app_annual_leaves_check', ['requestId' => $id]);
    }

}
