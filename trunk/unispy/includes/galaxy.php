<?php
/**
*	filename	: galaxy.php
 * @version 1.0 Beta
* @package UniSpy
*  @author Kyser & OGSteam
*  @link http://www.ogsteam.fr
*  @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}


/**
* Verifie les droits utilisateurs
* NB: Ne renvoie pas de valeur redirige sur un message d'erreur si l'utilisateur n'a pas le droit verifi�
* @param string $action le type d'action verifi�
*/
function galaxy_check_auth($action) {
	global $user_data, $user_auth, $LANG;

	switch ($action) {
		case "import_planet":
		if ($user_auth["ogs_set_system"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		die("<!-- [AccessDenied] ".$LANG["incgal_AccesDenied"]." -->"."\n"."<!-- ".$LANG["incgal_NoRightExportSolarSystem"]." -->"."\n");
		break;

		case "export_planet":
		if ($user_auth["ogs_get_system"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		die("<!-- [AccessDenied] ".$LANG["incgal_AccesDenied"]." -->"."\n"."<!-- ".$LANG["incgal_NoRightImportSolarSystem"]." -->"."\n");
		break;

		case "import_spy":
		if ($user_auth["ogs_set_spy"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		die("<!-- [AccessDenied] ".$LANG["incgal_AccesDenied"]." -->"."\n"."<!-- ".$LANG["incgal_NoRightExportSpyReport"]." -->"."\n");
		break;

		case "export_spy":
		if ($user_auth["ogs_get_spy"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		die("<!-- [AccessDenied] ".$LANG["incgal_AccesDenied"]." -->"."\n"."<!-- ".$LANG["incgal_NoRightImportSpyReport"]." -->"."\n");
		break;

		case "import_ranking":
		if ($user_auth["ogs_set_ranking"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		die("<!-- [AccessDenied] ".$LANG["incgal_AccesDenied"]." -->"."\n"."<!-- ".$LANG["incgal_NoRightExportRankings"]." -->"."\n");
		break;

		case "export_ranking":
		if ($user_auth["ogs_get_ranking"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		die("<!-- [AccessDenied] ".$LANG["incgal_AccesDenied"]." -->"."\n"."<!-- ".$LANG["incgal_NoRightImportRankings"]." -->"."\n");
		break;

		case "drop_ranking" :
		if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_ranking"] != 1)
		redirection("index.php?action=message&id_message=forbidden&info");
		break;

		case "set_ranking" :
		if (($user_auth["server_set_ranking"] != 1) && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
			redirection("index.php?action=message&id_message=forbidden&info");
		}
		break;

		default:
		die ("<!-- [ErrorFatal=18] ".$LANG["incgal_IncorrectData"]."  -->");
	}
}

/**
* Renvoi un tableau contenant les donn�es galaxies selon les param�tres du formulaire $pub_*
* @return array Le tableau contenant les donn�es galaxies
*/
function galaxy_show() {
	global $db, $user_data, $user_auth, $server_config;
	global $pub_galaxy, $pub_system, $pub_coordinates;

	if (isset($pub_coordinates)) {
		@list($pub_galaxy, $pub_system) = explode(":", $pub_coordinates);
	}
	if (isset($pub_galaxy) && isset($pub_system)) {
		if (intval($pub_galaxy) < 1) $pub_galaxy = 1;
		if (intval($pub_galaxy) > $server_config["nb_galaxy"]) $pub_galaxy = $server_config["nb_galaxy"];
		if (intval($pub_system) < 1) $pub_system = 1;
		if (intval($pub_system) > $server_config["nb_system"]) $pub_system = $server_config["nb_system"];
	}

	$ally_protection = $allied = array();

  if (($server_config["ally_protection"] != "") && ($user_auth["hidden_allys"] != "")) 
      $ally_protection = explode(",", $server_config["ally_protection"].",".$user_auth["hidden_allys"]);
  elseif ($server_config["ally_protection"] != "")
      $ally_protection = explode(",", $server_config["ally_protection"]);
	if ($server_config["allied"] != "") $allied = explode(",", $server_config["allied"]);

	if (!isset($pub_galaxy) || !isset($pub_system)) {
		$pub_galaxy = $user_data["user_galaxy"];
		$pub_system = $user_data["user_system"];

		if ($pub_galaxy == 0 || $pub_system == 0) {
			$pub_galaxy = 1;
			$pub_system = 1;
		}
	}

	$request = "select row, name, ally, player, status, last_update, user_name";
	$request .= " from ".TABLE_UNIVERSE." left join ".TABLE_USER;
	$request .= " on user_id = last_update_user_id";
	$request .= " where galaxy = $pub_galaxy and system = $pub_system order by row";
	$result = $db->sql_query($request);

	$population = array_fill(1, $server_config["nb_row"],  array("ally" => "", "player" => "", "planet" => "", "report_spy" => false, "status" => "", "timestamp" => "", "poster" => "", "hided" => "", "allied" => ""));
	while (list($row, $planet, $ally, $player, $status, $timestamp, $poster) = $db->sql_fetch_row($result)) {
		$report_spy = 0;
		$request = "select * from ".TABLE_SPY." where active = '1' and spy_galaxy = $pub_galaxy and spy_system = $pub_system and spy_row = $row";
		$result_2 = $db->sql_query($request);
		if ($db->sql_numrows($result_2) > 0) $report_spy = $db->sql_numrows($result_2);

		if (!in_array($ally, $ally_protection) || $ally == "" || $user_auth["server_show_positionhided"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
			$hided = $friend = false;
			if (in_array($ally, $ally_protection)) $hided = true;
			if (in_array($ally, $allied)) $friend = true;

			$population[$row] = array("ally" => $ally, "player" => $player, "planet" => $planet, "report_spy" => $report_spy, "status" => $status, "timestamp" => $timestamp, "poster" => $poster, "hided" => $hided, "allied" => $friend);
		}
		elseif (in_array($ally, $ally_protection)) {
			$population[$row] = array("ally" => "", "player" => "", "planet" => "", "report_spy" => "", "status" => "", "timestamp" => $timestamp, "poster" => $poster, "hided" => "", "allied" => "");
		}
	}

	return array("population" => $population, "galaxy" => $pub_galaxy, "system" => $pub_system);
}


/**
* todo: A documenter
*/
function galaxy_show_sector() {
	global $db, $server_config, $user_data, $user_auth;
	global $pub_galaxy, $pub_system_down, $pub_system_up;

	if (isset($pub_galaxy) && isset($pub_system_down) && isset($pub_system_up)) {
		if (intval($pub_galaxy) < 1) $pub_galaxy = 1;
		if (intval($pub_galaxy) > $server_config["nb_galaxy"]) $pub_galaxy = $server_config["nb_galaxy"];
		if (intval($pub_system_down) < 1) $pub_system_down = 1;
		if (intval($pub_system_down) > $server_config["nb_system"]) $pub_system_down = $server_config["nb_system"];
		if (intval($pub_system_up) < 1) $pub_system_up = 1;
		if (intval($pub_system_up) > $server_config["nb_system"]) $pub_system_up = $server_config["nb_system"];
	}

	if (!isset($pub_galaxy) || !isset($pub_system_down) || !isset($pub_system_up)) {
		$pub_galaxy = 1;
		$pub_system_down = 1;
		$pub_system_up = 25;
	}

	$ally_protection = $allied = array();
// ajout test Naqdazar -> inclusion test ($user_auth["hidden_allys"] != "")
  if (($server_config["ally_protection"] != "") && ($user_auth["hidden_allys"] != "")) 
      $ally_protection = explode(",", $server_config["ally_protection"].",".$user_auth["hidden_allys"]);
  elseif ($server_config["ally_protection"] != "")
      $ally_protection = explode(",", $server_config["ally_protection"]);
	if ($server_config["allied"] != "") $allied = explode(",", $server_config["allied"]);

	$request = "select system, row, name, ally, player, status, last_update";
	$request .= " from ".TABLE_UNIVERSE;
	$request .= " where galaxy = $pub_galaxy and system between ".$pub_system_down." and ".$pub_system_up;
	$request .= " order by system, row";
	$result = $db->sql_query($request);

	$population = array_fill($pub_system_down, $pub_system_up,  "");
	while (list($system, $row, $planet, $ally, $player, $status, $update) = $db->sql_fetch_row($result)) {
		if (!isset($last_update[$system])) $last_update[$system] = $update;
		elseif ($update < $last_update[$system]) $last_update[$system] = $update;

		$report_spy = 0;
		$request = "select * from ".TABLE_SPY." where active = '1' and spy_galaxy = $pub_galaxy and spy_system = $system and spy_row = $row";
		$result_2 = $db->sql_query($request);
		if ($db->sql_numrows($result_2) > 0) $report_spy = $db->sql_numrows($result_2);

		if (!in_array($ally, $ally_protection) || $ally == "" || $user_auth["server_show_positionhided"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
			$hided = $friend = false;
			if (in_array($ally, $ally_protection)) $hided = true;
			if (in_array($ally, $allied)) $friend = true;

			$population[$system][$row] = array("ally" => $ally, "player" => $player, "planet" => $planet, "report_spy" => $report_spy, "status" => $status, "hided" => $hided, "allied" => $friend);
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
* @return array le resultat
*/
function galaxy_search() {
	global $db, $user_data, $server_config;
	global $pub_string_search, $pub_type_search, $pub_strict, $pub_sort, $pub_sort2, $pub_galaxy_down, $pub_galaxy_up, $pub_system_down, $pub_system_up, $pub_row_down, $pub_row_up, $pub_row_active, $pub_page;

	$user_auth = user_get_auth($user_data["user_id"]);

//	if (!check_var($pub_string_search, "Char") || !check_var($pub_type_search, "Char") || !check_var($pub_strict, "Char") ||
	if (!check_var($pub_type_search, "Char") || !check_var($pub_strict, "Char") ||
	!check_var($pub_sort, "Num") || !check_var($pub_sort2, "Num") || !check_var($pub_galaxy_down, "Num") ||
	!check_var($pub_galaxy_up, "Num") || !check_var($pub_system_down, "Num") || !check_var($pub_system_up, "Num") ||
	!check_var($pub_row_down, "Num") || !check_var($pub_row_up, "Num") || !check_var($pub_row_active, "Char") ||
	!check_var($pub_page, "Num")) {
		redirection("index.php?action=message&id_message=errordata&info");
	}

	$search_result = array();
	$total_page = 0;
	$ally_protection = $allied = array();
	// ajout test Naqdazar -> inclusion test ($user_auth["hidden_allys"] != "")
  if (($server_config["ally_protection"] != "") && ($user_auth["hidden_allys"] != "")) 
      $ally_protection = explode(",", $server_config["ally_protection"].",".$user_auth["hidden_allys"]);
  elseif ($server_config["ally_protection"] != "")
      $ally_protection = explode(",", $server_config["ally_protection"]);
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

			$select = "select galaxy, system, row, ally, player, status, last_update, user_name";
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

			$select = "select galaxy, system, row, impulsion, silo, ally, player, status, last_update, user_name";
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

			$select = "select galaxy, system, row, impulsion, silo, ally, player, status, last_update, user_name";
			$request = $select.$request;
			break;

			case "colonization" :
			$galaxy_start = intval($pub_galaxy_down);
			$galaxy_end = intval($pub_galaxy_up);
			$system_start = intval($pub_system_down);
			$system_end = intval($pub_system_up);
			$row_start = intval($pub_row_down);
			$row_end = intval($pub_row_up);

			if ($galaxy_start < 1 || $galaxy_start > $server_config["nb_galaxy"] || $galaxy_end < 1 || $galaxy_end > $server_config["nb_galaxy"]) break;
			if ($system_start < 1 || $system_start > $server_config["nb_system"] || $system_end < 1 || $system_end > $server_config["nb_system"]) break;
			if ($pub_row_active) {
				if ($row_start < 1 || $row_start > $server_config["nb_row"] || $row_end < 1 || $row_end > $server_config["nb_row"]) break;
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

			$select = "select galaxy, system, row, impulsion, silo, ally, player, status, last_update, user_name";
			$request = $select.$request;
			break;

			$result = $db->sql_query($select.$request);
			list($total_row) = $db->sql_fetch_row($result);

			$select = "select galaxy, system, row, ally, player, status, last_update, user_name";
			$request = $select.$request;
			break;

			case "away" :
			$galaxy_start = intval($pub_galaxy_down);
			$galaxy_end = intval($pub_galaxy_up);
			$system_start = intval($pub_system_down);
			$system_end = intval($pub_system_up);
			$row_start = intval($pub_row_down);
			$row_end = intval($pub_row_up);

			if ($galaxy_start < 1 || $galaxy_start > $server_config["nb_galaxy"] || $galaxy_end < 1 || $galaxy_end > $server_config["nb_galaxy"]) break;
			if ($system_start < 1 || $system_start > $server_config["nb_system"] || $system_end < 1 || $system_end > $server_config["nb_system"]) break;
			if ($pub_row_active) {
				if ($row_start < 1 || $row_start > $server_config["nb_row"] || $row_end < 1 || $row_end > $server_config["nb_row"]) break;
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

			$select = "select galaxy, system, row, ally, player, status, last_update, user_name";
			$request = $select.$request;
			break;

			case "spy" :
			$galaxy_start = intval($pub_galaxy_down);
			$galaxy_end = intval($pub_galaxy_up);
			$system_start = intval($pub_system_down);
			$system_end = intval($pub_system_up);
			$row_start = intval($pub_row_down);
			$row_end = intval($pub_row_up);

			if ($galaxy_start < 1 || $galaxy_start > $server_config["nb_galaxy"] || $galaxy_end < 1 || $galaxy_end > $server_config["nb_galaxy"]) break;
			if ($system_start < 1 || $system_start > $server_config["nb_system"] || $system_end < 1 || $system_end > $server_config["nb_system"]) break;
			if ($pub_row_active) {
				if ($row_start < 1 || $row_start > $server_config["nb_row"] || $row_end < 1 || $row_end > $server_config["nb_row"]) break;
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

			$select = "select distinct galaxy, system, row, ally, player, status, last_update, user_name";
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
				$search_result[] = array("galaxy" => $row["galaxy"], "system" => $row["system"], "row" => $row["row"], "ally" => $row["ally"], "player" => $row["player"], "report_spy" => $report_spy, "status" => $row["status"], "timestamp" => $row["last_update"], "poster" => $row["user_name"], "hided" => $hided, "allied" => $friend);
			}
		}
	}
	return array($search_result, $total_page);
}

/**
* R�cup�ration des statistiques des galaxies
* @param int $step optional Divisions de systemes 50 par d�faut
* @return array 'map','nb_planets','nb_planets_free' 
*/
function galaxy_statistic($step = 50) {
	global $db, $user_data , $server_config;

	$nb_planets_total = 0;
	$nb_freeplanets_total = 0;
	for ($galaxy=1 ; $galaxy<=$server_config["nb_galaxy"] ; $galaxy++) {
		for ($system=1 ; $system<=$server_config["nb_system"] ; $system=$system+$step) {
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
			
			$statictics[$galaxy][$system] = array("planet" => $nb_planet, "free" => $nb_planet_free, "new" => $new, "last_update" => $last_update);
		}
	}

	return array("map" =>$statictics, "nb_planets" => $nb_planets_total, "nb_planets_free" => $nb_freeplanets_total);
}

/**
* Listing des alliances
* @return array
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

//R�cup�ration position alliance
function galaxy_ally_position ($step = 50) {
	global $db, $user_auth, $user_data, $server_config;
	global $pub_ally_1, $pub_ally_2, $pub_ally_3;

	if (!check_var($pub_ally_1, "Text") || !check_var($pub_ally_2, "Text") || !check_var($pub_ally_3, "Text")) {
		redirection("index.php?action=message&id_message=errordata&info");
	}

	if (!isset($pub_ally_1) || !isset($pub_ally_2) || !isset($pub_ally_3)) {
		return array();
	}

	$pub_ally_protection = $allied = array();
	if ($server_config["ally_protection"] != "") $pub_ally_protection = explode(",", $server_config["ally_protection"]);
	if ($server_config["allied"] != "") $allied = explode(",", $server_config["allied"]);

	$statictics = array();
	$pub_ally_list = array($pub_ally_1, $pub_ally_2, $pub_ally_3);

	foreach ($pub_ally_list as $pub_ally_name) {
		if ($pub_ally_name == "") continue;
		if (in_array($pub_ally_name, $pub_ally_protection) && $user_auth["server_show_positionhided"] == 0 && $user_data["user_admin"] == 0 && $user_data["user_coadmin"] == 0) {
			$statictics[$pub_ally_name][0][0] = null;
			continue;
		}
		$friend = false;
		if (in_array($pub_ally_name, $allied)) $friend = true;

		for ($galaxy=1 ; $galaxy<=$server_config["nb_galaxy"] ; $galaxy++) {
			for ($system=1 ; $system<=$server_config["nb_system"] ; $system=$system+$step) {
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

//Enregistrer des donn�es erron�es envoy�es via le navigateur
function galaxy_getsource_error($datas) {
	global $user_data, $server_config;

	if ($server_config["debug_log"] == "1") {
		$nomfichier = PATH_LOG_TODAY.date("ymd_His")."_ID".$user_data["user_id"]."_Error.txt";
		write_file($nomfichier, "w", $datas);
	}
}


/**
* R�cup�ration des donn�es transmises via le navigateur
* {@source 2 2}
*/
function galaxy_getsource() {
	global $db, $user_data, $user_auth, $server_config, $LANG;
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
				
		if (preg_match("#".$LANG["SolarSystem"]."#", $line)) {
			if ($user_auth["server_set_system"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
				redirection("index.php?action=message&id_message=errorfatal&info");
			}
			$lines = array_values($lines);
			$system_added = galaxy_system($lines);
			break;
		}
		elseif (preg_match($LANG["Resources"], $line)) {
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
			$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + ".$server_config["nb_row"]."";
			$request .= " where statistic_name = 'planetimport_server'";
			
			$db->sql_query($request);
			if ($db->sql_affectedrows() == 0) {
				$request = "insert ignore into ".TABLE_STATISTIC." values ('planetimport_server', '".$server_config["nb_row"]."')";
				$db->sql_query($request);
			}

			redirection("index.php?galaxy=$galaxy&system=$system");
		}
	}
	if (isset($report_added)) {
		if ($report_added !== false) {

			if ($server_config["debug_log"] == "1") {
				//Sauvegarde donn�es tranmises
				$nomfichier = PATH_LOG_TODAY.date("ymd_His")."_ID".$user_data["user_id"]."_spy(".sizeof($report_added).").txt";
				write_file($nomfichier, "w", $files);
			}
			log_("load_spy", sizeof($report_added));

			//Statistiques serveur
			/*//Incompatible MySQL 4.0
			$request = "insert into ".TABLE_STATISTIC." values ('spyimport_server', '".sizeof($report_added)."')";
			$request .= " on duplicate key update statistic_value = statistic_value + ".sizeof($report_added)."";
			$db->sql_query($request);*/
			$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + ".sizeof($report_added);
			$request .= " where statistic_name = 'spyimport_server'";
			$db->sql_query($request);
			if ($db->sql_affectedrows() == 0) {
				$request = "insert ignore into ".TABLE_STATISTIC." values ('spyimport_server', '".sizeof($report_added)."')";
				$db->sql_query($request);
			}

			$reports = "";
			foreach ($report_added as $v) {
				list($added, $coordinates, $timestamp) = $v;
				$reports .= $added."~".$coordinates."~".$timestamp."�";
			}
			$reports = substr($reports, 0, strlen($reports)-3);
			redirection("index.php?action=message&id_message=spy_added&info=".$reports);
		}
	}

	galaxy_getsource_error($files);
	redirection("index.php?action=message&id_message=errorfatal&info");
}


/**
* Ajout des donn�es d'un syst�me
* @param string $lines Les donn�es copi�s/coll�s
* @return array coorddon�es du systeme ajout� ['galaxy'],['system']
*/
function galaxy_system($lines) {
	global  $LANG, $server_config;
	$OK = false;
	$status = array_fill(1, $server_config["nb_row"], "");
	$galaxy = ""; $system = "";
	$now = time();


	for ($i=0 ; $i<=sizeof($lines) ; $i++) {
		$line = "";
		if ($i<sizeof($lines)) {
			$line = $lines[$i];
		
		
		}

		if (preg_match("#^".$LANG["SolarSystem"]." (\d+):(\d{1,3})$#", trim($line), $arr)) {
		
			$galaxy = $arr[1];
			$system = $arr[2];
			continue;
		}
		
		//if (preg_match("#^(\d+).*\(([^)\d*]+)\)?#", $line, $arr)) {	
		if (preg_match("#^(\d+).*\(([a-zA-Z]{1}|\+[\d]{1,2})\)?#", $line, $arr)) {				

			if (preg_match("/".$LANG['symbol_inactive']."/", $arr[2])) $status[$arr[1]] .= "i";
			if (preg_match("/".$LANG['symbol_Inactive']."/", $arr[2])) $status[$arr[1]] .= "I";

		}
		if (ereg($LANG["Inactive"], $line)) {
			$solar_system = array_fill(1, $server_config["nb_row"],  array("planet" => "", "ally" => "", "player" => "", "status" => ""));
			$OK = true;
			continue;
		}
		if (ereg($LANG["Legend"], $line)) {
			$OK = false;
			continue;
		}

		if ($OK) {
			$planet = "";
			$ally = "";
			$player = "";
			
			for ($i=$i ; $i<sizeof($lines) ; $i++) {
				$line = trim($lines[$i]);
				$line = str_replace(chr(9), " ", $line);
				
				if (preg_match("#^".$LANG["Ally"]."#", $line)) {   // l'alliance � forcement un champ 'alliance_end', du moins en fr et org.
				
					$pos_space = strpos($line, " ");
					$pos_end = strpos($line, $LANG["alliance_end"]);
					if ($pos_end !== false) {
						$ally = substr($line, $pos_space, ($pos_end-$pos_space));
						
					}
					else {
					
						if ($line != $LANG["Alliance_Page"] && $line != $LANG["Alliance_Homepage"])
						  {   $ally = substr($line, $pos_space);  }
						
					}
					
					$ally = trim($ally);

					
					continue;
				}

				// le player n'a pas forcement un champ 'alliance_end', du moins en fr et org.
				if (preg_match("#^".$LANG["Player"]."#", $line) || preg_match("#".$LANG["player_end"]."#", $line)) {

				
					if (preg_match("#^".$LANG["Player"]."#", $line))
					{			 $pos_begin =strpos($line,' ');  }
					
					else
						$pos_begin =0;
				
				/*
					if (preg_match("#".$LANG["player_end"]."#", $line))
						$pos_end = strpos($line, $LANG["player_end"]);

					else*/
						$pos_end = strlen($line);
						$pos_comma = strpos($line, " (");
						if ($pos_comma == "") $pos_comma=$pos_end;
						
						
							$player = substr($line, $pos_begin, ($pos_comma-$pos_begin));
							//$player = substr($line, $pos_begin, ($pos_end-$pos_begin));
							
						
					/*if (preg_match("#^".$LANG["Player"]."#", $line))			//seconde v�rification, needed for others languages, probably later.
					{		$pos_begin =strpos($line,' ');
							$pos_end = strlen($line);
							$player = substr($line, $pos_begin, ($pos_end-$pos_begin));
					}
					*/
					//echo"<br>POF: ".$player."<br>";
						$player = trim($player);
						continue;
				}

				if (preg_match("#^".$LANG["Planet"]."#", $line)) {
					
					$pos_space = strpos($line, " ");
					$pos_bracket_l = strrpos($line, "[");
					$pos_bracket_r = strrpos($line, "]");
					
					$planet = substr($line, $pos_space, ($pos_bracket_l-$pos_space));
					$planet = trim($planet);
					
					$coordinates = substr($line, ($pos_bracket_l+1), ($pos_bracket_r-$pos_bracket_l-1));
					list(, , $row) = explode(":", $coordinates);

					if (!check_var($galaxy, "Num") || !check_var($system, "Num") || !check_var($row, "Num") ||
					!check_var($planet, "Galaxy") || !check_var($ally, "Galaxy") || !check_var($player, "Galaxy")) {
						redirection("index.php?action=message&id_message=errordata&info");
					}

					$solar_system[$row] = array("galaxy" => $galaxy, "system" => $system, "row" => $row, "planet" => $planet, "ally" => $ally, "player" => $player, "status" => $status[$row]);
					
					$planet = "";
					$ally = "";
					$player = "";
					continue;
				}				

			}

			$row = 1;
			foreach ($solar_system as $v) {
				if ($galaxy != "" && $system != "") {
					if(!galaxy_add_system($galaxy, $system, $row, $v["planet"], $v["ally"], $v["player"], $v["status"], $now)) {
						return false;
					}
				}
				$row++;
			}

			break;
		}
	}
	if (!$OK && $galaxy <> "" && $system <> "") {
		for ($row=1 ; $row<=$server_config["nb_row"] ; $row++) {
			galaxy_add_system($galaxy, $system, $row, "0", "", "", "", "", $now);
			
		}
	}
	galaxy_add_system_ally();

	return array($galaxy, $system);
}


/**
* R�cup�ration des donn�es transmises par OGS
*/
function galaxy_ImportPlanets() {
	global $db, $user_data, $server_config,$LANG;
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

	$require = array("galaxy", "system", "row", "datetime", "planetname", "allytag", "playername", "status", "sendername");
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
			die ("<!-- [ErrorFatal=12] Donn�es transmises incorrectes  -->");
		}

		$result = galaxy_add_system($galaxy, $system, $row, $planetname, $allytag, $playername, $status, $timestamp, true);
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
		//Sauvegarde donn�es tranmises
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

	echo $LANG["incgal_Thanks"]." ".$user_data["user_name"]."\n";
	echo $LANG["incgal_PlanetsSended"]." : ".$totalplanet."\n";
	echo "".$LANG["incgal_PlanetsInserted"]." : ".$totalinserted."\n";
	echo "".$LANG["incgal_PlanetsUpdated"]." : ".$totalupdated."\n";
	echo "".$LANG["incgal_PlanetsObsolete"]." : ".$totalcanceled."\n";
	echo "".$LANG["incgal_PlanetsFailed"]."  : ".$totalfailed."\n";
	echo "".$LANG["incgal_CommitDuration"]." : $totaltime sec"."\n";

	log_("load_system_OGS", array($totalplanet, $totalinserted, $totalupdated, $totalcanceled, $totalfailed, $totaltime));

	exit();
}


/**
* Envoie des donn�es vers OGS
*/
function galaxy_ExportPlanets() {
	global $db, $user_data, $server_config, $user_auth,$LANG;
	global $pub_galnum, $pub_sincedate;

	galaxy_check_auth("export_planet");

	$request_galaxy = "";
	$request_date = "";
	if (isset($pub_galnum)) {
		if (!check_var($pub_galnum, "Num")) {
			die ("<!-- [ErrorFatal=01] ".$LANG["incgal_IncorrectData"]."  -->");
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
			die ("<!-- [ErrorFatal=02] ".$LANG["incgal_IncorrectData"]."  -->");
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

	$request = "select galaxy, system, row, name, ally, player, status, user_name, last_update".
	" from ".TABLE_UNIVERSE." left join ".TABLE_USER.
	" on last_update_user_id = user_id".
	$request_galaxy.
	$request_date.
	" order by galaxy, system, row";

	$result = $db->sql_query($request);

	$i=0;
	echo "galaxy=1,system=2,row=3,planetname=4,playername=5,allytag=6,status=7,datetime=8,sendername=9<->";
	while(list($galaxy, $system, $row, $name, $ally, $player, $status, $user_name, $last_update) = $db->sql_fetch_row($result)) {
		if ($name == "") $name = " ";
		if ($ally == "") $ally = " ";
		if ($player == "") $player = " ";
		if (is_null($user_name)) $user_name = "Inconnu";

		if (!in_array($ally, $ally_protection) || $ally == "" || $user_auth["server_show_positionhided"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
			$texte = $galaxy."<||>";
			$texte .= $system."<||>";
			$texte .= $row."<||>";
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
* Mise � jours des systemes
* @param mixed $galaxy, $system, $row, $moon, $name, $ally, $player, $status, $timestamp
* @param boolean $mode_ogs optionnal False par defaut, Mode OGS
*/
function galaxy_add_system ($galaxy, $system, $row, $name, $ally, $player, $status, $timestamp, $mode_ogs = false) {
	global $db, $user_data;
	
	$error = false;
	$updated = false;
	$canceled = true;
	$inserted = false;
	//if(!check_var($row, "Num") || $row<1 && $row>15) return false;  Correctif par rapport au trunk.

	//Controle si l'update entraine des modifications
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
		//Mise � jour
		/*//Incompatible MySQL 4.0
		$request = "insert into ".TABLE_UNIVERSE." (galaxy, system, row, moon, name, ally, player, status, last_update, last_update_user_id)".
		" values ('".$galaxy."', ".$system.", '".$row."', '".$moon."', '".$name."', '".mysql_real_escape_string($ally)."', '".mysql_real_escape_string($player)."', '".$status."', ".$timestamp.", ".$user_data["user_id"].")".
		" on duplicate key update ally = '".mysql_real_escape_string($ally)."', player = '".mysql_real_escape_string($player)."', moon = '".$moon."', name = '".$name."', status = '".$status."', last_update = '".$timestamp."', last_update_user_id = ".$user_data["user_id"];
		$db->sql_query($request) or $error = true;*/
		$request = "update ".TABLE_UNIVERSE." set ally = '".mysql_real_escape_string($ally)."', player = '".mysql_real_escape_string($player)."', name = '".mysql_real_escape_string($name)."', status = '".$status."', last_update = '".$timestamp."', last_update_user_id = ".$user_data["user_id"];
		$request .= " where galaxy = '".$galaxy."' and system = ".$system." and row = '".$row."'";
		
		
		$db->sql_query($request) or $error = true;
		if ($db->sql_affectedrows() == 0) {
			$request = "insert ignore into ".TABLE_UNIVERSE." (galaxy, system, row, name, ally, player, status, last_update, last_update_user_id)";
			$request .= " values ('".$galaxy."', ".$system.", '".$row."', '".mysql_real_escape_string($name)."', '".mysql_real_escape_string($ally)."', '".mysql_real_escape_string($player)."', '".$status."', ".$timestamp.", ".$user_data["user_id"].")";
			$db->sql_query($request) or $error = true;
		}

		if ($error) return false;

		if ($player != "") { // mysql_real_escape_string ?
			$request = "insert into ".TABLE_UNIVERSE_TEMPORARY." (player, ally, status, timestamp) values ('".mysql_real_escape_string($player)."', '".mysql_real_escape_string($ally)."', '".$status."', '".$timestamp."')";  // Correctif trunk.
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
* Mise � jour des allys et statuts joueurs
*/
function galaxy_add_system_ally () {
	global $db, $user_data, $table_prefix;

	/*//Incompatible H�bergement 1&1
	$request = "create temporary table universe_temporary_cleaned like ".TABLE_UNIVERSE_TEMPORARY;*/
	$table = $table_prefix.$user_data["user_id"]."_".time()."_utc";
	$request = "create table ".$table." (";
	$request .= " player varchar(20) not null default '',";
	$request .= " ally varchar(20) not null default '',";
	$request .= " status varchar(5) not null default '',";
	$request .= " timestamp int(11) not null default '0'";
	$request .= ");";
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
	global $db, $user_data, $LANG, $server_config;

	$nb_spy_added = 0;
	$spy_added = array();
	for ($i=0 ; $i<sizeof($lines) ; $i++) {
		$line = stripslashes($lines[$i]);



		if (preg_match($LANG["Resources"], $line)) {
			$phalanx = $gate = 0;
			$header = str_replace($LANG["Header_ressources"], "", $line);

			
			list($coordinates, $time) = explode("]", $header);
			if (is_null($coordinates) || is_null($time)) {
				break;
			}

			$time = trim($time);
			$time = str_replace($LANG["Header_date"],"", $time);		// time doit �tre au format: 11-23 11:26:40
		

			list($planet, $coordinates) = explode("[", $coordinates);
			if (is_null($coordinates) || is_null($time)) {
				break;
			}
			$planet = trim($planet);
			
			list($galaxy, $system, $row) = explode(":", $coordinates);
			
			if (intval($galaxy) < 1 || intval($galaxy) > $server_config["nb_galaxy"] || intval($system) < 1 || intval($system) > $server_config["nb_system"] || intval($row) < 1 || intval($row) > $server_config["nb_galaxy"]) {
				
				break;
			}
			
			list($date, $hour) = explode(" ", $time);
			if (is_null($date) || is_null($hour)) {
				break;
			}

			list($day, $month, $year) = explode("/", $date);

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
			
			$timestamp = mktime($hour, $minute, $seconde, $month, $day);
	
			$report = "";
		}

		// ajout Naqdazar - test new 3.1.dev
		//$arr2 = array(2);
		if (preg_match($LANG["Spy_ImpulseDrive"], $line, $arr)) {
			$impulsion = $arr[1];
			/* if (sizeof($arr)>1) {			   
				 $impulsion .= $arr[2];
				 echo "impulsion a deux chiffres :".$impulsion."-".$arr[2]."\n";
			} */
		}
		if (preg_match($LANG["Spy_MissileSilo"], $line, $arr)) {
			$silo = $arr[1];
		}
        //----------

		if (isset($report)) {
			$checking = false;
			$report .= $line;
			//echo $line."<br>";
			
			if (preg_match($LANG["Spy_FleetDestructionProbability"], $line)) {
				//V�rification de la validit� des donn�es
				if (!check_var($galaxy, "Num") || !check_var($system, "Num") || !check_var($row, "Num") || !check_var($planet, "Galaxy") ||
				!check_var($timestamp, "Num") || !check_var($phalanx, "Num") || !check_var($report, "Spyreport") 
				// || !check_var($impulsion, "Num") || !check_var($silo, "Num") // <- � revoir (Nqz)  SI C'EST A REVOIR TU LE COMMENTE !
				) { 
					redirection("index.php?action=message&id_message=errordata&info");
				}

				$coordinates = $galaxy.":".$system.":".$row;
				if (galaxy_add_spy($galaxy, $system, $row, $planet, $timestamp, $report, $impulsion, $silo)) {
					$spy_added[] = array(1, $coordinates, $timestamp);
					$nb_spy_added++;
				}
				else {
					$spy_added[] = array(0, $coordinates, $timestamp);
				}
				$phalanx = $gate = 0;
				unset($report);
			}
		}
	}

	user_set_stat(null, null, null, $nb_spy_added);

	return $spy_added;
}


/**
* R�cup�ration des rapports d'espionnage provenant de OGS
*/
function galaxy_ImportSpy(){
	global $db, $user_data, $server_config,$LANG;
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
		!check_var($planet, "Galaxy") || !check_var($timestamp, "Num")/* || !check_var($report, "Spyreport")*/) {
			die ("<!-- [ErrorFatal=17] ".$LANG["incgal_IncorrectData"]."  -->");
		}

		if (galaxy_add_spy($galaxy, $system, $row, $planet, $timestamp, $report, 0, 0, 0, 0)) {
			$spy_added++;
		}

		next($datas);
	}

	if ($server_config["debug_log"] == "1") {
		//Sauvegarde donn�es tranmises
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

	die("Merci ".$user_data["user_name"]."\n"."Nb de rapports charg�s : ".$spy_added."\n");
}


/**
* Envoie des rapports d'espionnage vers OGS
*/
function galaxy_ExportSpy() {
	global $db, $user_data,$LANG;
	global $pub_galnum, $pub_sysnum;

	galaxy_check_auth("export_spy");

	if (!isset($pub_galnum) || !isset($pub_sysnum)) {
		die ("<!-- [ErrorFatal=08] ".$LANG["incgal_IncorrectData"]."  -->");
	}
	if (!check_var($pub_galnum, "Num") || !check_var($pub_sysnum, "Num")) {
		die ("<!-- [ErrorFatal=09] ".$LANG["incgal_IncorrectData"]."  -->");
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
* Envoie des rapports d'espionnage vers OGS � partir d'une date
*/
function galaxy_ExportSpy_since() {
	global $db, $user_data,$LANG;
	global $pub_since;

	galaxy_check_auth("export_spy");

	if (!isset($pub_since)) {
		die ("<!-- [ErrorFatal=10] ".$LANG["incgal_IncorrectData"]."  -->");
	}
	if (!check_var($pub_since, "Special", "#^(\d){4}-(\d){2}-(\d){2}\s(\d){2}:(\d){2}:(\d){2}$#")) {
		die ("<!-- [ErrorFatal=11] Donn�es transmises incorrectes  -->");
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
* prototype modifi� Naqdazar, ajout champ silo et impulsion
* @param int $galaxy Num�ro de galaxie
* @param int $system Num�ro de syst�me
* @param int $row Position de la plan�te
* @param int $timestamp Date/heure du rapport 
* @param string $report le texte du rapport
* @param ??? $phalanx Le niveau de phallange (rica: Qui est pars� ou ?)
* @param ??? $gate  Porte de saut (rica: pars� ou ? type boolean ou int ?)
* @param ??? $impulsion (rica: Qui est pars� ou ?)
* @param ??? $silo (rica: pars� ou ?)
* @return boolean true si le rapport a �t� ajout�
*/
function galaxy_add_spy($galaxy, $system, $row, $planet, $timestamp, $report, $impulsion, $silo) {
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


		$request = "select last_update from ".TABLE_UNIVERSE." where galaxy = $galaxy and system = $system and row = $row";
		$result = $db->sql_query($request);
		list($last_update) = $db->sql_fetch_row($result);

		if ($timestamp > $last_update) {
			/*//Incompatible MySQL 4.0
			$request = "insert into ".TABLE_UNIVERSE." (galaxy, system, row, name, last_update, last_update_user_id)".
			" values ('".$galaxy."', ".$system.", '".$row."', '".$planet."', ".$timestamp.", ".$user_data["user_id"].")".
			" on duplicate key update name = '".$planet."', last_update = '".$timestamp."', last_update_user_id = ".$user_data["user_id"];*/

			$request = "update ".TABLE_UNIVERSE." set last_update = '".$timestamp."', last_update_user_id = ".$user_data["user_id"];
			$request .= ", name = '".$planet."'"; // mysql_real_escape_string ??
			$request .= " where galaxy = '".$galaxy."' and system = ".$system." and row = '".$row."'";
			$db->sql_query($request);

			if ($db->sql_affectedrows() == 0) {
				$request = "insert ignore into ".TABLE_UNIVERSE." (galaxy, system, row, name, last_update, last_update_user_id)";
				$request .= " values ('".$galaxy."', ".$system.", '".$row."', '".mysql_real_escape_string($planet)."', ".$timestamp.", ".$user_data["user_id"].")";
				$db->sql_query($request);
			}
			// modifi� Axel, maj techno impulsion + silo
            if (isset($impulsion) or isset($silo)) {
                $request = '';
                if (isset($impulsion) and ($impulsion>0)) $request .= "impulsion = ".$impulsion;
                if (isset($impulsion) and isset($silo) and ($silo>0)) $request .= ", ";
                if (isset($silo) and ($silo>0)) $request .= "silo = ".$silo;
                if ($request != ''){
                    $request = "update ".TABLE_UNIVERSE." set ".$request;
                    $request .= " where galaxy = '".$galaxy."' and system = ".$system." and row = '".$row."'";
                    $db->sql_query($request);
                }
            }			
		}

		return true;
	}
	return false;
}


/**
* R�cup�ration des rapports d'espionnagea
* Donn�es puis�s dans les $pub_
* global $pub_galaxy, $pub_system, $pub_row, $pub_spy_id;
*/
function galaxy_reportspy_show() {
	global $db, $server_config;
	global $pub_galaxy, $pub_system, $pub_row, $pub_spy_id;

	if (!check_var($pub_galaxy, "Num") || !check_var($pub_system, "Num") || !check_var($pub_row, "Num")) {
		return false;
	}

	if (!isset($pub_galaxy) || !isset($pub_system) || !isset($pub_row)) {
		return false;
	}
	if (intval($pub_galaxy) < 1 || intval($pub_galaxy) > $server_config["nb_galaxy"] || intval($pub_system) < 1 || intval($pub_system) > $server_config["nb_system"] || intval($pub_row) < 1 || intval($pub_row) > $server_config["nb_row"]) {
		return false;
	}

	$request = "select spy_id, user_name, rawdata";
	$request .= " from ".TABLE_SPY." left join ".TABLE_USER." on user_id = sender_id";
	if (!isset($pub_spy_id)) {
		$request .= " where active = '1'";
		$request .= " and spy_galaxy = ".intval($pub_galaxy);
		$request .= " and spy_system = ".intval($pub_system);
		$request .= " and spy_row = ".intval($pub_row);
		$request .= " order by datadate desc";
	}
	else {
		$request .= " where spy_id = ".intval($pub_spy_id);
	}
	$result = $db->sql_query($request);

	$reports = array();
	while (list($pub_spy_id, $user_name, $rawdata) = $db->sql_fetch_row($result)) {
		$reports[] = array("spy_id"=> $pub_spy_id, "sender" => $user_name, "data" => $rawdata);
	}

	return $reports;
}


/**
* Purge des rapports d'espionnage
* Ne renvoie rien
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
* R�cup�ration des syst�mes favoris de l'utilisateur en cours
* rica: devrait etre mis dans includes/user.php
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
* R�cup�ration du classement joueur via OGS
* @param string $ranktype Type de rapport demand�s 'points','flotte','research'
* Ne renvoi rien mais fait un die avec un texte detect� par OGS
*/
function galaxy_ImportRanking_player($ranktype){
	global $db, $user_data, $server_config,$LANG;
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
		die ("<!-- [ErrorFatal=15] ".$LANG["incgal_IncorrectData"]."  -->");
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
				die ("<!-- [ErrorFatal=16] ".$LANG["incgal_IncorrectData"]."  -->");
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
		//Sauvegarde donn�es tranmises
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
* R�cup�ration du classement alliance via OGS
* @param string $ranktype Type de rapports envoy�s 'points','flotte','research'
*/
function galaxy_ImportRanking_ally($ranktype){
	global $db, $user_data, $server_config,$LANG;
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
		die ("<!-- [ErrorFatal=13] ".$LANG["incgal_IncorrectData"]."  -->");
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
				die ("<!-- [ErrorFatal=14] ".$LANG["incgal_IncorrectData"]."  -->");
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
		//Sauvegarde donn�es tranmises
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
* Envoie du classement joueur vers OGS
* Utilise les donn�es $pub_
* global $pub_date, $pub_type;
*/
function galaxy_ExportRanking_player() {
	global $db, $user_data,$LANG;
	global $pub_date, $pub_type;

	galaxy_check_auth("export_ranking");

	if (!isset($pub_date) || !isset($pub_type)) {
		die ("<!-- [ErrorFatal=05] ".$LANG["incgal_IncorrectData"]."  -->");
	}

	switch ($pub_type) {
		case "points": $ranktable = TABLE_RANK_PLAYER_POINTS; break;
		case "flotte": $ranktable = TABLE_RANK_PLAYER_FLEET; break;
		case "research": $ranktable = TABLE_RANK_PLAYER_RESEARCH; break;
		default: die ("<!-- [ErrorFatal=06] ".$LANG["incgal_IncorrectData"]."  -->");;
	}

	if (!check_var($pub_date, "Special", "#^(\d){4}-(\d){2}-(\d){2}\s(\d){2}:(\d){2}:(\d){2}$#")) {
		die ("<!-- [ErrorFatal=07] ".$LANG["incgal_IncorrectData"]."  -->");
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
* Envoie du classement alliance vers OGS
* Utilise les donn�es $pub_
*	global $pub_date, $pub_type;
*/
function galaxy_ExportRanking_ally() {
	global $db, $user_data,$LANG;
	global $pub_date, $pub_type;

	galaxy_check_auth("export_ranking");

	if (!isset($pub_date) || !isset($pub_type)) {
		die ("<!-- [ErrorFatal=03] ".$LANG["incgal_IncorrectData"]."  -->");
	}

	switch ($pub_type) {
		case "points": $ranktable = TABLE_RANK_ALLY_POINTS; break;
		case "flotte": $ranktable = TABLE_RANK_ALLY_FLEET; break;
		case "research": $ranktable = TABLE_RANK_ALLY_RESEARCH; break;
		default: die ("<!-- [ErrorFatal=04] ".$LANG["incgal_IncorrectData"]."  -->");;
	}

	if (!check_var($pub_date, "Special", "#^(\d){4}-(\d){2}-(\d){2}\s(\d){2}:(\d){2}:(\d){2}$#")) {
		die ("<!-- [ErrorFatal=04] ".$LANG["incgal_IncorrectData"]."  -->");
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
		$texte  = $rank."<||>";
		$texte .= utf8_decode($ally)."<||>";
		$texte .= $number_member."<||>";
		$texte .= $points."<||>";
		$texte .= $points_per_member."<||>";
		$texte .= utf8_decode($user_name)."<||>";
		$texte .= "<->";
		echo $texte;

		$i++;
	}

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
* Listing des classement disponible sur le serveur pour envoie vers OGS
* @param string $type 'player','ally'
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
*  Utilise les $pub_
*	global $pub_order_by, $pub_date, $pub_interval;
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

	if (!isset($pub_interval)) {
		$pub_interval = 1;
	}
	if (($pub_interval-1)%100 != 0 || $pub_interval > 1401) {
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

	return array($order, $ranking, $ranking_available);
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
	if (($pub_interval-1)%100 != 0 || $pub_interval > 1401) {
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

	$request = "select rank, ally, points, user_name";
	$request .= " from ".$table[$i]["tablename"]." left join ".TABLE_USER;
	$request .= " on sender_id = user_id";
	$request .= " where rank between ".$limit_down." and ".$limit_up;
	$request .= isset($last_ranking) ? " and datadate = ".mysql_real_escape_string($last_ranking) : "";
	$request .= " order by ".$pub_order_by2;
	$result = $db->sql_query($request);

	while (list($rank, $ally, $points, $user_name) = $db->sql_fetch_row($result)) {
		$ranking[$ally][$table[$i]["arrayname"]] = array("rank" => $rank, "points" => $points);
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
			$request = "select rank, ally, points, user_name";
			$request .= " from ".$table[$i]["tablename"]." left join ".TABLE_USER;
			$request .= " on sender_id = user_id";
			$request .= " where ally = '".mysql_real_escape_string(key($ranking))."'";
			$request .= isset($last_ranking) ? " and datadate = ".mysql_real_escape_string($last_ranking) : "";
			$request .= " order by rank";
			$result = $db->sql_query($request);

			while (list($rank, $ally, $points, $user_name) = $db->sql_fetch_row($result)) {
				$ranking[$ally][$table[$i]["arrayname"]] = array("rank" => $rank, "points" => $points);
				$ranking[$ally]["sender"] = $user_name;

				if ($pub_order_by == $table[$i]["arrayname"]) {
					$order[$rank] = $ally;
				}
			}

			next($ranking);
		}
	}

	$ranking_available = array_unique($ranking_available);

	return array($order, $ranking, $ranking_available);
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
* Affichage classement d'une ally particuli�re
*/
function galaxy_show_ranking_unique_ally($ally, $last = false) {
	global $db;

	$ranking = array();

	$request = "select datadate, rank, points";
	$request .= " from ".TABLE_RANK_ALLY_POINTS;
	$request .= " where ally = '".mysql_real_escape_string($ally)."'";
	$request .= " order by datadate desc";
	$result = $db->sql_query($request);
	while (list($datadate, $rank, $points) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["general"] = array("rank" => $rank, "points" => $points);
		if ($last) break;
	}

	$request = "select datadate, rank, points";
	$request .= " from ".TABLE_RANK_ALLY_FLEET;
	$request .= " where ally = '".mysql_real_escape_string($ally)."'";
	$request .= " order by datadate desc";
	$result = $db->sql_query($request);
	while (list($datadate, $rank, $points) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["fleet"] = array("rank" => $rank, "points" => $points);
		if ($last) break;
	}

	$request = "select datadate, rank, points";
	$request .= " from ".TABLE_RANK_ALLY_RESEARCH;
	$request .= " where ally = '".mysql_real_escape_string($ally)."'";
	$request .= " order by datadate desc";
	$result = $db->sql_query($request);
	while (list($datadate, $rank, $points) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["research"] = array("rank" => $rank, "points" => $points);
		if ($last) break;
	}

	return $ranking;
}


//R�cup�ration des classements  (joueurs+alliance)
function galaxy_getranking($lines, $datatype) {
	global $db, $user_data, $server_config, $LANG;

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
	if ($time > mktime(0,0,0) && $time < mktime(6,0,0)) $timestamp = mktime(0,0,0);
	if ($time > mktime(6,0,0) && $time < mktime(12,0,0)) $timestamp = mktime(6,0,0);
	if ($time > mktime(12,0,0) && $time < mktime(18,0,0)) $timestamp = mktime(12,0,0);
	if ($time > mktime(18,0,0) && $time < (mktime(0,0,0)+60*60*24)) $timestamp = mktime(18,0,0);

	$files = array();
	$OK = false;
	$last_position = 0;
	$index = 0;

	if (preg_match("#player#", $datatype)) {    //if it's a player-related ranking
		for ($i=0 ; $i<sizeof($lines) ; $i++) {
			$line = trim($lines[$i]);
			
			if (!$OK && preg_match($LANG["Ranking_Player"], $line)) {
			
				$OK = true;
				$position = 0;
				continue;
				
			}

			if ($OK) {
				$files[] = $line;
				
				$index++;
				preg_match($LANG["Ranking_SendMessage"], $line, $arr);
				list($text, $position, $player, $ally, $points) = $arr;

				$points = str_replace(" ", "", $points);
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
	else {   //if it's a alliance-related ranking
	
		for ($i=0 ; $i<sizeof($lines) ; $i++) {
			$line = trim($lines[$i]);
			

			if (!$OK && preg_match($LANG["Ranking_Alliance"], $line)
			) {

				$OK = true;
				$position = 0;
				continue;
				
			}

			if ($OK) {
				$files[] = $line;
				
				$index++;
				
				preg_match($LANG["Ranking_Text"], $line, $arr);
				

				list($text, $position, $nom_ally, $ally, $points) = $arr;
				$points = str_replace(" ", "", $points);
				
				if (!is_numeric($position) || !is_string($nom_ally) || !is_string($ally) || !is_numeric($points)) {
					return false;
				}
				if ($last_position != 0) {
					if ($last_position+1 != $position) {
						return false;
					}
				}
				$ranking[$position] = array("ally" => $ally, "nom_ally" => $nom_ally, "points" => $points);
				$last_position = $position;
				if ($index == 100) break;
			}
		}
//Arr�t ici

	}

	if (!$OK) {
		redirection("index.php?action=ranking");
	}

	if ($server_config["debug_log"] == "1") {
		//Sauvegarde donn�es tranmises
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
			$request .= " (datadate, rank, ally, nom_ally, points, sender_id)";
			$request .= " values (".$timestamp.", ".key($ranking).", '".mysql_real_escape_string($rankline["ally"])."', '".$rankline["nom_ally"]."', ".$rankline["points"].", ".$user_data["user_id"].")";
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
* Suppression automatique de classement
*/
function galaxy_purge_ranking() {
	global $db, $server_config;

	if (!is_numeric($server_config["max_keeprank"])) {
		return;
	}
	$max_keeprank = intval($server_config["max_keeprank"]);

	if ($server_config["keeprank_criterion"] == "day") {
		$request = "delete from ".TABLE_RANK_PLAYER_POINTS." where datadate < ".(time()-60*60*24*$max_keeprank);
		$db->sql_query($request, true, false);
		$request = "delete from ".TABLE_RANK_PLAYER_FLEET." where datadate < ".(time()-60*60*24*$max_keeprank);
		$db->sql_query($request, true, false);
		$request = "delete from ".TABLE_RANK_PLAYER_RESEARCH." where datadate < ".(time()-60*60*24*$max_keeprank);
		$db->sql_query($request, true, false);
	}

	if ($server_config["keeprank_criterion"] == "quantity") {
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
	}
}


/**
* Suppresion manuel de classement
*/
function galaxy_drop_ranking() {
	global $db;
	global $pub_datadate, $pub_subaction;

	if (!check_var($pub_datadate, "Num") || !check_var($pub_subaction, "Char")) {
		redirection("index.php?action=message&id_message=errordata&info");
	}

	//V�rification des droits
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
* fonction ajout�e Naqdazar
* ....
*/
function galaxy_get_interplanetary($galaxy, $system) {
	global $db, $server_config, $user_data, $user_auth;

	$ally_protection = array();
	if ($server_config["ally_protection"] != "") $ally_protection = explode(",", $server_config["ally_protection"]);

	$missiler = array();

	$request[] = "select galaxy, system, row, impulsion, silo, name, ally, player from ".TABLE_UNIVERSE." where galaxy = ".$galaxy." and silo >= 4 and impulsion > 0 and system < ".$system." and system + (2*impulsion - 1) >= ".$system;
	$request[] = "select galaxy, system, row, impulsion, silo, name, ally, player from ".TABLE_UNIVERSE." where galaxy = ".$galaxy." and silo >= 4  and impulsion > 0 and system > ".$system." and system - (2*impulsion - 1) <= ".$system;
	$request[] = "select galaxy, system, row, impulsion, silo, name, ally, player from ".TABLE_UNIVERSE." where galaxy = ".$galaxy." and silo >=	 4  and impulsion > 0 and system = ".$system;

	foreach ($request as $req) {
		$result = $db->sql_query($req);
		while ($coordinates = $db->sql_fetch_assoc($result)) {
			if (!in_array($coordinates["ally"], $ally_protection) || $coordinates["ally"] == "" || $user_auth["server_show_positionhided"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
				$missiler[] = $coordinates;
			}
		}
	}

	return $missiler;
}

/**
* Affichage des syst�mes solaires obsol�tes
*/
function galaxy_obsolete() {
	global $db;
	global $pub_perimeter, $pub_since, $pub_typesearch;

	$obsolete = array();
	if (isset($pub_perimeter) && isset($pub_since) && is_numeric($pub_perimeter) && is_numeric($pub_since)) {
		
		$pub_typesearch = "P";

		$timestamp = time();
		$pub_since_56 = $timestamp - 60 * 60 * 24 * 56;
		$pub_since_42 = $timestamp - 60 * 60 * 24 * 42;
		$pub_since_28 = $timestamp - 60 * 60 * 24 * 28;
		$pub_since_21 = $timestamp - 60 * 60 * 24 * 21;
		$pub_since_14 = $timestamp - 60 * 60 * 24 * 14;
		$pub_since_7 = $timestamp - 60 * 60 * 24 * 7;

		$field = "last_update";
		$row_field = "";


		switch ($pub_since) {
			case 56 :
			$request = "select distinct galaxy, system".$row_field." from ".TABLE_UNIVERSE." where ".$field." < ".$pub_since_56;
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
			$request = "select distinct galaxy, system".$row_field." from ".TABLE_UNIVERSE." where ".$field." between ".$pub_since_56." and ".$pub_since_42;
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
			$request = "select distinct galaxy, system".$row_field." from ".TABLE_UNIVERSE." where ".$field." between ".$pub_since_42." and ".$pub_since_28;
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
			$request = "select distinct galaxy, system".$row_field." from ".TABLE_UNIVERSE." where ".$field." between ".$pub_since_28." and ".$pub_since_21;
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
			$request = "select distinct galaxy, system".$row_field." from ".TABLE_UNIVERSE." where ".$field." between ".$pub_since_21." and ".$pub_since_14;
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
			$request = "select distinct galaxy, system".$row_field." from ".TABLE_UNIVERSE." where ".$field." between ".$pub_since_14." and ".$pub_since_7;
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
?>
