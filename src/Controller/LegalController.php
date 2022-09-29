<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalController extends AbstractController
{
    #[Route('/mentions-legales', name: 'app_legal')]
    public function index(): Response
    {
        return $this->render('legal/mentionsLegales.html.twig', [
            'controller_name' => 'LegalController',
        ]);
    }
}
