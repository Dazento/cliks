<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $user = null;


    public function __construct()
    {
        $this->orderedProducts = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, OrderedProduct>
     */
    public function getOrderedProducts(): Collection
    {
        return $this->orderedProducts;
    }

    public function addOrderedProduct(OrderedProduct $orderedProduct): self
    {
        if (!$this->orderedProducts->contains($orderedProduct)) {
            $this->orderedProducts->add($orderedProduct);
            $orderedProduct->addOrderid($this);
        }

        return $this;
    }

    public function removeOrderedProduct(OrderedProduct $orderedProduct): self
    {
        if ($this->orderedProducts->removeElement($orderedProduct)) {
            $orderedProduct->removeOrderid($this);
        }

        return $this;
    }

    public function getOrderedProduct(): ?OrderedProduct
    {
        return $this->orderedProduct;
    }

    public function setOrderedProduct(?OrderedProduct $orderedProduct): self
    {
        $this->orderedProduct = $orderedProduct;

        return $this;
    }
}
