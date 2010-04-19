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
$mod_empire_lang["PT"] = "Petit transporteur";
$mod_empire_lang["GT"] = "Grand transporteur";
$mod_empire_lang["CLE"] = "Chasseur léger";
$mod_empire_lang["CLO"] = "Chasseur lourd";
$mod_empire_lang["CR"] = "Croiseur";
$mod_empire_lang["VB"] = "Vaisseau de bataille";
$mod_empire_lang["VC"] = "Vaisseau de colonisation";
$mod_empire_lang["REC"] = "Recycleur";
$mod_empire_lang["SE"] = "Sonde espionnage";
$mod_empire_lang["BMD"] = "Bombardier";
$mod_empire_lang["DST"] = "Destructeur";
$mod_empire_lang["EDLM"] = "Étoile de la mort";
$mod_empire_lang["TR"] = "Traqueur";


function mod_empire_get_ship($ship, $add=false) {
	global $user_data, $mod_empire_lang, $db;
	
	$lines = array();
	$ship = stripcslashes($ship);
	$lines = explode(chr(10), $ship);
	$OK = false;
	$get_ship = array("PT" => 0, "GT" => 0, "CLE" => 0, "CLO" => 0, "CR" => 0, "VB" => 0,
						"VC" => 0, "REC" => 0, "SE" => 0, "BMD" => 0, "DST" => 0, "EDLM" => 0, "TR" => 0);
	
	foreach ($lines as $line) {
		$arr = array();
		$line = trim($line);

		if(strpos($line, "Type de vaisseau") === 0 ) {
			$OK = true;
			continue;
		}

		if($OK && preg_match("/^([\D\s]+)\s+(\d+)/", $line, $arr)) {
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
