<?php

namespace Application\Resource;


use Application\Http\Client\ApiClient;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AbstractMapperFactory implements AbstractFactoryInterface {

	/**
	 * Determine if we can create a service with name
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @param $name
	 * @param $requestedName
	 * @return bool
	 */
	public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
		return substr($requestedName, -strlen('Mapper')) === 'Mapper';
	}

	/**
	 * Create service with name
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @param $name
	 * @param $requestedName
	 * @return mixed
	 */
	public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
		/** @var $apiClient ApiClient */
		$apiClient = $serviceLocator->get('api-client');

		/** @var $mapper AbstractMapper */
		$mapper = new $requestedName();
		$mapper->setApiClient($apiClient);
		return $mapper;
	}
}