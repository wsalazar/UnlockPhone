<?php
/*
 * This file is used for REST Service. It communicates with PayPal's ReSTful Web Service.
 * It first communicates with OAuth 2.0 an receives an access token.
 * It then asks the user for permission using my Client ID and Secret that I obtained from PayPal Developer portal.
 *
 */

namespace Unlock\FormBundle\Services;

/**
 * RestService uses PayPals ReSTful API
 * @author Will Salazar
 */

class RestService
{
	const PAYPAL_SANDBOX_URL = 'https://api.sandbox.paypal.com/v1/';
	const TEST_ACCOUNT = 'will.a.salazar-facilitator@gmail.com';
	const CLIENT_ID = 'AVKZiRAC2C-fS-yDLWkrzWL3N-0M0pxV8_31Ag0jVEVSckexk2wO0C5B3bJ1';
	const SECRET = 'EIuSqhBjIdiADvhFMA1KPE6Qq6MOFBvkVH5ACI1s5OBECyUM2-Wg10EKFTg6';

	/**
	  * @var string
	  */
	private $token;

	/**
	  *This function uses OAuth 2.0 to retrieve an access token that is needed for PayPal.
	  *@return $result whichis json object.
	  */
	public function getAccessToken(){
			$init = curl_init();
			curl_setopt($init, CURLOPT_URL, RestService::PAYPAL_SANDBOX_URL . "oauth2/token");
			curl_setopt($init, CURLOPT_HEADER, false);
			curl_setopt($init, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($init, CURLOPT_POST, true);
			curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($init, CURLOPT_USERPWD, RestService::CLIENT_ID . ':'. RestService::SECRET );
			curl_setopt($init, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
			$result = curl_exec($init);
			curl_close($init);
			return $result;
	}

	/**
	  *This function decodes a json object to give state to an property.
	  * @param $tokenHandler is json object.
	  */
	public function setAccessToken($tokenHandler){
		$accessToken = json_decode($tokenHandler);
		$this->token = $accessToken->access_token;
	}
//https://www.sandbox.paypal.com/webapps/auth/protocol/openidconnect/v1/authorize?client_id=AVKZiRAC2C-fS-yDLWkrzWL3N-0M0pxV8_31Ag0jVEVSckexk2wO0C5B3bJ1&response_type=code&scope=profile+email+address+phone+https%3A%2F%2Furi.paypal.com%2Fservices%2Fpaypalattributes&redirect_uri=http://unlock.lcl/app_dev.php/unlock	
	public function getUserPermission(){
  		$uri = array(
  				'client_id' => self::CLIENT_ID,
  				'response_type'	=>	'code',
  				'scope'	=>	'profile+email+address+phone',
  				'redirect_uri'	=>	'http://unlock.lcl/app_dev.php/unlock'
  			);

// 		$uri = 'client_id=' . self::CLIENT_ID . '&response_type=code&scope=profile+email+address+phone+https://uri.paypal.com/services/paypalattributes&redirect_uri=http://unlock.lcl/app_dev.php/thank-you';
  		$uri = http_build_query($uri);
  		echo '<br /><br /><br />------'.$uri.'-------<br /><br />';
  		$init = curl_init();
  		curl_setopt_array($init, array(
			CURLOPT_URL 		=> 'https://www.sandbox.paypal.com/webapps/auth/protocol/openidconnect/v1/authorize?'.$uri,
			//CURLOPT_HTTPGET		=> true,
			CURLOPT_RETURNTRANSFER	=> true,
			//CURLOPT_POSTFIELDS	=>	$uri,
			CURLOPT_HEADER 		=> true,
			CURLOPT_HTTPHEADER => array(
					'Content-Type: application/x-www-form-urlencoded'
				)
			));
  		$result = curl_exec($init);
		curl_close($init);
		return $result;
  	}

  	public function RestErrorHandler($restStatus){
  		var_dump($restStatus);
  		//$status = json_decode($restStatus);
  		//var_dump($status);
  	}
/*
	public function getAccessToken(){
		return $this->token;
	}

	public function verifyPayments(){
		$init = curl_init();
		$data = array('intent' 	=> 'sale', 'redirect_urls' => array('return_url' => 'http://unlock.lcl/app_dev.php/unlock',
    					'cancel_url' => 'http://unlock.lcl/app_dev.php/unlock'),'payer' => array('payment_method' => 'paypal'),
						'transactions' => array( array('amount' => array('total'=>'125','currency' => 'USD') ) ) );
		$data = json_encode($data);
		curl_setopt($init, CURLOPT_URL, RestService::PAYPAL_SANDBOX_URL ."payments/payment");
		curl_setopt($init, CURLOPT_POST, true);
		curl_setopt($init, CURLOPT_POSTFIELDS,  $data);
		curl_setopt($init, CURLOPT_HEADER,  true);
		curl_setopt($init, CURLOPT_HTTPHEADER, array(
				'Content-Type' => 'application/json',
				'Authorization' => 'Bearer ' . $this->getToken(),
				'Content-length' => strlen($data))
			);
		$result = curl_exec($init);
		var_dump( $result );
		curl_close( $init );
		return $result;
	}
*/
}