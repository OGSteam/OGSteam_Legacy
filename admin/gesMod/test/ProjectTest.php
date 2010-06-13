<?php
require_once 'PHPUnit/Framework.php';
require_once 'inc/common.php';

class ProjectTest extends PHPUnit_Framework_TestCase {
	public function testProject() {
		$project = new Project('http://svn.ogsteam.fr/tags/ogspy-mod/');
		var_dump($project);
	}
}
?>