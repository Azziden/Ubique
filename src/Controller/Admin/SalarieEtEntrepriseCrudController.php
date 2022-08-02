<?php

namespace App\Controller\Admin;

use App\Entity\SalarieEtEntreprise;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SalarieEtEntrepriseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SalarieEtEntreprise::class;
    }
    public function configureFields(string $pageName): iterable
    {
        // First we get all the default fields by calling the parent method from AbstractCrudController
        $entityFields = parent::configureFields($pageName);
        // As we want to keep the ID as the first column, we slice the array to get all the fields except from the first one
        $allExceptId = array_slice($entityFields, 1);

        return [
            // We put the first entity field, being ID
            $entityFields[0],



            // We spread all the default sliced entity fields (+ not working correctly)
            ...$allExceptId,

            IntegerField::new("ratio_brut_commande", "Ratio brut commandé")->onlyOnIndex(),

        ];
    }
}
