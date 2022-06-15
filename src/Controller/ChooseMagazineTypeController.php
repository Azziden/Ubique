<?php

namespace App\Controller;

use App\Entity\Magazine;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChooseMagazineTypeController extends AbstractController
{
    #[Route('/magazine/{magazine}', name: 'app_choose_magazine_type')]
    public function index(Magazine $magazine, Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $date = $request->get('date_de_parution');
        if ($date) {
            $magazine->setDateDeParution($date);
            $entityManager->flush();
        }
            

        return $this->render('choose_magazine_type/index.html.twig', [
            'controller_name' => 'ChooseMagazineTypeController',
            'magazine' => $magazine,
        ]);
    }
}
