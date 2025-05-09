<?php

namespace Auction\Service;

use Auction\Dto\Lot;
use Auction\Entity\Order;
use Auction\Entity\Product;

class FileDbService
{
    /**
     * @param int $idVente
     * @param Lot[] $incomingLots
     * @return void
     */
    public static function saveLotInProductFiles(int $idVente, array $incomingLots): void
    {
        // write local json version
        file_put_contents(__DIR__ . '/../../data/vente_' . $idVente . '_lots.json', json_encode($incomingLots, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        foreach ($incomingLots as $lot) {
            $product = (new Product())
                ->setId($lot->identifiant)
                ->setSaleId($idVente)
                ->setName(mb_substr($lot->description, 0, 64))
                ->setPriceHighEstimate($lot->estimation_haute)
                ->setPriceLowEstimate($lot->estimation_basse)
            ;
            file_put_contents(__DIR__ . '/../../data/product/' . $product->getId() . '.json', json_encode($product, JSON_UNESCAPED_SLASHES));
        }
    }

    public static function getProductById(string $identifier): ?Product
    {
        if (!file_exists(__DIR__ . '/../../data/product/' . $identifier . '.json')) {
            return null;
        }

        return (new Product())->hydrate(json_decode(file_get_contents(__DIR__ . '/../../data/product/' . $identifier . '.json'), true));
    }

    public static function saveOrderInFile(Order $order): void
    {
        file_put_contents(__DIR__ . '/../../data/order/' . $order->getId() . '.json', json_encode($order, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
    }

    public static function getOrderById(string $identifier): ?Order
    {
        if (!file_exists(__DIR__ . '/../../data/order/' . $identifier . '.json')) {
            return null;
        }

        return (new Order())->hydrate(json_decode(file_get_contents(__DIR__ . '/../../data/order/' . $identifier . '.json'), true));
    }
}
