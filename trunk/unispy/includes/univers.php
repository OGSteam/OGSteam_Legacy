<?php
/**
 * Fonctions relatives à Univers - Les Formules - 
 * @version 1.0 Beta
* @package UniSpy
 * @subpackage Univers
 * @author kyser
 * @link http://www.ogsteam.fr
 * @modified 24/11/2006
 */ 
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

//Production par heure
/**
 * Calcule la production d'une usine par heure
 * @param string $building Ti Titane Ca Carbone .... (Ti,Ca,Tr,CG,CaT)
 * @param string $level Niveau de mine
 * @param int $temperature Utilisé pour le calcul des Centrales a Fusion
 * @return int Valeur arrondi de la production horaire
 */
function production ($building, $level, $tech=0, $temperature = 0) {
global $server_config;
	switch ($building) {
		case "Ti":
		$result = 20 + (30 * ($level) * pow((1.1+($tech)/1000),$level) * $server_config['uni_speed']);
		break;

		case "Ca":
		$result = 10 + (20 * ($level) * pow((1.1+($tech)/1000),$level) * $server_config['uni_speed']);
		break;

		case "Tr":
		$result = (10 * ($level) * pow((1.1+($tech)/1000),$level) * $server_config['uni_speed']);
		break;

		case "CG":
		$result = 20 * $level * pow(1.1, $level);
		break;

		case "CaT":
		$result = 50 * $level * pow(1.1, $level);
		break;

		default:
		$result = 0;
		break;
	}

	return round($result);
}

//Production des satellites
/**
 *  Energie fourni par un satellite selon la température
* @param int $temperature 
* @return int Energie fourni
 */
function production_sat ($temperature) {
	return floor(($temperature / 4) + 20);
}

//Consommation d'énergie
/**
 * Calcul de la consommation d'energie d'un batiment
 * @param string $building Ti Titane Ca Carbone .... (Ti,Ca,Tr,CaT)
  * @param int $level Niveau du batiment
 * @return int arrondi de l'energie consommé
 */
function consumption ($building, $level) {
	switch ($building) {
		case "Ti":
		$result = 10 * $level * pow(1.1, $level);
		break;

		case "Ca":
		$result = 10 * $level * pow(1.1, $level);
		break;

		case "Tr":
		$result = 20 * $level * pow(1.1, $level);
		break;

		case "CaT":
		$result = 10 * $level * pow(1.1, $level);
		break;

		default:
		$result = 0;
		break;
	}

	return round($result);
}

/**
 * Capacité des hangars de stockage
 * @param int $level le niveau du hangar
 * @return int Arrondi de la capacité de stockage
 */
function depot_capacity ($level) {
	$result = 100;
	if ($level > 0) {
		$result = 100 + 50 * floor(pow(1.6, $level));
	}

	return round($result);
}


/**
 * Coûts d'amélioration des batiments et recherches
 * @param string $building
 * @param int $level Niveau du batiment
 * @return array tableau (M,C,D,NRJ)
 * @version 3.02
 */
