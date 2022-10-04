<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductImageRepository;
use App\Repository\ProductRepository;
use MobileDetectBundle\DeviceDetector\MobileDetectorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RequestStack;
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

    #[Route('/show/{slug}', name: '_product')]
    public function product(Product $product, ProductImageRepository $productImageRepository): Response
    {

        $imageList = $productImageRepository->findBy(['product' => $product->getId()]);
        return $this->render('products/product.html.twig', [
            'controller_name' => 'ProductsController',
            'product' => $product,
            'imageList' => $imageList
        ]);
    }

    #[Route('/search', name: '_search')]
    public function searchResult(RequestStack $requestStack, ProductRepository $productRepository): Response
    {
        if (isset($requestStack->getCurrentRequest()->get('form')['search'])) {
            $searchedValue = $requestStack->getCurrentRequest()->get('form')['search'];
            if ($searchedValue) {
                $products = $productRepository->search($searchedValue);
            }
        } else {
            $searchedValue = null;
            $products = null;
        }

        return $this->render('products/searchResult.html.twig', [
            'searchedValue' => $searchedValue,
            'products' => $products
        ]);
    }

    public function searchBar(MobileDetectorInterface $mobileDetectorInterface): Response
    {
        $mobileDetectorInterface->isMobile();
        $mobileDetectorInterface->isTablet();

        $searchForm = $this->createFormBuilder()
            ->setAction($this->generateUrl('products_search'))
            ->add('search', TextType::class, [
                'label' => false,
                'attr' => [
                    'maxLength' => 50,
                    'placeholder' => 'Recherche'
                ]
            ])
            ->getForm();

        return $this->render('products/searchForm.html.twig', [
            'searchForm' => $searchForm->createView()
        ]);
    }
}
