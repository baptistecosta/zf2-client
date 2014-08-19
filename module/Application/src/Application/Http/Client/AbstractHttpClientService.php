<?php
namespace Application\Http\Client;


use Application\Session\Container\SessionIdentityAwareInterface;
use Application\Session\Container\SessionIdentityAwareTrait;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

abstract class AbstractHttpClientService implements ServiceLocatorAwareInterface, SessionIdentityAwareInterface {

	use ServiceLocatorAwareTrait;
	use SessionIdentityAwareTrait;

	const CLIENT_ID = 'sefaireaider-website';
	const CLIENT_SECRET = '{7W5Vy?rxT;Ax9b';

	/**
	 * @var $client AbstractHttpClient
	 */
	protected $client;

	public function setClient(AbstractHttpClient $client) {
		$this->client = $client;
		return $this;
	}

	/**
	 * @return \Application\Http\Client\AbstractHttpClient
	 */
	public function getClient() {
		return $this->client;
	}
}