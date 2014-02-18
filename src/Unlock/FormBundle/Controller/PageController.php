<?php

namespace Unlock\FormBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Unlock\FormBundle\Entity\Unlock;
use Unlock\FormBundle\Form\UnlockType;
use Unlock\FormBundle\Services\RestService;
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
				//echo gettype($tokenHandler) . '<br />';
				$service->setToken($tokenHandler);
				//echo '<br /><br /> Access Token: '. $service->getToken();
				//$service->verifyPayments();
				$result = $service->verifyPayments();
				//var_dump($result);
				//echo 'hi';
				//$resource = curl_init();
				//$this->redirect($this->generateUrl('UnlockFormBundle_paypal_payment'));

			}
		}
		return $this->render('UnlockFormBundle:Page:unlock.html.twig',array('form' => $form->createView()));
	}
}