<?php

namespace Auction\Entity;

use Auction\Service\HydrateStaticTrait;

class Customer
{
    use HydrateStaticTrait;

    public ?string $email = null; //sample@example.com',
    public ?string $reference = null; //' => uniqid('customer_'),

    public ?string $language = 'fr';
    public ?string $title = null;
    public ?string $firstName = null;
    public ?string $lastName = null;
    public ?string $category = 'PRIVATE';
    public ?string $address = null;
    public ?string $zipCode = null;
    public ?string $city = null;
    public ?string $phoneNumber = null;
    public ?string $country = 'FR'; //FR'

    public function __construct()
    {
        $this->reference = uniqid('customer_');
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): Customer
    {
        $this->email = $email;
        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): Customer
    {
        $this->reference = $reference;
        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): Customer
    {
        $this->language = $language;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Customer
    {
        $this->title = $title;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): Customer
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): Customer
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): Customer
    {
        $this->category = $category;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): Customer
    {
        $this->address = $address;
        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): Customer
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): Customer
    {
        $this->city = $city;
        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): Customer
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): Customer
    {
        $this->country = $country;
        return $this;
    }
}
