<?php

namespace App\Tests\Controller;

use App\Entity\Quote\Quote;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{
	protected KernelBrowser $client;

	
	public function setUp(): void
	{
		$this->client = static::createClient();
	}
	
	public function testDisplayIndex()
	{
		$this->client->request('GET', '/');
		$this->assertResponseStatusCodeSame(Response::HTTP_OK);
		$this->assertSelectorTextContains('h3', "Demande de devis");
	}
	
/*	Should be END-TO-END tested
	public function testCreatePayment()
	{
		$quote = (new Quote())
		->setOriginLongitude('2.35059442767782')
		->setOriginLatitude('48.868227997121956')
		->setDestinationLatitude('48.8702804295734')
		->setDestinationLongitude('2.3294947231886405')
		->setTravelDistanceInKms(2)
		->setOriginAddress('12 Rue d\'Alexandrie, 75002 Paris, France')
		->setDestinationAddress('14 Bd des Capucines, 75009 Paris, France')
		->setFormattedTravelTime('11 minutes')
		->setPrice(20)
		->setDepartureTimestamp(1634830920);
		$this->client->getContainer()->get('session')->set('quote', $quote);
		$this->client->request('GET', '/create-paypal-transaction');
	}*/
}