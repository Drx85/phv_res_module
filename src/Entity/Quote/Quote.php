<?php

namespace App\Entity\Quote;

class Quote
{
	/**
	 * @var string
	 */
	private string $originAddress;
	/**
	 * @var string
	 */
	private string $originLatitude;
	/**
	 * @var string
	 */
	private string $originLongitude;
	/**
	 * @var string
	 */
	private string $destinationAddress;
	/**
	 * @var string
	 */
	private string $destinationLatitude;
	/**
	 * @var string
	 */
	private string $destinationLongitude;
	/**
	 * @var int
	 */
	private int $travelDistanceInKms;
	/**
	 * @var string
	 */
	private string $formattedTravelTime;
	
	/**
	 * @var float
	 */
	private float $price;
	
	/**
	 * @var int
	 */
	private int $departureTimestamp;
	
	/**
	 * @return string
	 */
	public function getOriginAddress(): string
	{
		return $this->originAddress;
	}
	
	/**
	 * @param string $originAddress
	 *
	 * @return Quote
	 */
	public function setOriginAddress(string $originAddress): Quote
	{
		$this->originAddress = $originAddress;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getOriginLatitude(): string
	{
		return $this->originLatitude;
	}
	
	/**
	 * @param string $originLatitude
	 *
	 * @return Quote
	 */
	public function setOriginLatitude(string $originLatitude): Quote
	{
		$this->originLatitude = $originLatitude;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getOriginLongitude(): string
	{
		return $this->originLongitude;
	}
	
	/**
	 * @param string $originLongitude
	 *
	 * @return Quote
	 */
	public function setOriginLongitude(string $originLongitude): Quote
	{
		$this->originLongitude = $originLongitude;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getDestinationAddress(): string
	{
		return $this->destinationAddress;
	}
	
	/**
	 * @param string $destinationAddress
	 *
	 * @return Quote
	 */
	public function setDestinationAddress(string $destinationAddress): Quote
	{
		$this->destinationAddress = $destinationAddress;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getDestinationLatitude(): string
	{
		return $this->destinationLatitude;
	}
	
	/**
	 * @param string $destinationLatitude
	 *
	 * @return Quote
	 */
	public function setDestinationLatitude(string $destinationLatitude): Quote
	{
		$this->destinationLatitude = $destinationLatitude;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getDestinationLongitude(): string
	{
		return $this->destinationLongitude;
	}
	
	/**
	 * @param string $destinationLongitude
	 *
	 * @return Quote
	 */
	public function setDestinationLongitude(string $destinationLongitude): Quote
	{
		$this->destinationLongitude = $destinationLongitude;
		return $this;
	}
	
	/**
	 * @return int
	 */
	public function getTravelDistanceInKms(): int
	{
		return $this->travelDistanceInKms;
	}
	
	/**
	 * @param int $travelDistanceInKms
	 *
	 * @return Quote
	 */
	public function setTravelDistanceInKms(int $travelDistanceInKms): Quote
	{
		$this->travelDistanceInKms = $travelDistanceInKms;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getFormattedTravelTime(): string
	{
		return $this->formattedTravelTime;
	}
	
	/**
	 * @param string $formattedTravelTime
	 *
	 * @return Quote
	 */
	public function setFormattedTravelTime(string $formattedTravelTime): Quote
	{
		$this->formattedTravelTime = $formattedTravelTime;
		return $this;
	}
	
	/**
	 * @return float
	 */
	public function getPrice(): float
	{
		return $this->price;
	}
	
	/**
	 * @param float $price
	 *
	 * @return Quote
	 */
	public function setPrice(float $price): Quote
	{
		$this->price = $price;
		return $this;
	}
	
	/**
	 * @return int
	 */
	public function getDepartureTimestamp(): int
	{
		return $this->departureTimestamp;
	}
	
	/**
	 * @param int $departureTimestamp
	 *
	 * @return Quote
	 */
	public function setDepartureTimestamp(int $departureTimestamp): Quote
	{
		$this->departureTimestamp = $departureTimestamp;
		return $this;
	}
}