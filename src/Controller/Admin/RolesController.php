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
namespace Passengers\Controller\Admin;

use Passengers\Controller\AppController;

/**
 * Roles Controller
 *
 * @property Passengers\Model\Table\RolesTable $Roles
 */
class RolesController extends AppController {

/**
 * Index method
 *
 * @return void
 */
	public function index() {
		$this->set('roles', $this->paginate($this->Roles));
	}

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function view($id = null) {
		$role = $this->Roles->get($id, [
			'contain' => []
		]);
		$this->set('role', $role);
	}

/**
 * Add method
 *
 * @return void
 */
	public function add() {
		$role = $this->Roles->newEntity($this->request->data);
		if ($this->request->is('post')) {
			if ($this->Roles->save($role)) {
				$this->Flash->success('The role has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The role could not be saved. Please, try again.');
			}
		}
		$this->set(compact('role'));
	}

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function edit($id = null) {
		$role = $this->Roles->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$role = $this->Roles->patchEntity($role, $this->request->data);
			if ($this->Roles->save($role)) {
				$this->Flash->success('The role has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The role could not be saved. Please, try again.');
			}
		}
		$this->set(compact('role'));
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function delete($id = null) {
		$role = $this->Roles->get($id);
		$this->request->allowMethod('post', 'delete');
		if(!$role->core){
			if ($this->Roles->delete($role)) {
				$this->Flash->success('The role has been deleted.');
			} else {
				$this->Flash->error('The role could not be deleted. Please, try again.');
			}
		} else {
			$this->Flash->error('The role could not be deleted.');
		}
		return $this->redirect(['action' => 'index']);
	}
}
