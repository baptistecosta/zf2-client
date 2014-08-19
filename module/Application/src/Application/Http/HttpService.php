<?php

namespace Application\Http;


use Application\Session\Container\SessionIdentityAwareInterface;
use Application\Session\Container\SessionIdentityAwareTrait;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Http\Client;
use Zend\Http\Response;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class HttpService implements ServiceLocatorAwareInterface, SessionIdentityAwareInterface, EventManagerAwareInterface {

	use EventManagerAwareTrait;
	use ServiceLocatorAwareTrait;
	use SessionIdentityAwareTrait;

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
	 * @param $uri
	 * @param string $method
	 * @param array $params
	 * @return mixed
	 */
	public function doRequest($uri, $method = 'GET', $params = []) {
		$headers = ['Accept' => 'application/json'];
		if ($this->getIdentity()->offsetExists('accessToken')) {
			$headers['Authorization'] = 'Bearer ' . $this->getIdentity()->offsetGet('accessToken');
		}

		$response = $this->client
			->setUri($this->baseUrl . $uri)
			->setMethod($method)
			->setHeaders($headers)
			->setParameterPost($params)
			->send();

		if ($response->isSuccess()) {
			return json_decode($response->getBody(), true);
		} else if ($response->isForbidden()) {

			$this->getEventManager()->trigger('request-forbidden');

//			$this->getIdentity()->offsetUnset('accessToken');
//			if ($this->requestToken()) {
//				$this->doRequest($uri, $method);
//			}
		}
	}

	/**
	 * Request token.
	 *
	 * @param null $username
	 * @param null $password
	 * @return mixed|null
	 */
	public function requestToken($username, $password) {
		$postParams = [
			'grant_type' => 'password',
			'username' => $username,
			'password' => $password,
			'client_id' => self::CLIENT_ID,
			'client_secret' => self::CLIENT_SECRET,
		];

		$response = $this->client
			->setMethod('POST')
			->setUri($this->baseUrl . '/oauth')
			->setParameterPost($postParams)
			->setHeaders(['Accept' => 'application/json'])
			->send();

		if ($response->isSuccess()) {
			$body = json_decode($response->getBody(), true);
			$this->getEventManager()->trigger('request-token-success', $this, ['tokenData' => $body]);
		} else {
			$this->getEventManager()->trigger('request-token-error');
		}
	}

	/**
	 * GET request.
	 *
	 * @param $uri
	 * @return mixed
	 */
	public function get($uri) {
		return $this->doRequest($uri, 'GET');
	}

	/**
	 * POST request.
	 *
	 * @param $uri
	 * @param $params
	 * @return mixed
	 */
	public function post($uri, $params) {
		return $this->doRequest($uri, 'POST', $params);
	}

	/**
	 * PUT request.
	 *
	 * @param $uri
	 * @param $params
	 * @return mixed
	 */
	public function put($uri, $params) {
		return $this->doRequest($uri, 'PUT', $params);
	}

	/**
	 * PATCH request.
	 *
	 * @param $uri
	 * @param $params
	 * @return mixed
	 */
	public function patch($uri, $params) {
		return $this->doRequest($uri, 'PATCH', $params);
	}

	/**
	 * DELETE request.
	 *
	 * @param $uri
	 * @param $params
	 * @return mixed
	 */
	public function delete($uri, $params) {
		return $this->doRequest($uri, 'DELETE', $params);
	}
}