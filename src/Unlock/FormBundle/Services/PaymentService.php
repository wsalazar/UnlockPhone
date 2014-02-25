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

class PaymentService extends PaymentServiceWrapper
{

	

	/**
	  * @var string
	  */
	private $token;
/*
	public function __construct(Symfony\Component\Form\Form $form){
		parent::__construct($form);
	}
*/
	/**
	  *This function uses OAuth 2.0 to retrieve an access token that is needed for PayPal.
	  *@return $result whichis json object.
	  */
	public function getAccessToken(){
			$headers = array(
				CURLOPT_URL 			=>	PaymentServiceWrapper::PAYMENT_SANDBOX_URL . "oauth2/token",
				CURLOPT_HEADER 			=> 	false,
				CURLOPT_SSL_VERIFYPEER	=> 	false,
				CURLOPT_POST 			=>	true,
				CURLOPT_RETURNTRANSFER	=>	true,
				CURLOPT_USERPWD			=>	PaymentServiceWrapper::CLIENT_ID . ':'. PaymentServiceWrapper::SECRET,
				CURLOPT_POSTFIELDS		=>	"grant_type=client_credentials"
				);
			$this->setHeaders($headers);
			return $this->setupCurl();
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
	public function getUserPermission($unlock){
		$headers = array(
			CURLOPT_URL 			=> 'https://www.sandbox.paypal.com/webapps/auth/protocol/openidconnect/v1/authorize?',
			CURLOPT_HTTPGET		=> true,
			CURLOPT_RETURNTRANSFER	=> true,
			//CURLOPT_POSTFIELDS	=>	$this->getUri($unlock),
			CURLOPT_HEADER 			=> true,
			//CURLOPT_HTTPHEADER 		=> array(
			//		'Content-Type: application/x-www-form-urlencoded'
			//	)
			);
		$this->setHeaders($headers, $unlock);//, $unlock

		return $this->setupCurl();
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