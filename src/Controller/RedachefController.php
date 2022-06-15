<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RedachefController extends AbstractController
{
    #[Route('/magazine/{magazine}/redachef', name: 'app_redachef')]
    public function index(): Response
    {
        return $this->render('redachef/index.html.twig', [
            'controller_name' => 'RedachefController',
        ]);
    }
}
