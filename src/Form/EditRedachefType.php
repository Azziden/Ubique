<?php

namespace App\Form;

use App\Entity\Redachef;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditRedachefType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('article',TextType::class,['label' => 'Article'])
            ->add('signe', IntegerType::class,['label' => 'Signe'])
            ->add('nb_de_feuillet',NumberType::class,['label' => 'Nombre de feuillet'])
            ->add('forfait', NumberType::class,['label' => 'Forfait'])
            ->add('prix_au_feuillet', NumberType::class,['label' => 'Prix au feuillet'])
            ->add('montant', NumberType::class,['label' => 'Montant'])
            ->add('submit', SubmitType::class,[
                'label' => "Enregistrer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Redachef::class,
        ]);
    }
}
