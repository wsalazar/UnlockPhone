<?php

namespace Unlock\FormBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Unlock\FormBundle\Entity\Unlock;
use Unlock\FormBundle\Form\UnlockType;
//use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{

	const PAYPAL_SANDBOX_URL = 'https://api.sandbox.paypal.com/v1/oauth2/token';
	const TEST_ACCOUNT = 'will.a.salazar-facilitator@gmail.com';
	const CLIENT_ID = 'AVKZiRAC2C-fS-yDLWkrzWL3N-0M0pxV8_31Ag0jVEVSckexk2wO0C5B3bJ1';
	const SECRET = 'EIuSqhBjIdiADvhFMA1KPE6Qq6MOFBvkVH5ACI1s5OBECyUM2-Wg10EKFTg6';

	public function unlockAction(){
		$unlock = new Unlock();
		$form = $this->createForm(new UnlockType(), $unlock);
		$request = $this->getRequest();
		if($request->getMethod() == 'POST'){
			$form->bind($request);

			if($form->isValid()){
				$curl = 'curl -v ' . PageController::PAYPAL_SANDBOX_URL . ' -H "Accept: application/json" -H "Accept-Language: en_US" -u "'.
					PageController::CLIENT_ID . ':'. PageController::SECRET . '" -d "grant_type=client_credentials"';
				//echo $curl;

				$token = shell_exec($curl);
				$token = json_decode($token);
				$className = get_class($token);
				if($token instanceof $className){
					//echo gettype($token);
					//var_dump($token);
					echo '<br /><br /> Access Token: '.$token->access_token;
				}
				//$resource = curl_init();
				//$this->redirect($this->generateUrl('UnlockFormBundle_paypal_payment'));

			}
		}
		return $this->render('UnlockFormBundle:Page:unlock.html.twig',array('form' => $form->createView()));
	}
}