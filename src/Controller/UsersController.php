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

	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('Cookie');
		$this->loadComponent('Platform.Email');
	}

	public function beforeFilter(Event $event)
	{
	    parent::beforeFilter($event);
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
			if($login = $this->request->data('username')){
				$active = $this->Users->find('all', [
					'conditions' => [
						'Users.active' => true,
						'OR' => [
							'Users.email' => $login,
							'Users.username' => $login
						]
					]
				])->count();
				if(!$active){
					$this->Flash->error(__d('passengers', 'Sorry, but your account has been not activated yet.'));
					$this->render();
				}
			}
			$user = $this->Auth->identify();
			if ($user) {
				$this->Auth->setUser($user);
				$this->_setCookie();
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Flash->error(__d('passengers', 'Invalid username or password, try again'));
		}
		$this->set('signupAllowed', Configure::read('App.allow_user_registration'));
	}

/**
 * SignOut method
 *
 * @return void
 */
	public function signout() {
		$this->Cookie->delete('RememberMe');
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
			$user->active = 1;
			if(Configure::read('App.use_users_activation')){
				$user->active = 1;
				$user->activation_code = md5(time().$_data['password_new']);
			}
			if ($this->Users->save($user)) {
				$this->Email->send($user->email, ['user' => $user], [
					'subject' => __('Registration confirmation'),
					'template' => 'Passengers.signup'
				]);
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

    public function activate($code = null){
        if(!$code){
            throw new BadRequestException('There is no any code to activate');
        }
        $user = $this->Users->findByActivationCode($code)->first();
        if(!$user){
            throw new NotFoundException('There is no any user to activate');
        }
        $user = $this->Users->patchEntity($user, [
            'activation_code' => '',
            'active' => true,
        ]);
        if($this->Users->save($user)){
			$this->Auth->setUser($user->toArray());
            if($user->update_required){
                $this->Flash->warning(__d('passengers', 'We are not sure that your profile data is correct. Maybe you need to update your data.'));
                $this->redirect(['action' => 'edit']);
            }
        }
        $this->set('user', $user);
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
