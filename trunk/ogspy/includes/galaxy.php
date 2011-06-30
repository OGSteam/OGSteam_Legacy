<?php
/** $Id$ **/
/**
* Fonctions relatives aux données galaxies/planètes
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 3.05 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

// fichier des fonctions MIP (christ24)
require_once("galaxybis.php");

/**
* Vérification des droits OGSpy
* @param string $action Droit interrogé
*/

function galaxy_check_auth($action) {
	global $user_data, $user_auth;

	switch ($action) {
		case "import_planet":
		if ($user_auth["ogs_set_system"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		die("<!-- [AccessDenied] Accès refusé -->"."\n"."<!-- Vous n'avez pas les droits pour exporter des systèmes solaires -->"."\n");
		break;

		case "export_planet":
		if ($user_auth["ogs_get_system"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		die("<!-- [AccessDenied] Accès refusé -->"."\n"."<!-- Vous n'avez pas les droits pour importer des systèmes solaires -->"."\n");
		break;

		case "import_spy":
		if ($user_auth["ogs_set_spy"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		die("<!-- [AccessDenied] Accès refusé -->"."\n"."<!-- Vous n'avez pas les droits pour exporter des rapports d'espionnage -->"."\n");
		break;

		case "export_spy":
		if ($user_auth["ogs_get_spy"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		die("<!-- [AccessDenied] Accès refusé -->"."\n"."<!-- Vous n'avez pas les droits pour importer des rapports d'espionnage -->"."\n");
		break;

		case "import_ranking":
		if ($user_auth["ogs_set_ranking"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		die("<!-- [AccessDenied] Accès refusé -->"."\n"."<!-- Vous n'avez pas les droits pour exporter des classements -->"."\n");
		break;

		case "export_ranking":
		if ($user_auth["ogs_get_ranking"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		die("<!-- [AccessDenied] Accès refusé -->"."\n"."<!-- Vous n'avez pas les droits pour importer des classements -->"."\n");
		break;

		case "drop_ranking" :
		if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_ranking"] != 1)
			redirection("index.php?action=message&id_message=forbidden&info");
		break;

		case "set_ranking" :
		if (($user_auth["server_set_ranking"] != 1) && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
			redirection("index.php?action=message&id_message=forbidden&info");
		break;

		case "set_rc" :
		if (($user_auth["server_set_rc"] != 1) && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
			redirection("index.php?action=message&id_message=forbidden&info");
		break;

		default:
		die ("<!-- [ErrorFatal=18] Données transmises incorrectes  -->");
	}
}

/**
* Affichage des galaxies
* @global $pub_galaxy
* @global $pub_system
* @global $pub_coordinates
*/
function galaxy_show() {
	global $db, $user_data, $user_auth, $server_config;
	global $pub_galaxy, $pub_system, $pub_coordinates;
	if (isset($pub_coordinates)) {
		@list($pub_galaxy, $pub_system) = explode(":", $pub_coordinates);
	}
	if (isset($pub_galaxy) && isset($pub_system)) {
		if (intval($pub_galaxy) < 1) $pub_galaxy = 1;
		if (intval($pub_galaxy) > intval($server_config['num_of_galaxies'])) $pub_galaxy = intval($server_config['num_of_galaxies']);
		if (intval($pub_system) < 1) $pub_system = 1;
		if (intval($pub_system) > intval($server_config['num_of_systems'])) $pub_system = intval($server_config['num_of_systems']);
	}

	$ally_protection = $allied = array();
	if ($server_config["ally_protection"] != "") $ally_protection = explode(",", $server_config["ally_protection"]);
	if ($server_config["allied"] != "") $allied = explode(",", $server_config["allied"]);

	if (!isset($pub_galaxy) || !isset($pub_system)) {
		$pub_galaxy = $user_data["user_galaxy"];
		$pub_system = $user_data["user_system"];

		if ($pub_galaxy == 0 || $pub_system == 0) {
			$pub_galaxy = 1;
			$pub_system = 1;
		}
	}

	$request = "select row, name, ally, player, moon, phalanx, gate, last_update_moon, status, last_update, user_name";
	$request .= " from ".TABLE_UNIVERSE." left join ".TABLE_USER;
	$request .= " on user_id = last_update_user_id";
	$request .= " where galaxy = $pub_galaxy and system = $pub_system order by row";
	$result = $db->sql_query($request);

	$population = array_fill(1, 15,  array("ally" => "", "player" => "", "moon" => "", "last_update_moon" => "", "phalanx" => "", "gate" => "", "planet" => "", "report_spy" => false, "status" => "", "timestamp" => "", "poster" => "", "hided" => "", "allied" => ""));
	while (list($row, $planet, $ally, $player, $moon, $phalanx, $gate, $last_update_moon, $status, $timestamp, $poster) = $db->sql_fetch_row($result)) {
		$report_spy = 0;
		$request = "select id_spy from ".TABLE_PARSEDSPY." where active = '1' and coordinates = '$pub_galaxy:$pub_system:$row'";
		$result_2 = $db->sql_query($request);
		if ($db->sql_numrows($result_2) > 0) $report_spy = $db->sql_numrows($result_2);
		$report_rc = 0;
		$request = "select id_rc from ".TABLE_PARSEDRC." where coordinates = '$pub_galaxy:$pub_system:$row'";
		$result_2 = $db->sql_query($request);
		if ($db->sql_numrows($result_2) > 0) $report_rc = $db->sql_numrows($result_2);

		if (!in_array($ally, $ally_protection) || $ally == "" || $user_auth["server_show_positionhided"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
			$hided = $friend = false;
			if (in_array($ally, $ally_protection)) $hided = true;
			if (in_array($ally, $allied)) $friend = true;

			$population[$row] = array("ally" => $ally, "player" => $player, "moon" => $moon, "phalanx" => $phalanx, "gate" => $gate, "last_update_moon" => $last_update_moon, "planet" => $planet, "report_spy" => $report_spy, "status" => $status, "timestamp" => $timestamp, "poster" => $poster, "hided" => $hided, "allied" => $friend, "report_rc" => $report_rc);
		}
		elseif (in_array($ally, $ally_protection)) {
			$population[$row] = array("ally" => "", "player" => "", "moon" => "", "phalanx" => "", "gate" => "", "last_update_moon" => "", "planet" => "", "report_spy" => "", "status" => "", "timestamp" => $timestamp, "poster" => $poster, "hided" => "", "allied" => "", "report_rc" => $report_rc);
		}
	}

	return array("population" => $population, "galaxy" => $pub_galaxy, "system" => $pub_system);
}

/**
* Affichage des systèmes
*/
function galaxy_show_sector() {
	global $db, $server_config, $user_data, $user_auth;
	global $pub_galaxy, $pub_system_down, $pub_system_up;

	if (isset($pub_galaxy) && isset($pub_system_down) && isset($pub_system_up)) {
		if (intval($pub_galaxy) < 1) $pub_galaxy = 1;
		if (intval($pub_galaxy) > intval($server_config['num_of_galaxies'])) $pub_galaxy = intval($server_config['num_of_galaxies']);
		if (intval($pub_system_down) < 1) $pub_system_down = 1;
		if (intval($pub_system_down) > intval($server_config['num_of_systems'])) $pub_system_down = intval($server_config['num_of_systems']);
		if (intval($pub_system_up) < 1) $pub_system_up = 1;
		if (intval($pub_system_up) > intval($server_config['num_of_systems'])) $pub_system_up = intval($server_config['num_of_systems']);
	}

	if (!isset($pub_galaxy) || !isset($pub_system_down) || !isset($pub_system_up)) {
		$pub_galaxy = 1;
		$pub_system_down = 1;
		$pub_system_up = 25;
	}

	$ally_protection = $allied = array();
	if ($server_config["ally_protection"] != "") $ally_protection = explode(",", $server_config["ally_protection"]);
	if ($server_config["allied"] != "") $allied = explode(",", $server_config["allied"]);

	$request = "select system, row, name, ally, player, moon, phalanx, gate, last_update_moon, status, last_update";
	$request .= " from ".TABLE_UNIVERSE;
	$request .= " where galaxy = $pub_galaxy and system between ".$pub_system_down." and ".$pub_system_up;
	$request .= " order by system, row";
	$result = $db->sql_query($request);

	$population = array_fill($pub_system_down, $pub_system_up,  "");
	while (list($system, $row, $planet, $ally, $player, $moon, $phalanx, $gate, $last_update_moon, $status, $update) = $db->sql_fetch_row($result)) {
		if (!isset($last_update[$system])) $last_update[$system] = $update;
		elseif ($update < $last_update[$system]) $last_update[$system] = $update;

		$report_spy = 0;
		$request = "select * from ".TABLE_PARSEDSPY." where active = '1' and coordinates = '$pub_galaxy:$system:$row'";
		$result_2 = $db->sql_query($request);
		if ($db->sql_numrows($result_2) > 0) $report_spy = $db->sql_numrows($result_2);

		if (!in_array($ally, $ally_protection) || $ally == "" || $user_auth["server_show_positionhided"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
			$hided = $friend = false;
			if (in_array($ally, $ally_protection)) $hided = true;
			if (in_array($ally, $allied)) $friend = true;

			$population[$system][$row] = array("ally" => $ally, "player" => $player, "moon" => $moon, "phalanx" => $phalanx, "gate" => $gate, "last_update_moon" => $last_update_moon, "planet" => $planet, "report_spy" => $report_spy, "status" => $status, "hided" => $hided, "allied" => $friend);
		}
	}

	while ($value = @current($last_update)) {
		$population[key($last_update)]["last_update"] = $value;
		next($last_update);
	}

	return array("population" => $population, "galaxy" => $pub_galaxy, "system_down" => $pub_system_down, "system_up" => $pub_system_up);
}

/**
* Fonctions de recherches
*/
function galaxy_search() {
	global $db, $user_data, $user_auth, $server_config;
	global $pub_string_search, $pub_type_search, $pub_strict, $pub_sort, $pub_sort2, $pub_galaxy_down, $pub_galaxy_up, $pub_system_down, $pub_system_up, $pub_row_down, $pub_row_up, $pub_row_active, $pub_page;

	if (!check_var($pub_string_search, "Text") || !check_var($pub_type_search, "Char") || !check_var($pub_strict, "Char") ||
	!check_var($pub_sort, "Num") || !check_var($pub_sort2, "Num") || !check_var($pub_galaxy_down, "Num") ||
	!check_var($pub_galaxy_up, "Num") || !check_var($pub_system_down, "Num") || !check_var($pub_system_up, "Num") ||
	!check_var($pub_row_down, "Num") || !check_var($pub_row_up, "Num") || !check_var($pub_row_active, "Char") ||
	!check_var($pub_page, "Num")) {
		redirection("index.php?action=message&id_message=errordata&info");
	}

	$search_result = array();
	$total_page = 0;
	$ally_protection = $allied = array();
	if ($server_config["ally_protection"] != "") $ally_protection = explode(",", $server_config["ally_protection"]);
	if ($server_config["allied"] != "") $allied = explode(",", $server_config["allied"]);

	if (isset($pub_type_search) && (isset($pub_string_search) || (isset($pub_galaxy_down) && isset($pub_galaxy_up) && isset($pub_system_down) && isset($pub_system_up) && isset($pub_row_down) && isset($pub_row_up)))) {
		user_set_stat(null, null, 1);

		switch ($pub_type_search) {
			case "player" :
			if ($pub_string_search == "") break;
			$search = isset($pub_strict) ? $pub_string_search : "%".$pub_string_search."%";

			$select = "select count(*)";
			$request = " from ".TABLE_UNIVERSE." left join ".TABLE_USER;
			$request .= " on last_update_user_id = user_id";
			$request .= " where player like '".mysql_real_escape_string($search)."'";
			if ($user_auth["server_show_positionhided"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
				foreach ($ally_protection as $v) {
					$request .= " and ally <> '".mysql_real_escape_string($v)."'";
				}
			}

			$result = $db->sql_query($select.$request);
			list($total_row) = $db->sql_fetch_row($result);

			$select = "select galaxy, system, row, moon, phalanx, gate, last_update_moon, ally, player, status, last_update, user_name";
			$request = $select.$request;
			break;

			case "ally" :
			if ($pub_string_search == "") break;
			$search = isset($pub_strict) ? $pub_string_search : "%".$pub_string_search."%";

			$select = "select count(*)";
			$request = " from ".TABLE_UNIVERSE." left join ".TABLE_USER;
			$request .= " on last_update_user_id = user_id";
			$request .= " where ally like '".mysql_real_escape_string($search)."'";
			if ($user_auth["server_show_positionhided"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
				foreach ($ally_protection as $v) {
					$request .= " and ally <> '".mysql_real_escape_string($v)."'";
				}
			}

			$result = $db->sql_query($select.$request);
			list($total_row) = $db->sql_fetch_row($result);

			$select = "select galaxy, system, row, moon, phalanx, gate, last_update_moon, ally, player, status, last_update, user_name";
			$request = $select.$request;
			break;

			case "planet" :
			if ($pub_string_search == "") break;
			$search = isset($pub_strict) ? $pub_string_search : "%".$pub_string_search."%";

			$select = "select count(*)";
			$request = " from ".TABLE_UNIVERSE." left join ".TABLE_USER;
			$request .= " on last_update_user_id = user_id";
			$request .= " where name like '".mysql_real_escape_string($search)."'";
			if ($user_auth["server_show_positionhided"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
				foreach ($ally_protection as $v) {
					$request .= " and ally <> '".mysql_real_escape_string($v)."'";
				}
			}

			$result = $db->sql_query($select.$request);
			list($total_row) = $db->sql_fetch_row($result);

			$select = "select galaxy, system, row, moon, phalanx, gate, last_update_moon, ally, player, status, last_update, user_name";
			$request = $select.$request;
			break;

			case "colonization" :
			$galaxy_start = intval($pub_galaxy_down);
			$galaxy_end = intval($pub_galaxy_up);
			$system_start = intval($pub_system_down);
			$system_end = intval($pub_system_up);
			$row_start = intval($pub_row_down);
			$row_end = intval($pub_row_up);

			if ($galaxy_start < 1 || $galaxy_start > intval($server_config['num_of_galaxies']) || $galaxy_end < 1 || $galaxy_end > intval($server_config['num_of_galaxies'])) break;
			if ($system_start < 1 || $system_start > intval($server_config['num_of_systems']) || $system_end < 1 || $system_end > intval($server_config['num_of_systems'])) break;
			if ($pub_row_active) {
				if ($row_start < 1 || $row_start > 15 || $row_end < 1 || $row_end > 15) break;
			}

			$select = "select count(*)";
			$request = " from ".TABLE_UNIVERSE." left join ".TABLE_USER;
			$request .= " on last_update_user_id = user_id";
			$request .= " where player = ''";
			$request .= " and galaxy between $galaxy_start and $galaxy_end";
			$request .= " and system between $system_start and $system_end";
			if ($pub_row_active) {
				$request .= " and row between $row_start and $row_end";
			}

			$result = $db->sql_query($select.$request);
			list($total_row) = $db->sql_fetch_row($result);

			$select = "select galaxy, system, row, moon, phalanx, gate, last_update_moon, ally, player, status, last_update, user_name";
			$request = $select.$request;
			break;

			case "moon" :
			$galaxy_start = intval($pub_galaxy_down);
			$galaxy_end = intval($pub_galaxy_up);
			$system_start = intval($pub_system_down);
			$system_end = intval($pub_system_up);
			$row_start = intval($pub_row_down);
			$row_end = intval($pub_row_up);

			if ($galaxy_start < 1 || $galaxy_start > intval($server_config['num_of_galaxies']) || $galaxy_end < 1 || $galaxy_end > intval($server_config['num_of_galaxies'])) break;
			if ($system_start < 1 || $system_start > intval($server_config['num_of_systems']) || $system_end < 1 || $system_end > intval($server_config['num_of_systems'])) break;
			if ($pub_row_active) {
				if ($row_start < 1 || $row_start > 15 || $row_end < 1 || $row_end > 15) break;
			}

			$select = "select count(*)";
			$request = " from ".TABLE_UNIVERSE." left join ".TABLE_USER;
			$request .= " on last_update_user_id = user_id";
			$request .= " where moon = '1'";
			$request .= " and galaxy between $galaxy_start and $galaxy_end";
			$request .= " and system between $system_start and $system_end";
			if ($pub_row_active) {
				$request .= " and row between $row_start and $row_end";
			}
			if ($user_auth["server_show_positionhided"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
				foreach ($ally_protection as $v) {
					$request .= " and ally <> '".mysql_real_escape_string($v)."'";
				}
			}

			$result = $db->sql_query($select.$request);
			list($total_row) = $db->sql_fetch_row($result);

			$select = "select galaxy, system, row, moon, phalanx, gate, last_update_moon, ally, player, status, last_update, user_name";
			$request = $select.$request;
			break;

			case "away" :
			$galaxy_start = intval($pub_galaxy_down);
			$galaxy_end = intval($pub_galaxy_up);
			$system_start = intval($pub_system_down);
			$system_end = intval($pub_system_up);
			$row_start = intval($pub_row_down);
			$row_end = intval($pub_row_up);

			if ($galaxy_start < 1 || $galaxy_start > intval($server_config['num_of_galaxies']) || $galaxy_end < 1 || $galaxy_end > intval($server_config['num_of_galaxies'])) break;
			if ($system_start < 1 || $system_start > intval($server_config['num_of_systems']) || $system_end < 1 || $system_end > intval($server_config['num_of_systems'])) break;
			if ($pub_row_active) {
				if ($row_start < 1 || $row_start > 15 || $row_end < 1 || $row_end > 15) break;
			}

			$select = "select count(*)";
			$request = " from ".TABLE_UNIVERSE." left join ".TABLE_USER;
			$request .= " on last_update_user_id = user_id";
			$request .= " where status like ('%i%')";
			$request .= " and galaxy between $galaxy_start and $galaxy_end";
			$request .= " and system between $system_start and $system_end";
			if ($pub_row_active) {
				$request .= " and row between $row_start and $row_end";
			}
			if ($user_auth["server_show_positionhided"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
				foreach ($ally_protection as $v) {
					$request .= " and ally <> '".mysql_real_escape_string($v)."'";
				}
			}

			$result = $db->sql_query($select.$request);
			list($total_row) = $db->sql_fetch_row($result);

			$select = "select galaxy, system, row, moon, phalanx, gate, last_update_moon, ally, player, status, last_update, user_name";
			$request = $select.$request;
			break;

			case "spy" :
			$galaxy_start = intval($pub_galaxy_down);
			$galaxy_end = intval($pub_galaxy_up);
			$system_start = intval($pub_system_down);
			$system_end = intval($pub_system_up);
			$row_start = intval($pub_row_down);
			$row_end = intval($pub_row_up);

			if ($galaxy_start < 1 || $galaxy_start > intval($server_config['num_of_galaxies']) || $galaxy_end < 1 || $galaxy_end > intval($server_config['num_of_galaxies'])) break;
			if ($system_start < 1 || $system_start > intval($server_config['num_of_systems']) || $system_end < 1 || $system_end > intval($server_config['num_of_systems'])) break;
			if ($pub_row_active) {
				if ($row_start < 1 || $row_start > 15 || $row_end < 1 || $row_end > 15) break;
			}

			$select = "select count(distinct spy_galaxy, spy_system, spy_row)";
			$request = " from ".TABLE_SPY.", ".TABLE_UNIVERSE." left join ".TABLE_USER;
			$request .= " on last_update_user_id = user_id";
			$request .= " where active = '1'";
			$request .= " and galaxy = spy_galaxy";
			$request .= " and system = spy_system";
			$request .= " and row = spy_row";
			$request .= " and galaxy between $galaxy_start and $galaxy_end";
			$request .= " and system between $system_start and $system_end";
			if ($pub_row_active) {
				$request .= " and spy_row between $row_start and $row_end";
			}
			if ($user_auth["server_show_positionhided"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
				foreach ($ally_protection as $v) {
					$request .= " and ally <> '".mysql_real_escape_string($v)."'";
				}
			}

			$result = $db->sql_query($select.$request);
			list($total_row) = $db->sql_fetch_row($result);

			$select = "select distinct galaxy, system, row, moon, phalanx, gate, last_update_moon, ally, player, status, last_update, user_name";
			$request = $select.$request;
			break;
		}

		if (isset($request)) {
			$order = " order by galaxy, system, row";
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
					$order = " order by galaxy".$order2.", system".$order2.", row".$order2."";
					break;

					case "2":
					$order = " order by ally".$order2.", player".$order2.", galaxy".$order2.", system".$order2.", row".$order2."";
					break;

					case "3":
					$order = " order by player".$order2.", galaxy".$order2.", system".$order2.", row".$order2."";
					break;
				}
			}
			$request .= $order;

			if (!isset($pub_page)) {
				$pub_page = 1;
			}
			$total_page = ceil($total_row / 30);
			if ($pub_page > $total_page) $pub_page = $total_page;
			$limit = intval($pub_page-1) * 30;
			if ($limit < 0) {
				$limit = 0;
				$pub_page = 1;
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
				$search_result[] = array("galaxy" => $row["galaxy"], "system" => $row["system"], "row" => $row["row"], "phalanx" => $row["phalanx"], "gate" => $row["gate"], "last_update_moon" => $row["last_update_moon"], "moon" => $row["moon"], "ally" => $row["ally"], "player" => $row["player"], "report_spy" => $report_spy, "status" => $row["status"], "timestamp" => $row["last_update"], "poster" => $row["user_name"], "hided" => $hided, "allied" => $friend);
			}
		}
	}
	return array($search_result, $total_page);
}

/**
* Récupération des statistiques des galaxies
*/
function galaxy_statistic($step = 50) {
	global $db, $user_data, $server_config;

	$nb_planets_total = 0;
	$nb_freeplanets_total = 0;
	for ($galaxy=1 ; $galaxy<=intval($server_config['num_of_galaxies']) ; $galaxy++) {
		for ($system=1 ; $system<=intval($server_config['num_of_systems']) ; $system=$system+$step) {
			$request = "select count(*) from ".TABLE_UNIVERSE;
			$request .= " where galaxy = ".$galaxy;
			$request .= " and system between ".$system." and ".($system+$step-1);
			$result = $db->sql_query($request);
			list($nb_planet) = $db->sql_fetch_row($result);
			$nb_planets_total += $nb_planet;

			$request = "select count(*) from ".TABLE_UNIVERSE;
			$request .= " where player = ''";
			$request .= " and galaxy = ".$galaxy;
			$request .= " and system between ".$system." and ".($system+$step-1);
			$result = $db->sql_query($request);
			list($nb_planet_free) = $db->sql_fetch_row($result);
			$nb_freeplanets_total += $nb_planet_free;

			$new = false;
			$request = "select max(last_update) from ".TABLE_UNIVERSE;
			$request .= " where galaxy = ".$galaxy;
			$request .= " and system between ".$system." and ".($system+$step-1);
			$result = $db->sql_query($request);
			list($last_update) = $db->sql_fetch_row($result);
			if ($last_update > $user_data["session_lastvisit"]) $new = true;

			$statictics[$galaxy][$system] = array("planet" => $nb_planet, "free" => $nb_planet_free, "new" => $new);
		}
	}

	return array("map" =>$statictics, "nb_planets" => $nb_planets_total, "nb_planets_free" => $nb_freeplanets_total);
}

/**
* Listing des alliances
*/
function galaxy_ally_listing () {
	global $db;

	$ally_list = array();

	$request = "select distinct ally from ".TABLE_UNIVERSE." order by ally";
	$result = $db->sql_query($request);
	while ($row = $db->sql_fetch_assoc($result)) {
		if ($row["ally"] != "")	$ally_list[] = $row["ally"];
	}

	return $ally_list;
}

/**
* Récupération position alliance
*/
function galaxy_ally_position ($step = 50) {
	global $db, $user_auth, $user_data, $server_config;
	global $pub_ally_, $nb_colonnes_ally;

	for ($i = 1 ; $i <= $nb_colonnes_ally ; $i ++){
		if (!check_var($pub_ally_[$i], "Text")) {
			redirection("index.php?action=message&id_message=errordata&info");
		}

		if (!isset($pub_ally_[$i])) {
			return array();
		}
	}

	$pub_ally_protection = $allied = array();
	if ($server_config["ally_protection"] != "") $pub_ally_protection = explode(",", $server_config["ally_protection"]);
	if ($server_config["allied"] != "") $allied = explode(",", $server_config["allied"]);

	$statictics = array();
	for ($i = 1 ; $i <= $nb_colonnes_ally ; $i ++){
		$pub_ally_list[$i-1] = $pub_ally_[$i];
	}

	foreach ($pub_ally_list as $pub_ally_name) {
		if ($pub_ally_name == "") continue;
		if (in_array($pub_ally_name, $pub_ally_protection) && $user_auth["server_show_positionhided"] == 0 && $user_data["user_admin"] == 0 && $user_data["user_coadmin"] == 0) {
			$statictics[$pub_ally_name][0][0] = null;
			continue;
		}
		$friend = false;
		if (in_array($pub_ally_name, $allied)) $friend = true;

		for ($galaxy=1 ; $galaxy<=intval($server_config['num_of_galaxies']) ; $galaxy++) {
			for ($system=1 ; $system<=intval($server_config['num_of_systems']) ; $system=$system+$step) {
				$request = "select galaxy, system, row, player from ".TABLE_UNIVERSE;
				$request .= " where galaxy = ".$galaxy;
				$request .= " and system between ".$system." and ".($system+$step-1);
				$request .= " and ally like '".$pub_ally_name."'";
				$request .= " order by player, galaxy, system, row";
				$result = $db->sql_query($request);
				$nb_planet = $db->sql_numrows($result);

				$population = array();
				while (list($galaxy_, $system_, $row_, $player) = $db->sql_fetch_row($result)) {
					$population[] = array("galaxy" => $galaxy_, "system" => $system_, "row" => $row_, "player" => $player);
				}

				$statictics[$pub_ally_name][$galaxy][$system] = array("planet" => $nb_planet, "population" => $population);
			}
		}
	}
	user_set_stat(null, null, 1);

	return $statictics;
}

/**
* Enregistrement des données erronées envoyées via le navigateur dans les logs
* @param string $datas Données du navigateur
*/
function galaxy_getsource_error($datas) {
	global $user_data, $server_config;

	if ($server_config["debug_log"] == "1") {
		$nomfichier = PATH_LOG_TODAY.date("ymd_His")."_ID".$user_data["user_id"]."_Error.txt";
		write_file($nomfichier, "w", $datas);
	}
}

/**
* Récupération des données transmises via le navigateur
*/
function galaxy_getsource() {
	global $db, $user_data, $user_auth, $server_config;
	global $pub_data, $pub_datatype;

	if (!isset($pub_data) || !isset($pub_datatype)) {
		redirection("index.php?action=message&id_message=errorfatal&info");
	}

	$lines = array();
	$lines = explode(chr(10), $pub_data);

	switch ($pub_datatype) {
		case "basic":
		if (($user_auth["server_set_system"] != 1 && $user_auth["server_set_spy"] != 1) && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
			redirection("index.php?action=message&id_message=errorfatal&info");
		}
		continue;

		case "combat_report":
		galaxy_check_auth("set_rc");
		insert_RC($pub_data); break;

		case "general_player":
		galaxy_check_auth("set_ranking");
		galaxy_getranking($lines, $pub_datatype); break;

		case "fleet_player":
		galaxy_check_auth("set_ranking");
		galaxy_getranking($lines, $pub_datatype); break;

		case "research_player":
		galaxy_check_auth("set_ranking");
		galaxy_getranking($lines, $pub_datatype); break;

		case "general_ally":
		galaxy_check_auth("set_ranking");
		galaxy_getranking($lines, $pub_datatype); break;

		case "fleet_ally":
		galaxy_check_auth("set_ranking");
		galaxy_getranking($lines, $pub_datatype); break;

		case "research_ally":
		galaxy_check_auth("set_ranking");
		galaxy_getranking($lines, $pub_datatype); break;

		case "none":
		redirection("index.php");


		default: redirection("index.php?action=message&id_message=errorfatal&info");
	}

	$nb_lines = sizeof($lines);
	$files = $lines;
	$authentification = true;

	$checking = false;
	for ($i=0 ; $i<$nb_lines ; $i++) {
		$line = $lines[$i];

		if (preg_match("#Système solaire#", $line)) {
			if ($user_auth["server_set_system"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
				redirection("index.php?action=message&id_message=errorfatal&info");
			}
			$lines = array_values($lines);
			$system_added = galaxy_system($lines);
			break;
		}
		elseif (preg_match("/Matières premières sur/", $line)) {
			if ($user_auth["server_set_spy"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
				redirection("index.php?action=message&id_message=errorfatal&info");
			}
			$lines = array_values($lines);
			$report_added = galaxy_spy($lines);
			break;
		}
		unset($lines[$i]);
	}

	if (isset($system_added)) {
		if ($system_added !== false) {
			list($galaxy, $system) = $system_added;

			if ($server_config["debug_log"] == "1") {
				$nomfichier = PATH_LOG_TODAY.date("ymd_His")."_ID".$user_data["user_id"]."_sys_G$galaxy"."S"."$system.txt";
				write_file($nomfichier, "w", $files);
			}
			log_("load_system", array($galaxy, $system));

			//Statistiques serveur
			/*//Incompatible MySQL 4.0
			$request = "insert into ".TABLE_STATISTIC." values ('planetimport_server', '15')";
			$request .= " on duplicate key update statistic_value = statistic_value + 15";
			$db->sql_query($request);*/
			$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + 15";
			$request .= " where statistic_name = 'planetimport_server'";
			$db->sql_query($request);
			if ($db->sql_affectedrows() == 0) {
				$request = "insert ignore into ".TABLE_STATISTIC." values ('planetimport_server', '15')";
				$db->sql_query($request);
			}

			redirection("index.php?galaxy=$galaxy&system=$system");
		}
	}
	if (isset($report_added)) {
		if ($report_added !== false) {

			if ($server_config["debug_log"] == "1") {
				//Sauvegarde données transmises
				$nomfichier = PATH_LOG_TODAY.date("ymd_His")."_ID".$user_data["user_id"]."_spy(".sizeof($report_added).").txt";
				write_file($nomfichier, "w", $files);
			}
			log_("load_spy", sizeof($report_added));

			//Statistiques serveur
			$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + ".sizeof($report_added);
			$request .= " where statistic_name = 'spyimport_server'";
			$db->sql_query($request);
			if ($db->sql_affectedrows() == 0) {
				$request = "insert ignore into ".TABLE_STATISTIC." values ('spyimport_server', '".sizeof($report_added)."')";
				$db->sql_query($request);
			}
						$recup = "SELECT spy_added_web FROM ".TABLE_USER." WHERE user_id =".$user_data["user_id"];
						$recup = $db->sql_query($recup);
						$valeur = $db->sql_fetch_row($recup);
						$query = "Update `".TABLE_USER."` SET `spy_added_web` = '".($valeur[0]+sizeof($report_added))."' WHERE `user_id` = '".$user_data["user_id"]."'";
						$db->sql_query($query);
			$reports = "";
			foreach ($report_added as $v) {
				list($added, $coordinates, $timestamp) = $v;
				$reports .= $added."~".$coordinates."~".$timestamp."¤";
			}
			$reports = substr($reports, 0, strlen($reports)-2);
			redirection("index.php?action=message&id_message=spy_added&info=".$reports);
		}
	}

	galaxy_getsource_error($files);
	redirection("index.php?action=message&id_message=errorfatal&info");
}

/**
* Ajout d'un système
*/
function galaxy_system($lines) {
	$OK = false;
	$status = array_fill(1, 15, "");
	$galaxy = "";
	$system = "";
	$now = time();
	$regExp = '/(\d{1,2})\s+([A-Za-z0-9àâäéèêëìïîòöôùüûç_\-\. ]+?)(?:\s\([0-9min \*]+\))?(\s+Lune \(Taille : \d+\))?\s{2,}([A-Za-z0-9àâäéèêëìïîòöôùüûç_\-\. ]+?)(\s\([iIbvdf ]+\))?\s{2,}([A-Za-z0-9àâäéèêëìïîòöôùüûç_\-\. ]+?)?\s+(?:Espionner[A-Za-z ]+)?/';
	for ($i=0 ; $i<sizeof($lines) ; $i++) {
		$line = $lines[$i];

		if (preg_match("#^Système solaire (\d+?):(\d+?)$#", trim($line), $arr)) {
			$galaxy = $arr[1];
			$system = $arr[2];
			$solar_system = array_fill(1, 15,  array("moon" => "0", "planet" => "", "ally" => "", "player" => "", "status" => ""));
			$OK = true;
			continue;
		}

		if ($OK) {
			for ( ; $i < sizeof ( $lines ); $i++ )
			{
				$line = $lines[$i];
			$planet = "";
			$ally = "";
			$player = "";
			$moon = 0;
			$statuts = "";
//Modification pour compatibilité v0.78c
			if ( preg_match ( $regExp, $line, $regs ) )
			{
				if ( ! empty ( $regs[4] ) && $regs[4] != ' ' )
				{
					$row = $regs[1];
					$planet = $regs[2];
					$moon = ( ! empty ( $regs[3] ) ) ? 1:0;
					$player = $regs[4];
					$status = ( isset ( $regs[5] ) && $regs[5] != 'Espionner' ) ? $regs[5]:'';
					$ally = ( isset ( $regs[6] ) && $regs[6] != 'Espionner' ) ? $regs[6]:'';
					$solar_system[$row] = array ( "moon" => $moon, "planet" => $planet, "ally" => $ally, "player" => $player, "status" => $status );
				}
			}
		}
//Fin de la modification pour compatibilité v0.78c
			$row = 1;
			foreach ($solar_system as $v) {
				if ($galaxy != "" && $system != "") {
					if(!galaxy_add_system($galaxy, $system, $row, $v["moon"], $v["planet"], $v["ally"], $v["player"], $v["status"], $now)) {
						return false;
					}
				}
				$row++;
			}

			break;
		}
	}

	if (!$OK && $galaxy <> "" && $system <> "") {
		for ($row=1 ; $row<=15 ; $row++) {
			galaxy_add_system($galaxy, $system, $row, "0", "", "", "", "", $now);
		}
	}
	galaxy_add_system_ally();

	return array($galaxy, $system);
}

/**
* Récupération des données transmises par OGS
*/
function galaxy_ImportPlanets() {
	global $db, $user_data, $server_config;
	global $pub_data;

	galaxy_check_auth("import_planet");

	$files = array();
	$start = benchmark();

	//		$test_ogs = file("test/Exp_Imp-planet.txt");
	//		$test_ogs = implode($test_ogs);
	//		$datas = explode("<->", $test_ogs);
	$datas=explode("<->",$pub_data);
	$files = $datas;

	$totalplanet=0;
	$totalupdated=0;
	$totalinserted=0;
	$totalfailed=0;
	$totalcanceled=0;

	$require = array("galaxy", "system", "row", "datetime", "moon", "planetname", "allytag", "playername", "status", "sendername");
	$head = current($datas);
	$head = explode(",", $head);
	$structure = array();
	foreach ($head as $value) {
		@list($info, $position) = explode("=", $value);
		if (in_array($info, $require)) {
			$structure[$info] = $position;
		}
	}

	next($datas);
	while ($planetdata = current($datas)) {
		$totalplanet++;
		$arr = explode("<||>",$planetdata);

		$galaxy = trim($arr[($structure["galaxy"]-1)]);
		$system = trim($arr[($structure["system"]-1)]);
		$row = trim($arr[($structure["row"]-1)]);

		if (isset($structure["datetime"])) {
			$datetime = trim($arr[($structure["datetime"]-1)]);

			list($day, $hour) = explode(" ", $datetime);
			list($year, $month, $day) = explode("-", $day);
			list($hour, $minute, $seconde) = explode(":", $hour);
			$timestamp = mktime($hour, $minute, $seconde, $month, $day, $year);
		}
		else $timestamp = 0;

		if (isset($structure["moon"])) {
			$moon = intval(trim($arr[$structure["moon"]-1]));
			if ($moon != 0 && $moon != 1) $moon = 0;
		}
		else $moon = 0;

		if (isset($structure["planetname"])) {
			$planetname = trim($arr[$structure["planetname"]-1]);
		}
		else $planetname = "";

		if (isset($structure["allytag"])) {
			$allytag = trim($arr[$structure["allytag"]-1]);
		}
		else $allytag = "";

		if (isset($structure["playername"])) {
			$playername = trim($arr[$structure["playername"]-1]);
		}
		else $playername = "";

		if (isset($structure["status"])) {
			$status = trim($arr[$structure["status"]-1]);
		}
		else $status = "";

		if (!check_var($galaxy, "Num") || !check_var($system, "Num") || !check_var($row, "Num") || !check_var($planetname, "Galaxy") ||
		!check_var($allytag, "Galaxy") || !check_var($playername, "Galaxy") || !check_var($status, "Char") || !check_var($timestamp, "Num")) {
			die ("<!-- [ErrorFatal=12] Données transmises incorrectes  -->");
		}

		$result = galaxy_add_system($galaxy, $system, $row, $moon, $planetname, $allytag, $playername, $status, $timestamp, true);
		if ($result) {
			list($inserted, $updated, $canceled) = $result;
			if ($inserted) $totalinserted++;
			if ($updated) $totalupdated++;
			if ($canceled) $totalcanceled++;
		}
		else {
			$totalfailed++;
		}

		next($datas);
	}

	if ($server_config["debug_log"] == "1") {
		//Sauvegarde données transmises
		$nomfichier = PATH_LOG_TODAY.date("ymd_His")."_ID".$user_data["user_id"]."_sys_OGS.txt";
		write_file($nomfichier, "w", $files);
	}

	galaxy_add_system_ally();

	$end = benchmark();
	$totaltime = ($end - $start);
	$totaltime = round($totaltime, 2);

	//Statistiques serveur
	/*//Incompatible MySQL 4.0
	$request = "insert into ".TABLE_STATISTIC." values ('planetimport_ogs', '".($totalinserted+$totalupdated)."')";
	$request .= " on duplicate key update statistic_value = statistic_value + ".($totalinserted+$totalupdated)."";
	$db->sql_query($request);*/
	$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + ".($totalinserted+$totalupdated);
	$request .= " where statistic_name = 'planetimport_ogs'";
	$db->sql_query($request);
	if ($db->sql_affectedrows() == 0) {
		$request = "insert ignore into ".TABLE_STATISTIC." values ('planetimport_ogs', '".($totalinserted+$totalupdated)."')";
		$db->sql_query($request);
	}

	echo "Merci ".$user_data["user_name"]."\n";
	echo "Nb de planètes soumises : ".$totalplanet."\n";
	echo "Nb de planètes insérées : ".$totalinserted."\n";
	echo "Nb de planètes mise à jour : ".$totalupdated."\n";
	echo "Nb de planètes obsolètes : ".$totalcanceled."\n";
	echo "Nb d'échec  : ".$totalfailed."\n";
	echo "Durée de traitement : $totaltime sec"."\n";

	log_("load_system_OGS", array($totalplanet, $totalinserted, $totalupdated, $totalcanceled, $totalfailed, $totaltime));

	exit();
}

/**
* Envoi des données vers OGS
*/
function galaxy_ExportPlanets() {
	global $db, $user_data, $server_config, $user_auth;
	global $pub_galnum, $pub_sincedate;

	galaxy_check_auth("export_planet");

	$request_galaxy = "";
	$request_date = "";
	if (isset($pub_galnum)) {
		if (!check_var($pub_galnum, "Num")) {
			die ("<!-- [ErrorFatal=01] Données transmises incorrectes  -->");
		}
		if ($pub_galnum != "") {
			log_("get_system_OGS", intval($pub_galnum));
			$request_galaxy = " where galaxy = ".intval($pub_galnum);
		}
		else log_("get_system_OGS");
	}
	else log_("get_system_OGS");


	if (isset($pub_sincedate)) {
		if (!check_var($pub_sincedate, "Special", "#^(\d){4}-(\d){2}-(\d){2}\s(\d){2}:(\d){2}:(\d){2}$#")) {
			die ("<!-- [ErrorFatal=02] Données transmises incorrectes  -->");
		}
		if ($pub_sincedate != "") {
			list($day, $hour) = explode(" ", $pub_sincedate);
			list($year, $month, $day) = explode("-", $day);
			list($hour, $minute, $seconde) = explode(":", $hour);
			$timestamp = mktime($hour, $minute, $seconde, $month, $day, $year);
			$request_date = isset($request_galaxy) ? " and " : " where ";
			$request_date .= "last_update >= ".$timestamp;
		}
	}

	$ally_protection = array();
	if ($server_config["ally_protection"] != "") $ally_protection = explode(",", $server_config["ally_protection"]);

	$request = "select galaxy, system, row, moon, name, ally, player, status, user_name, last_update".
	" from ".TABLE_UNIVERSE." left join ".TABLE_USER.
	" on last_update_user_id = user_id".
	$request_galaxy.
	$request_date.
	" order by galaxy, system, row";

	$result = $db->sql_query($request);

	$i=0;
	echo "galaxy=1,system=2,row=3,moon=4,planetname=5,playername=6,allytag=7,status=8,datetime=9,sendername=10<->";
	while(list($galaxy, $system, $row, $moon, $name, $ally, $player, $status, $user_name, $last_update) = $db->sql_fetch_row($result)) {
		if ($name == "") $name = " ";
		if ($ally == "") $ally = " ";
		if ($player == "") $player = " ";
		if (is_null($user_name)) $user_name = "Inconnu";

		if (!in_array($ally, $ally_protection) || $ally == "" || $user_auth["server_show_positionhided"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
			$texte = $galaxy."<||>";
			$texte .= $system."<||>";
			$texte .= $row."<||>";
			$texte .= ($moon == 1) ? "M" : "";
			$texte .= "<||>";

			$texte .= utf8_decode($name)."<||>";
			$texte .= utf8_decode($player)."<||>";
			$texte .= utf8_decode($ally)."<||>";
			$texte .= $status."<||>";
			$texte .= date("Y-m-d H:i:s", $last_update)."<||>";
			$texte .= utf8_decode($user_name);
			$texte .= "<->";

			echo $texte;
			$i++;
		}
	}

	user_set_stat(null, null, null, null, null, null, null, $i);

	//Statistiques serveur
	$db->sql_query($request);
	/*//Incompatible MySQL 4.0
	$request = "insert into ".TABLE_STATISTIC." values ('planetexport_ogs', '".$i."')";
	$request .= " on duplicate key update statistic_value = statistic_value + ".$i."";*/
	$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + ".$i;
	$request .= " where statistic_name = 'planetexport_ogs'";
	$db->sql_query($request);
	if ($db->sql_affectedrows() == 0) {
		$request = "insert ignore into ".TABLE_STATISTIC." values ('planetexport_ogs', '".$i."')";
		$db->sql_query($request);
	}

	//Statistiques joueur

	exit();
}

/**
* Mise à jours des systemes
*/
function galaxy_add_system ($galaxy, $system, $row, $moon, $name, $ally, $player, $status, $timestamp, $mode_ogs = false) {
	global $db, $user_data;

	$error = false;
	$updated = false;
	$canceled = true;
	$inserted = false;

	$name=trim($name);
	$ally=trim($ally);
	$player=trim($player);


	if(!check_var($row, "Num") || $row<1 && $row>15) return false;

	//Contrôle si l'update entraine des modifications
	$request = "select ally, player, last_update from ".TABLE_UNIVERSE." where galaxy = $galaxy and system = $system and row = $row";
	$result = $db->sql_query($request);
	list($old_ally, $old_player, $last_update) = $db->sql_fetch_row($result);

	if ($timestamp > time()) $timestamp = time();
	if($last_update < $timestamp) {
		$canceled = false;
		if (!isset($old_ally) && !isset($old_player)) {
			if (!$mode_ogs) user_set_stat(1);
			else user_set_stat(0, 1);
			$inserted = true;
		}
		else {
			if (!$mode_ogs) user_set_stat(1);
			else user_set_stat(null, 1);
			$updated = true;

			if ($ally == "(unknown)" && $player == "(unkwown)") {
				$ally = $old_ally;
				$player = $old_player;
			}
		}

		$values = $status;
		$status = "";
		if (preg_match("#i#", $values)) $status .= "i";
		if (preg_match("#b#", $values)) $status .= "b";
		if (preg_match("#v#", $values)) $status .= "v";
		if (preg_match("#d#", $values)) $status .= "d";
		if (preg_match("#f#", $values)) $status .= "f";
		if (preg_match("#I#", $values)) $status .= "I";

		//Mise à jour
		$request = "update ".TABLE_UNIVERSE." set ally = '".mysql_real_escape_string($ally)."', player = '".mysql_real_escape_string($player)."', moon = '".$moon."', name = '".mysql_real_escape_string($name)."', status = '".$status."', last_update = '".$timestamp."', last_update_user_id = ".$user_data["user_id"];
		$request .= " where galaxy = '".$galaxy."' and system = ".$system." and row = '".$row."'";
		$db->sql_query($request) or $error = true;
		if ($db->sql_affectedrows() == 0) {
			$request = "insert ignore into ".TABLE_UNIVERSE." (galaxy, system, row, moon, name, ally, player, status, last_update, last_update_user_id)";
			$request .= " values ('".$galaxy."', ".$system.", '".$row."', '".$moon."', '".mysql_real_escape_string($name)."', '".mysql_real_escape_string($ally)."', '".mysql_real_escape_string($player)."', '".$status."', ".$timestamp.", ".$user_data["user_id"].")";
			$db->sql_query($request) or $error = true;
		}
		if ($moon == 0) {
			$request = "update ".TABLE_UNIVERSE." set phalanx = 0, gate = '0', last_update_moon = 0 where galaxy = '".$galaxy."' and system = ".$system." and row = '".$row."'";
			$db->sql_query($request) or $error = true;
		}

		if ($error) return false;

		if ($player != "") {
			$request = "insert into ".TABLE_UNIVERSE_TEMPORARY." (player, ally, status, timestamp) values ('".mysql_real_escape_string($player)."', '".mysql_real_escape_string($ally)."', '".mysql_real_escape_string($status)."', '".$timestamp."')";
			$db->sql_query($request);
		}
		else {
			$request = "update ".TABLE_SPY." set active = '0' where spy_galaxy = '".$galaxy."' and spy_system = ".$system." and spy_row = '".$row."'";
			$db->sql_query($request);
		}
	}
	return array($inserted, $updated, $canceled);
}

/**
* Mise à jour des allys et statuts joueurs
*/
function galaxy_add_system_ally () {
	global $db, $user_data, $table_prefix;

	/*//Incompatible Hébergement 1&1
	$request = "create temporary table universe_temporary_cleaned like ".TABLE_UNIVERSE_TEMPORARY;*/
	$table = $table_prefix.$user_data["user_id"]."_".time()."_utc";
	$request = "create table ".$table." (";
	$request .= " player varchar(20) not null default '',";
	$request .= " ally varchar(20) not null default '',";
	$request .= " status varchar(5) not null default '',";
	$request .= " timestamp int(11) not null default '0'";
	$request .= ") ;";
	$db->sql_query($request);

	$request = "insert into ".$table;
	$request .= " select player, ally, status, max(timestamp)";
	$request .= " from ".TABLE_UNIVERSE_TEMPORARY;
	$request .= " group by player, ally";
	$db->sql_query($request);

	$request = "delete from ".$table;
	$request .= " using ".TABLE_UNIVERSE." u, ".$table;
	$request .= " where u.player = ".$table.".player";
	$request .= " and timestamp < last_update";
	$result = $db->sql_query($request);

	$request = "update ".TABLE_UNIVERSE." u, ".$table." utc";
	$request .= " set u.ally = utc.ally, u.status = utc.status";
	$request .= " where u.player = utc.player";
	$result = $db->sql_query($request);

	$request = "drop table ".$table;
	$db->sql_query($request);

	$request = "truncate ".TABLE_UNIVERSE_TEMPORARY;
	$result = $db->sql_query($request);
}

/**
* Analyse de rapports d'espionnage
*/
function galaxy_spy($lines) {
	global $db, $user_data, $server_config;

	$nb_spy_added = 0;
	$spy_added = array();
	
	$reports = join ( chr(10), $lines );
	preg_match_all ( '/Mati.res\spremi.res\ssur(.*?):\d+%/ms', $reports, $report );
	foreach ( $report[0] as $spy )
	{
		$coordinates = explode ( ']', $spy );
			$coordinates = substr ( $coordinates[0], strrpos ( $coordinates[0], '[' ) + 1 );
			$timestamp = explode ( "\nle", $spy );
			$timestamp = explode ( "\n", $timestamp[1] );
			$timestamp = $timestamp[0];
		if ( insert_RE ( $spy ) )
		{
			$nb_spy_added++;
				$spy_added[] = array ( 1, $coordinates, $timestamp );
			}
			else
				$spy_added[] = array ( 0, $coordinates, $timestamp );
	}

	user_set_stat(null, null, null, $nb_spy_added);
	return $spy_added;
}

/**
* Récupération des rapports d'espionnage provenant de OGS
*/
function galaxy_ImportSpy(){
	global $db, $user_data, $server_config;
	global $pub_data;

	galaxy_check_auth("import_spy");

	//		$test_ogs = file("test/spy-import.txt");
	//		$test_ogs = implode($test_ogs);
	//		$datas = explode("<->", $test_ogs);
	$datas = explode("<->",$pub_data);
	$files = $datas;

	$require = array("coordinates", "planet", "datatime", "report");
	$head = current($datas);
	$head = explode(",", $head);
	$structure = array();
	foreach ($head as $value) {
		@list($info, $position) = explode("=", $value);
		if (in_array($info, $require)) {
			$structure[$info] = $position;
		}
	}


	$spy_added = 0;
	next($datas);
	while ($spyreportdata = current($datas)) {
		$arr = explode("<||>",$spyreportdata);

		$coordinates = $arr[($structure["coordinates"]-1)];
		list($galaxy, $system , $row)=explode(":",$coordinates);
		$galaxy = intval($galaxy);
		$system = intval($system);
		$row = intval($row);

		if (isset($structure["planet"])) {
			$planet = trim($arr[($structure["planet"]-1)]);
		}
		else $planet = "";

		if (isset($structure["datatime"])) {
			$datatime = trim($arr[($structure["datatime"]-1)]);
			list($day, $hour) = explode(" ", $datatime);
			list($year, $month, $day) = explode("-", $day);
			list($hour, $minute, $seconde) = explode(":", $hour);
			$timestamp = mktime($hour, $minute, $seconde, $month, $day, $year);
		}
		else $timestamp = 0;

		$report = $arr[($structure["report"]-1)];

		if (!check_var($galaxy, "Num") || !check_var($system, "Num") || !check_var($row, "Num") ||
		!check_var($planet, "Galaxy") || !check_var($timestamp, "Num") || !check_var($report, "Spyreport")) {
			die ("<!-- [ErrorFatal=17] Données transmises incorrectes  -->");
		}

//		if (galaxy_add_spy($galaxy, $system, $row, $planet, $timestamp, $report, 0, 0)) { // modif pour les noms de lunes http://ogsteam.fr/forums/sujet-1652-correctif-bug-phalange-porte-saut
		$pos=strpos($report,"Phalange de capteur")+strlen("Phalange de capteur")+1;
		$phalanx="'".substr("$report",$pos,$pos+1)."'";
		$pos2=strpos($report,"Porte de saut spatial")+strlen("Porte de saut spatial")+1;
		$gate=substr("$report",$pos2,$pos2+1);
		if (galaxy_add_spy($galaxy, $system, $row, $planet, $timestamp, $report, $phalanx, $gate[0])) {
			$spy_added++;
		}

		next($datas);
	}

	if ($server_config["debug_log"] == "1") {
		//Sauvegarde données transmises
		$nomfichier = PATH_LOG_TODAY.date("ymd_His")."_ID".$user_data["user_id"]."_spy_OGS.txt";
		write_file($nomfichier, "w", $files);
	}

	user_set_stat(null, null, null, null, $spy_added);

	log_("load_spy_OGS", $spy_added);

	//Statistiques serveur
	/*//Incompatible MySQL 4.0
	$request = "insert into ".TABLE_STATISTIC." values ('spyimport_ogs', '".$spy_added."')";
	$request .= " on duplicate key update statistic_value = statistic_value + ".$spy_added."";*/
	$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + ".$spy_added;
	$request .= " where statistic_name = 'spyimport_ogs'";
	$db->sql_query($request);
	if ($db->sql_affectedrows() == 0) {
		$request = "insert ignore into ".TABLE_STATISTIC." values ('spyimport_ogs', '".$spy_added."')";
		$db->sql_query($request);
	}

	die("Merci ".$user_data["user_name"]."\n"."Nb de rapports chargés : ".$spy_added."\n");
}

/**
* Renvoi des rapports d'espionnage vers OGS
*/
function galaxy_ExportSpy() {
	global $db, $user_data;
	global $pub_galnum, $pub_sysnum;

	galaxy_check_auth("export_spy");

	if (!isset($pub_galnum) || !isset($pub_sysnum)) {
		die ("<!-- [ErrorFatal=08] Données transmises incorrectes  -->");
	}
	if (!check_var($pub_galnum, "Num") || !check_var($pub_sysnum, "Num")) {
		die ("<!-- [ErrorFatal=09] Données transmises incorrectes  -->");
	}
	$galaxy = intval($pub_galnum);
	$system = intval($pub_sysnum);

	$request = "select max(spy_id), un.name, s.rawdata, us.user_name".
	" from ".TABLE_UNIVERSE." un, ".TABLE_SPY." s left join ".TABLE_USER." us".
	" on s.sender_id = us.user_id".
	" where active = '1'".
	" and un.galaxy = s.spy_galaxy".
	" and un.system = s.spy_system".
	" and un.row = s.spy_row".
	" and galaxy = ".$galaxy.
	" and system = ".$system.
	" group by s.spy_galaxy, s.spy_system, s.spy_row";

	$result = $db->sql_query($request);

	$i=0;
	echo "sendername=1,report=2<->";
	while(list($spy_id, $name, $data, $user_name) = $db->sql_fetch_row($result)) {
		$texte = $user_name."<||>";
		$texte .= stripslashes($data)."<->";

		echo $texte;
		$i++;
	}

	user_set_stat(null, null, null, null, null, null, null, null, $i);

	log_("export_spy_sector", array($i, $galaxy, $system));

	//Statistiques serveur
	/*//Incompatible MySQL 4.0
	$request = "insert into ".TABLE_STATISTIC." values ('spyexport_ogs', '".$i."')";
	$request .= " on duplicate key update statistic_value = statistic_value + ".$i."";*/
	$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + ".$i;
	$request .= " where statistic_name = 'spyexport_ogs'";
	$db->sql_query($request);
	if ($db->sql_affectedrows() == 0) {
		$request = "insert ignore into ".TABLE_STATISTIC." values ('spyexport_ogs', '".$i."')";
		$db->sql_query($request);
	}

	exit();
}

/**
* Envoi des rapports d'espionnage vers OGS à partir d'une date
*/
function galaxy_ExportSpy_since() {
	global $db, $user_data;
	global $pub_since;

	galaxy_check_auth("export_spy");

	if (!isset($pub_since)) {
		die ("<!-- [ErrorFatal=10] Données transmises incorrectes  -->");
	}
	if (!check_var($pub_since, "Special", "#^(\d){4}-(\d){2}-(\d){2}\s(\d){2}:(\d){2}:(\d){2}$#")) {
		die ("<!-- [ErrorFatal=11] Données transmises incorrectes  -->");
	}

	list($day, $hour) = explode(" ", $pub_since);
	list($year, $month, $day) = explode("-", $day);
	list($hour, $minute, $seconde) = explode(":", $hour);
	$timestamp = mktime($hour, $minute, $seconde, $month, $day, $year);

	$request = "select s.rawdata, us.user_name".
	" from ".TABLE_SPY." s left join ".TABLE_USER." us".
	" on s.sender_id = us.user_id".
	" where active = '1'";
	" and datadate >= ".$timestamp;
	$result = $db->sql_query($request);

	$i=0;
	echo "sendername=1,report=2<->";
	while(list($data, $user_name) = $db->sql_fetch_row($result)) {
		$texte = $user_name."<||>";
		$texte .= stripslashes($data)."<->";

		echo $texte;
		$i++;
	}

	user_set_stat(null, null, null, null, null, null, null, null, $i);

	log_("export_spy_date", array($i, $timestamp));

	//Statistiques serveur
	$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + ".$i;
	$request .= " where statistic_name = 'spyexport_ogs'";
	$db->sql_query($request);
	if ($db->sql_affectedrows() == 0) {
		$request = "insert ignore into ".TABLE_STATISTIC." values ('spyexport_ogs', '".$i."')";
		$db->sql_query($request);
	}

	exit();
}

/**
* Ajout de rapport d'espionnage
*/
function galaxy_add_spy($galaxy, $system, $row, $planet, $timestamp, $report, $phalanx, $gate) {
	global $db, $user_data, $server_config;

	$spy_added = array();
	$request = "insert into ".TABLE_SPY." (spy_galaxy, spy_system, spy_row, sender_id, datadate, rawdata)".
	" values ('$galaxy', '$system', '$row', ".$user_data["user_id"].", '$timestamp', '".mysql_real_escape_string($report)."')";
	if ($db->sql_query($request, false)) {
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

		$moon = 0;
		if ((strcmp($planet, "lune") == 0 || strpos($planet, " (Lune)") != 0 ) && !preg_match("#Mine#", $report))
			$moon = 1;

		$request = "select last_update, last_update_moon from ".TABLE_UNIVERSE." where galaxy = $galaxy and system = $system and row = $row";
		$result = $db->sql_query($request);
		list($last_update, $last_update_moon) = $db->sql_fetch_row($result);

		if ($timestamp > $last_update) {
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

		if ($timestamp > $last_update_moon && $moon) {
			$request = "update ".TABLE_UNIVERSE." set moon = '1', last_update_moon = ".$timestamp.", phalanx = ".$phalanx.", gate = '".$gate."' where galaxy = '".$galaxy."' and system = ".$system." and row = '".$row."'";
			$db->sql_query($request);
		}

		return true;
	}
	return false;
}

/**
* Récupération des rapports d'espionnage
*/
function galaxy_reportspy_show() {
	global $db;
	global $pub_galaxy, $pub_system, $pub_row, $pub_spy_id, $server_config;

	if (!check_var($pub_galaxy, "Num") || !check_var($pub_system, "Num") || !check_var($pub_row, "Num")) {
		return false;
	}

	if (!isset($pub_galaxy) || !isset($pub_system) || !isset($pub_row)) {
		return false;
	}
	if (intval($pub_galaxy) < 1 || intval($pub_galaxy) > intval($server_config['num_of_galaxies']) || intval($pub_system) < 1 || intval($pub_system) > intval($server_config['num_of_systems']) || intval($pub_row) < 1 || intval($pub_row) > 15) {
		return false;
	}

	$request = "select id_spy, user_name, dateRE";
	$request .= " from ".TABLE_PARSEDSPY." left join ".TABLE_USER." on user_id = sender_id";
	if (!isset($pub_spy_id)) {
		$request .= " where active = '1'  and coordinates = '".intval($pub_galaxy).":".intval($pub_system).":".intval($pub_row)."'";
	}
	else {
		$request .= " where id_spy = ".intval($pub_spy_id);
	}
	$request .= " and planet_name not like '%(Lune)%' AND planet_name not like 'lune' order by dateRE desc LIMIT 1";
	$result = $db->sql_query($request);

	$reports = array();
	while (list($pub_spy_id, $user_name, $dateRE) = $db->sql_fetch_row($result)) {
			$data = UNparseRE($pub_spy_id);
		$reports[] = array ( "spy_id"=> $pub_spy_id, "sender" => $user_name, "data" => $data, "moon" => 0, "dateRE" => $dateRE );
	}

	$request = "select id_spy, user_name, dateRE";
	$request .= " from ".TABLE_PARSEDSPY." left join ".TABLE_USER." on user_id = sender_id";
	if (!isset($pub_spy_id)) {
		$request .= " where active = '1'  and coordinates = '".intval($pub_galaxy).":".intval($pub_system).":".intval($pub_row)."'";
	}
	else {
		$request .= " where id_spy = ".intval($pub_spy_id);
	}
	$request .= " and (planet_name like '%(Lune)%' OR planet_name like 'lune') order by dateRE desc LIMIT 1";
	$result = $db->sql_query($request);

	while (list($pub_spy_id, $user_name, $dateRE) = $db->sql_fetch_row($result)) {
			$data = UNparseRE($pub_spy_id);
		$reports[] = array ( "spy_id"=> $pub_spy_id, "sender" => $user_name, "data" => $data, "moon" => 1, "dateRE" => $dateRE );
	}

	return $reports;
}

/**
* Récupération des rapports de combat
*/
function galaxy_reportrc_show() {
	global $db;
	global $pub_galaxy, $pub_system, $pub_row, $pub_spy_id, $server_config;

	if (!check_var($pub_galaxy, "Num") || !check_var($pub_system, "Num") || !check_var($pub_row, "Num")) {
		return false;
	}

	if (!isset($pub_galaxy) || !isset($pub_system) || !isset($pub_row)) {
		return false;
	}
	if (intval($pub_galaxy) < 1 || intval($pub_galaxy) > intval($server_config['num_of_galaxies']) || intval($pub_system) < 1 || intval($pub_system) > intval($server_config['num_of_systems']) || intval($pub_row) < 1 || intval($pub_row) > 15) {
		return false;
	}

	$request = "select id_rc from ".TABLE_PARSEDRC;
	if (!isset($pub_rc_id)) {
		$request .= " where coordinates = '".intval($pub_galaxy).':'.intval($pub_system).':'.intval($pub_row) . "'";
		$request .= " order by dateRC desc";
	}
	else {
		$request .= " where id_rc = ".intval($pub_rc_id);
	}
	$result = $db->sql_query($request);

	$reports = array();
	while (list($pub_rc_id) = $db->sql_fetch_row($result))
		$reports[] = UNparseRC ( $pub_rc_id );

	return $reports;
}

/**
* Purge des rapports d'espionnage
*/
function galaxy_purge_spy() {
	global $db, $server_config;

	if (!is_numeric($server_config["max_keepspyreport"])) {
		return;
	}
	$max_keepspyreport = intval($server_config["max_keepspyreport"]);

	$request = "select spy_id from ".TABLE_SPY." where active = '0' or datadate < ".(time()-60*60*24*$max_keepspyreport);
	$result = $db->sql_query($request);

	while (list($spy_id) = $db->sql_fetch_row($result)) {
		$request = "select * from ".TABLE_USER_SPY." where spy_id = ".$spy_id;
		$result2 = $db->sql_query($request);
		if ($db->sql_numrows($result2) == 0) {
			$request = "delete from ".TABLE_SPY." where spy_id = ".$spy_id;
			$db->sql_query($request);
		}
	}
}

/**
* Récupération des systèmes favoris
*/
function galaxy_getfavorites() {
	global $db, $user_data;

	$favorite = array();

	$request = "select galaxy, system from ".TABLE_USER_FAVORITE;
	$request .= " where user_id = ".$user_data["user_id"];
	$request .= " order by galaxy, system";
	$result = $db->sql_query($request);

	while (list($galaxy, $system) = $db->sql_fetch_row($result)) {
		$favorite[] = array("galaxy" => $galaxy, "system" => $system);
	}

	return $favorite;
}

/**
* Récupération du classement joueur via OGS
*/
function galaxy_ImportRanking_player($ranktype){
	global $db, $user_data, $server_config;
	global $pub_data;

	galaxy_check_auth("import_ranking");

	//		$test_ogs = file("test/Exp_Imp-ranking.txt");
	//		$ranking=explode("<->", $test_ogs[0]);
	$ranking = explode("<->",$pub_data);
	$files = $ranking;
	$countrank=0;

	switch ($ranktype) {
		case "points":
		$ranktable = TABLE_RANK_PLAYER_POINTS;
		$ranktype = "general";
		break;

		case "flotte":
		$ranktable = TABLE_RANK_PLAYER_FLEET;
		$ranktype = "fleet";
		break;

		case "research":
		$ranktable = TABLE_RANK_PLAYER_RESEARCH;
		$ranktype = "research";
		break;

		default:
		die ("<!-- [ErrorFatal=15] Données transmises incorrectes  -->");
		break;
	}

	$require = array("datetime", "playername", "allytag", "rank", "points", "sendername");
	$head = current($ranking);
	$head = explode(",", $head);
	$structure = array();
	foreach ($head as $value) {
		@list($info, $position) = explode("=", $value);
		if (in_array($info, $require)) {
			$structure[$info] = $position;
		}
	}

	@$datadate = $structure["datetime"];
	@list($day, $hour) = explode(" ", $datadate);
	@list($year, $month, $day) = explode("-", $day);
	@list($hour, $minute, $seconde) = explode(":", $hour);
	@$timestamp = mktime($hour, 0, 0, $month, $day, $year);

	next($ranking);
	while ($RankLine = current($ranking)) {
		if ($RankLine){
			$arr = explode("<||>",$RankLine);
			$countrank = $countrank +1;

			$rank = intval($arr[$structure["rank"]-1]);

			if (isset($structure["playername"])) {
				$playername = trim($arr[$structure["playername"]-1]);
			}
			else $playername = "";

			if (isset($structure["allytag"])) {
				$allytag = trim($arr[$structure["allytag"]-1]);
			}
			else $allytag = "";

			if (isset($structure["points"])) {
				$points = intval($arr[$structure["points"]-1]);
			}
			else $points = "";

			if (!check_var($rank, "Num") || !check_var($allytag, "Galaxy") || !check_var($playername, "Galaxy") || !check_var($points, "Num") || !check_var($timestamp, "Num")) {
				die ("<!-- [ErrorFatal=16] Données transmises incorrectes  -->");
			}

			$request = "insert ignore into ".$ranktable;
			$request .= " (datadate, rank, player, ally, points, sender_id)";
			$request .= " values ('".$timestamp."', '".$rank."', '".mysql_real_escape_string($playername)."', '".mysql_real_escape_string($allytag)."','".$points."', '".$user_data["user_id"]."')";
			$db->sql_query($request);
		}

		next($ranking);
	}

	user_set_stat(null, null, null, null, null, null,  $countrank);

	if ($server_config["debug_log"] == "1") {
		//Sauvegarde données transmises
		$nomfichier = PATH_LOG_TODAY.date("ymd_His")."_ID".$user_data["user_id"]."_ranking_".$ranktype.".txt";
		write_file($nomfichier, "w", $files);
	}

	if ($countrank > 0) {
		log_("load_rank", array("OGS", $ranktype, "player", $timestamp, $countrank));
	}

	//Statistiques serveur
	$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + ".$countrank;
	$request .= " where statistic_name = 'rankimport_ogs'";
	$db->sql_query($request);
	if ($db->sql_affectedrows() == 0) {
		$request = "insert ignore into ".TABLE_STATISTIC." values ('rankimport_ogs', '".$countrank."')";
		$db->sql_query($request);
	}

	die ("\nMerci ".$user_data["user_name"]."\n"
	."Nb de lignes soumises : ".$countrank."\n");
}

/**
* Récupération du classement alliance via OGS
*/
function galaxy_ImportRanking_ally($ranktype){
	global $db, $user_data, $server_config;
	global $pub_data;

	galaxy_check_auth("import_ranking");

	$ranking = explode("<->",$pub_data);
	$files = $ranking;
	$countrank=0;

	switch ($ranktype) {
		case "points":
		$ranktable = TABLE_RANK_ALLY_POINTS;
		$ranktype = "general";
		break;

		case "flotte":
		$ranktable = TABLE_RANK_ALLY_FLEET;
		$ranktype = "fleet";
		break;

		case "research":
		$ranktable = TABLE_RANK_ALLY_RESEARCH;
		$ranktype = "research";
		break;

		default:
		die ("<!-- [ErrorFatal=13] Données transmises incorrectes  -->");
		break;
	}

	$require = array("rank", "allytag", "number_member", "points", "points_per_member", "sendername", "datetime");
	$head = current($ranking);
	$head = explode(",", $head);
	$structure = array();
	foreach ($head as $value) {
		@list($info, $position) = explode("=", $value);
		if (in_array($info, $require)) {
			$structure[$info] = $position;
		}
	}

	@$datadate = $structure["datetime"];
	@list($day, $hour) = explode(" ", $datadate);
	@list($year, $month, $day) = explode("-", $day);
	@list($hour, $minute, $seconde) = explode(":", $hour);
	@$timestamp = mktime($hour, 0, 0, $month, $day, $year);

	next($ranking);
	while ($RankLine = current($ranking)) {
		if ($RankLine){
			$arr = explode("<||>",$RankLine);
			$countrank = $countrank +1;

			$rank = intval($arr[$structure["rank"]-1]);

			if (isset($structure["allytag"])) {
				$allytag = trim($arr[$structure["allytag"]-1]);
			}
			else $allytag = "";

			if (isset($structure["number_member"])) {
				$number_member = trim($arr[$structure["number_member"]-1]);
			}
			else $number_member = "";

			if (isset($structure["points"])) {
				$points = intval($arr[$structure["points"]-1]);
			}
			else $points = "";

			if (isset($structure["points_per_member"])) {
				$points_per_member = intval($arr[$structure["points_per_member"]-1]);
			}
			else $points_per_member = "";

			if (!check_var($rank, "Num") || !check_var($allytag, "Galaxy") || !check_var($number_member, "Num") || !check_var($points, "Num") || !check_var($points_per_member, "Num") || !check_var($timestamp, "Num")) {
				die ("<!-- [ErrorFatal=14] Données transmises incorrectes  -->");
			}

			$request = "insert ignore into ".$ranktable;
			$request .= " (datadate, rank, ally, number_member, points, points_per_member, sender_id)";
			$request .= " values ('".$timestamp."', '".$rank."', '".mysql_real_escape_string($allytag)."','".$number_member."','".$points."','".$points_per_member."', '".$user_data["user_id"]."')";
			$db->sql_query($request);
		}

		next($ranking);
	}

	user_set_stat(null, null, null, null, null, null, $countrank);

	if ($server_config["debug_log"] == "1") {
		//Sauvegarde données transmises
		$nomfichier = PATH_LOG_TODAY.date("ymd_His")."_ID".$user_data["user_id"]."_ranking_".$ranktype.".txt";
		write_file($nomfichier, "w", $files);
	}

	if ($countrank > 0) {
		log_("load_rank", array("OGS", $ranktype, "ally", $timestamp, $countrank));
	}

	//Statistiques serveur
	$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + ".$countrank;
	$request .= " where statistic_name = 'rankimport_ogs'";
	$db->sql_query($request);
	if ($db->sql_affectedrows() == 0) {
		$request = "insert ignore into ".TABLE_STATISTIC." values ('rankimport_ogs', '".$countrank."')";
		$db->sql_query($request);
	}

	die ("\nMerci ".$user_data["user_name"]."\n"
	."Nb de lignes soumises : ".$countrank."\n");
}

/**
* Envoi du classement joueur vers OGS
*/
function galaxy_ExportRanking_player() {
	global $db, $user_data;
	global $pub_date, $pub_type;

	galaxy_check_auth("export_ranking");

	if (!isset($pub_date) || !isset($pub_type)) {
		die ("<!-- [ErrorFatal=05] Données transmises incorrectes  -->");
	}

	switch ($pub_type) {
		case "points": $ranktable = TABLE_RANK_PLAYER_POINTS; break;
		case "flotte": $ranktable = TABLE_RANK_PLAYER_FLEET; break;
		case "research": $ranktable = TABLE_RANK_PLAYER_RESEARCH; break;
		default: die ("<!-- [ErrorFatal=06] Données transmises incorrectes  -->");;
	}

	if (!check_var($pub_date, "Special", "#^(\d){4}-(\d){2}-(\d){2}\s(\d){2}:(\d){2}:(\d){2}$#")) {
		die ("<!-- [ErrorFatal=07] Données transmises incorrectes  -->");
	}

	list($day, $hour) = explode(" ", $pub_date);
	list($year, $month, $day) = explode("-", $day);
	list($hour, $minute, $seconde) = explode(":", $hour);
	$timestamp = mktime($hour, 0, 0, $month, $day, $year);

	$request = "select rank, player, ally, points, user_name";
	$request .= " from ".$ranktable." left join ".TABLE_USER;
	$request .= " on sender_id = user_id";
	$request .= " where datadate = ".$timestamp;
	$request .= " order by rank";
	$result = $db->sql_query($request);

	$i=0;
	echo "playername=1,allytag=2,rank=3,points=4,sendername=5,datetime=".$pub_date."<->";
	while (list($rank, $player, $ally, $points, $user_name) = $db->sql_fetch_row($result)) {
		$texte = utf8_decode($player)."<||>";
		$texte .= utf8_decode($ally)."<||>";
		$texte .= $rank."<||>";
		$texte .= $points."<||>";
		$texte .= utf8_decode($user_name)."<||>";
		$texte .= "<->";
		echo $texte;

		$i++;
	}

	user_set_stat(null, null, null, null, null, null, null, null, null, $i);

	log_("get_rank", array($pub_type, $timestamp));

	//Statistiques serveur
	$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + ".$i;
	$request .= " where statistic_name = 'rankexport_ogs'";
	$db->sql_query($request);
	if ($db->sql_affectedrows() == 0) {
		$request = "insert ignore into ".TABLE_STATISTIC." values ('rankexport_ogs', '".$i."')";
		$db->sql_query($request);
	}

	exit();
}

/**
* Envoi du classement alliance vers OGS
*/
function galaxy_ExportRanking_ally() {
	global $db, $user_data;
	global $pub_date, $pub_type;

	galaxy_check_auth("export_ranking");

	if (!isset($pub_date) || !isset($pub_type)) {
		die ("<!-- [ErrorFatal=03] Données transmises incorrectes  -->");
	}

	switch ($pub_type) {
		case "points": $ranktable = TABLE_RANK_ALLY_POINTS; break;
		case "flotte": $ranktable = TABLE_RANK_ALLY_FLEET; break;
		case "research": $ranktable = TABLE_RANK_ALLY_RESEARCH; break;
		default: die ("<!-- [ErrorFatal=04] Données transmises incorrectes  -->");;
	}

	if (!check_var($pub_date, "Special", "#^(\d){4}-(\d){2}-(\d){2}\s(\d){2}:(\d){2}:(\d){2}$#")) {
		die ("<!-- [ErrorFatal=04] Données transmises incorrectes  -->");
	}

	list($day, $hour) = explode(" ", $pub_date);
	list($year, $month, $day) = explode("-", $day);
	list($hour, $minute, $seconde) = explode(":", $hour);
	$timestamp = mktime($hour, 0, 0, $month, $day, $year);

	$request = "select rank, ally, number_member, points, points_per_member, user_name";
	$request .= " from ".$ranktable." left join ".TABLE_USER;
	$request .= " on sender_id = user_id";
	$request .= " where datadate = ".$timestamp;
	$request .= " order by rank";
	$result = $db->sql_query($request);

	$i=0;
	echo "rank=1,allytag=2,number_member=3,points=4,points_per_member=5,sendername=6,datetime=".$pub_date."<->";
	while (list($rank, $ally, $number_member, $points, $points_per_member, $user_name) = $db->sql_fetch_row($result)) {
		$texte .= $rank."<||>";
		$texte .= utf8_decode($ally)."<||>";
		$texte .= $number_member."<||>";
		$texte .= $points."<||>";
		$texte .= $points_per_member."<||>";
		$texte .= utf8_decode($user_name)."<||>";
		$texte .= "<->";
		echo $texte;

		$i++;
	}

	user_set_stat(null, null, null, null, null, null, null, null, null, $i);

	log_("get_rank", array($pub_type, $timestamp));

	//Statistiques serveur
	$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + ".$i;
	$request .= " where statistic_name = 'rankexport_ogs'";
	$db->sql_query($request);
	if ($db->sql_affectedrows() == 0) {
		$request = "insert ignore into ".TABLE_STATISTIC." values ('rankexport_ogs', '".$i."')";
		$db->sql_query($request);
	}

	exit();
}

/**
* Listing des classements disponibles sur le serveur pour envoi vers OGS
*/
function galaxy_ShowAvailableRanking($type) {
	global $db;

	$ranking = array();

	switch ($type) {
		case "player":
		$table_points = TABLE_RANK_PLAYER_POINTS;
		$table_fleet = TABLE_RANK_PLAYER_POINTS;
		$table_research = TABLE_RANK_PLAYER_POINTS;
		break;

		case "ally":
		$table_points = TABLE_RANK_ALLY_POINTS;
		$table_fleet = TABLE_RANK_ALLY_POINTS;
		$table_research = TABLE_RANK_ALLY_POINTS;
		break;
	}

	$request = "select distinct datadate from ".$table_points." order by datadate desc";
	$result = $db->sql_query($request);
	while (list($datadate) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["points"] = true;
	}

	$request = "select distinct datadate from ".$table_fleet." order by datadate desc";
	$result = $db->sql_query($request);
	while (list($datadate) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["fleet"] = true;
	}

	$request = "select distinct datadate from ".$table_research." order by datadate desc";
	$result = $db->sql_query($request);
	while (list($datadate) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["research"] = true;
	}

	while ($value = current($ranking)) {
		echo date("Y-m-d H:i:s", key($ranking)+4)."=";
		if (isset($value["points"])) echo "P";
		if (isset($value["fleet"])) echo "F";
		if (isset($value["research"])) echo "R";
		echo "<|>";
		next($ranking);
	}
	exit();
}

/**
* Affichage classement des joueurs
*/
function galaxy_show_ranking_player() {
	global $db;
	global $pub_order_by, $pub_date, $pub_interval;

	if (!isset($pub_order_by)) {
		$pub_order_by = "general";
	}
	if ($pub_order_by != "general" && $pub_order_by != "fleet" && $pub_order_by != "research") {
		$pub_order_by = "general";
	}

	$request = "SELECT rank FROM `" .TABLE_RANK_PLAYER_FLEET. "` order by `rank` desc limit 0,1";
	$result = $db->sql_query($request);
	$maxfleet = $db->sql_fetch_row($result);
	$maxrank[0] = $maxfleet[0];
	$request = "SELECT rank FROM `" .TABLE_RANK_PLAYER_POINTS. "` order by `rank` desc limit 0,1";
	$result = $db->sql_query($request);
	$maxpoints = $db->sql_fetch_row($result);
	$maxrank[1] = $maxpoints[0];
	$request = "SELECT rank FROM `" .TABLE_RANK_PLAYER_RESEARCH. "` order by `rank` desc limit 0,1";
	$result = $db->sql_query($request);
	$maxresearch = $db->sql_fetch_row($result);
	$maxrank[2] = $maxresearch[0];
	$maxrank = max($maxrank);

	if (!isset($pub_interval)) {
		$pub_interval = 1;
	}
	if (($pub_interval-1)%100 != 0 || $pub_interval > $maxrank) {
		$pub_interval = 1;
	}
	$limit_down = $pub_interval;
	$limit_up = $pub_interval + 99;

	$order = array();
	$ranking = array();
	$ranking_available = array();

	switch ($pub_order_by) {
		case "general":
		$table[] = array("tablename" => TABLE_RANK_PLAYER_POINTS, "arrayname" => "general");
		$table[] = array("tablename" => TABLE_RANK_PLAYER_FLEET, "arrayname" => "fleet");
		$table[] = array("tablename" => TABLE_RANK_PLAYER_RESEARCH, "arrayname" => "research");
		break;
		case "fleet":
		$table[] = array("tablename" => TABLE_RANK_PLAYER_FLEET, "arrayname" => "fleet");
		$table[] = array("tablename" => TABLE_RANK_PLAYER_POINTS, "arrayname" => "general");
		$table[] = array("tablename" => TABLE_RANK_PLAYER_RESEARCH, "arrayname" => "research");
		break;
		case "research":
		$table[] = array("tablename" => TABLE_RANK_PLAYER_RESEARCH, "arrayname" => "research");
		$table[] = array("tablename" => TABLE_RANK_PLAYER_POINTS, "arrayname" => "general");
		$table[] = array("tablename" => TABLE_RANK_PLAYER_FLEET, "arrayname" => "fleet");
		break;
	}
	$i=0;

	if (!isset($pub_date)) {
		$request = "select max(datadate) from ".$table[$i]["tablename"];
		$result = $db->sql_query($request);
		list($last_ranking) = $db->sql_fetch_row($result);
	}
	else $last_ranking = $pub_date;

	$request = "select rank, player, ally, points, user_name";
	$request .= " from ".$table[$i]["tablename"]." left join ".TABLE_USER;
	$request .= " on sender_id = user_id";
	$request .= " where rank between ".$limit_down." and ".$limit_up;
	$request .= isset($last_ranking) ? " and datadate = ".mysql_real_escape_string($last_ranking) : "";
	$request .= " order by rank";
	$result = $db->sql_query($request);

	while (list($rank, $player, $ally, $points, $user_name) = $db->sql_fetch_row($result)) {
		$ranking[$player][$table[$i]["arrayname"]] = array("rank" => $rank, "points" => $points);
		$ranking[$player]["ally"] = $ally;
		$ranking[$player]["sender"] = $user_name;

		if ($pub_order_by == $table[$i]["arrayname"]) {
			$order[$rank] = $player;
		}
	}

	$request = "select distinct datadate from ".$table[$i]["tablename"]." order by datadate desc";
	$result_2 = $db->sql_query($request);
	while ($row = $db->sql_fetch_assoc($result_2)) {
		$ranking_available[] = $row["datadate"];
	}

	for ($i ; $i<3 ; $i++) {
		reset($ranking);
		while ($value = current($ranking)) {
			$request = "select rank, player, ally, points, user_name";
			$request .= " from ".$table[$i]["tablename"]." left join ".TABLE_USER;
			$request .= " on sender_id = user_id";
			$request .= " where player = '".mysql_real_escape_string(key($ranking))."'";
			$request .= isset($last_ranking) ? " and datadate = ".mysql_real_escape_string($last_ranking) : "";
			$request .= " order by rank";
			$result = $db->sql_query($request);

			while (list($rank, $player, $ally, $points, $user_name) = $db->sql_fetch_row($result)) {
				$ranking[$player][$table[$i]["arrayname"]] = array("rank" => $rank, "points" => $points);
				$ranking[$player]["ally"] = $ally;
				$ranking[$player]["sender"] = $user_name;

				if ($pub_order_by == $table[$i]["arrayname"]) {
					$order[$rank] = $player;
				}
			}

			next($ranking);
		}
	}

	$ranking_available = array_unique($ranking_available);

	return array($order, $ranking, $ranking_available, $maxrank);
}

/**
* Affichage classement des alliances
*/
function galaxy_show_ranking_ally() {
	global $db;
	global $pub_order_by, $pub_date, $pub_interval, $pub_suborder;

	if (!check_var($pub_order_by, "Char") || !check_var($pub_date, "Num") || !check_var($pub_interval, "Num") || !check_var($pub_suborder, "Char")) {
		redirection("index.php?action=message&id_message=errordata&info");
	}

	$request = "SELECT rank FROM `" .TABLE_RANK_ALLY_FLEET. "` order by `rank` desc limit 0,1";
	$result = $db->sql_query($request);
	$maxfleet = $db->sql_fetch_row($result);
	$maxrank[0] = $maxfleet[0];
	$request = "SELECT rank FROM `" .TABLE_RANK_ALLY_POINTS. "` order by `rank` desc limit 0,1";
	$result = $db->sql_query($request);
	$maxpoints = $db->sql_fetch_row($result);
	$maxrank[1] = $maxpoints[0];
	$request = "SELECT rank FROM `" .TABLE_RANK_ALLY_RESEARCH. "` order by `rank` desc limit 0,1";
	$result = $db->sql_query($request);
	$maxresearch = $db->sql_fetch_row($result);
	$maxrank[2] = $maxresearch[0];
	$maxrank = max($maxrank);

	if (!isset($pub_order_by)) {
		$pub_order_by = "general";
	}
	if ($pub_order_by != "general" && $pub_order_by != "fleet" && $pub_order_by != "research") {
		$pub_order_by = "general";
	}

	if (isset($pub_suborder) && $pub_suborder == "member") $pub_order_by2 = "points_per_member desc";
	else $pub_order_by2 = "rank";

	if (!isset($pub_interval)) {
		$pub_interval = 1;
	}
	if (($pub_interval-1)%100 != 0 || $pub_interval > $maxrank) {
		$pub_interval = 1;
	}
	$limit_down = $pub_interval;
	$limit_up = $pub_interval + 99;

	$order = array();
	$ranking = array();
	$ranking_available = array();

	switch ($pub_order_by) {
		case "general":
		$table[] = array("tablename" => TABLE_RANK_ALLY_POINTS, "arrayname" => "general");
		$table[] = array("tablename" => TABLE_RANK_ALLY_FLEET, "arrayname" => "fleet");
		$table[] = array("tablename" => TABLE_RANK_ALLY_RESEARCH, "arrayname" => "research");
		break;
		case "fleet":
		$table[] = array("tablename" => TABLE_RANK_ALLY_FLEET, "arrayname" => "fleet");
		$table[] = array("tablename" => TABLE_RANK_ALLY_POINTS, "arrayname" => "general");
		$table[] = array("tablename" => TABLE_RANK_ALLY_RESEARCH, "arrayname" => "research");
		break;
		case "research":
		$table[] = array("tablename" => TABLE_RANK_ALLY_RESEARCH, "arrayname" => "research");
		$table[] = array("tablename" => TABLE_RANK_ALLY_POINTS, "arrayname" => "general");
		$table[] = array("tablename" => TABLE_RANK_ALLY_FLEET, "arrayname" => "fleet");
		break;
	}
	$i=0;

	if (!isset($pub_date)) {
		$request = "select max(datadate) from ".$table[$i]["tablename"];
		$result = $db->sql_query($request);
		list($last_ranking) = $db->sql_fetch_row($result);
	}
	else $last_ranking = $pub_date;

	$request = "select rank, ally, number_member, points, points_per_member, user_name";
	$request .= " from ".$table[$i]["tablename"]." left join ".TABLE_USER;
	$request .= " on sender_id = user_id";
	$request .= " where rank between ".$limit_down." and ".$limit_up;
	$request .= isset($last_ranking) ? " and datadate = ".mysql_real_escape_string($last_ranking) : "";
	$request .= " order by ".$pub_order_by2;
	$result = $db->sql_query($request);

	while (list($rank, $ally, $number_member, $points, $points_per_member, $user_name) = $db->sql_fetch_row($result)) {
		$ranking[$ally][$table[$i]["arrayname"]] = array("rank" => $rank, "points" => $points, "points_per_member" => $points_per_member);
		$ranking[$ally]["number_member"] = $number_member;
		$ranking[$ally]["sender"] = $user_name;

		if ($pub_order_by == $table[$i]["arrayname"]) {
			$order[$rank] = $ally;
		}
	}

	$request = "select distinct datadate from ".$table[$i]["tablename"]." order by datadate desc";
	$result_2 = $db->sql_query($request);
	while ($row = $db->sql_fetch_assoc($result_2)) {
		$ranking_available[] = $row["datadate"];
	}

	for ($i ; $i<3 ; $i++) {
		reset($ranking);
		while ($value = current($ranking)) {
			$request = "select rank, ally, number_member, points, points_per_member, user_name";
			$request .= " from ".$table[$i]["tablename"]." left join ".TABLE_USER;
			$request .= " on sender_id = user_id";
			$request .= " where ally = '".mysql_real_escape_string(key($ranking))."'";
			$request .= isset($last_ranking) ? " and datadate = ".mysql_real_escape_string($last_ranking) : "";
			$request .= " order by rank";
			$result = $db->sql_query($request);

			while (list($rank, $ally, $number_member, $points, $points_per_member, $user_name) = $db->sql_fetch_row($result)) {
				$ranking[$ally][$table[$i]["arrayname"]] = array("rank" => $rank, "points" => $points, "points_per_member" => $points_per_member);
				$ranking[$ally]["number_member"] = $number_member;
				$ranking[$ally]["sender"] = $user_name;

				if ($pub_order_by == $table[$i]["arrayname"]) {
					$order[$rank] = $ally;
				}
			}

			next($ranking);
		}
	}

	$ranking_available = array_unique($ranking_available);

	return array($order, $ranking, $ranking_available, $maxrank);
}

/**
* Affichage classement d'un joueur particulier
*/
function galaxy_show_ranking_unique_player($player, $last = false) {
	global $db;

	$ranking = array();

	$request = "select datadate, rank, points";
	$request .= " from ".TABLE_RANK_PLAYER_POINTS;
	$request .= " where player = '".mysql_real_escape_string($player)."'";
	$request .= " order by datadate desc";
	$result = $db->sql_query($request);
	while (list($datadate, $rank, $points) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["general"] = array("rank" => $rank, "points" => $points);
		if ($last) break;
	}

	$request = "select datadate, rank, points";
	$request .= " from ".TABLE_RANK_PLAYER_FLEET;
	$request .= " where player = '".mysql_real_escape_string($player)."'";
	$request .= " order by datadate desc";
	$result = $db->sql_query($request);
	while (list($datadate, $rank, $points) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["fleet"] = array("rank" => $rank, "points" => $points);
		if ($last) break;
	}

	$request = "select datadate, rank, points";
	$request .= " from ".TABLE_RANK_PLAYER_RESEARCH;
	$request .= " where player = '".mysql_real_escape_string($player)."'";
	$request .= " order by datadate desc";
	$result = $db->sql_query($request);
	while (list($datadate, $rank, $points) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["research"] = array("rank" => $rank, "points" => $points);
		if ($last) break;
	}

	return $ranking;
}

/**
* Affichage classement d'une ally particulière
*/
function galaxy_show_ranking_unique_ally($ally, $last = false) {
	global $db;

	$ranking = array();

	$request = "select datadate, rank, points, number_member, points_per_member";
	$request .= " from ".TABLE_RANK_ALLY_POINTS;
	$request .= " where ally = '".mysql_real_escape_string($ally)."'";
	$request .= " order by datadate desc";
	$result = $db->sql_query($request);
	while (list($datadate, $rank, $points, $number_member, $points_per_member) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["general"] = array("rank" => $rank, "points" => $points, "points_per_member" => $points_per_member);
		$ranking[$datadate]["number_member"] = $number_member;
		if ($last) break;
	}

	$request = "select datadate, rank, points, number_member, points_per_member";
	$request .= " from ".TABLE_RANK_ALLY_FLEET;
	$request .= " where ally = '".mysql_real_escape_string($ally)."'";
	$request .= " order by datadate desc";
	$result = $db->sql_query($request);
	while (list($datadate, $rank, $points, $number_member, $points_per_member) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["fleet"] = array("rank" => $rank, "points" => $points, "points_per_member" => $points_per_member);
		$ranking[$datadate]["number_member"] = $number_member;
		if ($last) break;
	}

	$request = "select datadate, rank, points, number_member, points_per_member";
	$request .= " from ".TABLE_RANK_ALLY_RESEARCH;
	$request .= " where ally = '".mysql_real_escape_string($ally)."'";
	$request .= " order by datadate desc";
	$result = $db->sql_query($request);
	while (list($datadate, $rank, $points, $number_member, $points_per_member) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["research"] = array("rank" => $rank, "points" => $points, "points_per_member" => $points_per_member);
		$ranking[$datadate]["number_member"] = $number_member;
		if ($last) break;
	}

	return $ranking;
}

/**
* Récupération du classement joueurs
*/
function galaxy_getranking($lines, $datatype) {
	global $db, $user_data, $server_config;

	switch ($datatype) {
		case "general_player" : $ranktable = TABLE_RANK_PLAYER_POINTS; break;
		case "fleet_player" : $ranktable = TABLE_RANK_PLAYER_FLEET; break;
		case "research_player" : $ranktable = TABLE_RANK_PLAYER_RESEARCH; break;

		case "general_ally" : $ranktable = TABLE_RANK_ALLY_POINTS; break;
		case "fleet_ally" : $ranktable = TABLE_RANK_ALLY_FLEET; break;
		case "research_ally" : $ranktable = TABLE_RANK_ALLY_RESEARCH; break;

		default: redirection("index.php?action=message&id_message=errorfatal&info");
	}

	$time = time()-60*4;
	if ($time > mktime(0,0,0) && $time < mktime(8,0,0)) $timestamp = mktime(0,0,0);
	if ($time > mktime(8,0,0) && $time < mktime(16,0,0)) $timestamp = mktime(8,0,0);
	if ($time > mktime(16,0,0) && $time < (mktime(0,0,0)+60*60*24)) $timestamp = mktime(16,0,0);

	$files = array();
	$OK = false;
	$last_position = 0;
	$index = 0;
	if (preg_match("#player#", $datatype)) {
		for ($i=0 ; $i<sizeof($lines) ; $i++) {
			$line = trim($lines[$i]);

			if (!$OK && preg_match("#^Place+\s+Joueur+\s+Alliance+\s+Points$#", $line)) {
				$OK = true;
				$position = 0;
				continue;
			}

			if ($OK) {
				$files[] = $line;

				$index++;
				//3 lignes , Compatibilité 0.76 , les . dans les nombres http://ogsteam.fr/forums/viewtopic.php?pid=27522#p27522
				preg_match("#^(\d+)\s+\S\s+(.*?)\s+(?:\s+Envoyer\sun\smessage)?\s+(.*?)?\s+([^\s][0-9.]*)$#", $line, $arr);
				list($text, $position, $player, $ally, $points) = $arr;
				$points=str_replace('.','',$points);

				if (!is_numeric($position) || !is_string($player) || !is_string($ally) || !is_numeric($points)) {
					return false;
				}
				if ($last_position != 0) {
					if ($last_position+1 != $position) {
						return false;
					}
				}
				$ranking[$position] = array("player" => $player, "ally" => $ally, "points" => $points);
				$last_position = $position;
				if ($index == 100) break;
			}
		}
	}
	else {
		for ($i=0 ; $i<sizeof($lines) ; $i++) {
			$line = trim($lines[$i]);

			if (!$OK && preg_match("#^Place+\s+Alliance+\s+Memb.+\s+(Milliers de )?points+\s+par membre$#i", $line)) {
				$OK = true;
				$position = 0;
				continue;
			}

			if ($OK) {
				$files[] = $line;

				$index++;
				//5 lignes , Compatibilité 0.76 , les . dans les nombres http://ogsteam.fr/forums/viewtopic.php?pid=27522#p27522 et posts suivants
				preg_match("#^(\d+)\s+\S\s+(.*?)\s+([^\s][0-9.]*)\s+([^\s][0-9.]*)\s+([^\s][0-9.]*)$#", $line, $arr);
				list($text, $position, $ally, $nb_member, $points, $points_per_member) = $arr;
				$nb_member = str_replace('.','',$nb_member);

				$points=str_replace('.','',$points);
				$points_per_member=str_replace('.','',$points_per_member);

				if (!is_numeric($position) || !is_string($ally) || !is_numeric($nb_member) || !is_numeric($points) || !is_numeric($points_per_member)) {
					return false;
				}
				if ($last_position != 0) {
					if ($last_position+1 != $position) {
						return false;
					}
				}
				$ranking[$position] = array("ally" => $ally, "number_member" => $nb_member, "points" => $points, "points_per_member" => $points_per_member);
				$last_position = $position;
				if ($index == 100) break;
			}
		}
	}

	if (!$OK) {
		redirection("index.php?action=ranking");
	}

	if ($server_config["debug_log"] == "1") {
		//Sauvegarde données tranmises
		$nomfichier = PATH_LOG_TODAY.date("ymd_His")."_ID".$user_data["user_id"]."_ranking_".$datatype.".txt";
		write_file($nomfichier, "w", $files);
	}

	while ($rankline = current($ranking)) {
		if (preg_match("#player#", $datatype)) {
			$request = "insert ignore into ".$ranktable;
			$request .= " (datadate, rank, player, ally, points, sender_id)";
			$request .= " values (".$timestamp.", ".key($ranking).", '".mysql_real_escape_string($rankline["player"])."', '".mysql_real_escape_string($rankline["ally"])."',".$rankline["points"].", ".$user_data["user_id"].")";
		}
		else{
			$request = "insert ignore into ".$ranktable;
			$request .= " (datadate, rank, ally, number_member, points, points_per_member, sender_id)";
			$request .= " values (".$timestamp.", ".key($ranking).", '".mysql_real_escape_string($rankline["ally"])."', ".$rankline["number_member"].", ".$rankline["points"].", ".$rankline["points_per_member"].", ".$user_data["user_id"].")";
		}
		$db->sql_query($request);

		next($ranking);
	}

	user_set_stat(null, null, null, null, null, $index);

	if (preg_match("#player#", $datatype)) {
		log_("load_rank", array("WEB", $datatype, "player", $timestamp, $index));
	}
	else {
		log_("load_rank", array("WEB", $datatype, "ally", $timestamp, $index));
	}

	//Statistiques serveur
	$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + ".sizeof($ranking);
	$request .= " where statistic_name = 'rankimport_server'";
	$db->sql_query($request);
	if ($db->sql_affectedrows() == 0) {
		$request = "insert ignore into ".TABLE_STATISTIC." values ('rankimport_server', '".sizeof($ranking)."')";
		$db->sql_query($request);
	}

	if (preg_match("#player#", $datatype)) redirection("index.php?action=ranking&subaction=player");
	if (preg_match("#ally#", $datatype)) redirection("index.php?action=ranking&subaction=ally");
}

/**
* Suppression automatique de classements joueurs & alliances
*/
function galaxy_purge_ranking() {
	global $db, $server_config;

	if (!is_numeric($server_config["max_keeprank"])) {
		return;
	}
	$max_keeprank = intval($server_config["max_keeprank"]);

	if ($server_config["keeprank_criterion"] == "day") {
		// classement joueur
		$request = "delete from ".TABLE_RANK_PLAYER_POINTS." where datadate < ".(time()-60*60*24*$max_keeprank);
		$db->sql_query($request, true, false);
		$request = "delete from ".TABLE_RANK_PLAYER_FLEET." where datadate < ".(time()-60*60*24*$max_keeprank);
		$db->sql_query($request, true, false);
		$request = "delete from ".TABLE_RANK_PLAYER_RESEARCH." where datadate < ".(time()-60*60*24*$max_keeprank);
		$db->sql_query($request, true, false);
		// classement ally
		$request = "delete from ".TABLE_RANK_ALLY_POINTS." where datadate < ".(time()-60*60*24*$max_keeprank);
		$db->sql_query($request, true, false);
		$request = "delete from ".TABLE_RANK_ALLY_FLEET." where datadate < ".(time()-60*60*24*$max_keeprank);
		$db->sql_query($request, true, false);
		$request = "delete from ".TABLE_RANK_ALLY_RESEARCH." where datadate < ".(time()-60*60*24*$max_keeprank);
		$db->sql_query($request, true, false);
	}

	if ($server_config["keeprank_criterion"] == "quantity") {
		// classement joueur
		$request = "select distinct datadate from ".TABLE_RANK_PLAYER_POINTS." order by datadate desc limit 0, ".$max_keeprank;
		$result = $db->sql_query($request);
		while ($row = $db->sql_fetch_assoc($result)) {$datadate = $row["datadate"];}
		if (isset($datadate)) {
			$request = "delete from ".TABLE_RANK_PLAYER_POINTS." where datadate < ".$datadate;
			$db->sql_query($request, true, false);
		}

		$request = "select distinct datadate from ".TABLE_RANK_PLAYER_FLEET." order by datadate desc limit 0, ".$max_keeprank;
		$result = $db->sql_query($request);
		while ($row = $db->sql_fetch_assoc($result)) {$datadate = $row["datadate"];}
		if (isset($datadate)) {
			$request = "delete from ".TABLE_RANK_PLAYER_FLEET." where datadate < ".$datadate;
			$db->sql_query($request, true, false);
		}

		$request = "select distinct datadate from ".TABLE_RANK_PLAYER_RESEARCH." order by datadate desc limit 0, ".$max_keeprank;
		$result = $db->sql_query($request);
		while ($row = $db->sql_fetch_assoc($result)) {$datadate = $row["datadate"];}
		if (isset($datadate)) {
			$request = "delete from ".TABLE_RANK_PLAYER_RESEARCH." where datadate < ".$datadate;
			$db->sql_query($request, true, false);
		}

		// classement ally
		$request = "select distinct datadate from ".TABLE_RANK_ALLY_POINTS." order by datadate desc limit 0, ".$max_keeprank;
		$result = $db->sql_query($request);
		while ($row = $db->sql_fetch_assoc($result)) {$datadate = $row["datadate"];}
		if (isset($datadate)) {
			$request = "delete from ".TABLE_RANK_ALLY_POINTS." where datadate < ".$datadate;
			$db->sql_query($request, true, false);
		}

		$request = "select distinct datadate from ".TABLE_RANK_ALLY_FLEET." order by datadate desc limit 0, ".$max_keeprank;
		$result = $db->sql_query($request);
		while ($row = $db->sql_fetch_assoc($result)) {$datadate = $row["datadate"];}
		if (isset($datadate)) {
			$request = "delete from ".TABLE_RANK_ALLY_FLEET." where datadate < ".$datadate;
			$db->sql_query($request, true, false);
		}

		$request = "select distinct datadate from ".TABLE_RANK_ALLY_RESEARCH." order by datadate desc limit 0, ".$max_keeprank;
		$result = $db->sql_query($request);
		while ($row = $db->sql_fetch_assoc($result)) {$datadate = $row["datadate"];}
		if (isset($datadate)) {
			$request = "delete from ".TABLE_RANK_ALLY_RESEARCH." where datadate < ".$datadate;
			$db->sql_query($request, true, false);
		}
	}
}


/**
* Suppression manuelle de classements
*/
function galaxy_drop_ranking() {
	global $db;
	global $pub_datadate, $pub_subaction;

	if (!check_var($pub_datadate, "Num") || !check_var($pub_subaction, "Char")) {
		redirection("index.php?action=message&id_message=errordata&info");
	}

	//Vérification des droits
	galaxy_check_auth("drop_ranking");

	if (!isset($pub_datadate) || !isset($pub_subaction)) {
		redirection("index.php");
	}

	if ($pub_subaction == "player") {
		$request = "delete from ".TABLE_RANK_PLAYER_POINTS." where datadate = ".intval($pub_datadate);
		$db->sql_query($request);
		$request = "delete from ".TABLE_RANK_PLAYER_FLEET." where datadate = ".intval($pub_datadate);
		$db->sql_query($request);
		$request = "delete from ".TABLE_RANK_PLAYER_RESEARCH." where datadate = ".intval($pub_datadate);
		$db->sql_query($request);
	}
	elseif ($pub_subaction == "ally") {
		$request = "delete from ".TABLE_RANK_ALLY_POINTS." where datadate = ".intval($pub_datadate);
		$db->sql_query($request);
		$request = "delete from ".TABLE_RANK_ALLY_FLEET." where datadate = ".intval($pub_datadate);
		$db->sql_query($request);
		$request = "delete from ".TABLE_RANK_ALLY_RESEARCH." where datadate = ".intval($pub_datadate);
		$db->sql_query($request);
	}

	redirection("index.php?action=ranking&subaction=".$pub_subaction);
}

/**
* Listing des phalanges
*/
function galaxy_get_phalanx($galaxy, $system) {
	global $db, $server_config, $user_data, $user_auth;

	$ally_protection = array();
	if ($server_config["ally_protection"] != "") $ally_protection = explode(",", $server_config["ally_protection"]);

	$phalanxer = array();

	$req = "select galaxy, system, row, phalanx, gate, name, ally, player from ".TABLE_UNIVERSE." where galaxy = ".$galaxy." and moon = '1' and phalanx > 0 and system + (power(phalanx, 2) - 1) >= ".$system." and system - (power(phalanx, 2) - 1) <= ".$system;

	$result = $db->sql_query($req);
	while ($coordinates = $db->sql_fetch_assoc($result)) {
		if (!in_array($coordinates["ally"], $ally_protection) || $coordinates["ally"] == "" || $user_auth["server_show_positionhided"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) $phalanxer[] = $coordinates;
	}

	return $phalanxer;
}

/**
* Affichage des systèmes solaires obsolètes
*/
function galaxy_obsolete() {
	global $db;
	global $pub_perimeter, $pub_since, $pub_typesearch;

	$obsolete = array();
	if (isset($pub_perimeter) && isset($pub_since) && is_numeric($pub_perimeter) && is_numeric($pub_since)) {
		if (!isset($pub_typesearch) || ($pub_typesearch != "M" && $pub_typesearch != "P")) $pub_typesearch = "P";

		$timestamp = time();
		$pub_since_56 = $timestamp - 60 * 60 * 24 * 56;
		$pub_since_42 = $timestamp - 60 * 60 * 24 * 42;
		$pub_since_28 = $timestamp - 60 * 60 * 24 * 28;
		$pub_since_21 = $timestamp - 60 * 60 * 24 * 21;
		$pub_since_14 = $timestamp - 60 * 60 * 24 * 14;
		$pub_since_7 = $timestamp - 60 * 60 * 24 * 7;

		if ($pub_typesearch == "P") {
			$field = "last_update";
			$row_field = "";
			$moon = 0;
		}
		else {
			$field = "last_update_moon";
			$row_field = ", row";
			$moon = 1;
		}

		switch ($pub_since) {
			case 56 :
			$request = "select distinct galaxy, system".$row_field." from ".TABLE_UNIVERSE." where moon = '".$moon."' and ".$field." < ".$pub_since_56;
			if ($pub_perimeter != 0) $request .= " and galaxy = ".intval($pub_perimeter);
			$request .= " order by galaxy, system, row limit 0, 51";
			$result = $db->sql_query($request);

			while ($row = $db->sql_fetch_assoc($result)) {
				$request = "select min(".$field.") from ".TABLE_UNIVERSE." where galaxy = ".$row["galaxy"]." and system = ".$row["system"];
				$result2 = $db->sql_query($request);
				list($last_update) = $db->sql_fetch_row($result2);
				$row["last_update"] = $last_update;

				$obsolete[56][] = $row;
			}

			case 42 :
			$request = "select distinct galaxy, system".$row_field." from ".TABLE_UNIVERSE." where moon = '".$moon."' and ".$field." between ".$pub_since_56." and ".$pub_since_42;
			if ($pub_perimeter != 0) $request .= " and galaxy = ".intval($pub_perimeter);
			if ($pub_perimeter != 0)
			$request .= " and galaxy = ".intval($pub_perimeter);
			$request .= " order by galaxy, system, row limit 0, 51";
			$result = $db->sql_query($request);

			while ($row = $db->sql_fetch_assoc($result)) {
				$request = "select min(".$field.") from ".TABLE_UNIVERSE." where galaxy = ".$row["galaxy"]." and system = ".$row["system"];
				$result2 = $db->sql_query($request);
				list($last_update) = $db->sql_fetch_row($result2);
				$row["last_update"] = $last_update;

				$obsolete[42][] = $row;
			}

			case 28 :
			$request = "select distinct galaxy, system".$row_field." from ".TABLE_UNIVERSE." where moon = '".$moon."' and ".$field." between ".$pub_since_42." and ".$pub_since_28;
			if ($pub_perimeter != 0) $request .= " and galaxy = ".intval($pub_perimeter);
			$request .= " order by galaxy, system, row limit 0, 51";
			$result = $db->sql_query($request);

			while ($row = $db->sql_fetch_assoc($result)) {
				$request = "select min(".$field.") from ".TABLE_UNIVERSE." where galaxy = ".$row["galaxy"]." and system = ".$row["system"];
				$result2 = $db->sql_query($request);
				list($last_update) = $db->sql_fetch_row($result2);
				$row["last_update"] = $last_update;

				$obsolete[28][] = $row;
			}

			case 21 :
			$request = "select distinct galaxy, system".$row_field." from ".TABLE_UNIVERSE." where moon = '".$moon."' and ".$field." between ".$pub_since_28." and ".$pub_since_21;
			if ($pub_perimeter != 0) $request .= " and galaxy = ".intval($pub_perimeter);
			$request .= " order by galaxy, system, row limit 0, 51";
			$result = $db->sql_query($request);

			while ($row = $db->sql_fetch_assoc($result)) {
				$request = "select min(".$field.") from ".TABLE_UNIVERSE." where galaxy = ".$row["galaxy"]." and system = ".$row["system"];
				$result2 = $db->sql_query($request);
				list($last_update) = $db->sql_fetch_row($result2);
				$row["last_update"] = $last_update;

				$obsolete[21][] = $row;
			}

			case 14 :
			$request = "select distinct galaxy, system".$row_field." from ".TABLE_UNIVERSE." where moon = '".$moon."' and ".$field." between ".$pub_since_21." and ".$pub_since_14;
			if ($pub_perimeter != 0) $request .= " and galaxy = ".intval($pub_perimeter);
			$request .= " order by galaxy, system, row limit 0, 51";
			$result = $db->sql_query($request);

			while ($row = $db->sql_fetch_assoc($result)) {
				$request = "select min(".$field.") from ".TABLE_UNIVERSE." where galaxy = ".$row["galaxy"]." and system = ".$row["system"];
				$result2 = $db->sql_query($request);
				list($last_update) = $db->sql_fetch_row($result2);
				$row["last_update"] = $last_update;

				$obsolete[14][] = $row;
			}

			case 7 :
			$request = "select distinct galaxy, system".$row_field." from ".TABLE_UNIVERSE." where moon = '".$moon."' and ".$field." between ".$pub_since_14." and ".$pub_since_7;
			if ($pub_perimeter != 0) $request .= " and galaxy = ".intval($pub_perimeter);
			$request .= " order by galaxy, system, row limit 0, 51";
			$result = $db->sql_query($request);

			while ($row = $db->sql_fetch_assoc($result)) {
				$request = "select min(".$field.") from ".TABLE_UNIVERSE." where galaxy = ".$row["galaxy"]." and system = ".$row["system"];
				$result2 = $db->sql_query($request);
				list($last_update) = $db->sql_fetch_row($result2);
				$row["last_update"] = $last_update;

				$obsolete[7][] = $row;
			}

			default: return $obsolete;
		}
	}

	return $obsolete;
}

/**
* Parsing des RE
* @param string $rawRE RE à parser
* @return array $return tableau de valeur pour les flotte/défense/bâtiment/recherche
*/
function parseRE ( $rawRE )
{
	$return = array ( 
		'planet_name' => '',
		'coordinates' => '',
		'dateRE' => '',
		'M' => -1,
		'C' => -1,
		'D' => -1,
		'CES' => -1,
		'CEF' => -1,
		'UdR' => -1,
		'UdN' => -1,
		'CSp' => -1,
		'HM' => -1,
		'HC' => -1,
		'HD' => -1,
		'Lab' => -1,
		'Ter' => -1,
		'DdR' => -1,
		'Silo' => -1,
		'BaLu' => -1,
		'Pha' => -1,
		'PoSa' => -1,
		'LM' => -1,
		'LLE' => -1,
		'LLO' => -1,
		'CG' => -1,
		'AI' => -1,
		'LP' => -1,
		'PB' => -1,
		'GB' => -1,
		'MIC' => -1,
		'MIP' => -1,
		'PT' => -1,
		'GT' => -1,
		'CLE' => -1,
		'CLO' => -1,
		'CR' => -1,
		'VB' => -1,
		'VC' => -1,
		'REC' => -1,
		'SE' => -1,
		'BMD' => -1,
		'SAT' => -1,
		'DST' => -1,
		'EDLM' => -1,
		'TRA' => -1,
		'Esp' => -1,
		'Ordi' => -1,
		'Armes' => -1,
		'Bouclier' => -1,
		'Protection' => -1,
		'NRJ' => -1,
		'HYP' => -1,
		'RC' => -1,
		'RI' => -1,
		'PH' => -1,
		'Laser' => -1,
		'Ions' => -1,
		'Plasma' => -1,
		'RRI' => -1,
		'Graviton' => -1,
		'Astrophysique' => -1,
		'metal' => -1,
		'cristal' => -1,
		'deuterium' => -1,
		'energie' => -1,
		'activite' => -1,
		'proba' => 0);
	$rawRE = stripslashes ( ereg_replace ( "\n|\r|\r\n", " \t", $rawRE ) );
	while ( preg_match ( '/(\d+)\.(\d+)/', $rawRE ) )
		$rawRE = preg_replace ( '/(\d+)\.(\d+)/', "$1$2", $rawRE );
	$match = false;
	$idx = 0;
	$regExp = array ( 
		'/.*Flotte(.*)D.fense(.*)B.timents(.*)Recherche(.*)/', 
		'/.*Flotte(.*)D.fense(.*)B.timents(.*)/', 
		'/.*Flotte(.*)D.fense(.*)/', 
		'/.*Flotte(.*)/', 
		'/.*/' 
	);

	if ( preg_match ( '/Mati.res premi.res sur (.*?) \[(\d+:\d+:\d+)\](?: \(Joueur \'.*?\'\))?[\s]*le (\d+-\d+ \d+:\d+:\d+)\s*M.tal:(\s)*(\d+)\s*Cristal:(\s)*(\d+)\s*Deut.rium:(\s)*(\d+)\s*Energie:(\s)*(\d+).*Probabilit. de destruction de la flotte d.espionnage( ?):([0-9]{1,3})%/', $rawRE, $reg ) )
	{
		$return['planet_name'] = trim ( $reg[1] );
		$return['coordinates'] = trim ( $reg[2] );
		$dateRE = trim ( $reg[3] );
		$tmp = explode ( ' ', $dateRE );
		list ( $mois, $jour ) = explode ( '-', $tmp[0] );
		list ( $heure, $minute, $seconde ) = explode ( ':', $tmp[1] );
		if ( $mois > date ( 'm' ) )
			$annee = date ( 'Y' ) - 1;
		else
			$annee = date ( 'Y' );
		$return['dateRE'] = mktime ( $heure, $minute, $seconde, $mois, $jour, $annee );
		$return['metal'] = trim ( $reg[5] );
		$return['cristal'] = trim ( $reg[7] );
		$return['deuterium'] = trim ( $reg[9] );
		$return['energie'] = trim ( $reg[11] );
		$return['proba'] = trim ( $reg[13] );
	
		preg_match ( '/dans les (\d+) derni.res minutes/', $rawRE, $reg );
		if ( isset ( $reg[1] ) ) $return['activite'] = $reg[1];
	
		do
		{
			if ( preg_match ( $regExp[$idx], $rawRE, $reg ) ){
				$match = true;
				continue;
			}
			$idx++;
		}while ( $match === false );
		if ( isset ( $reg[1] ) ) $total_flotte = trim ( $reg[1] );
		if ( isset ( $reg[2] ) ) $total_defense = trim ( $reg[2] );
		if ( isset ( $reg[3] ) ) $total_build = trim ( $reg[3] );
		if ( isset ( $reg[4] ) ) $total_search = trim ( $reg[4] );

		if ( isset ( $total_build ) ) {
			preg_match ( '/Mine de m.tal\s+(\d+)/', $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['M'] = $reg[1];
			else $return['M'] = 0;
			preg_match ( '/Mine de cristal\s+(\d+)/', $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['C'] = $reg[1];
			else $return['C'] = 0;
			preg_match ( '/Synth.tiseur de deut.rium\s+(\d+)/', $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['D'] = $reg[1];
			else $return['D'] = 0;
			preg_match ( '/Centrale .lectrique solaire\s+(\d+)/', $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['CES'] = $reg[1];
			else $return['CES'] = 0;
			preg_match ( '/Centrale .lectrique de fusion\s+(\d+)/', $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['CEF'] = $reg[1];
			else $return['CEF'] = 0;
			preg_match ( '/Usine de robots\s+(\d+)/', $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['UdR'] = $reg[1];
			else $return['UdR'] = 0;
			preg_match ( '/Usine de nanites\s+(\d+)/', $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['UdN'] = $reg[1];
			else $return['UdN'] = 0;
			preg_match ( '/Chantier spatial\s+(\d+)/', $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['CSp'] = $reg[1];
			else $return['CSp'] = 0;
			preg_match ( '/Hangar de m.tal\s+(\d+)/', $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['HM'] = $reg[1];
			else $return['HM'] = 0;
			preg_match ( '/Hangar de cristal\s+(\d+)/', $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['HC'] = $reg[1];
			else $return['HC'] = 0;
			preg_match ( '/R.servoir de deut.rium\s+(\d+)/', $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['HD'] = $reg[1];
			else $return['HD'] = 0;
			preg_match ( '/Laboratoire de recherche\s+(\d+)/', $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['Lab'] = $reg[1];
			else $return['Lab'] = 0;
			preg_match ( '/Terraformeur\s+(\d+)/', $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['Ter'] = $reg[1];
			else $return['Ter'] = 0;
			preg_match ( '/D.p.t de ravitaillement\s+(\d+)/', $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['DdR'] = $reg[1];
			else $return['DdR'] = 0;
			preg_match ( '/Silo de missiles\s+(\d+)/', $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['Silo'] = $reg[1];
			else $return['Silo'] = 0;
			preg_match ( '/Base lunaire\s+(\d+)/', $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['BaLu'] = $reg[1];
			else $return['BaLu'] = 0;
			preg_match ( '/Phalange de capteur\s+(\d+)/', $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['Pha'] = $reg[1];
			else $return['Pha'] = 0;
			preg_match ( '/Porte de saut spatial\s+(\d+)/', $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['PoSa'] = $reg[1];
			else $return['PoSa'] = 0;
		}
		if ( isset ( $total_defense ) ) {
			preg_match ( '/Lanceur de missiles\s+(\d+)/', $total_defense, $reg );
			if ( isset ( $reg[1] ) ) $return['LM'] = $reg[1];
			else $return['LM'] = 0;
			preg_match ( '/Artillerie laser l.g.re\s+(\d+)/', $total_defense, $reg );
			if ( isset ( $reg[1] ) ) $return['LLE'] = $reg[1];
			else $return['LLE'] = 0;
			preg_match ( '/Artillerie laser lourde\s+(\d+)/', $total_defense, $reg );
			if ( isset ( $reg[1] ) ) $return['LLO'] = $reg[1];
			else $return['LLO'] = 0;
			preg_match ( '/Canon de Gauss\s+(\d+)/', $total_defense, $reg );
			if ( isset ( $reg[1] ) ) $return['CG'] = $reg[1];
			else $return['CG'] = 0;
			preg_match ( '/Artillerie . ions\s+(\d+)/', $total_defense, $reg );
			if ( isset ( $reg[1] ) ) $return['AI'] = $reg[1];
			else $return['AI'] = 0;
			preg_match ( '/Lanceur de plasma\s+(\d+)/', $total_defense, $reg );
			if ( isset ( $reg[1] ) ) $return['LP'] = $reg[1];
			else $return['LP'] = 0;
			preg_match ( '/Petit bouclier\s+(\d+)/', $total_defense, $reg );
			if ( isset ( $reg[1] ) ) $return['PB'] = $reg[1];
			else $return['PB'] = 0;
			preg_match ( '/Grand bouclier\s+(\d+)/', $total_defense, $reg );
			if ( isset ( $reg[1] ) ) $return['GB'] = $reg[1];
			else $return['GB'] = 0;
			preg_match ( '/Missile Interception\s+(\d+)/', $total_defense, $reg );
			if ( isset ( $reg[1] ) ) $return['MIC'] = $reg[1];
			else $return['MIC'] = 0;
			preg_match ( '/Missile Interplan.taire\s+(\d+)/', $total_defense, $reg );
			if ( isset ( $reg[1] ) ) $return['MIP'] = $reg[1];
			else $return['MIP'] = 0;
		}
		if ( isset ( $total_flotte ) ) {
			preg_match ( '/Petit transporteur\s+(\d+)/', $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['PT'] = $reg[1];
			else $return['PT'] = 0;
			preg_match ( '/Grand transporteur\s+(\d+)/', $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['GT'] = $reg[1];
			else $return['GT'] = 0;
			preg_match ( '/Chasseur l.ger\s+(\d+)/', $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['CLE'] = $reg[1];
			else $return['CLE'] = 0;
			preg_match ( '/Chasseur lourd\s+(\d+)/', $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['CLO'] = $reg[1];
			else $return['CLO'] = 0;
			preg_match ( '/Croiseur\s+(\d+)/', $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['CR'] = $reg[1];
			else $return['CR'] = 0;
			preg_match ( '/Vaisseau de bataille\s+(\d+)/', $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['VB'] = $reg[1];
			else $return['VB'] = 0;
			preg_match ( '/Vaisseau de colonisation\s+(\d+)/', $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['VC'] = $reg[1];
			else $return['VC'] = 0;
			preg_match ( '/Recycleur\s+(\d+)/', $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['REC'] = $reg[1];
			else $return['REC'] = 0;
			preg_match ( '/Sonde espionnage\s+(\d+)/', $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['SE'] = $reg[1];
			else $return['SE'] = 0;
			preg_match ( '/Bombardier\s+(\d+)/', $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['BMD'] = $reg[1];
			else $return['BMD'] = 0;
			preg_match ( '/Satellite solaire\s+(\d+)/', $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['SAT'] = $reg[1];
			else $return['SAT'] = 0;
			preg_match ( '/Destructeur\s+(\d+)/', $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['DST'] = $reg[1];
			else $return['DST'] = 0;
			preg_match ( '/.toile de la mort\s+(\d+)/', $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['EDLM'] = $reg[1];
			else $return['EDLM'] = 0;
			preg_match ( '/Traqueur\s+(\d+)/', $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['TRA'] = $reg[1];
			else $return['TRA'] = 0;
		}
		if ( isset ( $total_search ) ) {
			preg_match ( '/Technologie Espionnage\s+(\d+)/', $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Esp'] = $reg[1];
			else $return['Esp'] = 0;
			preg_match ( '/Technologie Ordinateur\s+(\d+)/', $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Ordi'] = $reg[1];
			else $return['Ordi'] = 0;
			preg_match ( '/Technologie Armes\s+(\d+)/', $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Armes'] = $reg[1];
			else $return['Armes'] = 0;
			preg_match ( '/Technologie Bouclier\s+(\d+)/', $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Bouclier'] = $reg[1];
			else $return['Bouclier'] = 0;
			preg_match ( '/Technologie Protection des vaisseaux spatiaux\s+(\d+)/', $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Protection'] = $reg[1];
			else $return['Protection'] = 0;
			preg_match ( '/Technologie Energie\s+(\d+)/', $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['NRJ'] = $reg[1];
			else $return['NRJ'] = 0;
			preg_match ( '/Technologie Hyperespace\s+(\d+)/', $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Hyp'] = $reg[1];
			else $return['Hyp'] = 0;
			preg_match ( '/Réacteur . combustion\s+(\d+)/', $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['RC'] = $reg[1];
			else $return['RC'] = 0;
			preg_match ( '/Réacteur . impulsion\s+(\d+)/', $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['RI'] = $reg[1];
			else $return['RI'] = 0;
			preg_match ( '/Propulsion hyperespace\s+(\d+)/', $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['PH'] = $reg[1];
			else $return['PH'] = 0;
			preg_match ( '/Technologie Laser\s+(\d+)/', $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Laser'] = $reg[1];
			else $return['Laser'] = 0;
			preg_match ( '/Technologie Ions\s+(\d+)/', $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Ions'] = $reg[1];
			else $return['Ions'] = 0;
			preg_match ( '/Technologie Plasma\s+(\d+)/', $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Plasma'] = $reg[1];
			else $return['Plasma'] = 0;
			preg_match ( '/R.seau de recherche intergalactique\s+(\d+)/', $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['RRI'] = $reg[1];
			else $return['RRI'] = 0;
			preg_match ( '/Technologie Graviton\s+(\d+)/', $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Graviton'] = $reg[1];
			else $return['Graviton'] = 0;
			preg_match ( '/Technologie Astrophysique\s+(\d+)/', $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Astrophysique'] = $reg[1];
			else $return['Astrophysique'] = 0;
		}
		return ( $return );
	}
	else
		return false;
}

/**
* Reconstruction des RE
* @global $table_prefix, $db
* @param string $id_RE RE à reconstituer
* @return string $template_RE reconstitué
*/
function UNparseRE ( $id_RE )
{
	global $table_prefix, $db;
	$show = array ( 'flotte' => 0, 'defense' => 0, 'batiment' => 0, 'recherche' => 0 );
	$flotte = array ( 'PT' => 'Petit transporteur', 'GT' => 'Grand transporteur', 'CLE' => 'Chasseur léger', 'CLO' => 'Chasseur lourd', 
		'CR' => 'Croiseur', 'VB' => 'Vaisseau de bataille', 'VC' => 'Vaisseau de colonisation', 'REC' => 'Recycleur', 
		'SE' => 'Sonde espionnage', 'BMD' => 'Bombardier', 'DST' => 'Destructeur', 'EDLM' => 'Étoile de la mort', 
		'SAT' => 'Satellite solaire', 'TRA' => 'Traqueur' );
	$defs = array ( 'LM' => 'Lanceur de missiles', 'LLE' => 'Artillerie laser légère', 'LLO' => 'Artillerie laser lourde', 
		'CG' => 'Canon de Gauss', 'AI' => 'Artillerie à ions', 'LP' => 'Lanceur de plasma', 'PB' => 'Petit bouclier', 
		'GB' => 'Grand bouclier', 'MIC' => 'Missile interception', 'MIP' => 'Missile interplanétaire' );
	$bats = array ( 'M' => 'Mine de métal', 'C' => 'Mine de cristal', 'D' => 'Synthétiseur de deutérium', 
		'CES' => 'Centrale électrique solaire', 'CEF' => 'Centrale électrique de fusion', 'UdR' => 'Usine de robots', 
		'UdN' => 'Usine de nanites', 'CSp' => 'Chantier spatial', 'HM' => 'Hangar de métal', 'HC' => 'Hangar de cristal', 
		'HD' => 'Réservoir de deutérium', 'Lab' => 'Laboratoire de recherche', 'Ter' => 'Terraformeur', 
		'DdR' => 'Dépôt de ravitaillement', 'Silo' => 'Silo de missiles', 'BaLu' => 'Base lunaire', 'Pha' => 'Phalange de capteur', 
		'PoSa' => 'Porte de saut spatial' );
	$techs = array ( 'Esp' => 'Technologie Espionnage', 'Ordi' => 'Technologie Ordinateur', 'Armes' => 'Technologie Armes', 
		'Bouclier' => 'Technologie Bouclier', 'Protection' => 'Technologie Protection des vaisseaux spatiaux', 
		'NRJ' => 'Technologie Energie', 'Hyp' => 'Technologie Hyperespace', 'RC' => 'Technologie Réacteur à combustion', 
		'RI' => 'Technologie Réacteur à impulsion', 'PH' => 'Technologie Propulsion hyperespace', 'Laser' => 'Technologie Laser', 
		'Ions' => 'Technologie Ions', 'Plasma' => 'Technologie Plasma', 'RRI' => 'Réseau de recherche intergalactique', 
		'Graviton' => 'Technologie Graviton', 'Astrophysique' => 'Technologie Astrophysique' );
	$query = 'SELECT planet_name, coordinates, metal, cristal, deuterium, energie, activite, M, C, D, CES, CEF, UdR, UdN, CSp, HM, HC, 
		HD, Lab, Ter, Silo, DdR, BaLu, Pha, PoSa, LM, LLE, LLO, CG, AI, LP, PB, GB, MIC, MIP, PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, 
		DST, EDLM, SAT, TRA, Esp, Ordi, Armes, Bouclier, Protection, NRJ, Hyp, RC, RI, PH, Laser, Ions, Plasma, RRI, Graviton, Astrophysique, 
		dateRE, proba FROM ' . TABLE_PARSEDSPY . ' WHERE id_spy=' . $id_RE;
	$result = $db->sql_query ( $query );
	$row = $db->sql_fetch_assoc ( $result );
	
	$queryPlayerName = "SELECT player FROM " . TABLE_UNIVERSE . " WHERE concat(galaxy, ':', system, ':', row) = (SELECT coordinates FROM " . TABLE_PARSEDSPY . " WHERE id_spy=" . $id_RE . ")";
	$resultPN = $db->sql_query ( $queryPlayerName );
	$rowPN = $db->sql_fetch_assoc ( $resultPN );
	
	$sep_mille = ".";

	if ( preg_match ( '/\(Lune\)/', $row['planet_name'] ) )
		$moon = 1;
	else
		$moon = 0;
//	$dateRE = date ( 'd/m/Y H:i:s', $row['dateRE'] ); incompatible avec Speedsim
	$dateRE = date ( 'm-d H:i:s', $row['dateRE'] );
	$template = '<table border="0" cellpadding="2" cellspacing="0" align="center">
	<tr>
		<td class="l" colspan="4" class="c">Ressources sur ' . $row['planet_name'] . ' [' . $row['coordinates'] . '] (joueur \'' . $rowPN['player'] . '\') le ' . $dateRE . '</td>
	</tr>
	<tr>
		<td class="c" style="text-align:right;">Métal:</td>
		<th>' . number_format($row['metal'], 0, ',', $sep_mille) . '</th>
		<td class="c" style="text-align:right;">Cristal:</td>
		<th>' . number_format($row['cristal'], 0, ',', $sep_mille) . '</th>
	</tr>
	<tr>
		<td class="c" style="text-align:right;">Deutérium:</td>
		<th>'. number_format($row['deuterium'], 0, ',', $sep_mille) . '</th>
		<td class="c" style="text-align:right;">Energie:</td>
		<th>' . number_format($row['energie'], 0, ',', $sep_mille) . '</th>
	</tr>
	<tr>
		<th colspan="4">';
	if ( $row['activite'] > 0 ) 
		$template .= 'Le scanner des sondes a détecté des anomalies dans l\'atmosphère de cette planète, indiquant qu\'il y a eu une activité sur cette planète dans les ' . $row['activite'] . ' dernières minutes.';
	else
		$template .= 'Le scanner des sondes n\'a pas détecté d\'anomalies atmosphériques sur cette planète. Une activité sur cette planète dans la dernière heure peut quasiment être exclue.';
	$template .= '</th>
	</tr>' . "\n";
	foreach ( $flotte as $key=>$value )
	{
		if ( $row[$key] != -1 )
		{
			$show['flotte'] = 1;
			continue;
		}
	}
	if ( $show['flotte'] == 0 )
	{
		$query = 'SELECT PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, DST, EDLM, SAT, TRA FROM ' . TABLE_PARSEDSPY . ' WHERE 
			(PT <> -1 OR GT <> -1 OR CLE <> -1 OR CLO <> -1 OR CR <> -1 OR VB <> -1 OR VC <> -1 OR REC <> -1 OR SE <> -1 OR 
			BMD <> -1 OR DST <> -1 OR EDLM <> -1 OR SAT <> -1 OR TRA <> -1) AND coordinates = "' . $row['coordinates'] . '" 
			AND planet_name' . ( ( $moon == 0 ) ? ' NOT ':'' ) . ' LIKE "%(Lune)%" ORDER BY dateRE DESC LIMIT 0,1';
		$tmp_res = $db->sql_query ( $query );
		if ( $db->sql_numrows ( $tmp_res ) > 0 )
		{
			$tmp_row = $db->sql_fetch_assoc ( $tmp_res );
			$row = array_merge ( $row, $tmp_row );
			$show['flotte'] = 1;
		}
	}
	foreach ( $defs as $key=>$value )
	{
		if ( $row[$key] != -1 )
		{
			$show['flotte'] = 1;
			$show['defense'] = 1;
			continue;
		}
	}
	if ( $show['defense'] == 0 )
	{
		$query = 'SELECT LM, LLE, LLO, CG, AI, LP, PB, GB, MIC, MIP FROM ' . TABLE_PARSEDSPY . ' WHERE (LM <> -1 OR LLE <> -1 
			OR LLO <> -1 OR CG <> -1 OR AI <> -1 OR PB <> -1 OR GB <> -1 OR MIC <> -1 OR MIC <> -1) AND coordinates = "' . 
			$row['coordinates'] . '" AND planet_name' . ( ( $moon == 0 ) ? ' NOT ':'' ) . ' LIKE "%(Lune)%" ORDER BY dateRE DESC LIMIT 0,1';
		$tmp_res = $db->sql_query ( $query );
		if ( $db->sql_numrows ( $tmp_res ) > 0 )
		{
			$tmp_row = $db->sql_fetch_assoc ( $tmp_res );
			$row = array_merge ( $row, $tmp_row );
			$show['defense'] = 1;
		}
	}
	foreach ( $bats as $key=>$value )
	{
		if ( $row[$key] != -1 )
		{
			$show['flotte'] = 1;
			$show['defense'] = 1;
			$show['batiment'] = 1;
			continue;
		}
	}
	if ( $show['batiment'] == 0 )
	{
		$query = 'SELECT M, C, D, CES, CEF, UdR, UdN, CSp, HM, HC, HD, Lab, Ter, Silo, DdR, BaLu, Pha, PoSa FROM ' . 
			TABLE_PARSEDSPY . ' WHERE (M <> -1 OR C <> -1 OR D <> -1 OR CES <> -1 OR CEF <> -1 OR UdR <> -1 OR UdN <> -1 OR 
			CSp <> -1 OR HM <> -1 OR HC <> -1 OR HD <> -1 OR Lab <> -1 OR Ter <> -1 OR Silo <> -1 OR DdR <> -1 OR BaLu <> -1 
			OR Pha <> -1 OR PoSa <> -1) AND coordinates = "' . $row['coordinates'] . '" AND planet_name' . ( ( $moon == 0 ) ? ' NOT ':'' ) . 
			' LIKE "%(Lune)%" ORDER BY dateRE DESC LIMIT 0,1';
		$tmp_res = $db->sql_query ( $query );
		if ( $db->sql_numrows ( $tmp_res ) > 0 )
		{
			$tmp_row = $db->sql_fetch_assoc ( $tmp_res );
			$row = array_merge ( $row, $tmp_row );
			$show['batiment'] = 1;
		}
	}
	foreach ( $techs as $key=>$value )
	{
		if ( $row[$key] != -1 )
		{
			$show['flotte'] = 1;
			$show['defense'] = 1;
			$show['batiment'] = 1;
			$show['recherche'] = 1;
			continue;
		}
	}
	if ( $show['recherche'] == 0 )
	{
		$query = 'SELECT Esp, Ordi, Armes, Bouclier, Protection, NRJ, Hyp, RC, RI, PH, Laser, Ions, Plasma, RRI, Graviton, 
			Astrophysique FROM ' . TABLE_PARSEDSPY . ' WHERE (Esp <> -1 OR Ordi <> -1 OR Armes <> -1 OR Bouclier <> -1 OR 
			Protection <> -1 OR NRJ <> -1 OR Hyp <> -1 OR RC <> -1 OR RI <> -1 OR PH <> -1 OR Laser <> -1 OR Ions <> -1 OR 
			Plasma <> -1 OR RRI <> -1 OR Graviton <> -1 OR Astrophysique <> -1) AND coordinates = "' . $row['coordinates'] . '" 
			AND planet_name' . ( ( $moon == 0 ) ? ' NOT ':'' ) . ' LIKE "%(Lune)%" ORDER BY dateRE DESC LIMIT 0,1';
		$tmp_res = $db->sql_query ( $query );
		if ( $db->sql_numrows ( $tmp_res ) > 0 )
		{
			$tmp_row = $db->sql_fetch_assoc ( $tmp_res );
			$row = array_merge ( $row, $tmp_row );
			$show['recherche'] = 1;
		}
	}
	if ( $show['flotte'] == 1 )
	{
		$template .= '  <tr>
		<td class="l" colspan="4">Flotte</td>
	</tr>
	<tr>' . "\n";
		$count = 0;
		foreach ( $flotte as $key=>$value )
		{
			if ( $row[$key] > 0 )
			{
				$template .= '    <td class="c" style="text-align:right;">' . $flotte[$key] . '</td>
		<th>' . number_format($row[$key], 0, ',', $sep_mille) . '</th>' . "\n";
				if ( $count == 0 )
				{
					$count = 1;
				}
				else
				{
					$template .= '  </tr>
	<tr>' . "\n";
					$count = 0;
				}
			}
		}
		if ( $count == 1 ) $template .= '    <td class="c" style="text-align:right;">&nbsp;</td>
		<th>&nbsp;</th>' . "\n";
		$template .= '  </tr>' . "\n";
	}
	if ( $show['defense'] == 1 )
	{
		$template .= '  <tr>
		<td class="l" colspan="4">Défense</td>
	</tr>
	<tr>' . "\n";
		$count = 0;
		foreach ( $defs as $key=>$value )
		{
			if ( $row[$key] > 0 )
			{
				$template .= '    <td class="c" style="text-align:right;">' . $defs[$key] . '</td>
		<th>' . number_format($row[$key], 0, ',', $sep_mille) . '</th>' . "\n";
				if ( $count == 0 )
				{
					$count = 1;
				}
				else
				{
					$template .= '  </tr>
	<tr>' . "\n";
					$count = 0;
				}
			}
		}
		if ( $count == 1 ) $template .= '    <td class="c" style="text-align:right;">&nbsp;</td>
		<th>&nbsp;</th>' . "\n";
		$template .= '  </tr>' . "\n";
	}
	if ( $show['batiment'] == 1 )
	{
		$template .= '  <tr>
		<td class="l" colspan="4">Bâtiments</td>
	</tr>
	<tr>' . "\n";
		$count = 0;
		foreach ( $bats as $key=>$value )
		{
			if ( $row[$key] > 0 )
			{
				$template .= '    <td class="c" style="text-align:right;">' . $bats[$key] . '</td>
		<th>' . $row[$key] . '</th>' . "\n";
				if ( $count == 0 )
				{
					$count = 1;
				}
				else
				{
					$template .= '  </tr>
	<tr>' . "\n";
					$count = 0;
				}
			}
		}
		if ( $count == 1 ) $template .= '    <td class="c" style="text-align:right;">&nbsp;</td>
		<th>&nbsp;</th>' . "\n";
		$template .= '  </tr>' . "\n";
	}
	if ( $show['recherche'] == 1 )
	{
		$template .= '  <tr>
		<td class="l" colspan="4">Recherche</td>
	</tr>
	<tr>' . "\n";
		$count = 0;
		foreach ( $techs as $key=>$value )
		{
			if ( $row[$key] > 0 )
			{
				$template .= '    <td class="c" style="text-align:right;">' . $techs[$key] . '</td>
		<th>' . $row[$key] . '</th>' . "\n";
				if ( $count == 0 )
				{
					$count = 1;
				}
				else
				{
					$template .= '  </tr>
	<tr>' . "\n";
					$count = 0;
				}
			}
		}
		if ( $count == 1 ) $template .= '    <td class="c" style="text-align:right;">&nbsp;</td>
		<th>&nbsp;</th>' . "\n";
		$template .= '  </tr>' . "\n";
	}
	$template .= '  <tr>
		<th colspan="4">Probabilité de destruction de la flotte d\'espionnage :' . $row['proba'] . '%</th>
	</tr>
</table>';
	return ( $template );
}

/**
* Enregistrement des RE
* @global $db Connexion à la base de données
* @global $user_data Information sur l'utilisateur envoyant le RE
* @global $server_config Configuration du serveur
* @global $pub_action Action demandée par l'utilisateur
* @param string $rawRE RE à insérer dans la BDD
* @param optional int $sender_id Identifiant de l'utilisateur envoyant le RE
* @return boolean true si OK, false si erreur
*/
function insert_RE ( $rawRE, $sender_id = -1 )
{
	global $db, $user_data, $server_config, $pub_action;
	$parsedRE = array();
	$user_id = ( $sender_id != -1 ) ? $sender_id:$user_data['user_id'];
	
	if ( $parsedRE = parseRE ( $rawRE ) )
	{
		if ( $parsedRE['PT'] == -1 ) $limit = 0;
		elseif ( $parsedRE['LM'] == -1 ) $limit = 1;
		elseif ( $parsedRE['M'] == -1 ) $limit = 2;
		elseif ( $parsedRE['Esp'] == -1 ) $limit = 3;
		else $limit = 4;
		switch ( $limit )
		{
			case 0:
				$fields = 'planet_name, coordinates, metal, cristal, deuterium, energie, activite, dateRE, proba, sender_id';
				$values = array ( $parsedRE['planet_name'], $parsedRE['coordinates'], $parsedRE['metal'], $parsedRE['cristal'], 
					$parsedRE['deuterium'], $parsedRE['energie'], $parsedRE['activite'], $parsedRE['dateRE'], $parsedRE['proba'], 
					$user_id );
				break;
			case 1:
				$fields = 'planet_name, coordinates, metal, cristal, deuterium, energie, activite, PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, 
					DST, EDLM, SAT, TRA, dateRE, proba, sender_id';
				$values = array ( $parsedRE['planet_name'], $parsedRE['coordinates'], $parsedRE['metal'], $parsedRE['cristal'], 
					$parsedRE['deuterium'], $parsedRE['energie'], $parsedRE['activite'], $parsedRE['PT'], $parsedRE['GT'], $parsedRE['CLE'], 
					$parsedRE['CLO'], $parsedRE['CR'], $parsedRE['VB'], $parsedRE['VC'], $parsedRE['REC'], $parsedRE['SE'], $parsedRE['BMD'], 
					$parsedRE['DST'], $parsedRE['EDLM'], $parsedRE['SAT'], $parsedRE['TRA'], $parsedRE['dateRE'], $parsedRE['proba'], 
					$user_id );
				break;
			case 2:
				$fields = 'planet_name, coordinates, metal, cristal, deuterium, energie, activite, LM, LLE, LLO, CG, AI, LP, PB, GB, MIC, MIP, 
					PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, DST, EDLM, SAT, TRA, dateRE, proba, sender_id';
				$values = array ( $parsedRE['planet_name'], $parsedRE['coordinates'], $parsedRE['metal'], $parsedRE['cristal'], 
					$parsedRE['deuterium'], $parsedRE['energie'], $parsedRE['activite'], $parsedRE['LM'], $parsedRE['LLE'], $parsedRE['LLO'], 
					$parsedRE['CG'], $parsedRE['AI'], $parsedRE['LP'], $parsedRE['PB'], $parsedRE['GB'], $parsedRE['MIC'], $parsedRE['MIP'], 
					$parsedRE['PT'], $parsedRE['GT'], $parsedRE['CLE'], $parsedRE['CLO'], $parsedRE['CR'], $parsedRE['VB'], $parsedRE['VC'], 
					$parsedRE['REC'], $parsedRE['SE'], $parsedRE['BMD'], $parsedRE['DST'], $parsedRE['EDLM'], $parsedRE['SAT'], $parsedRE['TRA'], 
					$parsedRE['dateRE'], $parsedRE['proba'], $user_id );
				break;
			case 3:
				$fields = 'planet_name, coordinates, metal, cristal, deuterium, energie, activite, M, C, D, CES, CEF, UdR, UdN, CSp, HM, HC, HD, 
					Lab, Ter, DdR, Silo, BaLu, Pha, PoSa, LM, LLE, LLO, CG, AI, LP, PB, GB, MIC, MIP, PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, 
					DST, EDLM, SAT, TRA, dateRE, proba, sender_id';
				$values = array ( $parsedRE['planet_name'], $parsedRE['coordinates'], $parsedRE['metal'], $parsedRE['cristal'], 
					$parsedRE['deuterium'], $parsedRE['energie'], $parsedRE['activite'], $parsedRE['M'], $parsedRE['C'], $parsedRE['D'], 
					$parsedRE['CES'], $parsedRE['CEF'], $parsedRE['UdR'], $parsedRE['UdN'], $parsedRE['CSp'], $parsedRE['HM'], $parsedRE['HC'], 
					$parsedRE['HD'], $parsedRE['Lab'], $parsedRE['Ter'], $parsedRE['DdR'], $parsedRE['Silo'], $parsedRE['BaLu'], $parsedRE['Pha'], 
					$parsedRE['PoSa'], $parsedRE['LM'], $parsedRE['LLE'], $parsedRE['LLO'], $parsedRE['CG'], $parsedRE['AI'], $parsedRE['LP'], 
					$parsedRE['PB'], $parsedRE['GB'], $parsedRE['MIC'], $parsedRE['MIP'], $parsedRE['PT'], $parsedRE['GT'], $parsedRE['CLE'], 
					$parsedRE['CLO'], $parsedRE['CR'], $parsedRE['VB'], $parsedRE['VC'], $parsedRE['REC'], $parsedRE['SE'], $parsedRE['BMD'], 
					$parsedRE['DST'], $parsedRE['EDLM'], $parsedRE['SAT'], $parsedRE['TRA'], $parsedRE['dateRE'], $parsedRE['proba'], 
					$user_id );
				break;
			case 4:
				$fields = 'planet_name, coordinates, metal, cristal, deuterium, energie, activite, M, C, D, CES, CEF, UdR, UdN, CSp, HM, HC, HD, 
					Lab, Ter, DdR, Silo, BaLu, Pha, PoSa, LM, LLE, LLO, CG, AI, LP, PB, GB, MIC, MIP, PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, 
					DST, EDLM, SAT, TRA, Esp, Ordi, Armes, Bouclier, Protection, NRJ, Hyp, RC, RI, PH, Laser, Ions, Plasma, RRI, Graviton, 
					Astrophysique, dateRE, proba, sender_id';
				$values = array ( $parsedRE['planet_name'], $parsedRE['coordinates'], $parsedRE['metal'], $parsedRE['cristal'], 
					$parsedRE['deuterium'], $parsedRE['energie'], $parsedRE['activite'], $parsedRE['M'], $parsedRE['C'], $parsedRE['D'], 
					$parsedRE['CES'], $parsedRE['CEF'], $parsedRE['UdR'], $parsedRE['UdN'], $parsedRE['CSp'], $parsedRE['HM'], $parsedRE['HC'], 
					$parsedRE['HD'], $parsedRE['Lab'], $parsedRE['Ter'], $parsedRE['DdR'], $parsedRE['Silo'], $parsedRE['BaLu'], $parsedRE['Pha'], 
					$parsedRE['PoSa'], $parsedRE['LM'], $parsedRE['LLE'], $parsedRE['LLO'], $parsedRE['CG'], $parsedRE['AI'], $parsedRE['LP'], 
					$parsedRE['PB'], $parsedRE['GB'], $parsedRE['MIC'], $parsedRE['MIP'], $parsedRE['PT'], $parsedRE['GT'], $parsedRE['CLE'], 
					$parsedRE['CLO'], $parsedRE['CR'], $parsedRE['VB'], $parsedRE['VC'], $parsedRE['REC'], $parsedRE['SE'], $parsedRE['BMD'], 
					$parsedRE['DST'], $parsedRE['EDLM'], $parsedRE['SAT'], $parsedRE['TRA'], $parsedRE['Esp'], $parsedRE['Ordi'], 
					$parsedRE['Armes'], $parsedRE['Bouclier'], $parsedRE['Protection'], $parsedRE['NRJ'], $parsedRE['Hyp'], $parsedRE['RC'], 
					$parsedRE['RI'], $parsedRE['PH'], $parsedRE['Laser'], $parsedRE['Ions'], $parsedRE['Plasma'], $parsedRE['RRI'], 
					$parsedRE['Graviton'], $parsedRE['Astrophysique'], $parsedRE['dateRE'], $parsedRE['proba'], $user_id );
				break;
		}
		$query = 'SELECT id_spy FROM ' . TABLE_PARSEDSPY . ' WHERE coordinates = "' . $parsedRE['coordinates'] . '" AND dateRE = ' . $parsedRE['dateRE'];
		$res = $db->sql_query ( $query );
		if ( $db->sql_numrows ( $res ) == 0 )
		{
			$query = 'INSERT INTO ' . TABLE_PARSEDSPY . '(' . $fields . ') VALUES ("' . join ( '", "', $values ) . '")';
			if ( $db->sql_query ( $query ) )
			{
				list ( $galaxy, $system, $row ) = explode ( ':', $parsedRE['coordinates'] );
				$spy_added[] = 'galaxy=' . $galaxy . '&system=' . $system . '&row=' . $row;
				if ( preg_match ( '/ \(Lune\)/', $parsedRE['planet_name'] ) || ($parsedRE['planet_name'] == 'lune' && ! preg_match ( '/Mine/', $rawRE ) ) )
				{
					$request = 'SELECT last_update_moon from ' . TABLE_UNIVERSE . ' where galaxy = ' . $galaxy . ' and 
						system = ' . $system . ' and row = ' . $row;
					$result = $db->sql_query ( $request );
					list ( $last_update_moon ) = $db->sql_fetch_row ( $result );
					if ( $parsedRE['dateRE'] > $last_update_moon )
					{
						$request = 'UPDATE ' . TABLE_UNIVERSE . ' SET last_update_user_id = ' . $user_data['user_id'] . ', moon = "1", 
							last_update_moon = ' . $parsedRE['dateRE'] . ', last_update = ' . $parsedRE['dateRE'] . ', phalanx = ' . 
							$parsedRE['Pha'] . ', gate = "' . $parsedRE['PoSa'] . '" WHERE galaxy = ' . $galaxy . ' AND system = ' . $system . ' AND 
							row = ' . $row;
						$db->sql_query ( $request );
					}
				}
				else
				{
					$request = 'SELECT last_update from ' . TABLE_UNIVERSE . ' where galaxy = ' . $galaxy . ' and system = ' . $system . ' and 
						row = ' . $row;
					$result = $db->sql_query ( $request );
					list ( $last_update ) = $db->sql_fetch_row ( $result );
					if ( $parsedRE['dateRE'] > $last_update )
					{
						$request = 'UPDATE ' . TABLE_UNIVERSE . ' SET last_update = ' . $parsedRE['dateRE'] . ', last_update_user_id = ' . 
							$user_data['user_id'] . ', name = "' . mysql_real_escape_string ( $parsedRE['planet_name'] ) . '" WHERE galaxy = ' . 
							$galaxy . ' AND system = ' . $system . ' AND row = ' . $row;
						$db->sql_query ( $request );
					}
				}
				return true;
			}
		}
		return false;
	}
	else
		return false;
}

/**
* Enregistrement des RE "ancien format" vers le nouveau format
* @global $db Connexion à la base de données
* @return boolean true si OK, false si erreur
*/
function import_RE ()
{
	global $db;
	
	$rq = 'SELECT sender_id, rawdata, datadate, spy_galaxy, spy_system, spy_row FROM ' . TABLE_SPY;
	$res = $db->sql_query ( $rq );
	$error = false;
	while ( list ( $sender_id, $rawdata, $datadate, $spy_galaxy, $spy_system, $spy_row ) = $db->sql_fetch_row ( $res ) )
	{
		$rq = 'SELECT id_spy FROM ' . TABLE_PARSEDSPY . ' WHERE coordinates = "' . $spy_galaxy . ':' . $spy_system . ':' . $spy_row . '"
			AND dateRE=' . $datadate;
		$res_already_inserted = $db->sql_query ( $rq );
		$already_inserted = $db->sql_numrows ( $res_already_inserted );
		if ( $already_inserted == 1 || ! insert_RE ( $rawdata, $sender_id ) )
			$error = true;
	}
	return $error;
}
?>