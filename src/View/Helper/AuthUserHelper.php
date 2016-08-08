<?php

namespace Passengers\View\Helper;

use Tools\View\Helper\AuthUserHelper as BaseAuthUserHelper;

/**
 * Helper to access auth user data.
 *
 * @author Mark Scherer
 */
class AuthUserHelper extends BaseAuthUserHelper {

	/**
	 * AuthUserHelper::_getUser()
	 *
	 * @return array
	 */
	protected function _getUser() {
		return $this->_View->request->session()->read('Auth.User');
	}

    public function hasRole($expectedRole, $providedRoles = null) {
		if ($providedRoles !== null) {
			$roles = (array)$providedRoles;
		} else {
			$roles = (array)$this->roles();
		}
		if (empty($roles)) {
			return false;
		}
		if (in_array($expectedRole, $roles, true)) {
			return true;
		}
		return false;
	}


}
