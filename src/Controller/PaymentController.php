<?php

namespace App\Controller;

use App\Entity\Order;
use Stripe\StripeClient;
use App\Service\CartService;
use Symfony\Component\Mime\Address;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class PaymentController extends AbstractController
{
    #[Route('/payment/{order}', name: 'payment')]
    public function index(Request $request, Order $order, CartService $cartService): Response
    {
        // Vérifie si l'utilisateur arrive bien de la page de validation
        if ($request->headers->get('referer') !== $this->getParameter('domain') . '/cart/validation') {
            return $this->redirectToRoute('cart_validation');
        }

        // Récupère le panier et initialise le panier stripe
        $sessionCart = $cartService->getCart();
        $stripeCart = [];

        // Parcourt le panier pour ajouter les données au panier Stripe
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
        // Parametrage de la page d'achat Stripe
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
    public function success(Order $order, CartService $cartService, ManagerRegistry $managerRegistry, Request $request, MailerInterface $mailer): Response
    {
        // Vérifie si l'utilisateur arrive bien de la page stripe
        if ($request->headers->get('referer') !== 'https://checkout.stripe.com/') {
            return $this->redirectToRoute('cart_index');
        }
        
        // vide le panier et valide le paiement
        $manager = $managerRegistry->getManager();
        $cartService->clear();
        $order->setPaid(true);
        $manager->persist($order);
        $manager->flush();

        $details = $order->getOrderDetails();

        // Modifie le stock
        foreach ($details as $detail) {
            $product = $detail->getProduct();
            $product->setStock($product->getStock() - $detail->getQuantity());
            $manager->persist($product);
        }
        $manager->flush();

        // Parametrage de l'email
        $email = (new TemplatedEmail())
            ->from(new Address($this->getParameter('email'), 'Cliks'))
            ->to($order->getUser()->getEmail())
            ->subject('Votre commande a bien été pris en compte !')
            ->htmlTemplate('emails/succesEmail.html.twig')
            ->context([
                'order' => $order
            ]);

        // Envoie le mail
        $mailer->send($email);

        $this->addFlash('success', 'Un email de confirmation vous a été envoyé');
        // envoyer un mail d'information à l'admin (préparation de la commande)
        return $this->render('payment/success.html.twig');
    }

    #[Route('/payment/{order}/cancel', name: 'cancel')]
    public function cancel(Request $request): Response
    {
        // Vérifie si l'utilisateur arrive bien de la page stripe
        if ($request->headers->get('referer') !== 'https://checkout.stripe.com/') {
            return $this->redirectToRoute('cart_index');
        }
        return $this->render('payment/cancel.html.twig');
    }
}
