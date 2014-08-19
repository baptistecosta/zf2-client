<?php

namespace Application\Session\Container;


use Zend\Session\Container;

/**
 * Trait SessionIdentityAwareTrait
 * @package Application\Session\Container
 */
trait SessionIdentityAwareTrait {

	protected $identity;

	/**
	 * @return Container
	 */
	public function getIdentity() {
		return $this->identity;
	}

	/**
	 * @param Container $identity
	 * @return $this
	 */
	public function setIdentity(Container $identity) {
		$this->identity = $identity;
		return $this;
	}
}