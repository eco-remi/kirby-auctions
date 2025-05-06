<?php

namespace Auction;

use Auction\Dto\KirbyEntity;
use Auction\Dto\KirbyLot;
use Auction\Dto\Lot;
use Auction\Dto\Result;

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

        $result->count = count($incomingLots);

        $kirbyLots = [];
        foreach ($incomingLots as $lot) {
            $kirbyLots[] = KirbyLot::adapt($lot);
        }

        KirbyEntity::writeKirbyFormat($kirbyLots);

        $result->success = true;
        $result->message = 'Synchronized successfully';

        return $result;
    }
}
