<?php

namespace Application\Http\Client\Standard;


use Application\Http\Service\AbstractHttpClient;
use Zend\Http\Response;

class HttpClient extends AbstractHttpClient {

	public function init() {
		$this->client->setHeaders([
			'Accept' => 'application/json'
		]);
	}
}