<?php
/**
* functions.php 
* @package MAJ
* @author ben.12
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME')) {
   die("Hacking attempt");
}

if (!isset($num_of_galaxies) || !isset($num_of_systems)) { 
	$num_of_galaxies = $server_config['num_of_galaxies'];
	$num_of_systems = $server_config['num_of_systems'];
}


//Récupération des statistiques des maj
function galaxy_maj ($div = 2, $jrs = 7) {
    global $db, $user_data;
	global $num_of_galaxies, $num_of_systems;

    $step = ceil($num_of_systems/$div);
	$nb_planets_total = 0;

    for ($system=1 ; $system<=$num_of_systems ; $system=$system+$step) {
		$nb_planets = array();
		$last_update = array();
		$nb_last_update = array();
		
        $request = "SELECT galaxy, count(*) from ".TABLE_UNIVERSE;
        $request .= " where (system between ".$system." and ".($system+$step-1).")";
        $request .= " and last_update > ".(time()-(60*60*24*$jrs));
		$request .= " GROUP BY galaxy";
        $result = $db->sql_query($request);
        while(list($glx, $nb) = $db->sql_fetch_row($result)) {
			if($glx<1 || $glx>$num_of_galaxies) continue;
			$nb_planets[$glx] = $nb;
			$nb_planets_total += $nb;
		}

        $request = "SELECT galaxy, max(last_update) from ".TABLE_UNIVERSE;
        $request .= " where system between ".$system." and ".($system+$step-1);
		$request .= " GROUP BY galaxy";
        $result = $db->sql_query($request);
			
		$request = "SELECT galaxy, COUNT(*) FROM ".TABLE_UNIVERSE." WHERE ";
        while(list($glx, $lu) = $db->sql_fetch_row($result)) {
			if($glx<1 || $glx>$num_of_galaxies) continue;
			$last_update[$glx] = $lu;
			
			$date = getdate($lu);
			$request .= " (galaxy=".$glx." AND (system between ".$system." AND ".($system+$step-1).")";
			$request .= " AND (last_update between ".mktime(0,0,0,$date["mon"],$date["mday"],$date["year"])." AND ".mktime(0,0,0,$date["mon"],$date["mday"]+1,$date["year"]).")) OR";
		}
			
        $request = substr($request, 0, strlen($request)-3)." GROUP BY galaxy";
		$result = $db->sql_query($request);
        while(list($glx, $nlu) = $db->sql_fetch_row($result)) {
			if($glx<1 || $glx>$num_of_galaxies) continue;
			$nb_last_update[$glx] = $nlu;
		}
			
		for($i=1 ; $i<=$num_of_galaxies ; $i++) {
			$statictics[$i][$system] = array("planet" => 0, "last_update" => false, "nb_last_update" => '-', "user_name" => '-');
			if(isset($nb_planets[$i])) 
				$statictics[$i][$system]["planet"] = $nb_planets[$i];
			if(isset($last_update[$i])) 
				$statictics[$i][$system]["last_update"] = $last_update[$i];
			if(isset($nb_last_update[$i])) 
				$statictics[$i][$system]["nb_last_update"] = $nb_last_update[$i];
		}
    }
		
	$request = "SELECT div_nb, user_name from ".TABLE_MAJ.", ".TABLE_USER;
    $request .= " where user_id = name_id and div_type = ".$div;
    $result = $db->sql_query($request);
	while(list($div_nb, $user) = $db->sql_fetch_row($result)) {
		$system = ($div_nb%$div)*$step+1;
		$glx = floor($div_nb/$div)+1;
		if($glx<1 || $glx>$num_of_galaxies) continue;
		if($system<1 || $system>$num_of_systems) continue;
		$statictics[$glx][$system]["user_name"] = $user;
	}
	
    return array($statictics, $nb_planets_total);
}

//Récupération des statistiques des maj
function rank_maj($ranking) {
    global $db, $user_data;
	
	switch($ranking) {
		case "player_points":
		case -1:
			$name = "Joueurs Général";
			$table = TABLE_RANK_PLAYER_POINTS;
			$div_type = -1;
			break;
		
		case "player_economic":
		case -2:
			$name = "Joueurs Economique";
			$table = TABLE_RANK_PLAYER_ECO;
			$div_type = -2;
			break;
			
		case "player_research":
		case -3:
			$name = "Joueurs Recherche";
			$table = TABLE_RANK_PLAYER_TECHNOLOGY;
			$div_type = -3;
			break;
			
			
		case "player_military":
		case -4:
			$name = "Joueurs Militaire";
			$table = TABLE_RANK_PLAYER_MILITARY;
			$div_type = -4;
			break;
		
		case "player_military_built":
		case -5:
			$name = "Joueurs Mil. Construit";
			$table = TABLE_RANK_PLAYER_MILITARY_BUILT;
			$div_type = -5;
			break;

		case "player_military_loose":
		case -6:
			$name = "Joueurs Mil. Détruit";
			$table = TABLE_RANK_PLAYER_MILITARY_LOOSE;
			$div_type = -6;
			break;
			
		case "player_military_destruct":
		case -7:
			$name = "Joueurs Mil. Détruit";
			$table = TABLE_RANK_PLAYER_MILITARY_DESTRUCT;
			$div_type = -7;
			break;
				
		case "player_military_honnor":
		case -8:
			$name = "Joueurs Mil. Honneur";
			$table = TABLE_RANK_PLAYER_HONOR;
			$div_type = -8;
			break;
					
		case "ally_points":
		case -9:
			$name = "Alliances Général";
			$table = TABLE_RANK_ALLY_POINTS;
			$div_type = -9;
			break;
			
		case "ally_economic":
		case -10:
			$name = "Alliances Economique";
			$table = TABLE_RANK_ALLY_ECO;
			$div_type = -10;
			break;
			
		case "ally_research":
		case -11:
			$name = "Alliances recherche";
			$table = TABLE_RANK_ALLY_TECHNOLOGY;
			$div_type = -11;
			break;
			
		case "ally_military":
		case -12:
			$name = "Alliances Militaire";
			$table = TABLE_RANK_ALLY_MILITARY;
			$div_type = -12;
			break;
				
		case "ally_military_buil":
		case -13:
			$name = "Alliances Mil. Construit";
			$table = TABLE_RANK_ALLY_MILITARY_BUILT;
			$div_type = -13;
			break;
				
		case "ally_military_loose":
		case -14:
			$name = "Alliances Mil. Perdu";
			$table = TABLE_RANK_ALLY_MILITARY_LOOSE;
			$div_type = -14;
			break;
		
		case "ally_military_destruct":
		case -15:
			$name = "Alliances Mil. Détruit";
			$table = TABLE_RANK_ALLY_MILITARY_DESTRUCT;
			$div_type = -15;
			break;
		
		case "ally_military_honnor":
		case -16:
			$name = "Alliances Mil. Honneur";
			$table = TABLE_RANK_ALLY_HONOR;
			$div_type = -16;
			break;
			
		default:
			return array("", 0, 0, "-");
	}
	
	$request = "select user_name from ".TABLE_MAJ.", ".TABLE_USER;
	$request .= " where user_id = name_id and div_type = ".$div_type;
    $result = $db->sql_query($request);
    list($user) = $db->sql_fetch_row($result);
	if($user===false) $user = "-";
	
	
	$request = "select max(datadate) from ".$table;
    $result = $db->sql_query($request);
    list($date) = $db->sql_fetch_row($result);
	
	if(!$date) {
		$date = 0;
		return array($name, $date, 0, array(), $user);
	}
	
	$request = "select max(rank) from ".$table;
	$request .= " where datadate = ".$date;
	$result = $db->sql_query($request);
	list($rank_number) = $db->sql_fetch_row($result);
	
	$min_maj = get_min_rank_number($ranking);
	if($rank_number < $min_maj)
		$page_number = ceil($min_maj/100);
	else
		$page_number = ceil($rank_number/100);
	
	$rank = array();
	$nb_rank = 0;
	
	for($i=0; $i<$page_number; $i++) {
		$request = "select count(*) from ".$table;
		$request .= " where datadate = ".$date;
		$request .= " and rank between ".($i*100+1)." and ".($i*100+100);
		$result = $db->sql_query($request);
		list($rank[$i]) = $db->sql_fetch_row($result);
		$nb_rank+=$rank[$i];
	}
	
	return array($name, $date, $nb_rank, $rank, $user);
}

function add_rank($name, $date, $nb_rank, $rank, $user, $type, $page_number = 15) {
	
	$min_maj = get_min_rank_number($type);
	$rate = $nb_rank;
	if($rate > $min_maj)
		$rate = $min_maj;
	
	echo "<tr>\n";
	echo "\t<td class='c'>".$name."</th>\n";
	echo "\t<th><font color='#EEFF00'>".$user."</color></th>\n";
	echo "\t<th>".strftime("%d %b %Y à %Hh", $date)."</th>\n";
	echo "\t<th><font color='#".get_color($rate, $min_maj)."'>".formate_number($nb_rank)."</font></th>\n";
	for($i=0; $i<$page_number ;$i++) {
		if(isset($rank[$i]) && $rank[$i]>0) 
			echo "\t<th><img src='mod/maj/img/ok.gif' alt='ok' ></th>\n";
		else
			echo "\t<th><img src='mod/maj/img/no.gif' alt='no' ></th>\n";
	}
}

function get_system_obs($galaxy, $system) {
	
	global $db, $user_data, $step, $days;
	global $num_of_galaxies, $num_of_systems;
	
	$obs = array();
	
	$up = $system+$step-1;
	if ($up > $num_of_systems) $up = $num_of_systems;
	
	$sql  = "SELECT galaxy, system, last_update FROM ".TABLE_UNIVERSE;
	$sql .= " WHERE last_update<".(time()-(60*60*24*$days));
	$sql .= " AND galaxy=".$galaxy;
	$sql .= " AND system BETWEEN ".$system." and ".$up;
	$sql .= " GROUP BY system";
	$result = $db->sql_query($sql);
    while(list($glx, $stm, $lu) = $db->sql_fetch_row($result)) {
		$obs[] = array("galaxy"=>$glx, "system"=>$stm, "last_update"=>$lu);
	}
	
	return $obs;
}

function get_min_rank_number($type) {
	global $server_config;
	
	switch($type) {
		case "player_points":
		case -1:
		case "player_economic":
		case -2:
		case "player_research":
		case -3:
		case "player_military":
		case -4:
		case "player_military_built":
		case -5:
		case "player_military_loose":
		case -6:
		case "player_military_destruct":
		case -7:
		case "player_military_honnor":
		case -8:
		case "player":
							
		case "popup_maj_num_rank_player_alert":
		default:
			$min_maj = $server_config['popup_maj_num_rank_player_alert'];
			break;
			
		case "ally_points":
		case -9:
		case "ally_economic":
		case -10:
		case "ally_research":
		case -11:
		case "ally_military":
		case -12:
		case "ally_military_built":
		case -13:
		case "ally_military_loose":
		case -14:
		case "ally_military_destruct":
		case -15:
		case "ally_military_honnor":
		case -16:
		case "ally":
			
		case "popup_maj_num_rank_ally_alert":
			$min_maj = $server_config['popup_maj_num_rank_ally_alert'];
			break;
	}
	
	return $min_maj;
}

?>