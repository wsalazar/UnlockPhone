<?php
namespace Unlock\FormBundle\Entity;

class Unlock
{
	private $imie;

	private $firstName;

	private $lastName;

	private $email;

	private $creditCardNum;

	private $nameOnCreditCard;

	private $monthExpired;

	private $yearExpired;

	private $cvv;

	public function setIMIE($imie){
		$this->imie = $imie;
	}

	public function getIMIE(){
		return $this->imie;
	}

	public function setFirstName($firstName){
		$this->firstName = $firstName;
	}

	public function getFirstName(){
		return $this->firstName;
	}

	public function setLastName($lastName){
		$this->lastName = $lastName;
	}

	public function getLastName(){
		return $this->lastName;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setNameOnCreditCard($nameOnCreditCard){
		$this->nameOnCreditCard = $nameOnCreditCard;
	}

	public function getNameOnCreditCard(){
		return $this->nameOnCreditCard;
	}

	public function setCreditCardNumber($creditCardNum){
		$this->creditCardNum = $creditCardNum;
	}

	public function getCreditCardNumber(){
		return $this->creditCardNum;
	}

	public function setNameOnCredit($nameOnCredit){
		$this->nameOnCredit = $nameOnCredit;
	}

	public function getNameOnCredit(){
		$this->nameOnCredit = $nameOnCredit;
	}

	public function setMonthExpired($monthExpired){
			$this->monthExpired = $monthExpired;
	}

	public function getMonthExpired(){
			return $this->monthExpired;
	}

	public function setYearExpired($yearExpired){
			$this->yearExpired = $yearExpired;
	}

	public function getYearExpired(){
			return $this->yearExpired;
	}

	public function setCVV($cvv){
			$this->cvv = $cvv;
		}

	public function getCVV(){
		return $this->cvv;
	}
}
