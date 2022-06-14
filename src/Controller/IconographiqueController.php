<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IconographiqueController extends AbstractController
{
    #[Route('/iconographique', name: 'app_iconographique')]
    public function index(): Response
    {
        return $this->render('iconographique/index.html.twig', [
            'controller_name' => 'IconographiqueController',
        ]);
    }
}
