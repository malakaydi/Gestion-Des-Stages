<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Fonctions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FonctionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('status')
            ->add('categorie_id', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'titre',
            ]
            );
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fonctions::class,
        ]);
    }
}
