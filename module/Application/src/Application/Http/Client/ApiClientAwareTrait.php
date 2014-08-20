<?php

namespace Application\Http\Client;

/**
 * Class ApiClientAwareTrait
 * @package Application\Http\Client
 */
trait ApiClientAwareTrait {

	/**
	 * @var $apiClient ApiClient
	 */
	protected $apiClient;

	/**
	 * @return ApiClient
	 */
	public function getApiClient() {
		return $this->apiClient;
	}

	/**
	 * @param ApiClient $apiClient
	 * @return $this
	 */
	public function setApiClient(ApiClient $apiClient) {
		$this->apiClient = $apiClient;
		return $this;
	}
}