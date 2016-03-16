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

use Phinx\Migration\AbstractMigration;
use Cake\Auth\PasswordHasherFactory;
use Cake\ORM\TableRegistry;

class PassengersInitialMigration extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
	    //Create roles table
        $roles = $this->table('passengers_roles');
	    $roles->addColumn('title', 'string', ['limit' => 255])
			->addColumn('slug', 'string', ['limit' => 255])
		    ->addColumn('admin', 'boolean', ['null' => true])
		    ->addColumn('core', 'boolean', ['null' => true])
		    ->addColumn('created', 'datetime', ['null' => true])
		    ->addColumn('modified', 'datetime', ['null' => true])
		    ->addColumn('user_count', 'integer', ['null' => true, 'default' => 0])
		    ->addIndex(['slug'], array('unique' => true, 'name' => 'passengers_roles_slug_idx'))
			->save();

	    //Create users table
	    $users = $this->table('passengers_users');
	    $users->addColumn('role_id', 'integer', ['default' => 2])
			->addColumn('username', 'string', ['limit' => 60])
			->addColumn('password', 'string', ['limit' => 60])
			->addColumn('email', 'string', ['limit' => 250])
			->addColumn('created', 'datetime', ['null' => true])
			->addColumn('modified', 'datetime', ['null' => true])
			->addColumn('active', 'boolean', ['default' => 0])
			->addColumn('activation_code', 'string', ['limit' => 32, 'null' => true])
			->addColumn('update_required', 'boolean', ['null' => true, 'default' => 0])
			->addColumn('profile', 'text', ['null' => true])
			->addColumn('options', 'text', ['null' => true])
		    //->addForeignKey('role_id', 'roles', 'id', ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION'])
		    ->addIndex(['role_id'], array('unique' => false, 'name' => 'passengers_users_role_id_idx'))
			->save();

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
	    $this->dropTable('passengers_roles');
	    $this->dropTable('passengers_users');

    }
}
