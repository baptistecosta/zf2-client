<?php

namespace Application\Resource\Auth;


use Application\Http\Client\ApiClient;
use Application\Resource\AbstractMapper;
use Zend\Http\Response;

/**
 * Class AuthMapper
 * @package Application\Resource\Auth
 */
class AuthMapper extends AbstractMapper {

	/**
	 * @param $username
	 * @param $password
	 * @return Response
	 */
	public function requestToken($username, $password) {
		$req = $this->getRequestBuilder()->post('/oauth', [
			'headers' => [
				'Content-Type' => 'application/x-www-form-urlencoded',
				'Accept' => 'application/json'
			],
			'post' => [
				'grant_type' => 'password',
				'username' => $username,
				'password' => $password,
				'client_id' => ApiClient::CLIENT_ID,
				'client_secret' => ApiClient::CLIENT_SECRET,
			]
		]);

		$reqStr = $req->toString();

		$apiResponse = $this->getApiClient()->send($req, false);
		return $apiResponse;
	}
}