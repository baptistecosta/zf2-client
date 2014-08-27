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
		$clientRequest = $this->getRequestBuilder()->get('/artist/' . $id, [
			'headers' => [
				'Accept' => [
					'text/html',
					'application/json',
				],
				'Content-Type' => [
					'text/html'
				]
			]
		]);
		$apiResponse = $this->getApiClient()->send($clientRequest);

		return json_decode($apiResponse->getBody(), true);
	}

	public function getAll(array $params = []) {
		$request = $this->getRequestBuilder()->get('/artist', ['query' => $params]);

		$adapter = new Adapter($this->getApiClient(), $request);
		$paginator = new Paginator($adapter, new Sliding());
		$paginator->setCurrentPageNumber(empty($params['page']) ? 1 : $params['page']);
		$paginator->setItemCountPerPage(empty($params['page_size']) ? 5 : $params['page_size']);
		return $paginator;
	}

	public function delete() {

	}

	public function update() {

	}
}