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

namespace Passengers\Controller\Component;

use Acl\Controller\Component\AclComponent as ParentComponent;

/**
 * Access Control List factory class.
 *
 * Uses a strategy pattern to allow custom ACL implementations to be used with the same component interface.
 * You can define by changing `Configure::write('Acl.classname', 'DbAcl');` in your App/Config/app.php. The adapter
 * you specify must implement `AclInterface`
 *
 * @link http://book.cakephp.org/2.0/en/core-libraries/components/access-control-lists.html
 */
class AclComponent extends ParentComponent {

/**
 * Constructor. Will return an instance of the correct ACL class as defined in `Configure::read('Acl.classname')`
 *
 * @param ComponentRegistry $collection A ComponentRegistry
 * @param array $config Array of configuration settings
 * @throws \Cake\Core\Exception\Exception when Acl.classname could not be loaded.
 */
	public function __construct(ComponentRegistry $collection, array $config = []) {
		parent::__construct($collection, $config);
		$className = $name = Configure::read('Acl.classname');
		if (!class_exists($className)) {
			$className = App::className('Acl.' . $name, 'Adapter');
			if (!$className) {
				throw new Exception(sprintf('Could not find {0}.', [$name]));
			}
		}
		$this->adapter($className);
	}

}
