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
        $this->setTable('passengers_users');
        $this->setDisplayField('username');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

		$this->belongsTo('Roles', [
			'foreignKey' => 'role_id',
			'className' => 'Passengers.Roles',
		]);
        //$this->addFilter('username', ['className' => 'Like']);
        //$this->addFilter('role_id', ['className' => 'Value']);

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
            ->allowEmpty('id', 'create');

        $validator
			->add('role_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('role_id', 'create')
            ->notEmpty('role_id');

        $validator
			->requirePresence('username', 'create')
			->notEmpty('username', 'Username need to be at least 6 characters long')
			->add('username', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'Username need to be at least 6 characters long',
            ]);

        $validator
			->add('email', 'valid', [
                'rule' => 'email',
                'message' => 'Email field should contain valid email address',
            ])
			->requirePresence('email', 'create')
			->notEmpty('email')
			->add('email', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'User with this email already registered',
            ]);

        $validator
			->add('active', 'valid', ['rule' => 'boolean'])
			->requirePresence('active', 'create')
            ->notEmpty('active');

        $validator
            ->allowEmpty('activation_code');

        $validator
			->add('update_required', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('update_required');

        $validator
			->allowEmpty('options');

        return $validator;
	}

    /**
     * Custom finder to filter active users
     *
     * @param Query $query Query object to modify
     * @param array $options Query options
     * @return Query
     */
    public function findActive(Query $query, array $options = [])
    {
        $query
            ->where(['OR' =>[
                $this->aliasField('username') => $options['username'],
                $this->aliasField('email') => $options['username'],
            ]], [], true)
            ->where([$this->aliasField('active') => 1]);
        return $query;
    }
}
