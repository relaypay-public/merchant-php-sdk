<?php

namespace RelayPay\SDK;

class Credentials {
	private $publicKey;
	private $privateKey;
	private $email;

	public function __construct( string $public_key, string $private_key, string $email ) {
		$this->publicKey  = $public_key;
		$this->privateKey = $private_key;
		$this->email      = $email;
	}

	/**
	 * @return string
	 */
	public function getPublicKey(): string {
		return $this->publicKey;
	}

	/**
	 * @param  mixed  $publicKey
	 *
	 * @return Credentials
	 */
	public function setPublicKey( $publicKey ): Credentials {
		$this->publicKey = $publicKey;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPrivateKey(): string {
		return $this->privateKey;
	}

	/**
	 * @param $privateKey
	 *
	 * @return Credentials
	 */
	public function setPrivateKey( $privateKey ): Credentials {
		$this->privateKey = $privateKey;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getEmail(): string {
		return $this->email;
	}

	/**
	 * @param  string  $email
	 *
	 * @return Credentials
	 */
	public function setEmail( string $email ): Credentials {
		$this->email = $email;

		return $this;
	}

}