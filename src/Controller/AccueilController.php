<?php

namespace App\Controller;


use App\Entity\Magazine;
use App\Form\SearchMagazineType;
use App\Controller\AccueilController;
use App\Repository\MagazineRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(MagazineRepository $magazineRepo,PaginatorInterface $paginator, Request $request, ManagerRegistry $doctrine)
    {
        $magazine = $doctrine->getRepository(Magazine::class)->findBy(['code_affaire' => 'DESC'], ['code_affaire_en_clair' =>'DESC']);
        $form = $this->createForm(SearchMagazineType::class);
       
        $search = $form->handleRequest($request); 
        $magazine = $doctrine->getRepository(Magazine::class)->findAll();
        if($form ->isSubmitted() && $form->isValid()){
            // On recherche les magazines correspondant aux mot clés
            $magazine = $magazineRepo->search($search->get('mots')
            ->getData());
        }
        

        {
            $magazine = $doctrine->getRepository(Magazine::class)->findAll();
    
            $magazine = $paginator->paginate(
                $magazine, 
                $request->query->getInt('page', 1),
                10
            );
         
    
       
         
        }
        return $this->render('accueil/index.html.twig', [
            'magazine' => $magazine,
            'form' =>$form->createView(),
            
        ]);
    }

   
    
}
