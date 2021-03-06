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
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
use Cake\Auth\DefaultPasswordHasher;

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
		$this->Auth->allow(['signin', 'signup', 'reset']);
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
 * SignIn method
 *
 * @return void
 * @throws NotFoundException
 */
	public function signin() {
		if ($this->request->is('post')) {
			$event = $this->dispatchEvent('Controller.Users.beforeSignIn');
			if ($event->isStopped()) {
				$this->Flash->error($event->result);
				$this->redirect(['action' => 'signin']);
			}
			if ($user = $this->Auth->identify()) {
				$this->Auth->setUser($user);
				$this->_setCookie();
				$event = $this->dispatchEvent('Controller.Users.afterSignIn');
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
		$this->Users->addBehavior('Passengers.Passwordable', [
			'formField' => 'password_new',
			'formFieldRepeat' => 'password_confirm',
			'formFieldCurrent' => 'password_current',
		]);
        $user = $this->Users->newEntity();
		if ($this->request->is('post')&&$signupAllowed) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            //TODO: make it configurable
            $user->role_id = 2;
            $user->active = 1;
            foreach($user->errors() as $field=>$error){
                $this->Flash->error(__d('passengers', implode("\n", $error)));
                return;
            }
			if(Configure::read('App.use_users_activation')){
				$user->active = 1;
				$user->activation_code = md5(time().$_data['password_new']);
			}
            $event = $this->dispatchEvent('Controller.Users.beforeSignUp', [$user]);
            if ($event->isStopped()) {
                $this->Flash->error($event->result);
                return;
            }
			$rememberPass = $user->password_new;
			if ($this->Users->save($user)) {
				$user->password = $rememberPass;
                //Deprecated! Email sending moved to event afterSignUp
                //$this->Email->send($user->email, ['user' => $user], [
				//	'subject' => __('Registration confirmation'),
				//	'template' => 'Passengers.signup'
				//]);
                $this->dispatchEvent('Controller.Users.afterSignUp', [$user]);
				$this->Flash->success(__d('passengers', 'Your account has been created.'));
				return $this->redirect(['action' => 'signin']);
			} else {
                foreach($user->errors() as $field=>$error){
                    $this->Flash->error(__d('passengers', implode(" ", $error)));
                }
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

    public function reset()
    {
        if ($this->request->is('post')) {
            $user = $this->Users->find('all', [
                'conditions' => [
                    'Users.active' => true,
                    'Users.email' => $this->request->data('email'),
                ]
            ])->first();

            if ($user) {
                $password = (new ComputerPasswordGenerator())
                    ->setOptionValue(ComputerPasswordGenerator::OPTION_UPPER_CASE, true)
                    ->setOptionValue(ComputerPasswordGenerator::OPTION_LOWER_CASE, true)
                    ->setOptionValue(ComputerPasswordGenerator::OPTION_NUMBERS, true)
                    ->setOptionValue(ComputerPasswordGenerator::OPTION_SYMBOLS, false)
                    ->generatePassword();

                $this->Users->addBehavior('Passengers.Passwordable', [
                    'confirm' => false,
                ]);
                $user = $this->Users->patchEntity($user, ['pwd' => $password]);
                if ($this->Users->save($user)) {
                    $user->password = $password;
                    //Deprecated. Old way to send reset email
                    //$this->Email->send($user->email, ['user' => $user], [
                    //    'subject' => __('Reset password'),
                    //    'template' => 'Passengers.reset'
                    //]);
                    $this->getMailer('Passengers.User')->send('resetPassword', [$user]);
                    $this->Flash->success('Please check email for new password.');
                    return $this->redirect(['action' => 'signin']);
                } else {
                    $this->Flash->error('The password could not be reseted. Please, try again.');
                }
            }

            $this->Flash->warning(__d('passengers', 'If the email you specified exists in our system, we\'ve sent a new password to it.'));
            return $this->redirect(['action' => 'signin']);
        }
    }

    public function password()
    {
        if ($this->request->is('post')) {
            $user = $this->Users->findById(
                $this->request->session()->read('Auth.User.id')
            )->first();

            if ((new DefaultPasswordHasher)->check($this->request->data('password_current'), $user->password)) {
                $this->Users->addBehavior('Passengers.Passwordable', [
                    'current' => true,
                    'formFieldCurrent' => 'password_current',
                    'formField' => 'password_new',
                    'formFieldRepeat' => 'password_confirm',
                ]);

                $user = $this->Users->patchEntity($user, $this->request->data);
                if ($this->Users->save($user)) {
                    $this->Flash->success('The password has been changed.');
                    return $this->redirect(['action' => 'password']);
                } else {
                    $this->Flash->error('The password could not be changed. Please, try again.');
                    return $this->redirect(['action' => 'password']);
                }
            }

            $this->Flash->error('Error. The password could not be changed. Please, try again.');
            return $this->redirect(['action' => 'password']);
        }
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
