<?php

namespace App\Controller;

use App\Entity\Order;
use App\Service\CartService;
use Doctrine\Persistence\ManagerRegistry;
use Stripe\StripeClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/payment/{order}', name: 'payment')]
    public function index(Request $request, Order $order, CartService $cartService): Response
    {
        // if ($request->headers->get('referer') !== 'https://127.0.0.1:8004/cart/validation') {
        //     return $this->redirectToRoute('cart_validation');
        // }

        $sessionCart = $cartService->getCart();
        $stripeCart = [];

        foreach ($sessionCart as $cartElement) {
            $stripeElement = [
                'quantity' => $cartElement['quantity'],
                'price_data' => [
                    'currency' => 'EUR',
                    'unit_amount' => $cartElement['product']->getPrice(),
                    'product_data' => [
                        'name' => $cartElement['product']->getName(),
                        'images' => [
                            'http://localhost:8004/assets/img/product/mainImg/' . $cartElement['product']->getMainImage(),
                        ]
                    ]
                ]
            ];
            $stripeCart[] = $stripeElement;
        }

        $stripe = new StripeClient($this->getParameter('stripe_secret_key'));

        $stripeSession = $stripe->checkout->sessions->create([
            'line_items' => $stripeCart,
            'mode' => 'payment',
            'success_url' => 'http://localhost:8004/payment/' . $order->getId() . '/success',
            'cancel_url' => 'http://localhost:8004/payment/cancel',
            'payment_method_types' => ['card']
        ]);

        return $this->render('payment/index.html.twig', [
            'sessionId' => $stripeSession->id
        ]);
    }

    #[Route('/payment/{order}/success', name: 'success')]
    public function success(Order $order, CartService $cartService, ManagerRegistry $managerRegistry): Response
    {
        // vérifier qu'on vient bien de la page de paiemetn Stripe

        $manager = $managerRegistry->getManager();
        $cartService->clear();
        $order->setPaid(true);
        $manager->persist($order);
        $manager->flush();

        // envoyer un mail récapitulatif au client
        // envoyer un mail d'information à l'admin (préparation de la commande)

        // gestion du stock produit en base de données

        return $this->render('payment/success.html.twig');
    }

    #[Route('/payment/{order}/cancel', name: 'cancel')]
    public function cancel(): Response
    {

        // vérifier qu'on vient bien de la page de paiemetn Stripe
        return $this->render('payment/cancel.html.twig');
    }
}
