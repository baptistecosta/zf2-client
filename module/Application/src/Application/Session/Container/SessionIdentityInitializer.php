<?php

namespace Application\Session\Container;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class SessionIdentityInitializer
 * @package Application\Session\Container
 */
class SessionIdentityInitializer implements InitializerInterface {

	public function initialize($instance, ServiceLocatorInterface $serviceLocator) {
		if ($instance instanceof AbstractActionController) {
			$identity = $serviceLocator->getServiceLocator()->get('identity');;
		} else if ($instance instanceof SessionIdentityAwareInterface) {
			$identity = $serviceLocator->get('identity');
		}
		if (isset($identity)) {
			$instance->setIdentity($identity);
		}
	}
}