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
    public function success(Order $order, CartService $cartService, ManagerRegistry $managerRegistry, Request $request, MailerInterface $mailer): Response
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

        $email = (new TemplatedEmail())
            ->from(new Address($this->getParameter('email'), 'Cliks'))
            ->to($order->getUser()->getEmail())
            ->subject('Votre commande a bien été pris en compte !')
            ->htmlTemplate('emails/succesEmail.html.twig')
            ->context([
                'order' => $order
            ]);
        $mailer->send($email);
        $this->addFlash('success', 'Un email de confirmation vous a été envoyé');

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
