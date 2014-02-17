<?php

namespace Unlock\FormBundle\Services;

class RestService
{
	const PAYPAL_SANDBOX_URL = 'https://api.sandbox.paypal.com/v1/oauth2/token';
	const TEST_ACCOUNT = 'will.a.salazar-facilitator@gmail.com';
	const CLIENT_ID = 'AVKZiRAC2C-fS-yDLWkrzWL3N-0M0pxV8_31Ag0jVEVSckexk2wO0C5B3bJ1';
	const SECRET = 'EIuSqhBjIdiADvhFMA1KPE6Qq6MOFBvkVH5ACI1s5OBECyUM2-Wg10EKFTg6';

	private $token;

	public function hasAccess(){
		$curl = 'curl -v ' . RestService::PAYPAL_SANDBOX_URL . ' -H "Accept: application/json" -H "Accept-Language: en_US" -u "'.
					RestService::CLIENT_ID . ':'. RestService::SECRET . '" -d "grant_type=client_credentials"';
		return shell_exec($curl);
	}

	public function setToken($tokenHanlder){
		$accessToken = json_decode($tokenHanlder);
		$this->token = $accessToken->access_token;
	}

	public function getToken(){
		return $this->token;
	}
}