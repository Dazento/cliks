<?php

namespace App\Entity;

use App\Repository\OrderDetailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderDetailRepository::class)]
class OrderDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'OrderDetails')]
    private ?Product $product = null;

    #[ORM\OneToMany(mappedBy: 'OrderDetail', targetEntity: Order::class)]
    private Collection $Orderid;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Order $orderid = null;

    #[ORM\Column]
    private ?int $quantity = null;

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
            $orderid->setOrderDetail($this);
        }

        return $this;
    }

    public function removeOrderid(Order $orderid): self
    {
        if ($this->Orderid->removeElement($orderid)) {
            // set the owning side to null (unless already changed)
            if ($orderid->getOrderDetail() === $this) {
                $orderid->setOrderDetail(null);
            }
        }

        return $this;
    }

    public function setOrderid(?Order $orderid): self
    {
        $this->orderid = $orderid;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
