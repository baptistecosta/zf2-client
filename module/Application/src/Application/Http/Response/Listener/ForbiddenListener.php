<?php

namespace Application\Http\Response\Listener;


use Application\Session\Container\SessionIdentityAwareInterface;
use Application\Session\Container\SessionIdentityAwareTrait;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\Response;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class ForbiddenListener
 * @package Application\Http\Response\Listener
 */
class ForbiddenListener implements ListenerAggregateInterface, ServiceLocatorAwareInterface, SessionIdentityAwareInterface {

	use ServiceLocatorAwareTrait;
	use SessionIdentityAwareTrait;

	protected $listeners = [];

	public function attach(EventManagerInterface $events) {
		$this->listeners[] = $events->attach('forbidden', [$this, 'onForbidden'], 1000);
	}

	public function detach(EventManagerInterface $events) {
		foreach ($this->listeners as $index => $listener) {
			if ($events->detach($listener)) {
				unset($this->listeners[$index]);
			}
		}
	}

	/**
	 * On forbidden request.
	 *
	 * @param Event $e
	 * @return Response
	 */
	public function onForbidden(Event $e) {
		$this->getIdentity()->offsetUnset('tokenData');

		$services = $this->getServiceLocator();

		/** @var $flash FlashMessenger */
		$services
			->get('ControllerPluginManager')
			->get('flashMessenger')
			->setNamespace('error')
			->addMessage('You are not authorized to access this resource.');

		/** @var $appResponse Response */
		$appResponse = $services->get('Response');
		$appResponse->setStatusCode(Response::STATUS_CODE_302);
		$appResponse->getHeaders()->addHeaderLine('Location', '/sign-in');
		return $appResponse;
	}
}