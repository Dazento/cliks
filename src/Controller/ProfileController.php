<?php

namespace App\Controller;

use App\Entity\UserAdress;
use App\Form\UserAdressType;
use App\Service\UserAdressService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profile', name: 'profile')]
class ProfileController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function index(): Response
    {

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    #[Route('/adresse/add', name: '_adress_add')]
    public function addAdress(Request $request, ManagerRegistry $managerRegistry, UserAdressService $userService): Response
    {
        $adressForm = $userService->add();
        
        return $this->render('profile/addAdress.html.twig', [
            'adressForm' => $adressForm->createView(),
        ]);
    }
}
