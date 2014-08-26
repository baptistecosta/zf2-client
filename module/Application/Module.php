<?php

namespace Application;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManager;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\Mvc\Application;
use Zend\Mvc\ModuleRouteListener;
use Zend\ServiceManager\ServiceManager;

class Module implements BootstrapListenerInterface, ConfigProviderInterface, AutoloaderProviderInterface, ControllerProviderInterface, ViewHelperProviderInterface {

	public function onBootstrap(EventInterface $e) {
		/** @var $application Application */
		$application = $e->getApplication();

		/** @var $services ServiceManager */
		$services = $application->getServiceManager();

		$eventManager = $application->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);

		/** @var $apiClientEventManager EventManager */
		$apiClientEventManager = $services->get('api-client')->getEventManager();
		$apiClientEventManager->attachAggregate($services->get('Application\\Http\\Client\\ApiListener'));

		/** @var $apiResponseHandlerEventManager EventManager */
		$apiResponseHandlerEventManager = $services->get('Application\\Http\\Response\\ApiResponseHandler')->getEventManager();
		$apiResponseHandlerEventManager->attachAggregate($services->get('Application\\Http\\Response\\Listener\\ClientError'));
		$apiResponseHandlerEventManager->attachAggregate($services->get('Application\\Http\\Response\\Listener\\Forbidden'));
		$apiResponseHandlerEventManager->attachAggregate($services->get('Application\\Http\\Response\\Listener\\NotFound'));
		$apiResponseHandlerEventManager->attachAggregate($services->get('Application\\Http\\Response\\Listener\\Redirect'));
		$apiResponseHandlerEventManager->attachAggregate($services->get('Application\\Http\\Response\\Listener\\ServerError'));
	}

	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
					'SFA' => __DIR__ . '/../../vendor/sefaireaider/src/SFA'
				),
			),
		);
	}

	public function getControllerConfig() {
		return [
			'invokables' => [
				'Application\\Controller\\Auth' => 'Application\\Controller\\AuthController',
				'Application\\Controller\\Index' => 'Application\\Controller\\IndexController',
				'Application\\Controller\\Artist' => 'Application\\Controller\\ArtistController',
			],
			'initializers' => [
				'Application\\Session\\Container\\SessionIdentityInitializer',
			]
		];
	}

	/**
	 * Expected to return \Zend\ServiceManager\Config object or array to
	 * seed such an object.
	 *
	 * @return array|\Zend\ServiceManager\Config
	 */
	public function getViewHelperConfig() {
		return [
			'invokables' => [
				'PaginationControl' => 'Application\\View\\Helper\\PaginationControl'
			]
		];
	}
}
