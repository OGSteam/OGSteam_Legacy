<?php
/**
 * @package Xtense 2
 * @author Unibozu
 * @licence GNU
 */

abstract class Callback {
	protected $version = '0';
	protected $root = '';
	
	private static $instances = array();
	
	public static function load($root) {
		if (isset(self::$instances[$root])) return self::$instances[$root];
		if (!file_exists('mod/'.$root.'/_xtense.php')) throw new Exception(__('callback file exists'));
		
		require_once('mod/'.$root.'/_xtense.php');
		$class = $root.'_Callback';
		
		if (!class_exists($class)) throw new Exception(__('callback class exists', $class));
		
		$call = new $class();
		$call->setRoot($root);
		
		if (!$call instanceof Callback) throw new Exception(__('callback class abstract', $class));
		if (!$call->validVersion()) throw new Exception(__('callback version',$call->version));
		
		self::$instances[$root] = $call;
		
		return $call;
	}
	
	final public function validVersion() {
		return version_compare(PLUGIN_VERSION, $this->version, '>=');
	}
	
	final public function setRoot($root) {
		$this->root = $root;
	}
	
	abstract public function getCallbacks();
}

