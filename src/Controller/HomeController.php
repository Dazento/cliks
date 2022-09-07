<?php

namespace App\Controller;

use App\Entity\ProductImage;
use App\Repository\ProductImageRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProductRepository $productRepository, ProductImageRepository $productImageRepository): Response
    {
        $productList = $productRepository->findFourClavierByAsc(['active' => 1]);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'productList' => $productList,
        ]);
    }
}
