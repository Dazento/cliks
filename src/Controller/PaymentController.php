<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/payment/{order}', name: 'payment')]
    public function index(Request $request, Order $order): Response
    {
        if ($request->headers->get('referer') !== 'https://127.0.0.1:8004/cart/validation') {
            return $this->redirectToRoute('cart');
        }


        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }
}
