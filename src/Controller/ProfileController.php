<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserAdress;
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
        return $this->render('profile/index.html.twig');
    }

    #[Route('/adresse/add', name: '_adress_add')]
    public function addAdress(UserAdressService $userService): Response
    {
        $adressForm = $userService->add();

        return $this->render('profile/addAdress.html.twig', [
            'adressForm' => $adressForm->createView(),
        ]);
    }

    #[Route('/adresse/edit/{id}', name: '_adress_edit')]
    public function editAdress(UserAdressService $userService, UserAdress $userAdress): Response
    {
        $adressForm = $userService->edit($userAdress);

        return $this->render('profile/editAdress.html.twig', [
            'adressForm' => $adressForm->createView(),
        ]);
    }

    #[Route('/adresse/delete/{id}', name: '_adress_delete')]
    public function deleteAdress(UserAdressService $userService, UserAdress $userAdress): Response
    {
        $userService->delete($userAdress);
        
        return $this->redirectToRoute('profile_index');
    }
}
