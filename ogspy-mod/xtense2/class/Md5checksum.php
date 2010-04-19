<?php
/**
 * @package Xtense 2
 * @author Unibozu
 * @licence GNU
 */

class Md5checksum {
	protected $basePath = '';
	protected $checkHiddenFile = false;
	protected $hashs = array();
	private $currentPattern = '';
	
	public function __construct($path = '', $hiddenFiles = false) {
		$this->setBasePath($path);
		$this->checkHiddenFile = !!$hiddenFiles;
	}
	
	public function check($file) {
		if (!file_exists($this->basePath.$file)) throw new Exception('Checksum file doesn\'t exist > "'.$file.'"');
		
		$contents = file($this->basePath.$file);
		$invalid = array();
		
		foreach ($contents as $line) {
			if ($line[0] != '#' && $line[0] != ';' && trim($line) != '') {
				$data = array_map('trim', explode(' ', $line, 2));
				
				if (!file_exists($this->basePath.$data[1]) || md5_file($this->basePath.$data[1]) != $data[0]) $invalid[] = $data[1];
			}
		}
		
		return (empty($invalid) ? true : $invalid);
	}
	
	public function createChecksumFile ($filename, $ignore = array()) {
		$files = array();
		$this->listFiles($files);
		
		foreach ($ignore as $pattern) {
			$this->currentPattern = '!^'.str_replace('\\*', '.*', preg_quote($pattern)).'$!Us';
			$files = array_filter($files, array($this, 'filesFilter'));
		}
		
		if (strpos($filename, '.') === false) $filename .= '.md5';
		
		$fp = @fopen($this->basePath.$filename, 'w');
		if (!$fp) throw new Exception('Can\t open/create checksum file "'.$filename.'"');
		
		fwrite($fp, '# Checksum file generated with Md5checksum PHP class - By unibozu <contact@unibozu.fr>'."\n");
		fwrite($fp, '# Generated '. date('r')."\n");
		fwrite($fp, '# Files: '.count($files)."\n\n");
		
		foreach ($files as $f) {
			$hash = md5_file($this->basePath.$f);
			fwrite($fp, $hash.' '.$f."\n");
		}
		
		fclose ($fp);
	}
	
	private function filesFilter($filename) {
		return !preg_match($this->currentPattern, $filename);
	}
	
	private function md5file($file) {
		return md5_file($this->basePath.$file);
	}
	
	private function listFiles(&$a, $path = '') {
		$fp = opendir($this->basePath.$path);
		while (($file = readdir($fp)) !== false) {
			if ($file != '.' && $file != '..' && ($this->checkHiddenFile || $file[0] != '.')) {
				if (is_dir($this->basePath.$path.$file)) $this->listFiles($a, $path.$file.'/');
				else $a[] = $path.$file;
			}
		}
	}
	
	public function setBasePath($path) {
		if (($path = realpath($path)) === false) throw new Exception('Invalid path "'.$path.'"');
		if ($path[strlen($path)-1] != '/') $path .= '/';
		$this->basePath = $path;
	}
}

