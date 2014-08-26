<?php

namespace Application\Http\Client;


use Application\Session\Container\SessionIdentityAwareInterface;
use Application\Session\Container\SessionIdentityAwareTrait;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Http\Client;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class ApiClient
 * @package Application\Http\Client
 */
class ApiClient implements ServiceLocatorAwareInterface, SessionIdentityAwareInterface, EventManagerAwareInterface {

	use EventManagerAwareTrait;
	use ServiceLocatorAwareTrait;
	use SessionIdentityAwareTrait;

	const EVENT_REQUEST_PRE = 'request.pre';
	const EVENT_REQUEST_POST = 'request.post';

	const CLIENT_ID = 'sefaireaider-website';
	const CLIENT_SECRET = '{7W5Vy?rxT;Ax9b';

	/**
	 * @var $client Client
	 */
	protected $client;

	/**
	 * @param Client $client
	 * @return $this
	 */
	public function setClient(Client $client) {
		$this->client = $client;
		return $this;
	}

	public function send(Request $request, $triggerPreEvent = true) {
		if ($triggerPreEvent) {
			$this->getEventManager()->trigger(self::EVENT_REQUEST_PRE, $this, ['apiRequest' => $request]);
		}
		$apiResponse = $this->client->send($request);
		$this->getEventManager()->trigger(self::EVENT_REQUEST_POST, $this, ['apiResponse' => $apiResponse]);
		return $apiResponse;
	}
}