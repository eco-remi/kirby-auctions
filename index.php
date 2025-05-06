<?php

use Auction\Synchronizer;
use Kirby\Cms\App as Kirby;

Kirby::plugin('eco-remi/kirby-auctions', [
    'routes' => [
        [
            'pattern' => 'run-sync',
            'method' => 'GET',
            'action'  => function () {

                return Synchronizer::synchronize();
            }
        ]
    ]
]);
