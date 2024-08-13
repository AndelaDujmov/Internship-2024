<?php

namespace App\Controller;

use App\Entity\AuthenticatedUser;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    private $passwordEncoder;
    private $jwtTokenManager;
    private $entityManager;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface, JWTTokenManagerInterface $jWTTokenManagerInterface, EntityManagerInterface $em) {
        $this->passwordEncoder = $userPasswordHasherInterface;
        $this->jwtTokenManager = $jWTTokenManagerInterface;
        $this->entityManager = $em;
    }

    #[Route('/auth', name: 'app_auth')]
    public function index(): Response
    {
        return $this->render('auth/index.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    #[Route('/auth/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return new JsonResponse([
                'status' => 400,
                'message' => 'Invalid JSON format'
            ]);
        }

      
        if (!is_array($data)) {
            return new JsonResponse([
                'status' => 400,
                'message' => 'Invalid data format'
            ]);
        }

        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        if (empty($username) || empty($password)) {
            return new JsonResponse([
                'status' => 400,
                'message' => 'Username or password cannot be empty'
            ]);
        }

        $user = new AuthenticatedUser();
        $user->setName($username);
        $user->setPassword($this->passwordEncoder->hashPassword($user, $password));
        $user->setVerified(true);
        $user->setType(\App\Enum\Type::PREMIUM->value);
        $user->setRoles(['USER_ROLE']);
        $user->setContractStartDate(new \DateTime());
        $user->setContractEndDate(Carbon::now()->addYear());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $token = $this->jwtTokenManager->create($user);

        return new JsonResponse([
            'status' => 200,
            'message' => 'User registered successfully',
            'token' => $token
        ]);
    }

    #[Route('/login', name: 'app_login', methods: ['POST'])]
    public function login(): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => 200,
                'message' => 'OK',
            ]
        );
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => 200,
                'message' => 'OK',
            ], 
            
        );
    }

    #[Route('/user', name: 'app_authentication_user', methods: ['GET'])]
    public function getAuthenticatedUser(): JsonResponse
    {
        $user = $this->getUser()->getUserIdentifier();
        return new JsonResponse(
            [
                'status' => 200,
                'message' => 'OK',
                'data' => $user
            ]
        );
    }
}
