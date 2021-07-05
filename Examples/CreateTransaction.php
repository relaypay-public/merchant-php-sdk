<?php

use RelayPay\SDK\RelayPay;

require_once '../vendor/autoload.php';

$rp = new RelayPay( 'YOUR_PUBLIC_KEY', 'YOUR_PRIVATE_KEY', 'YOUR_EMAIL' );
try {
	$data        = [
		'amount'        => 42.87,
		'customerName'  => 'Jacob',
		'customerEmail' => 'info@gmail.com',
		'storeName'     => 'Store24',
		'currency'      => 'AUD',
		'orderId'       => 222333,
	];
	$transaction = $rp->ecommerce()->createTransaction( $data );
	die( var_dump( $transaction ) );
} catch ( \RelayPay\ApiException $e ) {
	die( var_dump( json_decode( $e->getResponseBody() ) ) );
}