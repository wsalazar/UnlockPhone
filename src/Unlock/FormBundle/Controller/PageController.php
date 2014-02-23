<?php

namespace Unlock\FormBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Unlock\FormBundle\Entity\Unlock;
use Unlock\FormBundle\Form\UnlockType;
use Unlock\FormBundle\Services\PaymentService;
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
				$service = new PaymentService();
				if(!($tokenHandler = $service->getAccessToken())) {

				}
				die();
				//$data = $form->getData();
				//print_r($data);
				$service->setAccessToken($tokenHandler);
				$restStatus = $service->getUserPermission($unlock);
				echo 'This is print r<br />';
				print_r($restStatus);
				$service->RestErrorHandler($restStatus);
				//echo $result;
				//return $this->redirect($this->generateUrl('UnlockFormBundle_thankyou'));

				//echo '<br /><br /> Access Token: '. $service->getAccessToken();
				//$service->verifyPayments();
				//$result = $service->verifyPayments();
			}
		}
		return $this->render('UnlockFormBundle:Page:unlock.html.twig',array('form' => $form->createView()));
	}

	public function thankyouAction(){
		return $this->render('UnlockFormBundle:Page:thankyou.html.twig');
	}
}