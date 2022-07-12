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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        //Enregistrer date de parution dans bdd
        $entityManager = $doctrine->getManager();

        $date = $request->get('date_de_parution');
        if ($date) {
            $magazine->setDateDeParution($date);
            $entityManager->flush();
        }
        $date = $request->get('date_de_bouclage');
        if ($date) {
            $magazine->setDateDeBouclage($date);
            $entityManager->flush();
        }
            

        return $this->render('choose_magazine_type/index.html.twig', [
            'controller_name' => 'ChooseMagazineTypeController',
            'magazine' => $magazine,
        ]);
    }
}
