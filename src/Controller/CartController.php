<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart', name: 'cart')]
class CartController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function index(): Response
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
    
    #[Route('/add/{id}', name: '_add')]
    public function add(Product $product, SessionInterface $session): Response
    {
        
        return $this->render('cart/add.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
}
