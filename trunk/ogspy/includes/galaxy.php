<?php
/** $Id$ **/
/**
 * Fonctions relatives aux donn�es galaxies/plan�tes
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
require_once ("galaxybis.php");

/**
 * V�rification des droits OGSpy
 * @param string $action Droit interrog�
 */

function galaxy_check_auth($action)
{
    global $user_data, $user_auth;

    switch ($action) {
        case "import_planet":
            if ($user_auth["ogs_set_system"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] !=
                1)
                die("<!-- [AccessDenied] Acc�s refus� -->" . "\n" .
                    "<!-- Vous n'avez pas les droits pour exporter des syst�mes solaires -->" . "\n");
            break;

        case "export_planet":
            if ($user_auth["ogs_get_system"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] !=
                1)
                die("<!-- [AccessDenied] Acc�s refus� -->" . "\n" .
                    "<!-- Vous n'avez pas les droits pour importer des syst�mes solaires -->" . "\n");
            break;

        case "import_spy":
            if ($user_auth["ogs_set_spy"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] !=
                1)
                die("<!-- [AccessDenied] Acc�s refus� -->" . "\n" .
                    "<!-- Vous n'avez pas les droits pour exporter des rapports d'espionnage -->" .
                    "\n");
            break;

        case "export_spy":
            if ($user_auth["ogs_get_spy"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] !=
                1)
                die("<!-- [AccessDenied] Acc�s refus� -->" . "\n" .
                    "<!-- Vous n'avez pas les droits pour importer des rapports d'espionnage -->" .
                    "\n");
            break;

        case "import_ranking":
            if ($user_auth["ogs_set_ranking"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] !=
                1)
                die("<!-- [AccessDenied] Acc�s refus� -->" . "\n" .
                    "<!-- Vous n'avez pas les droits pour exporter des classements -->" . "\n");
            break;

        case "export_ranking":
            if ($user_auth["ogs_get_ranking"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] !=
                1)
                die("<!-- [AccessDenied] Acc�s refus� -->" . "\n" .
                    "<!-- Vous n'avez pas les droits pour importer des classements -->" . "\n");
            break;

        case "drop_ranking":
            if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_ranking"] !=
                1)
                redirection("index.php?action=message&id_message=forbidden&info");
            break;

        case "set_ranking":
            if (($user_auth["server_set_ranking"] != 1) && $user_data["user_admin"] != 1 &&
                $user_data["user_coadmin"] != 1)
                redirection("index.php?action=message&id_message=forbidden&info");
            break;

        case "set_rc":
            if (($user_auth["server_set_rc"] != 1) && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] !=
                1)
                redirection("index.php?action=message&id_message=forbidden&info");
            break;

        default:
            die("<!-- [ErrorFatal=18] Donn�es transmises incorrectes  -->");
    }
}





/**
 * Affichage des galaxies
 * @global $pub_galaxy
 * @global $pub_system
 * @global $pub_coordinates
 */
function galaxy_show()
{
    global $db, $user_data, $user_auth, $server_config;
    global $pub_galaxy, $pub_system, $pub_coordinates;
    if (isset($pub_coordinates)) {
        @list($pub_galaxy, $pub_system) = explode(":", $pub_coordinates);
    }
    if (isset($pub_galaxy) && isset($pub_system)) {
        if (intval($pub_galaxy) < 1)
            $pub_galaxy = 1;
        if (intval($pub_galaxy) > intval($server_config['num_of_galaxies']))
            $pub_galaxy = intval($server_config['num_of_galaxies']);
        if (intval($pub_system) < 1)
            $pub_system = 1;
        if (intval($pub_system) > intval($server_config['num_of_systems']))
            $pub_system = intval($server_config['num_of_systems']);
    }

    $ally_protection = $allied = array();
    if ($server_config["ally_protection"] != "")
        $ally_protection = explode(",", $server_config["ally_protection"]);
    if ($server_config["allied"] != "")
        $allied = explode(",", $server_config["allied"]);

    if (!isset($pub_galaxy) || !isset($pub_system)) {
        $pub_galaxy = $user_data["user_galaxy"];
        $pub_system = $user_data["user_system"];

        if ($pub_galaxy == 0 || $pub_system == 0) {
            $pub_galaxy = 1;
            $pub_system = 1;
        }
    }

    $request = "select row, name, ally, player, moon, phalanx, gate, last_update_moon, status, last_update, user_name";
    $request .= " from " . TABLE_UNIVERSE . " left join " . TABLE_USER;
    $request .= " on user_id = last_update_user_id";
    $request .= " where galaxy = $pub_galaxy and system = $pub_system order by row";
    $result = $db->sql_query($request);

    $population = array_fill(1, 15, array("ally" => "", "player" => "", "moon" => "",
        "last_update_moon" => "", "phalanx" => "", "gate" => "", "planet" => "",
        "report_spy" => false, "status" => "", "timestamp" => "", "poster" => "",
        "hided" => "", "allied" => ""));
    while (list($row, $planet, $ally, $player, $moon, $phalanx, $gate, $last_update_moon,
        $status, $timestamp, $poster) = $db->sql_fetch_row($result)) {
        $report_spy = 0;
        $request = "select id_spy from " . TABLE_PARSEDSPY .
            " where active = '1' and coordinates = '$pub_galaxy:$pub_system:$row'";
        $result_2 = $db->sql_query($request);
        if ($db->sql_numrows($result_2) > 0)
            $report_spy = $db->sql_numrows($result_2);
        $report_rc = 0;
        $request = "select id_rc from " . TABLE_PARSEDRC . " where coordinates = '$pub_galaxy:$pub_system:$row'";
        $result_2 = $db->sql_query($request);
        if ($db->sql_numrows($result_2) > 0)
            $report_rc = $db->sql_numrows($result_2);

        if (!in_array($ally, $ally_protection) || $ally == "" || $user_auth["server_show_positionhided"] ==
            1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
            $hided = $friend = false;
            if (in_array($ally, $ally_protection))
                $hided = true;
            if (in_array($ally, $allied))
                $friend = true;

            $population[$row] = array("ally" => $ally, "player" => $player, "moon" => $moon,
                "phalanx" => $phalanx, "gate" => $gate, "last_update_moon" => $last_update_moon,
                "planet" => $planet, "report_spy" => $report_spy, "status" => $status,
                "timestamp" => $timestamp, "poster" => $poster, "hided" => $hided, "allied" => $friend,
                "report_rc" => $report_rc);
        } elseif (in_array($ally, $ally_protection)) {
            $population[$row] = array("ally" => "", "player" => "", "moon" => "", "phalanx" =>
                "", "gate" => "", "last_update_moon" => "", "planet" => "", "report_spy" => "",
                "status" => "", "timestamp" => $timestamp, "poster" => $poster, "hided" => "",
                "allied" => "", "report_rc" => $report_rc);
        }
    }

    return array("population" => $population, "galaxy" => $pub_galaxy, "system" => $pub_system);
}

/**
 * Affichage des syst�mes
 */
function galaxy_show_sector()
{
    global $db, $server_config, $user_data, $user_auth;
    global $pub_galaxy, $pub_system_down, $pub_system_up;

    if (isset($pub_galaxy) && isset($pub_system_down) && isset($pub_system_up)) {
        if (intval($pub_galaxy) < 1)
            $pub_galaxy = 1;
        if (intval($pub_galaxy) > intval($server_config['num_of_galaxies']))
            $pub_galaxy = intval($server_config['num_of_galaxies']);
        if (intval($pub_system_down) < 1)
            $pub_system_down = 1;
        if (intval($pub_system_down) > intval($server_config['num_of_systems']))
            $pub_system_down = intval($server_config['num_of_systems']);
        if (intval($pub_system_up) < 1)
            $pub_system_up = 1;
        if (intval($pub_system_up) > intval($server_config['num_of_systems']))
            $pub_system_up = intval($server_config['num_of_systems']);
    }

    if (!isset($pub_galaxy) || !isset($pub_system_down) || !isset($pub_system_up)) {
        $pub_galaxy = 1;
        $pub_system_down = 1;
        $pub_system_up = 25;
    }

    $ally_protection = $allied = array();
    if ($server_config["ally_protection"] != "")
        $ally_protection = explode(",", $server_config["ally_protection"]);
    if ($server_config["allied"] != "")
        $allied = explode(",", $server_config["allied"]);

    $request = "select system, row, name, ally, player, moon, phalanx, gate, last_update_moon, status, last_update";
    $request .= " from " . TABLE_UNIVERSE;
    $request .= " where galaxy = $pub_galaxy and system between " . $pub_system_down .
        " and " . $pub_system_up;
    $request .= " order by system, row";
    $result = $db->sql_query($request);

    $population = array_fill($pub_system_down, $pub_system_up, "");
    while (list($system, $row, $planet, $ally, $player, $moon, $phalanx, $gate, $last_update_moon,
        $status, $update) = $db->sql_fetch_row($result)) {
        if (!isset($last_update[$system]))
            $last_update[$system] = $update;
        elseif ($update < $last_update[$system])
            $last_update[$system] = $update;

        $report_spy = 0;
        $request = "select * from " . TABLE_PARSEDSPY .
            " where active = '1' and coordinates = '$pub_galaxy:$system:$row'";
        $result_2 = $db->sql_query($request);
        if ($db->sql_numrows($result_2) > 0)
            $report_spy = $db->sql_numrows($result_2);

        if (!in_array($ally, $ally_protection) || $ally == "" || $user_auth["server_show_positionhided"] ==
            1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
            $hided = $friend = false;
            if (in_array($ally, $ally_protection))
                $hided = true;
            if (in_array($ally, $allied))
                $friend = true;

            $population[$system][$row] = array("ally" => $ally, "player" => $player, "moon" =>
                $moon, "phalanx" => $phalanx, "gate" => $gate, "last_update_moon" => $last_update_moon,
                "planet" => $planet, "report_spy" => $report_spy, "status" => $status, "hided" =>
                $hided, "allied" => $friend);
        }
    }

    while ($value = @current($last_update)) {
        $population[key($last_update)]["last_update"] = $value;
        next($last_update);
    }

    return array("population" => $population, "galaxy" => $pub_galaxy, "system_down" =>
        $pub_system_down, "system_up" => $pub_system_up);
}

/**
 * Fonctions de recherches
 */
