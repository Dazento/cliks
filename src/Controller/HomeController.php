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
    public function index(ProductRepository $productRepository): Response
    {
        $productList = $productRepository->findFourClavierByDesc();
        $keycapsList = $productRepository->findFourKeycapsByDesc();
        $switchList = $productRepository->findFourSwitchByDesc();
        return $this->render('home/index.html.twig', [
            'productList' => $productList,
            'keycapsList' => $keycapsList,
            'switchList' => $switchList,
        ]);
    }
}
