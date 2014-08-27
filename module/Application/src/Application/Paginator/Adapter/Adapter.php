<?php

namespace Application\Paginator\Adapter;


use Application\Http\Client\ApiClient;
use Zend\Http\Request;
use Zend\Paginator\Adapter\AdapterInterface;

class Adapter implements AdapterInterface {

	/**
	 * @var ApiClient $client
	 */
	protected $client;

	/**
	 * @var Request $request
	 */
	protected $request;

	/**
	 * Items
	 */
	protected $items;

	/**
	 * Total number of items in collection.
	 *
	 * @var int
	 */
	protected $totalItems = 0;

	/**
	 * Number of pages.
	 *
	 * @var int
	 */
	protected $pageCount = 0;

	function __construct(ApiClient $client, Request $request) {
		$this->client = $client;
		$this->request = $request;
	}

	/**
	 * Returns a collection of items for a page.
	 *
	 * @param $page
	 * @param $itemCountPerPage
	 * @internal param array $queryParams
	 * @internal param int $page Page offset
	 * @internal param int $itemCountPerPage Number of items per page
	 * @return array
	 */
	public function getItems($page, $itemCountPerPage) {
		$response = $this->client->send($this->request);
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
	}

	/**
	 * Return the number of pages.
	 *
	 * @return int
	 */
	public function getPageCount() {
		return $this->pageCount;
	}

	/**
	 * Return the item count in the current page.
	 *
	 * @return int
	 */
	public function getItemCountInCurrentPage() {
		return count($this->items);
	}

	/**
	 * @return array
	 */
	public function getRequest() {
		return $this->request;
	}
}