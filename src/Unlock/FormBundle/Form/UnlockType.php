<?php
namespace Unlock\FormBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UnlockType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder->add('imie', null, array('label' => 'IMIE: '));
		$builder->add('firstName', null, array('label' => 'First Name: '));
		$builder->add('lastName', null, array('label' => 'Last Name: '));
		$builder->add('address', null, array('label' => 'Mailing Address: '));
		$builder->add('phone', null, array('label' => 'Phone Number: '));
		$builder->add('email','email', array('label' => 'E-Mail: '));
		$builder->add('account_type', null, array('label' => 'Account Type: '));
		$builder->add('creditCardNum', null, array('label' => 'Credit Card Number: '));
		$builder->add('nameOnCreditCard', null, array('label' => 'Name on Credit Card: '));
		$builder->add('monthExpired','choice', array(
				'choices'		=>	array(
						'1'		=>	'January',
						'2'		=>	'February',
						'3'		=>	'March',
						'4'		=>	'April',
						'5'		=>	'May',
						'6'		=>	'June',
						'7'		=>	'July',
						'8'		=>	'August',
						'9'		=>	'September',
						'10'	=>	'October',
						'11'	=>	'November',
						'12'	=>	'December'
					),
				'required'		=>	true,
				'empty_value'	=>	'-- Choose Month --',
				'empty_data'	=>	null
			));
		$builder->add('yearExpired', 'choice', array(
				'choices'		=>	array(
						'2014'	=>	'2014',
						'2015'	=>	'2015',
						'2016'	=>	'2016',
						'2017'	=>	'2017',
						'2018'	=>	'2018',
						'2019'	=>	'2019',
						'2020'	=>	'2020',
						'2021'	=>	'2021'
					),
				'required'		=>	true,
				'empty_value'	=>	'-- Choose Year --',
				'empty_data'	=>	null
			));
		$builder->add('cvv', null, array('label' => 'CVV: '));
	}

	public function getName(){
		return 'unlock';
	}
}

