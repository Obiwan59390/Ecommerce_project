<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ModifierPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => 'Votre prénom:',
                'label_attr' =>['style' => "text-decoration: underline;",
                            'class'=>'col-sm-2 col-form-label'],
                'disabled' => true
            ])
            ->add('nom', TextType::class, [
                'label' => 'Votre nom:',
                'label_attr' =>['style' => "text-decoration: underline;",
                'class'=>'col-sm-2 col-form-label'],
                'disabled' => true
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse éléctronique:',
                'label_attr' =>['style' => "text-decoration: underline;",
                'class'=>'col-sm-2 col-form-label'],
                'disabled' => true
            ])
            ->add('ancienPassword', PasswordType::class, [
                'label' => 'Mot de passe actuel:',
                'label_attr' =>['style' => "text-decoration: underline;",
                'class'=>'col-sm-2 col-form-label'],
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Mot de passe actuel'
                ]
            ])
            ->add('nouveauPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique',
                'label' => 'Nouveau mot de passe:',
                'label_attr' =>['style' => "text-decoration: underline;",
                'class'=>'col-sm-2 col-form-label'],
                'required' => true,
                'first_options' =>[
                    'label' => 'Nouveau mot de passe:',
                    'attr' => [
                        'placeholder' => 'nouveau mot de passe'
                    ],
                    'label_attr' =>['style' => "text-decoration: underline;",
                    'class'=>'col-sm-2 col-form-label'],
                ],
                'second_options' =>['label' => 'Confirmer le nouveau mot de passe:',
                    'attr' => [
                        'placeholder' => 'confirmer le nouveau mot de passe'
                    ],
                    'label_attr' =>['style' => "text-decoration: underline;",
                    'class'=>'col-sm-2 col-form-label'],
                ]
                    ])
            ->add('submit', SubmitType::class, [
                'label' => 'Changer mot de passe',
                'attr' => ['class'=>'btn btn-lg btn-primary mb-1',
                                    ]
                    ])
                ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
