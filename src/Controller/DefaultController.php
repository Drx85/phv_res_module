<?php

namespace App\Controller;

use App\Entity\Quote\Prospect;
use App\Form\AskQuoteType;
use App\Service\Payment\CapturePayment;
use App\Service\Payment\CreatePayment;
use App\Service\Quote\QuoteGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class DefaultController extends AbstractController
{
	#[Route('/', name: 'home')]
	public function index(Request $request, QuoteGenerator $quoteGenerator, SessionInterface $session): Response|RedirectResponse
	{
		$form = $this->createForm(AskQuoteType::class);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$askedQuote = $form->getData();
			$prospect = new Prospect();
			$prospect->setName($askedQuote['name'])
				->setEmail($askedQuote['email'])
				->setPhoneNumber($askedQuote['phoneNumber']);
			$session->set('prospect', $prospect);
			return $this->render('quote.html.twig', [
				'quote' => $quoteGenerator->generate(
					$askedQuote['originPlaceId'],
					$askedQuote['destinationPlaceId'],
					$askedQuote['departureDateTime']				)
			]);
		}
		
		return $this->renderForm('home.html.twig', [
			'form' => $form,
		]);
	}
	
	#[Route('/create-paypal-transaction', name: 'render.payment')]
	public function renderPayment(CreatePayment $payment, SessionInterface $session): JsonResponse
	{
		$quote = $session->get('quote');
		
		return new JsonResponse(['res' => $payment->create($quote->getPrice())]);
	}
	
	#[Route('/capture-paypal-transaction', name: 'capture.payment')]
	public function capturePayment(CapturePayment $payment, Request $request): JsonResponse
	{
		$data = json_decode($request->getContent(), true);
		
		return new JsonResponse(['res' => $payment->capture($data['orderID'])]);
	}
	
	#[Route('/confirmation', name: 'confirm.payment')]
	public function confirmPayment(): Response
	{
		return $this->render('confirmation.html.twig');
	}
}
