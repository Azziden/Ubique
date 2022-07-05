<?php

namespace App\Controller;

use App\Entity\Magazine;
use App\Entity\PigisteClient;
use App\Repository\SalarieEtEntrepriseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PigisteClientController extends AbstractController
{
    #[Route('magazine/{magazine}/pigisteClient', name: 'app_pigiste_client')]
    public function index(PigisteClientController $pigisteClient, ManagerRegistry $doctrine, Magazine $magazine, Request $request, SalarieEtEntrepriseRepository $salarieRepo): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');//Imposible de voir le site si on est pas connecté

        $data = $request->get('data');
        if ($data != null) {
            $obj = json_decode($data);

            $entityManager = $doctrine->getManager();

            foreach ($obj as $item) {
                $salarie = $salarieRepo->find($item->salarie_id);

                if ($salarie == null) {
                    continue;
                }

                $pigisteClient = new PigisteClient();
                $pigisteClient ->setSalarieEtEntreprise($salarie);
                $pigisteClient ->setMagazine($magazine);
                $pigisteClient ->setArticle($item->article);
                $pigisteClient ->setSigne($item->signe);
                $pigisteClient ->setNbDeFeuillet($item->nb_de_feuillet);
                $pigisteClient ->setForfait($item->forfait);
                $pigisteClient ->setPrixAuFeuillet($item->prix_au_feuillet);
                $pigisteClient ->setMontant($item->montant);

                $entityManager->persist($pigisteClient);
            }

            $entityManager->flush();
        }

        $pigisteClient  = $magazine->getpigisteClients();

        //Enregistrer Nombre de page redactionnelle a la bdd
        $entityManager = $doctrine->getManager();

        $nbDePageRedactionnelle = $request->get('nb_de_page_redactionnelle');
        if ($nbDePageRedactionnelle) {
            $magazine->setNbDePageRedactionnelle($nbDePageRedactionnelle);
            $entityManager->flush();
        }

        return $this->render('pigiste_client/index.html.twig', [
            'pigiste_client' => $pigisteClient,
            'magazine' => $magazine,

        ]);
    }
}
