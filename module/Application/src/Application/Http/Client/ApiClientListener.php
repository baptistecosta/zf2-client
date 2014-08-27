<?php

namespace Application\Http\Client;


use Application\Session\Container\SessionIdentityAwareInterface;
use Application\Session\Container\SessionIdentityAwareTrait;
use ArrayIterator;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\Header\Accept;
use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class ApiClientListener
 * @package Application\Http\Client
 */
class ApiClientListener extends AbstractListenerAggregate implements ServiceLocatorAwareInterface, SessionIdentityAwareInterface {

	use ServiceLocatorAwareTrait;
	use SessionIdentityAwareTrait;

	protected $requestFormatter;

	/**
	 * @param mixed $requestFormatter
	 */
	public function setRequestFormatter($requestFormatter) {
		$this->requestFormatter = $requestFormatter;
	}

	public function attach(EventManagerInterface $events) {
		$this->listeners[] = $events->attach(ApiClient::EVENT_SEND_PRE, [$this, 'handleApiRequestHeaders'], 1000);
		$this->listeners[] = $events->attach(ApiClient::EVENT_SEND_PRE, [$this, 'logRequest'], 10);

		$this->listeners[] = $events->attach(ApiClient::EVENT_SEND_POST, [$this, 'handleApiResponse'], 1000);
	}

	/**
	 * Handle API request header default behavior.
	 *
	 * @param Event $e
	 */
	public function handleApiRequestHeaders(Event $e) {
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

	/**
	 * Format and log/dump the request.
	 *
	 * @param Event $e
	 */
	public function logRequest(Event $e) {
		$apiRequest = $e->getParam('apiRequest');
		var_dump($this->requestFormatter->process($apiRequest));
	}

	/**
	 * Handle API response.
	 *
	 * @param Event $e
	 * @return mixed
	 */
	public function handleApiResponse(Event $e) {
		$apiResponseHandler = $this->getServiceLocator()->get('Application\\Http\\Response\\ApiResponseHandler');
		return $apiResponseHandler->process($e->getParam('apiResponse'));
	}
}