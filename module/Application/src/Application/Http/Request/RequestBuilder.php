<?php

namespace Application\Http\Request;


use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;

/**
 * Class RequestBuilder
 * @package Application\Resource\Artist
 */
class RequestBuilder implements EventManagerAwareInterface {

	use EventManagerAwareTrait;

	const EVENT_SET_QUERY_PRE = 'set-query.pre';
	const EVENT_BUILD_POST = 'build.post';

	/**
	 * Base URL (e.g: http://www.domain.com ).
	 *
	 * @var string
	 */
	protected $baseUrl;

	/**
	 * @param $baseUrl
	 */
	function __construct($baseUrl) {
		$this->baseUrl = $baseUrl;
	}

	/**
	 * @param string $resource
	 * @param array $params
	 * @return Request
	 */
	public function build($resource, array $params = []) {
		$request = new Request();
		$request->setUri($this->baseUrl . $resource);
		$request->setMethod(empty($params['method']) ? 'GET' : $params['method']);

		if (!empty($params['headers'])) {
			$request->getHeaders()->addHeaders($params['headers']);
		}

		if (!empty($params['query'])) {
			$query = $this->getEventManager()->trigger(self::EVENT_SET_QUERY_PRE, null, ['query' => $params['query']])->last();
			$request->setQuery(new Parameters($query));
		}

		if (!empty($params['post'])) {
			$params = new Parameters($params['post']);
			$request->setPost($params);
		}

		$this->getEventManager()->trigger(self::EVENT_BUILD_POST, null, ['request' => $request]);

		return $request;
	}

	/**
	 * GET request.
	 *
	 * @param $resource
	 * @param $params
	 * @return Request
	 */
	public function get($resource, $params = []) {
		return $this->build($resource, $params);
	}

	/**
	 * POST request.
	 *
	 * @param $resource
	 * @param $params
	 * @return Request
	 */
	public function post($resource, $params = []) {
		return $this->build($resource, array_merge([
			'method' => 'POST'
		], $params));
	}

	/**
	 * PUT request.
	 *
	 * @param $resource
	 * @param $params
	 * @return Request
	 */
	public function put($resource, $params = []) {
		return $this->build($resource, array_merge([
			'method' => 'PUT'
		], $params));
	}

	/**
	 * PATCH request.
	 *
	 * @param $resource
	 * @param $params
	 * @return Request
	 */
	public function patch($resource, $params = []) {
		return $this->build($resource, array_merge([
			'method' => 'PATCH'
		], $params));
	}

	/**
	 * DELETE request.
	 *
	 * @param $resource
	 * @param $params
	 * @return Request
	 */
	public function delete($resource, $params = []) {
		return $this->build($resource, array_merge([
			'method' => 'DELETE'
		], $params));
	}
}