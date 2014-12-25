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

use Cake\Auth\PasswordHasherFactory;

class UsersData
{

	public $users = [
		[
			'id' => 1,
			'role_id' => 4,
			'username' => 'admin',
			'password' => 'qwerty1234',
			'email' => 'admin@example.com',
			'active' => true,
		]
	];

	public function change($data = []){

		$passwordHasher = PasswordHasherFactory::build('Default');
		$data['password'] = $passwordHasher->hash($data['password']);

		return $data;
	}

}
