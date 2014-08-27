<?php

namespace Application\Http\Request;


use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\Request;

class RequestBuilderListener extends AbstractListenerAggregate {

	protected $listeners = [];

	protected $requestFormatter;

	public function attach(EventManagerInterface $events) {
		$this->listeners[] = $events->attach(RequestBuilder::EVENT_SET_QUERY_PRE, [$this, 'setQueryPre'], 1000);
		$this->listeners[] = $events->attach('build.post', [$this, 'buildPost'], 100);
	}

	/**
	 * Executed before RequestBuilder sets the query parameters.
	 *
	 * @param Event $e
	 * @return array
	 */
	public function setQueryPre(Event $e) {
		$query = $e->getParam('query');

		if (!empty($query['order'])) {
			// Match any query order starting with "-", e.g. -name.
			if (preg_match_all("/^-([a-zA-Z-_]+)/i", $query['order'], $matches)) {
				// Convert "-name" to "name desc".
				$orderField = $matches[1][0];
				$query['order'] = $orderField . ' desc';
			}
		}

		return $query;
	}

	public function buildPost(Event $e) {
		/** @var Request $request */
//		$request = $e->getParam('request');
	}
}