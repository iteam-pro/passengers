<?php

use Cake\Auth\PasswordHasherFactory;
use Phinx\Seed\AbstractSeed;

class PassengersCellsSeeder extends AbstractSeed
{
    public function run()
    {

        $adminBlock = $this->fetchRow('SELECT * FROM platform_blocks WHERE slug LIKE \'dashboard-left\'');
        $data = [
            [
    			'block_id' => (isset($adminBlock['id']) ? $adminBlock['id'] : 0),
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
