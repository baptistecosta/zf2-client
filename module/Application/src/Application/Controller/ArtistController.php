<?php

namespace Application\Controller;


use Application\Paginator\Adapter\ApigilityAdapter;
use Application\Resource\Artist\ArtistMapperGetterTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

class ArtistController extends AbstractActionController {

	use ArtistMapperGetterTrait;

	public function indexAction() {

		$page = $this->params()->fromQuery('page', 1);
		$size = $this->params()->fromQuery('page_size', 5);

//		$paginator = $this->getArtistMapper()->getAll($page, $size);
//		$paginator->setCurrentPageNumber((int)$page);
//		$paginator->setItemCountPerPage($size);

//		$query = [];
//		if ($order = $this->params()->fromQuery('order', null)) {
//			$query['order'] = $order;
//		}

		$paginator = $this->getArtistMapper()->getAll([
			'query' => $this->params()->fromQuery()
		]);
		$paginator->setPage((int)$page);
		$paginator->setItemCountPerPage($size);

//		$paginator->setPage((int)$page);
//		$paginator->setItemCountPerPage($size);
//		if ($order = $this->params()->fromQuery('order', null)) {
//			$paginator->setOrder($order);
//		}


//		$apigilityAdapter = new ApigilityAdapter($this->getArtistMapper());
//		$paginator = new Paginator($apigilityAdapter);


		return new ViewModel([
//			'artists' => $artistData,
			'paginator' => $paginator,
		]);
	}

	public function getAction() {
		$artistData = $this->getArtistMapper()->get(1);
		return new ViewModel(['data' => $artistData]);
	}
}