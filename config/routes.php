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

use Cake\Routing\Router;

Router::plugin('Passengers', function($routes) {
	$routes->fallbacks('InflectedRoute');
});
Router::connect('/signin', ['plugin' => 'Passengers', 'controller' => 'Users', 'action' => 'signin']);
Router::connect('/signout', ['plugin' => 'Passengers', 'controller' => 'Users', 'action' => 'signout']);
Router::connect('/signup', ['plugin' => 'Passengers', 'controller' => 'Users', 'action' => 'signup']);
Router::connect('/user/reset', ['plugin' => 'Passengers', 'controller' => 'Users', 'action' => 'reset']);
Router::connect('/user/activate/*', ['plugin' => 'Passengers', 'controller' => 'Users', 'action' => 'activate']);

Router::prefix('admin', function($routes) {
	$routes->plugin('Passengers', function($routes) {
		$routes->fallbacks('InflectedRoute');
	});
	$routes->connect('/users', ['plugin' => 'Passengers', 'controller' => 'Users', 'action' => 'index']);
	$routes->connect('/users/:action', ['plugin' => 'Passengers', 'controller' => 'Users']);
	$routes->connect('/roles', ['plugin' => 'Passengers', 'controller' => 'Roles', 'action' => 'index']);
	$routes->connect('/roles/:action', ['plugin' => 'Passengers', 'controller' => 'Roles']);

	$routes->connect('/signin', ['plugin' => 'Passengers', 'controller' => 'Users', 'action' => 'signin']);
	$routes->connect('/signout', ['plugin' => 'Passengers', 'controller' => 'Users', 'action' => 'signout']);
	$routes->connect('/signup', ['plugin' => 'Passengers', 'controller' => 'Users', 'action' => 'signup']);

});
