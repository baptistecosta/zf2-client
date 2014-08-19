<?php

namespace Application\Filter\Auth;


use Zend\InputFilter\InputFilter;

/**
 * Class SignInFilter
 * @package Application\Filter\Auth
 */
class SignInFilter extends InputFilter {

	public function __construct() {
		$this->add([
			'name' => 'username',
			'required' => true,
			'filters' => [],
			'validators' => []
		]);

		$this->add([
			'name' => 'password',
			'required' => true,
			'filters' => [],
			'validators' => []
		]);
	}
}