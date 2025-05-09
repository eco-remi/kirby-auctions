<?php

namespace Auction\Entity;

use Auction\Service\HydrateStaticTrait;

class Product
{
    public ?string $id = null;
    public ?string $name = null;
    public ?string $saleId = null;
    public ?string $priceHighEstimate = null;
    public ?string $priceLowEstimate = null;
    public ?string $priceCustomEstimate = null;

    use HydrateStaticTrait;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): Product
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    public function getSaleId(): ?string
    {
        return $this->saleId;
    }

    public function setSaleId(?string $saleId): Product
    {
        $this->saleId = $saleId;
        return $this;
    }

    public function getPriceHighEstimate(): ?string
    {
        return $this->priceHighEstimate;
    }

    public function setPriceHighEstimate(?string $priceHighEstimate): Product
    {
        $this->priceHighEstimate = $priceHighEstimate;
        return $this;
    }

    public function getPriceLowEstimate(): ?string
    {
        return $this->priceLowEstimate;
    }

    public function setPriceLowEstimate(?string $priceLowEstimate): Product
    {
        $this->priceLowEstimate = $priceLowEstimate;
        return $this;
    }

    public function getPriceCustomEstimate(): ?string
    {
        return $this->priceCustomEstimate;
    }

    public function setPriceCustomEstimate(?string $priceCustomEstimate): Product
    {
        $this->priceCustomEstimate = $priceCustomEstimate;
        return $this;
    }
}
