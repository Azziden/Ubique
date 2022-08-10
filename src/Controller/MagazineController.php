<?php

namespace App\Controller;

use App\Entity\Magazine;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MagazineController extends AbstractController
{
    #[Route('/magazine/{magazine}', name: 'app_choose_magazine_type')]
    public function view(Magazine $magazine, Request $request, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        //Enregistrer date de parution dans bdd
        $entityManager = $doctrine->getManager();

        $now = date_create();

        $date = $request->get('date_de_parution');
        if ($date) {
            if ($magazine->getDateDeParutionSetAt() === null || $magazine->getDateDeParutionSetAt()->diff($now)->days < 5) {
                $magazine->setDateDeParution($date);

                if ($magazine->getDateDeParutionSetAt() === null) {
                    $magazine->setDateDeParutionSetAt($now);
                }

                $entityManager->flush();
            } else {
                $this->addFlash('danger', "Ce n'est pas possible de modifier la date de parution");
            }
        }

        $date = $request->get('date_de_bouclage');
        if ($date) {
            if ($magazine->getDateDeBouclageSetAt() === null || $magazine->getDateDeBouclageSetAt()->diff($now)->days < 5) {
                $magazine->setDateDeBouclage($date);

                if ($magazine->getDateDeBouclageSetAt() === null) {
                    $magazine->setDateDeBouclageSetAt($now);
                }

                $entityManager->flush();
            } else {
                $this->addFlash('danger', "Ce n'est pas possible de modifier la date de bouclage");
            }
        }


        return $this->render('magazine/view.html.twig', [
            'controller_name' => 'ChooseMagazineTypeController',
            'magazine' => $magazine,
        ]);
    }

    #[Route('/magazine/{magazine}/set_nb_de_page_redactionnelle', name: 'app_magazine_set_nb_de_page_redactionnelle')]
    public function setNbDePageRedactionnelle(ManagerRegistry $doctrine, Magazine $magazine, Request $request): Response
    {
        $pigisteClient = $magazine->getpigisteClients();

        //Enregistrer Nombre de page redactionnelle a la bdd
        $entityManager = $doctrine->getManager();

        $now = date_create();
        $nbDePageRedactionnelle = $request->get('nb_de_page_redactionnelle');

        if ($nbDePageRedactionnelle !== null) {
            if ($magazine->getNbDePageRedactionnelleSetAt() === null || $magazine->getNbDePageRedactionnelleSetAt()->diff($now)->days < 5) {
                $magazine->setNbDePageRedactionnelle($nbDePageRedactionnelle);

                if ($magazine->getNbDePageRedactionnelleSetAt() === null) {
                    $magazine->setNbDePageRedactionnelleSetAt($now);
                }

                $entityManager->flush();
            } else {
                $this->addFlash('danger', "Ce n'est pas possible de modifier le nombre de page rédactionnelle");
            }
        } else {
            throw new BadRequestHttpException();
        }

        $this->addFlash('success', "Nombre de page rédactionnelle envoyé avec succès");

        $route = 'app_pigiste_client';

        if ($request->get('origin') === 'redachef') {
            $route = 'app_redachef';
        }

        return $this->redirectToRoute($route, ['magazine' => $magazine->getId()]);
    }
}
