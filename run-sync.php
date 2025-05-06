<?php

use Auction\Synchronizer;

require __DIR__ . '/../../../vendor/autoload.php';

$result = Synchronizer::synchronize();

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result);
