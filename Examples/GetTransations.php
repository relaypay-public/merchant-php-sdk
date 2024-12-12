<?php

use RelayPay\ApiException;
use RelayPay\SDK\RelayPay;

require_once '../vendor/autoload.php';

$rp = new RelayPay( 'YOUR_PUBLIC_KEY', 'YOUR_PRIVATE_KEY', 'YOUR_EMAIL' );
try {
	$transactions = $rp->ecommerce()->getTransactions();
	die( var_dump( $transactions ) );
} catch ( ApiException $e ) {
	die( var_dump( json_decode( $e->getResponseBody() ) ) );
}