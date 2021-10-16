<?php

namespace App\Service\Payment;

use JetBrains\PhpStorm\ArrayShape;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalHttp\HttpResponse;

class CreatePayment
{
	private PayPalClient $client;
	
	public function __construct(PayPalClient $client)
	{
		$this->client = $client;
	}
	/**
	 *This is the sample function to create an order. It uses the
	 *JSON body returned by buildRequestBody() to create an order.
	 */
	public function create(float $amount): HttpResponse
	{
		$request = new OrdersCreateRequest();
		$request->prefer('return=representation');
		$request->body = self::buildRequestBody($amount);
		// Call PayPal to set up a transaction
		$client = $this->client->getClient();
		return $client->execute($request);
	}
	
	/**
	 * Setting up the JSON request body for creating the order with minimum request body. The intent in the
	 * request body should be "AUTHORIZE" for authorize intent flow.	 *
	 */
	#[ArrayShape(['intent' => "string", 'application_context' => "string[]", 'purchase_units' => "\array[][]"])]
	private static function buildRequestBody(float $amount): array
	{
		return array(
			'intent' => 'CAPTURE',
			'application_context' =>
				array(
					'return_url' => 'https://example.com/return',
					'cancel_url' => 'https://example.com/cancel'
				),
			'purchase_units' =>
				array(
					0 =>
						array(
							'amount' =>
								array(
									'currency_code' => 'EUR',
									'value' => $amount
								)
						)
				)
		);
	}
}