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

    protected function getRangeArray($start, $end, $padLeft = false): array {
        $arr = [];

        for ($i = $start; $i <= $end; $i++) {
            $val = str_pad(strval($i), $padLeft ? 2 : 0, '0', STR_PAD_LEFT);

            $arr[$val] = $val;
        }

        return $arr;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $year = intval(date('Y'));

        $builder
            ->add('day', ChoiceType::class, [
                'placeholder' => "Entrez le jour",
                'required' => false,
                'choices' => $this->getRangeArray(1, 31, true)
            ])
            ->add('month', ChoiceType::class, [
                'placeholder' => "Entrez le mois",
                'required' => false,
                'choices' => $this->getRangeArray(1, 12, true)
            ])
            ->add('year', ChoiceType::class, [
                'placeholder' => "Entrez l'année",
                'required' => false,
                'choices' => array_reverse($this->getRangeArray($year - 5, $year), true)
            ])
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
