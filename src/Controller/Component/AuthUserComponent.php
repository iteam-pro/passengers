<?php

namespace Passengers\Controller\Component;

use Tools\Auth\AuthUserTrait;
use Cake\Controller\Component;

/**
 * Authentication User component class
 */
class AuthUserComponent extends Component {

	use AuthUserTrait;

	/**
	 * AuthUserComponent::_getUser()
	 *
	 * @return array
	 */
	protected function _getUser() {
        $controller = $this->_registry->getController();
		return (array)$controller->request->session()->read('Auth.User');
	}

}
