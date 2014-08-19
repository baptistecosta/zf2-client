<?php

namespace Application;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\Mvc\ModuleRouteListener;

class Module implements BootstrapListenerInterface, ConfigProviderInterface, AutoloaderProviderInterface, ControllerProviderInterface {

	public function onBootstrap(EventInterface $e) {
		$eventManager = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
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
				'Application\\Controller\\Index' => 'Application\\Controller\\IndexController'
			],
			'factories' => [
//				'Application\\Controller\\Index' => 'Application\\Controller\\IndexControllerFactory',
			],
			'initializers' => [
				'Application\\Session\\Container\\SessionIdentityInitializer',
			]
		];
	}
}
