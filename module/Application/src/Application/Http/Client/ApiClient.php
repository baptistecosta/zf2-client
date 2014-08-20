<?php

namespace Application\Http\Client;


use Application\Session\Container\SessionIdentityAwareInterface;
use Application\Session\Container\SessionIdentityAwareTrait;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Http\Client;
use Zend\Http\Response;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class ApiClient
 * @package Application\Http\Client
 */
class ApiClient implements ServiceLocatorAwareInterface, SessionIdentityAwareInterface, EventManagerAwareInterface {

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
		if ($this->getIdentity()->offsetExists('tokenData')) {
			$tokenData = $this->getIdentity()->offsetGet('tokenData');
			$headers['Authorization'] = 'Bearer ' . $tokenData['access_token'];
		}

		$apiResponse = $this->client
			->setUri($this->baseUrl . $uri)
			->setMethod($method)
			->setHeaders($headers)
			->setParameterPost($params)
			->send();

		return $this->getEventManager()->trigger('do-request.post', $this, ['apiResponse' => $apiResponse])->last();
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