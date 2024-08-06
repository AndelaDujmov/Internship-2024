<?php

namespace App\Controller;

use App\Service\UserManagementService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    private $userService;

    public function __construct(UserManagementService $userManagementService) {
        $this->userService = $userManagementService;
    }

    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        $users = $this->userService->getUsers();
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users' => $users
        ]);
    }

    #[Route('/user/delete', name: 'app_user_delete')]
    public function delete(Request $request) : Response {
        $userId = (int) $request->get('id');
        
        $this->userService->deleteUser($userId);

        return $this->redirectToRoute('/user');
    }
}
