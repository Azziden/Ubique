<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Titre;
use App\Repository\MagazineRepository;
use App\Repository\TitreRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TitreController extends AbstractController
{
    #[Route('/titre', name: 'titre')]
    public function index(TitreRepository $titreRepo, Request $request, PaginatorInterface $paginator ,ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /** @var User $user */
        $user = $this->getUser();

        //If connected as admin then can see all the "magazines"
        if ($isAdmin = $this->isGranted('ROLE_ADMIN')) {
            $titres = $doctrine->getRepository(Titre::class)->findAll();
        } else {
            // Else, he would only have access to his own "magazines"
            $magazines = [];

            foreach ($user->getTitreMemberships() as $membership) {
                $titres = array_merge($titres, $membership->getTitre()->getTitres()->toArray());
            }
        }

        if($mots = $request->query->get('mots')){
            // Search magazines by the "mots" query variable, giving user as null if it's an admin or itself to filter
            // by his magazines
            $titres = $titreRepo->searchTitre($mots, $isAdmin ? null : $user);
        }

        $titre = $paginator->paginate(
            $titres,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('titre/index.html.twig', [
            'titre' => $titre,
            'mots' => $mots,
            'no_memberships' => $user->getTitreMemberships()->count() === 0
        ]);
    }

    #[Route('/titre/{titre}', name: 'app_choose_titre_details')]
    public function view(MagazineRepository $magazineRepo, Request $request, PaginatorInterface $paginator, Titre $titre): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /** @var User $user */
        $user = $this->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');

        $magazines = $titre->getMagazines();

        if ($mots = $request->query->get('mots')) {
            // Search magazines by the "mots" query variable, giving user as null if it's an admin or itself to filter
            // by his magazines
            $magazines = $magazineRepo->search($mots, $isAdmin ? null : $user);
        }

        $magazine = $paginator->paginate(
            $magazines,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('titre/view.html.twig', [
            'magazine' => $magazine,
            'mots' => $mots,
            'no_memberships' => $user->getTitreMemberships()->count() === 0
        ]);
    }

}
