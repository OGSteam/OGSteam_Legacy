<?php
/**
 * @package Xtense 2
 * @author Unibozu
 * @licence GNU
 */

abstract class Check {
	static function filterSpecialChars ($string) {//http://www.wikistuce.info/doku.php/php/supprimer_tous_les_caracteres_speciaux_d-une_chaine
		$string = utf8_decode($string);
		//echo $string;
		//$search = array ('@[éèêëÊË]@i','@[àâäÂÄ]@i','@[îïÎÏ]@i','@[ûùüÛÜ]@i','@[ôöÔÖ]@i','@[ç]@i','@[^a-zA-Z0-9_ -]@');
		//$replace = array ('e','a','i','u','o','c','');
		
		//$search = '@[^éèêëÊËàâäÂÄîïÎÏûùüÛÜôöÔÖç_. a-zA-Z0-9-]@';
		/*$search = '@[^a-zA-Z0-9_. -]@';
		$replace = '';
		return preg_replace($search, $replace, $string);*/
		return $string;
	}
	
	static function player_name($string) {
		return preg_match('![A-Z0-9_ -]{1,20}!i', $string);
		//return preg_match('!.{1,20}!i', $string);
	}
	
	static function planet_name($string) {
		//return preg_match('![A-Z0-9éè_. -]{1,20}!i', $string);
		return preg_match('!.{1,20}!i', $string);
	}
	
	static function player_status($string) {
		return preg_match('!^[snfdvbiI]*$!', $string);//fdvbiI en français, snvbiI in english
	}
	
	static function ally_tag($string) {
		//return preg_match('!^[A-Z0-9\\ ._-]{0,8}$!i', $string);
		return preg_match('!.{0,8}!i', $string);
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
		if ($string == "unknown") return true; //cas avec une seule planète
		if (!preg_match('!^([0-9]{1,2}):([0-9]{1,3}):([0-9]{1,2})$!Usi', $string, $match)) return false;
		return !($match[1] < 1 || $match[2] < 1 || $match[3] < 1 || $match[1] > $config['num_of_galaxies'] || $match[2] > $config['num_of_systems'] || ($exp ? ($match[3] != 16) : ($match[3] > 15))) ;
	}
	
	static function date($d) {
					//date au format anglais 																					//date au format de/fr
		return preg_match('!^[01][0-9]-[0-3][0-9] [0-2][0-9]:[0-6][0-9]:[0-6][0-9]$!', $d) || preg_match('!^[0-3][0-9]-[01][0-9] [0-2][0-9]:[0-6][0-9]:[0-6][0-9]$!', $d);
	}
	
	static function data() {
		foreach (func_get_args() as $v) {
			if (!$v) die('hack');
		}
	}
	
	static function data2() {
		foreach (func_get_args() as $v) {
			if (!$v) {
				return false;
			}
		}
		return true;
	}
	
	static function universe($str) {
		$universe = false;//'http://uni0.ogame.fr';
		if(!defined('CARTO')) {
			if (preg_match('!(uni[0-9]+\\.ogame\\.[A-Z.]+)(\\/|$)!Ui', $str, $matches)) 
				$universe = 'http://'.strtolower($matches[1]);
		}
		else if(CARTO == 'OGSpy') {
			if (preg_match('!([a-z0-9]+.ogame\\.[A-Z.]+)(\\/|$)!Ui', $str, $matches)) 
				$universe = 'http://'.strtolower($matches[1]);
		}
		else if(CARTO == 'UniSpy') {
			//echo '$universe'.$str;
			if (preg_match('!((bt|testing|(beta[0-9]+)|b1)\\.e-univers\\.[A-Z.]+)(\\/|$)!Ui', $str, $matches)) 
				$universe = 'http://'.strtolower($matches[1]);
			//echo '|'.$universe;
		}
		return $universe;
	}
	
}


?>