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
namespace Passengers\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity.
 */
class User extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'role_id' => true,
		'username' => true,
		'password' => true,
		//TODO: Under the question neded this fields or not
		'password_new' => true,
		'password_confirm' => true,
		'password_current' => true,
		'email' => true,
		'active' => true,
		'activation_code' => true,
		'update_required' => true,
		'profile' => true,
		'options' => true,
		'role' => true,
	];

}
