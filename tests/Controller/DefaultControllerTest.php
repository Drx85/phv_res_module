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
	
	public function testEndToEndAskQuote()
	{
		$client = static::createPantherClient();
		$client->request('GET', '/');
		$client->getWebDriver()->findElement(WebDriverBy::name('ask_quote[origin]'))->sendKeys('12 rue');
		usleep(400000);
		$client->getWebDriver()->findElement(WebDriverBy::name('ask_quote[origin]'))->sendKeys(WebDriverKeys::ARROW_DOWN)->sendKeys(WebDriverKeys::ENTER);
		$client->getWebDriver()->findElement(WebDriverBy::name('ask_quote[destination]'))->sendKeys('14 rue');
		usleep(400000);
		$client->getWebDriver()->findElement(WebDriverBy::name('ask_quote[destination]'))->sendKeys(WebDriverKeys::ARROW_DOWN)->sendKeys(WebDriverKeys::ENTER);
		$client->getWebDriver()->findElement(WebDriverBy::name('ask_quote[departureDateTime]'))->sendKeys('26100021210000');
		$client->getWebDriver()->findElement(WebDriverBy::name('ask_quote[name]'))->sendKeys('test');
		$client->getWebDriver()->findElement(WebDriverBy::name('ask_quote[email]'))->sendKeys('test@test.fr');
		$client->getWebDriver()->findElement(WebDriverBy::name('ask_quote[phoneNumber]'))->sendKeys('0164101258');
		$client->getWebDriver()->findElement(WebDriverBy::name('ask_quote[validate]'))->click();
		$client->waitFor('/html/body/div[1]/div[1]/div[1]/h3', 1);
		$this->assertSelectorNotExists('.text-red-600');
		$this->assertSelectorTextContains('h3', "Devis");
	}
}