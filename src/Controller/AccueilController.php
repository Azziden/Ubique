<?php

namespace App\Controller;


use App\Entity\Magazine;

use App\Repository\MagazineRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(MagazineRepository $magazineRepo, Request $request, PaginatorInterface $paginator ,ManagerRegistry $doctrine)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
     
        $magazine = $doctrine->getRepository(Magazine::class)->findAll();

        if($mots = $request->query->get('mots')){
            // On recherche les magazines correspondant aux mot clés
            $magazine = $magazineRepo->search($mots);
        }

        $magazine = $paginator->paginate(
            $magazine,
            $request->query->getInt('page', 1),
            10
        );

        
        
        return $this->render('accueil/index.html.twig', [
            'magazine' => $magazine,
            'mots' => $mots
        ]);
    }
    
}
