<?php
/***************************************************************************
*	filename	: index.php
*	desc.		:
*	Author		: Kyser - http://ogs.servebbs.net/
*	created		: 15/11/2005
*	modified	: 22/08/2006 00:00:00
***************************************************************************/

define("IN_SPYOGAME", true);

require_once("common.php");

$php_start = benchmark();
$sql_timing = 0;

if (!isset($pub_action)) {
	$pub_action = "";
}

if (strstr($_SERVER['HTTP_USER_AGENT'], "OGSClient") === false) {
	if (MODE_DEBUG) {
		require_once("views/debug.php");
	}

	if (is_dir("install") && $pub_action != "message") {
		redirection("index.php?action=message&id_message=install_directory&info");
	}
	if ($server_config["server_active"] == 0 && $pub_action != "login_web" && $pub_action != "logout" && $user_data['user_admin'] != 1) {
		$pub_action = "server_close";
	}

	//	Visiteur non identifi�
	if (!isset($user_data["user_id"]) && !(isset($pub_action) && $pub_action == "login_web")) {
		if ($pub_action == "message") {
			require("views/message.php");
		}
		elseif (!isset($pub_ajax)) {
			if (preg_match("#^action=(.*)#", $_SERVER['QUERY_STRING'], $matches)) {
				$goto = $matches[1];
			}
			require_once("views/login.php");
		} else {
			echo 'delog';
		}
		exit();
	}
	
	if ($pub_action <> '') {
        $query = "SELECT root, link FROM ".TABLE_MOD." WHERE active = '1' AND action = '".$pub_action."'";
        $result = $db->sql_query($query);
        if ($db->sql_numrows($result)) {
            $val = $db->sql_fetch_assoc($result);
            require_once("mod/".$val['root']."/".$val['link']);
            exit();
        }
    }

	switch ($pub_action) {
		//----------------------------------------//
		//--------Connexion---------//
		//----------------------------------------//
		//Identification
		case "login_web" :
		user_login();
		break;

		//D�connexion
		case "logout" :
		user_logout();
		break;

		//----------------------------------------//
		//---Administration---//
		//----------------------------------------//
		case "administration" :
		require_once("views/admin.php");
		break;

		case "set_serverconfig" :
		set_serverconfig();
		break;

		case "extractor" :
		log_extractor();
		break;

		case "db_optimize" :
		db_optimize();
		break;

		//----------------------------------------//
		//---Gestion des membres---//
		//----------------------------------------//
		case "home" :
		require_once("views/home.php");
		break;

		case "graphic_curve" :
		require_once("views/graphic_curve.php");
		break;

		case "graphic_pie" :
		require_once("views/graphic_pie.php");
		break;

		case "set_empire" :
		user_set_empire();
		break;

		case "del_planet" :
		user_del_building();
		break;

		case "move_planet" :
		user_move_empire();
		break;

		case "profile" :
		require_once("views/profile.php");
		break;

		case "newaccount" :
		user_create();
		break;

		case "message" :
		require("views/message.php");
		break;

		case "admin_modify_member" :
		admin_user_set();
		break;

		case "member_modify_member" :
		member_user_set();
		break;

		case "delete_member" :
		user_delete();
		break;

		case "new_password" :
		admin_regeneratepwd();
		break;

		// [AJAX]
		case "usergroup_create" :
		echo usergroup_create();
		break;
		
		case 'usergroup_get' :
		echo usergroup_member($pub_group_id);
		echo "\n=\n";
		echo usergroup_get($pub_group_id);
		break;
		
		case 'usergroup_rename':
		echo usergroup_rename();
		break;
		
		case 'usergroup_delete':
		echo usergroup_delete();
		break;
		
		case "usergroup_setauth" :
		echo usergroup_setauth();
		break;

		case "usergroup_delmember" :
		echo usergroup_delmember();
		break;
	
		case "usergroup_newmember" :
		echo usergroup_newmember();
		break;



		//----------------------------------------//
		//--- ---//
		//----------------------------------------//
		case "galaxy" :
		require_once("views/galaxy.php");
		break;

		case "galaxy_sector" :
		require_once("views/galaxy_sector.php");
		break;

		//Chargement galaxie
		case "get_data" :
		galaxy_getsource();
		break;

		//
		case "show_reportspy" :
		require_once("views/report_spy.php");
		break;

		//
		case "add_favorite" :
		user_add_favorite();
		break;

		//
		case "del_favorite" :
		user_del_favorite();
		break;

		//
		case "search" :
		require_once("views/search.php");
		break;

		//
		case "cartography" :
		require_once("views/cartography.php");
		break;

		//
		case "statistic" :
		require_once("views/statistic.php");
		break;

		//
		case "ranking" :
		require_once("views/ranking.php");
		break;

		//
		case "drop_ranking" :
		galaxy_drop_ranking();
		break;

		//
		case "about" :
		require_once("views/about.php");
		break;

		//
		case "galaxy_obsolete" :
		require_once("views/galaxy_obsolete.php");
		break;

		//
		case "add_favorite_spy" :
		user_add_favorite_spy();
		break;

		//
		case "del_favorite_spy" :
		user_del_favorite_spy();
		break;



		//----------------------------------------//
		//--- ---//
		//----------------------------------------//
		case "mod_disable" :
		mod_disable();
		break;
		
		//
		case "mod_uninstall" :
		mod_uninstall();
		break;
		
		//
		case "mod_active" :
		mod_active();
		break;
		
		//
		case "mod_install" :
		mod_install();
		break;
		
		//
		case "mod_update" :
		mod_update();
		break;

		
		//
		case "mod_up" :
		mod_sort("up");
		break;

		
		//
		case "mod_down" :
		mod_sort("down");
		break;


		//----------------------------------------//
		//--- ---//
		//----------------------------------------//
		case "server_close":
		require_once("views/serverdown.php");
		break;

		default:
		require_once("views/galaxy.php");
		break;
	}
}
else {
	header("Content-Type: application/octet-stream");
	if ($server_config["server_active"] == 0) {
		die("<!-- [Login=0] Server desactived -->"."\n");
	}

	//Visiteur non identifi�
	if ((!isset($user_data["user_id"]) && !(isset($pub_action) && $pub_action == "login"))) {
		die ("<!-- [Login=0] Acc�s refus�  -->");
	}

	switch ($pub_action) {

		//
		case "login" :
		user_ogs_login();
		break;

		//
		case "postplanets" :
		galaxy_ImportPlanets();
		break;

		//
		case "fbimport" :
		galaxy_ExportPlanets();
		break;

		//
		case "postrankpoints_player":
		galaxy_ImportRanking_player("points");
		break;

		//
		case "postrankflotte_player":
		galaxy_ImportRanking_player("flotte");
		break;

		//
		case "postrankresearch_player":
		galaxy_ImportRanking_player("research");
		break;

		//
		case "getstats_player":
		galaxy_ExportRanking_player();
		break;

		//
		case "getstatsinfo_player":
		galaxy_ShowAvailableRanking("player");
		break;

		//
		case "postrankpoints_ally":
		galaxy_ImportRanking_ally("points");
		break;

		//
		case "postrankflotte_ally":
		galaxy_ImportRanking_ally("flotte");
		break;

		//
		case "postrankresearch_ally":
		galaxy_ImportRanking_ally("research");
		break;

		//
		case "getstats_ally":
		galaxy_ExportRanking_ally();
		break;

		//
		case "getstatsinfo_ally":
		galaxy_ShowAvailableRanking("ally");
		break;

		//
		case "postspyingreports" :
		galaxy_ImportSpy();
		break;

		//
		case "reportsforsystem" :
		galaxy_ExportSpy();
		break;

		//
		case "spyreport" :
		galaxy_ExportSpy_since();
		break;

		default:
		die("<!-- Requ�te inconnu (".$pub_action.") -->");
	}
}
?>