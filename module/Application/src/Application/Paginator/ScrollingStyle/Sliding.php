<?php

namespace Application\Paginator\ScrollingStyle;


use Application\Paginator\ApigilityPaginator;

class Sliding {

	/**
	 * Returns an array of "local" pages given a page number and range.
	 *
	 * @param ApigilityPaginator $paginator
	 * @param  int $pageRange (Optional) Page range
	 * @return array
	 */
	public function getPages(ApigilityPaginator $paginator, $pageRange = null) {
		if (!$pageRange) {
			$pageRange = $paginator->getPageRange();
		}

		$pageNumber = $paginator->getCurrentPageNumber();
		$pageCount = $paginator->getPageCount();

		if ($pageRange > $pageCount) {
			$pageRange = $pageCount;
		}

		$delta = ceil($pageRange / 2);

		if ($pageNumber - $delta > $pageCount - $pageRange) {
			$lowerBound = $pageCount - $pageRange + 1;
			$upperBound = $pageCount;
		} else {
			if ($pageNumber - $delta < 0) {
				$delta = $pageNumber;
			}

			$offset = $pageNumber - $delta;
			$lowerBound = $offset + 1;
			$upperBound = $offset + $pageRange;
		}

		return $paginator->getPagesInRange($lowerBound, $upperBound);
	}
}