function building_upgrade ($building, $level) {
	switch ($building) {
		case "Ti":
		$Ti = 50 * pow(1.5, ($level-1));
		$Ca = 20 * pow(1.5, ($level-1));
		$Tr = 0;
		$NRJ = 0;
		break;

		case "Ca":
		$Ti = 60 * pow(1.5, ($level-1));
		$Ca = 25 * pow(1.5, ($level-1));
		$Tr = 0;
		$NRJ = 0;
		break;

		case "Tr":
		$Ti = 225 * pow(1.5, ($level-1));
		$Ca = 75 * pow(1.5, ($level-1));
		$Tr = 0;
		$NRJ = 0;
		break;

		case "CG":
		$Ti = 75 * pow(1.5, ($level-1));
		$Ca = 30 * pow(1.5, ($level-1));
		$Tr = 0;
		$NRJ = 0;
		break;

		case "CaT":
		$Ti = 960 * pow(1.7, ($level-1));
		$Ca = 360 * pow(1.7, ($level-1));
		$Tr = 180 * pow(1.7, ($level-1));
		$NRJ = 0;
		break;
		
		case "UdD":
		$Ti = 400 * pow(2, ($level-1));
		$Ca = 120 * pow(2, ($level-1));
		$Tr = 200 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "UdA":
		$Ti = 1000000 * pow(2, ($level-1));
		$Ca = 500000 * pow(2, ($level-1));
		$Tr = 100000 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "UA":
		$Ti = 400 * pow(2, ($level-1));
		$Ca = 200 * pow(2, ($level-1));
		$Tr = 100 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "STi":
		$Ti = 2000 * pow(1.5, ($level-1));
		$Ca = 0;
		$Tr = 0;
		$NRJ = 0;
		break;
		
		case "SCa":
		$Ti = 2000 * pow(1.5, ($level-1));
		$Ca = 1000 * pow(1.5, ($level-1));
		$Tr = 0;
		$NRJ = 0;
		break;
		
		case "STr":
		$Ti = 2000 * pow(1.5, ($level-1));
		$Ca = 2000 * pow(1.5, ($level-1));
		$Tr = 0;
		$NRJ = 0;
		break;
		
		case "CT":
		$Ti = 200 * pow(2, ($level-1));
		$Ca = 400 * pow(2, ($level-1));
		$Tr = 200 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "Ter":
		$Ti = 50000 * pow(2, ($level-1));
		$Ca = 100000 * pow(2, ($level-1));
		$Tr = 0;
		$NRJ = 0;
		break;
		
		case "HM":
		$Ti = 10000 * pow(2, ($level-1));
		$Ca = 10000 * pow(2, ($level-1));
		$Tr = 1000 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "CM":
		$Ti = 1000000 * pow(2, ($level-1));
		$Ca = 750000 * pow(2, ($level-1));
		$Tr = 200000 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		
		case "Esp":
		$Ti = 400 * pow(2, ($level-1));
		$Ca = 1500 * pow(2, ($level-1));
		$Tr = 300 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "Qua":
		$Ti = 0;
		$Ca = 600 * pow(2, ($level-1));
		$Tr = 1000 * pow(2, ($level-1));
		$NRJ = 0;
		break;

		case "Alli":
		$Ti = 0;
		$Ca = 800 * pow(1.8, ($level-1));
		$Tr = 400 * pow(1.8, ($level-1));
		$NRJ = 0;
		break;

		case "SC":
		$Ti = 1000 * pow(1.8, ($level-1));
		$Ca = 0;
		$Tr = 800 * pow(1.8, ($level-1));
		$NRJ = 0;
		break;
		
		case "Raf":
		$Ti = 1200* pow(1.5, ($level-1));
		$Ca = 800 * pow(1.5, ($level-1));
		$Tr = 0;
		$NRJ = 0;
		break;
		
		case "Armes":
		$Ti = 750 * pow(2, ($level-1));
		$Ca = 250 * pow(2, ($level-1));
		$Tr = 0;
		$NRJ = 0;
		break;
		
		case "Bouclier":
		$Ti = 350 * pow(2, ($level-1));
		$Ca = 650 * pow(2, ($level-1));
		$Tr = 0;
		$NRJ = 0;
		break;
		
		case "Blindage":
		$Ti = 1000 * pow(2, ($level-1));
		$Ca = 0;
		$Tr = 0;
		$NRJ = 0;
		break;
		
		case "Ther":
		$Ti = 0;
		$Ca = 800 * pow(2, ($level-1));
		$Tr = 400 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "Anti":
		$Ti = 0;
		$Ca = 4000 * pow(2, ($level-1));
		$Tr = 1500 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "HD":
		$Ti = 400 * pow(2, ($level-1));
		$Ca = 0;
		$Tr = 600 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "Imp":
		$Ti = 2000 * pow(2, ($level-1));
		$Ca = 4000 * pow(2, ($level-1));
		$Tr = 600 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "Warp":
		$Ti = 10000 * pow(2, ($level-1));
		$Ca = 20000 * pow(2, ($level-1));
		$Tr = 5500 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "Smart":
		$Ti = 400 * pow(2, ($level-1));
		$Ca = 200 * pow(2, ($level-1));
		$Tr = 0;
		$NRJ = 0;
		break;
		
		case "Ions":
		$Ti = 1000 * pow(2, ($level-1));
		$Ca = 400 * pow(2, ($level-1));
		$Tr = 150 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "Aereon":
		$Ti = 4000 * pow(2, ($level-1));
		$Ca = 4000 * pow(2, ($level-1));
		$Tr = 1500 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "Sca":
		$Ti = 300000 * pow(2, ($level-1));
		$Ca = 450000 * pow(2, ($level-1));
		$Tr = 100000 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		case "Graviton":
		$Ti = 0;
		$Ca = 0;
		$Tr = 0;
		$NRJ = 400000 * pow(3, ($level-1));
		break;
		
		case "Admi":
		$Ti = 2000 * pow(1.9, ($level-1));
		$Ca = 2500 * pow(1.9, ($level-1));
		$Tr = 800 * pow(1.9, ($level-1));
		$NRJ = 10 * pow(1.9, ($level-1));
		break;

		case "Expl":
		$Ti = 7500 * pow(2, ($level-1));
		$Ca = 10000 * pow(2, ($level-1));
		$Tr = 15000 * pow(2, ($level-1));
		$NRJ = 0;
		break;
		
		default:
		$Ti = 0;
		$Ca = 0;
		$Tr = 0;
		$NRJ = 0;
		break;
	}

	return array("Ti" => $Ti, "Ca" => $Ca, "Tr" => $Tr, "NRJ" => $NRJ);
}

