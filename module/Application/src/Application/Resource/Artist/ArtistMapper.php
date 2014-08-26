<?php

namespace Application\Resource\Artist;


use Application\Paginator\Adapter\ApigilityAdapter;
use Application\Paginator\ApigilityPaginator;
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
		$response = $this->getApiClient()->get('/artist/' . $id);
		return json_decode($response->getBody(), true);
	}

	public function getAll($requestSettings) {
		$adapter = new ApigilityAdapter($this->getApiClient(), $requestSettings);
		return new ApigilityPaginator($adapter, new Sliding());
	}

	public function delete() {

	}

	public function update() {

	}
}