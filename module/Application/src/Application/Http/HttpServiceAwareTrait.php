<?php

namespace Application\Http;

/**
 * Class HttpServiceAwareTrait
 * @package Application\Http
 */
trait HttpServiceAwareTrait {

	/**
	 * @var $httpService HttpService
	 */
	protected $httpService;

	/**
	 * @return \Application\Http\HttpService
	 */
	public function getHttpService() {
		return $this->getServiceLocator()->get('Application\\Http\\HttpService');
	}

	/**
	 * @param \Application\Http\HttpService $httpService
	 * @return $this
	 */
	public function setHttpService($httpService) {
		$this->httpService = $httpService;
		return $this;
	}
}