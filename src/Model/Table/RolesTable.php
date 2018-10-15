<?php
namespace Passengers\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Roles Model
 */
class RolesTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
	public function initialize(array $config) {
		$this->table('passengers_roles');
		$this->displayField('title');
		$this->primaryKey('id');
		$this->addBehavior('Timestamp');
		$this->addBehavior('Tools.Slugged', [
			'length' => 255,
			'unique' => true,
			'case' => 'low',
		]);
		$this->hasMany('Users', [
			'foreignKey' => 'role_id',
			'className' => 'Passengers.Users',
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
            ->allowEmpty('id', 'create');

        $validator
			->requirePresence('title', 'create')
			->notEmpty('title');

        $validator
            ->add('admin', 'valid', ['rule' => 'boolean'])
			->allowEmpty('admin');

        $validator
			->add('core', 'valid', ['rule' => 'boolean'])
			->allowEmpty('core');

		return $validator;
	}
}
