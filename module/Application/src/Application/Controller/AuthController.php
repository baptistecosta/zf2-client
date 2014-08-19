<?php

namespace Application\Controller;


use Application\Filter\Auth\SignInFilter;
use Application\Form\Auth\SignInForm;
use Application\Http\HttpServiceAwareTrait;
use Application\Session\Container\SessionIdentityAwareInterface;
use Application\Session\Container\SessionIdentityAwareTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractActionController implements SessionIdentityAwareInterface {

	use HttpServiceAwareTrait;
	use SessionIdentityAwareTrait;

	public function signInAction() {
		$form = new SignInForm();
		$form->get('submit');

		if ($this->getRequest()->isPost()) {
			$form->setInputFilter(new SignInFilter());
			$form->setData($this->getRequest()->getPost());

			if ($form->isValid()) {
				$data = $form->getData();
				$this->getHttpService()->requestToken($data['username'], $data['password']);
			}
		}
		return new ViewModel([
			'form' => $form
		]);
	}

	public function signOutAction() {
		$this->getIdentity()->offsetUnset('accessToken');
		$this->getIdentity()->offsetUnset('refreshToken');
		return $this->redirect()->toRoute('home');
	}
} 