<?php

namespace App\Form;

use App\Entity\Navigation;
use App\Entity\NavigationListe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class NavigationListeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actif')
            ->add('titre')
            ->add('type_de_page' ,ChoiceType::class, [
                'choices'  => [
                    'Aucun Lien' => 1,
                    'Lien vers une page' => 2,
                    'liste faq' => 3,
                    'Plan du site' => 4,
                    'Nos solutions ' =>5,
                    'Conseils' =>6,
                    'CMS' =>7,
                    'Nos Réalisations' => 8,
                    'Blogs' =>9,
                    'Categories Blogs' =>10,
                    'Sous Categories Blogs' =>11,
                ],
            ])
            ->add('target' ,ChoiceType::class, [
                'choices'  => [
                    '_Top' => 1,
                    '_New' => 2,
                    '_Self' => 3,
                    '_Blank' => 4,
                    '_Parent ' =>5,  
                ],
            ])
            ->add('no_follow')
            ->add('navigation', EntityType::class, [
                'class' => Navigation::class,
                'choice_label' => 'titre'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NavigationListe::class,
        ]);
    }
}
