<?php

namespace Application\Controller;

use Application\Http\HttpServiceAwareTrait;
use Application\Session\Container\SessionIdentityAwareInterface;
use Application\Session\Container\SessionIdentityAwareTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController implements SessionIdentityAwareInterface {

	use HttpServiceAwareTrait;
	use SessionIdentityAwareTrait;

	public function indexAction() {
		return new ViewModel();
	}

	public function artistAction() {
		$http = $this->getHttpService();
		$response = $http->get('/artist/1');
	}
}