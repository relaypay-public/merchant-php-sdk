<?php

namespace RelayPay\SDK\Api;

use GuzzleHttp\Psr7\Utils;
use RelayPay\Api\ECommerceApi;
use RelayPay\ApiException;
use RelayPay\Model\EcommerceIncomingRequest;
use RelayPay\Model\EcommerceMerchantTransaction;
use RelayPay\Model\EcommerceResponse;
use RelayPay\Model\PageEcommerceMerchantTransaction;
use RelayPay\SDK\Abstracts\ApiRequest;

/**
 * Class Transactions
 *
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

		return $this->getClient()->getMerchantTxs( $this->getCredentials()->getPublicKey(), $this->getCredentials()->getEmail(), $page, $size );
	}

	public function setAuthorizationHeader() {
		$this->getClient()->getConfig()->setApiKey( 'Authorization', $this->getCredentials()->getPublicKey() );
	}

	public function setSignHeader( $sign ) {
		$this->getClient()->getConfig()->setApiKey( 'Sign', $sign );
	}

	/**
	 * @param $data
	 *
	 * @return EcommerceResponse
	 * @throws ApiException
	 */
	public function createTransaction( $data ): EcommerceResponse {
		$body = $this->getEcommerceIncomingRequest( $data );
		$sign = $this->generateSignature( $this->getEcommerceIncomingRequestData( $body ) );

		return $this->getClient()->setEcommerceRequest( $this->getCredentials()->getPublicKey(), $this->getCredentials()->getEmail(), $sign, $body );
	}

	/**
	 * @param $data
	 *
	 * @return EcommerceIncomingRequest
	 */
	public function getEcommerceIncomingRequest( $data ): EcommerceIncomingRequest {
		$data['merchantId'] = $data['merchantId'] ?? $this->getCredentials()->getEmail();

		$body = new EcommerceIncomingRequest();

		foreach ( $data as $key => $value ) {
			$setter = sprintf( 'set%s', ucfirst( $key ) );
			if ( method_exists( $body, $setter ) ) {
				$body->$setter( $value );
			}
		}

		return $body;
	}

	/**
	 * Pass args to this method to get the sign with added args
	 *
	 * @param array $data
	 *
	 * @return false|string
	 */
	public function getSignForRequest( array $data ) {
		$body = $this->getEcommerceIncomingRequest( $data );

		return $this->generateSignature( $this->getEcommerceIncomingRequestData( $body ) );
	}

	/**
	 * @param EcommerceIncomingRequest $request
	 *
	 * @return string
	 */
	public function getEcommerceIncomingRequestData( EcommerceIncomingRequest $request ): string {
		return Utils::streamFor( $request )->getContents();
	}

	/**
	 * @return EcommerceMerchantTransaction
	 * @throws ApiException
	 */
	public function getTransaction( $orderId ) {
		return $this->getClient()->getMerchantTransaction( $this->getCredentials()->getPublicKey(), $this->getCredentials()->getEmail(), $orderId );
	}
}