<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotEqualTo;
use Symfony\Component\Validator\Constraints\Regex;

class AskQuoteType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('origin', TextType::class, [
				'constraints' => new NotBlank(['message' => "L'adresse de départ doit être valide."])
			])
			->add('originPlaceId', HiddenType::class, [
				'constraints' => new NotBlank(['message' => "L'adresse de départ doit être valide."])
			])
			->add('destination', TextType::class, [
				'constraints' => new NotBlank(['message' => "L'adresse d'arrivée doit être valide."])
			])
			->add('departureDateTime', DateTimeType::class, [
				'widget' => 'single_text',
				'input' => 'timestamp',
				'view_timezone' => 'Europe/Paris',
				'constraints' => new GreaterThan(time(), null, "Le moment du départ ne peut pas être passé.")
			])
			->add('destinationPlaceId', HiddenType::class, [
				'constraints' => [
					new NotEqualTo(['propertyPath' => 'parent.all[originPlaceId].data'], null, "L'origine et la destination ne peuvent pas être identiques."),
					new NotBlank(['message' => "L'adresse d'arrivée doit être valide."])
				]
			])
			->add('name', TextType::class, [
				'constraints' => new NotBlank()
			])
			->add('email', EmailType::class, [])
			->add('phoneNumber', TelType::class, [
				'constraints' => new Regex([
					'pattern' => '^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$^',
				])
			]);
	}
	
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'translation_domain' => 'forms'
		]);
	}
}