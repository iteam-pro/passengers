<?php
namespace Passengers\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Passengers\Model\Table\SessionsTable;
use Cake\TestSuite\TestCase;

/**
 * Passengers\Model\Table\SessionsTable Test Case
 */
class SessionsTableTest extends TestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = [
		'plugin.passengers.session'
	];

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$config = TableRegistry::exists('Sessions') ? [] : ['className' => 'Passengers\Model\Table\SessionsTable'];
		$this->Sessions = TableRegistry::get('Sessions', $config);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Sessions);

		parent::tearDown();
	}

}
