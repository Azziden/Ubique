<?php

namespace App\Controller;

use App\Entity\Magazine;
use App\Entity\Titre;
use App\Entity\User;
use App\Repository\MagazineRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChooseTitreDetailsController extends AbstractController
{
    #[Route('/titre/{titre}', name: 'app_choose_titre_details')]
    public function index(MagazineRepository $magazineRepo, Request $request, PaginatorInterface $paginator ,Titre $titre): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /** @var User $user */
        $user = $this->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');

        $magazines = $titre->getMagazines();

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

        return $this->render('choose_titre_details/index.html.twig', [
            'magazine' => $magazine,
            'mots' => $mots,
            'no_memberships' => $user->getTitreMemberships()->count() === 0
        ]);
    }
}
