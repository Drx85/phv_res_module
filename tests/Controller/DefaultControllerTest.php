<?php

namespace App\Tests\Controller;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Panther\PantherTestCase;

class DefaultControllerTest extends PantherTestCase
{
	public function testDisplayIndex()
	{
		$client = static::createClient();
		$client->request('GET', '/');
		$this->assertResponseStatusCodeSame(Response::HTTP_OK);
		$this->assertSelectorTextContains('h3', "Demande de devis");
	}
	
	public function testFromAskQuoteToPaymentSuccess()
	{
		$client = static::createPantherClient();
		$client->request('GET', '/');
		$driver = $client->getWebDriver();
		$driver->findElement(WebDriverBy::name('ask_quote[origin]'))->sendKeys('12 rue');
		usleep(400000);
		$driver->findElement(WebDriverBy::name('ask_quote[origin]'))->sendKeys(WebDriverKeys::ARROW_DOWN)->sendKeys(WebDriverKeys::ENTER);
		$driver->findElement(WebDriverBy::name('ask_quote[destination]'))->sendKeys('14 rue');
		usleep(400000);
		$driver->findElement(WebDriverBy::name('ask_quote[destination]'))->sendKeys(WebDriverKeys::ARROW_DOWN)->sendKeys(WebDriverKeys::ENTER);
		$driver->findElement(WebDriverBy::name('ask_quote[departureDateTime]'))->sendKeys('26100020370000');
		$driver->findElement(WebDriverBy::name('ask_quote[name]'))->sendKeys('test');
		$driver->findElement(WebDriverBy::name('ask_quote[email]'))->sendKeys('test@test.fr');
		$driver->findElement(WebDriverBy::name('ask_quote[phoneNumber]'))->sendKeys('0164101258');
		$driver->findElement(WebDriverBy::name('ask_quote[validate]'))->click();
		$client->waitFor('#quote', 2);
		$this->assertSelectorNotExists('.text-red-600');
		$this->assertSelectorTextContains('h3', "Devis");
		$driver->switchTo()->frame(1);
		$client->waitFor('.paypal-button-number-0', 3);
		$driver->findElement(WebDriverBy::className('paypal-button-number-0'))->click();
		usleep(700000);
		$driver->findElement(WebDriverBy::className('paypal-button-number-0'))->click();
		$wHandle = $driver->getWindowHandles();
		$client->switchTo()->window($wHandle[1]);
		$client->waitFor('#email', 5);
		$buyerEmail = $this->getContainer()->getParameter('app.paypal_buyer_email');
		$driver->findElement(WebDriverBy::id('email'))->sendKeys($buyerEmail);
		$driver->findElement(WebDriverBy::id('btnNext'))->click();
		$buyerPassword = $this->getContainer()->getParameter('app.paypal_buyer_password');
		$client->waitFor('#password', 2);
		usleep(900000);
		$driver->findElement(WebDriverBy::id('password'))->sendKeys($buyerPassword);
		$driver->findElement(WebDriverBy::id('btnLogin'))->click();
		$client->waitFor('#payment-submit-btn', 7);
		usleep(700000);
		$driver->manage()->window()->maximize();
		$driver->getKeyboard()->sendKeys(WebDriverKeys::END);
		usleep(200000);
		$driver->findElement(WebDriverBy::id('payment-submit-btn'))->click();
		usleep(700000);
		$driver->findElement(WebDriverBy::id('payment-submit-btn'))->click();
		$client->switchTo()->window($wHandle[0]);
		$client->waitFor('.text-4xl', 10);
		$this->assertSelectorTextContains('div', "Réservation confirmée");
	}
}
