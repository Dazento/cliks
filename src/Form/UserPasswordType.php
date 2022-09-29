<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Ancien mot de passe',
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                ]
            ])
            ->add(
                'newPassword',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'invalid_message' => 'Les deux mots de passe ne correspondent pas.',
                    'mapped' => false,
                    'attr' => [
                        'autocomplete' => 'new-password',
                    ],
                    'first_options' => [
                        'label' => 'Nouveau mot de passe',
                        'attr' => [
                            'class'  => 'mdp'
                        ],
                        'constraints' => [
                            new NotBlank([
                                'message' => 'Le mot de passe est obligatoire.',
                            ]),
                            new PasswordStrength([
                                'minLength' => 8,
                                'tooShortMessage' => 'Le mot de passe doit contenir au moins 8 caractères.',
                                'minStrength' => 3,
                                'message' => 'Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule et un chiffre.'
                            ])
                        ],
                    ],
                    'second_options' => [
                        'label' => 'Confirmation du mot de passe',
                        'attr' => [
                            'class'  => 'confirmMdp'
                        ],
                        'constraints' => [
                            new NotBlank([
                                'message' => 'Merci de confirmer votre mot de passe.'
                            ])
                        ]
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
