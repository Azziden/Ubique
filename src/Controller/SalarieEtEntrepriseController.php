<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SalarieEtEntrepriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SalarieEtEntrepriseController extends AbstractController
{
    #[Route('/salarie-et-entreprise/search', name: 'app_salarie_et_entreprise_search')]
    public function index(SalarieEtEntrepriseRepository $repository, Request $request): Response
    {
        //$data = $repository->findAllMatchingIcono($request->query->get('query'));
        $data = $repository->findAllMatching($request->query->get('query'));
        $noms = [];

        foreach ($data as $datum) {
            $noms[] = [
                "id" => $datum->getId(),
                "nom_d_usage" => $datum->getNomDUsage(),
                "nom_compta" => $datum->getNomCompta(),
                "statut" => $datum->getStatut(),
                "type" => $datum->getType(),
                "droit_auteur" => $datum->getDroitAuteur(),
            ];
        }

        return $this->json($noms);
    }
}
