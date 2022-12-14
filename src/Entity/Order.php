<?php

namespace App\Entity;

use App\Entity\OrderDetail;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderRepository;
use App\Entity\Trait\CreatedAtTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $reference = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserAdress $deliveryAdress = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserAdress $billingAdress = null;

    #[ORM\Column]
    private ?int $Amount = null;

    #[ORM\Column]
    private ?bool $paid = null;

    #[ORM\OneToMany(mappedBy: 'orderid', targetEntity: OrderDetail::class, orphanRemoval: true)]
    private Collection $orderDetails;


    public function __construct()
    {
        $this->orderDetails = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

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
     * @return Collection<int, OrderDetail>
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetail $orderDetail): self
    {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails->add($orderDetail);
            $orderDetail->setOrderid($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetail $orderDetail): self
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            $orderDetail->setOrderid(null);
        }

        return $this;
    }

    public function getDeliveryAdress(): ?UserAdress
    {
        return $this->deliveryAdress;
    }

    public function setDeliveryAdress(?UserAdress $deliveryAdress): self
    {
        $this->deliveryAdress = $deliveryAdress;

        return $this;
    }

    public function getBillingAdress(): ?UserAdress
    {
        return $this->billingAdress;
    }

    public function setBillingAdress(?UserAdress $billingAdress): self
    {
        $this->billingAdress = $billingAdress;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->Amount;
    }

    public function setAmount(int $Amount): self
    {
        $this->Amount = $Amount;

        return $this;
    }

    public function isPaid(): ?bool
    {
        return $this->paid;
    }

    public function setPaid(bool $paid): self
    {
        $this->paid = $paid;

        return $this;
    }
}
