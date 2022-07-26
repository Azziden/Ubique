<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ExportFormType extends AbstractType
{
    public const REDACHEF_KEY = 'redachef';
    public const ICONOGRAPHIE_KEY = 'iconographie';
    public const PIGISTE_KEY = 'pigiste_fourni_par_client';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Redachef' => self::REDACHEF_KEY,
                    'Iconographie' => self::ICONOGRAPHIE_KEY ,
                    'Pigiste fourni par client' => self::PIGISTE_KEY,
                ],
                'label' => false,
                'placeholder' => 'Selectionner le type',
            ])
            ->add('submit', SubmitType::class,[
                'label' => "Exporter"
            ])
        ;
    }

}
