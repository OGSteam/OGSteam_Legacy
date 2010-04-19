<?php
/**
 * @package Xtense 2
 * @author Unibozu
 * @licence GNU
 */

abstract class Check {
	static function player_name($string) {
		return preg_match('![A-Z0-9_ -]{1,20}!i', $string);
	}
	
	static function planet_name($string) {
		return preg_match('![A-Z0-9éè_. -]{1,20}!i', $string);
	}
	
	static function player_status($string) {
		return preg_match('!^[fdvbiI]*$!', $string);
	}
	
	static function ally_tag($string) {
		return preg_match('!^[A-Z0-9\\ ._-]{0,8}$!i', $string);
	}
	
	static function galaxy($n) {
		global $config;
		return !($n == 0 || $n > $config['num_of_galaxies']);
	}
	
	static function system($n) {
		global $config;
		return !($n == 0 || $n > $config['num_of_systems']);
	}
	
	static function stats_type1($string) {
		return ($string == 'player' || $string == 'ally');
	}
	
	static function stats_type2($string) {
		return ($string != 'points' || $string != 'fleet' || $string != 'research');
	}
	
	static function stats_offset($off) {
		return ((($off-1) % 100) == 0);
	}
	
	static function coords($string, $exp = 0) {
		global $config;
		if (!preg_match('!^([0-9]{1,2}):([0-9]{1,3}):([0-9]{1,2})$!Usi', $string, $match)) return false;
		return !($match[1] < 1 || $match[2] < 1 || $match[3] < 1 || $match[1] > $config['num_of_galaxies'] || $match[2] > $config['num_of_systems'] || ($exp ? ($match[3] != 16) : ($match[3] > 15)));
	}
	
	static function date($d) {
		return preg_match('!^[01][0-9]-[0-3][0-9] [0-2][0-9]:[0-6][0-9]:[0-6][0-9]$!', $d);
	}
	
	static function data() {
		foreach (func_get_args() as $v) {
			if (!$v) die('hack');
		}
	}
	
}


?>