<?php

namespace Application\Paginator;

use Application\Paginator\Adapter\Adapter;
use ArrayIterator;
use Countable;
use IteratorAggregate;

/**
 * Class Paginator
 *
 * @package Application\Paginator
 */
class Paginator implements Countable, IteratorAggregate, PaginatorInterface {

	/**
	 * @var Adapter $adapter
	 */
	protected $adapter;

	/**
	 * The current page number.
	 *
	 * @var int
	 */
	protected $page;

	/**
	 * Nuùber of items per page.
	 *
	 * @var int
	 */
	protected $itemCountPerPage;

	/**
	 * Number of pages.
	 *
	 * @var int
	 */
	protected $pageCount;

	/**
	 * The scrolling style used for pagination controller.
	 */
	protected $scrollingStyle;

	/**
	 * Number of local pages (i.e., the number of discrete page numbers
	 * that will be displayed, including the current page number)
	 *
	 * @var int
	 */
	protected $pageRange = 10;

	/**
	 * @param Adapter $adapter
	 * @param $scrollingStyle
	 * @throws \Exception
	 */
	function __construct(Adapter $adapter, $scrollingStyle) {
		$this->adapter = $adapter;
		if (!$scrollingStyle) {
			throw new \Exception("Scrolling style class is null.");
		}
		$this->scrollingStyle = $scrollingStyle;
	}

	public function getIterator() {
		$items = $this->adapter->getItems($this->page, $this->itemCountPerPage);
		return new ArrayIterator($items);
	}

	public function count() {
		return $this->adapter->count();
	}

	public function getPages() {
		$pages = new \stdClass();
		$pages->pageCount = $this->getPageCount();
		$pages->itemCountPerPage = $this->getItemCountPerPage();
		$pages->first = 1;
		$pages->current = $this->page;
		$pages->last = $this->getPageCount();

		// Previous and next
		if ($this->page - 1 > 0) {
			$pages->previous = $this->page - 1;
		}

		if ($this->page + 1 <= $this->getPageCount()) {
			$pages->next = $this->page + 1;
		}

		// Pages in range
		$pages->pagesInRange = $this->scrollingStyle->getPages($this);
		$pages->firstPageInRange = min($pages->pagesInRange);
		$pages->lastPageInRange = max($pages->pagesInRange);

		// Item numbers
		$pages->currentItemCount = $this->getCurrentItemCount();
		$pages->totalItemCount   = $this->count();
		$pages->firstItemNumber  = (($this->page - 1) * $this->getItemCountPerPage()) + 1;
		$pages->lastItemNumber   = $pages->firstItemNumber + $pages->currentItemCount - 1;

		return $pages;
	}

	public function getPagesInRange($lowerBound, $upperBound) {
		$lowerBound = $this->normalizePageNumber($lowerBound);
		$upperBound = $this->normalizePageNumber($upperBound);

		$pages = [];

		for ($pageNumber = $lowerBound; $pageNumber <= $upperBound; $pageNumber++) {
			$pages[$pageNumber] = $pageNumber;
		}

		return $pages;
	}

	/**
	 * Brings the page number in range of the paginator.
	 *
	 * @param  int $pageNumber
	 * @return int
	 */
	private function normalizePageNumber($pageNumber) {
		$pageNumber = (int)$pageNumber;

		if ($pageNumber < 1) {
			$pageNumber = 1;
		}

		$pageCount = $this->count();

		if ($pageCount > 0 && $pageNumber > $pageCount) {
			$pageNumber = $pageCount;
		}

		return $pageNumber;
	}

	/**
	 * @return Adapter
	 */
	public function getAdapter() {
		return $this->adapter;
	}

	public function setCurrentPageNumber($page) {
		$this->page = (int)$page;
	}

	public function getCurrentPageNumber() {
		return $this->page;
	}

	public function setItemCountPerPage($itemCountPerPage) {
		$this->itemCountPerPage = $itemCountPerPage;
	}

	public function getItemCountPerPage() {
		return $this->itemCountPerPage;
	}

	public function getPageCount() {
		return $this->adapter->getPageCount();
	}

	public function setPageRange($pageRange) {
		$this->pageRange = $pageRange;
	}

	public function getPageRange() {
		return $this->pageRange;
	}

	public function getCurrentItemCount() {
		return $this->adapter->getItemCountInCurrentPage();
	}

	public function getRequestSettings() {
		return $this->adapter->getRequest();
	}
}