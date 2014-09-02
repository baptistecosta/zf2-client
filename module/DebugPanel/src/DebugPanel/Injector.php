<?php

namespace DebugPanel;

use DebugPanel\Http\Request\Formatter\FormatterInterface;
use Exception;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\RendererInterface;

/**
 * Class Injector
 *
 * @package DebugPanel
 */
class Injector {

	/**
	 * @var Request $request
	 */
	protected $apiRequest;

	/**
	 * @var RendererInterface $renderer
	 */
	protected $renderer;

	/**
	 * @var FormatterInterface $formatter
	 */
	protected $formatter;

	/**
	 * @param Response $response
	 * @throws Exception
	 */
	public function process(Response $response) {
		$body = $response->getBody();
		$this->appendToHeadTag($body);
		$this->appendToBodyTag($body);
		$response->setContent($body);
	}

	/**
	 * Inject stylesheet to response <head> tag.
	 *
	 * @param $body
	 * @return mixed
	 */
	private function appendToHeadTag(&$body) {
		$view = new ViewModel();
		$view->setTemplate('style');
		$stub = $this->renderer->render($view);
		$body = preg_replace('/<\/head>/i', $stub . "\n</head>", $body, 1);
	}

	/**
	 * Inject HTML to response <body> tag.
	 *
	 * @param $body
	 * @return mixed
	 */
	private function appendToBodyTag(&$body) {
		$httpRequest = $this->apiRequest ? $this->formatter->run($this->apiRequest) : "Aucune requête HTTP";
		$view = new ViewModel(['httpRequest' => $httpRequest]);
		$view->setTemplate('debug-panel');
		$stub = $this->renderer->render($view);
		$body = preg_replace('/<\/body>/i', $stub . "\n</body>", $body, 1);
	}

	/**
	 * @param Request $apiRequest
	 * @return $this
	 */
	public function setApiRequest(Request $apiRequest) {
		$this->apiRequest = $apiRequest;
		return $this;
	}

	/**
	 * @param RendererInterface $renderer
	 * @return $this
	 */
	public function setViewRenderer(RendererInterface $renderer) {
		$this->renderer = $renderer;
		return $this;
	}

	/**
	 * @param FormatterInterface $formatter
	 * @return $this
	 */
	public function setFormatter(FormatterInterface $formatter) {
		$this->formatter = $formatter;
		return $this;
	}
}