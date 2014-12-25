<?php
namespace Passengers\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 */
class UsersTable extends Table {

	public $filterArgs = [
		'search' => [
			'type' => 'like',
			'field' => [
				'Users.username',
				'Users.email'
			]
		],
	];

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('passengers_users');
		$this->displayField('id');
		$this->primaryKey('id');
		$this->addBehavior('Timestamp');
		$this->addBehavior('Search.Searchable');

		$this->belongsTo('Roles', [
			'foreignKey' => 'role_id',
			'className' => 'Passengers.Roles',
		]);

	}

/**
 * Default validation rules.
 *
 * @param \Cake\Validation\Validator $validator
 * @return \Cake\Validation\Validator
 */
	public function validationDefault(Validator $validator) {
		$validator
			->add('id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('id', 'create')
			->add('role_id', 'valid', ['rule' => 'numeric'])
			->validatePresence('role_id', 'create')
			->notEmpty('role_id')
			->validatePresence('username', 'create')
			->notEmpty('username')
			->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])
			//->validatePresence('password', 'create')
			//->notEmpty('password')
			->add('email', 'valid', ['rule' => 'email'])
			->validatePresence('email', 'create')
			->notEmpty('email')
			->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])
			->add('active', 'valid', ['rule' => 'boolean'])
			->validatePresence('active', 'create')
			->notEmpty('active')
			->allowEmpty('activation_code')
			->add('update_required', 'valid', ['rule' => 'boolean'])
			->allowEmpty('update_required')
			->allowEmpty('profile')
			->allowEmpty('options');

		return $validator;
	}

}
