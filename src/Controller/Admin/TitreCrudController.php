<?php

namespace App\Controller\Admin;

use App\Entity\Titre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;

class TitreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Titre::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            ...parent::configureFields($pageName),

            ArrayField::new('magazines')->onlyOnDetail()
        ];
    }
}
