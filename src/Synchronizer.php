<?php

namespace Auction;

use Auction\Dto\KirbyEntity;
use Auction\Dto\KirbyLot;
use Auction\Dto\Lot;
use Auction\Dto\Result;
use Auction\Service\FileDbService;

class Synchronizer
{
    public static function synchronize(): Result
    {
        $result = new Result();
        $incomingLots = Lot::getIncomingData();

        if (empty($incomingLots)) {
            $result->message = 'Incoming lots not found';
            return $result;
        }

        $idVente = 6; // todo : get last count
        FileDbService::saveLotInProductFiles($idVente, $incomingLots);

        $result->count = count($incomingLots);

        /** @var KirbyLot[] $kirbyLots */
        $kirbyLots = [];
        foreach ($incomingLots as $lot) {
            $kirbyLots[] = KirbyLot::adapt($lot);
        }

        KirbyEntity::writeKirbyFormat($kirbyLots, $idVente);

        $result->success = true;
        $result->message = 'Synchronized successfully';

        return $result;
    }
}
