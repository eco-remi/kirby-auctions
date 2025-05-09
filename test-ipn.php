<?php

require __DIR__ . '/../../../vendor/autoload.php';

require_once __DIR__ . '/spplus_config.php';

// Notification de la banque -> validation de l'order
$formToken = \Auction\Service\SpPlusPayment::instantPaymentNotification();

