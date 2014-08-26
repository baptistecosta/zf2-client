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
			'sign-in' => [
				'type' => 'Literal',
				'options' => [
					'route' => '/sign-in',
					'defaults' => [
						'__NAMESPACE__' => 'Application\Controller',
						'controller' => 'Auth',
						'action' => 'signIn',
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
			'artist' => [
				'type' => 'Literal',
				'options' => [
					'route' => '/artist',
					'defaults' => [
						'__NAMESPACE__' => 'Application\Controller',
						'controller' => 'Artist',
						'action' => 'index',
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
			'Application\\Resource\\AbstractMapperFactory'
		],
		'aliases' => [
			'api-client' => 'Application\\Http\\Client\\ApiClient',
			'identity' => 'Application\\Session\\Container\\SessionIdentity',
			'request-manager' => 'Application\\Http\\Request\\Manager',
			'translator' => 'MvcTranslator',
		],
		'factories' => [
			'Application\\Session\\Container\\SessionIdentity' => 'Application\\Session\\Container\\SessionIdentityFactory',
			'Application\\Http\\Client\\ApiClient' => 'Application\\Http\\Client\\ApiClientFactory',
			'Application\\Http\\Request\\Manager' => 'Application\\Http\\Request\\RequestManagerFactory'
		],
		'invokables' => [
			'Application\\Http\\Client\\ApiListener' => 'Application\\Http\\Client\\ApiClientListener',
			'Application\\Session\\Container\\IdentityListener' => 'Application\\Session\\Container\\SessionIdentityListener',
			'Application\\Http\\Response\\ApiResponseHandler' => 'Application\\Http\\Response\\ApiResponseHandler',
			'Application\\Http\\Response\\Listener\\ClientError' => 'Application\\Http\\Response\\Listener\\ClientErrorListener',
			'Application\\Http\\Response\\Listener\\Forbidden' => 'Application\\Http\\Response\\Listener\\ForbiddenListener',
			'Application\\Http\\Response\\Listener\\NotFound' => 'Application\\Http\\Response\\Listener\\NotFoundListener',
			'Application\\Http\\Response\\Listener\\Redirect' => 'Application\\Http\\Response\\Listener\\RedirectListener',
			'Application\\Http\\Response\\Listener\\ServerError' => 'Application\\Http\\Response\\Listener\\ServerErrorListener',
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
