<?php
return [
    'modules' => [
        'Application',
		'DebugPanel',
		'ZendDeveloperTools'
	],
    'module_listener_options' => [
        'module_paths' => [
            './module',
            './vendor',
        ],
        'config_glob_paths' => [
            'config/autoload/{,*.}{global,local}.php',
        ],
    ],
];
