<?php
/***************************************************************************
*	filename	: recherche_plus.php
*	Author	: ben.12
***************************************************************************/

/**************************************************************************
*	Ce mod gère les permission d'acces grace aux groupe d'ogpy.
*	Pour cela créé un groupe nomé "recherche_plus" et ajoutez y les utilisateur devants avoir acces a ce mod.
*	SI AUCUN GROUPE N'EST CREE, TOUS LES MEMBRES ONT ACCES.
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='recherche_plus' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

if($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
	$request = "SELECT group_id FROM ".TABLE_GROUP." WHERE group_name='recherche_plus'";
	$result = $db->sql_query($request);
	
	if(list($group_id) = $db->sql_fetch_row($result)) {
		$request = "SELECT COUNT(*) FROM ".TABLE_USER_GROUP." WHERE group_id=".$group_id." AND user_id=".$user_data['user_id'];
		$result = $db->sql_query($request);
		list($row) = $db->sql_fetch_row($result);
		if($row == 0) redirection("index.php?action=message&id_message=forbidden&info");
	}
}

if (!isset($server_config['num_of_galaxies']) || !isset($server_config['num_of_systems'])) { 
	$num_of_galaxies = 9;
	$num_of_systems = 499;
}else{
	$num_of_galaxies = $server_config['num_of_galaxies'];
	$num_of_systems = $server_config['num_of_systems'];
}
/*/vérification de la version pour compatibilité 
	$num_of_galaxies = 50;
	$num_of_systems = 100;//*/

if(isset($pub_graph) && $pub_graph == "barre") {
	require_once("mod/recherche_plus/graphic_barre.php");
	exit();
}

// Version du Mod
$mod_version = 0;
$query = "SELECT version FROM ".TABLE_MOD." WHERE `action`='recherche_plus'";
$result = $db->sql_query($query);
list($mod_version) = $db->sql_fetch_row($result);

//include "./mod/recherche_plus/universes.php";

require_once("views/page_header.php");

?>
<script language="javascript"><!-- 
function plus_affiche(ranking)
{
	if (document.getElementById && document.getElementById(ranking) != null)
	{
		document.getElementById(ranking).style.display='block';
	}
}

function plus_cache(ranking)
{
	if (document.getElementById && document.getElementById(ranking) != null)
	{
		document.getElementById(ranking).style.display='none';
	}
}

function plus_select(ranking)
{
	if(ranking.indexOf("player") != -1) {
		plus_cache("rank_player_points");
		plus_cache("rank_player_fleet");
		plus_cache("rank_player_research");
	} else {
		plus_cache("rank_ally_points");
		plus_cache("rank_ally_fleet");
		plus_cache("rank_ally_research");
	}
	
	plus_affiche(ranking);
}

function plus_partout(formulaire)
{
	formulaire.galaxy_down.value="1";
	formulaire.galaxy_up.value="<?php echo $num_of_galaxies; ?>";
	formulaire.system_down.value="1";
	formulaire.system_up.value="<?php echo $num_of_systems; ?>";
}

function erreur() {
	
	alert("Un paramètre de recherche n'est pas convenable.");
}
//--></script>
<?php
$help["recherche_plus_row"] = "Intervalle de planètes (1 à 15)";
$help["recherche_plus_allys"] = "Seulements ces alliances seront recherchées<br><font color='orange'><i>(Séparez les alliances par des virgules.)</i></font>";
$help["recherche_plus_players"] = "Seulements ces joueurs seront recherchés<br><font color='orange'><i>(Séparez les joueurs par des virgules.)</i></font>";
$help["recherche_plus_pilori"] = "Si vous copiez le pilori ci-dessous, seul les joueurs bloqués sans MV seront recherchés.<br><i>(bloquage pour spam ou insulte)</i>";

// Affiche la selection de la date:
function plus_rank_date($ranking, $rank_date) {
	global $db, $pub_date;
	
	switch($ranking) {
		case "rank_player_points":
			$table = TABLE_RANK_PLAYER_POINTS;
			break;
		case "rank_player_fleet":
			$table = TABLE_RANK_PLAYER_FLEET;
			break;
		case "rank_player_research":
			$table = TABLE_RANK_PLAYER_RESEARCH;
			break;
		case "rank_ally_points":
			$table = TABLE_RANK_ALLY_POINTS;
			break;
		case "rank_ally_fleet":
			$table = TABLE_RANK_ALLY_FLEET;
			break;
		case "rank_ally_research":
			$table = TABLE_RANK_ALLY_RESEARCH;
			break;
		default:
			$table = TABLE_RANK_PLAYER_FLEET;
	}
	
	$request = "SELECT count(*), datadate FROM ".$table." GROUP BY datadate ORDER BY datadate desc";
	
	echo "<div id='".$ranking."' style='display:none;'><select name='date_".$ranking."'>\n";
	if($rank_date=="0") $select = " selected";
	if($result = $db->sql_query($request)) {
		while(list($lignes, $date) = $db->sql_fetch_row($result)) {
			if($rank_date!="0" && $rank_date == $date) $select = " selected";
			echo "\t<option value='".$date."'".$select.">".strftime("%d %b %Y %Hh", $date)." (".$lignes.")</option>\n";
			$select = "";
		}
	}
	echo "</select></div>\n";
}

