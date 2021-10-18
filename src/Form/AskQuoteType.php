<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotEqualTo;

class AskQuoteType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('origin', TextType::class, [
				'label' => 'Adresse de départ',
				'constraints' => new NotBlank()
			])
			->add('originPlaceId', HiddenType::class, [])
			->add('destination', TextType::class, [
				'label' => "Adresse d'arrivée",
				'constraints' => new NotBlank()
			])
			->add('departureDateTime', DateTimeType::class, [
				'label' => 'Date et heure de départ',
				'widget' => 'single_text',
				'input' => 'timestamp',
				'view_timezone' => 'Europe/Paris',
				'constraints' => new GreaterThan(time(), null, "Le moment du départ ne peut pas être passé.")
			])
			->add('destinationPlaceId', HiddenType::class, [
				'constraints' => new NotEqualTo(['propertyPath' => 'parent.all[originPlaceId].data'
				], null, "L'origine et la destination ne peuvent pas être identiques.")
			])
			->add('name', TextType::class, [
				'label' => 'Nom et prénom',
				'constraints' => new NotBlank()
			])
			->add('email', EmailType::class, [])
			->add('phoneNumber', TextType::class, [
				'label' => 'Numéro de téléphone',
				'constraints' => new Length([
					'min' => 9,
					'minMessage' => 'Cette valeur est trop courte. Elle doit faire au moins 9 caractères.'
				])
			])
			->add('Suivant', SubmitType::class, []);
	}
}