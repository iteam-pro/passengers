<?php

// -------------------------------------
// Roles
// -------------------------------------
$config['roles'] = array(
	'Role/guest'				=> null,
	'Role/registered'			=> null,
	'Role/manager'				=> null,
	'Role/admin'				=> null,
	'User/admin'				=> 'Role/admin',
);

//-------------------------------------
// Rules
//-------------------------------------
$config['rules']['allow'] = array(
	'/*' => 'Role/admin',
);
$config['rules']['deny'] = array(
);
