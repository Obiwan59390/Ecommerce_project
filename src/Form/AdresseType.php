<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('libelle',TextType::class, [
            'label' => 'Libelle :',
            'label_attr' =>['style' => "text-decoration: underline;",
                            'class'=>'col-sm-2 col-form-label'],
            'attr' => [
                'placeholder' => 'Saisir votre libellé',
            ]
            ])
        
        ->add('societe', TextType::class, [
            'label' => 'Sociéte (facultatif) :',
            'required' => false,
            'label_attr' =>['style' => "text-decoration: underline;",
                            'class'=>'col-sm-2 col-form-label'],
            'attr' => [
                'placeholder' => 'Saisir votre nom de société',
                ],
            ])

            ->add('siret', TextType::class, [
                'label' => 'Siret (falcultatif):',
                'required' => false,
                'label_attr' =>['style' => "text-decoration: underline;",
                                'class'=>'col-sm-2 col-form-label'],
                'attr' => [
                    'placeholder' => 'Saisir votre numero siret (facultatif)',
                ],
            ])

            ->add('texteAdresse', TextType::class, [
                'label' => 'Adresse:',
                'label_attr' =>['style' => "text-decoration: underline;",
                                'class'=>'col-sm-2 col-form-label'],
                'attr' => [
                    'placeholder' => 'Saisir votre adresse (rue/impasse/etc)',
                ],
            ])

            ->add('cp', TextType::class, [
                'label' => 'Code postal:',
                'label_attr' =>['style' => "text-decoration: underline;",
                                'class'=>'col-sm-2 col-form-label'],
                'attr' => [
                    'placeholder' => 'Saisir votre code postal',
                ],
            ])

            ->add('ville', TextType::class, [
                'label' => 'Ville:',
                'label_attr' =>['style' => "text-decoration: underline;",
                                'class'=>'col-sm-2 col-form-label'],
                'attr' => [
                    'placeholder' => 'Saisir votre ville',
                ],
            ])

            ->add('pays', TextType::class, [
                'label' => 'Pays:',
                'label_attr' =>['style' => "text-decoration: underline;",
                                'class'=>'col-sm-2 col-form-label'],
                'attr' => [
                    'placeholder' => 'Saisir votre pays',
                ],
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter l\'adresse',
                'attr' => ['class'=>'btn btn-lg btn-primary mb-1',
                            ]
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
