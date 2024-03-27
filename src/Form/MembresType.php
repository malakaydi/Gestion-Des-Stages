<?php

namespace App\Form;

use App\Entity\Villes;
use App\Entity\Membres;
use App\Entity\Departements;
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


class MembresType extends AbstractType
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
            ->add('date_naissance', DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
                'attr' => ['class' => 'datepicker'],
                'html5' => false,
                'format' => 'dd/mm/yy',
            ])
            ->add('nationalite')
            ->add('complement_adresse')
            ->add('permis')
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
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membres::class,
        ]);
    }
}
