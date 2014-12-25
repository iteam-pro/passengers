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

class RolesData
{

	public $roles = [
		[
			'id' => 1,
			'title' => 'Guest',
			'slug' => 'guest',
			'admin' => false,
			'core' => true
		],
		[
			'id' => 2,
			'title' => 'Registered',
			'slug' => 'registered',
			'admin' => false,
			'core' => true
		],
		[
			'id' => 3,
			'title' => 'Manager',
			'slug' => 'manager',
			'admin' => true,
			'core' => true
		],
		[
			'id' => 4,
			'title' => 'Admin',
			'slug' => 'admin',
			'admin' => true,
			'core' => true
		],
	];

}
