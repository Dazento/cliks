<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\UserAdress;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class CartValidationType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('deliveryAdress', EntityType::class, [
                'label' => 'Adresse de livraison',
                'class' => UserAdress::class,
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('a')
                        ->where('a.user = :val')
                        ->setParameter(':val', $this->security->getUser());
                },
                'choice_label' => function (UserAdress $userAdress) {
                    return $userAdress->getAdressline() . ' - ' . $userAdress->getZipcode() . ' ' . $userAdress->getCity();
                }
            ])
            ->add('billingAdress', EntityType::class, [
                'label' => 'Adresse de facturation',
                'class' => UserAdress::class,
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('a')
                        ->where('a.user = :val')
                        ->setParameter(':val', $this->security->getUser());
                },
                'choice_label' => function (UserAdress $userAdress) {
                    return $userAdress->getAdressline() . ' - ' . $userAdress->getZipcode() . ' ' . $userAdress->getCity();
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
