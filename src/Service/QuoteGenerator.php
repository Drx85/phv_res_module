<?php

namespace App\Service;

use App\Entity\Quote\Quote;

class QuoteGenerator
{
	private int $minimumOrderPrice;
	private int $priceOfCare;
	private float $pricePerKm;
	private float $pricePerMinute;
	
	public function __construct(int $minimumOrderPrice, int $priceOfCare, float $pricePerKm, float $pricePerMinute)
	{
		$this->minimumOrderPrice = $minimumOrderPrice;
		$this->priceOfCare = $priceOfCare;
		$this->pricePerKm = $pricePerKm;
		$this->pricePerMinute = $pricePerMinute;
	}

	/**
	 * @param array $apiResponse
	 *
	 * @return Quote
	 */
	public function generate(array $apiResponse): Quote
	{
		$travelDistanceInKm = $apiResponse['routes']['0']['legs']['0']['distance']['text'];
		$timeInMinutes = ceil($apiResponse['routes']['0']['legs']['0']['duration']['value'] / 60);
		$formattedTimeInHours = $this->convertMinutesToFormattedHours($timeInMinutes);
		$price = $this->calculPrice(intval($travelDistanceInKm), intval($timeInMinutes));
		$quote = new Quote();
		return $quote->setOriginAddress($apiResponse['routes']['0']['legs']['0']['start_address'])
			->setOriginLatitude($apiResponse['routes']['0']['legs']['0']['start_location']['lat'])
			->setOriginLongitude($apiResponse['routes']['0']['legs']['0']['start_location']['lng'])
			->setDestinationAddress($apiResponse['routes']['0']['legs']['0']['end_address'])
			->setDestinationLatitude($apiResponse['routes']['0']['legs']['0']['start_location']['lat'])
			->setDestinationLongitude($apiResponse['routes']['0']['legs']['0']['start_location']['lng'])
			->setTravelDistanceInKms(intval($travelDistanceInKm))
			->setFormattedTravelTimeInHours($formattedTimeInHours)
			->setPrice($price);
	}
	
	/**
	 * Return a formatted string from total minutes which contains hours + minutes travel time.
	 *
	 * Can be displayed to the user.<br/>
	 * Examples of outputs : '1 heure et 3 minutes', '1 minute'
	 *
	 * @param int $minutes
	 *
	 * @return string
	 */
	private function convertMinutesToFormattedHours(int $minutes): string
	{
		$hours = floor($minutes / 60);
		$stringHours = 'heures';
		if ($stringHours < 2) $stringHours = 'heure';
		
		$minutes = $minutes - $hours * 60;
		$stringMinutes = 'minutes';
		if ($stringMinutes < 2) $stringMinutes = 'minute';
		
		if ($hours == 0) return $minutes . ' ' . $stringMinutes;
		return $hours . ' ' . $stringHours . ' et ' . $minutes . ' ' . $stringMinutes;
	}
	
	/**
	 * @param int $travelDistanceInKm
	 * @param int $timeInMinutes
	 *
	 * @return float|int
	 */
	private function calculPrice(int $travelDistanceInKm, int $timeInMinutes)
	{
		$price = $this->pricePerKm * $travelDistanceInKm + $this->pricePerMinute * $timeInMinutes + $this->priceOfCare;
		if ($price < $this->minimumOrderPrice) return $this->minimumOrderPrice;
		return round($price, 2);
	}
}