<?php

namespace Application\Controller;

use Application\Resource\Artist\ArtistMapperGetterTrait;
use Application\Session\Container\SessionIdentityAwareTrait;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

	use ArtistMapperGetterTrait;

	public function indexAction() {
		return new ViewModel();
	}
}