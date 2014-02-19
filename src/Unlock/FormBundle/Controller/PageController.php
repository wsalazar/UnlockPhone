<?php

namespace Unlock\FormBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Unlock\FormBundle\Entity\Unlock;
use Unlock\FormBundle\Form\UnlockType;
use Unlock\FormBundle\Services\RestService;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Common\PPApiContext as Context;
//use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{

	public function unlockAction(){
		$unlock = new Unlock();
		$form = $this->createForm(new UnlockType(), $unlock);
		$request = $this->getRequest();
		if($request->getMethod() == 'POST'){
			$form->bind($request);

			if($form->isValid()){
				$service = new RestService();
				if(!($tokenHandler = $service->hasAccess())) {

				}
				$service->setToken($tokenHandler);
				$openIdUrl = urldecode($service->grantAccess(new Context(array('mode' => 'sandbox'))));
				echo $openIdUrl;
				$this->redirect($openIdUrl,302);
				//$url = $this->redirect('https://www.sandbox.paypal.com/webapps/auth/protocol/openidconnect/v1/authorize/'.RestService::CLIENT_ID,302);
				//echo '<pre>';
				//var_dump($url);
				
				//echo gettype($tokenHandler) . '<br />';
//				$service->setToken($tokenHandler);
				//echo '<br /><br /> Access Token: '. $service->getToken();
				//$service->verifyPayments();
//				$result = $service->verifyPayments();
				//var_dump($result);
				//echo 'hi';
				//$resource = curl_init();
				//$this->redirect($this->generateUrl('UnlockFormBundle_paypal_payment'));

			}
		}
		return $this->render('UnlockFormBundle:Page:unlock.html.twig',array('form' => $form->createView()));
	}
}