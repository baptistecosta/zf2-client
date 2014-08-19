<?php

namespace Application\Http\Client;


use Zend\Http\Client;
use Zend\Http\Request;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Session\Container;

abstract class AbstractHttpClient implements ServiceLocatorAwareInterface {

	use ServiceLocatorAwareTrait;

	/**
	 * @var $client Client
	 */
	protected $client;

	/**
	 * @var $identity \Zend\Session\Container
	 */
	protected $identity;

	/**
	 * @param Client $client
	 * @param \Zend\Session\Container $identity
	 */
	public function __construct(Client $client, Container $identity = null) {
		$this->client = $client;
		$this->identity = $identity;

		$this->init();
	}

	/**
	 * @return mixed
	 */
	public abstract function init();

	/**
	 * @param $uri string
	 * @return $this
	 */
	public function setUri($uri) {
		$this->client->setUri($uri);
		return $this;
	}

	/**
	 * @param array $params
	 * @return $this
	 */
	public function setParameterPost(array $params) {
		$this->client->setParameterPost($params);
		return $this;
	}

	/**
	 * @param Request $request
	 * @return \Zend\Http\Response
	 */
	public function send(Request $request = null) {
		return $this->client->send($request);
	}

	/**
	 * @return \Zend\Session\Container
	 */
	public function getIdentity() {
		return $this->identity;
	}
}