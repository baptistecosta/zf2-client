<?php

namespace Application\Http\Request;


trait RequestBuilderGetterTrait {

	/**
	 * @return RequestBuilder
	 */
	public function getRequestBuilder() {
		return $this->getServiceLocator()->get('request-builder');
	}
} 