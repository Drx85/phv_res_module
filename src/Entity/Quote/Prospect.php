<?php

namespace App\Entity\Quote;

class Prospect
{
	private string $name;
	private string $email;
	private string $phoneNumber;
	
	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}
	
	/**
	 * @param string $name
	 *
	 * @return Prospect
	 */
	public function setName(string $name): Prospect
	{
		$this->name = $name;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}
	
	/**
	 * @param string $email
	 *
	 * @return Prospect
	 */
	public function setEmail(string $email): Prospect
	{
		$this->email = $email;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getPhoneNumber(): string
	{
		return $this->phoneNumber;
	}
	
	/**
	 * @param string $phoneNumber
	 *
	 * @return Prospect
	 */
	public function setPhoneNumber(string $phoneNumber): Prospect
	{
		$this->phoneNumber = $phoneNumber;
		
		return $this;
	}
}
