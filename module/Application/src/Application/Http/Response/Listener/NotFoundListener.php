<?php

namespace Application\Http\Response\Listener;


use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class NotFoundListener implements ListenerAggregateInterface {

	public function attach(EventManagerInterface $events) {
	}

	public function detach(EventManagerInterface $events) {
	}
}