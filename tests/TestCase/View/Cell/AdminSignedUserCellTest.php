<?php
namespace Passengers\Test\TestCase\View\Cell;

use Passengers\View\Cell\AdminSignedUserCell;
use Cake\TestSuite\TestCase;

/**
 * Passengers\View\Cell\AdminSignedUserCell Test Case
 */
class AdminSignedUserCellTest extends TestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->request = $this->getMock('Cake\Network\Request');
		$this->response = $this->getMock('Cake\Network\Response');
		$this->AdminSignedUser = new AdminSignedUserCell($this->request, $this->response);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AdminSignedUser);

		parent::tearDown();
	}

/**
 * testDisplay method
 *
 * @return void
 */
	public function testDisplay() {
		$this->markTestIncomplete('testDisplay not implemented.');
	}

}
