<?php

namespace Application\Controller;


use Zend\Mvc\Controller\AbstractActionController;

class AbstractApplicationController extends AbstractActionController {

	protected function redirectToReferrer() {
		$uri = $this->getRequest()->getHeader('Referer')->getUri();
		$this->redirect()->toUrl($uri);
	}
}