function galaxy_search()
{
    global $db, $user_data, $user_auth, $server_config;
    global $pub_string_search, $pub_type_search, $pub_strict, $pub_sort, $pub_sort2,
        $pub_galaxy_down, $pub_galaxy_up, $pub_system_down, $pub_system_up, $pub_row_down,
        $pub_row_up, $pub_row_active, $pub_page;

    if (!check_var($pub_string_search, "Text") || !check_var($pub_type_search,
        "Char") || !check_var($pub_strict, "Char") || !check_var($pub_sort, "Num") || !
        check_var($pub_sort2, "Num") || !check_var($pub_galaxy_down, "Num") || !
        check_var($pub_galaxy_up, "Num") || !check_var($pub_system_down, "Num") || !
        check_var($pub_system_up, "Num") || !check_var($pub_row_down, "Num") || !
        check_var($pub_row_up, "Num") || !check_var($pub_row_active, "Char") || !
        check_var($pub_page, "Num")) {
        redirection("index.php?action=message&id_message=errordata&info");
    }

    $search_result = array();
    $total_page = 0;
    $ally_protection = $allied = array();
    if ($server_config["ally_protection"] != "")
        $ally_protection = explode(",", $server_config["ally_protection"]);
    if ($server_config["allied"] != "")
        $allied = explode(",", $server_config["allied"]);

    if (isset($pub_type_search) && (isset($pub_string_search) || (isset($pub_galaxy_down) &&
        isset($pub_galaxy_up) && isset($pub_system_down) && isset($pub_system_up) &&
        isset($pub_row_down) && isset($pub_row_up)))) {
        user_set_stat(null, null, 1);

        switch ($pub_type_search) {
            case "player":
                if ($pub_string_search == "")
                    break;
                $search = isset($pub_strict) ? $pub_string_search:
                "%" . $pub_string_search . "%";

                $select = "select count(*)";
                $request = " from " . TABLE_UNIVERSE . " left join " . TABLE_USER;
                $request .= " on last_update_user_id = user_id";
                $request .= " where player like '" . $db->sql_escape_string($search) . "'";
                if ($user_auth["server_show_positionhided"] != 1 && $user_data["user_admin"] !=
                    1 && $user_data["user_coadmin"] != 1) {
                    foreach ($ally_protection as $v) {
                        $request .= " and ally <> '" . $db->sql_escape_string($v) . "'";
                    }
                }

                $result = $db->sql_query($select . $request);
                list($total_row) = $db->sql_fetch_row($result);

                $select = "select galaxy, system, row, moon, phalanx, gate, last_update_moon, ally, player, status, last_update, user_name";
                $request = $select . $request;
                break;

            case "ally":
                if ($pub_string_search == "")
                    break;
                $search = isset($pub_strict) ? $pub_string_search:
                "%" . $pub_string_search . "%";

                $select = "select count(*)";
                $request = " from " . TABLE_UNIVERSE . " left join " . TABLE_USER;
                $request .= " on last_update_user_id = user_id";
                $request .= " where ally like '" . $db->sql_escape_string($search) . "'";
                if ($user_auth["server_show_positionhided"] != 1 && $user_data["user_admin"] !=
                    1 && $user_data["user_coadmin"] != 1) {
                    foreach ($ally_protection as $v) {
                        $request .= " and ally <> '" . $db->sql_escape_string($v) . "'";
                    }
                }

                $result = $db->sql_query($select . $request);
                list($total_row) = $db->sql_fetch_row($result);

                $select = "select galaxy, system, row, moon, phalanx, gate, last_update_moon, ally, player, status, last_update, user_name";
                $request = $select . $request;
                break;

            case "planet":
                if ($pub_string_search == "")
                    break;
                $search = isset($pub_strict) ? $pub_string_search:
                "%" . $pub_string_search . "%";

                $select = "select count(*)";
                $request = " from " . TABLE_UNIVERSE . " left join " . TABLE_USER;
                $request .= " on last_update_user_id = user_id";
                $request .= " where name like '" . $db->sql_escape_string($search) . "'";
                if ($user_auth["server_show_positionhided"] != 1 && $user_data["user_admin"] !=
                    1 && $user_data["user_coadmin"] != 1) {
                    foreach ($ally_protection as $v) {
                        $request .= " and ally <> '" . $db->sql_escape_string($v) . "'";
                    }
                }

                $result = $db->sql_query($select . $request);
                list($total_row) = $db->sql_fetch_row($result);

                $select = "select galaxy, system, row, moon, phalanx, gate, last_update_moon, ally, player, status, last_update, user_name";
                $request = $select . $request;
                break;

            case "colonization":
                $galaxy_start = intval($pub_galaxy_down);
                $galaxy_end = intval($pub_galaxy_up);
                $system_start = intval($pub_system_down);
                $system_end = intval($pub_system_up);
                $row_start = intval($pub_row_down);
                $row_end = intval($pub_row_up);

                if ($galaxy_start < 1 || $galaxy_start > intval($server_config['num_of_galaxies']) ||
                    $galaxy_end < 1 || $galaxy_end > intval($server_config['num_of_galaxies']))
                    break;
                if ($system_start < 1 || $system_start > intval($server_config['num_of_systems']) ||
                    $system_end < 1 || $system_end > intval($server_config['num_of_systems']))
                    break;
                if ($pub_row_active) {
                    if ($row_start < 1 || $row_start > 15 || $row_end < 1 || $row_end > 15)
                        break;
                }

                $select = "select count(*)";
                $request = " from " . TABLE_UNIVERSE . " left join " . TABLE_USER;
                $request .= " on last_update_user_id = user_id";
                $request .= " where player = ''";
                $request .= " and galaxy between $galaxy_start and $galaxy_end";
                $request .= " and system between $system_start and $system_end";
                if ($pub_row_active) {
                    $request .= " and row between $row_start and $row_end";
                }

                $result = $db->sql_query($select . $request);
                list($total_row) = $db->sql_fetch_row($result);

                $select = "select galaxy, system, row, moon, phalanx, gate, last_update_moon, ally, player, status, last_update, user_name";
                $request = $select . $request;
                break;

            case "moon":
                $galaxy_start = intval($pub_galaxy_down);
                $galaxy_end = intval($pub_galaxy_up);
                $system_start = intval($pub_system_down);
                $system_end = intval($pub_system_up);
                $row_start = intval($pub_row_down);
                $row_end = intval($pub_row_up);

                if ($galaxy_start < 1 || $galaxy_start > intval($server_config['num_of_galaxies']) ||
                    $galaxy_end < 1 || $galaxy_end > intval($server_config['num_of_galaxies']))
                    break;
                if ($system_start < 1 || $system_start > intval($server_config['num_of_systems']) ||
                    $system_end < 1 || $system_end > intval($server_config['num_of_systems']))
                    break;
                if ($pub_row_active) {
                    if ($row_start < 1 || $row_start > 15 || $row_end < 1 || $row_end > 15)
                        break;
                }

                $select = "select count(*)";
                $request = " from " . TABLE_UNIVERSE . " left join " . TABLE_USER;
                $request .= " on last_update_user_id = user_id";
                $request .= " where moon = '1'";
                $request .= " and galaxy between $galaxy_start and $galaxy_end";
                $request .= " and system between $system_start and $system_end";
                if ($pub_row_active) {
                    $request .= " and row between $row_start and $row_end";
                }
                if ($user_auth["server_show_positionhided"] != 1 && $user_data["user_admin"] !=
                    1 && $user_data["user_coadmin"] != 1) {
                    foreach ($ally_protection as $v) {
                        $request .= " and ally <> '" . $db->sql_escape_string($v) . "'";
                    }
                }

                $result = $db->sql_query($select . $request);
                list($total_row) = $db->sql_fetch_row($result);

                $select = "select galaxy, system, row, moon, phalanx, gate, last_update_moon, ally, player, status, last_update, user_name";
                $request = $select . $request;
                break;

            case "away":
                $galaxy_start = intval($pub_galaxy_down);
                $galaxy_end = intval($pub_galaxy_up);
                $system_start = intval($pub_system_down);
                $system_end = intval($pub_system_up);
                $row_start = intval($pub_row_down);
                $row_end = intval($pub_row_up);

                if ($galaxy_start < 1 || $galaxy_start > intval($server_config['num_of_galaxies']) ||
                    $galaxy_end < 1 || $galaxy_end > intval($server_config['num_of_galaxies']))
                    break;
                if ($system_start < 1 || $system_start > intval($server_config['num_of_systems']) ||
                    $system_end < 1 || $system_end > intval($server_config['num_of_systems']))
                    break;
                if ($pub_row_active) {
                    if ($row_start < 1 || $row_start > 15 || $row_end < 1 || $row_end > 15)
                        break;
                }

                $select = "select count(*)";
                $request = " from " . TABLE_UNIVERSE . " left join " . TABLE_USER;
                $request .= " on last_update_user_id = user_id";
                $request .= " where status like ('%i%')";
                $request .= " and galaxy between $galaxy_start and $galaxy_end";
                $request .= " and system between $system_start and $system_end";
                if ($pub_row_active) {
                    $request .= " and row between $row_start and $row_end";
                }
                if ($user_auth["server_show_positionhided"] != 1 && $user_data["user_admin"] !=
                    1 && $user_data["user_coadmin"] != 1) {
                    foreach ($ally_protection as $v) {
                        $request .= " and ally <> '" . $db->sql_escape_string($v) . "'";
                    }
                }

                $result = $db->sql_query($select . $request);
                list($total_row) = $db->sql_fetch_row($result);

                $select = "select galaxy, system, row, moon, phalanx, gate, last_update_moon, ally, player, status, last_update, user_name";
                $request = $select . $request;
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
                        $order = " order by galaxy" . $order2 . ", system" . $order2 . ", row" . $order2 .
                            "";
                        break;

                    case "2":
                        $order = " order by ally" . $order2 . ", player" . $order2 . ", galaxy" . $order2 .
                            ", system" . $order2 . ", row" . $order2 . "";
                        break;

                    case "3":
                        $order = " order by player" . $order2 . ", galaxy" . $order2 . ", system" . $order2 .
                            ", row" . $order2 . "";
                        break;
                }
            }
            $request .= $order;

            if (!isset($pub_page)) {
                $pub_page = 1;
            }
            $total_page = ceil($total_row / 30);
            if ($pub_page > $total_page)
                $pub_page = $total_page;
            $limit = intval($pub_page - 1) * 30;
            if ($limit < 0) {
                $limit = 0;
                $pub_page = 1;
            }
            $request .= " LIMIT " . $limit . " , 30";

            $result = $db->sql_query($request);
            $search_result = array();
            while ($row = $db->sql_fetch_assoc($result)) {
                $hided = $friend = false;
                if (in_array($row["ally"], $ally_protection))
                    $hided = true;
                if (in_array($row["ally"], $allied))
                    $friend = true;

                $request = "select * from " . TABLE_PARSEDSPY .
                    " where active = '1' and coordinates = '" . $row["galaxy"] . ":" . $row["system"] . ":" . $row["row"] ."'";
                $result_2 = $db->sql_query($request);
                $report_spy = $db->sql_numrows($result_2);
                $search_result[] = array("galaxy" => $row["galaxy"], "system" => $row["system"],
                    "row" => $row["row"], "phalanx" => $row["phalanx"], "gate" => $row["gate"],
                    "last_update_moon" => $row["last_update_moon"], "moon" => $row["moon"], "ally" =>
                    $row["ally"], "player" => $row["player"], "report_spy" => $report_spy, "status" =>
                    $row["status"], "timestamp" => $row["last_update"], "poster" => $row["user_name"],
                    "hided" => $hided, "allied" => $friend);
            }
        }
    }
    return array($search_result, $total_page);
}

/**
 * R�cup�ration des statistiques des galaxies
 */
