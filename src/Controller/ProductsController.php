<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produits', name: 'products')]
class ProductsController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function index(ProductRepository $productRepository,): Response
    {

        $productList = $productRepository->findAll();
        return $this->render('products/index.html.twig', [
            'controller_name' => 'ProductsController',
            'productList' => $productList
        ]);
    }

    #[Route('/{slug}', name: '_product')]
    public function product(Product $product): Response
    {

        return $this->render('products/product.html.twig', [
            'controller_name' => 'ProductsController',
            'product' => $product
        ]);
    }
}
