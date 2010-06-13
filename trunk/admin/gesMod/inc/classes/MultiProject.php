<?php
class MultiProject {
	private $url;
	private $projects = array();

	public function __construct ( $url, $stable = true ) {
		$this->url = $url;

		$this->fetchVersions($stable);
	}

	private function fetchVersions($stable) {
		$versions = SVN::ls($this->url);

		foreach($versions as $version) {
			try {
				$version = new Version($version);
				if ( self::isValidVersion($stable, $version ) ) {
					if ( !array_key_exists($version->project, $this->projects) ) {
						$this->projects[$version->project] = new Project();
					}

					$this->projects[$version->project]->addVersion($version);
				}
			} catch (Exception $e) {
			}
		}

		ksort($this->projects);
	}

	private static function isValidVersion($stable, Version $version) {
		if ( !$stable || $version->isStable() ) {
			return true;
		}

		return false;
	}

	public function getProjects() {
		return array_keys($this->projects);
	}

	public function getProject($name) {
		if ( array_key_exists($name, $this->projects) ) {
			return $this->projects[$name];
		}

		return null;
	}
}
?>