function plus_search() {
    global $db, $user_data, $user_auth, $server_config, $pilo;
    global $pub_sort, $pub_sort2, $pub_galaxy_down, $pub_galaxy_up, $pub_system_down, $pub_system_up, $pub_row_down, $pub_row_up, $pub_row_active, $pub_days_active, $pub_days, $pub_rank_fleet_down, $pub_rank_fleet_up, $pub_rank_point_down, $pub_rank_point_up, $pub_rank_search_down, $pub_rank_search_up, $pub_rank_active, $pub_page;
	global $pub_ally_point_down, $pub_ally_point_up, $pub_ally_fleet_down, $pub_ally_fleet_up, $pub_ally_search_down, $pub_ally_search_up, $pub_ally_active, $pub_allys, $pub_lune_active, $pub_spy_active, $pub_phalanx_active, $pub_gate_active, $pub_player_active, $pub_players;
	global $pub_date_rank_player_points, $pub_date_rank_player_fleet, $pub_date_rank_player_research, $pub_date_rank_ally_points, $pub_date_rank_ally_fleet, $pub_date_rank_ally_research;
	global $pub_rank_ally_active, $pub_inactif_active, $pub_vac_active, $pub_bloc_active;
	global $num_of_galaxies, $num_of_systems;
	
	
    $search_result = "erreur";
    $total_page = 0;
    $ally_protection = $allied = array();
	$request_output = "";

	$pub_date_rank_player_points = isset($pub_date_rank_player_points) ? intval($pub_date_rank_player_points) : 0;
    $pub_date_rank_player_fleet = isset($pub_date_rank_player_fleet) ? intval($pub_date_rank_player_fleet) : 0;
	$pub_date_rank_player_research = isset($pub_date_rank_player_research) ? intval($pub_date_rank_player_research) : 0;
    $pub_date_rank_ally_points = isset($pub_date_rank_ally_points) ? intval($pub_date_rank_ally_points) : 0;
	$pub_date_rank_ally_fleet = isset($pub_date_rank_ally_fleet) ? intval($pub_date_rank_ally_fleet) : 0;
	$pub_date_rank_ally_research = isset($pub_date_rank_ally_research) ? intval($pub_date_rank_ally_research) : 0;
	
    if ($server_config["ally_protection"] != "") $ally_protection = explode(",", $server_config["ally_protection"]);
	if ($server_config["allied"] != "") $allied = explode(",", $server_config["allied"]);

    if (isset($pub_galaxy_down) && isset($pub_galaxy_up) && isset($pub_system_down) && isset($pub_system_up) && 
		isset($pub_row_down) && isset($pub_row_up) && isset($pub_days) && isset($pub_rank_fleet_down) && isset($pub_rank_fleet_up) &&
		isset($pub_rank_point_down) && isset($pub_rank_point_up) && isset($pub_rank_search_down) &&
		isset($pub_rank_search_up) && isset($pub_ally_point_down) && isset($pub_ally_point_up) && isset($pub_ally_fleet_down) && 
		isset($pub_ally_fleet_up) && isset($pub_ally_search_down) && isset($pub_ally_search_up) && isset($pub_allys) && isset($pub_players) && 
		isset($pub_date_rank_player_points) && isset($pub_date_rank_player_fleet) && isset($pub_date_rank_player_research) && isset($pub_date_rank_ally_points) && isset($pub_date_rank_ally_fleet) && isset($pub_date_rank_ally_research)) {

			if (!check_var($pub_sort, "Num") || !check_var($pub_sort2, "Num") || !check_var($pub_galaxy_down, "Num") ||
			!check_var($pub_galaxy_up, "Num") || !check_var($pub_system_down, "Num") || !check_var($pub_system_up, "Num") ||
			!check_var($pub_row_down, "Num") || !check_var($pub_row_up, "Num") || !check_var($pub_days, "Num") || !check_var($pub_row_active, "Char") || !check_var($pub_ally_active, "Char") ||
			!check_var($pub_page, "Num") || !check_var($pub_rank_active, "Char") || !check_var($pub_rank_fleet_down, "Num") ||
			!check_var($pub_rank_fleet_up, "Num") || !check_var($pub_rank_point_down, "Num") || !check_var($pub_rank_point_up, "Num") ||
			!check_var($pub_rank_search_down, "Num") || !check_var($pub_rank_search_up, "Num") || !check_var($pub_ally_point_up, "Num") ||
			!check_var($pub_ally_point_down, "Num") || !check_var($pub_ally_fleet_down, "Num") || !check_var($pub_ally_fleet_up, "Num") ||
			!check_var($pub_ally_search_down, "Num") || !check_var($pub_ally_search_up, "Num") || !check_var($pub_date_rank_player_points, "Num") || 
			!check_var($pub_date_rank_player_fleet, "Num") || !check_var($pub_date_rank_player_research, "Num") || !check_var($pub_date_rank_ally_points, "Num") || !check_var($pub_date_rank_ally_fleet, "Num") || !check_var($pub_date_rank_ally_research, "Num")) {
				redirection("index.php?action=message&id_message=errordata&info");
			}
			
			user_set_stat($user_data["user_id"], null, null, null, null, 1);
			
            $galaxy_start = intval($pub_galaxy_down);
            $galaxy_end = intval($pub_galaxy_up);
            $system_start = intval($pub_system_down);
            $system_end = intval($pub_system_up);
            $row_start = intval($pub_row_down);
            $row_end = intval($pub_row_up);
			$days = intval($pub_days);
            $rank_fleet_start = intval($pub_rank_fleet_down);
            $rank_fleet_end = intval($pub_rank_fleet_up);
			$rank_point_start = intval($pub_rank_point_down);
            $rank_point_end = intval($pub_rank_point_up);
			$rank_search_start = intval($pub_rank_search_down);
            $rank_search_end = intval($pub_rank_search_up);
			$ally_point_start = intval($pub_ally_point_down);
            $ally_point_end = intval($pub_ally_point_up);
			$ally_fleet_start = intval($pub_ally_fleet_down);
            $ally_fleet_end = intval($pub_ally_fleet_up);
			$ally_search_start = intval($pub_ally_search_down);
            $ally_search_end = intval($pub_ally_search_up);
        
            if ($galaxy_start < 1 || $galaxy_start > $num_of_galaxies || $galaxy_end < 1 || $galaxy_end > $num_of_galaxies) return array($search_result, $total_page, "");
            if ($system_start < 1 || $system_start > $num_of_systems || $system_end < 1 || $system_end > $num_of_systems) return array($search_result, $total_page, "");
            if ($pub_row_active) {
				if ($row_start < 1 || $row_start > 15 || $row_end < 1 || $row_end > 15) return array($search_result, $total_page, "");
            }
			if (isset($pub_ally_active) && $pub_ally_active) {
				$ally_active = array();
				$ally_active = $pub_allys!="" ? split(",", $pub_allys) : array("?");
			}
			if (isset($pub_player_active) && $pub_player_active) {
				$player_active = array();
				$player_active = $pub_players!="" ? split(",", $pub_players) : array("?");
			}
			switch ($pub_rank_active) {
				case "fleet": 
					if ($rank_fleet_start < 1 || $rank_fleet_end < 1) return array($search_result, $total_page, "");
					else {
						$table = TABLE_RANK_PLAYER_FLEET;
						$start = $rank_fleet_start;
						$end = $rank_fleet_end;
						$date = $pub_date_rank_player_fleet;
					}
					break;
				case "general": 
					if ($rank_point_start < 1 || $rank_point_end < 1) return array($search_result, $total_page, "");
					else {
						$table = TABLE_RANK_PLAYER_POINTS;
						$start = $rank_point_start;
						$end = $rank_point_end;
						$date = $pub_date_rank_player_points;
					}
					break;
				case "research": 
					if ($rank_search_start < 1 || $rank_search_end < 1) return array($search_result, $total_page, "");
					else {
						$table = TABLE_RANK_PLAYER_RESEARCH;
						$start = $rank_search_start;
						$end = $rank_search_end;
						$date = $pub_date_rank_player_research;
					}
					break;
			}
			
			switch($pub_rank_ally_active) {
				case "allygeneral": 
					if ($ally_point_start < 1 || $ally_point_end < 1) return array($search_result, $total_page, "");
					else {
						$table2 = TABLE_RANK_ALLY_POINTS;
						$start2 = $ally_point_start;
						$end2 = $ally_point_end;
						$date2 = $pub_date_rank_ally_points;
					}
					break;
				case "allyfleet": 
					if ($ally_fleet_start < 1 || $ally_fleet_end < 1) return array($search_result, $total_page, "");
					else {
						$table2 = TABLE_RANK_ALLY_FLEET;
						$start2 = $ally_fleet_start;
						$end2 = $ally_fleet_end;
						$date2 = $pub_date_rank_ally_fleet;
					}
					break;
				case "allyresearch": 
					if ($ally_search_start < 1 || $ally_search_end < 1) return array($search_result, $total_page, "");
					else {
						$table2 = TABLE_RANK_ALLY_RESEARCH;
						$start2 = $ally_search_start;
						$end2 = $ally_search_end;
						$date2 = $pub_date_rank_ally_research;
					}
					break;
            }
            
			$coord_prefix = (isset($pub_spy_active) && $pub_spy_active)?TABLE_SPY.".spy_":TABLE_UNIVERSE.".";
			
            $select = "select count(distinct ".$coord_prefix."galaxy, ".$coord_prefix."system, ".$coord_prefix."row)";
            $request = " from ".TABLE_UNIVERSE;
			if(isset($table)) $request .= " left join ".$table." on ".TABLE_UNIVERSE.".player = ".$table.".player";
			if(isset($table2)) $request .= " left join ".$table2." on ".TABLE_UNIVERSE.".ally = ".$table2.".ally";
			if(isset($pub_spy_active) && $pub_spy_active) $request .= " left join ".TABLE_SPY." on ".TABLE_UNIVERSE.".galaxy = ".TABLE_SPY.".spy_galaxy AND ".TABLE_UNIVERSE.".system = ".TABLE_SPY.".spy_system AND ".TABLE_UNIVERSE.".row = ".TABLE_SPY.".spy_row";
			$request .= " left join ".TABLE_USER;
            $request .= " on last_update_user_id = user_id";
			$request .= " where (".$coord_prefix."galaxy between $galaxy_start and $galaxy_end)";
			$request .= " and (".$coord_prefix."system between $system_start and $system_end)";
			if ($user_auth["server_show_positionhided"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
				foreach ($ally_protection as $v) {
					$request .= " and ally <> '".mysql_real_escape_string($v)."'";
				}
			}
            if(isset($table) && isset($date) && isset($start) && isset($end)) {
				$request .= " and ".$table.".datadate = $date";
				$request .= " and (".$table.".rank between $start and $end)";
			}
			if(isset($table2) && isset($date2) && isset($start2) && isset($end2)) {
				$request .= " and ".$table2.".datadate = $date2";
				$request .= " and (".$table2.".rank between $start2 and $end2)";
			}
            if (isset($pub_row_active) && $pub_row_active) {
                $request .= " and ".$coord_prefix."row between $row_start and $row_end";
            }
			if (isset($pub_days_active) && $pub_days_active) {
                $request .= " and ".TABLE_UNIVERSE.".last_update>".(time()-($days*24*60*60));
            }
			if (isset($pub_ally_active) && $pub_ally_active && isset($ally_active)) {
				$request .= " and (";
				foreach($ally_active as $v) {
					if(check_var($v, "Galaxy")) $request .= TABLE_UNIVERSE.".ally='".mysql_escape_string($v)."' or ";
				}
				$request = substr($request, 0, strlen($request)-4).")";
			}
			if (isset($pub_player_active) && $pub_player_active && isset($player_active)) {
				$request .= " and (";
				foreach($player_active as $v) {
					if(check_var($v, "Galaxy")) $request .= TABLE_UNIVERSE.".player='".mysql_escape_string($v)."' or ";
				}
				$request = substr($request, 0, strlen($request)-4).")";
			}
			if (isset($pub_lune_active) && $pub_lune_active) $request .= " and moon='1'";
			if (isset($pub_phalanx_active) && $pub_phalanx_active) $request .= " and phalanx!='0'";
			if (isset($pub_gate_active) && $pub_gate_active) $request .= " and gate='1'";
			if (isset($pub_inactif_active) && $pub_inactif_active) $request .= " and status like '%i%'";
			if (isset($pub_vac_active) && $pub_vac_active) $request .= " and not(status like '%v%')";
			if (isset($pub_bloc_active) && $pub_bloc_active) $request .= " and not(status like '%b%')";
			
            $result = $db->sql_query($select.$request);
            list($total_row) = $db->sql_fetch_row($result);
            
            $select = "select distinct ".$coord_prefix."galaxy as galaxy, ".$coord_prefix."system as system, ".$coord_prefix."row as row, moon, phalanx, gate, last_update_moon, ".TABLE_UNIVERSE.".ally, ".TABLE_UNIVERSE.".player, status, last_update, user_name";
			if(isset($table)) $select .= ", ".$table.".rank as rankplayer, ".$table.".points as pointsplayer";
			if(isset($table2)) $select .= ", ".$table2.".rank as rankally, ".$table2.".points as pointsally";
            $request = $select.$request;

        if (isset($request)) {
			$request_output = substr($request, strlen($select));
            $order = " order by ".$coord_prefix."galaxy, ".$coord_prefix."system, ".$coord_prefix."row";
            $order2 = " asc";
            if (isset($pub_sort) && isset($pub_sort2)) {
                switch ($pub_sort2) {
                    case "0":
                    $order2 = " asc";
                    break;

                    case "1":
                    $order2 = " desc";
                    break;
                }
                switch ($pub_sort) {
                    case "1":
						$order = " order by ".$coord_prefix."galaxy".$order2.", ".$coord_prefix."system".$order2.", ".$coord_prefix."row".$order2."";
                    break;

                    case "2":
						$order = " order by ally".$order2.", player".$order2.", ".$coord_prefix."galaxy".$order2.", ".$coord_prefix."system".$order2.", ".$coord_prefix."row".$order2."";
                    break;

                    case "3":
						$order = " order by player".$order2.", ".$coord_prefix."galaxy".$order2.", ".$coord_prefix."system".$order2.", ".$coord_prefix."row".$order2."";
                    break;
					
					case "4":
						$order = "order by ";
						if(isset($table)) $order .= $table;
						elseif(isset($table2)) $order .= $table2;
						if(isset($table) || isset($table2)) $order .= ".rank".$order2.", ";
						$order .= $coord_prefix."galaxy".$order2.", ".$coord_prefix."system".$order2.", ".$coord_prefix."row".$order2."";
                    break;
                }
            }
            $request .= $order;

            if (!isset($pub_page)) {
                $page = 1;
            } else $page = $pub_page;
            $total_page = ceil($total_row / 30);
            if ($page > $total_page) $page = $total_page;
            $limit = intval($page-1) * 30;
            if ($limit < 0) {
                $limit = 0;
                $page = 1;
            }
            $request .= " LIMIT ".$limit." , 30";

            $result = $db->sql_query($request);
            $search_result = array();
            while ($row = $db->sql_fetch_assoc($result)) {
				$hided = $friend = false;
				if (in_array($row["ally"], $ally_protection)) $hided = true;
				if (in_array($row["ally"], $allied)) $friend = true;
				
				$request = "select * from ".TABLE_SPY." where active = '1' and spy_galaxy = ".$row["galaxy"]." and spy_system = ".$row["system"]." and spy_row = ".$row["row"];
                $result_2 = $db->sql_query($request);
                $report_spy = $db->sql_numrows($result_2);
				$row["rankplayer"] = (isset($row["rankplayer"]) ? $row["rankplayer"] : "-");
				$row["pointsplayer"] = (isset($row["pointsplayer"]) ? $row["pointsplayer"] : "-");
				$row["rankally"] = (isset($row["rankally"]) ? $row["rankally"] : "-");
				$row["pointsally"] = (isset($row["pointsally"]) ? $row["pointsally"] : "-");
				$search_result[] = array("galaxy" => $row["galaxy"], "system" => $row["system"], "row" => $row["row"], "phalanx" => $row["phalanx"], "gate" => $row["gate"], 
										"last_update_moon" => $row["last_update_moon"], "moon" => $row["moon"], "ally" => $row["ally"], "player" => $row["player"], "report_spy" => $report_spy, 
										"status" => $row["status"], "timestamp" => $row["last_update"], "poster" => $row["user_name"], "hided" => $hided, "allied" => $friend, 
										"rank" => $row["rankplayer"], "points" => $row["pointsplayer"], "rank ally" => $row["rankally"], "points ally" => $row["pointsally"]);
            }
        }
    } else
		$search_result = array();
    return array($search_result, $total_page, $request_output);
}

function get_pilori_players($pilo, $players) {
	$lines = explode(chr(10), $pilo);
	$og_date = array("Jan"=>1, "Feb"=>2, "Mar"=>3, "Apr"=>4, "May"=>5, "Jun"=>6, "Jul"=>7, "Aug"=>8, "Sep"=>9, "Oct"=>10, "Nov"=>11, "Dec"=>12);
	$players_already = explode(",", $players);
	foreach($lines as $line) {
		$line = trim($line);
		if(preg_match("#^\S{3}\s\S{3}\s\d{1,2}\s\S{4}\s(?:\d{1,2}:\d{1,2}:\d{1,2})\s{2,}(?:\s?\S)+\s{2,}((?:\s?\S)+)\s+\S{3}\s(\S{3})\s(\d{1,2})\s(\S{4})\s(\d{1,2}:\d{1,2}:\d{1,2})\s+((?:\s?\S)+)$#",$line,$arr)) {
			if(preg_match("/insult/i", $arr[6]) || preg_match("/spam/i", $arr[6])) {
				$h = explode(":",$arr[5]);
				$t = mktime($h[0],$h[1],$h[2],$og_date[$arr[2]],$arr[3],$arr[4]);
				if(time() < $t && (time()+60*60*24*365*2) > $t && !in_array(trim($arr[1]), $players_already)) {
					if($players == '') $players = trim($arr[1]);
					else $players .= ','.trim($arr[1]);
				}
			}
		}
	}
	return $players;
}

if(isset($pub_pilori)&& !empty($pub_pilori)) {
	if(!isset($pub_players))
		$pub_players = "";
	
	$pub_players = get_pilori_players($pub_pilori, $pub_players);
	$pub_player_active = 'on';
}

$search_result = array();
list($search_result, $total_page, $request_output) = plus_search();
if(is_string($search_result) && $search_result=="erreur") {
	echo '<script language="javascript"> erreur(); </script>';
	$search_result = array();
}

$page = (isset($pub_page)) ? $pub_page : 1;
@$sort = $pub_sort;
@$sort2 = $pub_sort2;

$link_order_coordinates = "";
$link_order_ally = "";
$link_order_player = "";
$link_order_rank = "";

$individual_ranking = array();
$individual_ranking_ally = array();

//Données recherche
$rank_active = (isset($pub_rank_active) && check_var($pub_rank_active, "Char")) ? $pub_rank_active : "";
$rank_ally_active = (isset($pub_rank_ally_active) && check_var($pub_rank_ally_active, "Char")) ? $pub_rank_ally_active : "";
$galaxy_down = isset($pub_galaxy_down) ? $pub_galaxy_down : "1";
$galaxy_up = isset($pub_galaxy_up) ? $pub_galaxy_up : $num_of_galaxies;
$system_down = isset($pub_system_down) ? $pub_system_down : "1";
$system_up = isset($pub_system_up) ? $pub_system_up : $num_of_systems;
$row_down = isset($pub_row_down) ? $pub_row_down : "";
$row_up = isset($pub_row_up) ? $pub_row_up : "";
$days_active = isset($pub_days_active) ? " checked" : "";
$days = isset($pub_days) ? $pub_days : "";
$row_active = isset($pub_row_active) ? " checked" : "";
$ally_active = isset($pub_ally_active) ? " checked" : "";
$lune_active = isset($pub_lune_active) ? " checked" : "";
$spy_active = isset($pub_spy_active) ? " checked" : "";
$phalanx_active = isset($pub_phalanx_active) ? " checked" : "";
$gate_active = isset($pub_gate_active) ? " checked" : "";
$inactif_active = isset($pub_inactif_active) ? " checked" : "";
$vac_active = isset($pub_vac_active) ? " checked" : "";
$bloc_active = isset($pub_bloc_active) ? " checked" : "";
$player_active = isset($pub_player_active) ? " checked" : "";
$allys = isset($pub_allys) ? $pub_allys : "";
$players = isset($pub_players) ? $pub_players : "";
$rank_fleet_down = isset($pub_rank_fleet_down) ? $pub_rank_fleet_down : "";
$rank_fleet_up = isset($pub_rank_fleet_up) ? $pub_rank_fleet_up : "";
$rank_fleet_active = ($rank_active == "fleet") ? " checked" : "";
$rank_point_down = isset($pub_rank_point_down) ? $pub_rank_point_down : "";
$rank_point_up = isset($pub_rank_point_up) ? $pub_rank_point_up : "";
$rank_point_active = ($rank_active == "general") ? " checked" : "";
$rank_search_down = isset($pub_rank_search_down) ? $pub_rank_search_down : "";
$rank_search_up = isset($pub_rank_search_up) ? $pub_rank_search_up : "";
$rank_search_active = ($rank_active == "research") ? " checked" : "";
$rank_null_active = ($rank_active == "") ? " checked" : "";
$ally_point_down = isset($pub_ally_point_down) ? $pub_ally_point_down : "";
$ally_point_up = isset($pub_ally_point_up) ? $pub_ally_point_up : "";
$ally_point_active = ($rank_ally_active == "allygeneral") ? " checked" : "";
$ally_fleet_down = isset($pub_ally_fleet_down) ? $pub_ally_fleet_down : "";
$ally_fleet_up = isset($pub_ally_fleet_up) ? $pub_ally_fleet_up : "";
$ally_fleet_active = ($rank_ally_active == "allyfleet") ? " checked" : "";
$ally_search_down = isset($pub_ally_search_down) ? $pub_ally_search_down : "";
$ally_search_up = isset($pub_ally_search_up) ? $pub_ally_search_up : "";
$ally_search_active = ($rank_ally_active == "allyresearch") ? " checked" : "";
$ally_null_active = ($rank_ally_active == "") ? " checked" : "";
$date_rank_player_points = isset($pub_date_rank_player_points) ? $pub_date_rank_player_points : "0";
$date_rank_player_fleet = isset($pub_date_rank_player_fleet) ? $pub_date_rank_player_fleet : "0";
$date_rank_player_research = isset($pub_date_rank_player_research) ? $pub_date_rank_player_research : "0";
$date_rank_ally_points = isset($pub_date_rank_ally_points) ? $pub_date_rank_ally_points : "0";
$date_rank_ally_fleet = isset($pub_date_rank_ally_fleet) ? $pub_date_rank_ally_fleet : "0";
$date_rank_ally_research = isset($pub_date_rank_ally_research) ? $pub_date_rank_ally_research : "0";

if ($search_result) {

	$new_sort2 = 0;
	if (isset($sort2)) {
		if ($sort2 == 0) $new_sort2 = 1;
		else $new_sort2 = 0;
	}
		$option = "&galaxy_down=".$galaxy_down;
		$option .= "&galaxy_up=".$galaxy_up;
		$option .= "&system_down=".$system_down;
		$option .= "&system_up=".$system_up;
		$option .= "&row_down=".$row_down;
		$option .= "&row_up=".$row_up;
		$option .= "&days=".$days;
		$option .= "&rank_fleet_down=".$rank_fleet_down;
		$option .= "&rank_fleet_up=".$rank_fleet_up;
		$option .= "&rank_point_down=".$rank_point_down;
		$option .= "&rank_point_up=".$rank_point_up;
		$option .= "&rank_search_down=".$rank_search_down;
		$option .= "&rank_search_up=".$rank_search_up;
		$option .= "&ally_point_down=".$ally_point_down;
		$option .= "&ally_point_up=".$ally_point_up;
		$option .= "&ally_fleet_down=".$ally_fleet_down;
		$option .= "&ally_fleet_up=".$ally_fleet_up;
		$option .= "&ally_search_down=".$ally_search_down;
		$option .= "&ally_search_up=".$ally_search_up;
		$option .= "&date_rank_player_points=".$date_rank_player_points;
		$option .= "&date_rank_player_fleet=".$date_rank_player_fleet;
		$option .= "&date_rank_player_research=".$date_rank_player_research;
		$option .= "&date_rank_ally_points=".$date_rank_ally_points;
		$option .= "&date_rank_ally_fleet=".$date_rank_ally_fleet;
		$option .= "&date_rank_ally_research=".$date_rank_ally_research;
		if ($row_active != "") $option .= "&row_active=on";
		if ($days_active != "") $option .= "&days_active=on";
		if ($ally_active != "") $option .= "&ally_active=on";
		if ($lune_active != "") $option .= "&lune_active=on";
		if ($spy_active != "") $option .= "&spy_active=on";
		if ($phalanx_active != "") $option .= "&phalanx_active=on";
		if ($gate_active != "") $option .= "&gate_active=on";
		if ($player_active != "") $option .= "&player_active=on";
		if ($inactif_active != "") $option .= "&inactif_active=on";
		if ($vac_active != "") $option .= "&vac_active=on";
		if ($bloc_active != "") $option .= "&bloc_active=on";
		$option .= "&rank_active=".$rank_active;
		$option .= "&rank_ally_active=".$rank_ally_active;
		$option .= "&allys=".$allys;
		$option .= "&players=".$allys;
		
		
		$link_order_coordinates = "<a href='index.php?action=recherche_plus&sort=1&sort2=".$new_sort2."&page=".$page.$option."'>Coordonnées";
		$link_order_ally = "<a href='index.php?action=recherche_plus&sort=2&sort2=".$new_sort2."&page=".$page.$option."'>Alliances";
		$link_order_player = "<a href='index.php?action=recherche_plus&sort=3&sort2=".$new_sort2."&page=".$page.$option."'>Joueurs";
		$link_order_rank = "<a href='index.php?action=recherche_plus&sort=4&sort2=".$new_sort2."&page=".$page.$option."'>";
		
		switch($rank_active) {
			case "fleet": 
				$link_order_rank .= "flotte";
				break;
			case "general": 
				$link_order_rank .= "général";
				break;
			case "research": 
				$link_order_rank .= "recherche";
				break;
			default:
				switch($rank_ally_active) {
					case "allygeneral":
						$link_order_rank .= "général ally";
						break;
					case "allyfleet":
						$link_order_rank .= "flotte ally";
						break;
					case "allyresearch":
						$link_order_rank .= "recherche ally";
						break;
				}
		}

		if ($sort2 == 0) {
			switch ($sort) {
				case "1" : $link_order_coordinates = "<img src='images/asc.png'>&nbsp;".$link_order_coordinates."&nbsp;<img src='images/asc.png'>";break;
				case "2" : $link_order_ally = "<img src='images/asc.png'>&nbsp;".$link_order_ally."&nbsp;<img src='images/asc.png'>";break;
				case "3" : $link_order_player = "<img src='images/asc.png'>&nbsp;".$link_order_player."&nbsp;<img src='images/asc.png'>";break;
				case "4" : $link_order_rank = "<img src='images/asc.png'>&nbsp;".$link_order_rank."&nbsp;<img src='images/asc.png'>";break;
			}
		}
		else {
			switch ($sort) {
				case "1" : $link_order_coordinates = "<img src='images/desc.png'>&nbsp;".$link_order_coordinates."&nbsp;<img src='images/desc.png'>";break;
				case "2" : $link_order_ally = "<img src='images/desc.png'>&nbsp;".$link_order_ally."&nbsp;<img src='images/desc.png'>";break;
				case "3" : $link_order_player = "<img src='images/desc.png'>&nbsp;".$link_order_player."&nbsp;<img src='images/desc.png'>";break;
				case "4" : $link_order_rank = "<img src='images/desc.png'>&nbsp;".$link_order_rank."&nbsp;<img src='images/desc.png'>";break;
			}
		}

		$link_order_coordinates .= "</a>";
		$link_order_ally .= "</a>";
		$link_order_player .= "</a>";
}

?>

<table width="90%">
<tr>
	<td valign="top">
		<table width="100%">
		<form name="search" method="POST" action="index.php">
		<input type="hidden" name="action" value="recherche_plus">
		<tr>
			<td class="c" colspan="4">Recherche plus</td>
		</tr>
		<tr>
			<th colspan="2" valign="top">
		<table width="100%">
		<tr>
			<th colspan="2" width="50%"><input type='button' onClick="javascript:plus_partout(this.form);" value="Dans tous l'univers"></th>
			<th width="25%">Minimum</th>
			<th width="25%">Maximum</th>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<th>Galaxie</th>
			<th><input name="galaxy_down" type="text" maxlength="<?php echo strlen($num_of_galaxies); ?>" size="3" value="<?php echo $galaxy_down;?>"></th>
			<th><input name="galaxy_up" type="text" maxlength="<?php echo strlen($num_of_galaxies); ?>" size="3" value="<?php echo $galaxy_up;?>"></th>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<th>Système solaire</th>
			<th><input name="system_down" type="text" maxlength="<?php echo strlen($num_of_systems); ?>" size="3" value="<?php echo $system_down;?>"></th>
			<th><input name="system_up" type="text" maxlength="<?php echo strlen($num_of_systems); ?>" size="3" value="<?php echo $system_up;?>"></th>
		</tr>
		<tr>
			<th><input name="row_active" type="checkbox"<?php echo $row_active;?>></th>
			<th>Position&nbsp;<?php echo help("recherche_plus_row");?></th>
			<th><input name="row_down" type="text" maxlength="2" size="3" value="<?php echo $row_down;?>" onkeyup="javascript:if(this.form.row_down.value!='' && this.form.row_up.value!='' ) this.form.row_active.checked='checked'; else this.form.row_active.checked='';"></th>
			<th><input name="row_up" type="text" maxlength="2" size="3" value="<?php echo $row_up;?>" onkeyup="javascript:if(this.form.row_down.value!='' && this.form.row_up.value!='' ) this.form.row_active.checked='checked'; else this.form.row_active.checked='';"></th>
		</tr>
		<tr>
			<th colspan="4">&nbsp;</th>
		</tr>
		<tr>
			<th><input name="days_active" type="checkbox"<?php echo $days_active;?>></th>
			<th>Jours d'anciennetés maximum</th>
			<th><input name="days" type="text" maxlength="3" size="3" value="<?php echo $days;?>" onkeyup="javascript:if(this.form.days.value!='') this.form.days_active.checked='checked'; else this.form.days_active.checked='';"></th>
			<th>&nbsp;</th>
		</tr>
		</table>
			</th>
			<th colspan="2" valign="top">
		<table width="100%">
		<tr>
			<th width="33%"><input name="ally_active" type="checkbox"<?php echo $ally_active;?>></th>
			<th>Alliances&nbsp;<?php echo help("recherche_plus_allys");?></th>
			<th width="33%"><input name="allys" type="text" value="<?php echo $allys;?>" onkeyup="javascript:if(this.form.allys.value!='') this.form.ally_active.checked='checked'; else this.form.ally_active.checked='';"></th>
		</tr>
		<tr>
			<th><input name="player_active" type="checkbox"<?php echo $player_active;?>></th>
			<th>Joueurs&nbsp;<?php echo help("recherche_plus_players");?></th>
			<th><input name="players" type="text" value="<?php echo $players;?>" onkeyup="javascript:if(this.form.players.value!='') this.form.player_active.checked='checked'; else this.form.player_active.checked='';"></th>
		</tr>
		<tr>
			<th colspan="3">&nbsp;</th>
		</tr>
		<tr>
			<th><input name="inactif_active" type="checkbox"<?php echo $inactif_active;?>> &nbsp;Inactif</th>
			<th><input name="vac_active" type="checkbox"<?php echo $vac_active;?>> &nbsp;Pas en mode vacance</th>
			<th><input name="bloc_active" type="checkbox"<?php echo $bloc_active;?>> &nbsp;Pas bloqué</th>
		</tr>
		<tr>
			<th><input name="lune_active" type="checkbox"<?php echo $lune_active;?>> &nbsp;Lune</th>
			<th><input name="phalanx_active" type="checkbox"<?php echo $phalanx_active;?>> &nbsp;Phalange</th>
			<th><input name="gate_active" type="checkbox"<?php echo $gate_active;?>> &nbsp;Porte</th>
		</tr>
		<tr>
			<th><input name="spy_active" type="checkbox"<?php echo $spy_active;?>> &nbsp;Espionné</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
		</table>
			</th>
		</tr>
		<tr>
			<td class="c" width="20%">Classement Joueurs:</td>
				<td class="c" align="right" width="20%"><?php plus_rank_date("rank_player_points", $date_rank_player_points);plus_rank_date("rank_player_fleet", $date_rank_player_fleet);plus_rank_date("rank_player_research", $date_rank_player_research);?></td>
			<td class="c" width="20%">Classement Alliances:</td>
				<td class="c" align="right" width="20%"><?php plus_rank_date("rank_ally_points", $date_rank_ally_points);plus_rank_date("rank_ally_fleet", $date_rank_ally_fleet);plus_rank_date("rank_ally_research", $date_rank_ally_research);?></td>
		</tr>
		<tr>
			<th colspan="2" valign="top">
		<table width="100%">
		<tr>
			<th colspan="2"></th>
			<th>Minimum</th>
			<th>Maximum</th>
		</tr>
		<tr>
			<th><input name="rank_active" value="general" type="radio"<?php echo $rank_point_active;?> onClick='plus_select("rank_player_points")'></th>
			<th>Classement général</th>
			<th><input name="rank_point_down" type="text" maxlength="4" size="4" value="<?php echo $rank_point_down;?>"></th>
			<th><input name="rank_point_up" type="text" maxlength="4" size="4" value="<?php echo $rank_point_up;?>"></th>
		</tr>
		<tr>
			<th><input name="rank_active" value="fleet" type="radio"<?php echo $rank_fleet_active;?> onClick='plus_select("rank_player_fleet")'></th>
			<th>Classement flotte</th>
			<th><input name="rank_fleet_down" type="text" maxlength="4" size="4" value="<?php echo $rank_fleet_down;?>"></th>
			<th><input name="rank_fleet_up" type="text" maxlength="4" size="4" value="<?php echo $rank_fleet_up;?>"></th>
		</tr>
		<tr>
			<th><input name="rank_active" value="research" type="radio"<?php echo $rank_search_active;?> onClick='plus_select("rank_player_research")'></th>
			<th>Classement recherche</th>
			<th><input name="rank_search_down" type="text" maxlength="4" size="4" value="<?php echo $rank_search_down;?>"></th>
			<th><input name="rank_search_up" type="text" maxlength="4" size="4" value="<?php echo $rank_search_up;?>"></th>
		</tr>
		<tr>
			<th><input name="rank_active" value="" type="radio"<?php echo $rank_null_active;?> onClick='plus_select("player")'></th>
			<th colspan='3'>Ne pas tenir compte du classement joueurs.</th>
		</tr>
		</table>
			</th>
			<th colspan="2" valign="top">
		<table width="100%">
		<tr>
			<th colspan="2"></th>
			<th>Minimum</th>
			<th>Maximum</th>
		</tr>
		<tr>
			<th><input name="rank_ally_active" value="allygeneral" type="radio"<?php echo $ally_point_active;?> onClick='plus_select("rank_ally_points")'></th>
			<th>Classement alliance générale</th>
			<th><input name="ally_point_down" type="text" maxlength="4" size="4" value="<?php echo $ally_point_down;?>"></th>
			<th><input name="ally_point_up" type="text" maxlength="4" size="4" value="<?php echo $ally_point_up;?>"></th>
		</tr>
		<tr>
			<th><input name="rank_ally_active" value="allyfleet" type="radio"<?php echo $ally_fleet_active;?> onClick='plus_select("rank_ally_fleet")'></th>
			<th>Classement alliance flotte</th>
			<th><input name="ally_fleet_down" type="text" maxlength="4" size="4" value="<?php echo $ally_fleet_down;?>"></th>
			<th><input name="ally_fleet_up" type="text" maxlength="4" size="4" value="<?php echo $ally_fleet_up;?>"></th>
		</tr>
		<tr>
			<th><input name="rank_ally_active" value="allyresearch" type="radio"<?php echo $ally_search_active;?> onClick='plus_select("rank_ally_research")'></th>
			<th>Classement alliance recherche</th>
			<th><input name="ally_search_down" type="text" maxlength="4" size="4" value="<?php echo $ally_search_down;?>"></th>
			<th><input name="ally_search_up" type="text" maxlength="4" size="4" value="<?php echo $ally_search_up;?>"></th>
		</tr>
		<tr>
			<th><input name="rank_ally_active" value="" type="radio"<?php echo $ally_null_active;?> onClick='plus_select("ally")'></th>
			<th colspan='3'>Ne pas tenir compte du classement alliances.</th>
		</tr>
		</table>
			</th>
		<tr>
			<td colspan="4" class='c'>
				Pilori univers: &nbsp;
				<select name="pilori_universe" OnChange="javascript:if(this.form.pilori_universe.value != '') window.open('http://uni'+this.form.pilori_universe.value+'.ogame.fr/game/pranger.php', 'pilori_universe', 'resizable=yes,scrollbars=yes,status=yes,width=700,height=400');return true;">
					<option value=""> - </option>
					<?php
					for($u=1; $u<=55; $u++) {
						echo "<option value=".$u.">".$u."</option>";
					}
					?>
				</select>
				&nbsp;<?php echo help("recherche_plus_pilori");?>
			</td>
		</tr>
		<tr>
			<th colspan="2">
				<textarea name="pilori" rows="2" ></textarea>
			</th>
			<th colspan="2">
				<input type='button' onClick="javascript:this.form.pilori.value = '';" value="Effacer">
			</th>
		</tr>
		<tr>
			<th colspan="4"><input type="submit" value="Chercher"></th>
		</tr>
		</form>
		</table>
	</td>
</tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr>
	<td colspan='3' align='center'>
		<table>
			<tr>
			<td colspan='4' align='left'>
<?php
if ($total_page > 1) {
	echo "\t\t\t"."<input type='button' value='<<' onclick=\"window.location = 'index.php?action=recherche_plus&sort=".$sort."&sort2=".$sort2."&page=1".$option."';\">&nbsp;";
	echo "<input type='button' value='<' onclick=\"window.location = 'index.php?action=recherche_plus&sort=".$sort."&sort2=".$sort2."&page=".($page-1).$option."';\">&nbsp;";

	echo "<input type='button' value='>' onclick=\"window.location = 'index.php?action=recherche_plus&sort=".$sort."&sort2=".$sort2."&page=".($page+1).$option."';\">&nbsp;";
	echo "<input type='button' value='>>' onclick=\"window.location = 'index.php?action=recherche_plus&sort=".$sort."&sort2=".$sort2."&page=".($total_page).$option."';\">"."\n";
}
echo "\t\t\t"."</td>"."\n";

echo "\t\t\t"."<form method='GET' action='index.php'>"."\n";
echo "\t\t\t"."<td colspan='4' align='right'>"."\n";
echo "\t\t\t"."<input type='hidden' name='action' value='recherche_plus'>"."\n";
if (isset($sort) && isset($sort2)) {
	echo "\t\t\t"."<input type='hidden' name='sort' value='".$sort."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='sort2' value='".$sort2."'>"."\n";
}
	echo "\t\t\t"."<input type='hidden' name='rank_fleet_up' value='".$rank_fleet_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='rank_fleet_down' value='".$rank_fleet_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='rank_point_up' value='".$rank_point_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='rank_point_down' value='".$rank_point_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='rank_search_up' value='".$rank_search_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='rank_search_down' value='".$rank_search_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='ally_point_up' value='".$ally_point_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='ally_point_down' value='".$ally_point_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='ally_fleet_up' value='".$ally_fleet_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='ally_fleet_down' value='".$ally_fleet_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='ally_search_up' value='".$ally_search_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='ally_search_down' value='".$ally_search_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='rank_active' value='".$rank_active."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='rank_ally_active' value='".$rank_ally_active."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='date_rank_player_points' value='".$date_rank_player_points."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='date_rank_player_fleet' value='".$date_rank_player_fleet."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='date_rank_player_research' value='".$date_rank_player_research."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='date_rank_ally_points' value='".$date_rank_ally_points."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='date_rank_ally_fleet' value='".$date_rank_ally_fleet."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='date_rank_ally_research' value='".$date_rank_ally_research."'>"."\n";
	if ($row_active != "") echo "\t\t\t"."<input type='hidden' name='row_active' value='on'>"."\n";
	if ($days_active != "") echo "\t\t\t"."<input type='hidden' name='days_active' value='on'>"."\n";
	if ($ally_active != "") echo "\t\t\t"."<input type='hidden' name='ally_active' value='on'>"."\n";
	if ($lune_active != "") echo "\t\t\t"."<input type='hidden' name='lune_active' value='on'>"."\n";
	if ($spy_active != "") echo "\t\t\t"."<input type='hidden' name='spy_active' value='on'>"."\n";
	if ($phalanx_active != "") echo "\t\t\t"."<input type='hidden' name='phalanx_active' value='on'>"."\n";
	if ($gate_active != "") echo "\t\t\t"."<input type='hidden' name='gate_active' value='on'>"."\n";
	if ($player_active != "") echo "\t\t\t"."<input type='hidden' name='player_active' value='on'>"."\n";
	if ($inactif_active != "") echo "\t\t\t"."<input type='hidden' name='inactif_active' value='on'>"."\n";
	if ($vac_active != "") echo "\t\t\t"."<input type='hidden' name='vac_active' value='on'>"."\n";
	if ($bloc_active != "") echo "\t\t\t"."<input type='hidden' name='bloc_active' value='on'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='players' value='".$players."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='allys' value='".$allys."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='galaxy_down' value='".$galaxy_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='galaxy_up' value='".$galaxy_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='system_down' value='".$system_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='system_up' value='".$system_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='row_down' value='".$row_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='row_up' value='".$row_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='days' value='".$days."'>"."\n";

if ($total_page > 1) {
	echo "\t\t\t"."<select name='page' onchange='this.form.submit();' onkeyup='this.form.submit();'>"."\n";
	for ($i=1 ; $i<=$total_page ; $i++) {
		$selected = "";
		if ($i == $page) $selected = "selected";
		echo "\t\t\t"."<option value='".$i."' ".$selected.">Page ".$i."</option>"."\n";
	}
	echo "\t\t\t"."</select>";
}
echo "\t\t\t"."</td>"."\n";
echo "\t\t\t"."</form>"."\n";

echo "\t\t"."</tr>";
?>
		<tr>
			<td class="c" width="150"><?php echo $link_order_coordinates; ?></td>
			<td class="c" width="150"><?php echo $link_order_ally; ?></td>
			<td class="c" width="150"><?php echo $link_order_player; ?></td>
			<td class="c" width="40">&nbsp;</td>
			<td class="c" width="30">&nbsp;</td>
			<td class="c" width="30">&nbsp;</td>
			<td class="c">&nbsp;</td>
			<td class='c' width='70'><?php echo $link_order_rank;?></td>
		</tr>
	
<?php
foreach ($search_result as $v) {
	$begin_hided = "";
	$end_hided = "";
	if ($v["hided"]) {
		$begin_hided = "<font color='lime'>";
		$end_hided = "</font>";
	}
	$begin_allied = "";
	$end_allied = "";
	if ($v["allied"]) {
		$begin_allied = "<blink>";
		$end_allied = "</blink>";
	}

	$coordinates = $v["galaxy"].":".$v["system"].":".$v["row"];
	$coordinates = "<a href='index.php?action=galaxy&galaxy=".$v["galaxy"]."&system=".$v["system"]."'>".$coordinates."</a>";

	if ($v["ally"] == "") $ally = "&nbsp;";
	else {
		$tooltip[$v["ally"]] = "<table width=\"250\">";
		$tooltip[$v["ally"]] .= "<tr><td colspan=\"3\" class=\"c\" align=\"center\">Alliance ".$v["ally"]."</td></tr>";
		$individual_ranking_ally = galaxy_show_ranking_unique_ally($v["ally"]);
		while ($ranking = current($individual_ranking_ally)) {
			$datadate = strftime("%d %b %Y à %Hh", key($individual_ranking_ally));
			$general_rank = isset($ranking["general"]) ?  formate_number($ranking["general"]["rank"]) : "&nbsp;";
			$general_points = isset($ranking["general"]) ? formate_number($ranking["general"]["points"]) . " <i>( ". formate_number($ranking["general"]["points_per_member"]) ." )</i>" : "&nbsp;";
			$fleet_rank = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["rank"]) : "&nbsp;";
			$fleet_points = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["points"]) . " <i>( ". formate_number($ranking["fleet"]["points_per_member"]) ." )</i>" : "&nbsp;";
			$research_rank = isset($ranking["research"]) ?  formate_number($ranking["research"]["rank"]) : "&nbsp;";
			$research_points = isset($ranking["research"]) ?  formate_number($ranking["research"]["points"]) . " <i>( ". formate_number($ranking["research"]["points_per_member"]) ." )</i>" : "&nbsp;";

			$tooltip[$v["ally"]] .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">Classement du ".$datadate."</td></tr>";
			$tooltip[$v["ally"]] .= "<tr><td class=\"c\" width=\"75\">Général</td><th width=\"30\">".$general_rank."</th><th>".$general_points."</th></tr>";
			$tooltip[$v["ally"]] .= "<tr><td class=\"c\">Flotte</td><th>".$fleet_rank."</th><th>".$fleet_points."</th></tr>";
			$tooltip[$v["ally"]] .= "<tr><td class=\"c\">Recherche</td><th>".$research_rank."</th><th>".$research_points."</th></tr>";
			$tooltip[$v["ally"]] .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">".formate_number($ranking["number_member"])." membre(s)</td></tr>";
			break;
		}
		$tooltip[$v["ally"]] .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\"><a href=\"index.php?action=search&type_search=ally&string_search=".$v["ally"]."&strict=on\">Voir détail</a></td></tr>";
		$tooltip[$v["ally"]] .= "</table>";
		$tooltip[$v["ally"]] = htmlentities($tooltip[$v["ally"]]);

		$ally = "<a href='index.php?action=search&type_search=ally&string_search=".$v["ally"]."&strict=on' onmouseover=\"this.T_WIDTH=260;this.T_TEMP=15000;return escape('".$tooltip[$v["ally"]]."')\">".$begin_allied.$begin_hided.$v["ally"].$end_hided.$end_allied."</a>";
	}

	if ($v["player"] == "") $player = "&nbsp;";
	else {
		if (!isset($tooltip[$v["player"]])) {
			$tooltip[$v["player"]] = "<table width=\"250\">";
			$tooltip[$v["player"]] .= "<tr><td colspan=\"3\" class=\"c\" align=\"center\">Joueur ".$v["player"]."</td></tr>";
			$individual_ranking_player = galaxy_show_ranking_unique_player($v["player"]);
			while ($ranking = current($individual_ranking_player)) {
				$datadate = strftime("%d %b %Y à %Hh", key($individual_ranking_player));
				$general_rank = isset($ranking["general"]) ?  formate_number($ranking["general"]["rank"]) : "&nbsp;";
				$general_points = isset($ranking["general"]) ? formate_number($ranking["general"]["points"]) : "&nbsp;";
				$fleet_rank = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["rank"]) : "&nbsp;";
				$fleet_points = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["points"]) : "&nbsp;";
				$research_rank = isset($ranking["research"]) ?  formate_number($ranking["research"]["rank"]) : "&nbsp;";
				$research_points = isset($ranking["research"]) ?  formate_number($ranking["research"]["points"]) : "&nbsp;";

				$tooltip[$v["player"]] .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">Classement du ".$datadate."</td></tr>";
				$tooltip[$v["player"]] .= "<tr><td class=\"c\" width=\"75\">Général</td><th width=\"30\">".$general_rank."</th><th>".$general_points."</th></tr>";
				$tooltip[$v["player"]] .= "<tr><td class=\"c\">Flotte</td><th>".$fleet_rank."</th><th>".$fleet_points."</th></tr>";
				$tooltip[$v["player"]] .= "<tr><td class=\"c\">Recherche</td><th>".$research_rank."</th><th>".$research_points."</th></tr>";
				break;
			}
			$tooltip[$v["player"]] .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\"><a href=\"index.php?action=search&type_search=player&string_search=".$v["player"]."&strict=on\">Voir détail</a></td></tr>";
			$tooltip[$v["player"]] .= "</table>";
			$tooltip[$v["player"]] = htmlentities($tooltip[$v["player"]]);
		}

		$player = "<a href='index.php?action=search&type_search=player&string_search=".$v["player"]."'&strict=on onmouseover=\"this.T_WIDTH=260;return escape('".$tooltip[$v["player"]]."')\">".$begin_allied.$begin_hided.$v["player"].$end_hided.$end_allied."</a>";
	}

	if ($v["status"] == "") $status = " &nbsp;";
	else $status = $v["status"];

	if ($v["moon"] == 1) {
		$moon = "M";
		$detail = "";
		if ($v["last_update_moon"] > 0) {
			$detail .= $v["phalanx"];
		}
		if ($v["gate"] == 1) {
			$detail .= "P";
		}
		if ($detail != "") $moon .= " - ".$detail;
	}
	else $moon = "&nbsp;";

	if ($v["report_spy"] > 0) $report_spy = "<A HREF=\"#\" onClick=\"window.open('index.php?action=show_reportspy&galaxy=".$v["galaxy"]."&system=".$v["system"]."&row=".$v["row"]."','_blank','width=640, height=480, toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=0');return(false)\">".$v["report_spy"]."E</A>";
	else $report_spy = "&nbsp;";

	$timestamp = $v["timestamp"];

	$poster = "&nbsp;";
	if ($timestamp != 0) {
		$timestamp = strftime("%d %b %Y %H:%M", $timestamp);
		$poster = $timestamp." - ".$v["poster"];
	}

	if ($v["player"] != "" && $rank_active != "") {
		if($v["points"] != "-") $points = formate_number($v["points"])." (".formate_number($v["rank"]).")";
		else $points = "- (-)";
	} elseif ($v["player"] != "" && $rank_ally_active != "") {
		if($v["points ally"] != "-") $points = formate_number($v["points ally"])." (".formate_number($v["rank ally"]).")";
		else $points = "- (-)";
	} else {
		$points = "-";
	}

	echo "\t\t"."<tr>"."\n";
	echo "\t\t\t"."<th>".$coordinates."</th>"."\n";
	echo "\t\t\t"."<th>".$ally."</th>"."\n";
	echo "\t\t\t"."<th>".$player."</th>"."\n";
	echo "\t\t\t"."<th>".$status."</th>"."\n";
	echo "\t\t\t"."<th>".$moon."</th>"."\n";
	echo "\t\t\t"."<th>".$report_spy."</th>"."\n";
	echo "\t\t\t"."<th>".$poster."</th>"."\n";
	echo "\t\t\t"."<th>".$points."</th>"."\n";
	echo "\t\t"."</tr>"."\n";
}

