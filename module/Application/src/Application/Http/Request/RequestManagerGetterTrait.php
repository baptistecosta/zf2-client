<?php

namespace Application\Http\Request;


trait RequestManagerGetterTrait {

	/**
	 * @return RequestManager
	 */
	public function getRequestManager() {
		return $this->getServiceLocator()->get('request-manager');
	}
} 