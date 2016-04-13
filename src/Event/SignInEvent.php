<?php
namespace Passengers\Event;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Controller\Component\AuthComponent;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\ORM\Association;
use Cake\ORM\Tableregistry;

class SignInEvent implements EventListenerInterface {

    public function implementedEvents()
    {
        return array(
	        'Controller.Users.beforeSignIn' => array(
                'callable' => 'beforeUsersControllerSignIn',
            ),
        );
    }

    public function beforeUsersControllerSignIn(Event $event)
    {
        $controller = $event->subject();
        $active = true;
        if($controller->request->is('post')){
            if($controller->request->data('username') || $controller->request->data('email')) {
                $active = $controller->Users->find('all', [
                    'conditions' => [
                        'Users.active' => true,
                        'OR' => [
                            'Users.email' => $controller->request->data('email'),
                            'Users.username' => $controller->request->data('username')
                        ]
                    ]
                ])->count();
            }
        }
        if($active){
            $event->stopPropagation();
            return __d('passengers', 'Sorry, but your account has been not activated yet.');
        }
    }

}
