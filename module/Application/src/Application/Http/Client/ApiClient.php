<?php

namespace Application\Http\Client;


use Application\Session\Container\SessionIdentityAwareInterface;
use Application\Session\Container\SessionIdentityAwareTrait;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Http\Client;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Stdlib\Parameters;

/**
 * Class ApiClient
 * @package Application\Http\Client
 */
class ApiClient implements ServiceLocatorAwareInterface, SessionIdentityAwareInterface, EventManagerAwareInterface {

	use EventManagerAwareTrait;
	use ServiceLocatorAwareTrait;
	use SessionIdentityAwareTrait;

	const EVENT_REQUEST_PRE = 'request.pre';
	const EVENT_REQUEST_POST = 'request.post';

	const CLIENT_ID = 'sefaireaider-website';
	const CLIENT_SECRET = '{7W5Vy?rxT;Ax9b';

	/**
	 * @var $client Client
	 */
	protected $client;

	/**
	 * @var $baseUrl
	 */
	protected $baseUrl;

	/**
	 * @param Client $client
	 * @return $this
	 */
	public function setClient(Client $client) {
		$this->client = $client;
		return $this;
	}

	/**
	 * @param mixed $baseUrl
	 * @return $this
	 */
	public function setBaseUrl($baseUrl) {
		$this->baseUrl = $baseUrl;
		return $this;
	}

	/**
	 * @param $resource
	 * @param array $settings
	 * @return Response
	 */
	public function request($resource, $settings = []) {
		$apiRequest = new Request();
		$apiRequest->setUri($this->baseUrl . $resource);
		$apiRequest->setMethod(empty($settings['method']) ? 'GET' : $settings['method']);
		if (!empty($settings['headers'])) {
			$apiRequest->setHeaders($settings['headers']);
		}
		if (!empty($settings['query'])) {
			$params = new Parameters($settings['query']);
			$apiRequest->setQuery($params);
		}
		if (!empty($settings['post'])) {
			$apiRequest->setPost($settings['post']);
		}

		$this->getEventManager()->trigger(self::EVENT_REQUEST_PRE, $this, ['apiRequest' => $apiRequest]);

		$apiResponse = $this->client->send($apiRequest);

		$this->getEventManager()->trigger(self::EVENT_REQUEST_POST, $this, ['apiResponse' => $apiResponse]);
		return $apiResponse;
	}

	/**
	 * Request token.
	 *
	 * @param null $username
	 * @param null $password
	 * @return Response
	 */
	public function requestToken($username, $password) {
		$apiResponse = $this->client
			->setMethod('POST')
			->setUri($this->baseUrl . '/oauth')
			->setHeaders(['Accept' => 'application/json'])
			->setParameterPost([
				'grant_type' => 'password',
				'username' => $username,
				'password' => $password,
				'client_id' => self::CLIENT_ID,
				'client_secret' => self::CLIENT_SECRET,
			])
			->send();

		return $this->getEventManager()->trigger('do-request.post', $this, ['apiResponse' => $apiResponse])->last();
	}

	/**
	 * GET request.
	 *
	 * @param $uri
	 * @param $settings
	 * @return \Zend\Http\Response
	 */
	public function get($uri, $settings = []) {
		return $this->request($uri, $settings);
	}

	/**
	 * POST request.
	 *
	 * @param $uri
	 * @param $settings
	 * @return Response
	 */
	public function post($uri, $settings = []) {
		return $this->request($uri, array_merge([
			'method' => 'POST'
		], $settings));
	}

	/**
	 * PUT request.
	 *
	 * @param $uri
	 * @param $settings
	 * @return mixed
	 */
	public function put($uri, $settings = []) {
		return $this->request($uri, array_merge([
			'method' => 'PUT'
		], $settings));
	}

	/**
	 * PATCH request.
	 *
	 * @param $uri
	 * @param $settings
	 * @return mixed
	 */
	public function patch($uri, $settings = []) {
		return $this->request($uri, array_merge([
			'method' => 'PATCH'
		], $settings));
	}

	/**
	 * DELETE request.
	 *
	 * @param $uri
	 * @param $settings
	 * @return mixed
	 */
	public function delete($uri, $settings = []) {
		return $this->request($uri, array_merge([
			'method' => 'DELETE'
		], $settings));
	}
}