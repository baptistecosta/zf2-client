<?php

namespace Application\Http\Client;


use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AbstractHttpClientServiceFactory
 * @package Application\Http\Client
 */
class AbstractHttpClientServiceFactory implements AbstractFactoryInterface {

	private $prefix = 'Application\\Http\\Client';

	/**
	 * Determine if we can create a service with name
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @param $name
	 * @param $requestedName
	 * @return bool
	 */
	public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
		return strpos($requestedName, $this->prefix) === 0;
	}

	/**
	 * Create service with name
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @param $name
	 * @param $requestedName
	 * @throws \Exception
	 * @return mixed
	 */
	public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
		$clientClassName = substr($requestedName, 0, -strlen('\\HttpClientService'));
		$client = $serviceLocator->get($clientClassName);

		$httpService = new $requestedName();
		$httpService->setClient($client);
		return $httpService;
	}
}