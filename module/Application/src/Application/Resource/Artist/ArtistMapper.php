<?php

namespace Application\Resource\Artist;


use Application\Http\Client\ApiClientAwareTrait;
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

	public function getAll() {

	}

	public function delete() {

	}

	public function update() {

	}
}