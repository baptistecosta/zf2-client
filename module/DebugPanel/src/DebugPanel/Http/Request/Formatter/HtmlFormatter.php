<?php

namespace DebugPanel\Http\Request\Formatter;


use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\RendererInterface;

/**
 * Class HtmlFormatter
 *
 * @package DebugPanel\Http\Request
 */
class HtmlFormatter implements FormatterInterface {

	/**
	 * @var RendererInterface $renderer
	 */
	protected $renderer;

	public function run(Request $request) {
		$dump = '';

		$url = $request->getUriString();
		$queryString = $request->getQuery()->toString();
		$url .= empty($queryString) ? '' : '?' . $queryString;
		$dump .= "<strong>Request URL:</strong> " . $url . "<br>";

		/** @var Headers $headers */
		$headers = $request->getHeaders();
		if ($headers->count() > 0) {
			$dump .= '<div><strong>Headers</strong><ul>';
			foreach ($headers as $header) {
				$dump .= '<li>' . $header->toString() . '</li>';
			}
			$dump .= '</ul></div>';
		}

		/** @var Parameters $query */
		$query = $request->getQuery();
		if ($query->count() > 0) {
			$dump .= $this->render('partial/html-formatter/query', ['query' => $query]);
		}

		$postData = $request->getPost();
		if ($postData->count() > 0) {
			$dump .= $this->render('partial/html-formatter/colon-separated-values', [
				'title' => 'Post Parameters',
				'params' => $postData
			]);
		}

		if ($content = $request->getContent()) {
			$dump .= "<strong>Content:</strong> $content<br>";
		}
		return $dump;
	}

	/**
	 * Render a template.
	 *
	 * @param $template
	 * @param $params
	 * @return string
	 */
	private function render($template, $params) {
		$view = new ViewModel($params);
		$view->setTemplate($template);
		return $this->renderer->render($view);
	}

	/**
	 * @param RendererInterface $renderer
	 * @return $this
	 */
	public function setRenderer(RendererInterface $renderer) {
		$this->renderer = $renderer;
		return $this;
	}
}