<?php

namespace App\Form;

use App\Entity\Race;
use App\Entity\Classe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('minPower', NumberType::class, [
                'required' => false,    
                // 'empty_data' => 0,
                ])

            ->add('race', EntityType::class, [
                'class' => Race::class,
                'choice_label'  =>  'race_name',
                // 'choices' => $race->getRaces(),
                // 'choices_value' => ChoiceList::value($this, 'race_name'),
                'required' => false,
                'expanded' => false,
                'multiple' => false,
                // 'empty_data' => ,
                'placeholder' => 'Toutes',
                ])

            ->add('class', EntityType::class, [
                'class' => Classe::class,
                'choice_label'  =>  'class_name',
                'required' => false,
                'expanded' => false,
                'multiple' => false,                
                // 'empty_data' => ,
                'placeholder' => 'Toutes',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
