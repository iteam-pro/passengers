<?php
namespace Passengers\Auth;

use Cake\Auth\BaseAuthenticate;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\ORM\TableRegistry;

class GuestAuthenticate extends BaseAuthenticate
{
    public function authenticate(Request $request, Response $response)
    {
        return false;
    }

    public function unauthenticated(Request $request, Response $response)
    {
        $role = TableRegistry::get('Passengers.roles')->get(1);
        $session = $request->session();

        $user = [
            'id' => '0',
            'role_id' => $role->id,
            'username' => 'guest',
            'email' => 'me@guest.co',
            'active' => 1,
            'role' => $role->toArray()
        ];
        if(!$session->read('Auth.User')){
            $session->write('Auth.User', $user);
        }
        return null;
    }
}
