<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApiProgresoController extends AbstractController
{
    #[Route('/api/progreso', name: 'app_api_progreso')]
    public function index(): Response
    {
        return $this->render('api_progreso/index.html.twig', [
            'controller_name' => 'ApiProgresoController',
        ]);
    }
}
