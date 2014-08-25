<?php

namespace Application\Resource\Artist;


use Application\Http\Client\ApiClientAwareTrait;
use Application\Paginator\Adapter\ApigilityAdapterInterface;
use Application\Resource\AbstractMapper;
use Zend\Http\Response;

/**
 * Class ArtistMapper
 * @package Application\Resource\Artist
 */
class ArtistMapper extends AbstractMapper implements ApigilityAdapterInterface {

	/**
	 * @param $id
	 * @return mixed
	 */
	public function get($id) {
		$response = $this->getApiClient()->get('/artist/' . $id);
		return json_decode($response->getBody(), true);
	}

	public function getAll($page, $size) {
		$api = $this->getApiClient();
		$response = $api->get('/artist', [
			'query' => [
				'page' => $page,
				'page_size' => $size
			]
		]);
		return json_decode($response->getBody(), true);
	}

	public function delete() {

	}

	public function update() {

	}
}