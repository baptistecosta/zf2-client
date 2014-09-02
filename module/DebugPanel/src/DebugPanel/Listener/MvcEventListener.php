<?php

namespace DebugPanel\Listener;


use DebugPanel\Injector;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

/**
 * Class MvcEventListener
 *
 * @package DebugPanel\Listener
 */
class MvcEventListener extends AbstractListenerAggregate {

	/**
	 * @var Injector $injector
	 */
	protected $injector;

	public function attach(EventManagerInterface $events) {
		$this->listeners[] = $events->attach(MvcEvent::EVENT_FINISH, [$this, 'injectDebugPanel']);
	}

	public function injectDebugPanel(Event $e) {
		$this->injector->process($e->getParam('response'));
	}

	/**
	 * @param Injector $injector
	 * @return $this
	 */
	public function setInjector(Injector $injector) {
		$this->injector = $injector;
		return $this;
	}
}