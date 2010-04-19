<?php
/**
* function_empire.php 
* @package Empire
* @author ben.12
* @link http://www.ogsteam.fr
*/
/***************************************************************************
*	filename	: home_empire.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 19/12/2005
*	modified	: 30/07/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

//Flotte
/**
* Langages courant pour le mod Empire
* @global array $mod_empire_lang
*/
$mod_empire_lang["PT5"] = "Navette PT-5";
$mod_empire_lang["GT50"] = "Navette GT-50";
$mod_empire_lang["CLEG"] = "Chasseur";
$mod_empire_lang["CLAN"] = "Chasseur Lance";
$mod_empire_lang["FREG"] = "Frégate d'assaut";
$mod_empire_lang["DEST"] = "Destroyer";
$mod_empire_lang["OVER"] = "Overlord";
$mod_empire_lang["FORT"] = "Forteresse Noire";
$mod_empire_lang["HYPE"] = "Hyperion";
$mod_empire_lang["COLL"] = "Collecteur";
$mod_empire_lang["SOND"] = "Sonde";
$mod_empire_lang["COLO"] = "Colonisateur";
$mod_empire_lang["VE"] = "Vaisseau Extracteur";


function mod_empire_get_ship($ship, $add=false) {
	global $user_data, $mod_empire_lang, $db;
	
	$lines = array();
	$ship = stripcslashes($ship);
	$lines = explode(chr(10), $ship);
	$OK = false;
	$get_ship = array("PT5" => 0, "GT50" => 0, "CLEG" => 0, "CLAN" => 0, "FREG" => 0, "DEST" => 0,
						"OVER" => 0, "FORT" => 0, "HYPE" => 0, "COLL" => 0, "SOND" => 0, "COLO" => 0, "VE" => 0);
	
	foreach ($lines as $line) {

		$arr = array();
		$line = trim($line);

		if(strpos($line, "Type de vaisseau") === 0 ) {
			$OK = true;
			continue;
		}
		
		
		if($OK && preg_match("/^([\w\s-]+)\s+(\d+)/", $line, $arr)) {
			foreach($mod_empire_lang as $key => $name) {
				if($name==trim($arr[1])) {
					$get_ship[$key] = $arr[2];
					break;
				}
			}
			continue;
		}
	}
	
	if($add) {
		$request = "SELECT";
		foreach($get_ship as $key => $value) {
			$request .= "`".$key."`, ";
		}
		$request = substr($request, 0, strlen($request)-2);
		$request .= " FROM ".TABLE_MOD_EMPIRE." WHERE user_id=".$user_data['user_id'];
		$result = $db->sql_query($request);
		$lines = $db->sql_fetch_assoc($result);
		foreach($lines as $key => $value) {
			$get_ship[$key] += $value;
		}
	}
	
	$request = "UPDATE ".TABLE_MOD_EMPIRE." SET";
	foreach($get_ship as $key => $value) {
		$request .= " `".$key."`=".$value.", ";
	}
	$request = substr($request, 0, strlen($request)-2);
	$request .= " WHERE user_id=".$user_data['user_id'];
	$db->sql_query($request);
}

?>
