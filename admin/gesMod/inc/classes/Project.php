<?php
class Project {
	private $url = null;
	public $name = null;
	private $stable = true;
	private $versions = array();

	public function __construct ( $url = null, $name = null , $stable = true ) {
		$this->url = $url;
		$this->name = $name;
		$this->stable = $stable;

		if ( isset($this->url) ) {
			$this->fetchVersions();
		}
	}

	private function fetchVersions() {
		$versions = SVN::ls($this->url);
		foreach($versions as $version) {
			try {
				$version = new Version($version);
				if ( $this->isValidVersion($version ) ) {
					$this->addVersion($version);
				}
			} catch (Exception $e) {
			}
		}

		usort($this->versions, 'Version::cmp');
	}

	private function isValidVersion(Version $version) {
		if ( !isset($this->name) || preg_match('/^' . $this->name . '/', $version->name ) > 0 ) {
			if ( !$this->stable || $version->isStable() ) {
				return true;
			}
		}

		return false;
	}

	public function addVersion(Version $version) {
		if ( !isset($this->name) ) {
			$this->name = $version->project;
		} elseif ( $this->name !== $version->project ) {
			throw new exception('Invalid version ' . $version->name . ' for project ' . $this->name);
		}

		array_push($this->versions, $version);
	}

	public function getVersions() {
		usort($this->versions, 'Version::cmp');
		return $this->versions;
	}

	public function getLatest() {
		usort($this->versions, 'Version::cmp');
		return end($this->versions);
	}
}
?>