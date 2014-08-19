<?php

namespace Application\Http\Client\Standard;


trait HttpClientAwareTrait {

	/**
	 * @return HttpClientService
	 */
	public function getHttpService() {
		return $this->getServiceLocator()->get('Application\\Http\\Client\\Standard\\HttpClientService');
	}
} 