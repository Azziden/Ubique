<?php

namespace App\Controller;


use App\Entity\Magazine;
use App\Entity\User;
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

        /** @var User $user */
        $user = $this->getUser();

        //If connected as admin then can see all the "magazines"
        if ($isAdmin = $this->isGranted('ROLE_ADMIN')) {
            $magazines = $doctrine->getRepository(Magazine::class)->findAll();
        } else {
            // Else, he would only have access to his own "magazines"
            $magazines = [];

            foreach ($user->getTitreMemberships() as $membership) {
                $magazines = array_merge($magazines, $membership->getTitre()->getMagazines()->toArray());
            }
        }

        if($mots = $request->query->get('mots')){
            // Search magazines by the "mots" query variable, giving user as null if it's an admin or itself to filter
            // by his magazines
            $magazines = $magazineRepo->search($mots, $isAdmin ? null : $user);
        }

        $magazine = $paginator->paginate(
            $magazines,
            $request->query->getInt('page', 1),
            10
        );
        
        return $this->render('accueil/index.html.twig', [
            'magazine' => $magazine,
            'mots' => $mots,
            'no_memberships' => $user->getTitreMemberships()->count() === 0
        ]);
    }
    
}
