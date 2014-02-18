<?php

namespace Unlock\FormBundle\Services;

class RestService
{
	const PAYPAL_SANDBOX_URL = 'https://api.sandbox.paypal.com/v1/';
	const TEST_ACCOUNT = 'will.a.salazar-facilitator@gmail.com';
	const CLIENT_ID = 'AVKZiRAC2C-fS-yDLWkrzWL3N-0M0pxV8_31Ag0jVEVSckexk2wO0C5B3bJ1';
	const SECRET = 'EIuSqhBjIdiADvhFMA1KPE6Qq6MOFBvkVH5ACI1s5OBECyUM2-Wg10EKFTg6';

	private $token;

	public function hasAccess(){
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
		/*
		$curl = 'curl -v ' . RestService::PAYPAL_SANDBOX_URL . 'oauth2/token -H "Accept: application/json" -H "Accept-Language: en_US" -u "'.
					RestService::CLIENT_ID . ':'. RestService::SECRET . '" -d "grant_type=client_credentials"';
*/
		return $result;
		//return shell_exec($curl);
	}

	public function setToken($tokenHandler){
		$json = json_decode($tokenHandler);
		//echo 'json response get type : ' . $jsonData->access_token;
		$this->token = $json->access_token;
	}

	public function getToken(){
		return $this->token;
	}

	public function verifyPayments(){
		$init = curl_init();
		$data = array('intent' 	=> 'sale', 'redirect_urls' => array('return_url' => 'http://unlock.lcl/app_dev.php/unlock',
    					'cancel_url' => 'http://unlock.lcl/app_dev.php/unlock'),'payer' => array('payment_method' => 'paypal'),
						'transactions' => array( array('amount' => array('total'=>'125','currency' => 'USD') ) ) );
		//$data = '{"intent":"sale","payer":{"payment_method":"paypal"},"transactions":[{"amount":{"total":"7.47","currency":"USD"}}]}';
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
		//$result = json_decode($result);
		curl_close( $init );
		return $result;
/*
		$json = array('intent' 	=> 'sale', 'payer' => array('payment_method' => 'paypal'),
				'transactions' => array( array('amount' => array('total'=>'125','currency' => 'USD') ) ) );
*/		
/*
		$curl = "curl -v " . RestService::PAYPAL_SANDBOX_URL ."payments/payment -H 'Content-Type: application/json' 
		-H 'Authorization: Bearer {" . $this->getToken() . "}' -d '" . $json . "'";
		//.{'intent':'sale','payer':{'payment_method':'paypal'},'transactions':[{'amount':{'total':'7.47','currency':'USD'}}]}'<br /><br />";
		echo $curl . '<br /><br />';
		//echo $json;
		echo "curl -v https://api.sandbox.paypal.com/v1/payments/payment -H 'Content-Type: application/json' -H 'Authorization: Bearer {accessToken}' 
-d '{'intent':'sale','payer':{'payment_method':'paypal'},'transactions':[{'amount':{'total':'7.47','currency':'USD'}}]}'<br />";
		var_dump(shell_exec($curl));
*/
	}
}


/*
curl -v https://api.sandbox.paypal.com/v1/payments/payment -H 'Content-Type: application/json' -H 'Authorization: Bearer {accessToken}' 
-d '{"intent":"sale","payer":{"payment_method":"paypal"},"transactions":[{"amount":{"total":"7.47","currency":"USD"}}]}'
	*/