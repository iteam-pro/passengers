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
namespace Passengers\Event;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Controller\Component\AuthComponent;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\ORM\Association;
use Cake\ORM\Tableregistry;

if (!defined('USER_ROLE_KEY')) {
	define('USER_ROLE_KEY', 'role');
}

class CoreEvent implements EventListenerInterface {

    public function implementedEvents()
    {
        return array(
	        'Controller.initialize' => array(
                'callable' => 'onControllerInit',
                'priority' => 2
            ),
            'Auth.afterIdentify' => array(
                'callable' => 'onAuthIdentify',
            )
        );
    }

    public function onControllerInit(Event $event)
    {
        $controller = $event->subject();

		//Skip Auth for non app controllers. DebugKit For example
        //possible injection hole, but needed.
	    if(!in_array('App\Controller\AppController', class_parents($controller))) return;

        $controller->loadComponent('Cookie');
        $loginRedirect = '/';
        if(isset($controller->request->params['prefix'])){
            $loginRedirect .= $controller->request->params['prefix'];
        }
        $controller->loadComponent('Auth', [
            'loginAction' => [
                'plugin' => 'Passengers',
                'controller' => 'Users',
                'action' => 'signin',
            ],
            'loginRedirect' => $loginRedirect,
            'logoutRedirect' => [
                'plugin' => 'Passengers',
                'controller' => 'Users',
                'action' => 'signin',
            ],
            'unauthorizedRedirect' => [
                'plugin' => 'Passengers',
                'controller' => 'Users',
                'action' => 'signin',
            ],
		    'authenticate' => [
			    AuthComponent::ALL => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password'
                    ],
                    'userModel' => 'Passengers.Users',
					'finder' => 'active'
                ],
				'Form',
				'Passengers.Cookie',
		    ],
	    ]);
        $authorizeConfig = [];
        if($authorizers = Configure::read('Passengers.authorizers')){
            foreach($authorizers as $key=>$authorizer){
                if(isset($authorizer['className'])&&($plugin = pluginSplit($authorizer['className'])[0])){
                    if(!Plugin::loaded($plugin)){
                        continue;
                    }
                }
                $authorizeConfig[$key] = $authorizer;
            }
        }
        $forceAuth = Configure::read('App.force_user_auth');
        if($forceAuth&&empty($authorizeConfig)){
            $authorizeConfig[] = 'Controller';
        }
        $controller->Auth->config('authorize', array(AuthComponent::ALL => ['actionPath' => 'controllers/'])+$authorizeConfig);

        $this->_setUser($controller);
        $controller->loadComponent('Passengers.AuthUser');
        $controller->viewBuilder()->helpers(['Passengers.AuthUser']);
    }

    public function onAuthIdentify(Event $event)
    {
        $object = $event->subject();
        list($user, $auth) = $event->data;
        if(!isset($user['id'])){
            return;
        }
        if($userModel = $auth->config('userModel')){
            $userModel = TableRegistry::get($userModel);
            $contain = [];
            foreach($userModel->associations() as $association){
                if(in_array($association->type(), [Association::ONE_TO_ONE, Association::MANY_TO_ONE])){
                    $contain[] = $association->name();
                }
            }
            if(!empty($contain)){
                $user = $userModel->get($user['id'], ['contain' => $contain])->toArray();
                unset($user['password']);
            }
        }
        //set result to return updated user data
        return $user;
    }

    protected function _setUser($controller){
        $request = $controller->request;

		//force user identification if cookies rememberMe found
		if (!$controller->Auth->user() && $controller->Cookie->read(Configure::read('Passengers.rememberMe.cookieName'))) {
	        $user = $controller->Auth->identify();
	        if ($user) {
	            $controller->Auth->setUser($user);
	        } else {
	            $controller->Cookie->delete(Configure::read('Passengers.rememberMe.cookieName'));
	        }
	    }

        $forceAuth = Configure::read('App.force_user_auth');
        //if authentication forced just skip guest user session and redirect to signin page
        if(!$forceAuth&&!$request->session()->read('Auth.User')){
            //if authentication not forced check prefix. Usually only requests without prefixes allow guests
            if(!isset($request->params['prefix'])||empty($request->params['prefix'])){
                $role = TableRegistry::get('Passengers.Roles')->findBySlug('guest')->first();
                if(!$role){
                    $role = [
                        'id' => 1,
                        'title' => 'Guest',
                        'slug' => 'guest',
                        'admin' => false,
                        'core' => true,
                        'created' => null,
                        'modified' => null,
                        'user_count' => 0
                    ];
                } else {
                    $role = $role->toArray();
                }
                $user = [
                    'id' => '0',
                    'role_id' => $role['id'],
                    'username' => 'guest',
                    'email' => 'me@guest.tld',
                    'active' => 1,
                    'role' => $role
                ];
                $controller->Auth->setUser($user);
            }
        }
    }

}
