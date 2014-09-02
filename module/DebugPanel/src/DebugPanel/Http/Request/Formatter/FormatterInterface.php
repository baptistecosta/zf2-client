<?php

namespace DebugPanel\Http\Request\Formatter;

use Zend\Http\Request;

/**
 * Class FormatterInterface
 *
 * @package DebugPanel\Http\Request\Formatter
 */
interface FormatterInterface {

	/**
	 * Run the formatter...
	 *
	 * @param Request $request
	 * @return mixed
	 */
	public function run(Request $request);
}