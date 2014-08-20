<?php

namespace Application\Controller;

use Application\Http\Client\ApiClientAwareTrait;
use Application\Resource\Artist\ArtistMapperGetterTrait;
use Application\Session\Container\SessionIdentityAwareInterface;
use Application\Session\Container\SessionIdentityAwareTrait;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController implements SessionIdentityAwareInterface {

	use ApiClientAwareTrait;
	use SessionIdentityAwareTrait;
	use ArtistMapperGetterTrait;

	public function indexAction() {
		return new ViewModel();
	}

	public function artistAction() {
		return new ViewModel([
			'artist' => $this->getArtistMapper()->get(1)
		]);
	}
}