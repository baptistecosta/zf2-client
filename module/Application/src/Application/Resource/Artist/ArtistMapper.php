<?php

namespace Application\Resource\Artist;


use Application\Paginator\Adapter\ApigilityAdapter;
use Application\Paginator\ApigilityPaginator;
use Application\Paginator\ProtoApigilityPaginator;
use Application\Paginator\ScrollingStyle\Sliding;
use Application\Resource\AbstractMapper;
use Zend\Http\Response;
use Zend\Paginator\Paginator;

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
		$response = $this->getApiClient()->get('/artist/' . $id);
		return json_decode($response->getBody(), true);
	}

	public function getAll($page, $size) {
//		$api = $this->getApiClient();
//		$response = $api->get('/artist', [
//			'query' => [
//				'page' => $page,
//				'page_size' => $size
//			]
//		]);
//		return json_decode($response->getBody(), true);

		$apigilityAdapter = new ApigilityAdapter($this->getApiClient());
//		return new Paginator($apigilityAdapter);
//		return new ApigilityPaginator($apigilityAdapter);
		return new ProtoApigilityPaginator($apigilityAdapter, new Sliding());
	}

	public function delete() {

	}

	public function update() {

	}
}