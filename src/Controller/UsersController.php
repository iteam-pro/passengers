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
namespace Passengers\Controller;

use Passengers\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;


/**
 * Users Controller
 *
 * @property Passengers\Model\Table\UsersTable $Users
 */
class UsersController extends AppController {

	public function beforeFilter(Event $event) {
	    parent::beforeFilter($event);
		$this->loadComponent('Cookie');
		//Allow users to signin and signup
		$this->Auth->allow(['signin', 'signup']);
	}

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function view($id = null) {
		$user = $this->Users->get($id, [
			'contain' => []
		]);
		$this->set('user', $user);
	}

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function edit($id = null) {
		$user = $this->Users->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$user = $this->Users->patchEntity($user, $this->request->data);
			if ($this->Users->save($user)) {
				$this->Flash->success('The user has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The user could not be saved. Please, try again.');
			}
		}
		$this->set(compact('user'));
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function delete($id = null) {
		$user = $this->Users->get($id);
		$this->request->allowMethod('post', 'delete');
		if ($this->Users->delete($user)) {
			$this->Flash->success('The user has been deleted.');
		} else {
			$this->Flash->error('The user could not be deleted. Please, try again.');
		}
		return $this->redirect(['action' => 'index']);
	}

/**
 * SignIn method
 *
 * @return void
 * @throws NotFoundException
 */
	public function signin() {
		if ($this->request->is('post')) {
			$user = $this->Auth->identify();
			if ($user) {
				$this->Auth->setUser($user);
				$this->_setCookie();
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Flash->error(__d('passengers', 'Invalid username or password, try again'));
		}
		$this->set('signupAllowed', Configure::read('Passengers.admin.registration.enable'));
	}

/**
 * SignOut method
 *
 * @return void
 */
	public function signout() {
		return $this->redirect($this->Auth->logout());
	}

/**
 * SignOut method
 *
 * @return void
 */
	public function signup() {
		$signupAllowed = Configure::read('App.allow_user_registration');
		if (!$signupAllowed) {
			$this->Flash->error(__d('passengers', 'Registration is disabled. Please contact with resourse administration'));
			return $this->redirect(['action' => 'signin']);
		}
		$this->Users->addBehavior('Tools.Passwordable', [
			'formField' => 'password_new',
			'formFieldRepeat' => 'password_confirm',
			'formFieldCurrent' => 'password_current',
		]);
		$user = $this->Users->newEntity($this->request->data);
		if ($this->request->is('post')&&$signupAllowed) {
			//TODO: make it configurable
			$user->role_id = 2;
			//TODO: make it configurable
			$user->active = 0;
			if ($this->Users->save($user)) {
				$this->Flash->success(__d('passengers', 'Your account has been created.'));
				return $this->redirect(['action' => 'signin']);
			} else {
				$this->Flash->error(__d('passengers', 'Your account could not be created. Please, try again or contact with resoure administration.'));
			}
			$user->unsetProperty('password_new');
			$user->unsetProperty('password_confirm');
		}

		$this->set(compact('user'));
	}

	protected function _setCookie() {
		if (!$this->request->data('remember_me')) {
			return false;
		}
		$data = [
			'username' => $this->request->data('username'),
			'password' => $this->request->data('password')
		];
		$this->Cookie->write('RememberMe', $data, true, '+1 week');
		return true;
	}
}
