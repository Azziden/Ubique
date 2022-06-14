<?php

namespace App\Controller\Admin;

use App\Entity\Iconographique;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class IconographiqueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Iconographique::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