/**
 * Coûts cumulé des batiments
 * @param string $building M metal C Crystal .... (M,C,D,CES,CEF,UdR,UdN,CSp,HM,HC,HD,Lab,Ter,Silo,BaLu,Pha,PoSa,Esp,Ordi,Armes,Bouclier,Protection,NRJ,Hyp,RC,...)
 * @param int $level Niveau du batiment
 * @return array tableau (M,C,D)
 * @version 3.02
 */

function building_cumulate ($building, $level) {

	switch ($building) {
		case "Ti":
		list($Ti, $Ca, $Tr) = array_values(building_upgrade($building, 1));
		$Ti = $Ti * (1 - pow(1.5, $level)) / (-0.5);
		$Ca = $Ca * (1 - pow(1.5, $level)) / (-0.5);
		$Tr = $Tr * (1 - pow(1.5, $level)) / (-0.5);
		break;

		case "Ca":
		list($Ti, $Ca, $Tr) = array_values(building_upgrade($building, 1));
		$Ti = $Ti * (1 - pow(1.5, $level)) / (-0.5);
		$Ca = $Ca * (1 - pow(1.5, $level)) / (-0.5);
		$Tr = $Tr * (1 - pow(1.5, $level)) / (-0.5);
		break;

		case "Tr":
		list($Ti, $Ca, $Tr) = array_values(building_upgrade($building, 1));
		$Ti = $Ti * (1 - pow(1.5, $level)) / (-0.5);
		$Ca = $Ca * (1 - pow(1.5, $level)) / (-0.5);
		$Tr = $Tr * (1 - pow(1.5, $level)) / (-0.5);
		break;

		case "CG":
		list($Ti, $Ca, $Tr) = array_values(building_upgrade($building, 1));
		$Ti = $Ti * (1 - pow(1.5, $level)) / (-0.5);
		$Ca = $Ca * (1 - pow(1.5, $level)) / (-0.5);
		$Tr = $Tr * (1 - pow(1.5, $level)) / (-0.5);
		break;
		
		case "STi":
		list($Ti, $Ca, $Tr) = array_values(building_upgrade($building, 1));
		$Ti = $Ti * (1 - pow(1.5, $level)) / (-0.5);
		$Ca = $Ca * (1 - pow(1.5, $level)) / (-0.5);
		$Tr = $Tr * (1 - pow(1.5, $level)) / (-0.5);
		break;

		case "SCa":
		list($Ti, $Ca, $Tr) = array_values(building_upgrade($building, 1));
		$Ti = $Ti * (1 - pow(1.5, $level)) / (-0.5);
		$Ca = $Ca * (1 - pow(1.5, $level)) / (-0.5);
		$Tr = $Tr * (1 - pow(1.5, $level)) / (-0.5);
		break;

		case "STr":
		list($Ti, $Ca, $Tr) = array_values(building_upgrade($building, 1));
		$Ti = $Ti * (1 - pow(1.5, $level)) / (-0.5);
		$Ca = $Ca * (1 - pow(1.5, $level)) / (-0.5);
		$Tr = $Tr * (1 - pow(1.5, $level)) / (-0.5);
		break;
		
		case "CaT":
		list($Ti, $Ca, $Tr) = array_values(building_upgrade($building, 1));
		$Ti = $Ti * (1 - pow(1.7, $level)) / (-0.7);
		$Ca = $Ca * (1 - pow(1.7, $level)) / (-0.7);
		$Tr = $Tr * (1 - pow(1.7, $level)) / (-0.7);
		break;
		
		case "Sat":
		$Ti = 0;
		$Ca = 2500 * $level;
		$Tr = 500 * $level;
		break;

		default:
		list($Ti, $Ca, $Tr) = array_values(building_upgrade($building, 1));
		$Ti = $Ti * -(1 - pow(2, $level));
		$Ca = $Ca * -(1 - pow(2, $level));
		$Tr = $Tr * -(1 - pow(2, $level));
		break;
	}

	return array("Ti" => $Ti, "Ca" => $Ca, "Tr" => $Tr);
}

