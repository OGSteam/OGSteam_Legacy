<?php
require_once 'PHPUnit/Framework.php';
require_once 'common.php';

class MultiProjectTest extends PHPUnit_Framework_TestCase {
	public function testMultiProject() {
		$project = new MultiProject('http://svn.ogsteam.fr/tags/ogspy-mod/');
		var_dump($project->getProject('xtense')->getLatest());
	}
}
?>