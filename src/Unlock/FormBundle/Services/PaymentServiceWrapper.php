<?php

namespace Unlock\FormBundle\Services;

abstract class PaymentServiceWrapper
{

	private $headers = array();
/*
	public function __construct(Symfony\Component\Form\Form $form){
		var_dump($form);
		echo 'this is the wrapper';
	}
*/
	public function setHeaders(array $headers = array(), Unlock\FormBundle\Entity\Unlock $unlock = null){
		if(is_null($unlock)){
			$this->headers = $headers;
			return;
		}
		$uri = $this->getUri($unlock);
		foreach( $headers as $option => $value ){
			if ($option == CURLOPT_URL){
				$value .= $value.$uri;
			}
		}
		$this->headers = $headers;
	}

	public function getHeaders(){
		return $this->headers;
	}

	public function getUri(Unlock\FormBundle\Entity\Unlock $unlock){
		$accountType = trim($unlock->getAccountType());
		$firstName = trim($unlock->getFirstName());
		$lastName = trim($unlock->getLastName());
		$address = trim($unlock->getAddress());
		$phone = trim($unlock->getPhone());
		$uri = array(
  				'client_id' => self::CLIENT_ID,
  				'response_type'	=>	'code',
  				'scope'	=> $fullName . '+' . $email . '+' . $address . '+' . $phone . '+' . $accountType,
  				'redirect_uri'	=>	'http://unlock.lcl/app_dev.php/unlock'
  		);
  		$uri = http_build_query($uri);
  		return $uri;
	}

	public function setupCurl(){
		$init = curl_init();
		curl_setopt_array($init, $this->getHeaders());
		$result = curl_exec($init);
		curl_close($init);
		return $result;
	}
}