<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'maxLength' => 50,
                ]
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'maxLength' => 50,
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'maxLength' => 150
                ]
            ])
            ->add('subject', ChoiceType::class, [
                'choices' => [
                    '-- sélectionner --' => '',
                    'signaler un bug' => 'bug',
                    'SAV' => 'sav',
                    'autre' => 'autre',
                ]
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'minLength' => 25,
                    'maxLength' => 2000
                ]
            ])
            ->add('honeypot', HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
