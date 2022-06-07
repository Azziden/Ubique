<?php

namespace App\Controller;

use App\Entity\Magazine;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MagazineController extends AbstractController
{
    #[Route('/magazine', name: 'search')]
    public function index(): Response
    {
        return $this->render('magazine/searchBar.html.twig', [
            'controller_name' => 'MagazineController',
        ]);
    }
    public function searchByCodeAffaireEnClairAction()
    {
        $em=$this->getDoctrine()->getManager();
        $magazine = $em->getRepository(classname:: Magazine::class)->findAll();

        return $this->render('magazine/searchBar.html.twig');
    }
}
