<?php

namespace Unlock\FormBundle\Services;

use PayPal\Auth\OAuthTokenCredential;

use PayPal\Auth\Openid\PPOpenIdSession;// as OpenIdSession;

class RestService
{

	const PAYPAL_SANDBOX_URL = 'https://api.sandbox.paypal.com/v1/';
	const TEST_ACCOUNT = 'will.a.salazar-facilitator@gmail.com';
	//const CLIENT_ID = 'AVKZiRAC2C-fS-yDLWkrzWL3N-0M0pxV8_31Ag0jVEVSckexk2wO0C5B3bJ1';
	const CLIENT_ID = 'AakKmRAUxxENYtDWMvc05LEylx9Mw6GSCkx7zpKnfLx-JyOJnQySEnXlnwhr';
	//const SECRET = 'EIuSqhBjIdiADvhFMA1KPE6Qq6MOFBvkVH5ACI1s5OBECyUM2-Wg10EKFTg6';
	const SECRET = 'EH3SoxBOTKLyeMbxOU9nWh7sFeQTClCoYk_VVSFwYVKnKIo1fKD3TzJRtLKM';

	private $token;

	public function hasAccess(){
		$oAuth = new OAuthTokenCredential(RestService::CLIENT_ID, RestService::SECRET);
		return $oAuth->getAccessToken(array('mode' => 'sandbox'));
		/*
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
		*/

	}

	public function grantAccess($apiContext){
		//$apiContext = new PPApiContext(array('mode' => 'sandbox'));
		$scope = array('openid', 'email');
		//echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$redirectUri = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		return PPOpenIdSession::getAuthorizationUrl($redirectUri, $scope, RestService::CLIENT_ID, $apiContext);
	}

	public function setToken($token){
		$this->token = $token;
	}
/*
	public function getToken(){
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