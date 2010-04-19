<?php
/** $Id$ **/
/**
 * Fichier principal d'ogspy : index.php appellé lors de tout accés
 * @package OGSpy 
 * @subpackage main 
 * @author Kyser 
 * @copyright Copyright &copy; 2007, http://ogsteam.fr/ 
 * @version 4.00 ($Rev$) 
 * @modified $Date$ 
 * @link $HeadURL$ 
 */

/**
 * @abstract Utilisé dans les autres fichiers pour s'assurer qu'index.php est bien appelé
 */
define("IN_SPYOGAME", true);


/**
 * Tout les includes se font à partir de là
 */
require_once ("common.php");


/**
 * Repère de début de traitement par OGSpy
 * @name $php_start
 */
$php_start = benchmark();
$sql_timing = 0;

/**
 * @global string $pub_action
 */
if (!isset($pub_action)) {
	$pub_action = "";
}

if (strstr($_SERVER['HTTP_USER_AGENT'], "OGSClient") === false) {
	if (MODE_DEBUG) {
		require_once (translated("views/debug.php"));
		//show_viewsfile("debug");
	}

	if (is_dir("install") && $pub_action != "message") {
		if (isset($modules_link_to_install)) {
			// Le dossier install existe, on est pas sur un message d'erreur, et il existe la variable créée à l'installation qui donne les modules à installer...
			// Définition que les scripts d'installation ont besoin
			define('OGSPY_INSTALLED', true);
			// Stockage des modules déjà installé (pour ne pas faire l'install d'un module déjà présent)
			$db->sql_query('SELECT root, version FROM ' . TABLE_MOD);
			$installed = array();
			while (list($root, $version) = $db->sql_fetch_row())
				$installed[$root] = $version;
			// Pour tous les modules demandé mais pas installé
			foreach ($modules_link_to_install as $root => $link) {
				$already_installed = array_key_exists($root, $installed);
				// Si le module est installé et qu'il existe un fichier de version
				if (file_exists($f = "mod/{$root}/version.txt") && $already_installed) {
					$tmp = file($f);
					// on vérifie que le module est a jour
					$up_to_date = version_compare($tmp[1], $installed[$root], '<=');
					// Sinon, on le considère à jour
				} else
					$up_to_date = true;
				// Si le module n'est pas installé, ou qu'il l'est, mais pas à jour et qu'en plus, le fichier ciblé existe
				if (!isset($installed) || file_exists($link) && (!$already_installed || !$up_to_date)) {
					// Appel de la procédure d'installation du module
					require_once ($link);
					if ($up_to_date) {
						// Mise à jour de la position du nouveau module (à la fin, fatalement)
						list($position) = $db->sql_fetch_row($db->sql_query("select max(position) from " .
							TABLE_MOD));
						$db->sql_query("update " . TABLE_MOD . " set position = " . ($position + 1) .
							" where root = '{$root}'");
					} elseif (isset($tmp[1])) {
						// Mise à jour du numéro de version du module (on force, pour être certain que l'exécution du lien ne se fera qu'une seule fois), par exemple si l'update.php du script ne s'en occupe pas)
						$db->sql_query("update " . TABLE_MOD . " set version = " . ($tmp[1]) .
							" where root = '{$root}'");
					}
				}
			}
			// Retour à l'installation
			redirection("install/index.php");
		}
		require_once ("install/version.php");
		if (isset($user_data) && $user_data['user_admin'] == 1) {
			if (($a = version_compare($server_config["version"], $install_version, '<')))
				redirection("install/index.php");
			else
				if (!MODE_DEBUG)
					redirection("?action=message&id_message=install_directory&info");
		} else
			if (!MODE_DEBUG)
				redirection("?action=message&id_message=install_inprogress&info");

	}
	if ($server_config["server_active"] == 0 && $pub_action != "login_web" && $pub_action !=
		"logout" && $user_data['user_admin'] != 1 && $user_data['user_coadmin'] != 1) {
		$pub_action = "server_close";
	}

	//	Visiteur non identifié
	if (!isset($user_data["user_id"]) && !(isset($pub_action) && $pub_action ==
		"login_web")) {
		if ($pub_action == "message") {
			//require("views/message.php");
			require (translated("views/message.php"));
		} else {
			if (preg_match("#^action=(.*)#", $_SERVER['QUERY_STRING'], $matches)) {
				$goto = $matches[1];
			}
			//require_once("views/login.php");
			if (isset($pub_ajax))
				die("delog");
			else
				require_once (translated("views/login.php"));
		}
		exit();
	}

	if ($pub_action <> '') {
		$query = "SELECT id, root, link FROM " . TABLE_MOD .
			" WHERE active = '1' AND action = '" . mysql_real_escape_string($pub_action) .
			"'";
		$result = $db->sql_query($query);
		if ($db->sql_numrows($result) && ratio_is_ok()) {
			$val = $db->sql_fetch_assoc($result);
			if ((in_array($val['id'], $user_auth['mod_restrict']))) {
				redirection("?action=message&id_message=forbidden&info");
			} else {
				require_once ("mod/" . $val['root'] . "/" . $val['link']);
				exit();
			}
		}
	}

	switch ($pub_action) {
			//----------------------------------------//
			//--------Connexion---------//
			//----------------------------------------//
			//Identification
		case "login_web":
			user_login();
			break;

			//Déconnexion
		case "logout":
			user_logout();
			break;

			//----------------------------------------//
			//---Administration---//
			//----------------------------------------//
		case "administration":
			//require_once("views/admin.php");
			require_once (translated("views/admin.php"));
			break;

		case "set_server_view":
			set_server_view();
			break;

		case "set_serverconfig":
			set_serverconfig();
			break;


		case "log_extractor":
			if ($download = get_log_files($pub_showlog, $pub_logtype)) {
				echo log_extractor($download, date($pub_logtype == 'select_day' ? 'ymd' : 'y-m',
					$pub_showlog));
				exit;
			}
			break;

		case "log_erase":
			if ($delete = get_log_files($pub_showlog, $pub_logtype))
				foreach ($delete as $d)
					unlink($d);
			redirection("?action=message&id_message=log_remove&info=");
			break;

		case "db_optimize":
			db_optimize();
			break;

		case "drop_sessions":
			$db->sql_query("TRUNCATE TABLE " . TABLE_SESSIONS);
			redirection();
			break;

		case "raz_ratio":
			admin_raz_ratio();
			break;

			//----------------------------------------//
			//---Gestion des membres---//
			//----------------------------------------//
		case "home":
			//require_once("views/home.php");
			require_once (translated("views/home.php"));
			break;

		case "graphic_curve":
			//require_once("views/graphic_curve.php");
			require_once ("views/graphic_curve.php");
			break;

		case "graphic_pie":
			//require_once("views/graphic_pie.php");
			require_once ("views/graphic_pie.php");
			break;

		case "set_empire":
			user_set_empire();
			break;

		case "del_planet":
			user_del_building();
			break;

		case "move_planet":
			user_move_empire();
			break;

		case "profile":
			//require_once("views/profile.php");
			require_once (translated("views/profile.php"));
			break;

		case "newaccount":
			user_create();
			break;

		case "message":
			//require("views/message.php");
			require_once (translated("views/message.php"));
			break;

		case "member_modify_member":
			member_user_set();
			break;

		case "delete_member":
			user_delete();
			break;

		case "new_password":
			admin_regeneratepwd();
			break;

		case "usergroup_create":
			usergroup_create();
			break;

		case 'usergroup_get':
			usergroup_get_data();
			break;

		case 'usergroup_rename':
			echo usergroup_rename();
			break;

		case "usergroup_delete":
			echo usergroup_delete();
			break;

		case "usergroup_setauth":
			echo usergroup_setauth();
			break;

		case "usergroup_delmember":
			echo usergroup_delmember();
			break;

		case "usergroup_newmember":
			echo usergroup_newmember();
			break;

		case "usergroup_delmod":
			echo usergroup_delmod();
			break;

		case "usergroup_newmod":
			echo usergroup_newmod();
			break;

			//----------------------------------------//
			//--- ---//
			//----------------------------------------//
		case "galaxy":
			//require_once("views/galaxy.php");
			require_once (translated("views/galaxy.php"));
			break;

		case "galaxy_sector":
			//require_once("views/galaxy_sector.php");
			require_once (translated("views/galaxy_sector.php"));
			break;

			//Chargement galaxie
		case "get_data":
			galaxy_getsource();
			break;

			//
		case "show_reportspy":
			//require_once("views/report_spy.php");
			require_once (translated("views/report_spy.php"));
			break;

			//
		case "show_reportrc":
			//require_once("views/report_rc.php");
			require_once (translated("views/report_rc.php"));
			break;

			//
		case "del_rc":
			user_del_rc();
			break;

			//
		case "add_favorite":
			user_add_favorite();
			break;

			//
		case "del_favorite":
			user_del_favorite();
			break;

			//
		case "search":
			//require_once("views/search.php");
			require_once (translated("views/search.php"));
			break;

			//
		case "cartography":
			//require_once("views/cartography.php");
			require_once (translated("views/cartography.php"));
			break;

			//
		case "mp":
			require_once (translated("views/mp.php"));
			break;

			//
		case "statistic":
			//require_once("views/statistic.php");
			require_once (translated("views/statistic.php"));
			break;

			//
		case "ranking":
			//require_once("views/ranking.php");
			require_once (translated("views/ranking.php"));
			break;

			//
		case "drop_ranking":
			galaxy_drop_ranking();
			break;

			//
		case "about":
			//require_once("views/about.php");
			require_once (translated("views/about.php"));
			break;

			//
		case "add_favorite_spy":
			user_add_favorite_spy();
			break;

			//
		case "del_favorite_spy":
			user_del_favorite_spy();
			break;

			//
		case "del_spy":
			user_del_spy();
			break;

			//
		case "import_RE":
			import_RE();
			redirection("?action=galaxy");
			break;


			//----------------------------------------//
			//--- ---//
			//----------------------------------------//
		case "server_close":
			//require_once("views/serverdown.php");
			require_once (translated("views/serverdown.php"));
			break;

		default:
			if ($server_config['open_user'] != "" && $user_data['user_admin'] != 1 && $user_data['user_coadmin'] !=
				1) {
				if (file_exists($server_config['open_user']))
					require_once (translated($server_config['open_user']));
				else
					require_once (translated("views/galaxy.php")); //require_once("views/galaxy.php");
			} elseif ($server_config['open_admin'] != "" && ($user_data['user_admin'] == 1 ||
			$user_data['user_coadmin'] == 1)) {
				if (file_exists($server_config['open_admin']))
					require_once (translated($server_config['open_admin']));
				else
					require_once (translated("views/galaxy.php")); //require_once("views/galaxy.php");
			} else
				require_once (translated("views/galaxy.php")); //require_once("views/galaxy.php");
			break;
	}
}
/**
 * Réponse à OGS 
 */  else {

	header("Content-Type: application/octet-stream");
	if ($server_config["server_active"] == 0) {
		die("<!-- [Login=0] Server desactived -->" . "\n");
	}

	//Visiteur non identifié
	if ((!isset($user_data["user_id"]) && !(isset($pub_action) && $pub_action ==
		"login"))) {
		die("<!-- [Login=0] Accès refusé  -->");
	}


	switch ($pub_action) {


		case "login":
			/// inclure le login obligatoire dans ogspy 
			user_ogs_login();
			break;

			///ogs protocole pour ofi
		case "ofi":
		$retour=verif_petitpotam();
		if ($retour = true) { include_once ("mod/petitpotam/ofi.php"); }
		else { die("<!-- Mod petit potam non installe -->"); }
			break;

			///ogs protocole pour petit potam
		case "petitpotam":
		$retour=verif_petitpotam();
		if ($retour = true) { include_once ("mod/petitpotam/petitpotam.php"); }
		else { die("<!-- Mod petit potam non installe -->"); }
			break;
		  


		default:
			die("<!-- Requête inconnu (" . $pub_action . ") -->");


	}
}
?>