function galaxy_statistic($step = 50)
{
    global $db, $user_data, $server_config;

    $nb_planets_total = 0;
    $nb_freeplanets_total = 0;
    for ($galaxy = 1; $galaxy <= intval($server_config['num_of_galaxies']); $galaxy++) {
        for ($system = 1; $system <= intval($server_config['num_of_systems']); $system =
            $system + $step) {
            $request = "select count(*) from " . TABLE_UNIVERSE;
            $request .= " where galaxy = " . $galaxy;
            $request .= " and system between " . $system . " and " . ($system + $step - 1);
            $result = $db->sql_query($request);
            list($nb_planet) = $db->sql_fetch_row($result);
            $nb_planets_total += $nb_planet;

            $request = "select count(*) from " . TABLE_UNIVERSE;
            $request .= " where player = ''";
            $request .= " and galaxy = " . $galaxy;
            $request .= " and system between " . $system . " and " . ($system + $step - 1);
            $result = $db->sql_query($request);
            list($nb_planet_free) = $db->sql_fetch_row($result);
            $nb_freeplanets_total += $nb_planet_free;

            $new = false;
            $request = "select max(last_update) from " . TABLE_UNIVERSE;
            $request .= " where galaxy = " . $galaxy;
            $request .= " and system between " . $system . " and " . ($system + $step - 1);
            $result = $db->sql_query($request);
            list($last_update) = $db->sql_fetch_row($result);
            if ($last_update > $user_data["session_lastvisit"])
                $new = true;

            $statictics[$galaxy][$system] = array("planet" => $nb_planet, "free" => $nb_planet_free,
                "new" => $new);
        }
    }

    return array("map" => $statictics, "nb_planets" => $nb_planets_total,
        "nb_planets_free" => $nb_freeplanets_total);
}

/**
 * Listing des alliances
 */
function galaxy_ally_listing()
{
    global $db;

    $ally_list = array();

    $request = "select distinct ally from " . TABLE_UNIVERSE . " order by ally";
    $result = $db->sql_query($request);
    while ($row = $db->sql_fetch_assoc($result)) {
        if ($row["ally"] != "")
            $ally_list[] = $row["ally"];
    }

    return $ally_list;
}

/**
 * R�cup�ration position alliance
 */
function galaxy_ally_position($step = 50)
{
    global $db, $user_auth, $user_data, $server_config;
    global $pub_ally_, $nb_colonnes_ally;

    for ($i = 1; $i <= $nb_colonnes_ally; $i++) {
        if (!check_var($pub_ally_[$i], "Text")) {
            redirection("index.php?action=message&id_message=errordata&info");
        }

        if (!isset($pub_ally_[$i])) {
            return array();
        }
    }

    $pub_ally_protection = $allied = array();
    if ($server_config["ally_protection"] != "")
        $pub_ally_protection = explode(",", $server_config["ally_protection"]);
    if ($server_config["allied"] != "")
        $allied = explode(",", $server_config["allied"]);

    $statictics = array();
    for ($i = 1; $i <= $nb_colonnes_ally; $i++) {
        $pub_ally_list[$i - 1] = $pub_ally_[$i];
    }

    foreach ($pub_ally_list as $pub_ally_name) {
        if ($pub_ally_name == "")
            continue;
        if (in_array($pub_ally_name, $pub_ally_protection) && $user_auth["server_show_positionhided"] ==
            0 && $user_data["user_admin"] == 0 && $user_data["user_coadmin"] == 0) {
            $statictics[$pub_ally_name][0][0] = null;
            continue;
        }
        $friend = false;
        if (in_array($pub_ally_name, $allied))
            $friend = true;

        for ($galaxy = 1; $galaxy <= intval($server_config['num_of_galaxies']); $galaxy++) {
            for ($system = 1; $system <= intval($server_config['num_of_systems']); $system =
                $system + $step) {
                $request = "select galaxy, system, row, player from " . TABLE_UNIVERSE;
                $request .= " where galaxy = " . $galaxy;
                $request .= " and system between " . $system . " and " . ($system + $step - 1);
                $request .= " and ally like '" . $pub_ally_name . "'";
                $request .= " order by player, galaxy, system, row";
                $result = $db->sql_query($request);
                $nb_planet = $db->sql_numrows($result);

                $population = array();
                while (list($galaxy_, $system_, $row_, $player) = $db->sql_fetch_row($result)) {
                    $population[] = array("galaxy" => $galaxy_, "system" => $system_, "row" => $row_,
                        "player" => $player);
                }

                $statictics[$pub_ally_name][$galaxy][$system] = array("planet" => $nb_planet,
                    "population" => $population);
            }
        }
    }
    user_set_stat(null, null, 1);

    return $statictics;
}

/**
 * Enregistrement des donn�es erron�es envoy�es via le navigateur dans les logs
 * @param string $datas Donn�es du navigateur
 */
function galaxy_getsource_error($datas)
{
    global $user_data, $server_config;

    if ($server_config["debug_log"] == "1") {
        $nomfichier = PATH_LOG_TODAY . date("ymd_His") . "_ID" . $user_data["user_id"] .
            "_Error.txt";
        write_file($nomfichier, "w", $datas);
    }
}

/**
 * R�cup�ration des donn�es transmises via le navigateur
 */
function galaxy_getsource()
{
    global $db, $user_data, $user_auth, $server_config;
    global $pub_data, $pub_datatype;

    if (!isset($pub_data) || !isset($pub_datatype)) {
        redirection("index.php?action=message&id_message=errorfatal&info");
    }

    $lines = array();
    $lines = explode(chr(10), $pub_data);

    switch ($pub_datatype) {
        case "basic":
            if (($user_auth["server_set_system"] != 1 && $user_auth["server_set_spy"] != 1) &&
                $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
                redirection("index.php?action=message&id_message=errorfatal&info");
            }
            continue;

        case "combat_report":
            galaxy_check_auth("set_rc");
            insert_RC($pub_data);
            break;

        case "general_player":
            galaxy_check_auth("set_ranking");
            galaxy_getranking($lines, $pub_datatype);
            break;

        case "fleet_player":
            galaxy_check_auth("set_ranking");
            galaxy_getranking($lines, $pub_datatype);
            break;

        case "research_player":
            galaxy_check_auth("set_ranking");
            galaxy_getranking($lines, $pub_datatype);
            break;

        case "general_ally":
            galaxy_check_auth("set_ranking");
            galaxy_getranking($lines, $pub_datatype);
            break;

        case "fleet_ally":
            galaxy_check_auth("set_ranking");
            galaxy_getranking($lines, $pub_datatype);
            break;

        case "research_ally":
            galaxy_check_auth("set_ranking");
            galaxy_getranking($lines, $pub_datatype);
            break;

        case "none":
            redirection("index.php");


        default:
            redirection("index.php?action=message&id_message=errorfatal&info");
    }

    $nb_lines = sizeof($lines);
    $files = $lines;
    $authentification = true;

    $checking = false;
    for ($i = 0; $i < $nb_lines; $i++) {
        $line = $lines[$i];

        if (preg_match("#Syst�me solaire#", $line)) {
            if ($user_auth["server_set_system"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] !=
                1) {
                redirection("index.php?action=message&id_message=errorfatal&info");
            }
            $lines = array_values($lines);
            $system_added = galaxy_system($lines);
            break;
        } elseif (preg_match("/Mati�res premi�res sur/", $line)) {
            if ($user_auth["server_set_spy"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] !=
                1) {
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
                $nomfichier = PATH_LOG_TODAY . date("ymd_His") . "_ID" . $user_data["user_id"] .
                    "_sys_G$galaxy" . "S" . "$system.txt";
                write_file($nomfichier, "w", $files);
            }
            log_("load_system", array($galaxy, $system));

            //Statistiques serveur
            /*//Incompatible MySQL 4.0
            $request = "insert into ".TABLE_STATISTIC." values ('planetimport_server', '15')";
            $request .= " on duplicate key update statistic_value = statistic_value + 15";
            $db->sql_query($request);*/
            $request = "update " . TABLE_STATISTIC .
                " set statistic_value = statistic_value + 15";
            $request .= " where statistic_name = 'planetimport_server'";
            $db->sql_query($request);
            if ($db->sql_affectedrows() == 0) {
                $request = "insert ignore into " . TABLE_STATISTIC .
                    " values ('planetimport_server', '15')";
                $db->sql_query($request);
            }

            redirection("index.php?galaxy=$galaxy&system=$system");
        }
    }
    if (isset($report_added)) {
        if ($report_added !== false) {

            if ($server_config["debug_log"] == "1") {
                //Sauvegarde donn�es transmises
                $nomfichier = PATH_LOG_TODAY . date("ymd_His") . "_ID" . $user_data["user_id"] .
                    "_spy(" . sizeof($report_added) . ").txt";
                write_file($nomfichier, "w", $files);
            }
            log_("load_spy", sizeof($report_added));

            //Statistiques serveur
            $request = "update " . TABLE_STATISTIC .
                " set statistic_value = statistic_value + " . sizeof($report_added);
            $request .= " where statistic_name = 'spyimport_server'";
            $db->sql_query($request);
            if ($db->sql_affectedrows() == 0) {
                $request = "insert ignore into " . TABLE_STATISTIC .
                    " values ('spyimport_server', '" . sizeof($report_added) . "')";
                $db->sql_query($request);
            }
            $recup = "SELECT spy_added_web FROM " . TABLE_USER . " WHERE user_id =" . $user_data["user_id"];
            $recup = $db->sql_query($recup);
            $valeur = $db->sql_fetch_row($recup);
            $query = "Update `" . TABLE_USER . "` SET `spy_added_web` = '" . ($valeur[0] +
                sizeof($report_added)) . "' WHERE `user_id` = '" . $user_data["user_id"] . "'";
            $db->sql_query($query);
            $reports = "";
            foreach ($report_added as $v) {
                list($added, $coordinates, $timestamp) = $v;
                $reports .= $added . "~" . $coordinates . "~" . $timestamp . "�";
            }
            $reports = substr($reports, 0, strlen($reports) - 2);
            redirection("index.php?action=message&id_message=spy_added&info=" . $reports);
        }
    }

    galaxy_getsource_error($files);
    redirection("index.php?action=message&id_message=errorfatal&info");
}

/**
 * Ajout d'un syst�me
 */
function galaxy_system($lines)
{
    $OK = false;
    $status = array_fill(1, 15, "");
    $galaxy = "";
    $system = "";
    $now = time();
    $regExp = '/(\d{1,2})\s+([A-Za-z0-9�����������������_\-\. ]+?)(?:\s\([0-9min \*]+\))?(\s+Lune \(Taille : \d+\))?\s{2,}([A-Za-z0-9�����������������_\-\. ]+?)(\s\([iIbvdf ]+\))?\s{2,}([A-Za-z0-9�����������������_\-\. ]+?)?\s+(?:Espionner[A-Za-z ]+)?/';
    for ($i = 0; $i < sizeof($lines); $i++) {
        $line = $lines[$i];

        if (preg_match("#^Syst�me solaire (\d+?):(\d+?)$#", trim($line), $arr)) {
            $galaxy = $arr[1];
            $system = $arr[2];
            $solar_system = array_fill(1, 15, array("moon" => "0", "planet" => "", "ally" =>
                "", "player" => "", "status" => ""));
            $OK = true;
            continue;
        }

        if ($OK) {
            for (; $i < sizeof($lines); $i++) {
                $line = $lines[$i];
                $planet = "";
                $ally = "";
                $player = "";
                $moon = 0;
                $statuts = "";
                //Modification pour compatibilit� v0.78c
                if (preg_match($regExp, $line, $regs)) {
                    if (!empty($regs[4]) && $regs[4] != ' ') {
                        $row = $regs[1];
                        $planet = $regs[2];
                        $moon = (!empty($regs[3])) ? 1 : 0;
                        $player = $regs[4];
                        $status = (isset($regs[5]) && $regs[5] != 'Espionner') ? $regs[5] : '';
                        $ally = (isset($regs[6]) && $regs[6] != 'Espionner') ? $regs[6] : '';
                        $solar_system[$row] = array("moon" => $moon, "planet" => $planet, "ally" => $ally,
                            "player" => $player, "status" => $status);
                    }
                }
            }
            //Fin de la modification pour compatibilit� v0.78c
            $row = 1;
            foreach ($solar_system as $v) {
                if ($galaxy != "" && $system != "") {
                    if (!galaxy_add_system($galaxy, $system, $row, $v["moon"], $v["planet"], $v["ally"],
                        $v["player"], $v["status"], $now)) {
                        return false;
                    }
                }
                $row++;
            }

            break;
        }
    }

    if (!$OK && $galaxy <> "" && $system <> "") {
        for ($row = 1; $row <= 15; $row++) {
            galaxy_add_system($galaxy, $system, $row, "0", "", "", "", "", $now);
        }
    }
    galaxy_add_system_ally();

    return array($galaxy, $system);
}




