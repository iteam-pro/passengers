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
use Cake\Event\Event;
use Cake\Core\Configure;

/**
 * Users Controller
 *
 * @property Passengers\Model\Table\UsersTable $Users
 */
class UsersController extends AppController {

    public $helpers = [
        'PlumSearch.Search'
    ];

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Cookie');
		$this->loadComponent('Platform.Email');
        $this->loadComponent('PlumSearch.Filter', [
            'parameters' => [
                ['name' => 'username', 'className' => 'Input'],
                [
                    'name' => 'role_id',
                    'className' => 'Select',
                    'finder' => $this->Users->Roles->find('list'),
                ]
            ]
        ]);
    }

	public function beforeFilter(Event $event) {
	    parent::beforeFilter($event);
		//Allow users to signin and signup
	    $this->Auth->allow(['signin', 'signup']);
	}

/**
 * Index method
 *
 * @return void
 */
	public function index() {
        $this->set('users', $this->paginate($this->Filter->prg($this->Users)));
    }

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function view($id = null) {
		$user = $this->Users->get($id, [
			'contain' => []
		]);
		$this->set('user', $user);
	}

/**
 * Add method
 *
 * @return void
 */
	public function add() {
		$this->Users->addBehavior('Tools.Passwordable', [
			'formField' => 'password_new',
			'formFieldRepeat' => 'password_confirm',
			'formFieldCurrent' => 'password_current',
		]);
		$user = $this->Users->newEntity($this->request->data);
		if ($this->request->is('post')) {
            $rememberPass = $user->password_new;
			if ($this->Users->save($user)) {
                if($sendEmail = $this->request->data('send_registration_email')){
                    $user->password = $rememberPass;
                    $this->Email->send($user->email, ['user' => $user], [
                        'subject' => __('Registration confirmation'),
                        'template' => 'Passengers.signup'
                    ]);
                }
                $this->Flash->success('The user has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The user could not be saved. Please, try again.');
			}
			$user->unsetProperty('password_new');
			$user->unsetProperty('password_confirm');
		}
		$roles = $this->Users->Roles->find('list');
		$this->set(compact('user', 'roles'));
	}

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function edit($id = null) {
		$user = $this->Users->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$this->Users->addBehavior('Tools.Passwordable', [
				'require' => false,
				'formField' => 'password_new',
				'formFieldRepeat' => 'password_confirm',
				'formFieldCurrent' => 'password_current',
			]);
			$user = $this->Users->patchEntity($user, $this->request->data);
			if ($this->Users->save($user)) {
				$this->Flash->success('The user has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The user could not be saved. Please, try again.');
			}
		}
		$roles = $this->Users->Roles->find('list');
		$this->set(compact('user', 'roles'));
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
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
	        if ($user = $this->Auth->identify()) {
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
			$user->role_id = 1;
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
		if($this->request->data('remember_me')) {
		    $this->Cookie->configKey(Configure::read('Passengers.rememberMe.cookieName'), [
		        'expires' => '+1 month',
		        'httpOnly' => true
		    ]);
		    $this->Cookie->write(Configure::read('Passengers.rememberMe.cookieName'), [
		        'username' => $this->request->data('username'),
		        'password' => $this->request->data('password')
		    ]);
		}
	}
}
