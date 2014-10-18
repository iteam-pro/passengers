<?php
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
