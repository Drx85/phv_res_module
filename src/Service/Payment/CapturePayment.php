<?php

namespace App\Service\Payment;

use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalHttp\HttpResponse;

class CapturePayment
{
	private PayPalClient $client;
	
	public function __construct(PayPalClient $client)
	{
		$this->client = $client;
	}
	
	/**
	 *This function can be used to capture an order payment by passing the approved
	 *order ID as argument.
	 *
	 * @param string $orderId
	 *
	 * @return HttpResponse
	 */
	public function capture(string $orderId): HttpResponse
	{
		$request = new OrdersCaptureRequest($orderId);
		$client = $this->client->getClient();
		return $client->execute($request);
	}
}