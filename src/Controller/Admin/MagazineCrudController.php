<?php

namespace App\Controller\Admin;

use App\Entity\Magazine;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MagazineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Magazine::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('code_affaire'),
            TextField::new('code_affaire_en_clair'),
            TextEditorField::new('description'),
        ];
    }
    
}
