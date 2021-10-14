<?php

namespace App\Entity\Quote;

class Quote
{
	/**
	 * @var string
	 */
	private $originAddress;
	/**
	 * @var string
	 */
	private $originLatitude;
	/**
	 * @var string
	 */
	private $originLongitude;
	/**
	 * @var string
	 */
	private $destinationAddress;
	/**
	 * @var string
	 */
	private $destinationLatitude;
	/**
	 * @var string
	 */
	private $destinationLongitude;
	/**
	 * @var int
	 */
	private $travelDistanceInKms;
	/**
	 * @var string
	 */
	private $formattedTravelTimeInHours;
	
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
	public function getFormattedTravelTimeInHours(): string
	{
		return $this->formattedTravelTimeInHours;
	}
	
	/**
	 * @param string $formattedTravelTimeInHours
	 *
	 * @return Quote
	 */
	public function setFormattedTravelTimeInHours(string $formattedTravelTimeInHours): Quote
	{
		$this->formattedTravelTimeInHours = $formattedTravelTimeInHours;
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
	 * @var float
	 */
	private $price;
}