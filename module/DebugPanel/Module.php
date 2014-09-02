<?php

namespace DebugPanel;

use DebugPanel\Listener\ApiClientListener;
use DebugPanel\Listener\MvcEventListener;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\Application;
use Zend\ServiceManager\ServiceManager;

class Module implements BootstrapListenerInterface, ConfigProviderInterface, AutoloaderProviderInterface {

	public function onBootstrap(EventInterface $e) {
		/** @var $application Application */
		$application = $e->getApplication();

		/** @var $services ServiceManager */
		$services = $application->getServiceManager();

		/** @var Injector $injector */
		$injector = $services->get('DebugPanel\\Injector');

		/** @var ApiClientListener $listener */
		$listener = $services->get('DebugPanel\\Listener\\ApiClient');
		$listener->setInjector($injector);
		$services->get('api-client')->getEventManager()->attachAggregate($listener);

		/** @var MvcEventListener $listener */
		$listener = $services->get('DebugPanel\\Listener\\MvcEvent');
		$listener->setInjector($injector);
		$application->getEventManager()->attachAggregate($listener);
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
}
