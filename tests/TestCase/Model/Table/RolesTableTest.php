<?php
namespace Passengers\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Passengers\Model\Table\RolesTable;
use Cake\TestSuite\TestCase;

/**
 * Passengers\Model\Table\RolesTable Test Case
 */
class RolesTableTest extends TestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = [
		'plugin.passengers.role',
		'plugin.passengers.user'
	];

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$config = TableRegistry::exists('Roles') ? [] : ['className' => 'Passengers\Model\Table\RolesTable'];
		$this->Roles = TableRegistry::get('Roles', $config);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Roles);

		parent::tearDown();
	}

}
