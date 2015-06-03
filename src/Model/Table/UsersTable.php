<?php
namespace Passengers\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 */
class UsersTable extends Table {

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

		$this->belongsTo('Roles', [
			'foreignKey' => 'role_id',
			'className' => 'Passengers.Roles',
		]);
		//$this->addBehavior('Search.Searchable');
		$this->addBehavior('PlumSearch.Filterable');
        $this->addFilter('username', ['className' => 'Like']);
        $this->addFilter('role_id', ['className' => 'Value']);

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
			->requirePresence('role_id', 'create')
			->notEmpty('role_id')
			->requirePresence('username', 'create')
			->notEmpty('username')
			->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])
			->add('email', 'valid', ['rule' => 'email'])
			->requirePresence('email', 'create')
			->notEmpty('email')
			->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])
			->add('active', 'valid', ['rule' => 'boolean'])
			->requirePresence('active', 'create')
			->notEmpty('active')
			->allowEmpty('activation_code')
			->add('update_required', 'valid', ['rule' => 'boolean'])
			->allowEmpty('update_required')
			->allowEmpty('profile')
			->allowEmpty('options');

		return $validator;
	}

}
