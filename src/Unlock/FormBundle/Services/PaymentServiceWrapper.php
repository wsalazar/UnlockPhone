<?php

namespace Unlock\FormBundle\Services;

use Unlock\FormBundle\Entity\Unlock;

abstract class PaymentServiceWrapper
{

	const PAYMENT_SANDBOX_URL = 'https://api.sandbox.paypal.com/v1/';
	const TEST_ACCOUNT = 'will.a.salazar-facilitator@gmail.com';
	const CLIENT_ID = 'AakKmRAUxxENYtDWMvc05LEylx9Mw6GSCkx7zpKnfLx-JyOJnQySEnXlnwhr';
	const SECRET = 'EH3SoxBOTKLyeMbxOU9nWh7sFeQTClCoYk_VVSFwYVKnKIo1fKD3TzJRtLKM';

	private $headers = array();

	public function setHeaders(array $headers = array(), $unlock = null){
		if(is_null($unlock) ){
			$this->headers = $headers;
			return;
		}
		
		$uri = $this->getUri($unlock);
		foreach( $headers as $option => $value ){
			if ($option == CURLOPT_URL){
				$value = $value.$uri;
				echo "###### $value   ######<br />";
			}
		}
		$this->headers = $headers;

	}

	public function getHeaders(){
		return $this->headers;
	}

	public function getUri($unlock){ //$unlock
		
		$accountType = trim($unlock->getAccountType());
		$firstName = trim($unlock->getFirstName());
		$lastName = trim($unlock->getLastName());
		$address = trim($unlock->getAddress());
		$phone = trim($unlock->getPhone());
		$email = trim($unlock->getEmail());
		$fullName = $firstName . ' ' . $lastName;
		
		$uri = array(
  				'client_id' => self::CLIENT_ID,
  				'response_type'	=>	'code',
  				'scope'	=> $fullName . '+' . $email . '+' . $address . '+' . $phone . '+' . $accountType,
  				//'scope'	=> 'openid+profile+email+address+phone',
  				'redirect_uri'	=>	'http://unlock.lcl/app_dev.php/unlock'
  		);
  		$uri = http_build_query($uri);
  		echo "------- $uri --------";
  		//die();
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