$legend = "<table width=\"225\">";
$legend .= "<tr><td class=\"c\" colspan=\"2\" align=\"center\" width=\"150\">Légende</td></tr>";
$legend .= "<tr><td class=\"c\">Inactif 7 jours</td><th>i</th></tr>";
$legend .= "<tr><td class=\"c\">Inactif 28 jours</td><th>I</th></tr>";
$legend .= "<tr><td class=\"c\">Joueur faible</td><th>d</th></tr>";
$legend .= "<tr><td class=\"c\">Lune<br><i>phalange 4 avec porte spatial</i></td><th>M - 4P</th></tr>";
$legend .= "<tr><td class=\"c\">Rapport d\'espionnage</td><th>xE</th></tr>";
$legend .= "<tr><td class=\"c\">Joueur / Alliance allié</td><th><blink><a>abc</a></blink></th></tr>";
$legend .= "<tr><td class=\"c\">Joueur / Alliance masqué</td><th><blink><font color=\"lime\">abc</font></blink></th></tr>";
$legend .= "</table>";
$legend = htmlentities($legend);

echo "<tr align='center'><td class='c' colspan='8'><a style='cursor:pointer' onmouseover=\"this.T_WIDTH=210;this.T_STICKY=true;this.T_TEMP=0;return escape('".$legend."');\">Légende</a></td></tr>";

