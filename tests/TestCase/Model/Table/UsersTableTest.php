<?php
namespace Passengers\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Passengers\Model\Table\UsersTable;
use Cake\TestSuite\TestCase;

/**
 * Passengers\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = [
		'plugin.passengers.user',
		'plugin.passengers.role'
	];

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$config = TableRegistry::exists('Users') ? [] : ['className' => 'Passengers\Model\Table\UsersTable'];
		$this->Users = TableRegistry::get('Users', $config);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Users);

		parent::tearDown();
	}

}
