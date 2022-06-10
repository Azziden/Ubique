<?php

namespace App\Controller\Admin;

use App\Entity\Magazine;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MagazineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Magazine::class;
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
