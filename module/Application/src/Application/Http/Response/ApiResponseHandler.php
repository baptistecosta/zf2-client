<?php

namespace Application\Http\Response;


use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Http\Response;

class ApiResponseHandler implements EventManagerAwareInterface {

	use EventManagerAwareTrait;

	public function process(Response $res) {
		if ($res->isSuccess()) {
			return $res;
		} else if ($res->isServerError()) {
			return $this->trigger('server-error', $res);
		} else if ($res->isForbidden()) {
			return $this->trigger('forbidden', $res);
		} else if ($res->isClientError()) {
			return $res;
//			return $this->trigger('client-error', $res);
		} else if ($res->isNotFound()) {
			return $this->trigger('not-found', $res);
		} else if ($res->isRedirect()) {
			return $this->trigger('redirect', $res);
		} else {
			return null;
		}
	}

	private function trigger($eventName, $res) {
		$results = $this->getEventManager()->trigger($eventName, null, ['response' => $res]);
		return $results->last();
	}
}