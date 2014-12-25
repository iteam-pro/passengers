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
namespace Passengers\View\Cell;

use RearEngine\View\Cell\ActiveCell;

/**
 * AdminLatestUsers cell
 */
class LatestUsersCell extends ActiveCell {

/**
 * List of valid options that can be passed into this
 * cell's constructor.
 *
 * @var array
 */
	protected $_validCellOptions = [];

/**
 * Default display method.
 *
 * @return void
 */
	public function admin($cell) {
		$this->loadModel('Passengers.Users');
		$users = $this->Users->find('all', [
			'order' => ['Users.created' => 'DESC'],
			'limit' => '5'
		])->all();
		$this->set(compact('cell', 'users'));
	}

}
