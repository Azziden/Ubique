<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Titre;
use App\Entity\Magazine;
use App\Entity\Redachef;
use App\Entity\Iconographique;
use App\Entity\SalarieEtEntreprise;
use App\Controller\Admin\UserCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;


class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return parent::redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
              // the name visible to end users
              ->setTitle('Ubique')
              // you can include HTML contents too (e.g. to link to an image)
              ->setTitle('<img src="..."> Ubique <span class="text-small">Corp.</span>')
  
              //the path defined in this method is passed to the Twig asset() function
              ->setFaviconPath('favicon.svg')
              ->setTranslationDomain('my-custom-domain')
              ->setTextDirection('ltr')
              ->renderContentMaximized()
              ->disableUrlSignatures()
              ->generateRelativeUrls();
    }

    

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Entités'),
            MenuItem::linkToCrud('Magazine', 'fa fa-tags', Magazine::class),
            MenuItem::linkToCrud('iconographique', 'fa fa-tags', Iconographique::class),
            MenuItem::linkToCrud('Redachef', 'fa fa-tags', Redachef::class),
            MenuItem::linkToCrud('SalarieEtEntreprise', 'fa fa-tags', SalarieEtEntreprise::class),
            MenuItem::linkToCrud('Titre', 'fa fa-tags', Titre::class),
           
            
            

            MenuItem::section('Users'),
            MenuItem::LinkToCrud('User', 'fa fa-user', User::class),

        ];
    }
}
