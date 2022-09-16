<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\CartService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/cart', name: 'cart')]
class CartController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function index(CartService $cartService): Response
    {
        return $this->render('cart/index.html.twig', [
            'cartData' => $cartService->getCart(),
            'total' => $cartService->getTotal(),
        ]);
    }

    #[Route('/add/{id}', name: '_add')]
    public function add(CartService $cartService, int $id): Response
    {
        $cartService->add($id);
        return $this->redirectToRoute("cart_index");
    }

    #[Route('/remove/{id}', name: '_remove')]
    public function remove(CartService $cartService, int $id): Response
    {
        $cartService->remove($id);
        return $this->redirectToRoute("cart_index");
    }

    #[Route('/delete/{id}', name: '_delete')]
    public function delete(CartService $cartService, int $id): Response
    {
        $cartService->delete($id);
        return $this->redirectToRoute("cart_index");
    }

    #[Route('/clear', name: '_clear')]
    public function clear(CartService $cartService, int $id): Response
    {
        $cartService->clear();
        return $this->redirectToRoute("cart_index");
    }

    public function getNbProducts(CartService $cartService): Response
    {
        return $this->render('cart/nbProducts.html.twig', [
            'nbProducts' => $cartService->getNbProducts(),
        ]);
    }
    
    #[Route('/validation', name: '_validation')]
    public function validation(Request $request, CartService $cartService, ManagerRegistry $registry): Response
    {
        
    }
}
