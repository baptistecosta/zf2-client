<?php

namespace Application;

use Application\Http\Client\ApiClientListener;
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

		/** @var $eventManager EventManager */
		$eventManager = $application->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);

		/** @var ApiClientListener $listener */
		$listener = $services->get('Application\\Http\\Client\\ApiListener');
		$eventManager = $services->get('api-client')->getEventManager();
		$eventManager->attachAggregate($listener);

		$eventManager = $services->get('Application\\Http\\Response\\ApiResponseHandler')->getEventManager();
		$eventManager->attachAggregate($services->get('Application\\Http\\Response\\Listener\\ClientError'));
		$eventManager->attachAggregate($services->get('Application\\Http\\Response\\Listener\\Forbidden'));
		$eventManager->attachAggregate($services->get('Application\\Http\\Response\\Listener\\NotFound'));
		$eventManager->attachAggregate($services->get('Application\\Http\\Response\\Listener\\Redirect'));
		$eventManager->attachAggregate($services->get('Application\\Http\\Response\\Listener\\ServerError'));

		$eventManager = $services->get('request-builder')->getEventManager();
		$eventManager->attachAggregate($services->get('Application\\Http\\Request\\Listener'));
	}

	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig() {
		return [
			'Zend\Loader\StandardAutoloader' => [
				'namespaces' => [
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				],
			],
		];
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
