<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart', name: 'cart')]
class CartController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function index(SessionInterface $session, ProductRepository $productRepository): Response
    {

        $cart = $session->get('cart', []);

        $cartData = [];
        $total = 0;

        foreach ($cart as $id => $quantity) {
            $product = $productRepository->find($id);
            $cartData[] = [
                "product" => $product,
                "quantity" => $quantity,
            ];

            $total += $product->getPrice() * $quantity;
        };

        return $this->render('cart/index.html.twig', [
            'cartData' => $cartData,
            'total' => $total,
        ]);
    }

    #[Route('/add/{id}', name: '_add')]
    public function add(Product $product, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        $id = $product->getId();

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute("cart_index");
    }

    #[Route('/remove/{id}', name: '_remove')]
    public function remove(Product $product, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        $id = $product->getId();

        if (!empty($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute("cart_index");
    }

    #[Route('/delete/{id}', name: '_delete')]
    public function delete(Product $product, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        $id = $product->getId();

        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute("cart_index");
    }
}
