<?php

namespace App\Form;

use App\Entity\UserAdress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adressline', TextType::class, [
                'label' => 'Adresse',
            ])
            ->add('zipcode', TextType::class, [
                'label' => 'Code postal',
                'attr' => [
                    'maxLength' => 5,
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('phone', TextType::class, [
                'label' => 'Numéro de téléphone',
                'attr' => [
                    'minLength' => 10,
                    'maxLength' => 20,
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserAdress::class,
        ]);
    }
}
