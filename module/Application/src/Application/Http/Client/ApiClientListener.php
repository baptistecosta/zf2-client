<?php

namespace Application\Http\Client;


use Application\Session\Container\SessionIdentityAwareInterface;
use Application\Session\Container\SessionIdentityAwareTrait;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\Request;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class ApiClientListener
 * @package Application\Http\Client
 */
class ApiClientListener implements ListenerAggregateInterface, ServiceLocatorAwareInterface, SessionIdentityAwareInterface {

	use ServiceLocatorAwareTrait;
	use SessionIdentityAwareTrait;

	protected $listeners = [];

	public function attach(EventManagerInterface $events) {
		$this->listeners[] = $events->attach(ApiClient::EVENT_REQUEST_PRE, [$this, 'onRequestPre'], 1000);
		$this->listeners[] = $events->attach(ApiClient::EVENT_REQUEST_POST, [$this, 'onRequestPost'], 1000);
		$this->listeners[] = $events->attach('do-request.post', [$this, 'onDoRequestPost'], 1000);
//		$this->listeners[] = $events->attach('request-forbidden', [$this, 'onRequestForbidden'], 50);
	}

	public function detach(EventManagerInterface $events) {
		foreach ($this->listeners as $index => $listener) {
			if ($events->detach($listener)) {
				unset($this->listeners[$index]);
			}
		}
	}

	public function onRequestPre(Event $e) {
		/** @var $apiRequest Request */
		$apiRequest = $e->getParam('apiRequest');
		$headers = $apiRequest->getHeaders();
		$headers->addHeaderLine('Accept', 'application/json');
		if ($this->getIdentity()->offsetExists('tokenData')) {
			$tokenData = $this->getIdentity()->offsetGet('tokenData');
			$headers->addHeaderLine('Authorization', 'Bearer ' . $tokenData['access_token']);
		}
	}

	public function onRequestPost(Event $e) {
		$apiResponseHandler = $this->getServiceLocator()->get('Application\\Http\\Response\\ApiResponseHandler');
		return $apiResponseHandler->process($e->getParam('apiResponse'));
	}

	public function onDoRequestPost(Event $e) {
		$apiResponseHandler = $this->getServiceLocator()->get('Application\\Http\\Response\\ApiResponseHandler');
		return $apiResponseHandler->process($e->getParam('apiResponse'));
	}
}