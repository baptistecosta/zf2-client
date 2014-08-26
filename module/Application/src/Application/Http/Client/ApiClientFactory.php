<?php

namespace Application\Http\Client;


use Zend\Http\Client;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ApiClientFactory implements FactoryInterface {

	/**
	 * Create service
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return mixed
	 */
	public function createService(ServiceLocatorInterface $serviceLocator) {
		$client = new Client();
		$client->setAdapter('Zend\\Http\\Client\\Adapter\\Curl');

		$apiClient = new ApiClient();
		return $apiClient->setClient($client);
	}
}