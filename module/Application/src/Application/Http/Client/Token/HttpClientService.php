<?php

namespace Application\Http\Client\Token;


use Application\Http\Client\AbstractHttpClientService;
use Application\Session\Container\SessionIdentityAwareTrait;
use Zend\Http\Response;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class HttpClientService extends AbstractHttpClientService {

	/**
	 * @return mixed
	 */
	public function request() {
		if ($this->getIdentity()->offsetExists('accessToken')) {
			return $this->getIdentity()->offsetGet('accessToken');
		}

		$postParams = [
			'grant_type' => 'password',
			'username' => 'baptiste',
			'password' => 'popo',
			'client_id' => self::CLIENT_ID,
			'client_secret' => self::CLIENT_SECRET
		];

		$response = $this->getClient()
			->setParameterPost($postParams)
			->send();

		if ($response->isSuccess()) {
			$body = json_decode($response->getBody(), true);
			$this->getIdentity()->accessToken = $body['access_token'];
			$this->getIdentity()->refreshToken = $body['refresh_token'];
			return $body['access_token'];
		} else {
			// User is not authenticated, redirect him to the sign in page.
		}
	}

	/**
	 * @param $refreshToken
	 * @return mixed
	 */
	public function refresh($refreshToken) {
		$postParams = [
			'grant_type' => 'refresh_token',
			'refresh_token' => $refreshToken
		];

		$response = $this->getClient()
			->setParameterPost($postParams)
			->send();

		if ($response->isSuccess()) {
			return json_decode($response->getBody(), true);
		} else {
			//
		}
	}
}