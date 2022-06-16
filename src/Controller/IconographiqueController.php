<?php

namespace App\Controller;

use App\Entity\Magazine;
use App\Entity\Iconographique;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\IconographiqueRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IconographiqueController extends AbstractController
{
    #[Route('/magazine/{magazine}/iconographique', name: 'app_iconographique')]
        public function index(IconographiqueRepository $iconoRepo, Request $request,ManagerRegistry $doctrine, Magazine $magazine)
        {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $iconographique = $magazine->getIconographiques();
            
            return $this->render('iconographique/index.html.twig', [
                'iconographique' => $iconographique,
                'magazine' => $magazine,
                
            ]);
        }
}
