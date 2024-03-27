<?php

namespace App\Form;

use App\Entity\Departements;
use App\Entity\Fonctions;
use App\Entity\Categories;
use App\Entity\ListeOffres;
use App\Entity\Membres;
use App\Entity\Villes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ListeOffresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('langue_offres', ChoiceType::class, [
                    'choices'  => [
                        'Arabe'=> 1,
                        'Français' => 2,
                        'Anglais'=> 3,
                        'Espagnol' =>4 ],])
                        

                        
            ->add('nombre_stagiaire' )
            ->add('date_debut_stage' ,  DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
                'attr' => ['class' => 'datepicker'],
                // 'html5' => false,
                //'format' => 'dd/mm/yy',
            ]) 
            ->add('date_fin_stage' ,  DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
                'attr' => ['class' => 'datepicker'],
                // 'html5' => false,
                //'format' => 'dd/mm/yy',
            ])

            ->add('date_depo' ,  DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
                'attr' => ['class' => 'datepicker'],
                // 'html5' => false,
                //'format' => 'dd/mm/yy',
            ])
            ->add('date_fin' ,  DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
                'attr' => ['class' => 'datepicker'],
                // 'html5' => false,
                //'format' => 'dd/mm/yy',
            ])
           
            ->add('type_contrat', ChoiceType::class, [
                'choices'  => [
                    'Stage conventionné' =>1,
                    'Contrat de professionnalisation'=> 2 ,
                    'Contrat d`apprentissage' =>3 ,
                    'Autres' => 4 ] ,])


            ->add('Remuneration', ChoiceType::class, [
                'choices'  => [
                    'Moins de 100 DT' =>1,
                    'Entre 100 et 500 DT'=> 2 ,
                    'Plus que 500 DT' =>3 ,
                    'Non rémunéré' => 4 ] ,])


            ->add('description_offres')
            ->add('niveau_etude', ChoiceType::class, [
                'choices'  => [
                    'Sans diplome' =>1,
                    'Bac'=> 2 ,
                    'Bac + 1' =>3 ,
                    'Bac + 2' => 4,
                    'Bac + 3' => 5,
                    'Bac + 4' => 6,
                    'Bac + 5 / plus' => 7,
                    'Autres' => 8,
                     ] ,])


            ->add('formations_requises', ChoiceType::class, [
                'choices'  => [
                    'BTS' =>1,
                    'Université (Licences et Maitrises)'=> 2 ,
                    'Ecoles d`ingénieurs' =>3 ,
                    'Expertises comptables' => 4,
                    'Autres' => 5] ,])

            ->add('permis')
            ->add('competences')
            ->add('langue_parlee')
            ->add('actif')
            ->add('a_la_une')
            ->add('membres', EntityType::class, [
                'class' => Membres::class,
                'choice_label' => 'nom',
                'required' => false,
            ]
            )
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'titre',
                'required' => false,
            ]
            )
            ->add('fonctions' , EntityType::class, [
                'class' => Fonctions::class,
                'choice_label' => 'titre',
                'required' => false,
            ]
            )
            ->add('departements' , EntityType::class, [
                'class' => Departements::class,
                'choice_label' => 'titre',
                'required' => false,
            ]
            )
            ->add('villes', EntityType::class, [
                'class' => Villes::class,
                'choice_label' => 'titre',
                'required' => false,
            ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ListeOffres::class,
        ]);
    }
}
