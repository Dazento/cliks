<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
  protected $requestStack;
  protected $productRepository;

  public function __construct(ProductRepository $productRepository, RequestStack $requestStack)
  {
    $this->requestStack = $requestStack;
    $this->productRepository = $productRepository;
  }

  public function add(int $id)
  {
    $cart = $this->requestStack->getSession()->get('cart', []);
    if (!empty($cart[$id])) {
      $cart[$id]++;
    } else {
      $cart[$id] = 1;
    }

    $this->requestStack->getSession()->set('cart', $cart);
  }

  public function remove(int $id)
  {
    $cart = $this->requestStack->getSession()->get('cart', []);

    if (!empty($cart[$id])) {
      if ($cart[$id] > 1) {
        $cart[$id]--;
      } else {
        unset($cart[$id]);
      }
    }

    $this->requestStack->getSession()->set('cart', $cart);
  }

  public function delete(int $id)
  {
    $cart = $this->requestStack->getSession()->get('cart', []);

    if (!empty($cart[$id])) {
      unset($cart[$id]);
    }
    $this->requestStack->getSession()->set('cart', $cart);
  }

  public function getCart(): array
  {
    $cart = $this->requestStack->getSession()->get('cart', []);


    $cartData = [];

    foreach ($cart as $id => $quantity) {
      $product = $this->productRepository->find($id);
      $cartData[] = [
        'product' => $product,
        'quantity' => $quantity
      ];
    }
    return $cartData;
  }

  public function getTotal(): float
  {
    $cart = $this->requestStack->getSession()->get('cart', []);
    $total = 0;
    foreach ($cart as $id => $quantity) {
      $product = $this->productRepository->find($id);
      $total += $product->getPrice() * $quantity;
    }

    return $total;
  }

  public function clear()
  {
    $this->requestStack->getSession()->remove(('cart'));
  }

  public function getNbProducts(): int
  {
    $cart = $this->requestStack->getSession()->get('cart', []);
    $nb = 0;
    foreach ($cart as $id => $quantity) {
      $nb += $quantity;
    }
    return $nb;
  }
}
