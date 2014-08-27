<?php

namespace Application\Http\Response\Listener;


use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;

class ClientErrorListener extends AbstractListenerAggregate {

	public function attach(EventManagerInterface $events) {
		$this->listeners[] = $events->attach('client-error', [$this, 'onClientError'], 1000);
	}

	/**
	 * On client error response.
	 */
	public function onClientError(Event $e) {
		//
	}
}