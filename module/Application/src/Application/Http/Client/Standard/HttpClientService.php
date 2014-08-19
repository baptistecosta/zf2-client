<?php

namespace Application\Http\Client\Standard;


use Application\Http\Client\AbstractHttpClientService;
use Application\Session\Container\SessionIdentityAwareTrait;
use Zend\Http\Response;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class HttpClientService
 * @package Application\Http\Client\Standard
 */
class HttpClientService extends AbstractHttpClientService {

	/**
	 * @param $uri
	 * @return mixed
	 */
	public function request($uri) {
		/** @var $response Response */
		$response = $this->getClient()
			->setUri($uri)
			->send();

		if ($response->isSuccess()) {
			return json_decode($response->getBody(), true);
		} else if ($response->isForbidden()) {
			//
		}
	}
}