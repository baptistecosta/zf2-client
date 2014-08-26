<?php

namespace Application\Controller;


use Application\Resource\Artist\ArtistMapperGetterTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ArtistController extends AbstractActionController {

	use ArtistMapperGetterTrait;

	public function indexAction() {
		$artistCollection = $this->getArtistMapper()->getAll([
			'query' => $this->params()->fromQuery()
		]);
		return new ViewModel([
			'artistCollection' => $artistCollection,
		]);
	}

	public function getAction() {
		$artistData = $this->getArtistMapper()->get(1);
		return new ViewModel(['data' => $artistData]);
	}
}