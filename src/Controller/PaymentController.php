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
        if ($request->headers->get('referer') !== $this->getParameter('domain') . '/cart/validation') {
            return $this->redirectToRoute('cart_validation');
        }

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
                            $this->getParameter('domain') . '/assets/img/product/mainImg/' . $cartElement['product']->getMainImage(),
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
            'success_url' => $this->getParameter('domain') . '/payment/' . $order->getId() . '/success',
            'cancel_url' => $this->getParameter('domain') . '/payment/cancel',
            'payment_method_types' => ['card']
        ]);

        return $this->render('payment/index.html.twig', [
            'sessionId' => $stripeSession->id
        ]);
    }

    #[Route('/payment/{order}/success', name: 'success')]
    public function success(Order $order, CartService $cartService, ManagerRegistry $managerRegistry, Request $request): Response
    {
        if ($request->headers->get('referer') !== 'https://checkout.stripe.com/') {
            return $this->redirectToRoute('cart_index');
        }

        $manager = $managerRegistry->getManager();
        $cartService->clear();
        $order->setPaid(true);
        $manager->persist($order);
        $manager->flush();

        $details = $order->getOrderDetails();

        foreach ($details as $detail) {
            $product = $detail->getProduct();
            $product->setStock($product->getStock() - $detail->getQuantity());
            $manager->persist($product);
        }

        $manager->flush();

        // envoyer un mail récapitulatif au client
        // envoyer un mail d'information à l'admin (préparation de la commande)

        return $this->render('payment/success.html.twig');
    }

    #[Route('/payment/{order}/cancel', name: 'cancel')]
    public function cancel(): Response
    {
        // vérifier qu'on vient bien de la page de paiemetn Stripe
        return $this->render('payment/cancel.html.twig');
    }
}
