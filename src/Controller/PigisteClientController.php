<?php

namespace App\Controller;

use App\Entity\Magazine;
use App\Entity\PigisteClient;
use App\Form\EditPigisteClientType;
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
                $pigisteClient->setCreatedAt(date_create());

                $entityManager->persist($pigisteClient);
            }

            $entityManager->flush();
        }

        $pigisteClient  = $magazine->getpigisteClients();

        //Enregistrer Nombre de page redactionnelle a la bdd
        $entityManager = $doctrine->getManager();

        $now = date_create();
        $nbDePageRedactionnelle = $request->get('nb_de_page_redactionnelle');

        if ($nbDePageRedactionnelle) {
            if ($magazine->getNbDePageRedactionnelleSetAt() === null || $magazine->getNbDePageRedactionnelleSetAt()->diff($now)->days < 5) {
                $magazine->setNbDePageRedactionnelle($nbDePageRedactionnelle);

                if ($magazine->getNbDePageRedactionnelleSetAt() === null) {
                    $magazine->setNbDePageRedactionnelleSetAt($now);
                }

                $entityManager->flush();
            } else {
                $this->addFlash('danger', "Ce n'est pas possible de modifier le nombre de page rédactionnelle");
            }
        }

        return $this->render('pigiste_client/index.html.twig', [
            'pigiste_client' => $pigisteClient,
            'magazine' => $magazine,

        ]);
    }
    #[Route('/magazine/{magazine}/pigiste_client/{pigiste_client}/edit', name: 'app_edit_pigiste_client')]
    public function edit(Magazine $magazine, PigisteClient $pigisteClient, Request $request, ManagerRegistry $doctrine,): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');//Imposible de voir le site si on est pas connecté

        $form = $this->createForm(EditPigisteClientType::class, $pigisteClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($pigisteClient);
            $em->flush();

            $this->addFlash('success', 'Pigiste enregistrée avec succès');

            return $this->redirectToRoute('app_pigiste_client', ['magazine' => $magazine->getId()]);
        }

        return $this->render('pigiste_client/edit.html.twig', [
            'pigisteClient' => $pigisteClient,
            'form' => $form->createView(),

        ]);
    }
}