/**
 * Coûts cumulé de tout les batiments
 */
function all_building_cumulate ($user_building) {

	$total = 0;

	while($data = current($user_building)) {
	
		$bats = array_keys($data);
		foreach($bats as $key) {
			$Ti = 0;
			$Ca = 0;
			$Tr = 0;
			
			$level = $data[$key];
			if($level=="") $level = 0;
			if($key === "Ti" || $key === "Ca" || $key === "Tr" || $key === "CG" || $key === "CaT" || $key === "UdD" || $key === "UdA" || 
			$key === "UA" || $key === "STi" || $key === "SCa" || $key === "STr" || $key === "CT" || $key === "Ter" || 
			$key === "HM" || $key === "CM" || $key === "Sat") {
				
				if($level > 0) list($Ti, $Ca, $Tr) = array_values(building_cumulate($key, $level));
				$total += $Ti + $Ca + $Tr;
			}
			
		}
		next($user_building);
	}
	return $total;
}

/**
 * Coûts cumulé de toutes les défenses
 */
function all_defence_cumulate ($user_defence) {

	$total = 0;
	$init_d_prix = array("BFG" => 3000, "SBFG" => 3500, "PFC" => 10500, "DeF" => 37000, "PFI" => 9000, "AMD" => 125000,
	"CF" => 20000, "Ho" => 100000, "CME" => 7000, "EMP" => 28000);
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

function technology_cumulate ($techno, $level) {

	switch ($techno) {
		
		case "Alli":
		list($Ti, $Ca, $Tr) = array_values(building_upgrade($techno, 1));
		$Ti = $Ti * (1 - pow(1.8, $level)) / (-0.8);
		$Ca = $Ca * (1 - pow(1.8, $level)) / (-0.8);
		$Tr = $Tr * (1 - pow(1.8, $level)) / (-0.8);
		break;

		case "SC":
		list($Ti, $Ca, $Tr) = array_values(building_upgrade($techno, 1));
		$Ti = $Ti * (1 - pow(1.8, $level)) / (-0.8);
		$Ca = $Ca * (1 - pow(1.8, $level)) / (-0.8);
		$Tr = $Tr * (1 - pow(1.8, $level)) / (-0.8);
		break;

		case "Raf":
		list($Ti, $Ca, $Tr) = array_values(building_upgrade($techno, 1));
		$Ti = $Ti * (1 - pow(1.5, $level)) / (-0.5);
		$Ca = $Ca * (1 - pow(1.5, $level)) / (-0.5);
		$Tr = $Tr * (1 - pow(1.5, $level)) / (-0.5);
		break;

		case "Admi":
		list($Ti, $Ca, $Tr) = array_values(building_upgrade($techno, 1));
		$Ti = $Ti * (1 - pow(1.9, $level)) / (-0.9);
		$Ca = $Ca * (1 - pow(1.9, $level)) / (-0.9);
		$Tr = $Tr * (1 - pow(1.9, $level)) / (-0.9);
		break;
		
		default:
		list($Ti, $Ca, $Tr) = array_values(building_upgrade($techno, 1));
		$Ti = $Ti * -(1 - pow(2, $level));
		$Ca = $Ca * -(1 - pow(2, $level));
		$Tr = $Tr * -(1 - pow(2, $level));
		break;
	}

	return array("Ti" => $Ti, "Ca" => $Ca, "Tr" => $Tr);
}

/**
 * Coûts cumulé de toutes les recherches
 */
function all_technology_cumulate ($user_technology) {
	
	$total = 0;

	$technos = array_keys($user_technology);
	
	//if(sizeof($init_t_prix) != sizeof($user_technology)) return 0;
	foreach($technos as $key){
		$Ti = 0;
		$Ca = 0;
		$Tr = 0;
		
		
		$level = $user_technology[$key];

		if($level=="") $level = 0;
		if($key === "Esp" || $key === "Qua" || $key === "Alli" || $key === "SC" || $key === "Raf" || $key === "Armes"
		|| $key === "Bouclier" || $key === "Blindage" || $key === "Ther" || $key === "Anti" || $key === "HD" || $key === "Imp"
		|| $key === "Warp" || $key === "Smart" || $key === "Ions" || $key === "Aereon" || $key === "Sca" || $key === "Graviton"
		|| $key === "Admi" || $key === "Expl") {
			if ($level > 0) list($Ti, $Ca, $Tr) = array_values(technology_cumulate($key,$level));
			$total += $Ti + $Ca + $Tr;
		}
	}
	return $total;
}
?>
