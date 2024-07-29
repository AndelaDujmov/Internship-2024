<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnnualLeavesController extends AbstractController
{
    #[Route('/annual/leaves', name: 'app_annual_leaves')]
    public function index(): Response
    {
        return $this->render('annual_leaves/index.html.twig', [
            'controller_name' => 'AnnualLeavesController',
        ]);
    }
}