/**
 * R�cup�ration des rapports d'espionnage
 */
function galaxy_reportspy_show()
{
    global $db;
    global $pub_galaxy, $pub_system, $pub_row, $pub_spy_id, $server_config;

    if (!check_var($pub_galaxy, "Num") || !check_var($pub_system, "Num") || !
        check_var($pub_row, "Num")) {
        return false;
    }

    if (!isset($pub_galaxy) || !isset($pub_system) || !isset($pub_row)) {
        return false;
    }
    if (intval($pub_galaxy) < 1 || intval($pub_galaxy) > intval($server_config['num_of_galaxies']) ||
        intval($pub_system) < 1 || intval($pub_system) > intval($server_config['num_of_systems']) ||
        intval($pub_row) < 1 || intval($pub_row) > 15) {
        return false;
    }

    $request_astre_name = "select name from " . TABLE_UNIVERSE . " where galaxy = " .
        intval($pub_galaxy) . " and system = " . intval($pub_system) . " and row = " .
        intval($pub_row);
    $result_astre_name = $db->sql_query($request_astre_name);
    $astre_name = $db->sql_fetch_assoc($result_astre_name); //R�cup�re le nom de la plan�te

    //RE plan�te
    $request = "select id_spy, user_name, dateRE";
    $request .= " from " . TABLE_PARSEDSPY . " left join " . TABLE_USER .
        " on user_id = sender_id";
    if (!isset($pub_spy_id)) {
        $request .= " where active = '1'  and coordinates = '" . intval($pub_galaxy) .
            ":" . intval($pub_system) . ":" . intval($pub_row) . "'";
    } else {
        $request .= " where id_spy = " . intval($pub_spy_id);
    }
    $request .= " and BaLu<=0 and Pha<=0 and PoSa<=0 and planet_name='" . $astre_name['name'] .
        "'";
    $request .= " order by dateRE desc LIMIT 1";
    $result = $db->sql_query($request);

    $reports = array();
    while (list($pub_spy_id, $user_name, $dateRE) = $db->sql_fetch_row($result)) {
        $data = UNparseRE($pub_spy_id);
        $reports[] = array("spy_id" => $pub_spy_id, "sender" => $user_name, "data" => $data,
            "moon" => 0, "dateRE" => $dateRE);
    }

    $request = "select id_spy, user_name, dateRE";
    $request .= " from " . TABLE_PARSEDSPY . " left join " . TABLE_USER .
        " on user_id = sender_id";
    if (!isset($pub_spy_id)) {
        $request .= " where active = '1'  and coordinates = '" . intval($pub_galaxy) .
            ":" . intval($pub_system) . ":" . intval($pub_row) . "'";
    } else {
        $request .= " where id_spy = " . intval($pub_spy_id);
    }
    $request .= " and M<=0 and C<=0 and D<=0 and CES<=0 and CEF<=0 and UdN<=0 and Lab<=0 and Ter<=0 and Silo<=0 and not planet_name='" .
        $astre_name['name'] . "'";
    $request .= " order by dateRE desc LIMIT 1";
    $result = $db->sql_query($request);

    while (list($pub_spy_id, $user_name, $dateRE) = $db->sql_fetch_row($result)) {
        $data = UNparseRE($pub_spy_id);
        $reports[] = array("spy_id" => $pub_spy_id, "sender" => $user_name, "data" => $data,
            "moon" => 1, "dateRE" => $dateRE);
    }

    return $reports;
}

/**
 * R�cup�ration des rapports de combat
 */
function galaxy_reportrc_show()
{
    global $db;
    global $pub_galaxy, $pub_system, $pub_row, $pub_spy_id, $server_config;

    if (!check_var($pub_galaxy, "Num") || !check_var($pub_system, "Num") || !
        check_var($pub_row, "Num")) {
        return false;
    }

    if (!isset($pub_galaxy) || !isset($pub_system) || !isset($pub_row)) {
        return false;
    }
    if (intval($pub_galaxy) < 1 || intval($pub_galaxy) > intval($server_config['num_of_galaxies']) ||
        intval($pub_system) < 1 || intval($pub_system) > intval($server_config['num_of_systems']) ||
        intval($pub_row) < 1 || intval($pub_row) > 15) {
        return false;
    }

    $request = "select id_rc from " . TABLE_PARSEDRC;
    if (!isset($pub_rc_id)) {
        $request .= " where coordinates = '" . intval($pub_galaxy) . ':' . intval($pub_system) .
            ':' . intval($pub_row) . "'";
        $request .= " order by dateRC desc";
    } else {
        $request .= " where id_rc = " . intval($pub_rc_id);
    }
    $result = $db->sql_query($request);

    $reports = array();
    while (list($pub_rc_id) = $db->sql_fetch_row($result))
        $reports[] = UNparseRC($pub_rc_id);

    return $reports;
}

/**
 * Purge des rapports d'espionnage
 */
function galaxy_purge_spy()
{
    global $db, $server_config;

    if (!is_numeric($server_config["max_keepspyreport"])) {
        return;
    }
    $max_keepspyreport = intval($server_config["max_keepspyreport"]);

    $request = "select id_spy from " . TABLE_PARSEDSPY .
        " where active = '0' or dateRE < " . (time() - 60 * 60 * 24 * $max_keepspyreport);
    $result = $db->sql_query($request);

    while (list($spy_id) = $db->sql_fetch_row($result)) {
        $request = "select * from " . TABLE_USER_SPY . " where spy_id = " . $spy_id;
        $result2 = $db->sql_query($request);
        if ($db->sql_numrows($result2) == 0) {
            $request = "delete from " . TABLE_PARSEDSPY . " where id_spy = " . $spy_id;
            $db->sql_query($request);
        }
    }
}

/**
 * R�cup�ration des syst�mes favoris
 */
