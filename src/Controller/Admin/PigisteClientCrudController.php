<?php

namespace App\Controller\Admin;

use App\Entity\PigisteClient;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PigisteClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PigisteClient::class;
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

            // We add all the extra fields here

            // This associated field is only gonna be visible on the forms (edit & new)
            AssociationField::new("salarie_et_entreprise")->onlyOnForms()->autocomplete(),

            // This associated field is only gonna be visible on the forms (edit & new)
            AssociationField::new("magazine")->onlyOnForms()->autocomplete(),

            // And all the text fields are only gonna be visible on the index page
            TextField::new("nom_d_usage", "Nom d'usage")->onlyOnIndex(),

            TextField::new("nom_compta", "Nom compta")->onlyOnIndex(),

            TextField::new("statut")->onlyOnIndex(),

            TextField::new("type")->onlyOnIndex(),

            // We spread all the default sliced entity fields ("+" not working correctly)
            ...$allExceptId,

            NumberField::new("montant_total_brut", "Montant total brut")->setNumDecimals(2)->onlyOnIndex(),

            NumberField::new("montant_charge", "Montant chargé")->setNumDecimals(2)->onlyOnIndex(),

            TextField::new("code_affaire")->onlyOnIndex(),

            TextField::new("racine")->onlyOnIndex(),


        ];
    }
}
