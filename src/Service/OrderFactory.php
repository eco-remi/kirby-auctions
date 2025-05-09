<?php

namespace Auction\Service;

use Auction\Entity\Customer;
use Auction\Entity\Order;
use Auction\Entity\OrderDetail;
use Auction\Entity\Product;
use Kirby\Exception\Exception;

class OrderFactory
{
    public static function processForm(array $data = []): void
    {
        $customer = (new Customer())
            ->setEmail($data['email'] ?? '')
            ->setLastName($data['lastname'] ?? '')
            ->setFirstName($data['firstname'] ?? '')
            ->setAddress($data['address'] ?? '')
            ->setCity($data['city'] ?? '')
            ->setZipCode($data['zipcode'] ?? '')
            ->setPhoneNumber($data['phone'] ?? '')
        ;
        $order = (new Order())
            ->setCustomer($customer)
        ;

        if (!empty($data['lots'])) {
            foreach ($data['lots'] as $lot) {
                $product = FileDbService::getProductById($lot);
                if (!$product) {
                    $product = new Product();
                }

                $order->orderDetails[] = (new OrderDetail())
                    ->setReference($lot)
                    ->setLabel($product->name)
                    ->setAmount($product->priceLowEstimate * 100)
                ;
            }
        }
        $order->getOrderTotal();

        FileDbService::saveOrderInFile($order);
    }

    public static function adaptFromBankAnswer(array $answer): Order
    {
        $order = FileDbService::getOrderById($answer['orderDetails']['orderId']);
        if (!$order) {
            $order = (new Order())
                ->setId($answer['orderDetails']['orderId']);
        }
        // update status
        $order
            ->setUpdatedAt(date('Y-m-d H:i:s'))
            ->setTransactionUuid($answer['transactions'][0]['uuid'] ?? null)
            ->setStatus($answer['orderStatus']);

        // save in File mode
        FileDbService::saveOrderInFile($order);

        return $order;
    }
}
