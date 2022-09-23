<?php

namespace App\Service;

use App\Entity\UserAdress;
use App\Form\UserAdressType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserAdressService extends AbstractController
{
  protected $request;
  protected $managerRegistry;

  public function __construct(RequestStack $requestStack, ManagerRegistry $managerRegistry)
  {
    $this->requestStack = $requestStack;
    $this->managerRegistry = $managerRegistry;
  }

  public function add()
  {
    $userAdress = new UserAdress();
    $adressForm = $this->createForm(UserAdressType::class, $userAdress);
    $adressForm->handleRequest($this->requestStack->getCurrentRequest());

    if ($adressForm->isSubmitted() && $adressForm->isValid()) {
      $manager = $this->managerRegistry->getManager();

      $userAdress
        ->setUser($this->getUser())
        ->setAdressline($adressForm['adressline']->getData())
        ->setCity($adressForm['city']->getData())
        ->setZipcode($adressForm['zipcode']->getData())
        ->setPhone($adressForm['phone']->getData());

      $manager->persist($userAdress);
      $manager->flush();
    }
    return $adressForm;
  }

  public function edit($userAdress)
  {
    $adressForm = $this->createForm(UserAdressType::class, $userAdress);
    $adressForm->handleRequest($this->requestStack->getCurrentRequest());

    if ($adressForm->isSubmitted() && $adressForm->isValid()) {
      $manager = $this->managerRegistry->getManager();

      $userAdress
        ->setUser($this->getUser())
        ->setAdressline($adressForm['adressline']->getData())
        ->setCity($adressForm['city']->getData())
        ->setZipcode($adressForm['zipcode']->getData())
        ->setPhone($adressForm['phone']->getData());

      $manager->persist($userAdress);
      $manager->flush();
    }
    return $adressForm;
  }

  public function delete($userAdress)
  {
    $manager = $this->managerRegistry->getManager();
    $manager->remove($userAdress);
    $manager->flush();
  }
}
