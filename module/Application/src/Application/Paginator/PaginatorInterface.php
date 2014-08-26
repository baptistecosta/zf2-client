<?php

namespace Application\Paginator;


interface PaginatorInterface {

	/**
	 * Returns the page collection.
	 *
	 * @return array
	 */
	public function getPages();

	/**
	 * Return the page range.
	 *
	 * @return int
	 */
	public function getPageRange();

	/**
	 * Returns the current page number.
	 *
	 * @return int
	 */
	public function getCurrentPageNumber();

	/**
	 * Return the number of pages.
	 *
	 * @return int
	 */
	public function getPageCount();

	/**
	 * Returns a subset of pages within a given range.
	 *
	 * @param int $lowerBound
	 * @param int $upperBound
	 * @return array
	 */
	public function getPagesInRange($lowerBound, $upperBound);
} 