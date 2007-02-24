<?php
/**
* @package client
* @subpackage utils
*
* This test use UNIX commands rm and svnadmin. It's probably easy to remove
* use of rm but you can't remove use of svnadmin.
*/

require_once 'USVN/Client/SVNUtils.php';

class TestClientSVNUtils extends PHPUnit2_Framework_TestCase
{
    public function setUp()
    {
        $this->clean();
        exec("svnadmin create tests/tmp/testrepository");
        mkdir('tests/tmp/fakerepository');
    }

    public function tearDown()
    {
        $this->clean();
    }

    private function clean()
    {
        exec("rm -Rf tests/tmp/testrepository");
        @rmdir('tests/tmp/fakerepository');
    }

    public function test_isSVNRepository()
    {
        $this->assertTrue(USVN_Client_SVNUtils::isSVNRepository('tests/tmp/testrepository'));
        $this->assertFalse(USVN_Client_SVNUtils::isSVNRepository('tests/tmp/fakerepository'));
    }

	public function test_changedFiles()
	{
        $this->assertEquals(array(array('M', 'tutu')), USVN_Client_SVNUtils::changedFiles('M tutu'));
        $this->assertEquals(array(array('M', 'tutu'), array('M', 'tata')), USVN_Client_SVNUtils::changedFiles('M tutu M tata'));
        $this->assertEquals(array(array('M', 'tutu'), array('M', 'M')), USVN_Client_SVNUtils::changedFiles('M tutu M M'));
        $this->assertEquals(array(array('M', 'tutu'), array('M', 'hello world')), USVN_Client_SVNUtils::changedFiles('M tutu M hello world'));
	}
}