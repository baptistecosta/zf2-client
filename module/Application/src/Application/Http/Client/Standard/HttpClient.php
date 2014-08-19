<?php

namespace Application\Http\Client\Standard;


use Application\Http\Client\AbstractHttpClient;

class HttpClient extends AbstractHttpClient {

	public function init() {
		$this->client->setHeaders([
			'Accept' => 'application/json'
		]);
	}
}