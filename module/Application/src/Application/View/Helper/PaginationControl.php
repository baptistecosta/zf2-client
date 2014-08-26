<?php

namespace Application\View\Helper;

use Application\Paginator\Paginator;
use Exception;
use Zend\View\Helper\AbstractHelper;

/**
 * Class PaginationControl
 * @package Application\View\Helper
 */
class PaginationControl extends AbstractHelper {

	/**
	 * @param Paginator $paginator
	 * @param null $partial
	 * @param null $route
	 * @return mixed
	 * @throws Exception
	 */
	public function __invoke(Paginator $paginator = null, $partial = null, $route = null) {
		if (!$paginator) {
			throw new \Exception('No paginator instance provided.');
		}

		if (!$partial) {
			throw new \Exception('No view partial provided and no default set');
		}

		$pages = get_object_vars($paginator->getPages());
		$requestSettings = $paginator->getAdapter()->getRequestSettings();

		$partialHelper = $this->view->plugin('partial');
		return $partialHelper($partial, [
			'pages' => $pages,
			'route' => $route,
			'query' => empty($requestSettings['query']) ? [] : $requestSettings['query']
		]);
	}
}