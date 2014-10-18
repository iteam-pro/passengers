<?php

use Phinx\Migration\AbstractMigration;
use Cake\Auth\PasswordHasherFactory;
use Cake\ORM\TableRegistry;

class InitialMigration extends AbstractMigration
{

	protected $roles = [
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

	protected $users = [
		[
			'id' => 1,
			'role_id' => 4,
			'username' => 'admin',
			'password' => 'qwerty1234',
			'email' => 'admin@example.com',
			'active' => true,
		]
	];

	protected $cells = [
		[
			'block_id' => 'dashboard-right',
			'title' => 'Latest registrations',
			'slug' => 'latest-users',
			'cell' => 'Passengers.LatestUsers',
			'state' => true,
			'visibility' => 'all'
		],
	];


    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * Uncomment this method if you would like to use it.
     *
    public function change()
    {
    }
    */
    
    /**
     * Migrate Up.
     */
    public function up()
    {
	    //Create roles table
        $roles =  $this->table('roles');
	    $roles->addColumn('title', 'string', ['limit' => 255])
			->addColumn('slug', 'string', ['limit' => 255])
		    ->addColumn('admin', 'boolean', ['null' => true])
		    ->addColumn('core', 'boolean', ['null' => true])
		    ->addColumn('created', 'datetime', ['null' => true])
		    ->addColumn('modified', 'datetime', ['null' => true])
		    ->addColumn('user_count', 'integer', ['null' => true, 'default' => 0])
		    ->addIndex(['slug'], array('unique' => true, 'name' => 'roles_slug_idx'))
			->save();

	    //Create users table
	    $users =  $this->table('users');
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
		    ->addIndex(['role_id'], array('unique' => false, 'name' => 'users_role_id_idx'))
			->save();

	    //Create sessions table
	    $sessions =  $this->table('sessions',['id' => false, 'primary_key' => ['id']]);
	    $sessions->addColumn('id', 'string', ['limit' => 40])
		    ->addColumn('data', 'text', ['null' => true])
		    ->addColumn('expires', 'integer', ['null' => true])
		    ->save();

	    //Seed roles table by default data
	    $roles = TableRegistry::get('Passengers.Roles');
	    foreach ($this->roles as $role){
		    $role = $roles->newEntity($role);
		    $roles->save($role);
	    }

	    //Seed users table by default data
	    $users = TableRegistry::get('Passengers.Users');
	    $passwordHasher = PasswordHasherFactory::build('Default');
	    foreach ($this->users as $user){
		    $user['password'] = $passwordHasher->hash($user['password']);
		    $user = $users->newEntity($user);
		    $users->save($user);
	    }

	    $exists = $this->hasTable('cells');
	    if ($exists) {
	        //Seed roles table by default data
		    $cells = TableRegistry::get('RearEngine.Cells');
		    $blocks = TableRegistry::get('RearEngine.Blocks');
		    foreach ($this->cells as $cell){
			    if (!is_int($cell['block_id'])){
				    $block = $blocks->findAllBySlug($cell['block_id'])->first();
				    $cell['block_id'] = 1;
					if(isset($block->id)){
						$cell['block_id'] = $block->id;
					}
			    }
			    $cell = $cells->newEntity($cell);
			    $cells->save($cell);
		    }
	    }

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
	    $this->dropTable('roles');
	    $this->dropTable('users');
	    $this->dropTable('sessions');

	    TableRegistry::get('RearEngine.Cells')->deleteAll([
		    'Cells.cell LIKE' => 'Passengers.%'
	    ]);

    }
}