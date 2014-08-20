<?php

namespace Application\Http\Response\Listener;


use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class ClientErrorListener implements ListenerAggregateInterface {

	protected $listeners = [];

	public function attach(EventManagerInterface $events) {
		$this->listeners[] = $events->attach('client-error', [$this, 'onClientError'], 1000);
	}

	public function detach(EventManagerInterface $events) {
		foreach ($this->listeners as $index => $listener) {
			if ($events->detach($listener)) {
				unset($this->listeners[$index]);
			}
		}
	}

	/**
	 * On client error response.
	 */
	public function onClientError(Event $e) {
		//
	}
}