<?php

use RelayPay\ApiException;
use RelayPay\SDK\RelayPay;

require_once '../vendor/autoload.php';

$rp = new RelayPay( 'YOUR_PUBLIC_KEY', 'YOUR_PRIVATE_KEY', 'YOUR_EMAIL' );
try {
	$transaction = $rp->ecommerce()->getTransaction(12345);
	die(var_dump($transaction));
} catch ( ApiException $e ) {
	die( var_dump( json_decode( $e->getResponseBody() ) ) );
}