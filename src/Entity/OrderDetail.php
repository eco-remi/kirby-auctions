<?php

namespace Auction\Entity;

use Auction\Service\HydrateStaticTrait;

class OrderDetail
{
    public ?string $reference = null;
    public int $amount = 0; // in cent of €
    public ?string $label = null;
    public int $qty = 1;

    use HydrateStaticTrait;

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): OrderDetail
    {
        $this->reference = $reference;
        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): OrderDetail
    {
        $this->amount = $amount;
        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): OrderDetail
    {
        $this->label = $label;
        return $this;
    }

    public function getQty(): int
    {
        return $this->qty;
    }

    public function setQty(int $qty): OrderDetail
    {
        $this->qty = $qty;
        return $this;
    }
}
