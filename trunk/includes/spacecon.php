<?php
/***************************************************************************
*	filename	: spacecon.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 17/12/2005
*	modified	: 30/07/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}


if (!isset($speed__uni)) {
	$speed_uni = 2;
}

//Production par heure
function production ($building, $level, $temperature = 0) {
	global $speed_uni, $user_technology;
	switch ($building) {
		case "M":
		$result = $speed_uni*(30 * $level * pow(1.1, $level));
		break;

		case "C":
		$result = $speed_uni*(20 * $level * pow(1.1, $level));
		break;

		case "D":
		$result = $speed_uni*(10 * $level * pow(1.1, $level) * (-0.002 * $temperature + 1.28));
		break;

		case "CES":
		$result = 20 * $level * pow(1.1, $level);
		break;

		case "CEF":
		$result = 30 * $level * pow((1.05 + 0.01 * $user_technology['NRJ']), $level);
		break;

		default:
		$result = 0;
		break;
	}

	return round($result);
}

//Production des réflecteurs
function production_ReSo ($temperature) {
	return floor(($temperature / 4) + 20);
}

//Consommation d'énergie
function consumption ($building, $level) {
    global $speed_uni;
	switch ($building) {
		case "M":
		$result = 10 * $level * pow(1.1, $level);
		break;

		case "C":
		$result = 10 * $level * pow(1.1, $level);
		break;

		case "D":
		$result = 20 * $level * pow(1.1, $level);
		break;

		case "CEF":
		$result = $speed_uni*(10 * $level * pow(1.1, $level));
		break;

		default:
		$result = 0;
		break;
	}

	return round($result);
}

//Capacité des hangars de stockage
function depot_capacity ($level) {
	$result = 100;
	if ($level > 0) {
		$result = 100 + 50 * floor(pow(1.6, $level));
	}

	return round($result);
}

//Coûts d'amélioration des batiments et recherches
function building_upgrade ($building, $level) {
	switch ($building) {
		case "M":
		$M = 60 * pow(1.5, ($level-1));
		$C = 15 * pow(1.5, ($level-1));
		$D = 0;
		$NRJ = 0;
		break;

		case "C":
		$M = 48 * pow(1.6, ($level-1));
		$C = 24 * pow(1.6, ($level-1));
		$D = 0;
		$NRJ = 0;
		break;

		case "D":
		$M = 225 * pow(1.5, ($level-1));
		$C = 75 * pow(1.5, ($level-1));
		$D = 0;
		$NRJ = 0;
		break;

		case "CES":
		$M = 75 * pow(1.5, ($level-1));
		$C = 30 * pow(1.5, ($level-1));
		$D = 0;
		$NRJ = 0;
		break;

		case "CEF":
		$M = 900 * pow(1.8, ($level-1));
		$C = 360 * pow(1.8, ($level-1));
		$D = 180 * pow(1.8, ($level-1));
		$NRJ = 0;
		break;
		
		case "UdR":
		$M = 400 * pow(2, ($level-1));
		$C = 120 * pow(2, ($level-1));
		$D = 200 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "UdN":
		$M = 1000000 * pow(2, ($level-1));
		$C = 500000 * pow(2, ($level-1));
		$D = 100000 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "CSp":
		$M = 400 * pow(2, ($level-1));
		$C = 200 * pow(2, ($level-1));
		$D = 100 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "HM":
		$M = 2000 * pow(2, ($level-1));
		$C = 0;
		$D = 0;
		$NRJ = 0;
		break;
		
		case "HC":
		$M = 2000 * pow(2, ($level-1));
		$C = 1000 * pow(2, ($level-1));
		$D = 0;
		$NRJ = 0;
		break;
		
		case "HD":
		$M = 2000 * pow(2, ($level-1));
		$C = 2000 * pow(2, ($level-1));
		$D = 0;
		$NRJ = 0;
		break;
		
		case "Lab":
		$M = 200 * pow(2, ($level-1));
		$C = 400 * pow(2, ($level-1));
		$D = 200 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "CdC":
		$M = 0;
		$C = 50000 * pow(2, ($level-1));
		$D = 100000 * pow(2, ($level-1));
		$NRJ = 1000 * pow(2, ($level-1));
		break;
		
		case "Silo":
		$M = 20000 * pow(2, ($level-1));
		$C = 20000 * pow(2, ($level-1));
		$D = 1000 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "CrAt":
		$M = 20000 * pow(2, ($level-1));
		$C = 40000 * pow(2, ($level-1));
		$D = 20000 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "Pha":
		$M = 20000 * pow(2, ($level-1));
		$C = 40000 * pow(2, ($level-1));
		$D = 20000 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "PoSa":
		$M = 2000000 * pow(2, ($level-1));
		$C = 4000000 * pow(2, ($level-1));
		$D = 2000000 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "Esp":
		$M = 200 * pow(2, ($level-1));
		$C = 1000 * pow(2, ($level-1));
		$D = 200 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "Gestion":
		$M = 0;
		$C = 400 * pow(2, ($level-1));
		$D = 600 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "Armes":
		$M = 800 * pow(2, ($level-1));
		$C = 200 * pow(2, ($level-1));
		$D = 0;
		$NRJ = 0;
		break;
		
		case "Bouclier":
		$M = 200 * pow(2, ($level-1));
		$C = 600 * pow(2, ($level-1));
		$D = 0;
		$NRJ = 0;
		break;
		
		case "Blindage":
		$M = 1000 * pow(2, ($level-1));
		$C = 0;
		$D = 0;
		$NRJ = 0;
		break;
		
		case "NRJ":
		$M = 0;
		$C = 800 * pow(2, ($level-1));
		$D = 400 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "Hyp":
		$M = 0;
		$C = 4000 * pow(2, ($level-1));
		$D = 2000 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "RC":
		$M = 400 * pow(2, ($level-1));
		$C = 0;
		$D = 600 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "RI":
		$M = 2000 * pow(2, ($level-1));
		$C = 4000 * pow(2, ($level-1));
		$D = 600 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "PH":
		$M = 10000 * pow(2, ($level-1));
		$C = 20000 * pow(2, ($level-1));
		$D = 6000 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "Laser":
		$M = 200 * pow(2, ($level-1));
		$C = 100 * pow(2, ($level-1));
		$D = 0;
		$NRJ = 0;
		break;
		
		case "Ions":
		$M = 1000 * pow(2, ($level-1));
		$C = 300 * pow(2, ($level-1));
		$D = 100 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "Plasma":
		$M = 2000 * pow(2, ($level-1));
		$C = 4000 * pow(2, ($level-1));
		$D = 1000 * pow(2, ($level-1));
		$NRJ = 0;
		break;

		default:
		$M = 0;
		$C = 0;
		$D = 0;
		$NRJ = 0;
		break;
	}

	return array("M" => $M, "C" => $C, "D" => $D, "NRJ" => $NRJ);
}

//Coûts cumulés des batiments
function building_cumulate ($building, $level) {
	switch ($building) {
		case "M":
		$M = 60 * (1 - pow(1.5, $level)) / (-0.5);
		$C = 15 * (1 - pow(1.5, $level)) / (-0.5);
		$D = 0;
		break;

		case "C":
		$M = 48 * (1 - pow(1.6, $level)) / (-0.6);
		$C = 24 * (1 - pow(1.6, $level)) / (-0.6);
		$D = 0;
		break;

		case "D":
		$M = 225 * (1 - pow(1.5, $level)) / (-0.5);
		$C = 75 * (1 - pow(1.5, $level)) / (-0.5);
		$D = 0;
		break;

		case "CES":
		$M = 75 * (1 - pow(1.5, $level)) / (-0.5);
		$C = 30 * (1 - pow(1.5, $level)) / (-0.5);
		$D = 0;
		break;

		case "CEF":
		$M = 900 * (1 - pow(1.8, $level)) / (-0.8);
		$C = 360 * (1 - pow(1.8, $level)) / (-0.8);
		$D = 180 * (1 - pow(1.8, $level)) / (-0.8);
		break;
		
		case "ReSo":
		$M = 0;
		$C = 2000 * $level;
		$D = 500 * $level;
		break;

		default:
		list($M, $C, $D) = array_values(building_upgrade($building, 1));
		$M = $M * -(1 - pow(2, $level));
		$C = $C * -(1 - pow(2, $level));
		$D = $D * -(1 - pow(2, $level));
		break;
	}

	return array("M" => $M, "C" => $C, "D" => $D);
}

//Coûts cumulés de tout les batiments
function all_building_cumulate ($user_building) {

	$total = 0;
	
	while($data = current($user_building)) {
	
		$bats = array_keys($data);
		
		foreach($bats as $key) {
	
			$level = $data[$key];
			if($level=="") $level = 0;

			if($key == "M" || $key == "C" || $key == "D" || $key == "CES" || $key == "CEF" || $key == "UdR" || $key == "UdN" || 
			$key == "CSp" || $key == "HM" || $key == "HC" || $key == "HD" || $key == "Lab" || $key == "CdC" || 
			$key == "Silo" || $key == "CrAt" || $key == "Pha" || $key == "PoSa") {
				list($M, $C, $D) = array_values(building_cumulate($key, $level));
				$total += $M + $C + $D;
			}
		}
		
		next($user_building);
	}

	return $total;
}

//Coûts cumulés de toutes les défenses
function all_defence_cumulate ($user_defence) {

	$total = 0;
	$init_d_prix = array("CA" => 2000, "TLM" => 2000, "ASA" => 8000, "CP" => 37000, "AM" => 8000, "Dem" => 130000,
	"PB" => 20000, "GB" => 100000, "MIC" => 10000, "MIP" => 25000);
	$keys = array_keys($init_d_prix);
	while($data = current($user_defence)) {
		if(sizeof($init_d_prix) != sizeof($keys)) continue;
	
		for($i=0; $i<sizeof($init_d_prix); $i++) {
			$total += $init_d_prix[$keys[$i]] * ($data[$keys[$i]]!="" ? $data[$keys[$i]] : 0);
		}
		
		next($user_defence);
	}

	return $total;
}

//Coûts cumulés de toutes les lunes
function all_lune_cumulate ($user_building, $user_defence) {
	
	$total = all_defence_cumulate($user_defence) + all_building_cumulate($user_building);

	return $total;
}

//Coûts cumulés de toutes les recherches
function all_technology_cumulate ($user_technology) {
	
	$total = 0;
	$init_t_prix = array("Esp" => 1400, "Ordi" => 1000, "Armes" => 1000, "Bouclier" => 800, "Blindage" => 1000,
	"NRJ" => 1200, "Hyp" => 6000, "RC" => 1000, "RI" => 6600, "PH" => 36000, "Laser" => 300, "Ions" => 1400,
	"Plasma" => 7000, "Antimatiere" => 0);
	$keys = array_keys($init_t_prix);

	if(sizeof($init_t_prix) != sizeof($user_technology)) return 0;
	
	for($i=0; $i<sizeof($init_t_prix); $i++) {
			$total += $init_t_prix[$keys[$i]] * (pow(2,($user_technology[$keys[$i]]!="") ? $user_technology[$keys[$i]] : 0) - 1);
	}

	return $total;
}
?>