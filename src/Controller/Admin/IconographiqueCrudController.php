<?php

namespace App\Controller\Admin;

use App\Entity\Iconographique;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class IconographiqueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Iconographique::class;
    }

    
    public function configureFields(string $pagename): iterable
    {
        return [
          IntegerField::new(  'id'), 
          TextField::new('article'),
          IntegerField::new('nb_photo'),
          IntegerField::new('prix_photo'), 
          IntegerField::new('montant'),
        ];
    }
    
}
