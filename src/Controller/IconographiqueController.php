<?php

namespace App\Controller;

use App\Entity\Magazine;
use App\Entity\Iconographique;
use App\Form\EditIconoType;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\IconographiqueRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SalarieEtEntrepriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IconographiqueController extends AbstractController
{
    #[Route('/magazine/{magazine}/iconographique', name: 'app_iconographique')]
    public function index(IconographiqueRepository $iconoRepo, Request $request, ManagerRegistry $doctrine, Magazine $magazine, SalarieEtEntrepriseRepository $salarieRepo)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $data = $request->get('data');
        if ($data != null) {
            $obj = json_decode($data);

            $entityManager = $doctrine->getManager();

            foreach ($obj as $item) {
                $salarie = $salarieRepo->find($item->salarie_id);

                if ($salarie == null) {
                    continue;
                }

                $iconographique = new Iconographique();
                $iconographique->setSalarieEtEntreprise($salarie);
                $iconographique->setMagazine($magazine);
                $iconographique->setArticle($item->article);
                $iconographique->setNbPhoto($item->nb_photo);
                $iconographique->setPrixPhoto($item->prix_photo);
                $iconographique->setMontant($item->montant);
                $iconographique->setCreatedAt(date_create());

                $entityManager->persist($iconographique);

            }

            $entityManager->flush();
        }
        $iconographique = $magazine->getIconographiques();

        return $this->render('iconographique/index.html.twig', [
            'iconographique' => $iconographique,
            'magazine' => $magazine,

        ]);
    }

    #[Route('/magazine/{magazine}/iconographique/{iconographique}/edit', name: 'app_edit_iconographique')]
    public function edit(Magazine $magazine, Iconographique $iconographique, Request $request, ManagerRegistry $doctrine,): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');//Imposible de voir le site si on est pas connecté

        $form = $this->createForm(EditIconoType::class, $iconographique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($iconographique);
            $em->flush();

            $this->addFlash('success', 'Iconographie enregistrée avec succès');

            return $this->redirectToRoute('app_iconographique', ['magazine' => $magazine->getId()]);
        }

        return $this->render('iconographique/edit.html.twig', [
            'iconographique' => $iconographique,
            'form' => $form->createView(),

        ]);
    }
}
