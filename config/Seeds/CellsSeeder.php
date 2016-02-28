<?php

use Cake\Auth\PasswordHasherFactory;
use Phinx\Seed\AbstractSeed;

class RolesAndUsersSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
    			'block_id' => 'dashboard-right',
    			'title' => 'Latest registrations',
    			'slug' => 'latest-users',
    			'cell' => 'Passengers.LatestUsers',
    			'state' => true,
    			'visibility' => 'all'
    		],
        ];

	    $cells = $this->table('platform_cells');
	    $cells->insert($data)
	        ->save();

	}
}
