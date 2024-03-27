<?php

namespace App\Form;

use App\Entity\Villes;
use App\Entity\Departements;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VillesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            //->add('departements')
            ->add('departements', EntityType::class, [
                'class' => Departements::class,
                'choice_label' => 'titre',
            ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Villes::class,
        ]);
    }
}
