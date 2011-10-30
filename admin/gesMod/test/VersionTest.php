<?php
require_once 'PHPUnit/Framework.php';
require_once 'common.php';
// test
class ExceptionTest extends PHPUnit_Framework_TestCase {
    public function testValidVersion() {
		$version = new Version('project-1.0.0');
		$this->assertEquals($version->project, 'project');
		$this->assertEquals($version->version, 1);
    	$this->assertEquals($version->major, 0);
    	$this->assertEquals($version->minor, 0);
    	$this->assertNull($version->quantifier);

    	$version = new Version('project-1.0.0-test');
		$this->assertEquals($version->project, 'project');
		$this->assertEquals($version->version, 1);
    	$this->assertEquals($version->major, 0);
    	$this->assertEquals($version->minor, 0);
    	$this->assertEquals($version->quantifier, 'test');
    }

    public function testInvalidVersion() {
		try {
    		$this->assertNull(new Version('project-1.0-test'));
    		$this->fail();
		} catch (Exception $e) {
		}

		try {
    		$this->assertNull(new Version('project@-1.0-test'));
    		$this->fail();
		} catch (Exception $e) {
		}
    }

    public function testIsRc() {
    	$version = new Version('project-1.0.0-RC1');
		$this->assertTrue($version->isRc());
    	$version = new Version('project-1.0.0-rc1');
		$this->assertTrue($version->isRc());
		$version = new Version('project-1.0.0-aRC1');
		$this->assertFalse($version->isRc());
    }

	public function testIsBeta() {
    	$version = new Version('project-1.0.0-Beta1');
		$this->assertTrue($version->isBeta());
    	$version = new Version('project-1.0.0-bEtA1');
		$this->assertTrue($version->isBeta());
		$version = new Version('project-1.0.0-abeta1');
		$this->assertFalse($version->isBeta());
    }

	public function testIsAlpha() {
    	$version = new Version('project-1.0.0-alpha1');
		$this->assertTrue($version->isAlpha());
    	$version = new Version('project-1.0.0-AlPhA1');
		$this->assertTrue($version->isAlpha());
		$version = new Version('project-1.0.0-aalpha1');
		$this->assertFalse($version->isAlpha());
    }

	public function testIsRev() {
    	$version = new Version('project-1.0.0-rev1');
		$this->assertTrue($version->isRev());
    	$version = new Version('project-1.0.0-ReV1');
		$this->assertTrue($version->isRev());
		$version = new Version('project-1.0.0-arev1');
		$this->assertFalse($version->isRev());
    }

	public function testIsStable() {
    	$version = new Version('project-1.0.0-rev1');
		$this->assertFalse($version->isStable());
    	$version = new Version('project-1.0.0-alpha1');
		$this->assertFalse($version->isStable());
    	$version = new Version('project-1.0.0-beta1');
		$this->assertFalse($version->isStable());
	   	$version = new Version('project-1.0.0-rc1');
		$this->assertFalse($version->isStable());
	   	$version = new Version('project-1.0.0-1');
		$this->assertTrue($version->isStable());
	}
}
?>