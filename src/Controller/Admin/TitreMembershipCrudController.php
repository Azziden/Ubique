<?php

namespace App\Controller\Admin;

use App\Entity\TitreMembership;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class TitreMembershipCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TitreMembership::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', '#')->hideOnForm(),
            AssociationField::new('user', 'Utilisateur')->autocomplete()->setRequired(true),
            AssociationField::new('titre', 'Titre associé')->autocomplete()->setRequired(true),
        ];
    }
}
