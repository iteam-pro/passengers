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

use Cake\View\Cell;

/**
 * AdminSignedUser cell
 */
class AdminSignedUserCell extends Cell {

	public $helpers = ['RearEngine.AdminMenu', 'Tools.Gravatar'];

	/**
	 * List of valid options that can be passed into this
	 * cell's constructor.
	 *
	 * @var array
	 */
	protected $_validCellOptions = ['options', 'children'];

	/**
	 * Default display method.
	 *
	 * @return void
	 */
	public function display($options = null, $children = null)
	{
		$user = $this->request->session()->read('Auth.User');
		$children = [
			'account' => [
				'title' => __d('passengers', 'My account'),
				'weight' => 10,
				'url' => [
					'prefix' => 'admin',
					'plugin' => 'Passengers',
					'controller' => 'Users',
					'action' => 'view',
					$user['id']
				],
				'options' => [
					'icon' => 'fa fa-user'
				]
			],
		] + $children;
		$this->set('user', $user);
		$this->set('children', $children);
	}

}
