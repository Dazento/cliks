<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/legale', name: 'legal_')]
class LegalController extends AbstractController
{
    
    #[Route('/mentions-legales', name: 'mention')]
    public function index(): Response
    {
        return $this->render('legal/mentionsLegales.html.twig', [
            'controller_name' => 'LegalController',
        ]);
    }

    #[Route('/cgv-cgu', name: 'cgv')]
    public function cgv(): Response
    {
        return $this->render('legal/cgv.html.twig', [
            'controller_name' => 'LegalController',
        ]);
    }
}