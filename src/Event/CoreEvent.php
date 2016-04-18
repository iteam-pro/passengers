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
                    'scope' => ['Users.active' => 1],
                ],
                'FOC/Authenticate.Cookie',
                'FOC/Authenticate.MultiColumn' => [
					'columns' => ['username', 'email'],
					'passwordHasher' => [
						'className' => 'Default',
						'hashers' => ['Default']
					]
				],
                //bypass auth with guest params
                'Passengers.Guest',
		    ],
	    ]);
        $authorizeConfig = [
            'Controller'
        ];
        if(Plugin::loaded('TinyAuth')){
            if(file_exists(CONFIG.'acl.ini')){
                $authorizeConfig = [
                    AuthComponent::ALL => ['actionPath' => 'controllers/'],
                    'TinyAuth.Tiny' => [
                        'roleColumn' => 'role_id', // Foreign key for the Role ID in users table or in pivot table
                        'aliasColumn' => 'slug', // Name of column in roles table holding role alias/slug
                        'rolesTable' => 'Passengers.Roles', // name of Configure key holding available roles OR class name of roles table
                        'usersTable' => 'Passengers.Users', // name of the Users table
                        'superAdminRole' => 4, // id of super admin role, which grants access to ALL resources
                        'autoClearCache' => Configure::read('debug')
                    ],
                ];
            }
        } elseif(Plugin::loaded('Acl')){
            $controller->loadComponent('Acl.Acl');
            if(file_exists(CONFIG.'acl.php')){
                $controller->Acl->config('PhpAcl');
            }
            $authorizeConfig = [
                AuthComponent::ALL => ['actionPath' => 'controllers/'],
                'Acl.Actions' => [
                    'userModel' => 'Passengers.Users'
                ],
            ];
        }
        $controller->Auth->config('authorize', $authorizeConfig);
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

}
