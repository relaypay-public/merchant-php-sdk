<?php

namespace RelayPay\SDK\Api;

use GuzzleHttp\Psr7\Utils;
use RelayPay\Api\ECommerceApi;
use RelayPay\Api\TransactionsApi;
use RelayPay\ApiException;
use RelayPay\Model\EcommerceIncomingRequest;
use RelayPay\Model\EcommerceMerchantTransaction;
use RelayPay\Model\EcommerceResponse;
use RelayPay\Model\PageEcommerceMerchantTransaction;
use RelayPay\Model\TransactionRequest;
use RelayPay\SDK\Abstracts\ApiRequest;

/**
 * Class Transactions
 * @package RelayPay\SDK\Api
 * @property ECommerceApi $client
 */
class Transactions extends ApiRequest {
	/**
	 * @return PageEcommerceMerchantTransaction
	 * @throws ApiException
	 */
	public function getTransactions( $args = [] ) {
		$page = $args['page'] ?? 1;
		$size = $args['size'] ?? 20;

		$this->setAuthorizationHeader();

		return $this->getClient()->getMerchantTxs( $this->getCredentials()->getEmail(), $page, $size );
	}

	public function setAuthorizationHeader() {
		$this->getClient()->getConfig()->setApiKey( 'Authorization', $this->getCredentials()->getPublicKey() );
	}

	public function setSignHeader( $sign ) {
		$this->getClient()->getConfig()->setApiKey( 'Sign', $sign );
	}

	/**
	 * @return EcommerceResponse
	 * @throws ApiException
	 */
	public function createTransaction( $data ) {
		$data['merchantId'] = $data['merchantId'] ?? $this->getCredentials()->getEmail();

		$body               = new EcommerceIncomingRequest();

		foreach ( $data as $key => $value ) {
			$setter = sprintf( 'set%s', ucfirst( $key ) );
			if ( method_exists( $body, $setter ) ) {
				$body->$setter( $value );
			}
		}
		$this->setAuthorizationHeader();
		$data = Utils::streamFor( $body )->getContents();
		$sign = $this->generateSignature( $data );
		$this->setSignHeader( $sign );

		return $this->getClient()->setEcommerceRequest( $body, );
	}

	/**
	 * @return EcommerceMerchantTransaction
	 * @throws ApiException
	 */
	public function getTransaction( $orderId ) {
		$this->setAuthorizationHeader();

		return $this->getClient()->getMerchantTransaction( $this->getCredentials()->getEmail(), $orderId );
	}
}