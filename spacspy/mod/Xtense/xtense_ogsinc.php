<?php
/**
* xtense_ogsinc.php
* @package Xtense
*  @author Naqdazar, then modified by OGSteam
*  @link http://www.ogsteam.fr
*  @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}

function plg_set_user_building($data, $planet_id=0, $planet_name, $fields=null, $coordinates, $temperature=null, $satellite=null) {
	global $db, $user_data;
	global $pub_view;
	global $num_of_galaxies, $num_of_systems;
	require_once("parameters/lang_empire.php");
	$planet_name = trim($planet_name) != "" ? trim($planet_name) : "Inconnu";
	if (!check_var($planet_name, "Galaxy")) $planet_name = "";
	$fields = intval($fields);
	$temperature = intval($temperature);
	$satellite = intval($satellite);
	$coordinates_ok = "";
	if (sizeof(explode(":", $coordinates)) == 3 || sizeof(explode(".", $coordinates)) == 3) {
		if (sizeof(explode(":", $coordinates)) == 3) @list($galaxy, $system, $row) = explode(":", $coordinates);
		if (sizeof(explode(".", $coordinates)) == 3) @list($galaxy, $system, $row) = explode(".", $coordinates);
		if (intval($galaxy) >= 1 && intval($galaxy) <= $num_of_galaxies &&  intval($system) >= 1 &&  intval($system) <= $num_of_systems &&  intval($row) >= 1 &&  intval($row) <= 15) {
			$coordinates_ok = $coordinates;
		}
	}
	
	$planet_id = intval($planet_id);
	if (($view=="planets" && ($planet_id < 1 || $planet_id > 9)) || ($view=="lunes" && ($planet_id < 10 || $planet_id > 18))) {
                SendHttpStatusCode("742");
	}
	$link_building = array($lang_building["M"] => "M", $lang_building["C"] => "C", $lang_building["D"] => "D",
	$lang_building["CES"] => "CES", $lang_building["CEF"] => "CEF",
	$lang_building["UdR"] => "UdR", $lang_building["UdN"] => "UdN", $lang_building["CSp"] => "CSp",
	$lang_building["HM"] => "HM", $lang_building["HC"] => "HC", $lang_building["HD"] => "HD",
	$lang_building["Lab"] => "Lab", $lang_building["CdC"] => "CdC", $lang_building["Silo"] => "Silo",
	$lang_building["BaLu"] => "BaLu", $lang_building["Pha"] => "Pha", $lang_building["PoSa"] => "PoSa");
	$buildings = array("M" => 0, "C" => 0,	"D" => 0,
	"CES" => 0, "CEF" => 0,
	"UdR" => 0, "UdN" => 0, "CSp" => 0,
	"HM" => 0, "HC" => 0, "HD" => 0,
	"Lab" => 0, "CdC" => 0, "Silo" => 0,
	"BaLu" => 0, "Pha" => 0, "PoSa" => 0);
	
	
	foreach ($lang_building as $build) {
	$nbuild = " next ".$build."";
	$data = str_replace($build,$nbuild,$data);
	}
	
	$lines = explode("next", $data);
	
	$OK = false;
	foreach ($lines as $line) {
		$arr = array();
		$line = trim($line);
		if (preg_match("^(.*) \(Niveau ([[:digit:]]{1,3}).*\)^", $line, $arr)) {
			list($string, $building, $level) = $arr;

			$building = trim($building);
			$level = trim(str_replace("Niveau", "", $level));

			if (isset($link_building[$building])) {
				$OK = true;
				$buildings[$link_building[$building]] = $level;
			}
		}
	}
	if ($fields!=null) {
          $insfield_name = ", `fields` ";
          $insfield_value = $fields.",";
          $updfield = ", `fields` = ".$fields;
        } else {
              $insfield_name = "";
              $insfield_value = "";
              $updfield = "";
        }
	if ($temperature!=null) {
          $instemperature_name = ", `temperature` ";
          $instemperature_value = $temperature.",";
          $updtemperature = ", `temperature` = ".$temperature;
        } else {
              $instemperature_name = "";
              $instemperature_value = "";
              $updtemperature = "";
        }
	if ($satellite!=null) {
          $inssatellite_name = ", `Sat` ";
          $inssatellite_value = $satellite.",";
          $updsatellite = ", `Sat` = ".$satellite;
        } else {
              $inssatellite_name = "";
              $inssatellite_value = "";
              $updsatellite = "";
        }
        if ($OK) {
      		$request = "delete from ".TABLE_USER_BUILDING." where user_id = ".$user_data["user_id"]." and planet_id= ".$planet_id;
      		$db->sql_query($request);
      		$request = "insert into ".TABLE_USER_BUILDING." (user_id, planet_id, planet_name, coordinates".$insfield_name.$instemperature_name.$inssatellite_name.", M, C, D, CES, CEF, UdR, UdN, CSP, HM, HC, HD, Lab, CdC, Silo, BaLu, Pha, PoSa)";
      		$request .= " values (".$user_data["user_id"].", ".$planet_id.", '".mysql_real_escape_string($planet_name)."', '".$coordinates_ok."',".$insfield_value.$instemperature_value.$inssatellite_value.$buildings["M"].", ".$buildings["C"].",".$buildings["D"].", ".$buildings["CES"].", ".$buildings["CEF"].", ".$buildings["UdR"].", ".$buildings["UdN"].", ".$buildings["CSp"].", ".$buildings["HM"].", ".$buildings["HC"].", ".$buildings["HD"].", ".$buildings["Lab"].", ".$buildings["CdC"].", ".$buildings["Silo"].", ".$buildings["BaLu"].", ".$buildings["Pha"].", ".$buildings["PoSa"].")";
                      $res=$db->sql_query($request);
      	}
      	else {
      		$request = "update ".TABLE_USER_BUILDING." set planet_name = '".mysql_real_escape_string($planet_name)."', coordinates = '".$coordinates_ok."'".$updfield.$updtemperature.$updsatellite." where user_id = ".$user_data["user_id"]." and planet_id = ".$planet_id;
      		$res=$db->sql_query($request);
      	}

        log_plugin_("user_load_buildings",$planet_name."[".$coordinates."]");
        if ($res==false) return false;
        else return true;
}

function plg_user_set_technology($data) {
	global $db, $user_data;
	require_once("parameters/lang_empire.php");
	$link_technology = array($lang_technology["Esp"] => "Esp", $lang_technology["Ordi"] => "Ordi",
	$lang_technology["Armes"] => "Armes", $lang_technology["Bouclier"] => "Bouclier", $lang_technology["Protection"] => "Protection",
	$lang_technology["NRJ"] => "NRJ",
	$lang_technology["Hyp"] => "Hyp", $lang_technology["RC"] => "RC", $lang_technology["RI"] => "RI", $lang_technology["PH"] => "PH",
	$lang_technology["Laser"] => "Laser", $lang_technology["Ions"] => "Ions", $lang_technology["Plasma"] => "Plasma",
	$lang_technology["RRI"] => "RRI", $lang_technology["Graviton"] => "Graviton");
	$technologies = array("Esp" => 0, "Ordi" => 0,
	"Armes" => 0, "Bouclier" => 0, "Protection" => 0,
	"NRJ" => 0,
	"Hyp" => 0, "RC" => 0, "RI" => 0, "PH" => 0,
	"Laser" => 0, "Ions" => 0, "Plasma" => 0,
	"RRI" => 0, "Graviton" => 0);
	$lines = explode(chr(10), $data);
	$OK = false;
	foreach ($lines as $line) {
		$arr = array();
		$line = trim($line);
		if (ereg("^(.*) \(Niveau ([[:digit:]]{1,3}).*\)$", $line, $arr)) {
			list($string, $technology, $level) = $arr;

			$technology = trim($technology);
			$level = trim(str_replace("Niveau", "", $level));

			if (isset($link_technology[$technology])) {
				$OK = true;
				$technologies[$link_technology[$technology]] = $level;
			}
		}
	}
	
	$request = "SELECT * FROM ".TABLE_USER_TECHNOLOGY." WHERE user_id='".$user_data["user_id"]."'";
	$res=$db->sql_query($request);
	$ret=$db->sql_fetch_assoc($res);
	
	if ($technologies["Esp"] < $ret["Esp"]) {
		$technologies["Esp"] = $ret["Esp"];}
	if ($technologies["Ordi"] < $ret["Ordi"]) {
		$technologies["Ordi"] = $ret["Ordi"];}
	if ($technologies["Armes"] < $ret["Armes"]) {
		$technologies["Armes"] = $ret["Armes"];}
	if ($technologies["Bouclier"] < $ret["Bouclier"]) {
		$technologies["Bouclier"] = $ret["Bouclier"];}
	if ($technologies["Protection"] < $ret["Protections"]) {
		$technologies["Protection"] = $ret["Protection"];}
	if ($technologies["NRJ"] < $ret["NRJ"]) {
		$technologies["NRJ"] = $ret["NRJ"];}
	if ($technologies["Hyp"] < $ret["Hyp"]) {
		$technologies["Hyp"] = $ret["Hyp"];}
	if ($technologies["RC"] < $ret["RC"]) {
		$technologies["RC"] = $ret["RC"];}
	if ($technologies["RI"] < $ret["RI"]) {
		$technologies["RI"] = $ret["RI"];}
	if ($technologies["PH"] < $ret["PH"]) {
		$technologies["PH"] = $ret["PH"];}
	if ($technologies["Laser"] < $ret["Laser"]) {
		$technologies["Laser"] = $ret["Laser"];}
	if ($technologies["Ions"] < $ret["Ions"]) {
		$technologies["Ions"] = $ret["Ions"];}
	if ($technologies["Plasma"] < $ret["Plasma"]) {
		$technologies["Plasma"] = $ret["Plasma"];}
	if ($technologies["RRI"] < $ret["RRI"]) {
		$technologies["RRI"] = $ret["RRI"];}
	if ($technologies["Graviton"] < $ret["Graviton"]) {
		$technologies["Graviton"] = $ret["Graviton"];}
		
	if (!$OK) {
		SendHttpStatusCode("748");
	}
	$request = "delete from ".TABLE_USER_TECHNOLOGY." where user_id = ".$user_data["user_id"];
	$db->sql_query($request);
	$request = "insert into ".TABLE_USER_TECHNOLOGY." (user_id, esp, Ordi, Armes, Bouclier, Protection, NRJ, Hyp, RC, RI, PH, Laser, Ions, Plasma, RRI, Graviton)";
	$request .= " values (".$user_data["user_id"].", ".$technologies["Esp"].", ".$technologies["Ordi"].",".$technologies["Armes"].", ".$technologies["Bouclier"].", ".$technologies["Protection"].", ".$technologies["NRJ"].", ".$technologies["Hyp"].", ".$technologies["RC"].", ".$technologies["RI"].", ".$technologies["PH"].", ".$technologies["Laser"].", ".$technologies["Ions"].", ".$technologies["Plasma"].", ".$technologies["RRI"].", ".$technologies["Graviton"].")";
	$res=$db->sql_query($request);
        if ($res==false) return false;
        else {
             log_plugin_("user_load_technos");
             return true;
        }
}

function plg_user_set_defence($data, $planet_id, $planet_name, $fields=null, $coordinates, $temperature=null, $satellite=null) {
	global $db, $user_data;
	global $pub_view;
	global $num_of_galaxies, $num_of_systems;
	require_once("parameters/lang_empire.php");
	$planet_name = trim($planet_name) != "" ? trim($planet_name) : "Inconnu";
	if (!check_var($planet_name, "Galaxy")) $planet_name = "";
	$fields = intval($fields);
	$temperature = intval($temperature);
	$satellite = intval($satellite);
	$coordinates_ok = "";
	if (sizeof(explode(":", $coordinates)) == 3 || sizeof(explode(".", $coordinates)) == 3) {
		if (sizeof(explode(":", $coordinates)) == 3) @list($galaxy, $system, $row) = explode(":", $coordinates);
		if (sizeof(explode(".", $coordinates)) == 3) @list($galaxy, $system, $row) = explode(".", $coordinates);
		if (intval($galaxy) >= 1 && intval($galaxy) <= $num_of_galaxies &&  intval($system) >= 1 &&  intval($system) <= $num_of_systems &&  intval($row) >= 1 &&  intval($row) <= 15) {
			$coordinates_ok = $coordinates;
		}
	}
	$planet_id = intval($planet_id);
		$link_defence = array($lang_defence["LM"] => "LM", $lang_defence["LLE"] => "LLE", $lang_defence["LLO"] => "LLO",
	$lang_defence["CG"] => "CG", $lang_defence["AI"] => "AI", $lang_defence["LP"] => "LP",
	$lang_defence["PB"] => "PB", $lang_defence["GB"] => "GB",
	$lang_defence["MIC"] => "MIC", $lang_defence["MIP"] => "MIP");
	$defences = array("LM" => 0, "LLE" => 0,	"LLO" => 0,
	"CG" => 0, "AI" => 0, "LP" => 0,
	"PB" => 0, "GB" => 0,
	"MIC" => 0, "MIP" => 0);
	foreach ($lang_defence as $def) {
	$nextdef = "next ".$def."";
	$data=str_replace($def,$nextdef,$data);
	}

	$data=str_replace('.','',$data);
	$lines = explode("next", $data);
	$OK = false;
	foreach ($lines as $line) {
		$arr = array();
		$line = trim($line);
 
		if (preg_match("!^(.*) \( ?([0-9]{1,11}) disponible.*\)!Usi", $line, $arr)) {
			list($string, $defence, $level) = $arr;

			$defence = trim($defence);
			$level = trim($level);

			if (isset($link_defence[$defence])) {
				$OK = true;
				$defences[$link_defence[$defence]] = $level;
			}
		}
	}

	if ($fields!=null) {
          $insfield_name = ", `fields` ";
          $insfield_value = $fields.",";
          $updfield = ", `fields` = ".$fields;
        } else {
              $insfield_name = "";
              $insfield_value = "";
              $updfield = "";
        }
	if ($temperature!=null) {
          $instemperature_name = ", `temperature` ";
          $instemperature_value = $temperature.",";
          $updtemperature = ", `temperature` = ".$temperature;
        } else {
              $instemperature_name = "";
              $instemperature_value = "";
              $updtemperature = "";
        }
	if ($satellite!=null) {
          $inssatellite_name = ", `satellite` ";
          $inssatellite_value = $satellite.",";
          $updsatellite = ", `satellite` = ".$satellite;
        } else {
              $inssatellite_name = "";
              $inssatellite_value = "";
              $updsatellite = "";
        }
	if ($OK) {
		$request = "delete from ".TABLE_USER_DEFENCE." where user_id = ".$user_data["user_id"]." and planet_id= ".$planet_id;
		$db->sql_query($request);

		$request = "insert into ".TABLE_USER_DEFENCE." (user_id, planet_id, LM, LLE, LLO, CG, AI, LP, PB, GB, MIC, MIP)";
		$request .= " values (".$user_data["user_id"].", ".$planet_id.", ".$defences["LM"].", ".$defences["LLE"].",".$defences["LLO"].", ".$defences["CG"].", ".$defences["AI"].", ".$defences["LP"].", ".$defences["PB"].", ".$defences["GB"].", ".$defences["MIC"].", ".$defences["MIP"].")";
		$res=$db->sql_query($request);
		if ($res==false) return false;
	}
	else {
		if (isset($fields) && isset($temperature) && isset($satellite)) {
                   $request = "update ".TABLE_USER_BUILDING." set planet_name = '".mysql_real_escape_string($planet_name)."', coordinates = '".$coordinates_ok."', `fields` = ".$fields.", temperature = ".$temperature.", Sat = ".$satellite." where user_id = ".$user_data["user_id"]." and planet_id = ".$planet_id;
		   $res=$db->sql_query($request);
		}
	}
        if ($res==false) return false;
        else {
             log_plugin_("user_load_defense",$planet_name."[".$coordinates."]" );
	     return true;
            }
}
function plg_user_set_all_empire($data, $pub_view) {
	global $db, $user_data;
	require_once("parameters/lang_empire.php");
	$data = str_replace ( "-", "0", $data );
	$data = str_replace ( ".", "", $data );
	$data = stripcslashes($data);
	$lines = explode(chr(10), $data);
	$OK = false;
	$etape = "";
	$planetes_total_row = false;
	$planetnames = array(9);
  foreach ($lines as $line) {
		$arr = array();
		$line = trim($line);

		if($line == "Vue d'ensemble de votre empire") {
			$OK = true;
			continue;
		}
		if($OK) {

      if (!(strpos($line,'Nom') ===false))
      if (preg_match("#^Nom\s{1,2}\t([a-z,A-Z,0-9]*.?)?\s{1,2}\t([a-z,A-Z,0-9]*.?)?\s{1,2}\t([a-z,A-Z,0-9]*.?)?\s{1,2}\t([a-z,A-Z,0-9]*.?)?\s{1,2}\t([a-z,A-Z,0-9]*.?)?\s{1,2}\t([a-z,A-Z,0-9]*.?)?\s{1,2}\t([a-z,A-Z,0-9]*.?)?\s{1,2}\t([a-z,A-Z,0-9]*.?)?\s{1,2}\t([a-z,A-Z,0-9]*.?)?$#", $line, $planetnames)) {
			}


			if (preg_match("#^Coordonnées\s+\[(.*)\]$#", $line, $arr)) {
				$coordonnees = preg_split("/\]\s+\[/", $arr[1]);
				$planetes_total_row = sizeof($coordonnees);
				if($planetes_total_row > 9) return false;

				$link_building = array($lang_building["M"] => "M", $lang_building["C"] => "C", $lang_building["D"] => "D",
				$lang_building["CES"] => "CES", $lang_building["CEF"] => "CEF",
				$lang_building["UdR"] => "UdR", $lang_building["UdN"] => "UdN", $lang_building["CSp"] => "CSp",
				$lang_building["HM"] => "HM", $lang_building["HC"] => "HC", $lang_building["HD"] => "HD",
				$lang_building["Lab"] => "Lab", $lang_building["CdC"] => "CdC", $lang_building["Silo"] => "Silo",
				$lang_building["BaLu"] => "BaLu", $lang_building["Pha"] => "Pha", $lang_building["PoSa"] => "PoSa");

				$buildings = array("M" => array_fill(0, $planetes_total_row, 0), "C" => array_fill(0, $planetes_total_row, 0),	"D" => array_fill(0, $planetes_total_row, 0),
				"CES" => array_fill(0, $planetes_total_row, 0), "CEF" => array_fill(0, $planetes_total_row, 0),
				"UdR" => array_fill(0, $planetes_total_row, 0), "UdN" => array_fill(0, $planetes_total_row, 0), "CSp" => array_fill(0, $planetes_total_row, 0),
				"HM" => array_fill(0, $planetes_total_row, 0), "HC" => array_fill(0, $planetes_total_row, 0), "HD" => array_fill(0, $planetes_total_row, 0),
				"Lab" => array_fill(0, $planetes_total_row, 0), "Ter" => array_fill(0, $planetes_total_row, 0), "Silo" => array_fill(0, $planetes_total_row, 0),
				"BaLu" => array_fill(0, $planetes_total_row, 0), "Pha" => array_fill(0, $planetes_total_row, 0), "PoSa" => array_fill(0, $planetes_total_row, 0));

				$link_defence = array($lang_defence["LM"] => "LM", $lang_defence["LLE"] => "LLE", $lang_defence["LLO"] => "LLO",
				$lang_defence["CG"] => "CG", $lang_defence["AI"] => "AI", $lang_defence["LP"] => "LP",
				$lang_defence["PB"] => "PB", $lang_defence["GB"] => "GB",
				$lang_defence["MIC"] => "MIC", $lang_defence["MIP"] => "MIP");

				$defences = array("LM" => array_fill(0, $planetes_total_row, 0), "LLE" => array_fill(0, $planetes_total_row, 0),	"LLO" => array_fill(0, $planetes_total_row, 0),
				"CG" => array_fill(0, $planetes_total_row, 0), "AI" => array_fill(0, $planetes_total_row, 0), "LP" => array_fill(0, $planetes_total_row, 0),
				"PB" => array_fill(0, $planetes_total_row, 0), "GB" => array_fill(0, $planetes_total_row, 0),
				"MIC" => array_fill(0, $planetes_total_row, 0), "MIP" => array_fill(0, $planetes_total_row, 0));

				$link_technology = array($lang_technology["Esp"] => "Esp", $lang_technology["Ordi"] => "Ordi",
				$lang_technology["Armes"] => "Armes", $lang_technology["Bouclier"] => "Bouclier", $lang_technology["Protection"] => "Protection",
				$lang_technology["NRJ"] => "NRJ",
				$lang_technology["Hyp"] => "Hyp", $lang_technology["RC"] => "RC", $lang_technology["RI"] => "RI", $lang_technology["PH"] => "PH",
				$lang_technology["Laser"] => "Laser", $lang_technology["Ions"] => "Ions", $lang_technology["Plasma"] => "Plasma",
				$lang_technology["RRI"] => "RRI", $lang_technology["Graviton"] => "Graviton");

				$technologies = array("Esp" => 0, "Ordi" => 0, "Armes" => 0, "Bouclier" => 0, "Protection" => 0,
				"NRJ" => 0, "Hyp" => 0, "RC" => 0, "RI" => 0, "PH" => 0, "Laser" => 0, "Ions" => 0, "Plasma" => 0,
				"RRI" => 0, "Graviton" => 0);

				$satellites = array_fill(0, $planetes_total_row, 0);
				$cases = array_fill(0, $planetes_total_row, 0);

				$masq = "#^((?:\s?\S+)+)\s+";
				for($i=0; $i<($planetes_total_row-1); $i++) {
					$masq .= "(\d+)(?:|\s\d+|\s\(\d+\))*\s+";
				}
				$masq .= "(\d+)(?:\s\d+|\s\(\d+\))*$#";

				continue;
			}

			if($OK && $planetes_total_row !==false) {

				if(preg_match("#^Cases\s+\d+\/((?:\d+\s+(?:\d+)\/(?:\d+)\s*){1,".$planetes_total_row."})$#",$line,$arr)) {
					$cases = preg_split("/\s+\d+\//", $arr[1]);
					if(sizeof($cases) != $planetes_total_row) return false;
					continue;
				}

				if(preg_match("#^(".$lang_empire["Batiment"]."|".$lang_empire["Recherche"]."|".$lang_empire["Vaisseaux"]."|".$lang_empire["Défense"].")$#",$line)) {
					$etape = $line;
					continue;
				}

				if($etape != "" && preg_match($masq, $line, $arr)) {

					$building = $arr[1];
					$levels = array_slice($arr, 2);
					switch($etape) {
						case "Bâtiments" :
						if (isset($link_building[$building])) {
							if( sizeof($levels) != $planetes_total_row) return false;
							$buildings[$link_building[$building]] = $levels;
						}
						break;
						case "Recherche" :
						if (isset($link_technology[$building])) {
							if( sizeof($levels) != $planetes_total_row) return false;
							$technologies[$link_technology[$building]] = max($levels);
						}
						break;
						case "Vaisseaux" :
						if ($building == "Satellite solaire") {
							if( sizeof($levels) != $planetes_total_row) return false;
							$satellites = $levels;
						}
						break;
						case "Défense" :
						if (isset($link_defence[$building])) {
							if( sizeof($levels) != $planetes_total_row) return false;
							$defences[$link_defence[$building]] = $levels;
						}
						break;
						default :
						    return false;
					}
					continue;
				}

			}
		}
	}
	if($OK && $planetes_total_row !== false) {
		$j=19;
		for($i=0; $i<$planetes_total_row; $i++) {
			if($pub_view == "moons") {
				$request = "select planet_id from ".TABLE_USER_BUILDING." where coordinates = '".$coordonnees[$i]."' and planet_id > 9";
				$result = $db->sql_query($request);
				if ($db->sql_numrows($result) > 0) {
					list($planete_id) = $db->sql_fetch_row($result);
				}
				else {
					$request = "select planet_id from ".TABLE_USER_BUILDING." where user_id = ".$user_data["user_id"]." and coordinates = '".$coordonnees[$i]."'";
					$result = $db->sql_query($request);
					list($planete_id) = $db->sql_fetch_row($result);
					if(!$planete_id) {
						$planete_id = $j;
						$j++;
					}
					else $planete_id += 9;
				}
			}
			else $planete_id = $i+1;

			if($pub_view == "planets") $case = $cases[$i]-5*$buildings["Ter"][$i];
			else $case = 1;
			$planetname = $planetnames[$i+1];

			$request = "update ".TABLE_USER_BUILDING." set coordinates = '".$coordonnees[$i]."', `fields` = ".$case." , Sat = ".$satellites[$i];
			$request .= ", M = ".$buildings["M"][$i].", C = ".$buildings["C"][$i].", D = ".$buildings["D"][$i];
			$request .= ", CES = ".$buildings["CES"][$i].", CEF = ".$buildings["CEF"][$i].", UdR = ".$buildings["UdR"][$i];
			$request .= ", UdN = ".$buildings["UdN"][$i].", CSp = ".$buildings["CSp"][$i].", HM = ".$buildings["HM"][$i];
			$request .= ", HC = ".$buildings["HC"][$i].", HD = ".$buildings["HD"][$i].", Lab = ".$buildings["Lab"][$i];
			$request .= ", Ter = ".$buildings["Ter"][$i].", Silo = ".$buildings["Silo"][$i].", BaLu = ".$buildings["BaLu"][$i];
			$request .= ", Pha = ".$buildings["Pha"][$i].", PoSa = ".$buildings["PoSa"][$i].($pub_view == 'moons' ? ', planet_name = \'Lune\'' : ', planet_name = \''.$planetname.'\'');
			$request .= " where user_id = ".$user_data["user_id"]." and planet_id = ".$planete_id;
			$db->sql_query($request);

      if ($db->sql_affectedrows() == 0) {
				$request = "insert ignore into ".TABLE_USER_BUILDING." (user_id, planet_id, planet_name, coordinates, `fields`, temperature, Sat, M, C, D, CES, CEF, UdR, UdN, CSp, HM, HC, HD, Lab, Ter, Silo, BaLu, Pha, PoSa)";
				$request .= " values (".$user_data["user_id"].", ".$planete_id.", '".($pub_view == 'moons' ? 'Lune' : $planetname)."', '".$coordonnees[$i]."', ".$case.", 0, ".$satellites[$i];
				$request .= ", ".$buildings["M"][$i].", ".$buildings["C"][$i].", ".$buildings["D"][$i];
				$request .= ", ".$buildings["CES"][$i].", ".$buildings["CEF"][$i].", ".$buildings["UdR"][$i];
				$request .= ", ".$buildings["UdN"][$i].", ".$buildings["CSp"][$i].", ".$buildings["HM"][$i];
				$request .= ", ".$buildings["HC"][$i].", ".$buildings["HD"][$i].", ".$buildings["Lab"][$i];
				$request .= ", ".$buildings["Ter"][$i].", ".$buildings["Silo"][$i].", ".$buildings["BaLu"][$i];
				$request .= ", ".$buildings["Pha"][$i].", ".$buildings["PoSa"][$i].")";
				$db->sql_query($request);
			}
			$request = "delete from ".TABLE_USER_DEFENCE." where user_id = ".$user_data["user_id"]." and planet_id= ".$planete_id;
			$db->sql_query($request);

			$request = "insert into ".TABLE_USER_DEFENCE." (user_id, planet_id, LM, LLE, LLO, CG, AI, LP, PB, GB, MIC, MIP)";
			$request .= " values (".$user_data["user_id"].", ".$planete_id.", ".$defences["LM"][$i].", ".$defences["LLE"][$i].",".$defences["LLO"][$i].", ".$defences["CG"][$i].", ".$defences["AI"][$i].", ".$defences["LP"][$i].", ".$defences["PB"][$i].", ".$defences["GB"][$i].", ".$defences["MIC"][$i].", ".$defences["MIP"][$i].")";
			$db->sql_query($request);
		}
		if($pub_view=="planets") {
			$request = "delete from ".TABLE_USER_TECHNOLOGY." where user_id = ".$user_data["user_id"];
			$db->sql_query($request);
			$request = "insert into ".TABLE_USER_TECHNOLOGY." (user_id, esp, Ordi, Armes, Bouclier, Protection, NRJ, Hyp, RC, RI, PH, Laser, Ions, Plasma, RRI, Graviton)";
			$request .= " values (".$user_data["user_id"].", ".$technologies["Esp"].", ".$technologies["Ordi"].",".$technologies["Armes"].", ".$technologies["Bouclier"].", ".$technologies["Protection"].", ".$technologies["NRJ"].", ".$technologies["Hyp"].", ".$technologies["RC"].", ".$technologies["RI"].", ".$technologies["PH"].", ".$technologies["Laser"].", ".$technologies["Ions"].", ".$technologies["Plasma"].", ".$technologies["RRI"].", ".$technologies["Graviton"].");";
			$db->sql_query($request);
		}

		user_set_all_empire_resync();
		return true;
	}
	return false;
}





?>
