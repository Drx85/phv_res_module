<?php

namespace App\Controller;

use App\Service\QuoteGenerator;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
	#[Route('/', name: 'home')]
	public function index()
	{
		return $this->render('home.html.twig');
	}
	
	#[Route('/quote/{origin}/{destination}', name: 'quote')]
	public function quote($origin, $destination, QuoteGenerator $quoteGenerator)
	{
		if ($origin === $destination) {
			$this->addFlash("warning", "L'origine et la destination ne peuvent pas être identiques");
			return $this->redirectToRoute('home');
		}
		return $this->render('quote.html.twig', [
			'quote' => $quoteGenerator->generate($origin,
												 $destination,
												 $this->getParameter('app.google_key'))
		]);
	}
}