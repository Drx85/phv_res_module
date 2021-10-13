<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
	#[Route('/', name: 'homepage')]
	
	public function index()
	{
		return $this->render('home.html.twig');
	}
	
	#[Route('/quote/{origin}/{destination}', name: 'quote')]
	
	public function quote($origin, $destination)
	{
		dd('Working !');
	}
}