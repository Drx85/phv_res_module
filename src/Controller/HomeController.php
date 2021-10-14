<?php

namespace App\Controller;

use App\Service\QuoteGenerator;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
	private HttpClientInterface $client;
	
	public function __construct(HttpClientInterface $client)
	{
		$this->client = $client;
	}
	
	#[Route('/', name: 'home')]
	public function index()
	{
		return $this->render('home.html.twig');
	}
	
	#[Route('/quote/{origin}/{destination}', name: 'quote')]
	public function quote(SessionInterface $session, $origin, $destination, QuoteGenerator $quoteGenerator)
	{
		if ($origin === $destination) {
			$this->addFlash("warning", "L'origine et la destination ne peuvent pas être identiques");
			return $this->redirectToRoute('home');
		}
		$apiResponse = $this->client->request(
			'GET',
			'https://maps.googleapis.com/maps/api/directions/json', [
				'query' => [
					'origin'      => 'place_id:' . $origin,
					'destination' => 'place_id:' . $destination,
					'key' => $this->getParameter('app.google_key')
				]
			]
		);
//		$statusCode = $apiResponse->getStatusCode();
		$quote = $quoteGenerator->generate($apiResponse->toArray());
		$session->set('quote', $quote);
		return $this->render('quote.html.twig', compact('quote'));
	}
}