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
	'session' => array(
		'remember_me_seconds'  => 1200,
		'use_cookies'          => true,
		'cookie_httponly'      => true,
		'cookie_domain'        => '',
	),
];