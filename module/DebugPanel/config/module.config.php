<?php

return [
	'service_manager' => [
		'invokables' => [
			'DebugPanel\\Listener\\ApiClient' => 'DebugPanel\\Listener\\ApiClientListener',
			'DebugPanel\\Listener\\MvcEvent' => 'DebugPanel\\Listener\\MvcEventListener',
		],
		'factories' => [
			'DebugPanel\\Injector' => function(\Zend\ServiceManager\ServiceManager $services) {
				$injector = new \DebugPanel\Injector();
				return $injector
					->setViewRenderer($services->get('ViewRenderer'))
					->setFormatter($services->get('DebugPanel\\Http\\Request\\Formatter\\Html'));
			},
			'DebugPanel\\Http\\Request\\Formatter\\Html' => function(\Zend\ServiceManager\ServiceManager $services) {
				$formatter = new \DebugPanel\Http\Request\Formatter\HtmlFormatter();
				return $formatter->setRenderer($services->get('ViewRenderer'));
			},
		],
	],
	'view_manager' => [
		'template_path_stack' => [
			__DIR__ . '/../view/debug-panel',
		],
	],
];