function galaxy_getfavorites()
{
    global $db, $user_data;

    $favorite = array();

    $request = "select galaxy, system from " . TABLE_USER_FAVORITE;
    $request .= " where user_id = " . $user_data["user_id"];
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
function galaxy_show_ranking_player()
{
    global $db;
    global $pub_order_by, $pub_date, $pub_interval;

    if (!isset($pub_order_by)) {
        $pub_order_by = "general";
    }

    $tables = array(TABLE_RANK_PLAYER_POINTS, TABLE_RANK_PLAYER_ECO,
        TABLE_RANK_PLAYER_TECHNOLOGY, TABLE_RANK_PLAYER_MILITARY,
        TABLE_RANK_PLAYER_MILITARY_BUILT, TABLE_RANK_PLAYER_MILITARY_LOOSE, TABLE_RANK_PLAYER_MILITARY_DESTRUCT,
        TABLE_RANK_PLAYER_HONOR);
    $name = array('general', 'eco', 'techno', 'military', 'military_b', 'military_l', 'military_d',
        'honnor');

    // verification de la variable pub_order
    if (!in_array($pub_order_by, $name)) {
        $pub_order_by = "general";
    }

    // selection du max rank
    $maxrank = array();
    $i = 0;
    foreach ($tables as $table) {
        $request = "SELECT rank FROM `" . $table . "` order by `rank` desc limit 0,1";
        $result = $db->sql_query($request);
        $max = $db->sql_fetch_row($result);
        $maxrank[$i] = $max[0];
        $i++;

    }

    // selection de rank max !
    $maxrank = max($maxrank);

    if (!isset($pub_interval)) {
        $pub_interval = 1;
    }
    if (($pub_interval - 1) % 100 != 0 || $pub_interval > $maxrank) {
        $pub_interval = 1;
    }
    $limit_down = $pub_interval;
    $limit_up = $pub_interval + 99;

    $order = array();
    $ranking = array();
    $ranking_available = array();
    $table = array();

    // on determine l id du pub order
    $id = (array_keys($name, $pub_order_by));

    // en premier l id :
    $table[] = array("tablename" => $tables[$id[0]], "arrayname" => $name[$id[0]]);
    $i = 0;
    // ensuite le reste des table / nom
    for ($i; $i < sizeof($name); $i++) {
        if ($id[0] != $i) {
            $table[] = array("tablename" => $tables[$i], "arrayname" => $name[$i]);
        }

    }


    $i = 0;

    if (!isset($pub_date)) {
        $request = "select max(datadate) from " . $table[$i]["tablename"];
        $result = $db->sql_query($request);
        list($last_ranking) = $db->sql_fetch_row($result);
    } else
        $last_ranking = $pub_date;

    $request = "select rank, player, ally, points, user_name";
    $request .= " from " . $table[$i]["tablename"] . " left join " . TABLE_USER;
    $request .= " on sender_id = user_id";
    $request .= " where rank between " . $limit_down . " and " . $limit_up;
    $request .= isset($last_ranking) ? " and datadate = " . $db->sql_escape_string($last_ranking) :
        "";
    $request .= " order by rank";
    $result = $db->sql_query($request);

    while (list($rank, $player, $ally, $points, $user_name) = $db->sql_fetch_row($result)) {
        $ranking[$player][$table[$i]["arrayname"]] = array("rank" => $rank, "points" =>
            $points);
        $ranking[$player]["ally"] = $ally;
        $ranking[$player]["sender"] = $user_name;

        if ($pub_order_by == $table[$i]["arrayname"]) {
            $order[$rank] = $player;
        }
    }

    $request = "select distinct datadate from " . $table[$i]["tablename"] .
        " order by datadate desc";
    $result_2 = $db->sql_query($request);
    while ($row = $db->sql_fetch_assoc($result_2)) {
        $ranking_available[] = $row["datadate"];
    }

    for ($i; $i < sizeof($name); $i++) {
        reset($ranking);
        while ($value = current($ranking)) {
            $request = "select rank, player, ally, points, user_name";
            $request .= " from " . $table[$i]["tablename"] . " left join " . TABLE_USER;
            $request .= " on sender_id = user_id";
            $request .= " where player = '" . $db->sql_escape_string(key($ranking)) . "'";
            $request .= isset($last_ranking) ? " and datadate = " . $db->sql_escape_string($last_ranking) :
                "";
            $request .= " order by rank";
            $result = $db->sql_query($request);

            while (list($rank, $player, $ally, $points, $user_name) = $db->sql_fetch_row($result)) {
                $ranking[$player][$table[$i]["arrayname"]] = array("rank" => $rank, "points" =>
                    $points);
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
function galaxy_show_ranking_ally()
{
    global $db;
    global $pub_order_by, $pub_date, $pub_interval, $pub_suborder;

    if (!check_var($pub_order_by, "Char") || !check_var($pub_date, "Num") || !
        check_var($pub_interval, "Num") || !check_var($pub_suborder, "Char")) {
        redirection("index.php?action=message&id_message=errordata&info");
    }

    $tables = array(TABLE_RANK_ALLY_POINTS, TABLE_RANK_ALLY_ECO,
        TABLE_RANK_ALLY_TECHNOLOGY, TABLE_RANK_ALLY_MILITARY,
        TABLE_RANK_ALLY_MILITARY_BUILT, TABLE_RANK_ALLY_MILITARY_LOOSE, TABLE_RANK_ALLY_MILITARY_DESTRUCT,
        TABLE_RANK_ALLY_HONOR);
    $name = array('general', 'eco', 'techno', 'military', 'military_b', 'military_l', 'military_d',
        'honnor');

    // verification de la variable pub_order_by
    if (!in_array($pub_order_by, $name)) {
        $pub_order_by = "general";
    }


    // selection du max rank
    $maxrank = array();
    $i = 0;
    foreach ($tables as $table) {
        $request = "SELECT rank FROM `" . $table . "` order by `rank` desc limit 0,1";
        $result = $db->sql_query($request);
        $max = $db->sql_fetch_row($result);
        $maxrank[$i] = $max[0];
        $i++;

    }
	
	// selection de rank max !
    $maxrank = max($maxrank);

    if (isset($pub_suborder) && $pub_suborder == "member")
        $pub_order_by2 = "points_per_member desc";
    else
        $pub_order_by2 = "rank";

    if (!isset($pub_interval)) {
        $pub_interval = 1;
    }
    if (($pub_interval - 1) % 100 != 0 || $pub_interval > $maxrank) {
        $pub_interval = 1;
    }
    $limit_down = $pub_interval;
    $limit_up = $pub_interval + 99;

    $order = array();
    $ranking = array();
    $ranking_available = array();
    $table = array();

    // on determine l id du pub order
    $id = (array_keys($name, $pub_order_by));

    // en premier l id :
    $table[] = array("tablename" => $tables[$id[0]], "arrayname" => $name[$id[0]]);
    $i = 0;
    // ensuite le reste des table / nom
    for ($i; $i < sizeof($name); $i++) {
        if ($id[0] != $i) {
            $table[] = array("tablename" => $tables[$i], "arrayname" => $name[$i]);
        }

    }

    $i = 0;

    if (!isset($pub_date)) {
        $request = "select max(datadate) from " . $table[$i]["tablename"];
        $result = $db->sql_query($request);
        list($last_ranking) = $db->sql_fetch_row($result);
    } else
        $last_ranking = $pub_date;

    $request = "select rank, ally, number_member, points,  user_name";
    $request .= " from " . $table[$i]["tablename"] . " left join " . TABLE_USER;
    $request .= " on sender_id = user_id";
    $request .= " where rank between " . $limit_down . " and " . $limit_up;
    $request .= isset($last_ranking) ? " and datadate = " . $db->sql_escape_string($last_ranking) :
        "";
    $request .= " order by " . $pub_order_by2;
	
    $result = $db->sql_query($request);
 
         while ($row = $db->sql_fetch_assoc($result)) {
			$ranking[$row["ally"]][$table[$i]["arrayname"]] = array("rank" => $row["rank"], "points" =>  $row["points"],
				"points_per_member" => (int)($row["points"]/$row["number_member"]));
			$ranking[$row["ally"]]["number_member"] = $row["number_member"];
			$ranking[$row["ally"]]["sender"] = $row["user_name"];

			if ($pub_order_by == $table[$i]["arrayname"]) {
				$order[$row["rank"]] = $row["ally"];
			}
        }


    $request = "select distinct datadate from " . $table[$i]["tablename"] .
        " order by datadate desc";
    $result_2 = $db->sql_query($request);
    while ($row = $db->sql_fetch_assoc($result_2)) {
        $ranking_available[] = $row["datadate"];
    }

    for ($i; $i < sizeof($name); $i++) {
        reset($ranking);
        while ($value = current($ranking)) {
            $request = "select rank, ally, number_member, points,  user_name";
            $request .= " from " . $table[$i]["tablename"] . " left join " . TABLE_USER;
            $request .= " on sender_id = user_id";
            $request .= " where ally = '" . $db->sql_escape_string(key($ranking)) . "'";
            $request .= isset($last_ranking) ? " and datadate = " . $db->sql_escape_string($last_ranking) :
                "";
            $request .= " order by rank";
            $result = $db->sql_query($request);

            while ($row = $db->sql_fetch_assoc($result)) {           
				$ranking[$row["ally"]][$table[$i]["arrayname"]] = array("rank" => $row["rank"], "points" =>  $row["points"],
					"points_per_member" => (int)($row["points"]/$row["number_member"]));
				$ranking[$row["ally"]]["number_member"] = $row["number_member"];
				$ranking[$row["ally"]]["sender"] = $row["user_name"];

				if ($pub_order_by == $table[$i]["arrayname"]) {
					$order[$row["rank"]] = $row["ally"];
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
function galaxy_show_ranking_unique_player($player, $last = false)
{
    global $db;

    $ranking = array();
    $tables = array(TABLE_RANK_PLAYER_POINTS, TABLE_RANK_PLAYER_ECO,
        TABLE_RANK_PLAYER_TECHNOLOGY, TABLE_RANK_PLAYER_MILITARY,
        TABLE_RANK_PLAYER_MILITARY_BUILT, TABLE_RANK_PLAYER_MILITARY_LOOSE, TABLE_RANK_PLAYER_MILITARY_DESTRUCT,
        TABLE_RANK_PLAYER_HONOR);
    $name = array('general', 'eco', 'techno', 'military', 'military_b', 'military_l', 'military_d',
        'honnor');

    $i = 0;
    foreach ($tables as $table) {

        $request = "select datadate, rank, points";
        $request .= " from " . $table;
        $request .= " where player = '" . $db->sql_escape_string($player) . "'";
        $request .= " order by datadate desc";
        $result = $db->sql_query($request);
        while (list($datadate, $rank, $points) = $db->sql_fetch_row($result)) {
            $ranking[$datadate][$name[$i]] = array("rank" => $rank, "points" => $points);
            if ($last)
                break;
        }


        $i++;
    }


    return $ranking;
}

/**
 * Affichage classement d'une ally particuli�re
 */
function galaxy_show_ranking_unique_ally($ally, $last = false)
{
    global $db;

    $ranking = array();
    $tables = array(TABLE_RANK_ALLY_POINTS, TABLE_RANK_ALLY_ECO,
        TABLE_RANK_ALLY_TECHNOLOGY, TABLE_RANK_ALLY_MILITARY,
        TABLE_RANK_ALLY_MILITARY_BUILT, TABLE_RANK_ALLY_MILITARY_LOOSE, TABLE_RANK_ALLY_MILITARY_DESTRUCT,
        TABLE_RANK_ALLY_HONOR);
    $name = array('general', 'eco', 'techno', 'military', 'military_b', 'military_l', 'military_d',
        'honnor');

    $i = 0;
    foreach ($tables as $table) {

        $request = "select datadate, rank, points, number_member";
        $request .= " from " . $table;
        $request .= " where ally = '" . $db->sql_escape_string($ally) . "'";
        $request .= " order by datadate desc";
        $result = $db->sql_query($request);
         while ($row = $db->sql_fetch_assoc($result)) {
            $ranking[$row["datadate"]][$name[$i]] = array("rank" => $row["rank"], "points" => $row["points"], "points_per_member" => (int)($row["points"]/$row["number_member"]));
            $ranking[$row["datadate"]]["number_member"] = $row["number_member"];
            if ($last)
                break;
        
        
        }
    


        $i++;
    }


    return $ranking;
}

/**
 * R�cup�ration du classement joueurs
 */
function galaxy_getranking($lines, $datatype)
{
    global $db, $user_data, $server_config;

    switch ($datatype) {
        case "general_player":
            $ranktable = TABLE_RANK_PLAYER_POINTS;
            break;
        case "fleet_player":
            $ranktable = TABLE_RANK_PLAYER_FLEET;
            break;
        case "research_player":
            $ranktable = TABLE_RANK_PLAYER_RESEARCH;
            break;

        case "general_ally":
            $ranktable = TABLE_RANK_ALLY_POINTS;
            break;
        case "fleet_ally":
            $ranktable = TABLE_RANK_ALLY_FLEET;
            break;
        case "research_ally":
            $ranktable = TABLE_RANK_ALLY_RESEARCH;
            break;

        default:
            redirection("index.php?action=message&id_message=errorfatal&info");
    }

    $time = time() - 60 * 4;
    if ($time > mktime(0, 0, 0) && $time < mktime(8, 0, 0))
        $timestamp = mktime(0, 0, 0);
    if ($time > mktime(8, 0, 0) && $time < mktime(16, 0, 0))
        $timestamp = mktime(8, 0, 0);
    if ($time > mktime(16, 0, 0) && $time < (mktime(0, 0, 0) + 60 * 60 * 24))
        $timestamp = mktime(16, 0, 0);

    $files = array();
    $OK = false;
    $last_position = 0;
    $index = 0;
    if (preg_match("#player#", $datatype)) {
        for ($i = 0; $i < sizeof($lines); $i++) {
            $line = trim($lines[$i]);

            if (!$OK && preg_match("#^Place+\s+Joueur+\s+Alliance+\s+Points$#", $line)) {
                $OK = true;
                $position = 0;
                continue;
            }

            if ($OK) {
                $files[] = $line;

                $index++;
                //3 lignes , Compatibilit� 0.76 , les . dans les nombres http://ogsteam.fr/forums/viewtopic.php?pid=27522#p27522
                preg_match("#^(\d+)\s+\S\s+(.*?)\s+(?:\s+Envoyer\sun\smessage)?\s+(.*?)?\s+([^\s][0-9.]*)$#",
                    $line, $arr);
                list($text, $position, $player, $ally, $points) = $arr;
                $points = str_replace('.', '', $points);

                if (!is_numeric($position) || !is_string($player) || !is_string($ally) || !
                    is_numeric($points)) {
                    return false;
                }
                if ($last_position != 0) {
                    if ($last_position + 1 != $position) {
                        return false;
                    }
                }
                $ranking[$position] = array("player" => $player, "ally" => $ally, "points" => $points);
                $last_position = $position;
                if ($index == 100)
                    break;
            }
        }
    } else {
        for ($i = 0; $i < sizeof($lines); $i++) {
            $line = trim($lines[$i]);

            if (!$OK && preg_match("#^Place+\s+Alliance+\s+Memb.+\s+(Milliers de )?points+\s+par membre$#i",
                $line)) {
                $OK = true;
                $position = 0;
                continue;
            }

            if ($OK) {
                $files[] = $line;

                $index++;
                //5 lignes , Compatibilit� 0.76 , les . dans les nombres http://ogsteam.fr/forums/viewtopic.php?pid=27522#p27522 et posts suivants
                preg_match("#^(\d+)\s+\S\s+(.*?)\s+([^\s][0-9.]*)\s+([^\s][0-9.]*)\s+([^\s][0-9.]*)$#",
                    $line, $arr);
                list($text, $position, $ally, $nb_member, $points, $points_per_member) = $arr;
                $nb_member = str_replace('.', '', $nb_member);

                $points = str_replace('.', '', $points);
                $points_per_member = str_replace('.', '', $points_per_member);

                if (!is_numeric($position) || !is_string($ally) || !is_numeric($nb_member) || !
                    is_numeric($points) || !is_numeric($points_per_member)) {
                    return false;
                }
                if ($last_position != 0) {
                    if ($last_position + 1 != $position) {
                        return false;
                    }
                }
                $ranking[$position] = array("ally" => $ally, "number_member" => $nb_member,
                    "points" => $points, "points_per_member" => $points_per_member);
                $last_position = $position;
                if ($index == 100)
                    break;
            }
        }
    }

    if (!$OK) {
        redirection("index.php?action=ranking");
    }

    if ($server_config["debug_log"] == "1") {
        //Sauvegarde donn�es tranmises
        $nomfichier = PATH_LOG_TODAY . date("ymd_His") . "_ID" . $user_data["user_id"] .
            "_ranking_" . $datatype . ".txt";
        write_file($nomfichier, "w", $files);
    }

    while ($rankline = current($ranking)) {
        if (preg_match("#player#", $datatype)) {
            $request = "insert ignore into " . $ranktable;
            $request .= " (datadate, rank, player, ally, points, sender_id)";
            $request .= " values (" . $timestamp . ", " . key($ranking) . ", '" . $db->
                sql_escape_string($rankline["player"]) . "', '" . $db->sql_escape_string($rankline["ally"]) .
                "'," . $rankline["points"] . ", " . $user_data["user_id"] . ")";
        } else {
            $request = "insert ignore into " . $ranktable;
            $request .= " (datadate, rank, ally, number_member, points, points_per_member, sender_id)";
            $request .= " values (" . $timestamp . ", " . key($ranking) . ", '" . $db->
                sql_escape_string($rankline["ally"]) . "', " . $rankline["number_member"] . ", " .
                $rankline["points"] . ", " . $rankline["points_per_member"] . ", " . $user_data["user_id"] .
                ")";
        }
        $db->sql_query($request);

        next($ranking);
    }

    user_set_stat(null, null, null, null, null, $index);

    if (preg_match("#player#", $datatype)) {
        log_("load_rank", array("WEB", $datatype, "player", $timestamp, $index));
    } else {
        log_("load_rank", array("WEB", $datatype, "ally", $timestamp, $index));
    }

    //Statistiques serveur
    $request = "update " . TABLE_STATISTIC .
        " set statistic_value = statistic_value + " . sizeof($ranking);
    $request .= " where statistic_name = 'rankimport_server'";
    $db->sql_query($request);
    if ($db->sql_affectedrows() == 0) {
        $request = "insert ignore into " . TABLE_STATISTIC .
            " values ('rankimport_server', '" . sizeof($ranking) . "')";
        $db->sql_query($request);
    }

    if (preg_match("#player#", $datatype))
        redirection("index.php?action=ranking&subaction=player");
    if (preg_match("#ally#", $datatype))
        redirection("index.php?action=ranking&subaction=ally");
}

/**
 * Suppression automatique de classements joueurs & alliances
 */
function galaxy_purge_ranking()
{
    global $db, $server_config;

    if (!is_numeric($server_config["max_keeprank"])) {
        return;
    }
    $max_keeprank = intval($server_config["max_keeprank"]);

    $rank_tables = array(TABLE_RANK_PLAYER_POINTS, TABLE_RANK_ALLY_POINTS,TABLE_RANK_PLAYER_ECO,TABLE_RANK_PLAYER_TECHNOLOGY,
            TABLE_RANK_PLAYER_MILITARY,TABLE_RANK_PLAYER_MILITARY_BUILT,TABLE_RANK_PLAYER_MILITARY_LOOSE,
            TABLE_RANK_PLAYER_MILITARY_DESTRUCT,TABLE_RANK_PLAYER_HONOR,TABLE_RANK_ALLY_ECO,TABLE_RANK_ALLY_TECHNOLOGY,
            TABLE_RANK_ALLY_MILITARY,TABLE_RANK_ALLY_MILITARY_BUILT,TABLE_RANK_ALLY_MILITARY_LOOSE,TABLE_RANK_ALLY_MILITARY_DESTRUCT,
            TABLE_RANK_ALLY_HONOR);
    
    if ($server_config["keeprank_criterion"] == "day") {
        // classement joueur

        foreach ($rank_tables as $table){
        $request = "delete from " . $table . " where datadate < " . (time
            () - 60 * 60 * 24 * $max_keeprank);
        $db->sql_query($request, true, false);
        }

    }

    if ($server_config["keeprank_criterion"] == "quantity") {
    	foreach ($rank_tables as $table){
    		
	        $request = "select distinct datadate from " . $table .
	            " order by datadate desc limit 0, " . $max_keeprank;
	        $result = $db->sql_query($request);
	        while ($row = $db->sql_fetch_assoc($result)) {
	            $datadate = $row["datadate"];
	        }
	        if (isset($datadate)) {
	            $request = "delete from " . $table . " where datadate < " . $datadate;
	            $db->sql_query($request, true, false);
	        }
    	}
      
    }
}


/**
 * Suppression manuelle de classements
 */
function galaxy_drop_ranking()
{
    global $db, $server_config;
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
        $requests[] = "delete from " . TABLE_RANK_PLAYER_POINTS . " where datadate = " .
            intval($pub_datadate);
        $requests[] = "delete from " . TABLE_RANK_PLAYER_ECO . " where datadate = " .
            intval($pub_datadate);
        $requests[] = "delete from " . TABLE_RANK_PLAYER_TECHNOLOGY .
            " where datadate = " . intval($pub_datadate);
        $requests[] = "delete from " . TABLE_RANK_PLAYER_MILITARY . " where datadate = " .
            intval($pub_datadate);
        $requests[] = "delete from " . TABLE_RANK_PLAYER_MILITARY_BUILT .
                    " where datadate = " . intval($pub_datadate);
        $requests[] = "delete from " . TABLE_RANK_PLAYER_MILITARY_LOOSE .
            " where datadate = " . intval($pub_datadate);
        $requests[] = "delete from " . TABLE_RANK_PLAYER_MILITARY_DESTRUCT .
            " where datadate = " . intval($pub_datadate);
        $requests[] = "delete from " . TABLE_RANK_PLAYER_HONOR . " where datadate = " .
            intval($pub_datadate);


        foreach ($requests as $request) {
            $db->sql_query($request);
        }


    } elseif ($pub_subaction == "ally") {
        $requests[] = "delete from " . TABLE_RANK_ALLY_POINTS . " where datadate = " .
            intval($pub_datadate);
        $requests[] = "delete from " . TABLE_RANK_ALLY_ECO . " where datadate = " .
            intval($pub_datadate);
        $requests[] = "delete from " . TABLE_RANK_ALLY_TECHNOLOGY .
            " where datadate = " . intval($pub_datadate);
        $requests[] = "delete from " . TABLE_RANK_ALLY_MILITARY . " where datadate = " .
            intval($pub_datadate);
        $requests[] = "delete from " . TABLE_RANK_ALLY_MILITARY_BUILT .
                    " where datadate = " . intval($pub_datadate);
        $requests[] = "delete from " . TABLE_RANK_ALLY_MILITARY_LOOSE .
            " where datadate = " . intval($pub_datadate);
        $requests[] = "delete from " . TABLE_RANK_ALLY_MILITARY_DESTRUCT .
            " where datadate = " . intval($pub_datadate);
        $requests[] = "delete from " . TABLE_RANK_ALLY_HONOR . " where datadate = " .
            intval($pub_datadate);
        foreach ($requests as $request) {
            $db->sql_query($request);
        }
    }

    redirection("index.php?action=ranking&subaction=" . $pub_subaction);
}

/**
 * Listing des phalanges
 */
function galaxy_get_phalanx($galaxy, $system)
{
    global $db, $server_config, $user_data, $user_auth;

    $ally_protection = array();
    if ($server_config["ally_protection"] != "")
        $ally_protection = explode(",", $server_config["ally_protection"]);

    $phalanxer = array();

    $req = "select galaxy, system, row, phalanx, gate, name, ally, player from " .
        TABLE_UNIVERSE . " where galaxy = " . $galaxy .
        " and moon = '1' and phalanx > 0 and system + (power(phalanx, 2) - 1) >= " . $system .
        " and system - (power(phalanx, 2) - 1) <= " . $system;

    $result = $db->sql_query($req);
    while ($coordinates = $db->sql_fetch_assoc($result)) {
        if (!in_array($coordinates["ally"], $ally_protection) || $coordinates["ally"] ==
            "" || $user_auth["server_show_positionhided"] == 1 || $user_data["user_admin"] ==
            1 || $user_data["user_coadmin"] == 1)
            $phalanxer[] = $coordinates;
    }

    return $phalanxer;
}

/**
 * Affichage des syst�mes solaires obsol�tes
 */
function galaxy_obsolete()
{
    global $db;
    global $pub_perimeter, $pub_since, $pub_typesearch;

    $obsolete = array();
    if (isset($pub_perimeter) && isset($pub_since) && is_numeric($pub_perimeter) &&
        is_numeric($pub_since)) {
        if (!isset($pub_typesearch) || ($pub_typesearch != "M" && $pub_typesearch != "P"))
            $pub_typesearch = "P";

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
        } else {
            $field = "last_update_moon";
            $row_field = ", row";
            $moon = 1;
        }

        switch ($pub_since) {
            case 56:
                $request = "select distinct galaxy, system" . $row_field . " from " .
                    TABLE_UNIVERSE . " where moon = '" . $moon . "' and " . $field . " < " . $pub_since_56;
                if ($pub_perimeter != 0)
                    $request .= " and galaxy = " . intval($pub_perimeter);
                $request .= " order by galaxy, system, row limit 0, 51";
                $result = $db->sql_query($request);

                while ($row = $db->sql_fetch_assoc($result)) {
                    $request = "select min(" . $field . ") from " . TABLE_UNIVERSE .
                        " where galaxy = " . $row["galaxy"] . " and system = " . $row["system"];
                    $result2 = $db->sql_query($request);
                    list($last_update) = $db->sql_fetch_row($result2);
                    $row["last_update"] = $last_update;

                    $obsolete[56][] = $row;
                }

            case 42:
                $request = "select distinct galaxy, system" . $row_field . " from " .
                    TABLE_UNIVERSE . " where moon = '" . $moon . "' and " . $field . " between " . $pub_since_56 .
                    " and " . $pub_since_42;
                if ($pub_perimeter != 0)
                    $request .= " and galaxy = " . intval($pub_perimeter);
                if ($pub_perimeter != 0)
                    $request .= " and galaxy = " . intval($pub_perimeter);
                $request .= " order by galaxy, system, row limit 0, 51";
                $result = $db->sql_query($request);

                while ($row = $db->sql_fetch_assoc($result)) {
                    $request = "select min(" . $field . ") from " . TABLE_UNIVERSE .
                        " where galaxy = " . $row["galaxy"] . " and system = " . $row["system"];
                    $result2 = $db->sql_query($request);
                    list($last_update) = $db->sql_fetch_row($result2);
                    $row["last_update"] = $last_update;

                    $obsolete[42][] = $row;
                }

            case 28:
                $request = "select distinct galaxy, system" . $row_field . " from " .
                    TABLE_UNIVERSE . " where moon = '" . $moon . "' and " . $field . " between " . $pub_since_42 .
                    " and " . $pub_since_28;
                if ($pub_perimeter != 0)
                    $request .= " and galaxy = " . intval($pub_perimeter);
                $request .= " order by galaxy, system, row limit 0, 51";
                $result = $db->sql_query($request);

                while ($row = $db->sql_fetch_assoc($result)) {
                    $request = "select min(" . $field . ") from " . TABLE_UNIVERSE .
                        " where galaxy = " . $row["galaxy"] . " and system = " . $row["system"];
                    $result2 = $db->sql_query($request);
                    list($last_update) = $db->sql_fetch_row($result2);
                    $row["last_update"] = $last_update;

                    $obsolete[28][] = $row;
                }

            case 21:
                $request = "select distinct galaxy, system" . $row_field . " from " .
                    TABLE_UNIVERSE . " where moon = '" . $moon . "' and " . $field . " between " . $pub_since_28 .
                    " and " . $pub_since_21;
                if ($pub_perimeter != 0)
                    $request .= " and galaxy = " . intval($pub_perimeter);
                $request .= " order by galaxy, system, row limit 0, 51";
                $result = $db->sql_query($request);

                while ($row = $db->sql_fetch_assoc($result)) {
                    $request = "select min(" . $field . ") from " . TABLE_UNIVERSE .
                        " where galaxy = " . $row["galaxy"] . " and system = " . $row["system"];
                    $result2 = $db->sql_query($request);
                    list($last_update) = $db->sql_fetch_row($result2);
                    $row["last_update"] = $last_update;

                    $obsolete[21][] = $row;
                }

            case 14:
                $request = "select distinct galaxy, system" . $row_field . " from " .
                    TABLE_UNIVERSE . " where moon = '" . $moon . "' and " . $field . " between " . $pub_since_21 .
                    " and " . $pub_since_14;
                if ($pub_perimeter != 0)
                    $request .= " and galaxy = " . intval($pub_perimeter);
                $request .= " order by galaxy, system, row limit 0, 51";
                $result = $db->sql_query($request);

                while ($row = $db->sql_fetch_assoc($result)) {
                    $request = "select min(" . $field . ") from " . TABLE_UNIVERSE .
                        " where galaxy = " . $row["galaxy"] . " and system = " . $row["system"];
                    $result2 = $db->sql_query($request);
                    list($last_update) = $db->sql_fetch_row($result2);
                    $row["last_update"] = $last_update;

                    $obsolete[14][] = $row;
                }

            case 7:
                $request = "select distinct galaxy, system" . $row_field . " from " .
                    TABLE_UNIVERSE . " where moon = '" . $moon . "' and " . $field . " between " . $pub_since_14 .
                    " and " . $pub_since_7;
                if ($pub_perimeter != 0)
                    $request .= " and galaxy = " . intval($pub_perimeter);
                $request .= " order by galaxy, system, row limit 0, 51";
                $result = $db->sql_query($request);

                while ($row = $db->sql_fetch_assoc($result)) {
                    $request = "select min(" . $field . ") from " . TABLE_UNIVERSE .
                        " where galaxy = " . $row["galaxy"] . " and system = " . $row["system"];
                    $result2 = $db->sql_query($request);
                    list($last_update) = $db->sql_fetch_row($result2);
                    $row["last_update"] = $last_update;

                    $obsolete[7][] = $row;
                }

            default:
                return $obsolete;
        }
    }

    return $obsolete;
}



/**
 * Reconstruction des RE
 * @global $table_prefix, $db
 * @param string $id_RE RE � reconstituer
 * @return string $template_RE reconstitu�
 */
function UNparseRE($id_RE)
{
    global $table_prefix, $db;
    $show = array('flotte' => 0, 'defense' => 0, 'batiment' => 0, 'recherche' => 0);
    $flotte = array('PT' => 'Petit transporteur', 'GT' => 'Grand transporteur',
        'CLE' => 'Chasseur l�ger', 'CLO' => 'Chasseur lourd', 'CR' => 'Croiseur', 'VB' =>
        'Vaisseau de bataille', 'VC' => 'Vaisseau de colonisation', 'REC' => 'Recycleur',
        'SE' => 'Sonde espionnage', 'BMD' => 'Bombardier', 'DST' => 'Destructeur',
        'EDLM' => '�toile de la mort', 'SAT' => 'Satellite solaire', 'TRA' => 'Traqueur');
    $defs = array('LM' => 'Lanceur de missiles', 'LLE' => 'Artillerie laser l�g�re',
        'LLO' => 'Artillerie laser lourde', 'CG' => 'Canon de Gauss', 'AI' =>
        'Artillerie � ions', 'LP' => 'Lanceur de plasma', 'PB' => 'Petit bouclier', 'GB' =>
        'Grand bouclier', 'MIC' => 'Missile interception', 'MIP' =>
        'Missile interplan�taire');
    $bats = array('M' => 'Mine de m�tal', 'C' => 'Mine de cristal', 'D' =>
        'Synth�tiseur de deut�rium', 'CES' => 'Centrale �lectrique solaire', 'CEF' =>
        'Centrale �lectrique de fusion', 'UdR' => 'Usine de robots', 'UdN' =>
        'Usine de nanites', 'CSp' => 'Chantier spatial', 'HM' => 'Hangar de m�tal', 'HC' =>
        'Hangar de cristal', 'HD' => 'R�servoir de deut�rium', 'Lab' =>
        'Laboratoire de recherche', 'Ter' => 'Terraformeur', 'DdR' =>
        'D�p�t de ravitaillement', 'Silo' => 'Silo de missiles', 'BaLu' =>
        'Base lunaire', 'Pha' => 'Phalange de capteur', 'PoSa' =>
        'Porte de saut spatial');
    $techs = array('Esp' => 'Technologie Espionnage', 'Ordi' =>
        'Technologie Ordinateur', 'Armes' => 'Technologie Armes', 'Bouclier' =>
        'Technologie Bouclier', 'Protection' =>
        'Technologie Protection des vaisseaux spatiaux', 'NRJ' => 'Technologie Energie',
        'Hyp' => 'Technologie Hyperespace', 'RC' => 'Technologie R�acteur � combustion',
        'RI' => 'Technologie R�acteur � impulsion', 'PH' =>
        'Technologie Propulsion hyperespace', 'Laser' => 'Technologie Laser', 'Ions' =>
        'Technologie Ions', 'Plasma' => 'Technologie Plasma', 'RRI' =>
        'R�seau de recherche intergalactique', 'Graviton' => 'Technologie Graviton',
        'Astrophysique' => 'Technologie Astrophysique');
    $query = 'SELECT planet_name, coordinates, metal, cristal, deuterium, energie, activite, M, C, D, CES, CEF, UdR, UdN, CSp, HM, HC, 
		HD, Lab, Ter, Silo, DdR, BaLu, Pha, PoSa, LM, LLE, LLO, CG, AI, LP, PB, GB, MIC, MIP, PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, 
		DST, EDLM, SAT, TRA, Esp, Ordi, Armes, Bouclier, Protection, NRJ, Hyp, RC, RI, PH, Laser, Ions, Plasma, RRI, Graviton, Astrophysique, 
		dateRE, proba FROM ' . TABLE_PARSEDSPY . ' WHERE id_spy=' . $id_RE;
    $result = $db->sql_query($query);
    $row = $db->sql_fetch_assoc($result);

    $queryPlayerName = "SELECT player FROM " . TABLE_UNIVERSE .
        " WHERE concat(galaxy, ':', system, ':', row) = (SELECT coordinates FROM " .
        TABLE_PARSEDSPY . " WHERE id_spy=" . $id_RE . ")";
    $resultPN = $db->sql_query($queryPlayerName);
    $rowPN = $db->sql_fetch_assoc($resultPN);

    $sep_mille = ".";

    if (preg_match('/\(Lune\)/', $row['planet_name']))
        $moon = 1;
    else
        $moon = 0;
    //	$dateRE = date ( 'd/m/Y H:i:s', $row['dateRE'] ); incompatible avec Speedsim
    $dateRE = date('m-d H:i:s', $row['dateRE']);
    $template = '<table border="0" cellpadding="2" cellspacing="0" align="center">
	<tr>
		<td class="l" colspan="4" class="c">Ressources sur ' . $row['planet_name'] .
        ' [' . $row['coordinates'] . '] (joueur \'' . $rowPN['player'] . '\') le ' . $dateRE .
        '</td>
	</tr>
	<tr>
		<td class="c" style="text-align:right;">M�tal:</td>
		<th>' . number_format($row['metal'], 0, ',', $sep_mille) . '</th>
		<td class="c" style="text-align:right;">Cristal:</td>
		<th>' . number_format($row['cristal'], 0, ',', $sep_mille) . '</th>
	</tr>
	<tr>
		<td class="c" style="text-align:right;">Deut�rium:</td>
		<th>' . number_format($row['deuterium'], 0, ',', $sep_mille) . '</th>
		<td class="c" style="text-align:right;">Energie:</td>
		<th>' . number_format($row['energie'], 0, ',', $sep_mille) . '</th>
	</tr>
	<tr>
		<th colspan="4">';
    if ($row['activite'] > 0)
        $template .= 'Le scanner des sondes a d�tect� des anomalies dans l\'atmosph�re de cette plan�te, indiquant qu\'il y a eu une activit� sur cette plan�te dans les ' .
            $row['activite'] . ' derni�res minutes.';
    else
        $template .= 'Le scanner des sondes n\'a pas d�tect� d\'anomalies atmosph�riques sur cette plan�te. Une activit� sur cette plan�te dans la derni�re heure peut quasiment �tre exclue.';
    $template .= '</th>
	</tr>' . "\n";
    foreach ($flotte as $key => $value) {
        if ($row[$key] != -1) {
            $show['flotte'] = 1;
            continue;
        }
    }
    if ($show['flotte'] == 0) {
        $query = 'SELECT PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, DST, EDLM, SAT, TRA FROM ' .
            TABLE_PARSEDSPY . ' WHERE 
			(PT <> -1 OR GT <> -1 OR CLE <> -1 OR CLO <> -1 OR CR <> -1 OR VB <> -1 OR VC <> -1 OR REC <> -1 OR SE <> -1 OR 
			BMD <> -1 OR DST <> -1 OR EDLM <> -1 OR SAT <> -1 OR TRA <> -1) AND coordinates = "' .
            $row['coordinates'] . '" 
			AND planet_name' . (($moon == 0) ? ' NOT ' : '') .
            ' LIKE "%(Lune)%" ORDER BY dateRE DESC LIMIT 0,1';
        $tmp_res = $db->sql_query($query);
        if ($db->sql_numrows($tmp_res) > 0) {
            $tmp_row = $db->sql_fetch_assoc($tmp_res);
            $row = array_merge($row, $tmp_row);
            $show['flotte'] = 1;
        }
    }
    foreach ($defs as $key => $value) {
        if ($row[$key] != -1) {
            $show['flotte'] = 1;
            $show['defense'] = 1;
            continue;
        }
    }
    if ($show['defense'] == 0) {
        $query = 'SELECT LM, LLE, LLO, CG, AI, LP, PB, GB, MIC, MIP FROM ' .
            TABLE_PARSEDSPY . ' WHERE (LM <> -1 OR LLE <> -1 
			OR LLO <> -1 OR CG <> -1 OR AI <> -1 OR PB <> -1 OR GB <> -1 OR MIC <> -1 OR MIC <> -1) AND coordinates = "' .
            $row['coordinates'] . '" AND planet_name' . (($moon == 0) ? ' NOT ' : '') .
            ' LIKE "%(Lune)%" ORDER BY dateRE DESC LIMIT 0,1';
        $tmp_res = $db->sql_query($query);
        if ($db->sql_numrows($tmp_res) > 0) {
            $tmp_row = $db->sql_fetch_assoc($tmp_res);
            $row = array_merge($row, $tmp_row);
            $show['defense'] = 1;
        }
    }
    foreach ($bats as $key => $value) {
        if ($row[$key] != -1) {
            $show['flotte'] = 1;
            $show['defense'] = 1;
            $show['batiment'] = 1;
            continue;
        }
    }
    if ($show['batiment'] == 0) {
        $query = 'SELECT M, C, D, CES, CEF, UdR, UdN, CSp, HM, HC, HD, Lab, Ter, Silo, DdR, BaLu, Pha, PoSa FROM ' .
            TABLE_PARSEDSPY . ' WHERE (M <> -1 OR C <> -1 OR D <> -1 OR CES <> -1 OR CEF <> -1 OR UdR <> -1 OR UdN <> -1 OR 
			CSp <> -1 OR HM <> -1 OR HC <> -1 OR HD <> -1 OR Lab <> -1 OR Ter <> -1 OR Silo <> -1 OR DdR <> -1 OR BaLu <> -1 
			OR Pha <> -1 OR PoSa <> -1) AND coordinates = "' . $row['coordinates'] .
            '" AND planet_name' . (($moon == 0) ? ' NOT ' : '') .
            ' LIKE "%(Lune)%" ORDER BY dateRE DESC LIMIT 0,1';
        $tmp_res = $db->sql_query($query);
        if ($db->sql_numrows($tmp_res) > 0) {
            $tmp_row = $db->sql_fetch_assoc($tmp_res);
            $row = array_merge($row, $tmp_row);
            $show['batiment'] = 1;
        }
    }
    foreach ($techs as $key => $value) {
        if ($row[$key] != -1) {
            $show['flotte'] = 1;
            $show['defense'] = 1;
            $show['batiment'] = 1;
            $show['recherche'] = 1;
            continue;
        }
    }
    if ($show['recherche'] == 0) {
        $query = 'SELECT Esp, Ordi, Armes, Bouclier, Protection, NRJ, Hyp, RC, RI, PH, Laser, Ions, Plasma, RRI, Graviton, 
			Astrophysique FROM ' . TABLE_PARSEDSPY .
            ' WHERE (Esp <> -1 OR Ordi <> -1 OR Armes <> -1 OR Bouclier <> -1 OR 
			Protection <> -1 OR NRJ <> -1 OR Hyp <> -1 OR RC <> -1 OR RI <> -1 OR PH <> -1 OR Laser <> -1 OR Ions <> -1 OR 
			Plasma <> -1 OR RRI <> -1 OR Graviton <> -1 OR Astrophysique <> -1) AND coordinates = "' .
            $row['coordinates'] . '" 
			AND planet_name' . (($moon == 0) ? ' NOT ' : '') .
            ' LIKE "%(Lune)%" ORDER BY dateRE DESC LIMIT 0,1';
        $tmp_res = $db->sql_query($query);
        if ($db->sql_numrows($tmp_res) > 0) {
            $tmp_row = $db->sql_fetch_assoc($tmp_res);
            $row = array_merge($row, $tmp_row);
            $show['recherche'] = 1;
        }
    }
    if ($show['flotte'] == 1) {
        $template .= '  <tr>
		<td class="l" colspan="4">Flotte</td>
	</tr>
	<tr>' . "\n";
        $count = 0;
        foreach ($flotte as $key => $value) {
            if ($row[$key] > 0) {
                $template .= '    <td class="c" style="text-align:right;">' . $flotte[$key] .
                    '</td>
		<th>' . number_format($row[$key], 0, ',', $sep_mille) . '</th>' . "\n";
                if ($count == 0) {
                    $count = 1;
                } else {
                    $template .= '  </tr>
	<tr>' . "\n";
                    $count = 0;
                }
            }
        }
        if ($count == 1)
            $template .= '    <td class="c" style="text-align:right;">&nbsp;</td>
		<th>&nbsp;</th>' . "\n";
        $template .= '  </tr>' . "\n";
    }
    if ($show['defense'] == 1) {
        $template .= '  <tr>
		<td class="l" colspan="4">D�fense</td>
	</tr>
	<tr>' . "\n";
        $count = 0;
        foreach ($defs as $key => $value) {
            if ($row[$key] > 0) {
                $template .= '    <td class="c" style="text-align:right;">' . $defs[$key] .
                    '</td>
		<th>' . number_format($row[$key], 0, ',', $sep_mille) . '</th>' . "\n";
                if ($count == 0) {
                    $count = 1;
                } else {
                    $template .= '  </tr>
	<tr>' . "\n";
                    $count = 0;
                }
            }
        }
        if ($count == 1)
            $template .= '    <td class="c" style="text-align:right;">&nbsp;</td>
		<th>&nbsp;</th>' . "\n";
        $template .= '  </tr>' . "\n";
    }
    if ($show['batiment'] == 1) {
        $template .= '  <tr>
		<td class="l" colspan="4">B�timents</td>
	</tr>
	<tr>' . "\n";
        $count = 0;
        foreach ($bats as $key => $value) {
            if ($row[$key] > 0) {
                $template .= '    <td class="c" style="text-align:right;">' . $bats[$key] .
                    '</td>
		<th>' . $row[$key] . '</th>' . "\n";
                if ($count == 0) {
                    $count = 1;
                } else {
                    $template .= '  </tr>
	<tr>' . "\n";
                    $count = 0;
                }
            }
        }
        if ($count == 1)
            $template .= '    <td class="c" style="text-align:right;">&nbsp;</td>
		<th>&nbsp;</th>' . "\n";
        $template .= '  </tr>' . "\n";
    }
    if ($show['recherche'] == 1) {
        $template .= '  <tr>
		<td class="l" colspan="4">Recherche</td>
	</tr>
	<tr>' . "\n";
        $count = 0;
        foreach ($techs as $key => $value) {
            if ($row[$key] > 0) {
                $template .= '    <td class="c" style="text-align:right;">' . $techs[$key] .
                    '</td>
		<th>' . $row[$key] . '</th>' . "\n";
                if ($count == 0) {
                    $count = 1;
                } else {
                    $template .= '  </tr>
	<tr>' . "\n";
                    $count = 0;
                }
            }
        }
        if ($count == 1)
            $template .= '    <td class="c" style="text-align:right;">&nbsp;</td>
		<th>&nbsp;</th>' . "\n";
        $template .= '  </tr>' . "\n";
    }
    $template .= '  <tr>
		<th colspan="4">Probabilit� de destruction de la flotte d\'espionnage :' . $row['proba'] .
        '%</th>
	</tr>
</table>';
    return ($template);
}


/**
 * Enregistrement des RE "ancien format" vers le nouveau format
 * @global $db Connexion � la base de donn�es
 * @return boolean true si OK, false si erreur
 * 
 * supprimer bouton correspondant dans admin avant de supp cette fonction
 */
function import_RE()
{
    global $db;

    $rq = 'SELECT sender_id, dateRE, coordinates FROM ' . TABLE_PARSEDSPY;
    $res = $db->sql_query($rq);
    $error = false;
    while (list($sender_id, $dateRE, $coordinates) =
        $db->sql_fetch_row($res)) {
        $rq = 'SELECT id_spy FROM ' . TABLE_PARSEDSPY . ' WHERE coordinates = "' . $coordinates . "' AND dateRE=" . $datadate;
        $res_already_inserted = $db->sql_query($rq);
        $already_inserted = $db->sql_numrows($res_already_inserted);
        if ($already_inserted == 1 || !insert_RE(null, $sender_id))
            $error = true;
    }
    return $error;
}


////////////////////////////////// AFFICHAGE SI MISSILE A PORTEE ////////////////////
function portee_missiles ( $galaxy, $system )
{
  global $user_data,$db;
  $retour = 0;
  $total_missil = 0;
  // recherche niveau missile
  $request = 'SELECT user_id, planet_id, coordinates, Silo FROM ' . TABLE_USER_BUILDING . ' WHERE Silo >= 3';
  $req1 = $db->sql_query ( $request );

  $ok_missil = '';
  while ( list ( $base_joueur, $base_id_planet, $base_coord, $base_missil ) = $db->sql_fetch_row ( $req1 ) )
  {   
    // s�pare les coords
    $missil_coord = explode ( ':', $base_coord );
    $galaxie_missil = $missil_coord[0];
    $sysSol_missil = $missil_coord[1];
    $planet_missil = $missil_coord[2];
    // recherche le niveau du r�acteur du joueur
    $request = 'SELECT RI FROM ' . TABLE_USER_TECHNOLOGY . ' where user_id = ' . $base_joueur;
    $req2 = $db->sql_query ( $request );
    list ( $niv_reac_impuls ) = $db->sql_fetch_row ( $req2 );
    // recherche du nombre de missile dispo
    $request = 'SELECT MIP FROM ' . TABLE_USER_DEFENCE . ' where user_id = ' . $base_joueur . ' AND planet_id = ' . $base_id_planet;
    $req2 = $db->sql_query ( $request );
    list ( $missil_dispo ) = $db->sql_fetch_row ( $req2 );
    if ( ! $missil_dispo )
      $missil_dispo = 'non connu';
    // recherche le nom du joueur
    $req3 = $db->sql_query ( 'SELECT user_name FROM ' . TABLE_USER . ' where user_id = ' . $base_joueur );
    list ( $nom_missil_joueur ) = $db->sql_fetch_row ( $req3 );
    $color_missil_ally1 = '<font color="#00FF00">';
    $color_missil_ally2 = '</font>';
    $tooltip = '<table width="250">';
    $tooltip .= '<tr><td colspan="2" class="c" align="center">MISSILE</td></tr>';
    $tooltip .= '<tr><td class="c" width="70">Nom : </td><th width="30">' . $nom_missil_joueur . '</th></tr>';
    $tooltip .= '<tr><td class="c" width="70">Nb de missiles dispo : </td><th width="30">' . $missil_dispo . '</th></tr>';
    $tooltip .= '</table>';
    $tooltip = htmlentities ( $tooltip );
    // calcule la port� du silo
    $porte_missil = ( $niv_reac_impuls * 5 ) - 1;
    // calcul des �carts
    $vari_missil_moins = $sysSol_missil - $porte_missil;
    $vari_missil_plus = $sysSol_missil + $porte_missil;
    // cr�ation des textes si missil � port�e
    if ( $galaxy == $galaxie_missil && $system >= $vari_missil_moins && $system <= $vari_missil_plus )
    {
      if ( $retour == 11 )
      {
        $ret = '<br>';
        $retour = 0;
      }
      else
      {
        $ret = '&nbsp;-&nbsp;';
        $retour++;
      }
      $door = '<a href="?action=galaxy&galaxy=' . $galaxie_missil . '&system=' . $sysSol_missil . 
        '" onmouseover="this.T_WIDTH=260;this.T_TEMP=15000;return escape(\'' . $tooltip . '\')">';
      $ok_missil .= $door . $color_missil_ally1 . $base_coord . $color_missil_ally2 . '</a> - ';
      $total_missil += $missil_dispo;
    }
  }
  if ( $ok_missil )
    $missil_ok = '<font color="#FFFF66"> � port� du (des) Silo de missiles suivant(s) : ' . $ok_missil . '</font><br><font color="#DBBADC">Total : ' . $total_missil . ' MIP Dispo</font>';
  else
    $missil_ok = '<font color="#FFFF66"> � port� d\'aucun silo de missiles connu</font>';
  return $missil_ok;
}
?>