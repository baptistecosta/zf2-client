<?php

namespace Application\Http\Client\Token;


use Zend\Http\Client;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class HttpClientFactory implements FactoryInterface {

	/**
	 * Create service
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return mixed
	 */
	public function createService(ServiceLocatorInterface $serviceLocator) {
		$client = new Client();
		$client->setAdapter('Zend\\Http\\Client\\Adapter\\Curl');

		/** @var $identity \Zend\Session\Container */
		$identity = $serviceLocator->get('identity');

		return new HttpClient($client, $identity);
	}
}