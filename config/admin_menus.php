<?php
/**
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) MindForce Team (http://mindforce.com)
 * @link          http://mindforce.me Passengers CakePHP 3 Plugin
 * @since         0.0.1
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$config = [
	'App' => [
		'admin' => [
			'menu' => [
				'top' => [
					'add' => [
						'title' => __d('passengers', 'Add...'),
						'weight' => 10,
						'options' => [
							'dropdown' => 'dropdown-quick-actions',
							'icon' => 'fa fa-plus'
						],
						'children' => [
							'users' => [
								'title' => __d('passengers', 'Add User'),
								'weight' => 999,
								'url' => [
									'prefix' => 'admin',
									'plugin' => 'Passengers',
									'controller' => 'Users',
									'action' => 'add'
								],
								'options' => [
									'icon' => 'fa fa-user'
								]
							]
						]
					],
					'user' => [
						'type' => 'cell',
						'weight' => 999,
                        'cell' => 'Passengers.AdminSignedUser',
						'children' => [
							'separator-before-logout' => [
								'type' => 'separator',
								'weight' => 998,
							],
							'logout' => [
								'title' => __d('passengers', 'Sign out'),
								'weight' => 999,
								'url' => [
									'prefix' => 'admin',
									'plugin' => 'Passengers',
									'controller' => 'Users',
									'action' => 'signout'
								],
								'options' => [
									'icon' => 'fa fa-sign-out'
								]
							]
						]
					]
				],
				'main' => [
					'accounts' => [
						'title' => __d('passengers', 'Accounts'),
						'weight' => 120,
						'options' => [
							'icon' => 'fa fa-group'
						],
						'children' => [
							'users' => [
								'title' => __d('passengers', 'Users'),
								'url' => [
									'prefix' => 'admin',
									'plugin' => 'Passengers',
									'controller' => 'Users',
									'action' => 'index'
								],
								'weight' => 10,
								'options' => [
									'icon' => 'fa fa-user'
								]
							],
							'roles' => [
								'title' => __d('passengers', 'Roles'),
								'url' => [
									'prefix' => 'admin',
									'plugin' => 'Passengers',
									'controller' => 'Roles',
									'action' => 'index'
								],
								'weight' => 20,
								'options' => [
									'icon' => 'fa fa-briefcase'
								]
							]
						]
					]
				]
			]
		]
	]
];
