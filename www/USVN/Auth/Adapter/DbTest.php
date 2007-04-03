<?php
/**
 * Auth an user from the Database
 *
 * @author Team USVN <contact@usvn.info>
 * @link http://www.usvn.info
 * @license http://www.cecill.info/licences/Licence_CeCILL_V2-en.txt CeCILL V2
 * @copyright Copyright 2007, Team USVN
 * @since 0.5
 * @package auth
 * @subpackage db
 *
 * This software has been written at EPITECH <http://www.epitech.net>
 * EPITECH, European Institute of Technology, Paris - FRANCE -
 * This project has been realised as part of
 * end of studies project.
 *
 * $Id$
 */

// Call USVN_Auth_Adapter_DbTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "USVN_Auth_Adapter_DbTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once 'www/USVN/autoload.php';

/**
 * Test class for USVN_Auth_Adapter_Db.
 * Generated by PHPUnit_Util_Skeleton on 2007-03-25 at 09:51:30.
 */
class USVN_Auth_Adapter_DbTest extends USVN_Test_DB {
    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("USVN_Auth_Adapter_DbTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    public function setUp() {
		parent::setUp();
		USVN_Translation::initTranslation("en_US", "www/locale");
		$data = array(
			"users_id" => 2,
			"users_login" => 'testlogin',
			"users_password" => crypt('testpassword')
		);
		$this->db->insert("usvn_users", $data);
    }

    public function testAuthenticateOk()
	{
		$authAdapter = new USVN_Auth_Adapter_Db('testlogin', 'testpassword');
		$result = $authAdapter->authenticate();
		$this->assertTrue($result->isValid());
    }

    public function testAuthenticateBadLogin()
	{
		$authAdapter = new USVN_Auth_Adapter_Db('testloginfalse', 'testpassword');
		$result = $authAdapter->authenticate();
		$this->assertFalse($result->isValid());
		$this->assertEquals(array('Login testloginfalse not found'), $result->getMessages());
    }

	public function testAuthenticateBadPassword()
	{
		$authAdapter = new USVN_Auth_Adapter_Db('testlogin', 'testpasswordfalse');
		$result = $authAdapter->authenticate();
		$this->assertFalse($result->isValid());
		$this->assertEquals(array('Incorrect password'), $result->getMessages());
    }
}

// Call USVN_Auth_Adapter_DbTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "USVN_Auth_Adapter_DbTest::main") {
    USVN_Auth_Adapter_DbTest::main();
}
?>
