<?php

use Cake\Auth\PasswordHasherFactory;
use Phinx\Seed\AbstractSeed;

class RolesAndUsersSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
			[
				'title' => 'Guest',
				'slug' => 'guest',
				'admin' => false,
				'core' => true
			],
			[
				'title' => 'Registered',
				'slug' => 'registered',
				'admin' => false,
				'core' => true
			],
			[
				'title' => 'Manager',
				'slug' => 'manager',
				'admin' => true,
				'core' => true
			],
			[
				'title' => 'Admin',
				'slug' => 'admin',
				'admin' => true,
				'core' => true
			],
		];

	    $roles = $this->table('passengers_roles');
	    $roles->insert($data)
	        ->save();

		$adminRole = $this->fetchRow('SELECT * FROM passengers_roles WHERE slug LIKE \'admin\'');
		$passwordHasher = PasswordHasherFactory::build('Default');
		$data = [
			[
				'role_id' => $adminRole['id'],
				'username' => 'admin',
				'password' => $passwordHasher->hash('qwerty1234'),
				'email' => 'admin@example.com',
				'active' => true,
			]
		];
		$users = $this->table('passengers_users');
	    $users->insert($data)
	        ->save();

	}
}
