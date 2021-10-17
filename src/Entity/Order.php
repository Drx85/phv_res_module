<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 'client_order')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;
	
	#[ORM\Column(type: 'string')]
	private string $originAddress;
	
	#[ORM\Column(type: 'string')]
	private string $destinationAddress;
	
	#[ORM\Column(type: 'integer')]
	private int $travelDistanceInKm;
	
	#[ORM\Column(type: 'string')]
	private string $formattedTravelTime;
	
	#[ORM\Column(type: 'float')]
	private float $price;
	
	#[ORM\Column(type: 'string')]
	private string $clientName;
	
	#[ORM\Column(type: 'string')]
	private string $clientEmail;
	
	#[ORM\Column(type: 'string')]
	private string $clientPhoneNumber;
	
	#[ORM\Column(type: 'string')]
	private string $paypalOrderId;
	
	public function getId(): ?int
	{
		return $this->id;
	}
	
	public function getOriginAddress(): string
	{
		return $this->originAddress;
	}
	
	public function setOriginAddress($originAddress): self
	{
		$this->originAddress = $originAddress;
		return $this;
	}

	public function getDestinationAddress(): string
	{
		return $this->destinationAddress;
	}
	
	public function setDestinationAddress($destinationAddress): self
	{
		$this->destinationAddress = $destinationAddress;
		return $this;
	}

	public function getTravelDistanceInKm(): int
	{
		return $this->travelDistanceInKm;
	}

	public function setTravelDistanceInKm($travelDistanceInKm): self
	{
		$this->travelDistanceInKm = $travelDistanceInKm;
		return $this;
	}

	public function getFormattedTravelTime(): string
	{
		return $this->formattedTravelTime;
	}

	public function setFormattedTravelTime($formattedTravelTime): self
	{
		$this->formattedTravelTime = $formattedTravelTime;
		return $this;
	}

	public function getPrice(): float
	{
		return $this->price;
	}

	public function setPrice($price): self
	{
		$this->price = $price;
		return $this;
	}

	public function getClientName(): string
	{
		return $this->clientName;
	}

	public function setClientName($clientName): self
	{
		$this->clientName = $clientName;
		return $this;
	}

	public function getClientEmail(): string
	{
		return $this->clientEmail;
	}

	public function setClientEmail($clientEmail): self
	{
		$this->clientEmail = $clientEmail;
		return $this;
	}

	public function getClientPhoneNumber(): string
	{
		return $this->clientPhoneNumber;
	}

	public function setClientPhoneNumber($clientPhoneNumber): self
	{
		$this->clientPhoneNumber = $clientPhoneNumber;
		return $this;
	}

	public function getPaypalOrderId(): string
	{
		return $this->paypalOrderId;
	}

	public function setPaypalOrderId($paypalOrderId): self
	{
		$this->paypalOrderId = $paypalOrderId;
		return $this;
	}
}
