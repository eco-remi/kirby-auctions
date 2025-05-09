<?php

use Auction\Service\OrderFactory;

require __DIR__ . '/../../../vendor/autoload.php';

$_POST = [
    'firstname' => 'John',
    'lastname' => 'Doe',
    'email' => 'john@doe.com',
    'phone' => '0123456789',
    'address' => 'test address',
    'city' => 'test city',
    'zipcode' => '73000',
    'vente' => 'Vente N° 9',
    'lots' => [
        '09-73001-202405071446440013-0011',
        '09-73001-202405071446440011-0009',
    ]
];

OrderFactory::processForm($_POST);

