<?php

namespace Application\Http\Client;


use Application\Session\Container\SessionIdentityAwareTrait;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class ApiClientListener
 * @package Application\Http\Client
 */
class ApiClientListener implements ListenerAggregateInterface, ServiceLocatorAwareInterface {

	use ServiceLocatorAwareTrait;

	protected $listeners = [];

	public function attach(EventManagerInterface $events) {
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

	public function onDoRequestPost(Event $e) {
		$apiResponseHandler = $this->getServiceLocator()->get('Application\\Http\\Response\\ApiResponseHandler');
		return $apiResponseHandler->process($e->getParam('apiResponse'));
	}

//	/**
//	 * On request forbidden.
//	 *
//	 * @param Event $e
//	 * @return Response
//	 */
//	public function onRequestForbidden(Event $e) {
//		/** @var $response Response */
//		$response = $this->getServiceLocator()->get('Response');
//		$response->setStatusCode(Response::STATUS_CODE_302);
//		$response->getHeaders()->addHeaderLine('Location', '/sign-in');
//		return $response;
//	}
}