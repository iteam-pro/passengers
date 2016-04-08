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

class PassengersDropProfileField extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
	    $users = $this->table('passengers_users');
	    $users->removeColumn('profile')
            ->update();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $users = $this->table('passengers_users');
        $users->addColumn('profile', 'text', ['null' => true, 'after' => 'update_required'])
            ->update();
    }
}
