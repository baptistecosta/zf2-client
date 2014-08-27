<?php

namespace Application\Controller;


use Application\Resource\Artist\ArtistMapperGetterTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ArtistController extends AbstractActionController {

	use ArtistMapperGetterTrait;

	public function indexAction() {
		$query = $this->params()->fromQuery();
		$artistCollection = $this->getArtistMapper()->getAll($query);
		return new ViewModel([
			'artistCollection' => $artistCollection,
			'query' => $query
		]);
	}

	public function getAction() {
		$artistData = $this->getArtistMapper()->get(1);
		return new ViewModel(['artistData' => $artistData]);
	}
}