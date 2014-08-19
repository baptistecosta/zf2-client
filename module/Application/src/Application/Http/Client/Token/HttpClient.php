<?php

namespace Application\Http\Client\Token;


use Application\Http\Client\AbstractHttpClient;
use Application\Session\Container\SessionIdentityAwareTrait;
use Zend\Http\Response;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class HttpClient extends AbstractHttpClient {

	public function init() {
		$headers = [
			'Accept' => 'application/json'
		];

		if ($this->identity->offsetExists('accessToken')) {
			$headers['Authentication'] = 'Bearer' . $this->identity->offsetGet('accessToken');
		}

		$this->client->setMethod('POST');
		$this->client->setHeaders([
			'Accept' => 'application/json'
		]);
		$this->client->setUri('http://apigility.loc/oauth');
	}
}