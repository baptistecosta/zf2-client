<?php

namespace Application\Session\Container;


use Zend\Session\Container;

interface SessionIdentityAwareInterface {

	/**
	 * @param Container $container
	 */
	public function setIdentity(Container $container);

	/**
	 * @return Container
	 */
	public function getIdentity();
} 