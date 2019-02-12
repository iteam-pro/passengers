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
        $controller = $event->getSubject();
        $active = true;
        if($controller->request->is('post')){
            $userName = '';
            if ($controller->request->data('username'))
                $userName = $controller->request->data('username');
            if ($controller->request->data('email'))
                $userName = $controller->request->data('email');
            if($userName) {
                $usersTable = TableRegistry::get('Passengers.Users');
                //$active = $controller->Users->find('all', [
                $active = $usersTable->find('all', [
                    'conditions' => [
                        'Users.active' => true,
                        'OR' => [
                            'Users.email' => $userName,
                            'Users.username' => $userName
                        ]
                    ]
                ])->count();
            }
        }
        if(!$active){
            $event->stopPropagation();
            return __d('passengers', 'Sorry, but your account has been not activated yet.');
        }
    }

}
