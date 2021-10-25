<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerFormTest extends WebTestCase
{
	protected KernelBrowser $client;
	protected $form;
	
	private string $origin = '14 Boulevard des Capucines, Paris, France';
	private string $destination = '12 Rue d\'Alexandrie, Paris, France';
	private string $originPlaceId = 'ChIJCwrwLhdu5kcRqYng8fbmN1w';
	private string $destinationPlaceId = 'ChIJJR5pQzFu5kcRB_02A7c-h9E';
	private string $departureTime = '2121-10-26T15:00:00';
	private string $name = 'test';
	private string $email = 'test@test.fr';
	private string $phoneNumber = '0164101258';
	
	public function setUp(): void
	{
		$this->client = static::createClient();
	}
	
	public function testSuccessfulCreateQuote()
	{
		$this->createAndSubmitForm();
		$this->assertResponseStatusCodeSame(Response::HTTP_OK);
		$this->assertSelectorNotExists('.text-red-600');
		$this->assertSelectorTextContains('h3', "Devis");
		$this->assertIsObject($this->getContainer()->get('session')->get('quote'));
	}
	
	public function testBlankOrigin()
	{
		$this->origin = '';
		$this->assertBadForm422();
	}
	
	public function testBlankOriginPlaceId()
	{
		$this->originPlaceId = '';
		$this->assertBadForm422();
	}
	
	public function testWrongOriginPlaceId()
	{
		$this->originPlaceId = 'wrong-id';
		$this->assertBadForm500();
	}
	
	public function testBlankDestination()
	{
		$this->destination = '';
		$this->assertBadForm422();
	}
	
	public function testBlankDestinationPlaceId()
	{
		$this->destinationPlaceId = '';
		$this->assertBadForm422();
	}
	
	public function testWrongDestinationPlaceId()
	{
		$this->destinationPlaceId = 'wrong-id';
		$this->assertBadForm500();
	}
	
	public function testSameOriginAndDestination()
	{
		$this->destinationPlaceId = 'ChIJCwrwLhdu5kcRqYng8fbmN1w';
		$this->assertBadForm422();
	}
	
	public function testBlankDepartureDateTime()
	{
		$this->departureTime = '';
		$this->assertBadForm422();
	}
	
	public function testInvalidPastDepartureDateTime()
	{
		$this->departureTime = '2021-10-24T15:00:00';
		$this->assertBadForm422();
	}
	
	public function testBlankName()
	{
		$this->name = '';
		$this->assertBadForm422();
	}
	
	public function testBlankEmail()
	{
		$this->email = '';
		$this->assertBadForm422();
	}
	
	public function testBlankPhoneNumber()
	{
		$this->phoneNumber = '';
		$this->assertBadForm422();
	}
	
	public function testInvalidPhoneNumber()
	{
		$this->phoneNumber = 'wrong-phone';
		$this->assertBadForm422();
	}
	
	private function createAndSubmitForm()
	{
		$crawler = $this->client->request('GET', '/');
		$this->form = $crawler->selectButton('Suivant')->form([
			'ask_quote[origin]' => $this->origin,
			'ask_quote[destination]' => $this->destination,
			'ask_quote[originPlaceId]' => $this->originPlaceId,
			'ask_quote[destinationPlaceId]' => $this->destinationPlaceId,
			'ask_quote[departureDateTime]' => $this->departureTime,
			'ask_quote[name]' => $this->name,
			'ask_quote[email]' => $this->email,
			'ask_quote[phoneNumber]' => $this->phoneNumber
		]);
		$this->client->submit($this->form);
	}
	
	private function assertBadForm422()
	{
		$this->createAndSubmitForm();
		$this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
		$this->assertSelectorExists('.text-red-600');
	}
	
	private function assertBadForm500()
	{
		$this->createAndSubmitForm();
		$this->assertResponseStatusCodeSame(Response::HTTP_INTERNAL_SERVER_ERROR);
		$this->assertSelectorTextContains('title', "Erreur lors de l'appel aux services Google.");
	}
}