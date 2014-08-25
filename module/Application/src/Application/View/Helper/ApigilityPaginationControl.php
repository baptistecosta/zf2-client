<?php

namespace Application\View\Helper;

use Exception;
use Zend\View\Helper\AbstractHelper;

class ApigilityPaginationControl extends AbstractHelper {

	public function __invoke($paginator = null, $partial = null, $params = null) {
		if (!$paginator) {
			throw new Exception('No paginator instance provided.');
		}

		if (!$partial) {
			throw new \Exception('No view partial provided and no default set');
		}

		$pages = get_object_vars($paginator->getPages());

		if ($params !== null) {
			$pages = array_merge($pages, (array)$params);
		}

//		if (is_array($partial)) {
//			if (count($partial) != 2) {
//				throw new \Exception('A view partial supplied as an array must contain two values: the filename and its module');
//			}
//
//			if ($partial[1] !== null) {
//				$partialHelper = $this->view->plugin('partial');
//				return $partialHelper($partial[0], $pages);
//			}
//
//			$partial = $partial[0];
//		}

		$partialHelper = $this->view->plugin('partial');
		return $partialHelper($partial, $pages);
	}
}