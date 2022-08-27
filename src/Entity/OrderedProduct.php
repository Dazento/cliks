<?php

namespace App\Entity;

use App\Repository\OrderedProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderedProductRepository::class)]
class OrderedProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderedProducts')]
    private ?Product $product = null;

    #[ORM\OneToMany(mappedBy: 'orderedProduct', targetEntity: Order::class)]
    private Collection $Orderid;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Order $orderid = null;

    public function __construct()
    {
        $this->Orderid = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrderid(): Collection
    {
        return $this->Orderid;
    }

    public function addOrderid(Order $orderid): self
    {
        if (!$this->Orderid->contains($orderid)) {
            $this->Orderid->add($orderid);
            $orderid->setOrderedProduct($this);
        }

        return $this;
    }

    public function removeOrderid(Order $orderid): self
    {
        if ($this->Orderid->removeElement($orderid)) {
            // set the owning side to null (unless already changed)
            if ($orderid->getOrderedProduct() === $this) {
                $orderid->setOrderedProduct(null);
            }
        }

        return $this;
    }

    public function setOrderid(?Order $orderid): self
    {
        $this->orderid = $orderid;

        return $this;
    }
}
