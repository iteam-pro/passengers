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
