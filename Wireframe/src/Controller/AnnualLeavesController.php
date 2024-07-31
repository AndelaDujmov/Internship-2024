<?php

namespace App\Controller;

use App\Service\AnnualLeaveService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnnualLeavesController extends AbstractController
{
    private $annualLeaveService;

    public function __construct(AnnualLeaveService $annualLeaveService) {
        $this->annualLeaveService = $annualLeaveService;
    }

    #[Route('/annual/leaves', name: 'app_annual_leaves')]
    public function index(): Response
    {
        return $this->render('annual_leaves/index.html.twig', [
            'controller_name' => 'AnnualLeavesController',
        ]);
    }

    #[Route('/annual/leaves/:userId', name: 'app_annual_leaves_get')]
    public function getAnnualLeavesByUser(string $userId) : Response {
        $annualLeaves = $this->annualLeaveService->();
        return $this->render('annual_leaves/perUser.html.twig', [
            'controller_name' => 'AnnualLeavesController',
        ]);
    }

    #[Route('/annual/leaves/request/create', name: 'app_annual_leaves_create')]
    public function createRequest() : Response {
        return $this->render('annual_leaves/create.html.twig', [
            'controller_name' => 'AnnualLeavesController',
        ]);
    }

    #[Route('/annual/leaves/request/:id', name: 'app_annual_leaves_process')]
    public function processRequest(string $id) : Response {
        $this->annualLeaveService->validateRequestForAL( $id );
        return $this->render('annual_leaves/request.html.twig', [
            'controller_name' => 'AnnualLeavesController',
        ]);
    }

}
