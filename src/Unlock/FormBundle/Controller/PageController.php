<?php

namespace Unlock\FormBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Unlock\FormBundle\Entity\Unlock;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
	public function newAction(Request $request){
		$unlock = new Unlock();
		$form = $this->createFormBuilder($unlock)
				->add('imie','text')
				->add('firstName','text')
				->add('lastName','text')
				->add('email','text')
				->add('creditCardNumber','text')
				->add('nameOnCreditCard','text')
				->add('monthExpired','number')
				->add('yearExpired','number')
				->add('cvv','number')
				->add('Send Unlock Code','submit')
				->getForm();
		//echo get_class($form);
		$form->handleRequest($request);
		if($form->isValid()){
			echo 'haha';
			return $this->redirect($this->generateUrl('success'));
		}
		return $this->redirect($this->generateUrl('failure'));
	}

	public function submittedAction(){
		echo 'yes';
	}

	public function failAction(){
		echo 'no';
	}
}