<?php
/** $Id$ **/
/**
* Fonctions relatives aux données galaxies/planètes
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

// fichier des fonctions MIP (christ24)
// require_once("galaxybis.php"); <----- la seule fonction de ce fichier a été ajouté à la fin. (portee_missiles)

/**
* Vérification des droits OGSpy
* @param string $action Droit interrogé
*/

function galaxy_check_auth($action) {
	global $user_data, $user_auth;

	switch ($action) {
		case "import_planet":
		if ($user_auth["ogs_set_system"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		die(L_("incgal_AccesDenied")."\n".L_("incgal_NoRightExportSolarSystem")."\n");
		break;

		case "export_planet":
		if ($user_auth["ogs_get_system"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		die(L_("incgal_AccesDenied")."\n".L_("incgal_NoRightImportSolarSystem")."\n");
		break;

		case "import_spy":
		if ($user_auth["ogs_set_spy"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		die(L_("incgal_AccesDenied")."\n".L_("incgal_NoRightExportSpyReport")."\n");
		break;

		case "export_spy":
		if ($user_auth["ogs_get_spy"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		die(L_("incgal_AccesDenied")."\n".L_("incgal_NoRightImportSpyReport")."\n");
		break;

		case "import_ranking":
		if ($user_auth["ogs_set_ranking"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		die(L_("incgal_AccesDenied")."\n".L_("incgal_NoRightExportRankings")."\n");
		break;

		case "export_ranking":
		if ($user_auth["ogs_get_ranking"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		die(L_("incgal_AccesDenied")."\n".L_("incgal_NoRightImportRankings")."\n");
		break;

		case "drop_ranking" :
		if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_ranking"] != 1)
			redirection("?action=message&id_message=forbidden&info");
		break;

		case "set_ranking" :
		if (($user_auth["server_set_ranking"] != 1) && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
			redirection("?action=message&id_message=forbidden&info");
		break;

		case "set_rc" :
		if (($user_auth["server_set_rc"] != 1) && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
			redirection("?action=message&id_message=forbidden&info");
		break;

		default:
		die ("<!-- [ErrorFatal=18] ".L_("incgal_IncorrectData")." -->");
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
	// Controle des champs galaxy, system, row (compatibilité avec XTense <= 2.06b)
	check_coords_parsedRE();
	
	if (isset($pub_galaxy) && isset($pub_system)) {
		if (intval($pub_galaxy) < 1) $pub_galaxy = 1;
		if (intval($pub_galaxy) > intval($server_config['num_of_galaxies'])) $pub_galaxy = intval($server_config['num_of_galaxies']);
		if (intval($pub_system) < 1) $pub_system = 1;
		if (intval($pub_system) > intval($server_config['num_of_systems'])) $pub_system = intval($server_config['num_of_systems']);
	}

	$ally_protection = array();
	if ($server_config["ally_protection"] != "") $ally_protection = explode(",", $server_config["ally_protection"]);

	if (!isset($pub_galaxy) || !isset($pub_system)) {
		$pub_galaxy = $user_data["user_galaxy"];
		$pub_system = $user_data["user_system"];

		if ($pub_galaxy == 0 || $pub_system == 0) {
			$pub_galaxy = 1;
			$pub_system = 1;
		}
	}

	$request = "select row, name, name_ally, name_player, moon, phalanx, gate, last_update_moon, status, last_update, user_name";
	$request .= " from ".TABLE_UNIVERSE." ou, ".TABLE_USER." ,".TABLE_ALLY." oa, ".TABLE_PLAYER." op";
	$request .= " where user_id = last_update_user_id  and oa.id_ally = op.id_ally and ou.id_player = op.id_player";
	$request .= " and galaxy = $pub_galaxy and system = $pub_system order by row";
	
	$result = $db->sql_query($request);

	$population = array_fill(1, 15,  array("ally" => "", "player" => "", "moon" => "", "last_update_moon" => "", "phalanx" => "", "gate" => "", "planet" => "", "report_spy" => false, "report_rc" => false, "status" => "", "timestamp" => 0, "poster" => "", "hided" => ""));
	while (list($row, $planet, $ally, $player, $moon, $phalanx, $gate, $last_update_moon, $status, $timestamp, $poster) = $db->sql_fetch_row($result)) {
		$report_spy = 0;
		$request = "select id_spy from ".TABLE_PARSEDSPY." where active = '1' and galaxy = '$pub_galaxy' and system = '$pub_system' and row ='$row'";
		$result_2 = $db->sql_query($request);
		if ($db->sql_numrows($result_2) > 0) $report_spy = $db->sql_numrows($result_2);
		$report_rc = 0;
		$request = "select id_rc from ".TABLE_PARSEDRC." where galaxy = '$pub_galaxy' and system = '$pub_system' and row ='$row'";
		$result_2 = $db->sql_query($request);
		if ($db->sql_numrows($result_2) > 0) $report_rc = $db->sql_numrows($result_2);

		if (!in_array($ally, $ally_protection) || $ally == "" || $user_auth["server_show_positionhided"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
			$hided = false;
			if (in_array($ally, $ally_protection)) $hided = true;

			$population[$row] = array("ally" => $ally, "player" => $player, "moon" => $moon, "phalanx" => $phalanx, "gate" => $gate, "last_update_moon" => $last_update_moon, "planet" => $planet, "report_spy" => $report_spy, "status" => $status, "timestamp" => $timestamp, "poster" => $poster, "hided" => $hided, "report_rc" => $report_rc);
		}
		elseif (in_array($ally, $ally_protection)) {
			$population[$row] = array("ally" => "", "player" => "", "moon" => "", "phalanx" => "", "gate" => "", "last_update_moon" => "", "planet" => "", "report_spy" => "", "status" => "", "timestamp" => $timestamp, "poster" => $poster, "hided" => "", "report_rc" => $report_rc);
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

	$ally_protection = array();
	if ($server_config["ally_protection"] != "") $ally_protection = explode(",", $server_config["ally_protection"]);

	$request = "SELECT system, row, name, name_ally, name_player, moon, phalanx, gate, last_update_moon, status, last_update";
	$request .= " FROM ".TABLE_UNIVERSE." un, ".TABLE_PLAYER." pl, ".TABLE_ALLY." al";
	$request .= " WHERE un.id_player = pl.id_player AND pl.id_ally = al.id_ally AND galaxy = $pub_galaxy AND system between ".$pub_system_down." AND ".$pub_system_up;
	$request .= " ORDER BY system, row";
	$result = $db->sql_query($request);

	$population = array_fill($pub_system_down, ($pub_system_up - $pub_system_down + 1),  "");
	while (list($system, $row, $planet, $ally, $player, $moon, $phalanx, $gate, $last_update_moon, $status, $update) = $db->sql_fetch_row($result)) {
		if (!isset($last_update[$system])) $last_update[$system] = $update;
		elseif ($update < $last_update[$system]) $last_update[$system] = $update;

		$report_spy = 0;
		$request = "SELECT * from ".TABLE_PARSEDSPY." where active = '1' and galaxy = '$pub_galaxy' and system = '$system' and row ='$row'";
		$result_2 = $db->sql_query($request);
		if ($db->sql_numrows($result_2) > 0) $report_spy = $db->sql_numrows($result_2);

		if (!in_array($ally, $ally_protection) || $ally == "" || $user_auth["server_show_positionhided"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
			$hided = false;
			if (in_array($ally, $ally_protection)) $hided = true;

			$population[$system][$row] = array("ally" => $ally, "player" => $player, "moon" => $moon, "phalanx" => $phalanx, "gate" => $gate, "last_update_moon" => $last_update_moon, "planet" => $planet, "report_spy" => $report_spy, "status" => $status, "hided" => $hided);
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
		redirection("?action=message&id_message=errordata&info");
	}

	$search_result = array();
	$total_page = 0;
	$ally_protection = array();
	if ($server_config["ally_protection"] != "") $ally_protection = explode(",", $server_config["ally_protection"]);

	if (isset($pub_type_search) && (isset($pub_string_search) || (isset($pub_galaxy_down) && isset($pub_galaxy_up) && isset($pub_system_down) && isset($pub_system_up) && isset($pub_row_down) && isset($pub_row_up)))) {
		user_set_stat(null, null, 1);

		switch ($pub_type_search) {
			case "player" :
			if ($pub_string_search == "") break;
			$search = isset($pub_strict) ? $pub_string_search : "%".$pub_string_search."%";

			$select = "SELECT count(*)";
			$request .= " FROM ".TABLE_UNIVERSE." un, ".TABLE_USER." us, ".TABLE_PLAYER." pl, ".TABLE_ALLY." al";
			$request .= " WHERE last_update_user_id = user_id AND un.id_player = pl.id_player AND pl.id_ally = al.id_ally";
			$request .= " AND name_player like '".mysql_real_escape_string($search)."'";
			if ($user_auth["server_show_positionhided"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
				foreach ($ally_protection as $v) {
					$request .= " AND name_ally <> '".mysql_real_escape_string($v)."'";
				}
			}

			$result = $db->sql_query($select.$request);
			list($total_row) = $db->sql_fetch_row($result);

			$select = "SELECT galaxy, system, row, moon, phalanx, gate, last_update_moon, name_ally, name_player, status, last_update, user_name";
			$request = $select.$request;
			break;

			case "ally" :
			if ($pub_string_search == "") break;
			$search = isset($pub_strict) ? $pub_string_search : "%".$pub_string_search."%";

			$select = "SELECT count(*)";
			$request = " FROM ".TABLE_UNIVERSE." un, ".TABLE_USER." us, ".TABLE_PLAYER." pl, ".TABLE_ALLY." al";
			$request .= " WHERE last_update_user_id = user_id AND un.id_player = pl.id_player AND pl.id_ally = al.id_ally";
			$request .= " AND ally like '".mysql_real_escape_string($search)."'";
			if ($user_auth["server_show_positionhided"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
				foreach ($ally_protection as $v) {
					$request .= " AND name_ally <> '".mysql_real_escape_string($v)."'";
				}
			}

			$result = $db->sql_query($select.$request);
			list($total_row) = $db->sql_fetch_row($result);

			$select = "SELECT galaxy, system, row, moon, phalanx, gate, last_update_moon, name_ally, name_player, status, last_update, user_name";
			$request = $select.$request;
			break;

			case "planet" :
			if ($pub_string_search == "") break;
			$search = isset($pub_strict) ? $pub_string_search : "%".$pub_string_search."%";

			$select = "SELCT count(*)";
			$request = " FROM ".TABLE_UNIVERSE." un, ".TABLE_USER." us, ".TABLE_PLAYER." pl, ".TABLE_ALLY." al";
			$request .= " WHERE last_update_user_id = user_id AND un.id_player = pl.id_player AND pl.id_ally = al.id_ally";
			$request .= " AND name like '".mysql_real_escape_string($search)."'";
			if ($user_auth["server_show_positionhided"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
				foreach ($ally_protection as $v) {
					$request .= " AND name_ally <> '".mysql_real_escape_string($v)."'";
				}
			}

			$result = $db->sql_query($select.$request);
			list($total_row) = $db->sql_fetch_row($result);

			$select = "SELECT galaxy, system, row, moon, phalanx, gate, last_update_moon, name_ally, name_player, status, last_update, user_name";
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

			$select = "SELECT count(*)";
			$request = " FROM ".TABLE_UNIVERSE." un, ".TABLE_USER." us, ".TABLE_PLAYER." pl, ".TABLE_ALLY." al";
			$request .= " WHERE last_update_user_id = user_id AND un.id_player = pl.id_player AND pl.id_ally = al.id_ally";
			$request .= " AND galaxy between $galaxy_start AND $galaxy_end";
			$request .= " AND system between $system_start AND $system_end";
			if ($pub_row_active) {
				$request .= " AND row between $row_start AND $row_end";
			}

			$result = $db->sql_query($select.$request);
			list($total_row) = $db->sql_fetch_row($result);

			$select = "select galaxy, system, row, moon, phalanx, gate, last_update_moon, name_ally, name_player, status, last_update, user_name";
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
			$request = " FROM ".TABLE_UNIVERSE." un, ".TABLE_USER." us, ".TABLE_PLAYER." pl, ".TABLE_ALLY." al";
			$request .= " WHERE last_update_user_id = user_id AND un.id_player = pl.id_player AND pl.id_ally = al.id_ally AND moon = '1'";
			$request .= " AND galaxy between $galaxy_start AND $galaxy_end";
			$request .= " AND system between $system_start AND $system_end";
			if ($pub_row_active) {
				$request .= " AND row between $row_start AND $row_end";
			}
			if ($user_auth["server_show_positionhided"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
				foreach ($ally_protection as $v) {
					$request .= " AND name_ally <> '".mysql_real_escape_string($v)."'";
				}
			}

			$result = $db->sql_query($select.$request);
			list($total_row) = $db->sql_fetch_row($result);

			$select = "select galaxy, system, row, moon, phalanx, gate, last_update_moon, name_ally, name_player, status, last_update, user_name";
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

			$select = "SELECT count(*)";
			$request = " FROM ".TABLE_UNIVERSE." un, ".TABLE_USER." us, ".TABLE_PLAYER." pl, ".TABLE_ALLY." al";
			$request .= " WHERE last_update_user_id = user_id AND un.id_player = pl.id_player AND pl.id_ally = al.id_ally AND status like ('%i%')";
			$request .= " AND galaxy between $galaxy_start AND $galaxy_end";
			$request .= " AND system between $system_start AND $system_end";
			if ($pub_row_active) {
				$request .= " AND row between $row_start AND $row_end";
			}
			if ($user_auth["server_show_positionhided"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
				foreach ($ally_protection as $v) {
					$request .= " AND name_ally <> '".mysql_real_escape_string($v)."'";
				}
			}

			$result = $db->sql_query($select.$request);
			list($total_row) = $db->sql_fetch_row($result);

			$select = "select galaxy, system, row, moon, phalanx, gate, last_update_moon, name_ally, name_player, status, last_update, user_name";
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

			$select = "SELECT count(distinct pa.galaxy, pa.system, pa.u.row)";
			$request = " FROM ".TABLE_PARSEDSPY." pa, ".TABLE_UNIVERSE." un, ".TABLE_USER." us, ".TABLE_PLAYER." pl, ".TABLE_ALLY." al";
			$request .= " WHERE last_update_user_id = user_id AND un.id_player = pl.id_player AND pl.id_ally = al.id_ally";
			$request .= " AND active = '1' AND pa.galaxy = un.galaxy AND pa.system = un.system AND pa.row = un.row";
			$request .= " AND pa.galaxy between $galaxy_start AND $galaxy_end";
			$request .= " AND pa.system between $system_start AND $system_end";
			if ($pub_row_active) {
				$request .= " AND pa.row between $row_start AND $row_end";
			}
			if ($user_auth["server_show_positionhided"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
				foreach ($ally_protection as $v) {
					$request .= " and name_ally <> '".mysql_real_escape_string($v)."'";
				}
			}

			$result = $db->sql_query($select.$request);
			list($total_row) = $db->sql_fetch_row($result);

			$select = "SELECT distinct u.galaxy, u.system, u.row, moon, phalanx, gate, last_update_moon, name_ally, name_player, status, last_update, user_name";
			$request = $select.$request;
			break;
		}

		if (isset($request)) {
		if($pub_type_search=="spy") $prefix="u."; else $prefix = "";
			$order = " order by {$prefix}galaxy, {$prefix}system, {$prefix}row";
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
					$order = " order by {$prefix}galaxy".$order2.", {$prefix}system".$order2.", {$prefix}row".$order2."";
					break;

					case "2":
					$order = " order by ally".$order2.", player".$order2.", {$prefix}galaxy".$order2.", {$prefix}system".$order2.", {$prefix}row".$order2."";
					break;

					case "3":
					$order = " order by player".$order2.", {$prefix}galaxy".$order2.", {$prefix}system".$order2.", {$prefix}row".$order2."";
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
				$hided = false;
				if (in_array($row["ally"], $ally_protection)) $hided = true;

				$request = "select * from ".TABLE_PARSEDSPY." where active = '1' and galaxy = ".$row["galaxy"]." and system = ".$row["system"]." and row = ".$row["row"];
				$result_2 = $db->sql_query($request);
				$report_spy = $db->sql_numrows($result_2);
				$search_result[] = array("galaxy" => $row["galaxy"], "system" => $row["system"], "row" => $row["row"], "phalanx" => $row["phalanx"], "gate" => $row["gate"], "last_update_moon" => $row["last_update_moon"], "moon" => $row["moon"], "ally" => $row["ally"], "player" => $row["player"], "report_spy" => $report_spy, "status" => $row["status"], "timestamp" => $row["last_update"], "poster" => $row["user_name"], "hided" => $hided);
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

			$request = "select count(*) from ".TABLE_UNIVERSE." tu , ".TABLE_PLAYER." tp ";
			$request .= " where tu.id_player = tp.id_player and name_player = ''";
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
function galaxy_ally_listing ($type = 'ally' , $mask = '') {
	global $db;

	$ally_list = array();
	if($mask!='') $where =" where `{$type}` like '".mysql_real_escape_string($mask)."%'"; else $where = "";
	$request = "select distinct {$type} from ".TABLE_UNIVERSE.$where." order by {$type}";
	$result = $db->sql_query($request);
	while ($row = $db->sql_fetch_assoc($result)) {
		if ($row[$type] != "")	$ally_list[] = $row[$type];
	}

	return $ally_list;
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
		redirection("?action=message&id_message=errorfatal&info");
	}
	/* We explode the data received in lines */
	$lines = array();
	$lines = explode(chr(10), $pub_data);
//var_dump($lines);
	switch ($pub_datatype) {
		case "basic":
		/* Check if user can send data */
		if (($user_auth["server_set_system"] != 1 && $user_auth["server_set_spy"] != 1) && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
			redirection("?action=message&id_message=errorfatal&info");
		}
		/* if yes, skip the switch and continue after */
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
		redirection("?");

		default: redirection("?action=message&id_message=errorfatal&info");
	}

	$nb_lines = sizeof($lines);
	$files = $lines;
	$authentification = true;

	$checking = false;
	for ($i=0 ; $i<$nb_lines ; $i++) {
		$line = $lines[$i];

		if (preg_match(L_('Gal_rgx_solarsyst'), $line)) {
			if ($user_auth["server_set_system"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
				redirection("?action=message&id_message=errorfatal&info");
			}
			$lines = array_values($lines);
			$system_added = galaxy_system($lines);
			break;
		}
		elseif (preg_match(L_('Gal_rgx_resources'), $line)) {
			if ($user_auth["server_set_spy"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
				redirection("?action=message&id_message=errorfatal&info");
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

			redirection("?galaxy=$galaxy&system=$system");
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
				$reports .= $added."~".$coordinates."~".$timestamp."€";
			}
			$reports = substr($reports, 0, strlen($reports)-2);
			redirection("?action=message&id_message=spy_added&info=".$reports);
		}
	}

	galaxy_getsource_error($files);
	redirection("?action=message&id_message=errorfatal&info");
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
	$regExp = L_('Gal_rgx_line');
	for ($i=0 ; $i<sizeof($lines) ; $i++) {
		$line = $lines[$i];

		if (preg_match(L_('Gat_rgx_header'), trim($line), $arr)) {
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
					$status = ( isset ( $regs[5] ) && $regs[5] != L_('Gal_rgx_spying') ) ? $regs[5]:'';
					$ally = ( isset ( $regs[6] ) && $regs[6] != L_('Gal_rgx_spying') ) ? $regs[6]:'';
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
		foreach(L_('Gal_rgx_status') as $status_type)
			if (preg_match("#{$status_type}#", $values)) $status .= $status_type;

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
	preg_match_all ( L_('Spy_rgx_matiere1ere'), $reports, $report );
	foreach ( $report[0] as $spy )
	{
		$coordinates = explode ( ']', $spy );
			$coordinates = substr ( $coordinates[0], strrpos ( $coordinates[0], '[' ) + 1 );
			$timestamp = explode ( L_('Spy_rgx_split_date') , $spy );
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
* Récupération des rapports de combat
*/
function galaxy_reportrc_show() {
	global $db,$user_data;
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
		$request .= " where galaxy = '".intval($pub_galaxy)."' and system ='".intval($pub_system)."' and row = '".intval($pub_row)."'";
		$request .= " order by dateRC desc";
	}
	else {
		$request .= " where id_rc = ".intval($pub_rc_id);
	}
	$result = $db->sql_query($request);

	$reports = array();
	if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) 
		$delete_string =  "<div align='right'>".
		"<input type='button' value='Delete?' onclick=\"window.location = '?action=del_rc&amp;rc_id=%s&amp;galaxy={$pub_galaxy}&amp;system={$pub_system}&amp;row={$pub_row}';\">".
		"</div>\n";
	else
		$delete_string = "";
	while (list($pub_rc_id) = $db->sql_fetch_row($result))
		$reports[] = ($delete_string != ""?sprintf($delete_string,$pub_rc_id):"").UNparseRC ( $pub_rc_id );

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

	$request = "DELETE FROM ".TABLE_PARSEDSPY." where active = '0' or dateRE < ".(time()-60*60*24*$max_keepspyreport);
	$result = $db->sql_query($request);
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
		$request = "SELECT max(datadate) from ".$table[$i]["tablename"];
		$result = $db->sql_query($request);
		list($last_ranking) = $db->sql_fetch_row($result);
	}
	else $last_ranking = $pub_date;

	$request = "SELECT rank, name_player, name_ally, points, user_name";
	$request .= " FROM ".$table[$i]["tablename"]." ra, ".TABLE_USER." us, ".TABLE_PLAYER." pl, ".TABLE_ALLY." al";
	$request .= " WHERE ra.sender_id = us.user_id AND pl.id_player = ra.id_player AND pl.id_ally = al.id_ally";
	$request .= " AND rank between ".$limit_down." AND ".$limit_up.(isset($last_ranking) ? " AND datadate = ".mysql_real_escape_string($last_ranking) : "");
	$request .= " ORDER BY rank";
	$result = $db->sql_query($request);

	while (list($rank, $player, $ally, $points, $user_name) = $db->sql_fetch_row($result)) {
		$ranking[$player][$table[$i]["arrayname"]] = array("rank" => $rank, "points" => $points);
		$ranking[$player]["ally"] = $ally;
		$ranking[$player]["sender"] = $user_name;

		if ($pub_order_by == $table[$i]["arrayname"]) {
			$order[$rank] = $player;
		}
	}

	$request = "SELECT distinct datadate from ".$table[$i]["tablename"]." order by datadate desc";
	$result_2 = $db->sql_query($request);
	while ($row = $db->sql_fetch_assoc($result_2)) {
		$ranking_available[] = $row["datadate"];
	}

	for ($i ; $i<3 ; $i++) {
		reset($ranking);
		while ($value = current($ranking)) {
			$request = "SELECT rank, name_player, name_ally, points, user_name";
			$request .= " FROM ".$table[$i]["tablename"]." ra, ".TABLE_USER." us, ".TABLE_PLAYER." pl, ".TABLE_ALLY." al ";
			$request .= "WHERE ra.sender_id = us.user_id AND pl.id_player = ra.id_player AND pl.id_ally = al.id_ally";
			$request .= " AND name_player = '".mysql_real_escape_string(key($ranking))."'".(isset($last_ranking) ? " AND datadate = ".mysql_real_escape_string($last_ranking) : "");
			$request .= " ORDER BY rank";
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
		redirection("?action=message&id_message=errordata&info");
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
		$request = "SELECT max(datadate) from ".$table[$i]["tablename"];
		$result = $db->sql_query($request);
		list($last_ranking) = $db->sql_fetch_row($result);
	}
	else $last_ranking = $pub_date;

	$request = "SELECT rank, name_ally, number_member, points, points_per_member, user_name";
	$request .= " FROM ".$table[$i]["tablename"]." ra, ".TABLE_USER." us, ".TABLE_ALLY." al";
	$request .= " WHERE ra.sender_id = us.user_id AND ra.id_ally = al.id_ally";
	$request .= " AND rank between ".$limit_down." and ".$limit_up.(isset($last_ranking) ? " and datadate = ".mysql_real_escape_string($last_ranking) : "");
	$request .= " ORDER BY ".$pub_order_by2;
	$result = $db->sql_query($request);

	while (list($rank, $ally, $number_member, $points, $points_per_member, $user_name) = $db->sql_fetch_row($result)) {
		$ranking[$ally][$table[$i]["arrayname"]] = array("rank" => $rank, "points" => $points, "points_per_member" => $points_per_member);
		$ranking[$ally]["number_member"] = $number_member;
		$ranking[$ally]["sender"] = $user_name;

		if ($pub_order_by == $table[$i]["arrayname"]) {
			$order[$rank] = $ally;
		}
	}

	$request = "SELECT distinct datadate from ".$table[$i]["tablename"]." order by datadate desc";
	$result_2 = $db->sql_query($request);
	while ($row = $db->sql_fetch_assoc($result_2)) {
		$ranking_available[] = $row["datadate"];
	}

	for ($i ; $i<3 ; $i++) {
		reset($ranking);
		while ($value = current($ranking)) {
			$request = "SELECT rank, name_ally, number_member, points, points_per_member, user_name";
			$request .= " from ".$table[$i]["tablename"]." ra, ".TABLE_USER." us, ".TABLE_ALLY." al";
			$request .= " WHERE ra.sender_id = us.user_id AND ra.id_ally = al.id_ally";
			$request .= " AND name_ally = '".mysql_real_escape_string(key($ranking))."'".(isset($last_ranking) ? " and datadate = ".mysql_real_escape_string($last_ranking) : "");
			$request .= " ORDER BY rank";
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
	$request .= " from ".TABLE_RANK_PLAYER_POINTS." trpp, ".TABLE_PLAYER." op ";
	$request .= " where  trpp.id_player = op.id_player and name_player = '".mysql_real_escape_string($player)."'";
	$request .= " order by datadate desc";
	$result = $db->sql_query($request);
	while (list($datadate, $rank, $points) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["general"] = array("rank" => $rank, "points" => $points);
		if ($last) break;
	}

	$request = "select datadate, rank, points";
	$request .= " from ".TABLE_RANK_PLAYER_FLEET." trpf, ".TABLE_PLAYER." op ";
	$request .= " where  trpf.id_player = op.id_player and name_player = '".mysql_real_escape_string($player)."'";
	$request .= " order by datadate desc";
	$result = $db->sql_query($request);
	while (list($datadate, $rank, $points) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["fleet"] = array("rank" => $rank, "points" => $points);
		if ($last) break;
	}

	$request = "select datadate, rank, points";
	$request .= " from ".TABLE_RANK_PLAYER_RESEARCH." trpr, ".TABLE_PLAYER." op ";
	$request .= " where  trpr.id_player = op.id_player and name_player = '".mysql_real_escape_string($player)."'";
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
	$request .= " from ".TABLE_RANK_ALLY_POINTS." trap, ".TABLE_ALLY." oa ";
	$request .= " where trap.id_ally = oa.id_ally and name_ally = '".mysql_real_escape_string($ally)."'";
	$request .= " order by datadate desc";
	$result = $db->sql_query($request);
	while (list($datadate, $rank, $points, $number_member, $points_per_member) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["general"] = array("rank" => $rank, "points" => $points, "points_per_member" => $points_per_member);
		$ranking[$datadate]["number_member"] = $number_member;
		if ($last) break;
	}
	
	$request = "select datadate, rank, points, number_member, points_per_member";
	$request .= " from ".TABLE_RANK_ALLY_FLEET." trap, ".TABLE_ALLY." oa ";
	$request .= " where trap.id_ally = oa.id_ally and name_ally = '".mysql_real_escape_string($ally)."'";
	$request .= " order by datadate desc";
	$result = $db->sql_query($request);
	while (list($datadate, $rank, $points, $number_member, $points_per_member) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["fleet"] = array("rank" => $rank, "points" => $points, "points_per_member" => $points_per_member);
		$ranking[$datadate]["number_member"] = $number_member;
		if ($last) break;
	}
	
	$request = "select datadate, rank, points, number_member, points_per_member";
	$request .= " from ".TABLE_RANK_ALLY_RESEARCH." trap, ".TABLE_ALLY." oa ";
	$request .= " where trap.id_ally = oa.id_ally and name_ally = '".mysql_real_escape_string($ally)."'";
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

		default: redirection("?action=message&id_message=errorfatal&info");
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

			if (!$OK && preg_match(L_('Stat_rgx_play_header'), $line)) {
				$OK = true;
				$position = 0;
				continue;
			}

			if ($OK) {
				$files[] = $line;

				$index++;
				//3 lignes , Compatibilité 0.76 , les . dans les nombres http://ogsteam.fr/forums/viewtopic.php?pid=27522#p27522
				preg_match(L_('Stat_rgx_play_line'), $line, $arr);
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

			if (!$OK && preg_match(L_('Stat_rgx_ally_header'), $line)) {
				$OK = true;
				$position = 0;
				continue;
			}

			if ($OK) {
				$files[] = $line;

				$index++;
				//5 lignes , Compatibilité 0.76 , les . dans les nombres http://ogsteam.fr/forums/viewtopic.php?pid=27522#p27522 et posts suivants
				preg_match(L_('Stat_rgx_ally_line'), $line, $arr);
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
		redirection("?action=ranking");
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

	if (preg_match("#player#", $datatype)) redirection("?action=ranking&subaction=player");
	if (preg_match("#ally#", $datatype)) redirection("?action=ranking&subaction=ally");
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
		redirection("?action=message&id_message=errordata&info");
	}

	//Vérification des droits
	galaxy_check_auth("drop_ranking");

	if (!isset($pub_datadate) || !isset($pub_subaction)) {
		redirection("?");
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

	redirection("?action=ranking&subaction=".$pub_subaction);
}

/**
* Listing des phalanges
*/
function galaxy_get_phalanx($galaxy, $system) {
	global $db, $server_config, $user_data, $user_auth;

	$ally_protection = array();
	if ($server_config["ally_protection"] != "") $ally_protection = explode(",", $server_config["ally_protection"]);

	$phalanxer = array();

	$req = "select galaxy, system, row, phalanx, gate, name, name_ally, name_player from ".TABLE_UNIVERSE." tu, ".TABLE_PLAYER." tp, ".TABLE_ALLY." ta where tu.id_player = tp.id_player and tp.id_ally = ta.id_ally and galaxy = ".$galaxy." and moon = '1' and phalanx > 0 and system + (power(phalanx, 2) - 1) >= ".$system." and system - (power(phalanx, 2) - 1) <= ".$system;

	$result = $db->sql_query($req);
	while ($row = $db->sql_fetch_assoc($result)) {
		if (!in_array($row["ally"], $ally_protection) || $row["ally"] == "" || $user_auth["server_show_positionhided"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1){
			$range = ($row['phalanx']*$row['phalanx'] - 1);
			$range_up = ($a=$row['system']+$range)>($b=$server_config['num_of_systems'])?$b:$a;
			$range_down = ($a=$row['system']-$range)<1?1:$a;
			$phalanxer[] = Array(
				'user_name' => $row['name'],
				'user_ally' => $row['ally']!=''?$row['ally']:'&nbsp;',
				'galaxy' => $row['galaxy'],
				'system' => $row['system'],
				'coordinates' => "{$row['galaxy']}:{$row['system']}:{$row['row']}",
				'range_down' => $range_down,
				'range_up' => $range_up, 
			);
		}
	}

	return $phalanxer;
}

/**
* Listing des phalanges amies
*/
function galaxy_get_friendly_phalanx($galaxy, $system) {
	global $db, $server_config, $user_data, $user_auth;

	$retour = array();
	
	$req = "select a.user_id, a.coordinates, a.Pha, b.user_name from ".TABLE_USER_BUILDING." a, ".TABLE_USER." b where a.Pha > 0 and a.user_id=b.user_id";

	$result = $db->sql_query($req);
	while ($matches = $db->sql_fetch_assoc($result)) {
		$a_portee = false;
		if(!preg_match('/([0-9]{1,2})\:([0-9]{1,3})\:([0-9]{1,2})/',$matches['coordinates'],$position)) 
			continue;
		$diff = $matches['Pha']*$matches['Pha']-1;
		$matches['galaxy'] = $position[1];
		$matches['system'] = $position[2];
		$matches['range_down'] = ($position[2]-$diff < 1)? 1 : $position[2]-$diff;
		$max_syst=$server_config['num_of_systems'];
		$matches['range_up'] = ($position[2]+$diff > $max_syst)? $max_syst : $position[2]+$diff;
		if($galaxy==$matches['galaxy'] && $system>=$matches['range_down'] && $system<=$matches['range_up']) 
			$a_portee = true;
		if (($user_auth["server_show_positionhided"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) && $a_portee){
			$retour[] = $matches;
		}
	}
	return $retour;
}

/**
* Parsing des RE
* @param string $rawRE RE à parser
* @return array $return tableau de valeur pour les flotte/défense/bâtiment/recherche
*/
function parseRE ( $rawRE ) {
	$return = array (
		'planet_name' => '','coordinates' => '','galaxy' => -1,'system' => -1,'row' => -1,'dateRE' => '','M' => -1,'C' => -1,
		'D' => -1,'CES' => -1,'CEF' => -1,'UdR' => -1,'UdN' => -1,'CSp' => -1,'HM' => -1,'HC' => -1,'HD' => -1,'Lab' => -1,
		'Ter' => -1,'DdR' => -1,'Silo' => -1,'BaLu' => -1,'Pha' => -1,'PoSa' => -1,'LM' => -1,'LLE' => -1,'LLO' => -1,
		'CG' => -1,'AI' => -1,'LP' => -1,'PB' => -1,'GB' => -1,'MIC' => -1,'MIP' => -1,'PT' => -1,'GT' => -1,'CLE' => -1,
		'CLO' => -1,'CR' => -1,'VB' => -1,'VC' => -1,'REC' => -1,'SE' => -1,'BMD' => -1,'SAT' => -1,'DST' => -1,'EDLM' => -1,
		'TRA' => -1,'Esp' => -1,'Ordi' => -1,'Armes' => -1,'Bouclier' => -1,'Protection' => -1,'NRJ' => -1,'HYP' => -1,'RC' => -1,
		'RI' => -1,'PH' => -1,'Laser' => -1,'Ions' => -1,'Plasma' => -1,'RRI' => -1,'Graviton' => -1,'Expeditions' => -1,
		'metal' => -1,'cristal' => -1,'deuterium' => -1,'energie' => -1,'activite' => -1,'proba' => 0);
	$rawRE = stripslashes ( preg_replace ( "/\n|\r|\r\n/", " \t", $rawRE ) );
	while ( preg_match ( '/(\d+)\.(\d+)/', $rawRE ) )
		$rawRE = preg_replace ( '/(\d+)\.(\d+)/', "$1$2", $rawRE );
	$match = false;
	$idx = 0;
	$regExp = L_('Spy_rgx_global');

	if ( preg_match ( L_('Spy_rgx_firstline'), $rawRE, $reg ) )
	{
		$return['planet_name'] = trim ( $reg[1] );
		$return['coordinates'] = trim ( $reg[2] );
		list($return['galaxy'],$return['system'],$return['row']) = explode(":",$return['coordinates']);
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
		/* retreive the time of last activity */
		preg_match ( L_('Spy_rgx_activity'), $rawRE, $reg );
		if ( isset ( $reg[1] ) ) $return['activite'] = $reg[1];
		/* We try to define what is present in the RE from Fleets,Defense,Building,Research */
		do
		{
			if ( preg_match ( $regExp[$idx], $rawRE, $reg ) ){
				$match = true;
				continue;
			}
			$idx++;
		}
		while ( $match === false );
		
		if ( isset ( $reg[1] ) ) $total_flotte = trim ( $reg[1] );
		if ( isset ( $reg[2] ) ) $total_defense = trim ( $reg[2] );
		if ( isset ( $reg[3] ) ) $total_build = trim ( $reg[3] );
		if ( isset ( $reg[4] ) ) $total_search = trim ( $reg[4] );

		if ( isset ( $total_build ) ) {
			preg_match ( L_('Spy_rgx_metal'), $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['M'] = $reg[1];
			else $return['M'] = 0;
			preg_match ( L_('Spy_rgx_cristal'), $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['C'] = $reg[1];
			else $return['C'] = 0;
			preg_match ( L_('Spy_rgx_deut'), $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['D'] = $reg[1];
			else $return['D'] = 0;
			preg_match ( L_('Spy_rgx_ces'), $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['CES'] = $reg[1];
			else $return['CES'] = 0;
			preg_match ( L_('Spy_rgx_cef'), $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['CEF'] = $reg[1];
			else $return['CEF'] = 0;
			preg_match ( L_('Spy_rgx_robots'), $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['UdR'] = $reg[1];
			else $return['UdR'] = 0;
			preg_match ( L_('Spy_rgx_nanites'), $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['UdN'] = $reg[1];
			else $return['UdN'] = 0;
			preg_match ( L_('Spy_rgx_chspatial'), $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['CSp'] = $reg[1];
			else $return['CSp'] = 0;
			preg_match ( L_('Spy_rgx_hangarmetal'), $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['HM'] = $reg[1];
			else $return['HM'] = 0;
			preg_match ( L_('Spy_rgx_hangarcristal'), $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['HC'] = $reg[1];
			else $return['HC'] = 0;
			preg_match ( L_('Spy_rgx_hangardeut'), $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['HD'] = $reg[1];
			else $return['HD'] = 0;
			preg_match ( L_('Spy_rgx_labo'), $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['Lab'] = $reg[1];
			else $return['Lab'] = 0;
			preg_match ( L_('Spy_rgx_terra'), $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['Ter'] = $reg[1];
			else $return['Ter'] = 0;
			preg_match ( L_('Spy_rgx_ddr'), $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['DdR'] = $reg[1];
			else $return['DdR'] = 0;
			preg_match ( L_('Spy_rgx_silo'), $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['Silo'] = $reg[1];
			else $return['Silo'] = 0;
			preg_match ( L_('Spy_rgx_baselune'), $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['BaLu'] = $reg[1];
			else $return['BaLu'] = 0;
			preg_match ( L_('Spy_rgx_phalange'), $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['Pha'] = $reg[1];
			else $return['Pha'] = 0;
			preg_match ( L_('Spy_rgx_portesaut'), $total_build, $reg );
			if ( isset ( $reg[1] ) ) $return['PoSa'] = $reg[1];
			else $return['PoSa'] = 0;
		}
		if ( isset ( $total_defense ) ) {
			preg_match ( L_('Spy_rgx_missiles'), $total_defense, $reg );
			if ( isset ( $reg[1] ) ) $return['LM'] = $reg[1];
			else $return['LM'] = 0;
			preg_match ( L_('Spy_rgx_llegers'), $total_defense, $reg );
			if ( isset ( $reg[1] ) ) $return['LLE'] = $reg[1];
			else $return['LLE'] = 0;
			preg_match ( L_('Spy_rgx_llourds'), $total_defense, $reg );
			if ( isset ( $reg[1] ) ) $return['LLO'] = $reg[1];
			else $return['LLO'] = 0;
			preg_match ( L_('Spy_rgx_gauss'), $total_defense, $reg );
			if ( isset ( $reg[1] ) ) $return['CG'] = $reg[1];
			else $return['CG'] = 0;
			preg_match ( L_('Spy_rgx_ion'), $total_defense, $reg );
			if ( isset ( $reg[1] ) ) $return['AI'] = $reg[1];
			else $return['AI'] = 0;
			preg_match ( L_('Spy_rgx_plasma'), $total_defense, $reg );
			if ( isset ( $reg[1] ) ) $return['LP'] = $reg[1];
			else $return['LP'] = 0;
			preg_match ( L_('Spy_rgx_petitboucl'), $total_defense, $reg );
			if ( isset ( $reg[1] ) ) $return['PB'] = $reg[1];
			else $return['PB'] = 0;
			preg_match ( L_('Spy_rgx_grandboucl'), $total_defense, $reg );
			if ( isset ( $reg[1] ) ) $return['GB'] = $reg[1];
			else $return['GB'] = 0;
			preg_match ( L_('Spy_rgx_MI'), $total_defense, $reg );
			if ( isset ( $reg[1] ) ) $return['MIC'] = $reg[1];
			else $return['MIC'] = 0;
			preg_match ( L_('Spy_rgx_MIP'), $total_defense, $reg );
			if ( isset ( $reg[1] ) ) $return['MIP'] = $reg[1];
			else $return['MIP'] = 0;
		}
		if ( isset ( $total_flotte ) ) {
			preg_match ( L_('Spy_rgx_pt'), $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['PT'] = $reg[1];
			else $return['PT'] = 0;
			preg_match ( L_('Spy_rgx_gt'), $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['GT'] = $reg[1];
			else $return['GT'] = 0;
			preg_match ( L_('Spy_rgx_cle'), $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['CLE'] = $reg[1];
			else $return['CLE'] = 0;
			preg_match ( L_('Spy_rgx_clo'), $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['CLO'] = $reg[1];
			else $return['CLO'] = 0;
			preg_match ( L_('Spy_rgx_cro'), $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['CR'] = $reg[1];
			else $return['CR'] = 0;
			preg_match ( L_('Spy_rgx_vb'), $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['VB'] = $reg[1];
			else $return['VB'] = 0;
			preg_match ( L_('Spy_rgx_vcolo'), $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['VC'] = $reg[1];
			else $return['VC'] = 0;
			preg_match ( L_('Spy_rgx_recy'), $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['REC'] = $reg[1];
			else $return['REC'] = 0;
			preg_match ( L_('Spy_rgx_se'), $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['SE'] = $reg[1];
			else $return['SE'] = 0;
			preg_match ( L_('Spy_rgx_bomb'), $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['BMD'] = $reg[1];
			else $return['BMD'] = 0;
			preg_match ( L_('Spy_rgx_sat'), $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['SAT'] = $reg[1];
			else $return['SAT'] = 0;
			preg_match ( L_('Spy_rgx_destro'), $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['DST'] = $reg[1];
			else $return['DST'] = 0;
			preg_match ( L_('Spy_rgx_rip'), $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['EDLM'] = $reg[1];
			else $return['EDLM'] = 0;
			preg_match ( L_('Spy_rgx_traq'), $total_flotte, $reg );
			if ( isset ( $reg[1] ) ) $return['TRA'] = $reg[1];
			else $return['TRA'] = 0;
		}
		if ( isset ( $total_search ) ) {
			preg_match ( L_('Spy_rgx_espion'), $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Esp'] = $reg[1];
			else $return['Esp'] = 0;
			preg_match ( L_('Spy_rgx_ordi'), $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Ordi'] = $reg[1];
			else $return['Ordi'] = 0;
			preg_match ( L_('Spy_rgx_armes'), $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Armes'] = $reg[1];
			else $return['Armes'] = 0;
			preg_match ( L_('Spy_rgx_bouclier'), $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Bouclier'] = $reg[1];
			else $return['Bouclier'] = 0;
			preg_match ( L_('Spy_rgx_protect'), $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Protection'] = $reg[1];
			else $return['Protection'] = 0;
			preg_match ( L_('Spy_rgx_energie'), $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['NRJ'] = $reg[1];
			else $return['NRJ'] = 0;
			preg_match ( L_('Spy_rgx_technohspace'), $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Hyp'] = $reg[1];
			else $return['Hyp'] = 0;
			preg_match ( L_('Spy_rgx_combustion'), $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['RC'] = $reg[1];
			else $return['RC'] = 0;
			preg_match ( L_('Spy_rgx_impulsion'), $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['RI'] = $reg[1];
			else $return['RI'] = 0;
			preg_match ( L_('Spy_rgx_prophspace'), $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['PH'] = $reg[1];
			else $return['PH'] = 0;
			preg_match ( L_('Spy_rgx_laser'), $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Laser'] = $reg[1];
			else $return['Laser'] = 0;
			preg_match ( L_('Spy_rgx_t_ion'), $total_search, $reg ); 
			if ( isset ( $reg[1] ) ) $return['Ions'] = $reg[1];
			else $return['Ions'] = 0;
			preg_match ( L_('Spy_rgx_t_plasma'), $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Plasma'] = $reg[1];
			else $return['Plasma'] = 0;
			preg_match ( L_('Spy_rgx_rri'), $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['RRI'] = $reg[1];
			else $return['RRI'] = 0;
			preg_match ( L_('Spy_rgx_grav'), $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Graviton'] = $reg[1];
			else $return['Graviton'] = 0;
			preg_match ( L_('Spy_rgx_exped'), $total_search, $reg );
			if ( isset ( $reg[1] ) ) $return['Expeditions'] = $reg[1];
			else $return['Expeditions'] = 0;
		}
		return ( $return );
	}
	else
		return false;
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
function insert_RE ( $rawRE, $sender_id = -1 ) {
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
				$fields = 'planet_name, coordinates, galaxy, system, row, metal, cristal, deuterium, energie, activite, dateRE, proba, sender_id';
				$values = array ( $parsedRE['planet_name'], $parsedRE['coordinates'], $parsedRE['galaxy'], $parsedRE['system'], $parsedRE['row'], $parsedRE['metal'], $parsedRE['cristal'], 
					$parsedRE['deuterium'], $parsedRE['energie'], $parsedRE['activite'], $parsedRE['dateRE'], $parsedRE['proba'], 
					$user_id );
				break;
			case 1:
				$fields = 'planet_name, coordinates, galaxy, system, row, metal, cristal, deuterium, energie, activite, PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, 
					DST, EDLM, SAT, TRA, dateRE, proba, sender_id';
				$values = array ( $parsedRE['planet_name'], $planet['coordinates'], $parsedRE['galaxy'], $parsedRE['system'], $parsedRE['row'],$parsedRE['metal'],
					$parsedRE['cristal'], $parsedRE['deuterium'], $parsedRE['energie'], $parsedRE['activite'], $parsedRE['PT'],
					$parsedRE['GT'], $parsedRE['CLE'], $parsedRE['CLO'], $parsedRE['CR'], $parsedRE['VB'], $parsedRE['VC'], $parsedRE['REC'],
					$parsedRE['SE'], $parsedRE['BMD'], $parsedRE['DST'], $parsedRE['EDLM'], $parsedRE['SAT'], $parsedRE['TRA'], 
					$parsedRE['dateRE'], $parsedRE['proba'], $user_id );
				break;
			case 2:
				$fields = 'planet_name, coordinates, galaxy, system, row, metal, cristal, deuterium, energie, activite, LM, LLE, LLO, CG, AI, LP, PB, GB, MIC, MIP, 
					PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, DST, EDLM, SAT, TRA, dateRE, proba, sender_id';
				$values = array ( $parsedRE['planet_name'], $planet['coordinates'], $parsedRE['galaxy'], $parsedRE['system'], $parsedRE['row'],$parsedRE['metal'],
					$parsedRE['cristal'], $parsedRE['deuterium'], $parsedRE['energie'], $parsedRE['activite'], $parsedRE['LM'], $parsedRE['LLE'],
					$parsedRE['LLO'], $parsedRE['CG'], $parsedRE['AI'], $parsedRE['LP'], $parsedRE['PB'], $parsedRE['GB'], $parsedRE['MIC'],
					$parsedRE['MIP'], $parsedRE['PT'], $parsedRE['GT'], $parsedRE['CLE'], $parsedRE['CLO'], $parsedRE['CR'], $parsedRE['VB'],
					$parsedRE['VC'], $parsedRE['REC'], $parsedRE['SE'], $parsedRE['BMD'], $parsedRE['DST'], $parsedRE['EDLM'], $parsedRE['SAT'],
					$parsedRE['TRA'], $parsedRE['dateRE'], $parsedRE['proba'], $user_id );
				break;
			case 3:
				$fields = 'planet_name, coordinates, galaxy, system, row, metal, cristal, deuterium, energie, activite, M, C, D, CES, CEF, UdR, UdN, CSp, HM, HC, HD, 
					Lab, Ter, DdR, Silo, BaLu, Pha, PoSa, LM, LLE, LLO, CG, AI, LP, PB, GB, MIC, MIP, PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, 
					DST, EDLM, SAT, TRA, dateRE, proba, sender_id';
				$values = array ( $parsedRE['planet_name'], $planet['coordinates'], $parsedRE['galaxy'], $parsedRE['system'], $parsedRE['row'],$parsedRE['metal'],
					$parsedRE['cristal'], $parsedRE['deuterium'], $parsedRE['energie'], $parsedRE['activite'], $parsedRE['M'], $parsedRE['C'],
					$parsedRE['D'], $parsedRE['CES'], $parsedRE['CEF'], $parsedRE['UdR'], $parsedRE['UdN'], $parsedRE['CSp'], $parsedRE['HM'],
					$parsedRE['HC'], $parsedRE['HD'], $parsedRE['Lab'], $parsedRE['Ter'], $parsedRE['DdR'], $parsedRE['Silo'], $parsedRE['BaLu'],
					$parsedRE['Pha'], $parsedRE['PoSa'], $parsedRE['LM'], $parsedRE['LLE'], $parsedRE['LLO'], $parsedRE['CG'], $parsedRE['AI'],
					$parsedRE['LP'], $parsedRE['PB'], $parsedRE['GB'], $parsedRE['MIC'], $parsedRE['MIP'], $parsedRE['PT'], $parsedRE['GT'],
					$parsedRE['CLE'], $parsedRE['CLO'], $parsedRE['CR'], $parsedRE['VB'], $parsedRE['VC'], $parsedRE['REC'], $parsedRE['SE'],
					$parsedRE['BMD'], $parsedRE['DST'], $parsedRE['EDLM'], $parsedRE['SAT'], $parsedRE['TRA'], $parsedRE['dateRE'], 
					$parsedRE['proba'], $user_id );
				break;
			case 4:
				$fields = 'planet_name, coordinates, galaxy, system, row, metal, cristal, deuterium, energie, activite, M, C, D, CES, CEF, UdR, UdN, CSp, HM, HC, HD, 
					Lab, Ter, DdR, Silo, BaLu, Pha, PoSa, LM, LLE, LLO, CG, AI, LP, PB, GB, MIC, MIP, PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, 
					DST, EDLM, SAT, TRA, Esp, Ordi, Armes, Bouclier, Protection, NRJ, Hyp, RC, RI, PH, Laser, Ions, Plasma, RRI, Graviton, 
					Expeditions, dateRE, proba, sender_id';
				$values = array ( $parsedRE['planet_name'], $parsedRE['coordinates'], $parsedRE['galaxy'], $parsedRE['system'], $parsedRE['row'],$parsedRE['metal'],
					$parsedRE['cristal'], $parsedRE['deuterium'], $parsedRE['energie'], $parsedRE['activite'], $parsedRE['M'], $parsedRE['C'],
					$parsedRE['D'], $parsedRE['CES'], $parsedRE['CEF'], $parsedRE['UdR'], $parsedRE['UdN'], $parsedRE['CSp'], $parsedRE['HM'],
					$parsedRE['HC'], $parsedRE['HD'], $parsedRE['Lab'], $parsedRE['Ter'], $parsedRE['DdR'], $parsedRE['Silo'], $parsedRE['BaLu'],
					$parsedRE['Pha'], $parsedRE['PoSa'], $parsedRE['LM'], $parsedRE['LLE'], $parsedRE['LLO'], $parsedRE['CG'], $parsedRE['AI'],
					$parsedRE['LP'], $parsedRE['PB'], $parsedRE['GB'], $parsedRE['MIC'], $parsedRE['MIP'], $parsedRE['PT'], $parsedRE['GT'],
					$parsedRE['CLE'], $parsedRE['CLO'], $parsedRE['CR'], $parsedRE['VB'], $parsedRE['VC'], $parsedRE['REC'], $parsedRE['SE'],
					$parsedRE['BMD'], $parsedRE['DST'], $parsedRE['EDLM'], $parsedRE['SAT'], $parsedRE['TRA'], $parsedRE['Esp'], 
					$parsedRE['Ordi'], $parsedRE['Armes'], $parsedRE['Bouclier'], $parsedRE['Protection'], $parsedRE['NRJ'], $parsedRE['Hyp'],
					$parsedRE['RC'], $parsedRE['RI'], $parsedRE['PH'], $parsedRE['Laser'], $parsedRE['Ions'], $parsedRE['Plasma'], 
					$parsedRE['RRI'], $parsedRE['Graviton'], $parsedRE['Expeditions'], $parsedRE['dateRE'], $parsedRE['proba'], $user_id );
				break;
		}
		$query = 'SELECT id_spy FROM ' . TABLE_PARSEDSPY . ' WHERE galaxy = "' . $parsedRE['galaxy'] . '" AND galaxy = "' . $parsedRE['galaxy'] . '" AND galaxy = "' . $parsedRE['galaxy'] . '" AND dateRE = ' . $parsedRE['dateRE'];
		$res = $db->sql_query ( $query );
		if ( $db->sql_numrows ( $res ) == 0 )
		{
			$query = 'INSERT INTO ' . TABLE_PARSEDSPY . '(' . $fields . ') VALUES ("' . join ( '", "', $values ) . '")';
			if ( $db->sql_query ( $query ) )
			{
				//list ( $galaxy, $system, $row ) = explode ( ':', $parsedRE['coordinates'] );
				$spy_added[] = 'galaxy=' . $parsedRE['galaxy'] . '&amp;system=' . $parsedRE['system'] . '&amp;row=' . $parsedRE['row'];
				if ( preg_match ( '/ '.L_('Spy_Moon_rgx').'/', $parsedRE['planet_name'] ) || ($parsedRE['planet_name'] == 'lune' && ! preg_match ( '/Mine/', $rawRE ) ) )
				{
					$request = 'SELECT last_update_moon from ' . TABLE_UNIVERSE . ' where galaxy = ' . $parsedRE['galaxy'] . ' and 
						system = ' . $parsedRE['system'] . ' and row = ' . $parsedRE['row'];
					$result = $db->sql_query ( $request );
					list ( $last_update_moon ) = $db->sql_fetch_row ( $result );
					if ( $parsedRE['dateRE'] > $last_update_moon )
					{
						$request = 'UPDATE ' . TABLE_UNIVERSE . ' SET last_update_user_id = ' . $user_data['user_id'] . ', moon = "1", 
							last_update_moon = ' . $parsedRE['dateRE'] . ', last_update = ' . $parsedRE['dateRE'] . ', phalanx = ' . 
							$parsedRE['Pha'] . ', gate = "' . $parsedRE['PoSa'] . '" WHERE galaxy = ' . $parsedRE['galaxy'] . 
							' AND system = ' . $parsedRE['system'] . ' AND row = ' . $parsedRE['row'];
						$db->sql_query ( $request );
					}
				}
				else
				{
					$request = 'SELECT last_update from ' . TABLE_UNIVERSE . ' where galaxy = ' . $parsedRE['galaxy'] . ' and system = ' .
					$parsedRE['system'] . ' and row = ' . $parsedRE['row'];
					$result = $db->sql_query ( $request );
					list ( $last_update ) = $db->sql_fetch_row ( $result );
					if ( $parsedRE['dateRE'] > $last_update )
					{
						$request = 'UPDATE ' . TABLE_UNIVERSE . ' SET last_update = ' . $parsedRE['dateRE'] . ', last_update_user_id = ' . 
							$user_data['user_id'] . ', name = "' . mysql_real_escape_string ( $parsedRE['planet_name'] ) . '" WHERE galaxy = ' . 
							$parsedRE['galaxy'] . ' AND system = ' . $parsedRE['system'] . ' AND row = ' . $parsedRE['row'];
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
function import_RE () {
	global $db;
	
	$rq = 'SELECT sender_id, rawdata, datadate, spy_galaxy, spy_system, spy_row FROM ' . TABLE_SPY;
	$res = $db->sql_query ( $rq );
	$error = false;
	while ( list ( $sender_id, $rawdata, $datadate, $spy_galaxy, $spy_system, $spy_row ) = $db->sql_fetch_row ( $res ) )
	{
		$rq = 'SELECT id_spy FROM ' . TABLE_PARSEDSPY . ' WHERE galaxy = "' . $spy_galaxy . '" AND system = "' . $spy_system . 
		'" AND row = "' . $spy_row . '"	AND dateRE=' . $datadate;
		$res_already_inserted = $db->sql_query ( $rq );
		$already_inserted = $db->sql_numrows ( $res_already_inserted );
		if ( $already_inserted == 1 || ! insert_RE ( $rawdata, $sender_id ) )
			$error = true;
	}
	return $error;
}
/**
* Controle des espionnages de la table PARSED, vérification que les champs galaxy, system et row ne sont pas à -1 et qu'ils correspondent bien au chanmp coordinates 
* L'importation de RE depuis XTense <= 2.0b6 ne met pas à jour ces 3 champs.
* Si install vaut 1, alors la fonction est appellée depuis l'installation : dans ce cas, le champ galaxy n'existe peut-etre pas encore et alors on renvoit un tableau avec les requetes a éxécuter.
* Sinon, on fait les requetes.
*/
function check_coords_parsedRE($install = 0){
	global $db;
	// Recherche des espionnages dont les champs galaxy, system et row ne sont pas renseigné (= défaut soit 0)
	$to_update = Array();
	$return = Array();
	$result = $db->sql_query("SELECT `id_spy`, `coordinates` FROM ".TABLE_PARSEDSPY.($install==0?" WHERE `galaxy` = 0":""));
	while (list($id, $coordinates) = $db->sql_fetch_row($result)) 
		if(preg_match("/([0-9]{1,2})\:([0-9]{1,3})\:([0-9]{1,2})/",$coordinates,$matches))
			$to_update[$id] = Array($matches[1],$matches[2],$matches[3]);
	
	// Remplissage de ces champs par raport aux données de coordinates
	foreach($to_update as $the_id => $the_pos){
		$rq = "UPDATE ".TABLE_PARSEDSPY." SET `galaxy`={$the_pos[0]}, `system`={$the_pos[1]}, `row`={$the_pos[2]} WHERE `id_spy`={$the_id}";
		if($install==0)
			$db->sql_query($rq);
		else
			$return[] = $rq;
	}
	return $return;
}

/**
* Affichage de la portée des missiles dans la page galaxies
*/
function galaxy_get_mip_position ( $galaxy, $system ){
	global $user_data,$db,$server_config;
	$array_return = Array();
	// recherche niveau missile
	$request = 'SELECT user_id, planet_id, coordinates, Silo FROM ' . TABLE_USER_BUILDING . ' WHERE Silo >= 3';
	$req1 = $db->sql_query ( $request );

	while ( list ( $base_joueur, $base_id_planet, $base_coord, $base_missil ) = $db->sql_fetch_row ( $req1 ) ){   
		// sépare les coords
		if(!preg_match('/([0-9]{1})\:([0-9]{1,3})\:([0-9]{1,2})/',$base_coord,$matches)) continue;
		$request = "SELECT RI, MIP, user_name 
			FROM ".TABLE_USER_TECHNOLOGY." t, ".TABLE_USER_DEFENCE." d, ".TABLE_USER." u 
			WHERE t.user_id = {$base_joueur} AND d.user_id = {$base_joueur} AND u.user_id = {$base_joueur} AND d.planet_id = " . $base_id_planet;
		$req2 = $db->sql_query ( $request );
		list ( $niv_reac_impuls, $missil_dispo, $nom_missil_joueur ) = $db->sql_fetch_row ( $req2 );
        $galaxie_missil = $matches[1];
		$sysSol_missil = $matches[2];
		$planet_missil = $matches[3];
		$range = ( $niv_reac_impuls * 5 ) - 1;
		$position_up = ($a=$sysSol_missil+$range)>$server_config['num_of_systems']?$server_config['num_of_systems']:$a;
		$position_down = ($a=$sysSol_missil-$range)<1?1:$a;
		if($galaxy==$galaxie_missil && $system>=$position_down && $system<=$position_up)
			$array_return[] = Array(
				'user_name' => $nom_missil_joueur,
				'galaxy' => $galaxie_missil,
				'system' => $sysSol_missil,
				'coordinates' => $base_coord,
				'MIP' => !$missil_dispo?'0':$missil_dispo,
				'position_up' => $position_up,
				'position_down' => $position_down,
			);
	}
	return $array_return;
}


/**
 * Renvoi le code pour afficher un Tooltip sur un Joueur ou une Alliance
 */
function get_rank_tooltip($type,$name){
	global $tpl_global_defined;
	if($type=='player'){
		$title = L_('common_Player')."&nbsp;".$name;
		$ranking = galaxy_show_ranking_unique_player($name);
		$link = '?action=search&amp;type_search=player&amp;string_search='.urlencode($name)."&amp;strict=on";
	}else{
		$title = L_('common_Ally')."&nbsp;".$name;
		$ranking = galaxy_show_ranking_unique_ally($name);
		$link = '?action=search&amp;type_search=ally&amp;string_search='.urlencode($name)."&amp;strict=on";
	}
	$g_date = $g_rank = $g_points = "";
	$f_date = $f_rank = $f_points = "";
	$r_date = $r_rank = $r_points = "";
	if(!empty($ranking)){
		while(($rank = current($ranking)) && ($g_date=="" || $f_date=="" || $r_date=="")){
			$date =  key($ranking);
			if(isset($rank['general'])&&$g_date==""){
				$g_rank = $rank['general']['rank'];
				$g_points = formate_number($rank['general']['points']);
				$g_date = date(L_('common_Date'),$date);
			}
			if(isset($rank['fleet'])&&$f_date==""){
				$f_rank = $rank['fleet']['rank'];
				$f_points = formate_number($rank['fleet']['points']);
				$f_date = date(L_('common_Date'),$date);
			}
			if(isset($rank['research'])&&$r_date==""){
				$r_rank = $rank['research']['rank'];
				$r_points = formate_number($rank['research']['points']);
				$r_date = date(L_('common_Date'),$date);
			}
			next($ranking);
		}		
	}
	$code = $tpl_global_defined->GetDefined('rank_tip',Array(
		'g_rank' =>  $g_rank, 'g_points' => $g_points, 'g_date' => $g_date,
		'f_rank' =>  $f_rank, 'f_points' => $f_points, 'f_date' => $f_date,
		'r_rank' =>  $r_rank, 'r_points' => $r_points, 'r_date' => $r_date,
		'link' => $link,
	));
	$code = addslashes($code);
	$title = addslashes(($title));
	return TipFormat($tpl_global_defined->GetDefined('rank_tip_link',Array('tip'=>$code,'title'=>$title)));
}

/** 
 * Renvoi la chaine HTML correspondant au type donnée 
 *
 * Ajoute les tag de couleur ou de clignotement requis en fonction des configs, ainsi que le code de tooltip pour le rang si nécessaire
 */
function get_formated_string($type,$var,$show_tip=true,$show_link=true,$check_color=true){
	global $server_config,$user_data,$tpl_global_defined,$user_auth;
	$valid_type = Array('player','ally','planet','coordinates','spy','combat');
	if(!in_array($type,$valid_type)) return 'Err!';

	if($check_color && $type!='spy'){
		if (in_array($var, $server_config['ally_protection_array']) && $type=='ally') {
			$color = $server_config['ally_protection_color'];
		}	else {
			$scolor_type = explode("_",$server_config['scolor_type']);
			$scolor_color = explode("_",$server_config['scolor_color']);
			$scolor_text = explode("_|_",$server_config['scolor_text']);
			$var_t = bin2hex($var);
			foreach($scolor_text as $j => $text)
				if ($text != "")
					if(	(preg_match('`(^|,)'.$var_t.'($|,)`',bin2hex($text)) && $scolor_type[$j]=="J" && $type=='player' ) ||
						(preg_match('`(^|,)\{mine\}($|,)`',bin2hex($text)) && $var==$user_data["user_stat_name"] && $scolor_type[$j]=="J" && $type=='player') ||
						(preg_match('`(^|,)'.$var_t.'($|,)`',bin2hex($text)) && $scolor_type[$j]=="A" && $type=='ally')	)
							$color = $scolor_color[$j];
		}		
	}
	if($show_link){
		switch($type){
			case'player': $link = "?action=search&amp;type_search=player&amp;string_search=".urlencode($var)."&amp;strict=on"; break;
			case'ally': $link = "?action=search&amp;type_search=ally&amp;string_search=".urlencode($var)."&amp;strict=on"; break;
			case'planet': $link = "?action=search&amp;type_search=planet&amp;string_search=".urlencode($var)."&amp;strict=on"; break;
			case'spy': $link = "?action=show_reportspy&amp;galaxy={$var['galaxy']}&amp;system={$var['system']}&amp;row={$var['row']}"; break;
			case'combat': $link = "?action=show_reportrc&amp;galaxy={$var['galaxy']}&amp;system={$var['system']}&amp;row={$var['row']}"; break;
			case'coordinates': 
				list($g,$s,$r) = explode(':',$var);
				$link = "?action=galaxy&amp;galaxy={$g}&amp;system={$s}";
				break;
		}
	}
	if($show_tip){
		switch($type){
			case'player': $tip = get_rank_tooltip('player',$var); break;
			case'ally': $tip = get_rank_tooltip('ally',$var); break;
//			case'spy': $tip = get_RE_tooltip($var); break;
//			case'combat': $tip = get_RC_tooltip($var); break;
		}
	}
	$return = is_array($var)?$var['text']:$var;

	if(isset($color))
	{
		$return = $tpl_global_defined->GetDefined($color==''?'hided_blink':'hided_color',Array('content'=>$return,'color'=> $color));
	}
	if(isset($link)) 
		switch($type){
		case 'spy':
		case 'combat':
			$return = $tpl_global_defined->GetDefined('cell_windowopen',Array('content' => $return,'link' => $link)); break;
		default:
			$return = "<a href='{$link}'>{$return}</a>";
		}
	if(isset($tip)) $return = "<span onmouseover='{$tip}'>{$return}</span>";
	
	return $return;
}
?>
