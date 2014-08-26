<?php

namespace Application\Http\Request;


use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;

/**
 * Class RequestManager
 * @package Application\Resource\Artist
 */
class RequestManager {

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
			$params = new Parameters($params['query']);
			$request->setQuery($params);
		}
		if (!empty($params['post'])) {
			$params = new Parameters($params['post']);
			$request->setPost($params);
		}
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