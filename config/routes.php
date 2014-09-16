<?php
use Cake\Routing\Router;

Router::plugin('Passengers', function($routes) {
	$routes->fallbacks();
});

Router::prefix('admin', function($routes) {
	$routes->plugin('Passengers', function($routes) {
		$routes->fallbacks();
	});
	$routes->connect('/users', ['plugin' => 'Passengers', 'controller' => 'Users', 'action' => 'index']);
	$routes->connect('/users/:action', ['plugin' => 'Passengers', 'controller' => 'Users']);
	$routes->connect('/roles', ['plugin' => 'Passengers', 'controller' => 'Roles', 'action' => 'index']);
	$routes->connect('/roles/:action', ['plugin' => 'Passengers', 'controller' => 'Roles']);
});