echo "\t\t"."<tr>";

echo "\t\t\t"."<td colspan='4' align='left' width='50%'>"."\n";
if ($total_page > 1) {
	
	echo "\t\t\t"."<input type='button' value='<<' onclick=\"window.location = 'index.php?action=recherche_plus&sort=".$sort."&sort2=".$sort2."&page=1".$option."';\">&nbsp;";
	echo "<input type='button' value='<' onclick=\"window.location = 'index.php?action=recherche_plus&sort=".$sort."&sort2=".$sort2."&page=".($page-1).$option."';\">&nbsp;";

	echo "<input type='button' value='>' onclick=\"window.location = 'index.php?action=recherche_plus&sort=".$sort."&sort2=".$sort2."&page=".($page+1).$option."';\">&nbsp;";
	echo "<input type='button' value='>>' onclick=\"window.location = 'index.php?action=recherche_plus&sort=".$sort."&sort2=".$sort2."&page=".($total_page).$option."';\">"."\n";
}
echo "\t\t\t"."</td>"."\n";

echo "\t\t\t"."<form method='GET' action='index.php'>"."\n";
echo "\t\t\t"."<td colspan='4' align='right' width='50%'>"."\n";
echo "\t\t\t"."<input type='hidden' name='action' value='recherche_plus'>"."\n";
if (isset($sort) && isset($sort2)) {
	echo "\t\t\t"."<input type='hidden' name='sort' value='".$sort."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='sort2' value='".$sort2."'>"."\n";
}
	echo "\t\t\t"."<input type='hidden' name='rank_fleet_up' value='".$rank_fleet_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='rank_fleet_down' value='".$rank_fleet_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='rank_point_up' value='".$rank_point_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='rank_point_down' value='".$rank_point_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='rank_search_up' value='".$rank_search_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='rank_search_down' value='".$rank_search_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='ally_point_up' value='".$ally_point_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='ally_point_down' value='".$ally_point_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='ally_fleet_up' value='".$ally_fleet_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='ally_fleet_down' value='".$ally_fleet_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='ally_search_up' value='".$ally_search_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='ally_search_down' value='".$ally_search_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='rank_active' value='".$rank_active."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='rank_ally_active' value='".$rank_ally_active."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='date_rank_player_points' value='".$date_rank_player_points."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='date_rank_player_fleet' value='".$date_rank_player_fleet."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='date_rank_player_research' value='".$date_rank_player_research."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='date_rank_ally_points' value='".$date_rank_ally_points."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='date_rank_ally_fleet' value='".$date_rank_ally_fleet."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='date_rank_ally_research' value='".$date_rank_ally_research."'>"."\n";
	if ($row_active != "") echo "\t\t\t"."<input type='hidden' name='row_active' value='on'>"."\n";
	if ($days_active != "") echo "\t\t\t"."<input type='hidden' name='days_active' value='on'>"."\n";
	if ($ally_active != "") echo "\t\t\t"."<input type='hidden' name='ally_active' value='on'>"."\n";
	if ($lune_active != "") echo "\t\t\t"."<input type='hidden' name='lune_active' value='on'>"."\n";
	if ($spy_active != "") echo "\t\t\t"."<input type='hidden' name='spy_active' value='on'>"."\n";
	if ($phalanx_active != "") echo "\t\t\t"."<input type='hidden' name='phalanx_active' value='on'>"."\n";
	if ($gate_active != "") echo "\t\t\t"."<input type='hidden' name='gate_active' value='on'>"."\n";
	if ($player_active != "") echo "\t\t\t"."<input type='hidden' name='player_active' value='on'>"."\n";
	if ($inactif_active != "") echo "\t\t\t"."<input type='hidden' name='inactif_active' value='on'>"."\n";
	if ($vac_active != "") echo "\t\t\t"."<input type='hidden' name='vac_active' value='on'>"."\n";
	if ($bloc_active != "") echo "\t\t\t"."<input type='hidden' name='bloc_active' value='on'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='players' value='".$players."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='allys' value='".$allys."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='galaxy_down' value='".$galaxy_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='galaxy_up' value='".$galaxy_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='system_down' value='".$system_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='system_up' value='".$system_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='row_down' value='".$row_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='row_up' value='".$row_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='days' value='".$days."'>"."\n";

