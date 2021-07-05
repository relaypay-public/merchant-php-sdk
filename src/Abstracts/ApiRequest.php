<?php

namespace RelayPay\SDK\Abstracts;

use RelayPay\Api\ECommerceApi;
use RelayPay\SDK\Credentials;
use RelayPay\SDK\Client;
use RelayPay\SDK\Exceptions\ApiException;

abstract class ApiRequest {
	private $client;
	private Credentials $credentials;
	const API_VERSION = 1;

	public function __construct( Credentials $apiKeys, $client ) {
		$this->client      = $client;
		$this->credentials = $apiKeys;
	}

	/**
	 * @return ECommerceApi
	 */
	public function getClient() {
		return $this->client;
	}

	/**
	 * @return Credentials
	 */
	public function getCredentials(): Credentials {
		return $this->credentials;
	}

	public function getRequestUrl( $endpoint ) {
		return 'api/v' . $this::API_VERSION . '/' . $endpoint;
	}

	public function generateSignature(  string $data = '' ) {
		return hash( 'sha256',  $data . $this->getCredentials()->getPrivateKey() );
	}

	public function validateSignature( $data, $signature ) {
		return $this->generateSignature( $data ) === $signature;
	}
}