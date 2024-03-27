<?php

namespace App\Form;

use App\Entity\Villes;
use App\Entity\Membres;
use App\Entity\Departements;
use App\Entity\Fonctions;
use App\Entity\Categories;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class MembresSocietesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $choicesCivilite = [
                'M.' => '1',
                'Mme' => '2',
                'Mlle' => '3',
            ];
            //On récupère l'entité lié au formulaire
            $entity = $event->getData();
            $form = $event->getForm();
            $form->add('civilite', ChoiceType::class, [
                 'label' => 'Civiité',
                 'choices' => $choicesCivilite,
                 'expanded' => true,
                 'multiple' => false,
                 //On définit ici la valeur par défaut
                 //Si le choix existe on le mets sinon on mets à 0 (Ne sais pas)
                 'data' => $entity->getCivilite() ? $entity->getCivilite() : 1
            ]);
            $form ->add('password', PasswordType::class, [
                'required' => $entity->getPassword() != null? false : true
           ]);

          
        });

        $builder
            ->add('nom')
            ->add('prenom')
            ->add('tel')
            ->add('email', EmailType::class)
            ->add('adresse')
            ->add('photo', FileType::class, [
                'label' => 'Photo',
                'mapped' => false,
                'required' => false,
            ])
            ->add('status')
            ->add('complement_adresse')
            ->add('code_postal')
            ->add('inscrit_nl')
            ->add('departement_id', EntityType::class, [
                'class' => Departements::class,
                'choice_label' => 'titre'
            ])
            ->add('ville_id', EntityType::class, [
                'class' => Villes::class,
                'choice_label' => 'titre'
            ])
            ->add('fonction_id', EntityType::class, [
                'class' => Fonctions::class,
                'choice_label' => 'titre'
            ])
            ->add('fax')
            ->add('category_id', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'titre'
            ])
            ->add('raison_social')
            ->add('effectifs_entreprise')
            ->add('chiffre_affaire')
            ->add('site_web')
            ->add('description')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membres::class,
        ]);
    }
}
