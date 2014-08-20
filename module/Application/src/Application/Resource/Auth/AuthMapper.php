<?php

namespace Application\Resource\Auth;


use Application\Resource\AbstractMapper;
use Zend\Http\Response;

/**
 * Class AuthMapper
 * @package Application\Resource\Auth
 */
class AuthMapper extends AbstractMapper {

	/**
	 * @param $username
	 * @param $password
	 * @return Response
	 */
	public function requestToken($username, $password) {
		return $this->getApiClient()->requestToken($username, $password);
	}
}