<?php

namespace Application\Controller;


use Application\Resource\Artist\ArtistMapperGetterTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ArtistController extends AbstractActionController {

	use ArtistMapperGetterTrait;

	public function indexAction() {
		return new ViewModel([
			'artists' => $this->getArtistMapper()->getAll()
		]);
	}
}