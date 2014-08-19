<?php

namespace Application\Form\Auth;


use Zend\Form\Form;

/**
 * Class SignInForm
 * @package Application\Form\Auth
 */
class SignInForm extends Form {

	public function __construct($name = null) {
		parent::__construct('user');
		$this->setAttribute('method', 'post');
		$this->add([
			'name' => 'id',
			'type' => 'Hidden',
		]);
		$this->add([
			'name' => 'username',
			'type' => 'Text',
			'attributes' => [
				'class' => 'form-control input-lg',
				'placeholder' => "Username"
			]
		]);
		$this->add([
			'name' => 'password',
			'type' => 'password',
			'attributes' => [
				'class' => 'form-control input-lg',
				'placeholder' => "Password"
			]
		]);
		$this->add([
			'name' => 'submit',
			'type' => 'Submit',
			'attributes' => [
				'value' => 'Sign in',
				'id' => 'submitButton',
				'class' => 'form-control btn-primary input-lg'
			]
		]);
	}
} 