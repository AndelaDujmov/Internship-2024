<?php

namespace App\Controller;

use App\Service\UserManagementService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{

    private $userService;

    public function __construct(UserManagementService $userManagementService) {
        $this->userService = $userManagementService;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        if ($this->isGranted('ROLE_WORKER')) {
            return $this->render('home/homeWorker.html.twig', [
                'controller_name' => 'HomeController',
                'notifications' => $this->userService->getNotifications($this->getUser()->getUserIdentifier()),
            ]);
        } 
        else if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
                'user' => $this->getUser()->getUserIdentifier()
            ]);
        } else {
            return $this->render('baseNull.html.twig', [
                'controller_name' => 'HomeController',
            ]);
        }
       
    }
}
