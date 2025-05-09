<?php

namespace Auction\Entity;

use Auction\Service\HydrateStaticTrait;

class Order
{
    public ?string $id = null;
    public ?string $transactionUuid = null;
    public ?string $status = null;

    public int $amount = 0; // in cent of €
    public ?string $currency = 'EUR';
    public ?Customer $customer = null;

    /** @var OrderDetail[] */
    public ?array $orderDetails = [];

    public ?string $createdAt = null;
    public ?string $updatedAt = null;

    use HydrateStaticTrait;

    public function __construct()
    {
        $this->id = uniqid(date('Ymd') . '_');
        $this->createdAt = date('Y-m-d H:i:s');
        $this->status = 'NEW';
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): Order
    {
        $this->id = $id;
        return $this;
    }

    public function getTransactionUuid(): ?string
    {
        return $this->transactionUuid;
    }

    public function setTransactionUuid(?string $transactionUuid): Order
    {
        $this->transactionUuid = $transactionUuid;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): Order
    {
        $this->status = $status;
        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): Order
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param string|null $amount in cent <=> € * 100
     */
    public function setAmount(?string $amount): Order
    {
        $this->amount = $amount;
        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): Order
    {
        $this->currency = $currency;
        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer|array|null $customer): Order
    {
        if (is_array($customer)) {
            $customer = (new Customer())->hydrate($customer);
        }
        $this->customer = $customer;
        return $this;
    }

    public function getOrderDetails(): ?array
    {
        return $this->orderDetails;
    }

    public function setOrderDetails(?array $orderDetails): Order
    {
        $this->orderDetails = array_map(fn ($row) => (new OrderDetail())->hydrate($row), $orderDetails);

        return $this;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?string $updatedAt): Order
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getOrderTotal(): int
    {
        /**
         * Règle de calcul pour l'empreinte de l'ordre d'achat, si le montant indiqué par le client est :
         * < 100 € = empreinte de 100 €
         * < 5 000 € = empreinte de 20% de l'estimation basse
         * > 5 000 € = empreinte de 5 000 €
         */
        $this->amount = 0;
        foreach ($this->orderDetails as $orderDetail) {
            $this->amount += $orderDetail->amount;
        }

        if ($this->amount <= 10000) {
            $this->amount = 10000;
        } elseif ($this->amount <= 500000) {
            $this->amount = $this->amount * 0.2; // empreinte de 20% de l'estimation basse
        } else {
            $this->amount = 500000;
        }

        return $this->amount; // return amount in cent
    }
}
