<?php

namespace Application\Controller;

use Application\Http\Client\Token\HttpClientService;
use Application\Session\Container\SessionIdentityAwareInterface;
use Application\Session\Container\SessionIdentityAwareTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController implements SessionIdentityAwareInterface {

	use SessionIdentityAwareTrait;

	public function indexAction() {

		$this->getIdentity()->offsetUnset('accessToken');
		$this->getIdentity()->offsetUnset('refreshToken');

		/** @var $httpTokenService HttpClientService */
		$httpTokenService = $this->getServiceLocator()->get('Application\\Http\\Client\\Token\\HttpClientService');
		$token = $httpTokenService->request();

		var_dump($token);




		return new ViewModel();
	}
}