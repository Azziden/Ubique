<?php

namespace App\Controller;

use App\Entity\Magazine;
use App\Repository\RedachefRepository;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RedachefController extends AbstractController
{
    #[Route('/magazine/{magazine}/redachef', name: 'app_redachef')]
    public function index(RedachefRepository $redachefRepo, ManagerRegistry $doctrine, Magazine $magazine ): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $redachef = $magazine->getRedachefs();

        
        return $this->render('redachef/index.html.twig', [
            'redachef' => $redachef,
            'magazine' => $magazine,

        ]);
    }
}
