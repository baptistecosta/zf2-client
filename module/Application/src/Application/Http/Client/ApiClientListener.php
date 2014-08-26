<?php

namespace Application\Http\Client;


use Application\Session\Container\SessionIdentityAwareInterface;
use Application\Session\Container\SessionIdentityAwareTrait;
use ArrayIterator;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\Header\Accept;
use Zend\Http\Header\HeaderInterface;
use Zend\Http\Headers;
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
		if (!$this->acceptApplicationJson($headers)) {
			$headers->addHeaderLine('Accept', 'application/json');
		}
		if ($apiRequest->isPost() || $apiRequest->isPut() || $apiRequest->isPatch() && !$headers->offsetGet('Content-Type')) {
			$headers->addHeaderLine('Content-Type', 'application/x-www-form-urlencoded');
		}

		if ($this->getIdentity()->offsetExists('tokenData')) {
			$tokenData = $this->getIdentity()->offsetGet('tokenData');
			$headers->addHeaderLine('Authorization', 'Bearer ' . $tokenData['access_token']);
		}
	}

	private function acceptApplicationJson(Headers $headers) {
		$headerKey = 'Accept';
		$mediaType = 'application/json';
		$accept = $headers->get($headerKey);
		if (is_bool($accept) && !$accept) {
			return false;
		} else if ($accept instanceof ArrayIterator) {
			foreach ($accept as $val) {
				if ($val->hasMediaType($mediaType)) {
					return true;
				}
			}
		} else if ($accept instanceof Accept) {
			return ($accept->hasMediaType($mediaType));
		}
		return false;
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