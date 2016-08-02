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
        if(!$request->session()->read('Auth.User')){
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
            $request->session()->write('Auth.User', [
                'id' => '0',
                'role_id' => $role['id'],
                'username' => 'guest',
                'email' => 'me@guest.co',
                'active' => 1,
                'role' => $role
            ]);
        }
    }
}
