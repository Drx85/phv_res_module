<?php

namespace App\Service\Payment;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

class PayPalClient

{
	private string $paypalId;
	private string $paypalSecret;
	
	public function __construct(string $paypalId, string $paypalSecret)
	{
		$this->paypalId = $paypalId;
		$this->paypalSecret = $paypalSecret;
	}
	
	/**
	 * Returns PayPal HTTP client instance with environment that has access
	 * credentials context. Use this instance to invoke PayPal APIs, provided the
	 * credentials have access.
	 */
	public function getClient(): PayPalHttpClient
	{
		return new PayPalHttpClient($this->environment());
	}
	
	/**
	 * Set up and return PayPal PHP SDK environment with PayPal access credentials.
	 * This sample uses SandboxEnvironment. In production, use LiveEnvironment.
	 */
	public function environment(): SandboxEnvironment
	{
		return new SandboxEnvironment($this->paypalId, $this->paypalSecret);
	}
}