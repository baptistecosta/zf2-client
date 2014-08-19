<?php

namespace Application;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\Mvc\Application;
use Zend\Mvc\ModuleRouteListener;
use Zend\ServiceManager\ServiceManager;

class Module implements BootstrapListenerInterface, ConfigProviderInterface, AutoloaderProviderInterface, ControllerProviderInterface {

	public function onBootstrap(EventInterface $e) {
		/** @var $application Application */
		$application = $e->getApplication();

		/** @var $services ServiceManager */
		$services = $application->getServiceManager();

		$eventManager = $application->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);

		$httpService = $services->get('http-service');
		$httpServiceListener = $services->get('Application\\Http\\HttpServiceListener');
		$httpServiceListener->setMvcEvent($e);
		$httpServiceListener->attach($httpService->getEventManager());
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
			],
			'initializers' => [
				'Application\\Session\\Container\\SessionIdentityInitializer',
			]
		];
	}
}
