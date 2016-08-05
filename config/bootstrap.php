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

use Cake\Event\EventManager;
use Cake\Core\Configure;
use Cake\Core\Plugin;

//TODO: For some reasons RearEngine does not loading properly
//Plugin::loadAll([
//    ['ignoreMissing' => true, 'bootstrap' => true],
//    'RearEngine' => ['routes' => true],
//]);
Plugin::load('RearEngine', ['bootstrap' => true, 'routes' => true]);

//Attach CoreEvent to wrap Acl And Auth into App
EventManager::instance()->attach(
    new Passengers\Event\CoreEvent,
    null
);

EventManager::instance()->attach(
    new Passengers\Event\SignInEvent,
    null
);

//Manage for admin registration
Configure::write('Passengers.admin.registration.enable', true);

//Configureing recommended simple TinyAuth plugin. It should loaded later by Event if plugin injected project by composer
//To use this plugin you need to create acl.ini file in your app config dir
Configure::write('Passengers.authorizers.Tiny', [
    'className' => 'TinyAuth.Tiny',
    'roleColumn' => 'role_id', // Foreign key for the Role ID in users table or in pivot table
    'aliasColumn' => 'slug', // Name of column in roles table holding role alias/slug
    'rolesTable' => 'Passengers.Roles', // name of Configure key holding available roles OR class name of roles table
    'usersTable' => 'Passengers.Users', // name of the Users table
    'superAdminRole' => 4, // id of super admin role, which grants access to ALL resources
    'autoClearCache' => Configure::read('debug')
]);

/*
//Removed from event but require special config
if(Plugin::loaded('Acl')&&file_exists(CONFIG.'acl.php')){
    $controller->loadComponent('Acl.Acl');
    $controller->Acl->config('PhpAcl');
    $authorizeConfig['Acl.Actions'] = [
        'userModel' => 'Passengers.Users'
    ];
}
*/
