<?php

namespace Application\Http\Request;


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
	 * @param array $settings
	 * @return Request
	 */
	public function build($resource, array $settings = []) {
		$request = new Request();
		$request->setUri($this->baseUrl . $resource);
		$request->setMethod(empty($settings['method']) ? 'GET' : $settings['method']);
		if (!empty($settings['headers'])) {
			$request->setHeaders($settings['headers']);
		}
		if (!empty($settings['query'])) {
			$params = new Parameters($settings['query']);
			$request->setQuery($params);
		}
		if (!empty($settings['post'])) {
			$request->setPost($settings['post']);
		}
		return $request;
	}

	/**
	 * GET request.
	 *
	 * @param $uri
	 * @param $settings
	 * @return Request
	 */
	public function get($uri, $settings = []) {
		return $this->build($uri, $settings);
	}

	/**
	 * POST request.
	 *
	 * @param $uri
	 * @param $settings
	 * @return Request
	 */
	public function post($uri, $settings = []) {
		return $this->build($uri, array_merge([
			'method' => 'POST'
		], $settings));
	}

	/**
	 * PUT request.
	 *
	 * @param $uri
	 * @param $settings
	 * @return Request
	 */
	public function put($uri, $settings = []) {
		return $this->build($uri, array_merge([
			'method' => 'PUT'
		], $settings));
	}

	/**
	 * PATCH request.
	 *
	 * @param $uri
	 * @param $settings
	 * @return Request
	 */
	public function patch($uri, $settings = []) {
		return $this->build($uri, array_merge([
			'method' => 'PATCH'
		], $settings));
	}

	/**
	 * DELETE request.
	 *
	 * @param $uri
	 * @param $settings
	 * @return Request
	 */
	public function delete($uri, $settings = []) {
		return $this->build($uri, array_merge([
			'method' => 'DELETE'
		], $settings));
	}
}