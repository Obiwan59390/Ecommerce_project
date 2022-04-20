<?php

namespace App\Form;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
        ->add('prenom',TextType::class, [
            'label' => 'Prénom :',
            'label_attr' =>['style' => "text-decoration: underline;",
                            'class'=>'col-sm-2 col-form-label'],
            'attr' => [
                'placeholder' => 'Saisir votre prénom',
            ]
            ])
        
            ->add('nom', TextType::class, [
            'label' => 'Nom :',
            'label_attr' =>['style' => "text-decoration: underline;",
                            'class'=>'col-sm-2 col-form-label'],
            'attr' => [
                'placeholder' => 'Saisir votre nom',
            ],
        ])
        
        ->add('email', EmailType::class, [
            'label' => 'Adresse éléctronique :',
            'label_attr' =>['style' => "text-decoration: underline;",
                            'class'=>'col-sm-2 col-form-label'],
            'attr' => [
                'placeholder' => 'Adresse email valide',
                
            ],
        ])
        
        ->add('dateNaissance', DateType::class, [
            'label' => 'Date de naissance :',
            'label_attr' =>['style' => "text-decoration: underline;",
                            'class'=>'col-sm-2 col-form-label'],
            'years' => range(1922,2022),
            'input'  => 'datetime_immutable',
            'format' => 'dd/MM/yyyy',
        ])
        
        ->add('telephone', TelType::class, [
            'label' => 'Téléphone :',
            'label_attr' =>[
                'style' => "text-decoration: underline;",
                'class'=>'col-sm-2 col-form-label'
            ],
            'attr' => [
                'placeholder' => 'Votre numéro de téléphone :'
            ],
        ])

        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Le mot de passe et la confirmation doivent être identique',
            'label' => 'Mot de passe:',
            'required' => true,
            'first_options' =>[
                'label' => 'Mot de passe',
                'label_attr' =>[
                    'style' => "text-decoration: underline;",
                    'class'=>'col-sm-2 col-form-label'
                ],
                'attr' => [
                    'placeholder' => 'mot de passe:'
                ]
            ],
            'second_options' =>['label' => 'Confirmer votre mot de passe:',
            'label_attr' =>[
                'style' => "text-decoration: underline;",
                'class'=>'col-sm-2 col-form-label'
                ],
                'attr' => [
                    'placeholder' => 'confirmer mot de passe'
                ]
            ]
        ])
        ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
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
