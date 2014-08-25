<?php

namespace Application\Paginator\ScrollingStyle;


class Sliding {

	/**
	 * Returns an array of "local" pages given a page number and range.
	 *
	 * @param  Paginator $paginator
	 * @param  int $pageRange (Optional) Page range
	 * @return array
	 */
	public function getPages($paginator, $pageRange = null) {
		if ($pageRange === null) {
			$pageRange = $paginator->getPageRange();
		}

		$pageNumber = $paginator->getCurrentPageNumber();
		$pageCount = count($paginator);

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
