<?php

namespace App\Service\Quote;

use App\Entity\Quote\Quote;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class QuoteGenerator
{
	private int $minimumOrderPrice;
	private int $priceOfCare;
	private float $pricePerKm;
	private float $pricePerMinute;
	private SessionInterface $session;
	private HttpClientInterface $client;
	
	public function __construct(int                 $minimumOrderPrice,
								int                 $priceOfCare,
								float               $pricePerKm,
								float               $pricePerMinute,
								SessionInterface    $session,
								HttpClientInterface $client)
	{
		$this->minimumOrderPrice = $minimumOrderPrice;
		$this->priceOfCare = $priceOfCare;
		$this->pricePerKm = $pricePerKm;
		$this->pricePerMinute = $pricePerMinute;
		$this->session = $session;
		$this->client = $client;
	}
	
	/**
	 * Call Google API, then create the quote from its response and save it in session.
	 *
	 * @param string $origin
	 * @param string $destination
	 * @param int    $departureTimestamp
	 * @param string $googleApiKey
	 *
	 * @return Quote
	 */
	public function generate(string $origin, string $destination, int $departureTimestamp, string $googleApiKey): Quote
	{
		$quote = $this->createQuote($this->callGoogleApi($origin, $destination, $departureTimestamp, $googleApiKey));
		$this->session->set('quote', $quote);
		return $quote;
	}
	
	/**
	 * @param string $origin
	 * @param string $destination
	 * @param int    $departureTimestamp
	 * @param string $googleApiKey
	 *
	 * @return array
	 * @throws ClientExceptionInterface
	 * @throws DecodingExceptionInterface
	 * @throws RedirectionExceptionInterface
	 * @throws ServerExceptionInterface
	 * @throws TransportExceptionInterface
	 */
	private function callGoogleApi(string $origin, string $destination, int $departureTimestamp, string $googleApiKey): array
	{
		try {
		$apiReponse = $this->client->request(
			'GET',
			'https://maps.googleapis.com/maps/api/directions/json', [
				'query' => [
					'origin'      => 'place_id:' . $origin,
					'destination' => 'place_id:' . $destination,
					'departure_time' => $departureTimestamp,
					'key'         => $googleApiKey
				]
			]
		);
		$apiResponse = $apiReponse->toArray();
		$apiResponse['departureTimestamp'] = $departureTimestamp;
		return $apiResponse;
		} catch (\Exception) {
			throw new HttpException(500, "Erreur lors de l'appel aux services Google.");
		}
	}
	
	/**
	 * @param array $apiResponse
	 *
	 * @return Quote
	 */
	private function createQuote(array $apiResponse): Quote
	{
		$travelDistanceInKm = $apiResponse['routes']['0']['legs']['0']['distance']['text'];
		$timeInMinutes = ceil($apiResponse['routes']['0']['legs']['0']['duration_in_traffic']['value'] / 60);
		$formattedTime = $this->convertMinutesToFormattedHours($timeInMinutes);
		$price = $this->calculatePrice((int)$travelDistanceInKm, (int)$timeInMinutes);
		$quote = new Quote();
		return $quote->setOriginAddress($apiResponse['routes']['0']['legs']['0']['start_address'])
			->setOriginLatitude($apiResponse['routes']['0']['legs']['0']['start_location']['lat'])
			->setOriginLongitude($apiResponse['routes']['0']['legs']['0']['start_location']['lng'])
			->setDestinationAddress($apiResponse['routes']['0']['legs']['0']['end_address'])
			->setDestinationLatitude($apiResponse['routes']['0']['legs']['0']['end_location']['lat'])
			->setDestinationLongitude($apiResponse['routes']['0']['legs']['0']['end_location']['lng'])
			->setTravelDistanceInKms((int)$travelDistanceInKm)
			->setFormattedTravelTime($formattedTime)
			->setPrice($price)
			->setDepartureTimestamp($apiResponse['departureTimestamp']);
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
	private function calculatePrice(int $travelDistanceInKm, int $timeInMinutes): float|int
	{
		$price = $this->pricePerKm * $travelDistanceInKm + $this->pricePerMinute * $timeInMinutes + $this->priceOfCare;
		if ($price < $this->minimumOrderPrice) return $this->minimumOrderPrice;
		return round($price, 2);
	}
}