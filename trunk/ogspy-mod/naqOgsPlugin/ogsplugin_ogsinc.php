<?php

// fonctions extraites des sources OGSPY par OGS Team (Kyser)
// "ne réinventons pas le fil à couper le beurre!"
// code en license GNU GPL

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

define("PLANETNAMECHARS", '\w,\d,\s,\!,\?,\-,_,é,è,à', true);



function plg_set_user_building($data, $planet_id=0, $planet_name, $fields=null, $coordinates, $temperature=null, $satellite=null) {
	global $db, $user_data;
	global $pub_view;
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
		if (intval($galaxy) >= 1 && intval($galaxy) <= 9 &&  intval($system) >= 1 &&  intval($system) <= 499 &&  intval($row) >= 1 &&  intval($row) <= 15) {
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
	$lang_building["Lab"] => "Lab", $lang_building["Ter"] => "Ter", $lang_building["Silo"] => "Silo",
	$lang_building["BaLu"] => "BaLu", $lang_building["Pha"] => "Pha", $lang_building["PoSa"] => "PoSa");
	$buildings = array("M" => 0, "C" => 0,	"D" => 0,
	"CES" => 0, "CEF" => 0,
	"UdR" => 0, "UdN" => 0, "CSp" => 0,
	"HM" => 0, "HC" => 0, "HD" => 0,
	"Lab" => 0, "Ter" => 0, "Silo" => 0,
	"BaLu" => 0, "Pha" => 0, "PoSa" => 0);
	$lines = explode(chr(10), $data);
	$OK = false;
	foreach ($lines as $line) {
		$arr = array();
		$line = trim($line);
		if (ereg("^(.*) \(Niveau ([[:digit:]]{1,3}).*\)$", $line, $arr)) {
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
      		$request = "insert into ".TABLE_USER_BUILDING." (user_id, planet_id, planet_name, coordinates".$insfield_name.$instemperature_name.$inssatellite_name.", M, C, D, CES, CEF, UdR, UdN, CSP, HM, HC, HD, Lab, Ter, Silo, BaLu, Pha, PoSa)";
      		$request .= " values (".$user_data["user_id"].", ".$planet_id.", '".mysql_real_escape_string($planet_name)."', '".$coordinates_ok."',".$insfield_value.$instemperature_value.$inssatellite_value.$buildings["M"].", ".$buildings["C"].",".$buildings["D"].", ".$buildings["CES"].", ".$buildings["CEF"].", ".$buildings["UdR"].", ".$buildings["UdN"].", ".$buildings["CSp"].", ".$buildings["HM"].", ".$buildings["HC"].", ".$buildings["HD"].", ".$buildings["Lab"].", ".$buildings["Ter"].", ".$buildings["Silo"].", ".$buildings["BaLu"].", ".$buildings["Pha"].", ".$buildings["PoSa"].")";
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
		if (intval($galaxy) >= 1 && intval($galaxy) <= 9 &&  intval($system) >= 1 &&  intval($system) <= 499 &&  intval($row) >= 1 &&  intval($row) <= 15) {
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
	$lines = explode(chr(10), $data);
	$OK = false;
	foreach ($lines as $line) {
		$arr = array();
		$line = trim($line);

		if (ereg("^(.*) \( ([[:digit:]]{1,5}) disponible\(s\).*\)$", $line, $arr)) {
			list($string, $defence, $level) = $arr;

			$defence = trim($defence);
			$level = trim(str_replace("disponible(s)", "", $level));

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
	global $db, $user_data, $fp;
	require_once("parameters/lang_empire.php");
	$data = str_replace ( "-", "0", $data );
	$data = str_replace ( ".", "", $data );
	$data = stripcslashes($data);
	$lines = explode(chr(10), $data);
	$OK = false;
	$etape = "";
	//$nbcase=1;
	$planetes_total_row = false;
	$planetnames = array(9);

$request = "delete from ".TABLE_USER_BUILDING." where  planet_id < 0"; // modif  ( Syrus ) Supprime planète Id < 0
				$result = $db->sql_query($request);    // modif  ( Syrus )
$request = "delete from ".TABLE_USER_DEFENCE." where  planet_id < 0";  // modif  ( Syrus )
				$result = $db->sql_query($request);    // modif  ( Syrus )


  foreach ($lines as $line) {
		$arr = array();
		$arrr =array();
		$line = trim($line);

		if($line == "Vue d'ensemble de votre empire") {
			$OK = true;
			continue;
		}
		if($OK) {
					
      if (!(strpos($line,'Nom') ===false))
      if (preg_match("#Nom(?:\s{0,2}\t)(\S[\w,\d,è,\s]+\S)#", $line, $planetnames_line)) {
       
         $planetnames = preg_split("/\s{0,2}\t/", $line /*$planetnames_line[1] */); 
	 if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"==> Motif 'Noms' de planète trouvé : ".count($planetnames)." noms\n_ \n");
          if (defined("OGS_PLUGIN_DEBUG"))  foreach($planetnames as $line_tab) fwrite($fp, $line_tab."/");
          if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"\n");
      }
		$line = str_replace("\xA0","\x20",$line);  	// modif pour version 0.78 ( Syrus )
		//$line = str_replace("\x09","",$line);		// modif pour version 0.78 ( Syrus )	
		$line = str_replace("  ",'',$line);		// modif pour version 0.78 ( Syrus )
		if (!(strpos($line,'Coordonnées') ===false)) fwrite($fp,"COORD : $line:");
			if (preg_match("#^Coordonnées\s+\[(.*)\]$#", $line, $arr)) {
				
				
				$coordonnees = preg_split("/\]\s+\[/", $arr[1]);
				$planetes_total_row = sizeof($coordonnees);
				if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Nombre de plantètes :$planetes_total_row \n");
				if($planetes_total_row > 9) return false;	

				$link_building = array($lang_building["M"] => "M", $lang_building["C"] => "C", $lang_building["D"] => "D",
				$lang_building["CES"] => "CES", $lang_building["CEF"] => "CEF",
				$lang_building["UdR"] => "UdR", $lang_building["UdN"] => "UdN", $lang_building["CSp"] => "CSp",
				$lang_building["HM"] => "HM", $lang_building["HC"] => "HC", $lang_building["HD"] => "HD",
				$lang_building["Lab"] => "Lab", $lang_building["Ter"] => "Ter", $lang_building["Silo"] => "Silo",
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

				
				//$masq2 = "#^((?:\s?\S+)+)\s+";
				//for($i=0; $i<($planetes_total_row); $i++) {
				//	$masq2 .= "(\t\d+)*\s+";
				//}
				//$masq2 .= "(\t\d+)*\s#";
				// $masq2 = "#^((?:\s?\S+)+)\s|(\t\d+)#";
				//masque pour virer les mine en cours
				

				$masq = "#^((?:\s?\S+)+)\s+";
				for($i=0; $i<($planetes_total_row); $i++) {
					$masq .= "(\d+)(?:|\s\d+|\s\(\d+\))*\s+";
				}
				$masq .= "(\d+)(?:\s\d+|\s\(\d+\))*$#";
				
				
				continue;
			}

			
				//preg_match($masq2, $line, $arr);
				//$line=$arr[1];
				

				
			if($OK && $planetes_total_row !==false) {
				
				// Retouche Syrus pour le calcul des cases  0.78 
				if (!(strpos($line,'Cases') ===false)) {
				 
					$arr[1]= str_replace("Cases","", $line);
					$cases = preg_split("/\s+\d+\//", $arr[1]);

					if(sizeof($cases) != $planetes_total_row+1) return false;
					continue;
				}

				
			if(preg_match("#^(".$lang_empire["Batiment"]."|".$lang_empire["Recherche"]."|".$lang_empire["Vaisseaux"]."|".$lang_empire["Défense"].")$#",$line)) {
					$etape = $line;
					continue;

				}
                  if (!(strpos($line,'Satellite solaire') ===false)) {  //Mise à jour Sat case fonctionne plus (syrus )
				
				$arr[1]= str_replace("Satellite solaire","", $line);
					$satellites  = explode(" ",$arr[1]);
		 }

 if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"\n");
				if($etape != "" && preg_match($masq, $line, $arr)) {
 				 if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Masque OK\n");
					$building = $arr[1];
					 if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Masque $building\n");
					$ar =preg_replace('/\x20\d+/','',$line);
					fwrite($fp,"Masque2 fin: $line / $ar / $arrr[0] / $arrr[1] \n\r");
					//preg_match($masq, $arrr[1], $arr);
					$levels = array_slice($arr, 2);
					
					switch($etape) {
						case "Bâtiments" :
						if (isset($link_building[$building])) {
							// modif pour version 0.78 ( Syrus ) rajout -1
							if( sizeof($levels)-1 != $planetes_total_row) return false;
							$buildings[$link_building[$building]] = $levels;
						}
						break;
						case "Recherche" :
						if (isset($link_technology[$building])) {
							// modif pour version 0.78 ( Syrus ) ajout -1
							if( sizeof($levels)-1 != $planetes_total_row) return false;
							//$levels = str_replace(max($levels),"",$levels);
							//$technologies[$link_technology[$building]] = max($levels);
							$technologies[$link_technology[$building]] = max($levels);
						}
						break;
						case "Vaisseaux" :
						
						if ($building == "  Satellite solaire") {
							// modif pour version 0.78 ( Syrus ) rajout -1
							if( sizeof($levels)-1 != $planetes_total_row) return false;
							$satellites = $levels;
							
						}
						break;
						case "Défense" :
						if (isset($link_defence[$building])) {
							// modif pour version 0.78 ( Syrus ) rajout -1
							if( sizeof($levels)-1 != $planetes_total_row) return false;
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

			if($pub_view == "planets") { $case = $cases[$i+1]-5*$buildings["Ter"][$i]; // Syrus +1 --> colonne somme
			}
			 else $case = 1;
			 
			
			$planetname = $planetnames[$i+1];
			
			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Insertion de la planète: $planetname $coordonnees[$i] \n");
			
			$request = "update ".TABLE_USER_BUILDING." set planet_name = '".mysql_escape_string($planetname)."', coordinates = '".mysql_escape_string($coordonnees[$i])."', `fields` = ".$case." , Sat = ".$satellites[$i+1];
			$request .= ", M = ".$buildings["M"][$i].", C = ".$buildings["C"][$i].", D = ".$buildings["D"][$i];
			$request .= ", CES = ".$buildings["CES"][$i].", CEF = ".$buildings["CEF"][$i].", UdR = ".$buildings["UdR"][$i];
			$request .= ", UdN = ".$buildings["UdN"][$i].", CSp = ".$buildings["CSp"][$i].", HM = ".$buildings["HM"][$i];
			$request .= ", HC = ".$buildings["HC"][$i].", HD = ".$buildings["HD"][$i].", Lab = ".$buildings["Lab"][$i];
			$request .= ", Ter = ".$buildings["Ter"][$i].", Silo = ".$buildings["Silo"][$i].", BaLu = ".$buildings["BaLu"][$i];
			$request .= ", Pha = ".$buildings["Pha"][$i].", PoSa = ".$buildings["PoSa"][$i];
			$request .= " where user_id = ".$user_data["user_id"]." and planet_id = ".$planete_id;
			$db->sql_query($request);

      if ($db->sql_affectedrows() == 0) {
				$request = "insert ignore into ".TABLE_USER_BUILDING." (user_id, planet_id, planet_name, coordinates, `fields`, temperature, Sat, M, C, D, CES, CEF, UdR, UdN, CSp, HM, HC, HD, Lab, Ter, Silo, BaLu, Pha, PoSa)";
				$request .= " values (".$user_data["user_id"].", ".$planete_id.", '".mysql_escape_string($planetname)."', '".$coordonnees[$i]."', ".$case.", 0, ".$satellites[$i+1];
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

/**
 *  Retourne le numéro du mois de l'année à partir de son abreviation anglaise
 **/
function MonthTagToNum($parTag) {

        if (trim($parTag)=='Jan') return 1;
        if (trim($parTag)=='Feb') return 2;
        if (trim($parTag)=='Mar') return 3;
        if (trim($parTag)=='Apr') return 4;
        if (trim($parTag)=='May') return 5;
        if (trim($parTag)=='Jun') return 6;
        if (trim($parTag)=='Jul') return 7;
        if (trim($parTag)=='Aug') return 8;
        if (trim($parTag)=='Sep') return 9;
        if (trim($parTag)=='Oct') return 10;
        if (trim($parTag)=='Nov') return 11;
        if (trim($parTag)=='Dec') return 12;
        else return 0;
}

/**
 * vérification et ajout d'un rapport d'espionnage en brut dans la base de données
 **/
function plg_user_galaxy_spy($data) {
global $fp, $server_config;

  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"################### plg_user_galaxy_spy ###################################\n");


	// test existence champ moon dans table universe : si non -> unispy
	$testcolmoon = OGSPlugin_DoDBColumnExists(TABLE_UNIVERSE, 'moon');

  if ($testcolmoon ) {
      // Correctif préventif pour E-Univers -> Affichage correcte dans le popup rapport de la page galaxie
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"plg_user_galaxy_spy(ogspy): Remplacement de 'Batiments' par 'Bâtiments'\n");
      $data = str_replace("Batiments", "Bâtiments", $data);
  } else if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"plg_user_galaxy_spy: Unispy! testcolmoon: ".(int)$testcolmoon." \n");

  // si paramètre n'est pas un tableau, on splite la chaîne
  if (sizeof($data)==1)
     $lines = explode(chr(10), $data);
  else $lines = $data;

  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"=>plg_user_galaxy_spy(".sizeof($lines)." lignes):\n $lines \n");
	
	$nb_spy_added = $nb_spy_notadded = $nb_spy_existing = $phalanx = $gate = 0;
	$spy_added = array("spy_added" => 0, "spy_notadded" => 0, "spy_existing" => 0);
	for ($i=0 ; $i<sizeof($lines) ; $i++) {
		$line = trim(stripslashes($lines[$i])); // trim ajouté pour le module RE Finder


		if (preg_match("/Matières premières sur/", $line)) {
    			$phalanx = $gate = 0;
    			$header = str_replace("Matières premières sur ", "", $line);

    			// Capture regexp - détection rapport e-univers
    			if (preg_match('/Titane/i', $data)) {
              
     
              if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Rapports E-Univers détecté! \n");
        			if (preg_match("/Matières\spremières\ssur\s(\S[".PLANETNAMECHARS."]+\S)\s\[(\d+)\:(\d+)\:(\d+)\]\sle\s\w+\s(\d+)\s(\w+)\s(\d+)\:(\d+)\:(\d+)/i", $line, $eunivers_header_tab)) {

                  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Capture header E-Univers ok: ".$eunivers_header_tab[6]."->".MonthTagToNum($eunivers_header_tab[6])."\n$line\n");

                  $planet = $eunivers_header_tab[1];
                  $galaxy = (int)$eunivers_header_tab[2];
                  $system = (int)$eunivers_header_tab[3];
                  $row = (int)$eunivers_header_tab[4];
                  
                  $day = (int)$eunivers_header_tab[5];
                  $month = (int)MonthTagToNum($eunivers_header_tab[6]);

                  $hour = (int)$eunivers_header_tab[7];
                  $minute = (int)$eunivers_header_tab[8];
                  $seconde= (int)$eunivers_header_tab[9];


        			} else if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Capture header E-Univers échouée: \n$line\n");



			} else {
			
			
    			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Line $line\n");
    			//--------------------------------------------------------------------------

				list($coordinates, $time) = explode("]", $header);
				$time = trim(stripslashes($lines[$i+1]));
				if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Coordonnées planètes $coordinates, temps:  $time\n");
				if (is_null($coordinates) || is_null($time)) {
				break;
				}
				//$time = trim($time);
				//$time = str_replace("le ", "", $time);
					$time = str_replace("le ", "", $time);

    			list($planet, $coordinates) = explode("[", $coordinates);
    			if (is_null($coordinates) || is_null($time)) {
    				break;
    			}
    			$planet = trim($planet);

    			list($galaxy, $system, $row) = explode(":", $coordinates);
    			if (intval($galaxy) < 1 || intval($galaxy) > 9 || intval($system) < 1 || intval($system) > 499 || intval($row) < 1 || intval($row) > 15) {
    				break;
    			}

    			list($day, $hour) = explode(" ", $time);
    			if (is_null($day) || is_null($hour)) {
    				break;
    			}

    			list($month, $day) = explode("-", $day);
    			if (intval($month) < 1 || intval($month) > 12 || intval($day) < 1 || intval($day) > 31) {
    				break;
    			}
    			if (!checkdate($month, $day, date("Y"))) {
    				break;
    			}

    			list($hour, $minute, $seconde) = explode(":", $hour);
    			if (intval($hour) < 0 || intval($hour) > 23 || intval($minute) < 0 || intval($minute) > 59 || intval($seconde) < 0 || intval($seconde) > 59) {
    				break;
    			}
			} // fin bloc Ogame
			$timestamp = mktime($hour, $minute, $seconde, $month, $day);
			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp," Génération de l'heure\n");
			$report = "";
		} // else if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"plg_user_galaxy_spy entete pas trouvé! ".sizeof($lines)." lignes \n");

		if (preg_match("#Phalange de capteur+\s(\d)#", $line, $arr)) {
			$phalanx = $arr[1];
		}
		if (preg_match("#Porte de saut spatial+\s(\d)#", $line, $arr)) {
			$gate = 1;
		} 

		if (isset($report)) {
			$checking = false;
			$report .= chr(10).$line;
			if (preg_match("/Probabilité\sde\sdestruction\sde\sla\sflotte\s(?:d')?espionnage/", $line)) {
				//Vérification de la validité des données
				if (!check_var($galaxy, "Num") || !check_var($system, "Num") || !check_var($row, "Num") || !check_var($planet, "Galaxy") ||
				!check_var($timestamp, "Num") || !check_var($phalanx, "Num") || !check_var($report, "Spyreport")) {
					// format rapport incorrecte!!!
				}

				$coordinates = $galaxy.":".$system.":".$row;
				
       //if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"plg_user_galaxy_spy coordinates: $coordinates \n");
				if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"=> Appel plg_user_galaxy_add_spy\n");
        $result_add_spy = plg_user_galaxy_add_spy($galaxy, $system, $row, $planet, $timestamp, trim($report), $phalanx, $gate);

        if ($result_add_spy == 1) {
					//$spy_tabresult[] = ; // array(1, $coordinates, $timestamp);
					$nb_spy_added++;
				} else if ($result_add_spy == 0) {
					//$spy_tabresult[] = ; // array(0, $coordinates, $timestamp);
					$nb_spy_existing++;
					
				} else if ($result_add_spy == -1) {
          
          $nb_spy_notadded++;
				}
				$phalanx = $gate = 0;
				unset($report);
			}
    } 
	}

  // Mise à jour des stats sur les ajouts de rapports
  if ($nb_spy_added > 0 ) user_set_stat(null, null, null, null, $nb_spy_added);
	
  $spy_tabresult["spy_added"] = $nb_spy_added;
  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"spy_added: ".$spy_tabresult['spy_added']." \n"); // ligne débug , commentaire si pas utile

  $spy_tabresult["spy_notadded"] = $nb_spy_notadded;
  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"spy_notadded: ".$spy_tabresult['spy_notadded']." \n"); // ligne débug , commentaire si pas utile
  
  $spy_tabresult["spy_existing"] = $nb_spy_existing;
  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"spy_existing: ".$spy_tabresult['spy_existing']." \n"); // ligne débug , commentaire si pas utile

  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"################### FIN plg_user_galaxy_spy ###################################\n");
  
	return $spy_tabresult; //$spy_added;

}

//Ajout de rapport d'espionnage
// Fonction OGSPY modifié pour indiquer si rapport inséré, pas inséré ou déjà existant( sql == 1062)
function plg_user_galaxy_add_spy($galaxy, $system, $row, $planet, $timestamp, $report, $phalanx, $gate) {
	global $db, $user_data, $server_config;
	
	if (defined("OGS_PLUGIN_DEBUG")) global $fp;

	$spy_added = array();
	$request = "insert into ".TABLE_SPY." (spy_galaxy, spy_system, spy_row, sender_id, datadate, rawdata)".
	" values ('$galaxy', '$system', '$row', ".$user_data["user_id"].", '$timestamp', '".mysql_real_escape_string($report)."')";

  $result_insertspy = $db->sql_query($request, false);
  $res_sql_error = $db->sql_error(); // fonction de la classe

	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"=> résultat insertion rapport: ".$res_sql_error["code"]."->".$res_sql_error["message"]."\n");
  if (defined("OGS_PLUGIN_DEBUG") && $res_sql_error["code"]==0) fwrite($fp,"Une erreur est survenue en récupérant le numéro d'erreur SQL!\n");

  if ($res_sql_error["code"]==1062) return 0;

	if ($result_insertspy) {
		$request = "select spy_id from ".TABLE_SPY;
		$request .= " where active = '1'";
		$request .= " and spy_galaxy = '".$galaxy."'";
		$request .= " and spy_system = '".$system."'";
		$request .= " and spy_row = '".$row."'";
		$request .= " order by datadate";
		$result = $db->sql_query($request);
		

		
		if ($db->sql_numrows($result) > $server_config["max_spyreport"]) {
			$nb = $db->sql_numrows($result) ;
			while ($nb > $server_config["max_spyreport"]) {
				list($spy_id) = $db->sql_fetch_row($result);
				$request = "update ".TABLE_SPY." set active = '0' where spy_id = ".$spy_id;
				$db->sql_query($request);
				$nb--;
			}
		}

		$spy_added[] = "galaxy=$galaxy&system=$system&row=$row";

		$moon = false;
		/* partie ci-dessous commentée suite à possibilité de renommer lune */
		if ( /* strcasecmp($planet, "lune") == 0 && */ !preg_match("#Mine#", $report) && !preg_match("#deutérium#", $report)) {
			$moon = true;
		}

    // test existence champ last_update_moon dans table universe : si non -> unispy
	  $testcol_lastupdatemoon = OGSPlugin_DoDBColumnExists(TABLE_UNIVERSE, 'last_update_moon');
	  
	  

		$request = "select last_update".($testcol_lastupdatemoon ? ", last_update_moon":"")." from ".TABLE_UNIVERSE." where galaxy = $galaxy and system = $system and row = $row";
		$result = $db->sql_query($request);
		if ($testcol_lastupdatemoon) list($last_update, $last_update_moon) = $db->sql_fetch_row($result);
		else list($last_update) = $db->sql_fetch_row($result);

		if ($timestamp > $last_update) {
			/*//Incompatible MySQL 4.0
			$request = "insert into ".TABLE_UNIVERSE." (galaxy, system, row, name, last_update, last_update_user_id)".
			" values ('".$galaxy."', ".$system.", '".$row."', '".$planet."', ".$timestamp.", ".$user_data["user_id"].")".
			" on duplicate key update name = '".$planet."', last_update = '".$timestamp."', last_update_user_id = ".$user_data["user_id"];*/

			$request = "update ".TABLE_UNIVERSE." set last_update = '".$timestamp."', last_update_user_id = ".$user_data["user_id"];
			if (!$moon) $request .= ", name = '".mysql_real_escape_string($planet)."'";
			$request .= " where galaxy = '".$galaxy."' and system = ".$system." and row = '".$row."'";
			$db->sql_query($request);

			if ($db->sql_affectedrows() == 0) {
				$request = "insert ignore into ".TABLE_UNIVERSE." (galaxy, system, row, name, last_update, last_update_user_id)";
				$request .= " values ('".$galaxy."', ".$system.", '".$row."', '".mysql_real_escape_string($planet)."', ".$timestamp.", ".$user_data["user_id"].")";
				$db->sql_query($request);
			}
		}

    if ($testcol_lastupdatemoon) { // colonne 'last_update_moon' existe -> mise à jour
    		if ($timestamp > $last_update_moon && $moon) {
    			$request = "update ".TABLE_UNIVERSE." set moon = '1', last_update_moon = ".$timestamp.", phalanx = ".$phalanx.", gate = '".$gate."' where galaxy = '".$galaxy."' and system = ".$system." and row = '".$row."'";
    			$db->sql_query($request);
    		}
		}

		return 1;
	}
	return -1;
}


?>
