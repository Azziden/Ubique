<?php

namespace App\Controller;

use App\Entity\Magazine;
use App\Entity\Redachef;

use App\Form\EditRedachefType;
use App\Repository\RedachefRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SalarieEtEntrepriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RedachefController extends AbstractController
{
    #[Route('/magazine/{magazine}/redachef', name: 'app_redachef')]
    public function index(ManagerRegistry $doctrine, Magazine $magazine, Request $request, SalarieEtEntrepriseRepository $salarieRepo): Response
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

                $redachef = new Redachef();
                $redachef->setSalarieEtEntreprise($salarie);
                $redachef->setMagazine($magazine);
                $redachef->setArticle($item->article);
                $redachef->setSigne($item->signe);
                $redachef->setNbDeFeuillet($item->nb_de_feuillet);
                $redachef->setForfait($item->forfait);
                $redachef->setPrixAuFeuillet($item->prix_au_feuillet);
                $redachef->setMontant($item->montant);
                $redachef->setCreatedAt(date_create());

                $entityManager->persist($redachef);
            }

            $entityManager->flush();
        }

        $redachef = $magazine->getRedachefs();

        //Enregistrer Nombre de page redactionnelle à la bdd
        $entityManager = $doctrine->getManager();

        $nbDePageRedactionnelle = $request->get('nb_de_page_redactionnelle');
        if ($nbDePageRedactionnelle) {
            $magazine->setNbDePageRedactionnelle($nbDePageRedactionnelle);
            $entityManager->flush();
        }

        return $this->render('redachef/index.html.twig', [
            'redachef' => $redachef,
            'magazine' => $magazine,

        ]);
    }

    #[Route('/magazine/{magazine}/redachef/{redachef}/edit', name: 'app_edit_redachef')]
    public function edit(Magazine $magazine, Redachef $redachef, Request $request, ManagerRegistry $doctrine,): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');//Imposible de voir le site si on est pas connecté

        $form = $this->createForm(EditRedachefType::class, $redachef);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($redachef);
            $em->flush();

            $this->addFlash('success', 'Redachef enregistrée avec succès');

            return $this->redirectToRoute('app_redachef', ['magazine' => $magazine->getId()]);
        }

        return $this->render('redachef/edit.html.twig', [
            'redachef' => $redachef,
            'form' => $form->createView(),

        ]);
    }
}
