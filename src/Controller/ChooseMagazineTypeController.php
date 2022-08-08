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
            

        return $this->render('choose_magazine_type/index.html.twig', [
            'controller_name' => 'ChooseMagazineTypeController',
            'magazine' => $magazine,
        ]);
    }
}
