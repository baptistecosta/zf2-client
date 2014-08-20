<?php
/**
 * Created by PhpStorm.
 * User: Baptiste
 * Date: 20/08/14
 * Time: 16:08
 */

namespace Application\Http\Response\Listener;


use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class RedirectListener implements ListenerAggregateInterface {

	public function attach(EventManagerInterface $events) {
	}

	public function detach(EventManagerInterface $events) {
	}
}