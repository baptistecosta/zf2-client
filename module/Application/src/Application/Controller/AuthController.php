<?php

namespace Application\Controller;


use Application\Filter\Auth\SignInFilter;
use Application\Form\Auth\SignInForm;
use Application\Http\Client\ApiClientAwareTrait;
use Application\Resource\Auth\AuthMapper;
use Application\Session\Container\SessionIdentityAwareInterface;
use Application\Session\Container\SessionIdentityAwareTrait;
use Zend\View\Model\ViewModel;

/**
 * Class AuthController
 * @package Application\Controller
 */
class AuthController extends AbstractApplicationController implements SessionIdentityAwareInterface {

	use ApiClientAwareTrait;
	use SessionIdentityAwareTrait;

	public function signInAction() {
		$form = new SignInForm();
		$form->get('submit');

		if ($this->getRequest()->isPost()) {
			$form->setInputFilter(new SignInFilter());
			$form->setData($this->getRequest()->getPost());

			if ($form->isValid()) {
				$data = $form->getData();

				/** @var $authMapper AuthMapper */
				$authMapper = $this->getServiceLocator()->get('Application\\Resource\\Auth\\AuthMapper');

				$apiResponse = $authMapper->requestToken($data['username'], $data['password']);
				$body = json_decode($apiResponse->getBody(), true);

				if ($apiResponse->isSuccess()) {
					$this->getIdentity()->offsetSet('tokenData', $body);
					$this->flashMessenger()->setNamespace('success')->addMessage('You are now logged in.');
					return $this->redirect()->toRoute('home');
				} else if ($apiResponse->isClientError()) {
					$this->getIdentity()->offsetUnset('tokenData');
					$this->flashMessenger()->setNamespace('error')->addMessage($body['detail']);
					return $this->redirect()->toRoute('auth');
				}
			}
		}
		return new ViewModel([
			'form' => $form
		]);
	}

	public function signOutAction() {
		$this->getIdentity()->offsetUnset('tokenData');
		$this->flashMessenger()->setNamespace('success')->addMessage('You have been logged out.');
		return $this->redirect()->toRoute('home');
	}
} 