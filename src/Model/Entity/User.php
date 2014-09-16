<?php
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
		'email' => true,
		'active' => true,
		'activation_code' => true,
		'update_required' => true,
		'profile' => true,
		'options' => true,
		'role' => true,
	];

}
