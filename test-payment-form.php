<?php

use Auction\Service\FileDbService;
use Auction\Service\SpPlusPayment;

require __DIR__ . '/../../../vendor/autoload.php';

require_once __DIR__ . '/spplus_config.php';

$order = FileDbService::getOrderById('demo-order');
$formToken = SpPlusPayment::getPayButton($order);

include_once __DIR__ . '/snippets/pay-form.html.php';
