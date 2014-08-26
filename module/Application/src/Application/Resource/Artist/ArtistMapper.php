<?php

namespace Application\Resource\Artist;


use Application\Paginator\Adapter\Adapter;
use Application\Paginator\Paginator;
use Application\Paginator\ScrollingStyle\Sliding;
use Application\Resource\AbstractMapper;
use Zend\Http\Response;

/**
 * Class ArtistMapper
 * @package Application\Resource\Artist
 */
class ArtistMapper extends AbstractMapper {

	/**
	 * @param $id
	 * @return mixed
	 */
	public function get($id) {
//		$response = $this->getApiClient()->get('/artist/' . $id);

		$clientRequest = $this->getRequestManager()->get('/artist/' . $id);
		$apiResponse = $this->getApiClient()->send($clientRequest);

		return json_decode($apiResponse->getBody(), true);
	}

	public function getAll(array $requestParams = []) {
		$adapter = new Adapter($this->getApiClient(), $requestParams);
		$paginator = new Paginator($adapter, new Sliding());
		$paginator->setCurrentPageNumber(empty($requestParams['query']['page']) ? 1 : $requestParams['query']['page']);
		$paginator->setItemCountPerPage(empty($requestParams['query']['page_size']) ? 5 : $requestParams['query']['page_size']);
		return $paginator;
	}

	public function delete() {

	}

	public function update() {

	}
}