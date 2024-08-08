<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
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
    public function deleteUser(Request $request) : Response {
        $userId =  $request->get('id');
        
        $this->userService->deleteUser($userId);

        return $this->redirectToRoute('app_user');
    }

    #[Route('/user/{id}/edit', name: 'app_user_edit')]
    public function editUser(Request $request) : Response {
        $userId = $request->get('id');

        $user = $this->userService->getUserById($userId);

        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->updateUser($user, $form->get('plainPassword')->getData(), $form->get('role')->getData());

            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/edit.html.twig', [
            'editForm' => $form,
        ]);
    }

}
