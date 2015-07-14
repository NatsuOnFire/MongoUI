<?php
return [
	'controllers' => [
		'invokables' => [
			'MongoUI\Controller\Index' => 'MongoUI\Controller\IndexController',
			'MongoUI\Controller\Connection' => 'MongoUI\Controller\ConnectionController'
		]
	],
	'router' => [
		'routes' => [
			'mongomyadmin' => [
				'type' => 'Literal',
				'options' => [
					'route' => '/mongomyadmin',
					'defaults' => [
						'__NAMESPACE__' => 'MongoUI\Controller',
						'controller' => 'Index',
						'action' => 'index',
					],
				],
				'may_terminate' => true,
				'child_routes' => [
                    'default' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => [
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                            ],
                        ],
                    ],
                ],
			],
		],
	],
	 'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
	'service_manager' => [
		'factories' => [
			// Configures the default SessionManager instance
			'Zend\Session\ManagerInterface' => 'Zend\Session\Service\SessionManagerFactory',
			// Provides session configuration to SessionManagerFactory
			'Zend\Session\Config\ConfigInterface' => 'Zend\Session\Service\SessionConfigFactory',
		],
	],
	'session_manager' => [
		// SessionManager config: validators, etc
		'remember_me_seconds'  => 1200,
		'use_cookies'          => true,
		'cookie_httponly'      => true,
		'cookie_domain'        => '',
	],
	'session_config' => [
		// Set the session and cookie expiries to 15 minutes
		'cache_expire' => 900,
		'cookie_lifetime' => 900,
	],
];