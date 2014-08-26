<?php

namespace Application\View\Helper;

use Application\Paginator\ApigilityPaginator;
use Exception;
use Zend\View\Helper\AbstractHelper;

class ApigilityPaginationControl extends AbstractHelper {

	public function __invoke(ApigilityPaginator $paginator = null, $partial = null, $route = null) {
		if (!$paginator) {
			throw new \Exception('No paginator instance provided.');
		}

		if (!$partial) {
			throw new \Exception('No view partial provided and no default set');
		}

		$pages = get_object_vars($paginator->getPages());

		$partialHelper = $this->view->plugin('partial');
		return $partialHelper($partial, [
			'pages' => $pages,
			'route' => $route,
			'query' => $paginator->getQuery()
		]);
	}
}