if ($total_page > 1) {
	echo "\t\t\t"."<select name='page' onchange='this.form.submit();' onkeyup='this.form.submit();'>"."\n";
	for ($i=1 ; $i<=$total_page ; $i++) {
		$selected = "";
		if ($i == $page) $selected = "selected";
		echo "\t\t\t"."<option value='".$i."' ".$selected.">Page ".$i."</option>"."\n";
	}
	echo "\t\t\t"."</select>";
}
echo "\t\t\t"."</td>"."\n";
echo "\t\t\t"."</form>"."\n";

echo "\t\t"."</tr>";
?>
		</table>
<?php
if (function_exists('imagecreatetruecolor') !== FALSE) {
	if($request_output!="" && $search_result) {
		
		$galaxy_nb = $galaxy_up - $galaxy_down + 1;
		
		if($galaxy_nb>=1 && $galaxy_nb<=2)
			$div_nb = 10;
		elseif($galaxy_nb>=3 && $galaxy_nb<=4)
			$div_nb = 5;
		elseif($galaxy_nb>=5 && $galaxy_nb<=10)
			$div_nb = 2;
		elseif($galaxy_nb>=11 && $galaxy_nb<=25)
			$div_nb = 1;
		elseif($galaxy_nb>=26)
			$div_nb = 1/2;
		else
			$div_nb = 2;
		
		$repartition = array();
		
		for($i=0; $i<($galaxy_nb*$div_nb); $i++) {
			$repartition[$i] = 0;
		}
		
		$j = 0;
		$coord_prefix = (isset($pub_spy_active) && $pub_spy_active)?TABLE_SPY.".spy_":TABLE_UNIVERSE.".";
		for($i=0; $i<$div_nb; $i++) {
			$s_up = (($num_of_systems+$num_of_systems%2)/$div_nb)*($i+1);
			$s_down = ((($num_of_systems+$num_of_systems%2)/$div_nb)*$i)+1;
			
			$request = "select count(distinct ".$coord_prefix."galaxy, ".$coord_prefix."system, ".$coord_prefix."row), ".$coord_prefix."galaxy ".$request_output." and ".$coord_prefix."system between ".$s_down." and ".$s_up." group by ".$coord_prefix."galaxy order by ".$coord_prefix."galaxy";
			
			$result = $db->sql_query($request);
			while(list($v, $g) = $db->sql_fetch_row($result)) {
				while($j<($g-$galaxy_down+($galaxy_nb*$i)))
					$j++;
				$repartition[floor($j*($div_nb<1?$div_nb:1))] += $v;
				$j++;
			}
		}
		
		echo "<br /><img src='index.php?action=recherche_plus&graph=barre&repartition=".implode(":",$repartition)."&div_nb=".($div_nb<1?((-1)/$div_nb):$div_nb)."&galaxy_down=".$galaxy_down."' alt='pas de graphique disponible' />";
	}
} else echo "<br /><span style='font-size:10px;'>Graphique indisponible car une option de php n'est pas disponible.</span>";
?>
	</td>
</tr>
</table>
<script language="javascript"><!--
	<?php
		if(!isset($rank_active)) $rank_active="";
		
		switch($rank_active) {
			case "general":
				echo "plus_select('rank_player_points');\n";
				break;
			case "fleet":
				echo "plus_select('rank_player_fleet');\n";
				break;
			case "research":
				echo "plus_select('rank_player_research');\n";
				break;
		}
		switch($rank_ally_active) {
			case "allygeneral":
				echo "plus_select('rank_ally_points');\n";
				break;
			case "allyfleet":
				echo "plus_select('rank_ally_fleet');\n";
				break;
			case "allyresearch":
				echo "plus_select('rank_ally_research');\n";
				break;
		}
	?>
//--></script>
<?php
echo "<center><p><b>MOD Recherche Plus v$mod_version par <font color='lime'>ben.12</font></b></p></center>";
require_once("views/page_tail.php");
?>