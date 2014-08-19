<?php

namespace Application\Http\Client\Standard;


use Zend\Http\Client;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class HttpClientFactory
 * @package Application\Http\Client\Standard
 */
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

		return new HttpClient($client);
	}
}