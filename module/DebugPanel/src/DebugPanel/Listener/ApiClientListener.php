<?php

namespace DebugPanel\Listener;

use DebugPanel\Injector;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\Request;

/**
 * Class ApiClientListener
 *
 * @package DebugPanel\Listener
 */
class ApiClientListener extends AbstractListenerAggregate {

	/**
	 * @var Injector $injector
	 */
	protected $injector;

	public function attach(EventManagerInterface $events) {
		$this->listeners[] = $events->attach('send.pre', [$this, 'onSendPre'], 10);
	}

	public function onSendPre(Event $e) {
		/** @var Request $apiRequest */
		$apiRequest = $e->getParam('apiRequest');
		$this->injector->setApiRequest($apiRequest);
	}

	/** Getters & Setters */

	/**
	 * @param $injector
	 * @return $this
	 */
	public function setInjector(Injector $injector) {
		$this->injector = $injector;
		return $this;
	}
}