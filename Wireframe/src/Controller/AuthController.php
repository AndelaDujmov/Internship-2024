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

        return new JsonResponse([
            'status' => 200,
            'message' => 'User registered successfully'
        ]);
    }

    #[Route('/auth/login', name: 'app_auth_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return new JsonResponse([
                'status' => 400,
                'message' => 'Invalid JSON format'
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

        $user = $this->entityManager->getRepository(AuthenticatedUser::class)->findOneBy(['name' => $username]);

        if ($user == null) {
            return new JsonResponse([
                'status' => 404,
                'message' => 'User ne postoji'
            ]);
        }

        try {
            $token = $this->jwtTokenManager->create($user);
            if (!$token) {
                throw new \Exception('Token creation returned empty value.');
            }
        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => 500,
                'message' => 'Error creating token: ' . $e->getMessage()
            ]);
        }
        
        return new JsonResponse(
            [
                'status' => 200,
                'message' => 'Succesfully logged in',
                'token' => $token
            ]
        );
    }

    #[Route('/auth/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => 200,
                'message' => 'OK',
            ], 
            
        );
    }

    #[Route('/auth/user', name: 'app_authentication_user', methods: ['GET'])]
    public function getAuthenticatedUser(): JsonResponse
    {
        $user = $this->getUser();
        return new JsonResponse(
            [
                'status' => 200,
                'message' => 'OK',
                'data' => $user
            ]
        );
    }
}
