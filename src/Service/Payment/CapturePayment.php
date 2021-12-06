<?php

namespace App\Service\Payment;

use App\Entity\Order;
use App\Entity\Quote\Prospect;
use App\Entity\Quote\Quote;
use Doctrine\ORM\EntityManagerInterface;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalHttp\HttpResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CapturePayment
{
	public function __construct(
		private PayPalClient           $client,
		private SessionInterface       $session,
		private EntityManagerInterface $manager
	) {
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
		try {
			$request = new OrdersCaptureRequest($orderId);
			$client = $this->client->getClient();
			$response = $client->execute($request);
			$this->createOrder($response->result->id);
			//TODO: Send confirmation email to the client with reservation reference
			//TODO: Send email to the PHV driver with reservation details
			return $response;
		} catch (\Exception $exc) {
			return new HttpResponse($exc->getCode(), $exc->getMessage(), $request->headers);
		}
	}
	
	/**
	 * Create final Order entity and save it in Database
	 *
	 * @param string $orderId
	 */
	private function createOrder(string $orderId): void
	{
		/** @var Quote $quote */$quote = $this->session->get('quote');
		/** @var Prospect $client */$client = $this->session->get('prospect');
		$order = new Order();
		$order->setOriginAddress($quote->getOriginAddress())
			->setDestinationAddress($quote->getDestinationAddress())
			->setTravelDistanceInKm($quote->getTravelDistanceInKms())
			->setFormattedTravelTime($quote->getFormattedTravelTime())
			->setPrice($quote->getPrice())
			->setDepartureTimestamp($quote->getDepartureTimestamp())
			->setClientName($client->getName())
			->setClientEmail($client->getEmail())
			->setClientPhoneNumber($client->getPhoneNumber())
			->setPaypalOrderId($orderId);
		$this->manager->persist($order);
		$this->manager->flush();
	}
}
