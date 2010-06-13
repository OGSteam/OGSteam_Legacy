<?php
class Version {
	public $name = null;
	public $project = null;
	public $version = null;
	public $major = null;
	public $minor = null;
	public $quantifier = null;

	public function __construct($name) {
		// Remove trailing / if any
		$name = preg_replace('#^(.*)/$#', '$1', $name);

		if ( preg_match('/([\w-]+)-(\d+)\.(\d+)\.(\d+)(?:-([\w-]+))?/', $name, $matches) <= 0 ) {
			throw new Exception('Invalid project version: ' . $name);
		}

		$this->name = $name;
		$this->project = $matches[1];
		$this->version = $matches[2];
		$this->major = $matches[3];
		$this->minor = $matches[4];

		if ( array_key_exists(5, $matches ) ) {
			$this->quantifier = $matches[5];
		} else {
			$this->quantifer = null;
		}
	}

	public function isRc() {
		return isset($this->quantifier) && (stripos($this->quantifier, 'rc') === 0);
	}

	public function isBeta() {
		return isset($this->quantifier) && (stripos($this->quantifier, 'beta') === 0);
	}

	public function isAlpha() {
		return isset($this->quantifier) && (stripos($this->quantifier, 'alpha') === 0);
	}

	public function isRev() {
		return isset($this->quantifier) && (stripos($this->quantifier, 'rev') === 0);
	}

	public function isStable() {
		return !$this->isRc() && !$this->isBeta() && !$this->isAlpha() && !$this->isRev();
	}

	public function getVersion() {
		$version = $this->version . '.' . $this->major . '.' . $this->minor;
		if ( isset($this->quantifier) ) {
			$version .= '-' . $this->quantifier;
		}
		return $version;
	}

	public static function cmp($v1, $v2) {
		return strnatcmp($v1->name, $v2->name);
	}
}
?>