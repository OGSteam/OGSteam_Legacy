<?php
require_once 'PHPUnit/Framework.php';
require_once 'common.php';

class SVNTest extends PHPUnit_Framework_TestCase {
	public function testLs() {
		var_dump(SVN::ls('http://svn.ogsteam.fr/tags/ogspy-mod/'));
	}

	public function testExport() {
		var_dump(SVN::export('http://svn.ogsteam.fr/tags/ogspy-mod/advspy-0.9.2/', 'tmp/advspy'));
	}
}
?>