<?php

namespace App\Controller;

use App\Entity\Magazine;
use App\Repository\RedachefRepository;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RedachefController extends AbstractController
{
    #[Route('/magazine/{magazine}/redachef', name: 'app_redachef')]
    public function index(RedachefRepository $redachefRepo, ManagerRegistry $doctrine, Magazine $magazine, Request $request ): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');//Imposible de voir le site si on est pas connecté
        $redachef = $magazine->getRedachefs();

        //Enregistrer Nombre de page redactionnelle a la bdd
        $entityManager = $doctrine->getManager();

        $nbDePageRedactionnelle = $request->get('nb_de_page_redactionnelle');
        if ($nbDePageRedactionnelle) {
            $magazine->setNbDePageRedactionnelle($nbDePageRedactionnelle);
            $entityManager->flush();
        }

        return $this->render('redachef/index.html.twig', [
            'redachef' => $redachef,
            'magazine' => $magazine,

        ]);
    }
}
