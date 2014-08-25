<?php

namespace Application\Paginator;

use ArrayIterator;
use Traversable;
use Zend\Paginator\Paginator;

class ApigilityPaginator extends Paginator {

	public function getItemsByPage($pageNumber)
	{
		$pageNumber = $this->normalizePageNumber($pageNumber);

		if ($this->cacheEnabled()) {
			$data = static::$cache->getItem($this->_getCacheId($pageNumber));
			if ($data) {
				return $data;
			}
		}

		$offset = ($pageNumber - 1) * $this->getItemCountPerPage();

		$items = $this->adapter->getItems($offset, $this->getItemCountPerPage());
		$this->pageCount = $this->_calculatePageCount();

		$filter = $this->getFilter();

		if ($filter !== null) {
			$items = $filter->filter($items);
		}

		if (!$items instanceof Traversable) {
			$items = new ArrayIterator($items);
		}

		if ($this->cacheEnabled()) {
			$cacheId = $this->_getCacheId($pageNumber);
			static::$cache->setItem($cacheId, $items);
			static::$cache->setTags($cacheId, array($this->_getCacheInternalId()));
		}

		return $items;
	}

	public function setItemCountPerPage($itemCountPerPage = -1)
	{
		$this->itemCountPerPage = (int) $itemCountPerPage;
		if ($this->itemCountPerPage < 1) {
			$this->itemCountPerPage = $this->getTotalItemCount();
		}
//		$this->pageCount        = $this->_calculatePageCount();
		$this->currentItems     = null;
		$this->currentItemCount = null;

		return $this;
	}
} 