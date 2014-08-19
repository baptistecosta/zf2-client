<?php

namespace Application\Http;


use Application\Session\Container\SessionIdentityAwareInterface;
use Application\Session\Container\SessionIdentityAwareTrait;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\Response;

class HttpServiceListener implements SessionIdentityAwareInterface {

	use SessionIdentityAwareTrait;

	protected $mvcEvent;

	public function setMvcEvent($mvcEvent) {
		$this->mvcEvent = $mvcEvent;
	}

	/**
	 * Attach one or more listeners
	 *
	 * Implementors may add an optional $priority argument; the EventManager
	 * implementation will pass this to the aggregate.
	 *
	 * @param EventManagerInterface $events
	 *
	 * @return void
	 */
	public function attach(EventManagerInterface $events) {
		$this->listeners[] = $events->attach('request-forbidden', [$this, 'onRequestForbidden']);
		$this->listeners[] = $events->attach('request-token-success', [$this, 'onRequestTokenSuccess']);
		$this->listeners[] = $events->attach('request-token-error', [$this, 'onRequestTokenError']);
	}

	public function onRequestForbidden(Event $e) {

	}

	public function onRequestTokenSuccess(Event $e) {
		$this->getIdentity()->tokenData = $e->getParam('tokenData');
	}

	public function onRequestTokenError(Event $e) {
		$this->getIdentity()->offsetUnset('tokenData');
		$response = $this->mvcEvent->getResponse();
		$response->setStatusCode(302);
		$response->getHeaders()->addHeaderLine('Location', '/');
		return $response;
	}
}