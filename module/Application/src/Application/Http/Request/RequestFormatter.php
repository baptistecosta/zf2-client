<?php

namespace Application\Http\Request;


use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;

/**
 * Class RequestFormatter
 * @package Application\Http\Request
 */
class RequestFormatter {

	public static function process(Request $request) {
		$dump = '';

		$url = $request->getUriString();
		$queryString = $request->getQuery()->toString();
		$url .= empty($queryString) ? '' : '?' . $queryString;
		$dump .= "Request URL: " . $url . "\n";

		/** @var Headers $headers */
		$headers = $request->getHeaders();
		if ($headers->count() > 0) {
			$dump .= "Headers\n";
			foreach ($headers as $header) {
				$dump .= "  " . $header->toString() . "\n";
			}
		}

		/** @var Parameters $query */
		$query = $request->getQuery();
		if ($query->count() > 0) {
			$dump .= "Query String Parameters\n";
			foreach ($query as $k => $v) {
				$dump .= "  $k: $v\n";
			}
		}

		if ($postData = $request->getPost()->toString()) {
			$dump .= "Post Parameters: $postData\n";
		}

		if ($content = $request->getContent()) {
			$dump .= "Content: $content\n";
		}
		$dump = trim($dump, "\n");
		return $dump;
	}
}