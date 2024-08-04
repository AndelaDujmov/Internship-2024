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
        //ako je korisnik admin, vidjet ćemo sve a ako nije vidjet ćemo samo za usere u timu
        $annualRequests = $this->annualLeaveService->getAll();
        return $this->render('annual_leaves/index.html.twig', [
            'controller_name' => 'AnnualLeavesController',
            'requests' => $annualRequests,
        ]);
    }

    #[Route('/annual/leaves/request/create', name: 'app_annual_leaves_create', methods: ['GET', 'POST'])]
    public function createRequest(Request $request) : Response {
        #$userId = $request->get('id');
        $userId = 'de668405-f6a8-4940-884b-a5361c24ddfa'; //id trenutno logiranog usera
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
            ]);
        }catch (Exception $e) {
            return $this->render('error/error.html.twig', [
                'controller_name' => 'TeamController',
                'error' => $e->getMessage(),
            ]);
        }
    }

    #[Route('/annual/leaves/request/:id', name: 'app_annual_leaves_process')]
    public function processRequest(string $id) : Response {
        $this->annualLeaveService->validateRequestForAL( $id );
        return $this->render('annual_leaves/request.html.twig', [
            'controller_name' => 'AnnualLeavesController',
        ]);
    }

}
