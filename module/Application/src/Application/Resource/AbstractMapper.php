<?php

namespace Application\Resource;


use Application\Http\Client\ApiClientAwareTrait;
use Application\Http\Request\RequestBuilderGetterTrait;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class AbstractMapper
 * @package Application\Resource
 */
abstract class AbstractMapper implements ServiceLocatorAwareInterface, EventManagerAwareInterface {

	use ApiClientAwareTrait;
	use EventManagerAwareTrait;
	use RequestBuilderGetterTrait;
	use ServiceLocatorAwareTrait;
}