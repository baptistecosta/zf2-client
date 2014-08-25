<?php

namespace Application\Paginator\Adapter;


use Application\Http\Client\ApiClient;
use Zend\Paginator\Adapter\AdapterInterface;

class ApigilityAdapter implements AdapterInterface {

	/**
	 * @var $client ApiClient
	 */
	protected $client;

	protected $items;

	protected $totalItems = 0;

	protected $pageCount = 0;

	function __construct(ApiClient $client) {
		$this->client = $client;
	}

	/**
	 * Returns a collection of items for a page.
	 *
	 * @param  int $page Page offset
	 * @param  int $itemCountPerPage Number of items per page
	 * @return array
	 */
	public function getItems($page, $itemCountPerPage) {
//		$page = $this->getPage($page, $itemCountPerPage);
		$response = $this->client->get('/artist', [
			'query' => [
				'page' => $page,
				'page_size' => $itemCountPerPage
			]
		]);
		$body = json_decode($response->getBody(), true);

		$this->items = current($body['_embedded']);
		$this->totalItems = $body['total_items'];
		$this->pageCount = $body['page_count'];

		return $this->items;
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Count elements of an object
	 * @link http://php.net/manual/en/countable.count.php
	 * @return int The custom count as an integer.
	 * </p>
	 * <p>
	 * The return value is cast to an integer.
	 */
	public function count() {
		return $this->totalItems;
//		return 5;
	}

	public function getPageCount() {
		return $this->pageCount;
	}

	public function getCurrentItemCount() {
		return count($this->items);
	}

//	protected function getPage($offset, $itemCountPerPage) {
//		return floor(($offset / $itemCountPerPage) + 1);
//	}
}