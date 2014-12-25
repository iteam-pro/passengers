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

use Cake\Event\EventListenerInterface;
use Cake\Controller\Component\AuthComponent;
use Cake\Core\Configure;

class CoreEvent implements EventListenerInterface {

    public function implementedEvents() {
        return array(
	        'Controller.initialize' => array(
                'callable' => 'onControllerInit',
            ),
        );
    }

    public function onControllerInit($event) {
        $controller = $event->subject();

		//Skip Auth for non app controllers. DebugKit For example
	    if(!in_array('App\Controller\AppController', class_parents($controller))) return;

        $controller->loadComponent('Cookie');
        $controller->loadComponent('Auth', [
		    'loginAction' => [
                'plugin' => 'Passengers',
                'controller' => 'Users',
                'action' => 'signin',
            ],
            'loginRedirect' => Configure::read('Passengers.auth.logout_redirect'),
            'logoutRedirect' => [
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
                //TODO Replace to Passengers/Authenticate.Cookie after session call fix
                'Passengers.Cookie',
				'FOC/Authenticate.MultiColumn' => [
					'columns' => ['username', 'email'],
					'passwordHasher' => [
						'className' => 'Default',
						'hashers' => ['Default']
					]
				]
		    ],
            //'authorize' => [
            //    AuthComponent::ALL => ['actionPath' => 'controllers/'],
            //    'Passengers.DbAcl' => [
            //        'userModel' => 'Passengers.Users'
            //    ],
            //    'Passengers.PhpAcl' => [
            //        'userModel' => 'Passengers.Users'
            //    ],
            //],
	    ]);
        //$controller->loadComponent('Passengers.Acl', [
        //]);
    }
}
