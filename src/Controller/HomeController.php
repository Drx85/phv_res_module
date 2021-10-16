<?php

namespace App\Controller;

use App\Service\Payment\CreatePayment;
use App\Service\Quote\QuoteGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class HomeController extends AbstractController
{
	#[Route('/', name: 'home')]
	public function index(): Response
	{
		return $this->render('home.html.twig');
	}
	
	#[Route('/quote/{origin}/{destination}', name: 'quote')]
	public function quote($origin, $destination, QuoteGenerator $quoteGenerator): RedirectResponse|Response
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
	
	#[Route('/quote/payment', name: 'render.payment')]
	public function renderPayment(CreatePayment $order, SessionInterface $session): JsonResponse
	{
		$quote = $session->get('quote');
		return new JsonResponse(['res' => $order->create($quote->getPrice())]);
	}
}