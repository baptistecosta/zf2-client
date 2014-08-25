<?php

namespace Application\Paginator\Adapter;


use Zend\Paginator\Adapter\AdapterInterface;

class ApigilityAdapter implements AdapterInterface {

	/**
	 * @var $dataMapper
	 */
	protected $dataMapper;

	function __construct(ApigilityAdapterInterface $dataMapper) {
		$this->$dataMapper = $dataMapper;
	}

	/**
	 * Returns a collection of items for a page.
	 *
	 * @param  int $offset Page offset
	 * @param  int $itemCountPerPage Number of items per page
	 * @return array
	 */
	public function getItems($offset, $itemCountPerPage) {
		$this->dataMapper->getAll($offset, $itemCountPerPage);
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

	}
}