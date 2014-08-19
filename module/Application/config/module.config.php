<?php

return [
	'router' => [
		'routes' => [
			'home' => [
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => [
					'route' => '/',
					'defaults' => [
						'controller' => 'Application\Controller\Index',
						'action' => 'index',
					],
				],
			],
			'application' => [
				'type' => 'Literal',
				'options' => [
					'route' => '/application',
					'defaults' => [
						'__NAMESPACE__' => 'Application\Controller',
						'controller' => 'Index',
						'action' => 'index',
					],
				],
				'may_terminate' => true,
				'child_routes' => [
					'default' => [
						'type' => 'Segment',
						'options' => [
							'route' => '/[:controller[/:action]]',
							'constraints' => [
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							],
							'defaults' => [],
						],
					],
				],
			],
			'auth' => [
				'type' => 'Literal',
				'options' => [
					'route' => '/auth',
					'defaults' => [
						'__NAMESPACE__' => 'Application\Controller',
						'controller' => 'Auth',
						'action' => 'signIn',
					],
				],
				'may_terminate' => true,
				'child_routes' => [
					'default' => [
						'type' => 'Segment',
						'options' => [
							'route' => '[/:action]',
							'constraints' => [
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
							],
							'defaults' => [],
						],
					],
				],
			],
		],
	],
	'service_manager' => [
		'abstract_factories' => [
			'Zend\\Cache\\Service\\StorageCacheAbstractServiceFactory',
			'Zend\\Log\\LoggerAbstractServiceFactory',
		],
		'aliases' => [
			'http-service' => 'Application\\Http\\HttpService',
			'translator' => 'MvcTranslator',
		],
		'factories' => [
			'Identity' => function () {
					return new \Zend\Session\Container('sfa\zf2client');
				},
			'Application\\Http\\HttpService' => function($sm) {
					$client = new Zend\Http\Client();
					$client->setAdapter('Zend\\Http\\Client\\Adapter\\Curl');

					$clientService = new \Application\Http\HttpService();
					return $clientService
						->setBaseUrl('http://apigility.loc')
						->setClient($client);
				},
		],
		'invokables' => [
			'Application\\Http\\HttpServiceListener' => 'Application\\Http\\HttpServiceListener'
		],
		'initializers' => [
			'Application\\Session\\Container\\SessionIdentityInitializer'
		],
	],
	'translator' => array(
		'locale' => 'en_US',
		'translation_file_patterns' => array(
			array(
				'type' => 'gettext',
				'base_dir' => __DIR__ . '/../language',
				'pattern' => '%s.mo',
			),
		),
	),
	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions' => true,
		'doctype' => 'HTML5',
		'not_found_template' => 'error/404',
		'exception_template' => 'error/index',
		'template_map' => array(
			'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
			'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
			'error/404' => __DIR__ . '/../view/error/404.phtml',
			'error/index' => __DIR__ . '/../view/error/index.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
	// Placeholder for console routes
	'console' => array(
		'router' => array(
			'routes' => array(),
		),
	),
];
