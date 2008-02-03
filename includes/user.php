<?php
/** $Id$ **/
/**
* user.php Fonctions concernant les utilisateurs
* @author Kyser
* @package OGSpy
* @subpackage user
* @copyright Copyright &copy; 2007, http://www.ogsteam.fr/
* @modified $Date$
* @author Kyser
* @link $HeadURL$
* @version 3.04b ( $Rev$ ) 
 */

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}

/**
* Verification des droits utilisateurs sur une action avec redirection le cas échéant
* @param string $action Action verifié
* @param int $user_id identificateur optionnel de l'utilisateur testé
*/
function user_check_auth($action, $user_id = null) {
	global $user_data, $user_auth;

	switch ($action) {
		case "user_create":
		case "usergroup_manage":
		if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_user"] != 1)
		redirection("index.php?action=message&id_message=forbidden&info");

		break;

		case "user_update" :
		if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_user"] != 1)
		redirection("index.php?action=message&id_message=forbidden&info");

		$info_user = user_get($user_id);
		if ($info_user === false)
		redirection("index.php?action=message&id_message=deleteuser_failed&info");

		if (($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_user"] != 1) ||
		($info_user[0]["user_admin"] == 1) ||
		(($user_data["user_coadmin"] == 1) && ($info_user[0]["user_coadmin"] == 1)) ||
		(($user_data["user_coadmin"] != 1 && $user_data["management_user"] == 1) && ($info_user[0]["user_coadmin"] == 1 || $info_user[0]["management_user"] == 1))) {
			redirection("index.php?action=message&id_message=forbidden&info");
		}

		break;


		default:
		redirection("index.php?action=message&id_message=errorfatal&info");
	}
}
/**
 * Login d'un utilisateur
 * @global string $pub_login
 * @global string $pub_password
 * @global string $pub_goto
 */
function user_login() {
	global $db;
	global $pub_login, $pub_password, $pub_goto;

	if (!check_var($pub_login, "Pseudo_Groupname") || !check_var($pub_password, "Password") || !check_var($pub_goto, "Special", "#^[\w=&%+]+$#")) {
		redirection("index.php?action=message&id_message=errordata&info");
	}

	if (!isset($pub_login) || !isset($pub_password)) {
		redirection("index.php?action=message&id_message=errorfatal&info");
	}
	else {
		$request = "select user_id, user_active from ".TABLE_USER." where user_name = '".mysql_real_escape_string($pub_login)."' and user_password = '".md5(sha1($pub_password))."'";
		$result = $db->sql_query($request);
		if (list($user_id, $user_active) = $db->sql_fetch_row($result)) {
			if ($user_active == 1) {
				$request = "select user_lastvisit from ".TABLE_USER." where user_id = ".$user_id;
				$result = $db->sql_query($request);
				list($lastvisit) = $db->sql_fetch_row($result);

				$request = "update ".TABLE_USER." set user_lastvisit = ".time()." where user_id = ".$user_id;
				$db->sql_query($request);

				/*//Incompatible MySQL 4.0
				$request = "insert into ".TABLE_STATISTIC." values ('connection_server', '1')";
				$request .= " on duplicate key update statistic_value = statistic_value + 1";*/
				$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + 1";
				$request .= " where statistic_name = 'connection_server'";
				$db->sql_query($request);
				if ($db->sql_affectedrows() == 0) {
					$request = "insert ignore into ".TABLE_STATISTIC." values ('connection_server', '1')";
					$db->sql_query($request);
				}

				session_set_user_id($user_id, $lastvisit);
				log_('login');
				redirection("index.php?action=".$pub_goto);
			}
			else {
				redirection("index.php?action=message&id_message=account_lock&info");
			}
		}
		else  {
			redirection("index.php?action=message&id_message=login_wrong&info");
		}
	}
}
/**
 * Login d'un utilisateur OGS
 */
function user_ogs_login() {
	global $db, $user_data, $user_auth, $server_config;
	global $pub_name, $pub_pass, $pub_ogsversion;

	if (!check_var($pub_name, "Pseudo_Groupname") || !check_var($pub_pass, "Password") || !check_var($pub_ogsversion, "Num")) {
		die ("<!-- [ErrorFatal=19] Données transmises incorrectes  -->");
	}

	//Refus des version OGS antérieure à 060601
	if (strcasecmp($pub_ogsversion, "060601") < 0) {
		die ("<!-- [Login=0] La version d'Ogame Stratege utilisé n'est pas compatible avec ce serveur  -->");
	}

	if (isset($pub_name, $pub_pass)) {
		$request = "select user_id, user_active from ".TABLE_USER." where user_name = '".mysql_real_escape_string($pub_name)."' and user_password = '".md5(sha1($pub_pass))."'";
		$result = $db->sql_query($request);
		if (list($user_id, $user_active) = $db->sql_fetch_row($result)) {
			session_set_user_id($user_id);

			if ($user_auth["ogs_connection"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
				die ("<!-- [Login=0] [AccessDenied] Accès refusé  -->");
			}

			if ($user_active == 1) {
				$request = "update ".TABLE_USER." set user_lastvisit = ".time()." where user_id = ".$user_id;
				$db->sql_query($request);

				/*//Incompatible MySQL 4.0
				$request = "insert into ".TABLE_STATISTIC." values ('connection_ogs', '1')";
				$request .= " on duplicate key update statistic_value = statistic_value + 1";
				$db->sql_query($request);*/
				$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + 1";
				$request .= " where statistic_name = 'connection_ogs'";
				$db->sql_query($request);
				if ($db->sql_affectedrows() == 0) {
					$request = "insert ignore into ".TABLE_STATISTIC." values ('connection_ogs', '1')";
					$db->sql_query($request);
				}

				log_('login_ogs');
				echo "<!-- [Login=1] OGame Stratege SharingDB -->"."\n";
				echo "<!-- Servername = OGSPY -->"."\n";
				echo "<!-- ServerVersion = ".$server_config["version"]." -->"."\n";
				echo "<!-- ServerInfo = By Kyser , http://www.ogsteam.fr -->"."\n\n";

				if ($user_auth["ogs_set_system"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) echo "<!-- [ExportSysAuth=1] You are authorised to export Solar System -->"."\n";
				else echo "<!-- [ExportSysAuth=0] You are not authorised to export Solar System -->"."\n";
				if ($user_auth["ogs_get_system"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) echo "<!-- [ImportSysAuth=1] You are authorised to import Solar System -->"."\n";
				else echo "<!-- [ImportSysAuth=0] You are not authorised to import Solar System -->"."\n";
				echo "\n";

				if ($user_auth["ogs_set_spy"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) echo "<!-- [ExportSpyAuth=1] You are authorised to export Spy Reports -->"."\n";
				else echo "<!-- [ExportSpyAuth=0] You are not authorised to export Spy Reports -->"."\n";
				if ($user_auth["ogs_get_spy"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) echo "<!-- [ImportSpyAuth=1] You are authorised to import Spy Reports -->"."\n";
				else echo "<!-- [ImportSpyAuth=0] You are not authorised to import Spy Reports -->"."\n";
				echo "\n";

				if ($user_auth["ogs_set_ranking"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) echo "<!-- [ExportRankAuth=1] You are authorised to export Ranking -->"."\n";
				else echo "<!-- [ExportRankAuth=0] You are not authorised to export Ranking -->"."\n";
				if ($user_auth["ogs_get_ranking"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) echo "<!-- [ImportRankAuth=1] You are authorised to import Ranking -->"."\n";
				else echo "<!-- [ImportRankAuth=0] You are not authorised to import Ranking -->"."\n";

				exit();
			}
		}
	}
	die ("<!-- [ErrorFatal=20] Données transmises incorrectes  -->");
}
/**
 * Déconnection utilisateur
 */
function user_logout() {
	log_("logout");
	session_close();
	redirection("index.php");
}
/**
 * Vérification de la validité de inputs utilisateurs
 * @param string $type Type de variable testé (pseudo,groupname,password,galaxy,system)
 * @param string $string La chaine testé
 * @return false|string 
 */
function string_check($type, $string) {
	if ($type == "pseudo" || $type == "groupname") {
		$length_min = 3;
		$length_max = 15;
	}
	elseif ($type = "password") {
		$length_min = 6;
		$length_max = 15;
	}
	elseif ($type = "galaxy") {
		$length_min = 1;
		$length_max = 999;
	}
	elseif ($type = "system" || $type = "systems") {
		$length_min = 1;
		$length_max = 999;
	}
	
	$string = trim($string);
	if (strlen($string) < $length_min || strlen($string) > $length_max) {
		return false;
	}

	return $string;
}

/**
 * Modification des droits ogspy d'un utilisateur par l'admin
 */
function admin_user_set() {
	global $user_data;
	global $pub_user_id, $pub_active, $pub_user_coadmin, $pub_management_user, $pub_management_ranking;

	if (!check_var($pub_user_id, "Num") || !check_var($pub_active, "Num") || !check_var($pub_user_coadmin, "Num") || !check_var($pub_management_user, "Num") || !check_var($pub_management_ranking, "Num")) {
		redirection("index.php?action=message&id_message=errordata&info");
	}

	if (!isset($pub_user_id) || !isset($pub_active)) {
		redirection("index.php?action=message&id_message=admin_modifyuser_failed&info");
	}

	//Vérification des droits
	user_check_auth("user_update", $pub_user_id);

	if ($user_data["user_admin"] == 1) {
		if (!isset($pub_user_coadmin) || !isset($pub_management_user) || !isset($pub_management_ranking)) {
			redirection("index.php?action=message&id_message=admin_modifyuser_failed&info");
		}
	}
	elseif ($user_data["user_coadmin"] == 1) {
		$pub_user_coadmin = null;
		if (!isset($pub_management_user) || !isset($pub_management_ranking)) {
			redirection("index.php?action=message&id_message=admin_modifyuser_failed&info");
		}
	}
	else {
		$pub_user_coadmin = $pub_management_user = null;
	}
	if (user_get($pub_user_id) === false) {
		redirection("index.php?action=message&id_message=admin_modifyuser_failed&info");
	}
	user_set_grant($pub_user_id, null, $pub_active, $pub_user_coadmin, $pub_management_user, $pub_management_ranking);
	redirection("index.php?action=administration&subaction=member");
}

/**
 * Génération d'un mot de passe par l'admin pour un utilisateur
 */
function admin_regeneratepwd() {
	global $user_data;
	global $pub_user_id;// $pub_new_pass;
  $pass_id = "pub_pass_" . $pub_user_id;
  global $$pass_id;
  $new_pass = $$pass_id;

	if (!check_var($pub_user_id, "Num")) {
		redirection("index.php?action=message&id_message=errordata&info");
	}

	if (!isset($pub_user_id)) {
		redirection("index.php?action=message&id_message=errorfatal&info");
	}

	user_check_auth("user_update", $pub_user_id);

	if (user_get($pub_user_id) === false) {
		redirection("index.php?action=message&id_message=regeneratepwd_failed&info");
	}
  if ($new_pass != ""){
	$password = $new_pass;
  }else{
    $password = password_generator();
  }
	user_set_general($pub_user_id, null, $password);

	$info = $pub_user_id . ":" . $password;
	log_("regeneratepwd", $pub_user_id);
	redirection("index.php?action=message&id_message=regeneratepwd_success&info=".$info);
}

/**
 * Modification du profil par un utilisateur
 */
function member_user_set() {
	global $db, $user_data;
	global $pub_pseudo, $pub_old_password, $pub_new_password, $pub_new_password2, $pub_galaxy, $pub_system, $pub_skin, $pub_disable_ip_check;

	if (!check_var($pub_pseudo, "Text") || !check_var($pub_old_password, "Text") || !check_var($pub_new_password, "Text") || !check_var($pub_new_password2, "CharNum") || !check_var($pub_galaxy, "Num") || !check_var($pub_system, "Num") || !check_var($pub_skin, "URL") || !check_var($pub_disable_ip_check, "Num")) {
		redirection("index.php?action=message&id_message=errordata&info");
	}

	$user_id = $user_data["user_id"];
	$user_info = user_get($user_id);

	$password_validated = null;
	if (!isset($pub_pseudo) || !isset($pub_old_password) || !isset($pub_new_password) || !isset($pub_new_password2) || !isset($pub_galaxy) || !isset($pub_system) || !isset($pub_skin)) {
		redirection("index.php?action=message&id_message=member_modifyuser_failed&info");
	}

	if ($pub_old_password != "" || $pub_new_password != "" || $pub_new_password2 != "") {
		if ($pub_old_password == "" || $pub_new_password == "" || $pub_new_password != $pub_new_password2) {
			redirection("index.php?action=message&id_message=member_modifyuser_failed_passwordcheck&info");
		}
		if (md5(sha1($pub_old_password)) != $user_info[0]["user_password"]) {
			redirection("index.php?action=message&id_message=member_modifyuser_failed_passwordcheck&info");
		}
		if (!check_var($pub_new_password, "Password")) {
			redirection("index.php?action=message&id_message=member_modifyuser_failed_password&info");
		}
	}

	if (!check_var($pub_pseudo, "Pseudo_Groupname")) {
		redirection("index.php?action=message&id_message=member_modifyuser_failed_pseudo&info");
	}

	//Contrôle que le pseudo ne soit pas déjà utilisé
	$request = "select * from ".TABLE_USER." where user_name = '".mysql_real_escape_string($pub_pseudo)."' and user_id <> ".$user_id;
	$result = $db->sql_query($request);
	if ($db->sql_numrows($result) != 0) {
		redirection("index.php?action=message&id_message=member_modifyuser_failed_pseudolocked&info");
	}

	if (is_null($pub_disable_ip_check) || $pub_disable_ip_check != 1) $pub_disable_ip_check = 0;

	user_set_general($user_id, $pub_pseudo, $pub_new_password, null, $pub_galaxy, $pub_system, $pub_skin, $pub_disable_ip_check);
	redirection("index.php?action=profile");
}

/**
* Entrée en BD de données utilisateurs
*/
function user_set_general($user_id, $user_name = null, $user_password = null, $user_lastvisit = null, $user_galaxy = null, $user_system = null, $user_skin = null, $disable_ip_check = null) {
	global $db, $user_data, $server_config;

	if (!isset($user_id)) {
		redirection("index.php?action=message&id_message=errorfatal&info");
	}

	if (!empty($user_galaxy)) {
		$user_galaxy = intval($user_galaxy);
		if ($user_galaxy < 1 || $user_galaxy > intval($server_config['num_of_galaxies'])) $user_galaxy = 1;
	}
	if (!empty($user_system)) {
		$user_system = intval($user_system);
		if ($user_system < 1 || $user_system > intval($server_config['num_of_systems'])) $user_system = 1;
	}

	$update = "";

	//Pseudo et mot de passe
	if (!empty($user_name))
	$update .= "user_name = '".mysql_real_escape_string($user_name)."'";
	if (!empty($user_password))
	$update .= ((strlen($update)>0) ? ", " : "")."user_password = '".md5(sha1($user_password))."'";

	//Galaxy et système solaire du membre
	if (!empty($user_galaxy))
	$update .= ((strlen($update)>0) ? ", " : "")."user_galaxy = '".$user_galaxy."'";
	if (!empty($user_system))
	$update .= ((strlen($update)>0) ? ", " : "")."user_system = '".$user_system."'";

	//Dernière visite
	if (!empty($user_lastvisit))
	$update .= ((strlen($update)>0) ? ", " : "")."user_lastvisit = '".$user_lastvisit."'";

	//Skin
	if (!is_null($user_skin)) {
		if (strlen($user_skin) > 0 && substr($user_skin, strlen($user_skin)-1) != "/") $user_skin .= "/";
		$update .= ((strlen($update)>0) ? ", " : "")."user_skin = '".mysql_real_escape_string($user_skin)."'";
	}

	//Désactivation de la vérification de l'adresse ip
	if (!is_null($disable_ip_check))
	$update .= ((strlen($update)>0) ? ", " : "")."disable_ip_check = '".$disable_ip_check."'";


	$request = "update ".TABLE_USER." set ".$update." where user_id = ".$user_id;
	$db->sql_query($request);

	if ($user_id == $user_data['user_id']) {
		log_("modify_account");
	}
	else {
		log_("modify_account_admin", $user_id);
	}
}

/**
* Enregistrement des droits et status utilisateurs
*/
function user_set_grant($user_id, $user_admin = null, $user_active = null,
$user_coadmin = null, $management_user = null, $management_ranking = null) {
	global $db, $user_data;

	if (!isset($user_id)) {
		redirection("index.php?action=message&id_message=errorfatal&info");
	}

	//Vérification des droits
	user_check_auth("user_update", $user_id);

	$update = "";

	//Activation membre
	if (!is_null($user_active)) {
		$update .= ((strlen($update)>0) ? ", " : "")."user_active = '".intval($user_active)."'";
		if (intval($user_active) == 0) {
			$request = "delete from ".TABLE_SESSIONS." where session_user_id = ".$user_id;
			$db->sql_query($request);
		}
	}

	//Co-administration
	if (!is_null($user_coadmin)) {
		$update .= ((strlen($update)>0) ? ", " : "")."user_coadmin = '".intval($user_coadmin)."'";
	}

	//Gestion des membres
	if (!is_null($management_user)) {
		$update .= ((strlen($update)>0) ? ", " : "")."management_user = '".intval($management_user)."'";
	}

	//Gestion des classements
	if (!is_null($management_ranking)) {
		$update .= ((strlen($update)>0) ? ", " : "")."management_ranking = '".intval($management_ranking)."'";
	}


	$request = "update ".TABLE_USER." set ".$update." where user_id = ".$user_id;
	$db->sql_query($request);

	if ($user_id == $user_data['user_id']) {
		log_("modify_account");
	}
	else {
		log_("modify_account_admin", $user_id);
	}
}
/**
* Enregistrement des statistiques utilisateurs
*/
function user_set_stat($planet_added_web = null, $planet_added_ogs = null, $search = null, $spy_added_web = null, $spy_added_ogs = null, $rank_added_web = null, $rank_added_ogs = null, $planet_exported = null, $spy_exported = null, $rank_exported = null) {
	global $db, $user_data;

	$update = "";

	//Statistiques envoi systèmes solaires et rapports d'espionnage
	if (!is_null($planet_added_web))
	$update .= ((strlen($update)>0) ? ", " : "")."planet_added_web = planet_added_web + ".$planet_added_web;
	if (!is_null($planet_added_ogs))
	$update .= ((strlen($update)>0) ? ", " : "")."planet_added_ogs = planet_added_ogs + ".$planet_added_ogs;
	if (!is_null($search))
	$update .= ((strlen($update)>0) ? ", " : "")."search = search + ".$search;
	if (!is_null($spy_added_web))
	$update .= ((strlen($update)>0) ? ", " : "")."spy_added_web = spy_added_web + ".$spy_added_web;
	if (!is_null($spy_added_ogs))
	$update .= ((strlen($update)>0) ? ", " : "")."spy_added_ogs = spy_added_ogs + ".$spy_added_ogs;
	if (!is_null($rank_added_web))
	$update .= ((strlen($update)>0) ? ", " : "")."rank_added_web = rank_added_web + ".$rank_added_web;
	if (!is_null($rank_added_ogs))
	$update .= ((strlen($update)>0) ? ", " : "")."rank_added_ogs = rank_added_ogs + ".$rank_added_ogs;
	if (!is_null($planet_exported))
	$update .= ((strlen($update)>0) ? ", " : "")."planet_exported = planet_exported + ".$planet_exported;
	if (!is_null($spy_exported))
	$update .= ((strlen($update)>0) ? ", " : "")."spy_exported = spy_exported + ".$spy_exported;
	if (!is_null($rank_exported))
	$update .= ((strlen($update)>0) ? ", " : "")."rank_exported = rank_exported + ".$rank_exported;

	$request = "update ".TABLE_USER." set ".$update." where user_id = ".$user_data["user_id"];
	$db->sql_query($request);
}

/**
* Récupération d'une ligne d'information utilisateur
* @param int $user_id Identificateur optionnel d'1 utilisateur spécifique 
* @return Array Liste des utilisateurs ou de l'utilisateur spécifique
* @comment Pourrait peut etre avantageusement remplacé par select * from TABLE_USER
* @comment pour les éventuels champs supplémentaires
*/
function user_get($user_id = false) {
	global $db;

	$request = "select user_id, user_name, user_password, user_active, user_regdate, user_lastvisit,".
	" user_galaxy, user_system, user_admin, user_coadmin, management_user, management_ranking, disable_ip_check".
	" from ".TABLE_USER;

	if ($user_id !== false) {
		$request .= " where user_id = ".$user_id;
	}
	$request .= " order by user_name";
	$result = $db->sql_query($request);

	$info_users = array();
	while ($row = $db->sql_fetch_assoc($result)) {

		$info_users[] = $row;
	}

	if (sizeof($info_users) == 0) {
		return false;
	}

	return $info_users;
}
/**
*  Récupération des droits d'un utilisateur
* @param int $user_id Identificateur de l'utilisateur demandé
* @return Array Tableau des droits
*/
function user_get_auth($user_id) {
	global $db;

	$user_info = user_get($user_id);
	$user_info = $user_info[0];
	if ($user_info["user_admin"] == 1 || $user_info["user_coadmin"] == 1) {
		$user_auth = array("server_set_system" => 1, "server_set_spy" => 1, "server_set_rc" => 1, 
		"server_set_ranking" => 1, "server_show_positionhided" => 1, "ogs_connection" => 1, 
		"ogs_set_system" => 1, "ogs_get_system" => 1, "ogs_set_spy" => 1, "ogs_get_spy" => 1, 
		"ogs_set_ranking" => 1, "ogs_get_ranking" => 1);

		return $user_auth;
	}

	$request = "select server_set_system, server_set_spy, server_set_rc, server_set_ranking, server_show_positionhided,";
	$request .= " ogs_connection, ogs_set_system, ogs_get_system, ogs_set_spy, ogs_get_spy, ogs_set_ranking, ogs_get_ranking";
	$request .= " from ".TABLE_GROUP." g, ".TABLE_USER_GROUP." u";
	$request .= " where g.group_id = u.group_id";
	$request .= " and user_id = ".$user_id;
	$result = $db->sql_query($request);

	if ($db->sql_numrows($result) > 0) {
		$user_auth = array("server_set_system" => 0, "server_set_spy" => 0, "server_set_rc" => 0, "server_set_ranking" => 0, "server_show_positionhided" => 0,
		"ogs_connection" => 0, "ogs_set_system" => 0, "ogs_get_system" => 0, "ogs_set_spy" => 0, "ogs_get_spy" => 0, "ogs_set_ranking" => 0, "ogs_get_ranking" => 0);

		while ($row = $db->sql_fetch_assoc($result)) {
			if ($row["server_set_system"] == 1) $user_auth["server_set_system"] = 1;
			if ($row["server_set_spy"] == 1) $user_auth["server_set_spy"] = 1;
			if ($row["server_set_rc"] == 1) $user_auth["server_set_rc"] = 1;
			if ($row["server_set_ranking"] == 1) $user_auth["server_set_ranking"] = 1;
			if ($row["server_show_positionhided"] == 1) $user_auth["server_show_positionhided"] = 1;
			if ($row["ogs_connection"] == 1) $user_auth["ogs_connection"] = 1;
			if ($row["ogs_set_system"] == 1) $user_auth["ogs_set_system"] = 1;
			if ($row["ogs_get_system"] == 1) $user_auth["ogs_get_system"] = 1;
			if ($row["ogs_set_spy"] == 1) $user_auth["ogs_set_spy"] = 1;
			if ($row["ogs_get_spy"] == 1) $user_auth["ogs_get_spy"] = 1;
			if ($row["ogs_set_ranking"] == 1) $user_auth["ogs_set_ranking"] = 1;
			if ($row["ogs_get_ranking"] == 1) $user_auth["ogs_get_ranking"] = 1;
		}
	}
	else {
		$user_auth = array("server_set_system" => 0, "server_set_spy" => 0, "server_set_ranking" => 0, "server_show_positionhided" => 0,
		"ogs_connection" => 0, "ogs_set_system" => 0, "ogs_get_system" => 0, "ogs_set_spy" => 0, "ogs_get_spy" => 0, "ogs_set_ranking" => 0, "ogs_get_ranking" => 0);
	}

	return $user_auth;
}

/**
* Création d'un utilisateur à partie des données du formulaire admin
* @comment redirection si erreur de type de donnée
*/
function user_create() {
	global $db, $user_data;
	global $pub_pseudo, $pub_user_id, $pub_active, $pub_user_coadmin, $pub_management_user, $pub_management_ranking, $pub_group_id, $pub_pass; 

	if (!check_var($pub_pseudo, "Pseudo_Groupname")) {
		redirection("index.php?action=message&id_message=errordata&info=1");
	}

	if (!isset($pub_pseudo)) {
		redirection("index.php?action=message&id_message=createuser_failed_general&info");
	}

	//Vérification des droits
	user_check_auth("user_create");

	if (!check_var($pub_pseudo, "Pseudo_Groupname")) {
		redirection("index.php?action=message&id_message=createuser_failed_pseudo&info=".$pub_pseudo);
	}

	if (!check_var($pub_pass, "Password")) {
		redirection("index.php?action=message&id_message=createuser_failed_password&info=".$pub_pseudo);
	}

	if ($pub_pass != "") {
		$password = $pub_pass;
	}
	else {
		$password = password_generator();
	}
	//$request = "select user_id from ".TABLE_USER." where user_name = '".mysql_real_escape_string($pub_pseudo)."'";
	$request = "select user_id from ".TABLE_USER." where user_name = '".$pub_pseudo."'";
	$result = $db->sql_query($request);
	if ($db->sql_numrows($result) == 0) {
		//$request = "insert into ".TABLE_USER." (user_name, user_password, user_regdate, user_active)".
		//" values ('".mysql_real_escape_string($pub_pseudo)."', '".md5(sha1($password))."', ".time().", '1')";
		$request = "insert into ".TABLE_USER." (user_name, user_password, user_regdate, user_active)".
		" values ('".$pub_pseudo."', '".md5(sha1($password))."', ".time().", '1')";
		$db->sql_query($request);
		$user_id = $db->sql_insertid();

		$request = "insert into ".TABLE_USER_GROUP." (group_id, user_id) values (".$pub_group_id.", ".$user_id.")";
		$db->sql_query($request);

		$info = $user_id.":".$password;
		log_("create_account", $user_id);
		user_set_grant($user_id, null, $pub_active, $pub_user_coadmin, $pub_management_user, $pub_management_ranking);
		redirection("index.php?action=message&id_message=createuser_success&info=".$info);
	}
	else {
		redirection("index.php?action=message&id_message=createuser_failed_pseudolocked&info=".$pub_pseudo);
	}
}
/**
* Suppression d'un utilisateur ($pub_user_id)
*/
function user_delete() {
	global $db, $user_data;
	global $pub_user_id;

	if (!check_var($pub_user_id, "Num")) {
		redirection("index.php?action=message&id_message=errordata&info");
	}

	if (!isset($pub_user_id)) {
		redirection("index.php?action=message&id_message=createuser_failed_general&info");
	}

	user_check_auth("user_update", $pub_user_id);

	log_("delete_account", $pub_user_id);
	$request = "delete from ".TABLE_USER." where user_id = ".$pub_user_id;
	$db->sql_query($request);

	$request = "delete from ".TABLE_USER_GROUP." where user_id = ".$pub_user_id;
	$db->sql_query($request);

	$request = "delete from ".TABLE_USER_BUILDING." where user_id = ".$pub_user_id;
	$db->sql_query($request);

	$request = "delete from ".TABLE_USER_FAVORITE." where user_id = ".$pub_user_id;
	$db->sql_query($request);

	$request = "delete from ".TABLE_USER_SPY." where user_id = ".$pub_user_id;
	$db->sql_query($request);

	$request = "delete from ".TABLE_USER_TECHNOLOGY." where user_id = ".$pub_user_id;
	$db->sql_query($request);

	$request = "update ".TABLE_RANK_PLAYER_FLEET." set sender_id = 0 where sender_id = ".$pub_user_id;
	$db->sql_query($request);

	$request = "update ".TABLE_RANK_PLAYER_POINTS." set sender_id = 0 where sender_id = ".$pub_user_id;
	$db->sql_query($request);

	$request = "update ".TABLE_RANK_PLAYER_RESEARCH." set sender_id = 0 where sender_id = ".$pub_user_id;
	$db->sql_query($request);

	$request = "update ".TABLE_SPY." set sender_id = 0 where sender_id = ".$pub_user_id;
	$db->sql_query($request);

	$request = "update ".TABLE_UNIVERSE." set last_update_user_id = 0 where last_update_user_id = ".$pub_user_id;
	$db->sql_query($request);

	session_close($pub_user_id);

	redirection("index.php?action=administration&subaction=member");
}
/**
* Récupération des statistiques
*/
function user_statistic() {
	global $db;

	$request = "select user_id, user_name, planet_added_web, planet_added_ogs, search, spy_added_web, spy_added_ogs, rank_added_web, rank_added_ogs, planet_exported, spy_exported, rank_exported";
	$request .= " from ".TABLE_USER." order by (planet_added_web + planet_added_ogs) desc";
	$result = $db->sql_query($request);

	$user_statistic = array();
	while ($row = $db->sql_fetch_assoc($result)) {
		$here = "";
		$request = "select session_ogs from ".TABLE_SESSIONS." where session_user_id = ".$row["user_id"];
		$result_2 = $db->sql_query($request);
		if ($db->sql_numrows($result_2) > 0) {
			$here = "(*)";
			list($session_ogs) = $db->sql_fetch_row($result_2);
			if ($session_ogs == 1) $here = "(**)";
		}
		$user_statistic[] = array_merge($row, array("here" => $here));
	}

	return $user_statistic;
}
/**
* Enregistrement des données Empires d'un utilisateur
*/
function user_set_empire() {
	global $pub_typedata, $pub_data, $pub_planet_id, $pub_planet_name, $pub_fields, $pub_coordinates, $pub_temperature, $pub_reflecteur;

	if (!isset($pub_typedata) || !isset($pub_data)) {
		redirection("index.php?action=message&id_message=errorfatal&info");
	}

	switch ($pub_typedata) {
		case "B" :
		if (!isset($pub_planet_name) || !isset($pub_fields) || !isset($pub_coordinates)|| !isset($pub_temperature) || !isset($pub_reflecteur)) {
			redirection("index.php?action=message&id_message=errorfatal&info");
		}
		user_set_building($pub_data, $pub_planet_id, $pub_planet_name, $pub_fields, $pub_coordinates, $pub_temperature, $pub_reflecteur);
		break;

		case "T" :
		user_set_technology($pub_data);
		break;

		case "D" :
		if (!isset($pub_planet_name) || !isset($pub_fields) || !isset($pub_coordinates)|| !isset($pub_temperature) || !isset($pub_reflecteur)) {
			redirection("index.php?action=message&id_message=errorfatal&info");
		}
		user_set_defence($pub_data, $pub_planet_id, $pub_planet_name, $pub_fields, $pub_coordinates, $pub_temperature, $pub_reflecteur);
		break;

		case "E" :
		user_set_all_empire($pub_data);
		break;


		default :
		redirection("index.php?action=message&id_message=errorfatal&info");
		break;
	}

	redirection("index.php?action=home&subaction=empire");
}
/**
* Enregistrement de toutes les données empires
*/
function user_set_all_empire($data) {
	global $db, $user_data;
	global $pub_view;
	require_once("parameters/lang_empire.php");

	$data = str_replace ( "-", "0", $data );
	$data = str_replace ( ".", "", $data );
	$data = stripcslashes($data);
	$lines = explode(chr(10), $data);
	$OK = false;
	$etape = "";
	$planetes_total_row = false;
	foreach ($lines as $line) {
		$arr = array();
		$line = trim($line);

		if($line == "Vue d'ensemble de votre empire") {
			$OK = true;
			continue;
		}

		if($OK) {
			if (preg_match("#^Coordonnées\s+\[(.*)\]$#", $line, $arr)) {
				$coordonnees = preg_split("/\]\s+\[/", $arr[1]);
				$planetes_total_row = sizeof($coordonnees) + 1;
				if($planetes_total_row > 10) return false;

				$link_building = array($lang_building["M"] => "M", $lang_building["C"] => "C", $lang_building["D"] => "D",
				$lang_building["CES"] => "CES", $lang_building["CEF"] => "CEF",
				$lang_building["UdR"] => "UdR", $lang_building["UdN"] => "UdN", $lang_building["CSp"] => "CSp",
				$lang_building["HM"] => "HM", $lang_building["HC"] => "HC", $lang_building["HD"] => "HD",
				$lang_building["Lab"] => "Lab", $lang_building["CdC"] => "CdC", $lang_building["Silo"] => "Silo",
				$lang_building["CrAt"] => "CrAt", $lang_building["Pha"] => "Pha", $lang_building["PoSa"] => "PoSa");

				$buildings = array("M" => array_fill(0, $planetes_total_row, 0), "C" => array_fill(0, $planetes_total_row, 0),	"D" => array_fill(0, $planetes_total_row, 0),
				"CES" => array_fill(0, $planetes_total_row, 0), "CEF" => array_fill(0, $planetes_total_row, 0),
				"UdR" => array_fill(0, $planetes_total_row, 0), "UdN" => array_fill(0, $planetes_total_row, 0), "CSp" => array_fill(0, $planetes_total_row, 0),
				"HM" => array_fill(0, $planetes_total_row, 0), "HC" => array_fill(0, $planetes_total_row, 0), "HD" => array_fill(0, $planetes_total_row, 0),
				"Lab" => array_fill(0, $planetes_total_row, 0), "CdC" => array_fill(0, $planetes_total_row, 0), "Silo" => array_fill(0, $planetes_total_row, 0),
				"CrAt" => array_fill(0, $planetes_total_row, 0), "Pha" => array_fill(0, $planetes_total_row, 0), "PoSa" => array_fill(0, $planetes_total_row, 0));

				$link_defence = array($lang_defence["CA"] => "CA", $lang_defence["TLM"] => "TLM", $lang_defence["ASA"] => "ASA",
				$lang_defence["CP"] => "CP", $lang_defence["AM"] => "AM", $lang_defence["Dem"] => "Dem",
				$lang_defence["PB"] => "PB", $lang_defence["GB"] => "GB",
				$lang_defence["MIC"] => "MIC", $lang_defence["MIP"] => "MIP");
				$defences = array("CA" => array_fill(0, $planetes_total_row, 0), "TLM" => array_fill(0, $planetes_total_row, 0),	"ASA" => array_fill(0, $planetes_total_row, 0),
				"CP" => array_fill(0, $planetes_total_row, 0), "AM" => array_fill(0, $planetes_total_row, 0), "Dem" => array_fill(0, $planetes_total_row, 0),
				"PB" => array_fill(0, $planetes_total_row, 0), "GB" => array_fill(0, $planetes_total_row, 0),
				"MIC" => array_fill(0, $planetes_total_row, 0), "MIP" => array_fill(0, $planetes_total_row, 0));

				$link_technology = array($lang_technology["Esp"] => "Esp", $lang_technology["Gestion"] => "Gestion",
				$lang_technology["Armes"] => "Armes", $lang_technology["Bouclier"] => "Bouclier", $lang_technology["Blindage"] => "Blindage",
				$lang_technology["NRJ"] => "NRJ",
				$lang_technology["Hyp"] => "Hyp", $lang_technology["RC"] => "RC", $lang_technology["RI"] => "RI", $lang_technology["PH"] => "PH",
				$lang_technology["Laser"] => "Laser", $lang_technology["Ions"] => "Ions", $lang_technology["Plasma"] => "Plasma",
				$lang_technology["Antimatiere"] => "Antimatiere");

				$technologies = array("Esp" => 0, "Gestion" => 0, "Armes" => 0, "Bouclier" => 0, "Blindage" => 0,
				"NRJ" => 0, "Hyp" => 0, "RC" => 0, "RI" => 0, "PH" => 0, "Laser" => 0, "Ions" => 0, "Plasma" => 0,
				"Antimatiere" => 0);

				$reflecteur = array_fill(0, $planetes_total_row, 0);
				$cases = array_fill(0, $planetes_total_row, 0);

				// creation du masque ici
				$masq = "#^((?:\s?\S+)+)\s+";
				for($i=0; $i<($planetes_total_row-1); $i++) {
					$masq .= "(\d+)(?:|\s\d+|\s\(\d+\))\s+";
				}
				$masq .= "(\d+)(?:\s\d+|\s\(\d+\))*$#";

				continue;
			}

			if($OK && $planetes_total_row !==false) {

				if(preg_match("#^Cases\s+\d+\/((?:\d+\s+(?:\d+)\/(?:\d+)\s*){1,".$planetes_total_row."})$#",$line,$arr)) {
					$cases = preg_split("/\s+\d+\//", $arr[1]);
					if(sizeof($cases) != $planetes_total_row) return false;
					continue;
				}

				if(preg_match("#^(".$lang_empire["Batiment"]."|".$lang_empire["Recherche"]."|".$lang_empire["Vaisseaux"]."|".$lang_empire["Défense"].")$#",$line)) {
					$etape = $line;
					continue;
				}

				if($etape != "" && preg_match($masq, $line, $arr)) {

					$building = $arr[1];
					$levels = array_slice($arr, 2);

					switch($etape) {
						case "Bâtiments" :
						if (isset($link_building[$building])) {
							if( sizeof($levels) != $planetes_total_row) return false;
							$buildings[$link_building[$building]] = $levels;
						}
						break;
						case "Recherche" :
						if (isset($link_technology[$building])) {
							if( sizeof($levels) != $planetes_total_row) return false;
							$technologies[$link_technology[$building]] = max($levels);
						}
						break;
						case "Vaisseaux" :
						if ($building == "réflecteur solaire") {
							if( sizeof($levels) != $planetes_total_row) return false;
							$reflecteurs = $levels;
						}
						break;
						case "Défense" :
						if (isset($link_defence[$building])) {
							if( sizeof($levels) != $planetes_total_row) return false;
							$defences[$link_defence[$building]] = $levels;
						}
						break;
						default :
						redirection("index.php?action=message&id_message=set_empire_failed_data&info");
					}
					continue;
				}

			}
		}
	}
	if($OK && $planetes_total_row !== false) {
		$j=19;
		for($i=0; $i<$planetes_total_row; $i++) {
			if($pub_view == "moons") {
				$request = "select planet_id from ".TABLE_USER_BUILDING." where coordinates = '".$coordonnees[$i]."' and planet_id > 9";
				$result = $db->sql_query($request);
				if ($db->sql_numrows($result) > 0) {
					list($planete_id) = $db->sql_fetch_row($result);
				}
				else {
					$request = "select planet_id from ".TABLE_USER_BUILDING." where user_id = ".$user_data["user_id"]." and coordinates = '".$coordonnees[$i]."'";
					$result = $db->sql_query($request);
					list($planete_id) = $db->sql_fetch_row($result);
					if(!$planete_id) {
						$planete_id = $j;
						$j++;
					}
					else $planete_id += 9;
				}
			}
			else $planete_id = $i+1;

			if($pub_view == "planets") $case = $cases[$i]-5*$buildings["CdC"][$i];
			else $case = 1;

			$request = "update ".TABLE_USER_BUILDING." set coordinates = '".$coordonnees[$i]."', `fields` = ".$case." , ReSo = ".$reflecteurs[$i];
			$request .= ", M = ".$buildings["M"][$i].", C = ".$buildings["C"][$i].", D = ".$buildings["D"][$i];
			$request .= ", CES = ".$buildings["CES"][$i].", CEF = ".$buildings["CEF"][$i].", UdR = ".$buildings["UdR"][$i];
			$request .= ", UdN = ".$buildings["UdN"][$i].", CSp = ".$buildings["CSp"][$i].", HM = ".$buildings["HM"][$i];
			$request .= ", HC = ".$buildings["HC"][$i].", HD = ".$buildings["HD"][$i].", Lab = ".$buildings["Lab"][$i];
			$request .= ", CdC = ".$buildings["CdC"][$i].", Silo = ".$buildings["Silo"][$i].", CrAt = ".$buildings["CrAt"][$i];
			$request .= ", Pha = ".$buildings["Pha"][$i].", PoSa = ".$buildings["PoSa"][$i].($pub_view == 'lunes' ? ', planet_name = \'Lune\'' : '');
			$request .= " where user_id = ".$user_data["user_id"]." and planet_id = ".$planete_id;
			$db->sql_query($request);
			if ($db->sql_affectedrows() == 0) {
				$request = "insert ignore into ".TABLE_USER_BUILDING." (user_id, planet_id, planet_name, coordinates, `fields`, temperature, ReSo, M, C, D, CES, CEF, UdR, UdN, CSp, HM, HC, HD, Lab, CdC, Silo, CrAt, Pha, PoSa)";
				$request .= " values (".$user_data["user_id"].", ".$planete_id.", '".($pub_view == 'moons' ? 'Lune' : 'planete '.$planete_id)."', '".$coordonnees[$i]."', ".$case.", 0, ".$reflecteurs[$i];
				$request .= ", ".$buildings["M"][$i].", ".$buildings["C"][$i].", ".$buildings["D"][$i];
				$request .= ", ".$buildings["CES"][$i].", ".$buildings["CEF"][$i].", ".$buildings["UdR"][$i];
				$request .= ", ".$buildings["UdN"][$i].", ".$buildings["CSp"][$i].", ".$buildings["HM"][$i];
				$request .= ", ".$buildings["HC"][$i].", ".$buildings["HD"][$i].", ".$buildings["Lab"][$i];
				$request .= ", ".$buildings["CdC"][$i].", ".$buildings["Silo"][$i].", ".$buildings["CrAt"][$i];
				$request .= ", ".$buildings["Pha"][$i].", ".$buildings["PoSa"][$i].")";
				$db->sql_query($request);
			}

			$request = "delete from ".TABLE_USER_DEFENCE." where user_id = ".$user_data["user_id"]." and planet_id= ".$planete_id;
			$db->sql_query($request);

			$request = "insert into ".TABLE_USER_DEFENCE." (user_id, planet_id, CA, TLM, ASA, CP, AM, Dem, PB, GB, MIC, MIP)";
			$request .= " values (".$user_data["user_id"].", ".$planete_id.", ".$defences["CA"][$i].", ".$defences["TLM"][$i].",".$defences["ASA"][$i].", ".$defences["CP"][$i].", ".$defences["AM"][$i].", ".$defences["Dem"][$i].", ".$defences["PB"][$i].", ".$defences["GB"][$i].", ".$defences["MIC"][$i].", ".$defences["MIP"][$i].")";
			$db->sql_query($request);
		}
		if($pub_view=="planets") {
			$request = "delete from ".TABLE_USER_TECHNOLOGY." where user_id = ".$user_data["user_id"];
			$db->sql_query($request);

			$request = "insert into ".TABLE_USER_TECHNOLOGY." (user_id, esp, Gestion, Armes, Bouclier, Blindage, NRJ, Hyp, RC, RI, PH, Laser, Ions, Plasma, Antimatiere)";
			$request .= " values (".$user_data["user_id"].", ".$technologies["Esp"].", ".$technologies["Gestion"].",".$technologies["Armes"].", ".$technologies["Bouclier"].", ".$technologies["Blindage"].", ".$technologies["NRJ"].", ".$technologies["Hyp"].", ".$technologies["RC"].", ".$technologies["RI"].", ".$technologies["PH"].", ".$technologies["Laser"].", ".$technologies["Ions"].", ".$technologies["Plasma"].", ".$technologies["Antimatiere"].");";
			$db->sql_query($request);
		}

		//Remise en ordre des lunes selon la position des planètes
		user_set_all_empire_resync();

		if($pub_view=="planets") redirection("index.php?action=home&subaction=empire&view=".$pub_view."&alert_empire=true");
		else redirection("index.php?action=home&subaction=empire&view=".$pub_view);
	}
	else redirection("index.php?action=message&id_message=set_empire_failed_data&info");
}

function user_set_all_empire_resync() {
	global $db, $user_data;

	$planet_position = array();
	$moon_position = array();
	$moon_position_extra = array();
	$position_free = array(18,17,16,15,14,13,12,11,10);

	$request = "select planet_id, coordinates";
	$request .= " from ".TABLE_USER_BUILDING;
	$request .= " where user_id = ".$user_data["user_id"];
	$request .= " and planet_id <= 9";
	$request .= " order by planet_id";
	$result = $db->sql_query($request);

	while (list($planet_id, $coordinates) = $db->sql_fetch_row($result)) {
		$planet_position[$coordinates] = $planet_id;
	}

	$request = "select planet_id, coordinates";
	$request .= " from ".TABLE_USER_BUILDING;
	$request .= " where user_id = ".$user_data["user_id"];
	$request .= " and planet_id > 9";
	$request .= " order by planet_id";
	$result = $db->sql_query($request);

	while (list($planet_id, $coordinates) = $db->sql_fetch_row($result)) {
		if (isset($planet_position[$coordinates])) {
			$moon_position[$planet_id] = $planet_position[$coordinates] + 9;
			unset($position_free[$planet_position[$coordinates] - 1]);
		}
		else {
			$moon_position_extra[] = $planet_id;
		}
	}

	$position_free = array_values($position_free);
	$i=0;
	foreach (array_values($moon_position_extra) as $planet_id) {
		$moon_position[$planet_id] = $position_free[$i];
		$i++;
	}

	$request = "update ".TABLE_USER_BUILDING." set planet_id = planet_id * (-1)";
	$request .= " where planet_id > 9";
	$request .= " and user_id = ".$user_data["user_id"];
	$db->sql_query($request);
	$request = "update ".TABLE_USER_DEFENCE." set planet_id = planet_id * (-1)";
	$request .= " where planet_id > 9";
	$request .= " and user_id = ".$user_data["user_id"];
	$db->sql_query($request);

	while ($value = @current($moon_position)) {
		$request = "update ".TABLE_USER_BUILDING." set planet_id = ".$value." where planet_id = ".key($moon_position) * (-1);
		$db->sql_query($request);
		$request = "update ".TABLE_USER_DEFENCE." set planet_id = ".$value." where planet_id = ".key($moon_position) * (-1);
		$db->sql_query($request);

		next($moon_position);
	}
}

function user_set_building($data, $planet_id, $planet_name, $fields, $coordinates, $temperature, $reflecteur) {
	global $db, $user_data;
	global $pub_view, $server_config;
	require_once("parameters/lang_empire.php");

	$planet_name = trim($planet_name) != "" ? trim($planet_name) : "Inconnu";
	if (!check_var($planet_name, "Galaxy")) $planet_name = "";

	$fields = intval($fields);
	$temperature = intval($temperature);
	$ReSoellite = intval($reflecteur);
	$coordinates_ok = "";
	if (sizeof(explode(":", $coordinates)) == 3 || sizeof(explode(".", $coordinates)) == 3) {
		if (sizeof(explode(":", $coordinates)) == 3) @list($galaxy, $system, $row) = explode(":", $coordinates);
		if (sizeof(explode(".", $coordinates)) == 3) @list($galaxy, $system, $row) = explode(".", $coordinates);
		if (intval($galaxy) >= 1 && intval($galaxy) <= intval($server_config['num_of_galaxies'])		&&  intval($system) >= 1 &&  intval($system) <= intval($server_config['num_of_systems']) &&  intval($row) >= 1 &&  intval($row) <= 15) {
			$coordinates_ok = $coordinates;
		}
	}

	if (!isset($planet_id)) {
		redirection("index.php?action=message&id_message=set_empire_failed_data&info");
	}
	$planet_id = intval($planet_id);
	if (($view=="planets" && ($planet_id < 1 || $planet_id > 9)) || ($view=="lunes" && ($planet_id < 10 || $planet_id > 18))) {
		redirection("index.php?action=message&id_message=set_empire_failed_data&info");
	}

	$link_building = array($lang_building["M"] => "M", $lang_building["C"] => "C", $lang_building["D"] => "D",
	$lang_building["CES"] => "CES", $lang_building["CEF"] => "CEF",
	$lang_building["UdR"] => "UdR", $lang_building["UdN"] => "UdN", $lang_building["CSp"] => "CSp",
	$lang_building["HM"] => "HM", $lang_building["HC"] => "HC", $lang_building["HD"] => "HD",
	$lang_building["Lab"] => "Lab", $lang_building["CdC"] => "CdC", $lang_building["Silo"] => "Silo",
	$lang_building["CrAt"] => "CrAt", $lang_building["Pha"] => "Pha", $lang_building["PoSa"] => "PoSa");

	$buildings = array("M" => 0, "C" => 0,	"D" => 0,
	"CES" => 0, "CEF" => 0,
	"UdR" => 0, "UdN" => 0, "CSp" => 0,
	"HM" => 0, "HC" => 0, "HD" => 0,
	"Lab" => 0, "CdC" => 0, "Silo" => 0,
	"CrAt" => 0, "Pha" => 0, "PoSa" => 0);

	$lines = explode(chr(10), $data);

	$OK = false;
	foreach ($lines as $line) {
		$arr = array();
		$line = trim($line);
		if (ereg("^(.*) \(Niveau ([[:digit:]]{1,3}).*\)$", $line, $arr)) {
			list($string, $building, $level) = $arr;

			$building = trim($building);
			$level = trim(str_replace("Niveau", "", $level));
			if (isset($link_building[$building])) {
				$OK = true;
				$buildings[$link_building[$building]] = $level;
			}
		}
	}
	
	if ($OK) {
		$request = "delete from ".TABLE_USER_BUILDING." where user_id = ".$user_data["user_id"]." and planet_id= ".$planet_id;
		$db->sql_query($request);

		$request = "insert into ".TABLE_USER_BUILDING." (user_id, planet_id, planet_name, coordinates, `fields`, temperature, ReSo, M, C, D, CES, CEF, UdR, UdN, CSP, HM, HC, HD, Lab, CdC, Silo, CrAt, Pha, PoSa)";
		$request .= " values ('".$user_data["user_id"]."', '".$planet_id."', '".mysql_real_escape_string($planet_name)."',
		   '".$coordinates_ok."', '".$fields."', '".$temperature."', '".$reflecteur."', '".$buildings["M"]."', '".$buildings["C"]."',
		   '".$buildings["D"]."', '".$buildings["CES"]."', '".$buildings["CEF"]."', '".$buildings["UdR"]."', '".$buildings["UdN"]."',
		   '".$buildings["CSp"]."', '".$buildings["HM"]."', '".$buildings["HC"]."', '".$buildings["HD"]."', '".$buildings["Lab"]."',
		   '".$buildings["CdC"]."', '".$buildings["Silo"]."', '".$buildings["CrAt"]."', '".$buildings["Pha"]."', '".$buildings["PoSa"]."')";
		$db->sql_query($request);
	}
	elseif ( $planet_id > 9 ) {
		$request = "insert into ".TABLE_USER_BUILDING." (user_id, planet_id, planet_name, coordinates, `fields`, temperature, ReSo, M, C, D, CES, CEF, UdR, UdN, CSP, HM, HC, HD, Lab, CdC, Silo, CrAt, Pha, PoSa)";
		$request .= " values (".$user_data["user_id"].", ".$planet_id.", '".mysql_real_escape_string($planet_name)."', '".$coordinates_ok."', ".$fields.", ".$temperature.", ".$reflecteur.", ".$buildings["M"].", ".$buildings["C"].",".$buildings["D"].", ".$buildings["CES"].", ".$buildings["CEF"].", ".$buildings["UdR"].", ".$buildings["UdN"].", ".$buildings["CSp"].", ".$buildings["HM"].", ".$buildings["HC"].", ".$buildings["HD"].", ".$buildings["Lab"].", ".$buildings["CdC"].", ".$buildings["Silo"].", ".$buildings["CrAt"].", ".$buildings["Pha"].", ".$buildings["PoSa"].")";
		$db->sql_query($request);
	}
	else {
		$request = "update ".TABLE_USER_BUILDING." set planet_name = '".mysql_real_escape_string($planet_name)."', coordinates = '".$coordinates_ok."', `fields` = ".$fields.", temperature = ".$temperature.", ReSo = ".$reflecteur." where user_id = ".$user_data["user_id"]." and planet_id = ".$planet_id;
		$db->sql_query($request);
	}

	redirection("index.php?action=home&subaction=empire&view=".$pub_view);
}

function user_set_technology($data) {
	global $db, $user_data;
	require_once("parameters/lang_empire.php");

	$link_technology = array($lang_technology["Esp"] => "Esp", $lang_technology["Gestion"] => "Gestion",
	$lang_technology["Armes"] => "Armes", $lang_technology["Bouclier"] => "Bouclier", $lang_technology["Blindage"] => "Blindage",
	$lang_technology["NRJ"] => "NRJ",
	$lang_technology["Hyp"] => "Hyp", $lang_technology["RC"] => "RC", $lang_technology["RI"] => "RI", $lang_technology["PH"] => "PH",
	$lang_technology["Laser"] => "Laser", $lang_technology["Ions"] => "Ions", $lang_technology["Plasma"] => "Plasma",
	$lang_technology["Antimatiere"] => "Antimatiere");

	$technologies = array("Esp" => 0, "Gestion" => 0,
	"Armes" => 0, "Bouclier" => 0, "Blindage" => 0,
	"NRJ" => 0,
	"Hyp" => 0, "RC" => 0, "RI" => 0, "PH" => 0,
	"Laser" => 0, "Ions" => 0, "Plasma" => 0,
	"Antimatiere" => 0);

	$lines = explode(chr(10), $data);

	$OK = false;
	foreach ($lines as $line) {
		$arr = array();
		$line = trim($line);
		if (ereg("^(.*) \(Niveau ([[:digit:]]{1,3}).*\)$", $line, $arr)) {
			list($string, $technology, $level) = $arr;
			$technology = trim($technology);
			$level = trim(str_replace("Niveau", "", $level));

			if (isset($link_technology[$technology])) {
				$OK = true;
				$technologies[$link_technology[$technology]] = $level;
			}
		}
	}

	if (!$OK) {
		redirection("index.php?action=message&id_message=set_empire_failed_data&info");
	}

	$request = "delete from ".TABLE_USER_TECHNOLOGY." where user_id = ".$user_data["user_id"];
	$db->sql_query($request);

	$request = "insert into ".TABLE_USER_TECHNOLOGY." (user_id, esp, Gestion, Armes, Bouclier, Blindage, NRJ, Hyp, RC, RI, PH, Laser, Ions, Plasma, Antimatiere)";
	$request .= " values (".$user_data["user_id"].", ".$technologies["Esp"].", ".$technologies["Gestion"].",".$technologies["Armes"].", ".$technologies["Bouclier"].", ".$technologies["Blindage"].", ".$technologies["NRJ"].", ".$technologies["Hyp"].", ".$technologies["RC"].", ".$technologies["RI"].", ".$technologies["PH"].", ".$technologies["Laser"].", ".$technologies["Ions"].", ".$technologies["Plasma"].", ".$technologies["Antimatiere"].");";
	$db->sql_query($request);

	redirection("index.php?action=home&subaction=empire");
}
/**
* Enregistrement des défenses de l'utilisateurs
*/
function user_set_defence($data, $planet_id, $planet_name, $fields, $coordinates, $temperature, $reflecteur) {
	global $db, $user_data;
	global $pub_view, $server_config;
	require_once("parameters/lang_empire.php");

	$planet_name = trim($planet_name) != "" ? trim($planet_name) : "Inconnu";
	if (!check_var($planet_name, "Galaxy")) $planet_name = "";
	$fields = intval($fields);
	$temperature = intval($temperature);
	$reflecteur = intval($reflecteur);
	$coordinates_ok = "";
	if (sizeof(explode(":", $coordinates)) == 3 || sizeof(explode(".", $coordinates)) == 3) {
		if (sizeof(explode(":", $coordinates)) == 3) @list($galaxy, $system, $row) = explode(":", $coordinates);
		if (sizeof(explode(".", $coordinates)) == 3) @list($galaxy, $system, $row) = explode(".", $coordinates);
		if (intval($galaxy) >= 1 && intval($galaxy) <= intval($server_config['num_of_galaxies']) &&  intval($system) >= 1 &&  intval($system) <= intval($server_config['num_of_systems']) &&  intval($row) >= 1 &&  intval($row) <= 15) {
			$coordinates_ok = $coordinates;
		}
	}

	if (!isset($planet_id)) {
		redirection("index.php?action=message&id_message=set_empire_failed_data&info");
	}
	$planet_id = intval($planet_id);
	if (($pub_view=="planets" && ($planet_id < 1 || $planet_id > 9)) || ($pub_view=="lunes" && ($planet_id < 10 || $planet_id > 18))) {
		redirection("index.php?action=message&id_message=set_empire_failed_data&info");
	}

	$link_defence = array($lang_defence["CA"] => "CA", $lang_defence["TLM"] => "TLM", $lang_defence["ASA"] => "ASA",
	$lang_defence["CP"] => "CP", $lang_defence["AM"] => "AM", $lang_defence["Dem"] => "Dem",
	$lang_defence["PB"] => "PB", $lang_defence["GB"] => "GB",
	$lang_defence["MIC"] => "MIC", $lang_defence["MIP"] => "MIP");
	
	$defences = array("CA" => 0, "TLM" => 0,	"ASA" => 0,
	"CP" => 0, "AM" => 0, "Dem" => 0,
	"PB" => 0, "GB" => 0,
	"MIC" => 0, "MIP" => 0);

	$lines = explode(chr(10), str_replace('.','',$data));

	$OK = false;
	foreach ($lines as $line) {
		$arr = array();
		$line = trim($line);

		if (ereg("^(.*) \(([[:space:][:digit:]]{1,9}|[[:digit:]]{1,9}) disponible", $line, $arr)) { 
			list($string, $defence, $level) = $arr;

			$defence = trim($defence);
			$level = trim(str_replace("disponible(s)", "", $level));

			if (isset($link_defence[$defence])) {
				$OK = true;
				$defences[$link_defence[$defence]] = $level;
			}
		}
	}

	if ($OK) {
		$request = "delete from ".TABLE_USER_DEFENCE." where user_id = ".$user_data["user_id"]." and planet_id= ".$planet_id;
		$db->sql_query($request);

		$request = "insert into ".TABLE_USER_DEFENCE." (user_id, planet_id, CA, TLM, ASA, CP, AM, Dem, PB, GB, MIC, MIP)";
		$request .= " values (".$user_data["user_id"].", ".$planet_id.", ".$defences["CA"].", ".$defences["TLM"].",".$defences["ASA"].", ".$defences["CP"].", ".$defences["AM"].", ".$defences["Dem"].", ".$defences["PB"].", ".$defences["GB"].", ".$defences["MIC"].", ".$defences["MIP"].")";
		$db->sql_query($request);
	}
	
	else {
		$request = "update ".TABLE_USER_BUILDING." set planet_name = '".mysql_real_escape_string($planet_name)."', coordinates = '".$coordinates_ok."', `fields` = ".$fields.", temperature = ".$temperature.", ReSo = ".$reflecteur." where user_id = ".$user_data["user_id"]." and planet_id = ".$planet_id;
		$db->sql_query($request);
	}

	redirection("index.php?action=home&subaction=empire&view=".$pub_view);
}

/**
* Récupération des données empire de l'utilisateur loggé
* @comment On pourrait mettre un paramète $user_id optionnel
*/
function user_get_empire() {
	global $db, $user_data;

	$planet = array(false, "user_id" => "", "planet_name" => "", "coordinates" => "",
	"fields" => "", "fields_used" => "", "temperature" => "", "ReSo" => "",
	"M" => 0, "C" => 0, "D" => 0,
	"CES" => 0, "CEF" => 0,
	"UdR" => 0, "UdN" => 0, "CSp" => 0,
	"HM" => 0, "HC" => 0, "HD" => 0,
	"Lab" => 0, "CdC" => 0, "Silo" => 0,
	"CrAt" => 0, "Pha" => 0, "PoSa" => 0);

	$defence = array("CA" => 0, "TLM" => 0, "ASA" => 0,
	"CP" => 0, "AM" => 0, "Dem" => 0,
	"PB" => 0, "GB" => 0,
	"MIC" => 0, "MIP" => 0);
	
	$request = "select planet_id, planet_name, coordinates, `fields`, temperature, ReSo, M, C, D, CES, CEF, UdR, UdN, CSp, HM, HC, HD, Lab, CdC, Silo, CrAt, Pha, PoSa";
	$request .= " from ".TABLE_USER_BUILDING;
	$request .= " where user_id = ".$user_data["user_id"];
	$request .= " order by planet_id";
	$result = $db->sql_query($request);

	$user_building = array_fill(1, 18, $planet);
	while ($row = $db->sql_fetch_assoc($result)) {
		$arr = $row;
		unset($arr["planet_id"]);
		unset($arr["planet_name"]);
		unset($arr["coordinates"]);
		unset($arr["fields"]);
		unset($arr["temperature"]);
		unset($arr["ReSo"]);
		$fields_used = array_sum(array_values($arr));

		$row["fields_used"] = $fields_used;
		$user_building[$row["planet_id"]] = $row;
		$user_building[$row["planet_id"]][0] = true;
	}

	$request = "select Esp, Gestion, Armes, Bouclier, Blindage, NRJ, Hyp, RC, RI, PH, Laser, Ions, Plasma, Antimatiere";
	$request .= " from ".TABLE_USER_TECHNOLOGY;
	$request .= " where user_id = ".$user_data["user_id"];
	$result = $db->sql_query($request);

	$user_technology = $db->sql_fetch_assoc($result);

	$request = "select planet_id, CA, TLM, ASA, CP, AM, Dem, PB, GB, MIC, MIP";
	$request .= " from ".TABLE_USER_DEFENCE;
	$request .= " where user_id = ".$user_data["user_id"];
	$request .= " order by planet_id";
	$result = $db->sql_query($request);	
	$user_defence = array_fill(1, 18, $defence);
	while ($row = $db->sql_fetch_assoc($result)) {
		$planet_id = $row["planet_id"];
		unset($row["planet_id"]);
		$user_defence[$planet_id] = $row;
	}

	return array("building" => $user_building, "technology" => $user_technology, "defence" => $user_defence, );
}
/**
* Suppression des données de batiments de l'utilisateur loggé
*/
function user_del_building() {
	global $db, $user_data;
	global $pub_planet_id, $pub_view;

	if (!check_var($pub_planet_id, "Num")) {
		redirection("index.php?action=message&id_message=errordata&info");
	}
	if (!isset($pub_planet_id)) {
		redirection("index.php?action=message&id_message=errorfatal&info");
	}

	$request = "delete from ".TABLE_USER_BUILDING." where user_id = ".$user_data["user_id"]." and planet_id = ".intval($pub_planet_id);
	$db->sql_query($request);

	$request = "delete from ".TABLE_USER_DEFENCE." where user_id = ".$user_data["user_id"]." and planet_id = ".intval($pub_planet_id);
	$db->sql_query($request);

	$request = "select * from ".TABLE_USER_BUILDING." where planet_id <= 9";
	$result = $db->sql_query($request);
	if ($db->sql_numrows($result) == 0) {
		$request = "delete from ".TABLE_USER_TECHNOLOGY." where user_id = ".$user_data["user_id"];
		$db->sql_query($request);
	}

	redirection("index.php?action=home&subaction=empire&view=".$pub_view);
}
/**
* Déplacement des données de planète de la page empire
*/
function user_move_empire() {
	global $db, $user_data;
	global $pub_planet_id, $pub_left, $pub_right;

	if (!check_var($pub_planet_id, "Num")) {
		redirection("index.php?action=message&id_message=errordata&info");
	}
	if (!isset($pub_planet_id) || (!isset($pub_left) && !isset($pub_right))) {
		redirection("index.php?action=message&id_message=errorfatal&info");
	}

	$pub_planet_id = intval($pub_planet_id);
	if ($pub_planet_id < 1 || $pub_planet_id > 9) {
		redirection("index.php?action=message&id_message=errorfatal&info");
	}
	if (isset($pub_left)) {
		if ($pub_planet_id == 1) redirection("index.php?action=home&subaction=empire");
		$new_position = $pub_planet_id-1;
	}
	elseif (isset($pub_right)) {
		if ($pub_planet_id == 9) redirection("index.php?action=home&subaction=empire");
		$new_position = $pub_planet_id+1;
	}

	$request = "update ".TABLE_USER_BUILDING." set planet_id = -".$new_position." where user_id = ".$user_data["user_id"]." and planet_id = ".$pub_planet_id;
	$db->sql_query($request);

	$request = "update ".TABLE_USER_BUILDING." set planet_id = ".$pub_planet_id." where user_id = ".$user_data["user_id"]." and planet_id = ".$new_position;
	$db->sql_query($request);

	$request = "update ".TABLE_USER_BUILDING." set planet_id = ".$new_position." where user_id = ".$user_data["user_id"]." and planet_id = -".$new_position;
	$db->sql_query($request);


	$request = "update ".TABLE_USER_DEFENCE." set planet_id = -".$new_position." where user_id = ".$user_data["user_id"]." and planet_id = ".$pub_planet_id;
	$db->sql_query($request);

	$request = "update ".TABLE_USER_DEFENCE." set planet_id = ".$pub_planet_id." where user_id = ".$user_data["user_id"]." and planet_id = ".$new_position;
	$db->sql_query($request);

	$request = "update ".TABLE_USER_DEFENCE." set planet_id = ".$new_position." where user_id = ".$user_data["user_id"]." and planet_id = -".$new_position;
	$db->sql_query($request);

	//Remise en ordre des lunes selon la position des planètes
	user_set_all_empire_resync();

	redirection("index.php?action=home&subaction=empire");
}

/**
* Ajout d'un système favori
*/
function user_add_favorite() {
	global $db, $user_data, $server_config;
	global $pub_galaxy, $pub_system;

	if (!isset($pub_galaxy) || !isset($pub_system)) {
		redirection("index.php");
	}
	if (intval($pub_galaxy) < 1 || intval($pub_galaxy) > intval($server_config['num_of_galaxies']) || intval($pub_system) < 1 || intval($pub_system) > intval($server_config['num_of_systems'])) {
		redirection("index.php?action=galaxy");
	}

	$request = "select * from ".TABLE_USER_FAVORITE." where user_id = ".$user_data["user_id"];
	$result = $db->sql_query($request);
	$nb_favorites = $db->sql_numrows($result);

	if ($nb_favorites < $server_config["max_favorites"]) {
		$request = "insert ignore into ".TABLE_USER_FAVORITE." (user_id, galaxy, system) values (".$user_data["user_id"].", '".$pub_galaxy."', ".$pub_system.")";
		$db->sql_query($request);
		redirection("index.php?action=galaxy&galaxy=".$pub_galaxy."&system=".$pub_system);
	}
	else {
		redirection("index.php?action=message&id_message=max_favorites&info");
	}
}

/**
* Suppression d'un système favori
*/
function user_del_favorite() {
	global $db, $user_data;
	global $pub_galaxy, $pub_system, $server_config;

	if (!isset($pub_galaxy) || !isset($pub_system)) {
		redirection("index.php");
	}
	if (intval($pub_galaxy) < 1 || intval($pub_galaxy) > intval($server_config['num_of_galaxies']) || intval($pub_system) < 1 || intval($pub_system) > intval($server_config['num_of_systems'])) {
		redirection("index.php?action=galaxy");
	}
	$request = "delete from ".TABLE_USER_FAVORITE." where user_id = ".$user_data["user_id"]." and galaxy = '".$pub_galaxy."' and system = ".$pub_system;
	$db->sql_query($request);

	redirection("index.php?action=galaxy&galaxy=".$pub_galaxy."&system=".$pub_system."");
}

/**
* Récupération des rapports favoris
*/
function user_getfavorites_spy() {
	global $db, $user_data;
	global $sort, $sort2;

	if (!isset($sort) || !isset($sort2) || !is_numeric($sort) || !is_numeric($sort2)) {
		$orderby = "datadate desc";
	}
	else {
		switch ($sort2)	{
			case 0: $order .= " desc"; break;
			case 1: $order .= " asc"; break;
			default: $order .= " asc";
		}

		switch ($sort) {
			case 1:	$orderby = "spy_galaxy ".$order.", spy_system".$order.", spy_row".$order.""; break;
			case 2:	$orderby = "ally ".$order; break;
			case 3:	$orderby = "player ".$order; break;
			case 4:	$orderby = "moon ".$order; break;
			case 5:	$orderby = "datadate ".$order; break;
			default: $orderby = "datadate ".$order;
		}
	}

	$favorite = array();

	$request = "select ".TABLE_USER_SPY.".spy_id, spy_galaxy, spy_system, spy_row, datadate, sender_id, ".TABLE_UNIVERSE.".moon, ".TABLE_UNIVERSE.".ally, ".TABLE_UNIVERSE.".player, ".TABLE_UNIVERSE.".status";
	$request .= " from ".TABLE_SPY.", ".TABLE_USER_SPY.", ".TABLE_UNIVERSE;
	$request .= " where user_id = ".$user_data["user_id"]." and ".TABLE_UNIVERSE.".galaxy=spy_galaxy and ".TABLE_UNIVERSE.".system=spy_system and ".TABLE_UNIVERSE.".row=spy_row and ".TABLE_USER_SPY.".spy_id=".TABLE_SPY.".spy_id";
	$request .= " order by ".$orderby;
	$result = $db->sql_query($request);

	while (list($spy_id, $spy_galaxy, $spy_system, $spy_row, $datadate, $sender_id, $moon, $ally, $player, $status) = $db->sql_fetch_row($result)) {
		$request = "select user_name from ".TABLE_USER;
		$request .= " where user_id=".$sender_id;
		$result_2 = $db->sql_query($request);
		list($user_name) = $db->sql_fetch_row($result_2);
		$favorite[$spy_id] = array("spy_id" => $spy_id, "spy_galaxy" => $spy_galaxy, "spy_system" => $spy_system, "spy_row" => $spy_row, "player" => $player, "ally" => $ally, "moon" => $moon, "status" => $status, "datadate" => $datadate, "poster" => $user_name);
	}

	return $favorite;
}

/**
* Ajout d'un rapport favori
*/
function user_add_favorite_spy() {
	global $db, $user_data, $server_config;
	global $pub_spy_id, $pub_galaxy, $pub_system, $pub_row;

	if (!check_var($pub_spy_id, "Num")) {
		redirection("index.php?action=message&id_message=errordata&info");
	}

	if (!isset($pub_spy_id)) {
		redirection("index.php?action=message&id_message=errorfatal&info");
	}

	$request = "select * from ".TABLE_USER_SPY." where user_id = ".$user_data["user_id"];
	$result = $db->sql_query($request);
	$nb_favorites = $db->sql_numrows($result);

	if ($nb_favorites < $server_config["max_favorites_spy"]) {
		$request = "insert ignore into ".TABLE_USER_SPY." (user_id, spy_id) values (".$user_data["user_id"].", ".$pub_spy_id.")";
		$db->sql_query($request);
		redirection("index.php?action=show_reportspy&galaxy=".$pub_galaxy."&system=".$pub_system."&row=".$pub_row);
	}
	else {
		redirection("index.php?action=message&id_message=max_favorites&info=_spy");
	}
}

/**
* Suppression d'un rapport favori
*/
function user_del_favorite_spy() {
	global $db, $user_data;
	global $pub_spy_id, $pub_galaxy, $pub_system, $pub_row, $pub_info;

	if (!check_var($pub_spy_id, "Num")) {
		redirection("index.php?action=message&id_message=errordata&info");
	}

	if (!isset($pub_spy_id)) {
		redirection("index.php?action=message&id_message=errorfatal&info");
	}

	$request = "delete from ".TABLE_USER_SPY." where user_id = ".$user_data["user_id"]." and spy_id = '".$pub_spy_id."'";
	$db->sql_query($request);

	if (!isset($pub_info)) $pub_info = 1;

	switch($pub_info) {
		case 2: redirection("index.php?action=show_reportspy&galaxy=".$pub_galaxy."&system=".$pub_system."&row=".$pub_row);
		case 1: redirection("index.php?action=home&subaction=spy");
		default: return true;
	}
}

/**
* Création d'un groupe
*/
function usergroup_create() {
	global $db, $user_data;
	global $pub_groupname;

	if (!isset($pub_groupname)) {
		redirection("index.php?action=message&id_message=createusergroup_failed_general&info");
	}

	//Vérification des droits
	user_check_auth("usergroup_manage");

	if (!check_var($pub_groupname, "Pseudo_Groupname")) {
		redirection("index.php?action=message&id_message=createusergroup_failed_groupname&info");
	}

	$request = "select group_id from ".TABLE_GROUP." where group_name = '".mysql_real_escape_string($pub_groupname)."'";
	$result = $db->sql_query($request);

	if ($db->sql_numrows($result) == 0) {
		$request = "insert into ".TABLE_GROUP." (group_name)".
		" values ('".mysql_real_escape_string($pub_groupname)."')";
		$db->sql_query($request);
		$group_id = $db->sql_insertid();

		log_("create_usergroup", $pub_groupname);
		redirection("index.php?action=administration&subaction=group&group_id=".$group_id);
	}
	else {
		redirection("index.php?action=message&id_message=createusergroup_failed_groupnamelocked&info=".$pub_groupname);
	}
}

/**
* Suppression d'un groupe utilisateur
*/
function usergroup_delete() {
	global $db, $user_data;
	global $pub_group_id;

	if (!check_var($pub_group_id, "Num")) {
		redirection("index.php?action=message&id_message=errordata&info");
	}

	if (!isset($pub_group_id)) {
		redirection("index.php?action=message&id_message=createusergroup_failed_general&info");
	}

	//Vérification des droits
	user_check_auth("usergroup_manage");

	if ($pub_group_id == 1) {
		redirection("index.php?action=administration&subaction=group&group_id=1");
	}

	log_("delete_usergroup", $pub_group_id);

	$request = "delete from ".TABLE_USER_GROUP." where group_id = ".intval($pub_group_id);
	$db->sql_query($request);

	$request = "delete from ".TABLE_GROUP." where group_id = ".intval($pub_group_id);
	$db->sql_query($request);

	redirection("index.php?action=administration&subaction=group");
}

/**
* Récupération des droits d'un groupe d'utilisateurs
*/
function usergroup_get($group_id = false) {
	global $db, $user_data;

	//Vérification des droits
	user_check_auth("usergroup_manage");

	$request = "select group_id, group_name, ";
	$request .= " server_set_system, server_set_spy, server_set_rc, server_set_ranking, server_show_positionhided,";
	$request .= " ogs_connection, ogs_set_system, ogs_get_system, ogs_set_spy, ogs_get_spy, ogs_set_ranking, ogs_get_ranking";
	$request .= " from ".TABLE_GROUP;

	if ($group_id !== false) {
		if (intval($group_id) == 0) return false;
		$request .= " where group_id = ".$group_id;
	}
	$request .= " order by group_name";
	$result = $db->sql_query($request);

	if (!$group_id) {
		$info_usergroup = array();
		while ($row = $db->sql_fetch_assoc()){
			$info_usergroup[] = $row;
		}
	}
	else {
		while ($row = $db->sql_fetch_assoc()){
			$info_usergroup = $row;
		}
	}

	if (sizeof($info_usergroup) == 0) {
		return false;
	}

	return $info_usergroup;
}
/**
* Enregistrement des droits d'un groupe utilisateurs
*/
function usergroup_setauth() {
	global $db, $user_data;
	global $pub_group_id, $pub_group_name,
	$pub_server_set_system, $pub_server_set_spy, $pub_server_set_rc, $pub_server_set_ranking, 
	$pub_server_show_positionhided, $pub_ogs_connection, $pub_ogs_set_system, $pub_ogs_get_system, 
	$pub_ogs_set_spy, $pub_ogs_get_spy, $pub_ogs_set_ranking, $pub_ogs_get_ranking;

	if (!check_var($pub_group_id, "Num") || !check_var($pub_group_name, "Pseudo_Groupname") ||
	!check_var($pub_server_set_system, "Num") || !check_var($pub_server_set_spy, "Num") || 
	!check_var($pub_server_set_rc, "Num") || !check_var($pub_server_set_ranking, "Num") ||
	!check_var($pub_server_show_positionhided, "Num") || !check_var($pub_ogs_connection, "Num") || 
	!check_var($pub_ogs_set_system, "Num") || !check_var($pub_ogs_get_system, "Num") || 
	!check_var($pub_ogs_set_spy, "Num") || !check_var($pub_ogs_get_spy, "Num") ||
	!check_var($pub_ogs_set_ranking, "Num") || !check_var($pub_ogs_get_ranking, "Num")) {
		redirection("index.php?action=message&id_message=errordata&info");
	}

	if (!isset($pub_group_id) || !isset($pub_group_name)) {
		redirection("index.php?action=message&id_message=errorfatal&info");
	}
	
	if (is_null($pub_server_set_system)) $pub_server_set_system = 0;
	if (is_null($pub_server_set_spy)) $pub_server_set_spy = 0;
	if (is_null($pub_server_set_rc)) $pub_server_set_rc = 0;
	if (is_null($pub_server_set_ranking)) $pub_server_set_ranking = 0;
	if (is_null($pub_server_show_positionhided)) $pub_server_show_positionhided = 0;
	if (is_null($pub_ogs_connection)) $pub_ogs_connection = 0;
	if (is_null($pub_ogs_set_system)) $pub_ogs_set_system = 0;
	if (is_null($pub_ogs_get_system)) $pub_ogs_get_system = 0;
	if (is_null($pub_ogs_set_spy)) $pub_ogs_set_spy = 0;
	if (is_null($pub_ogs_get_spy)) $pub_ogs_get_spy = 0;
	if (is_null($pub_ogs_set_ranking)) $pub_ogs_set_ranking = 0;
	if (is_null($pub_ogs_get_ranking)) $pub_ogs_get_ranking = 0;

	//Vérification des droits
	user_check_auth("usergroup_manage");

	log_("modify_usergroup", $pub_group_id);

	$request = "update ".TABLE_GROUP;
	$request .= " set group_name = '".mysql_real_escape_string($pub_group_name)."',";
	$request .= " server_set_system = '".intval($pub_server_set_system)."', server_set_spy = '".intval($pub_server_set_spy)."', server_set_rc = '".intval($pub_server_set_rc)."', server_set_ranking = '".intval($pub_server_set_ranking)."', server_show_positionhided = '".intval($pub_server_show_positionhided)."',";
	$request .= " ogs_connection = '".intval($pub_ogs_connection)."', ogs_set_system = '".intval($pub_ogs_set_system)."', ogs_get_system = '".intval($pub_ogs_get_system)."', ogs_set_spy = '".intval($pub_ogs_set_spy)."', ogs_get_spy = '".intval($pub_ogs_get_spy)."', ogs_set_ranking = '".intval($pub_ogs_set_ranking)."', ogs_get_ranking = '".intval($pub_ogs_get_ranking)."'";
	$request .= " where group_id = ".intval($pub_group_id);
	$db->sql_query($request);

	redirection("index.php?action=administration&subaction=group&group_id=".$pub_group_id);
}

/**
* Récupération des utilisateurs appartenant à un groupe
* @param int $group_id Identificateur du groupe demandé
* @return Array Liste des utilisateurs
*/
function usergroup_member($group_id) {
	global $db, $user_data;

	if (!isset($group_id) || !is_numeric($group_id)) {
		redirection("index.php?action=message&id_message=errorfatal&info");
	}

	$usergroup_member = array();

	$request = "select u.user_id, user_name from ".TABLE_USER." u, ".TABLE_USER_GROUP." g";
	$request .= " where u.user_id = g.user_id";
	$request .= " and group_id = ".intval($group_id);
	$request .= " order by user_name";
	$result = $db->sql_query($request);
	while ($row = $db->sql_fetch_assoc()) {
		$usergroup_member[] = $row;
	}

	return $usergroup_member;
}

/**
* Ajout d'un utilisateur à un groupe
*/
function usergroup_newmember() {
	global $db, $user_data;
	global $pub_user_id, $pub_group_id, $pub_add_all;
	
	if ($pub_add_all == "Ajouter tout les membres") {
		$request = "SELECT user_id FROM ".TABLE_USER;
		$result = $db->sql_query($request);
	
		while ($res = $db->sql_fetch_assoc($result)) {
			user_check_auth("usergroup_manage");		
			$request = "INSERT IGNORE INTO ".TABLE_USER_GROUP." (group_id, user_id) values (".intval($pub_group_id).", ".intval($res["user_id"]).")";
			$db->sql_query($request);
		}
		redirection("index.php?action=administration&subaction=group");
	}
	else {
		if (!check_var($pub_user_id, "Num") || !check_var($pub_group_id, "Num")) {
			redirection("index.php?action=message&id_message=errordata&info");
		}

		if (!isset($pub_user_id) || !isset($pub_group_id)) {
			redirection("index.php?action=message&id_message=errorfatal&info");
		}

		//Vérification des droits
		user_check_auth("usergroup_manage");
		
			$request = "select group_id from ".TABLE_GROUP." where group_id = ".intval($pub_group_id);
			$result = $db->sql_query($request);
			if ($db->sql_numrows($result) == 0) {
				redirection("index.php?action=administration&subaction=group");
			}

			$request = "select user_id from ".TABLE_USER." where user_id = ".intval($pub_user_id);
			$result = $db->sql_query($request);
			if ($db->sql_numrows($result) == 0) {
				redirection("index.php?action=administration&subaction=group");
			}

			$request = "insert ignore into ".TABLE_USER_GROUP." (group_id, user_id) values (".intval($pub_group_id).", ".intval($pub_user_id).")";
			$result = $db->sql_query($request);

			if ($db->sql_affectedrows() > 0) {
				log_("add_usergroup", array($pub_group_id, $pub_user_id));
			}

			redirection("index.php?action=administration&subaction=group&group_id=".$pub_group_id);
	}
}

/**
* Supression d'un utilisateur d'un groupe
* @global int $pub_user_id Identificateur utilisateur
* @global int $pub_group_id Identificateur du Groupe
*/
function usergroup_delmember() {
	global $db, $user_data;
	global $pub_user_id, $pub_group_id;

	if (!isset($pub_user_id) || !isset($pub_group_id)) {
		redirection("index.php?action=message&id_message=errorfatal&info");
	}
	if (!check_var($pub_user_id, "Num") || !check_var($pub_group_id, "Num")) {
		redirection("index.php?action=message&id_message=errordata&info");
	}

	//Vérification des droits
	user_check_auth("usergroup_manage");

	$request = "delete from ".TABLE_USER_GROUP." where group_id = ".intval($pub_group_id)." and user_id = ".intval($pub_user_id);
	$result = $db->sql_query($request);

	if ($db->sql_affectedrows() > 0) {
		log_("del_usergroup", array($pub_group_id, $pub_user_id));
	}

	redirection("index.php?action=administration&subaction=group&group_id=".$pub_group_id);
}

/**
* A quoi sert donc cette fonction ? :p
*/
function user_set_stat_name($user_stat_name) {
	global $db, $user_data;

	$request = "update ".TABLE_USER." set user_stat_name = '".$user_stat_name."' where user_id = ".$user_data['user_id'];
	$db->sql_query($request);
}

//Suppression d'un rapport d'espionnage
function user_del_spy() {
	global $db, $user_data;
	global $pub_spy_id, $pub_galaxy, $pub_system, $pub_row, $pub_info;

	if (!check_var($pub_spy_id, "Num")) {
		redirection("index.php?action=message&id_message=errordata&info");
	}

	if (!isset($pub_spy_id)) {
		redirection("index.php?action=message&id_message=errorfatal&info");
	}

	if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1)
	{
    	$request = "delete from ".TABLE_SPY." where spy_id = '".$pub_spy_id."'";
	    $db->sql_query($request);
	}

	if (!isset($pub_info)) $pub_info = 1;

	switch($pub_info) {
		case 2: redirection("index.php?action=show_reportspy&galaxy=".$pub_galaxy."&system=".$pub_system."&row=".$pub_row);
		case 1: redirection("index.php?action=home&subaction=spy");
		default: return true;
	}
}

/**
* Parsing des RC
* @param string $rawRC RC à parser
* @return int $return identifiant du RC
*/
function parseRC ( $rawRC )
{
  // Suppression des '\', et gestion des retours charriots/sauts de ligne
  $rawRC = str_replace ( '\\', '', ereg_replace ( "\n|\r|\r\n", " \n", $rawRC ) );
  // Suppression des '.' dans les nombres
  $rawRC = preg_replace ( '/(\d+)\.(\d+)/', "$1$2", $rawRC );
  $return = array ( 
    'dateRC' => '',
    'nb_rounds' => 0,
    'attaquants' => array (),
    'defenseur' => array (),
    'victoire' => 'A',
    'pertes_A' => 0,
    'pertes_D' => 0,
    'gain_M' => -1,
    'gain_C' => -1,
    'gain_D' => -1,
    'debris_M' => -1,
    'debris_C' => -1,
    'lune' => 0,
    'coordinates' => '1:1:1');

  // Extraction du timestamp pour la date du RC
  preg_match ( '/affrontées le (\d*)-(\d*) (\d*):(\d*):(\d*) \.:/', $rawRC, $reg );
  $jourRC = trim ( $reg[2] );
  $moisRC = trim ( $reg[1] );
  $heureRC = trim ( $reg[3] );
  $minutesRC = trim ( $reg[4] );
  $secondesRC = trim ( $reg[5] );
  $return['dateRC'] = mktime ( $heureRC, $minutesRC, $secondesRC, $moisRC, $jourRC, date ( 'Y' ) );

  // Extraction du nom, des coordonnées et des techs de l'attaquant et du défenseur
  $opponents = array();
  preg_match_all ( '/Attaquant (.*) \(\[(.*)\]\)(\s*)Armes: (\d*)% Bouclier: (\d*)% Coque: (\d*)%/', $rawRC, $reg );
  for ( $idx = 0; $idx < sizeof ( $reg[0] ); $idx++ )
  {
    $return['attaquants'][] = array ( 
      'pseudo' =>$reg[1][$idx], 
      'coordinates' => $reg[2][$idx], 
      'armes' => $reg[4][$idx], 
      'bouclier' => $reg[5][$idx], 
      'protection' => $reg[6][$idx] );
    $opponents[] = $reg[1][$idx];
  }
  preg_match_all ( '/D.fenseur (.*) \(\[(.*)\]\)(\s*)Armes: (\d*)% Bouclier: (\d*)% Coque: (\d*)%/', $rawRC, $reg );
  for ( $idx = 0; $idx < sizeof ( $reg[0] ); $idx++ )
  {
    if ( $idx == 0 ) $return['coordinates'] = $reg[2][$idx];
    $return['defenseurs'][] = array ( 
      'pseudo' => $reg[1][$idx], 
      'coordinates' => $reg[2][$idx], 
      'armes' => $reg[4][$idx], 
      'bouclier' => $reg[5][$idx], 
      'protection' => $reg[6][$idx] );
    $opponents[] = $reg[1][$idx];
  }

  // Comptage du nombre de roungs
  $return['nb_rounds'] = substr_count ( $rawRC, 'attaquante tire' ) + 1;

  // Extraction des pertes
  preg_match ( '/L\'attaquant a perdu au total (\d*) unit.s/', $rawRC, $reg );
  $return['pertes_A'] = trim ( $reg[1] );
  preg_match ( '/Le d.fenseur a perdu au total (\d*) unit.s/', $rawRC, $reg );
  $return['pertes_D'] = trim ( $reg[1] );

  // Extraction du champ de débris et du pourcentage de lune
  preg_match ( '/Un champ de d.bris contenant (\d*) unit.s de m.tal et (\d*) unit.s de Silicium(.*)/', $rawRC, $reg );
  $return['debris_M'] = trim ( $reg[1] );
  $return['debris_C'] = trim ( $reg[2] );
  if ( preg_match ( '/une lune est de (\d*)( ?)%/', $rawRC, $reg ) )
    $return['lune'] = trim ( $reg[1] );

  // Extraction du résultat du RC
  // A = victoire de l'attaquant
  // D = victoire du défenseur
  // N = match nul
  if ( preg_match ( '/L\'attaquant a gagn. la bataille/', $rawRC ) )
  {
    $return['victoire'] = 'A';
    // Extraction des ressources gagnées
    preg_match ( '/(\d*) unit.s de m.tal, (\d*) unit.s de Silicium et (\d*) unit.s de deut.rium/', $rawRC, $reg );
    $return['gain_M'] = trim ( $reg[1] );
    $return['gain_C'] = trim ( $reg[2] );
    $return['gain_D'] = trim ( $reg[3] );
  }
  elseif ( preg_match ( '/Le d.fenseur a gagn. la bataille/', $rawRC ) )
    $return['victoire'] = 'D';
  else
    $return['victoire'] = 'N';

  $tmp = parseRCround ( $rawRC, $return['nb_rounds'], $opponents, $return['victoire'] );
  
  $idx = 1;
  foreach ( $tmp as $array )
  {
    $return['round'.$idx] = $array;
    $idx++;
  }

  return $return;
}

/**
* Parsing de chaque round des RC
* @param string $rawRC RC à analyser
* @param int $nb_rounds Nombre de round du RC à analyser
* @param array $opponents Tableau contenant le nom de chaque joueur du RC
* @return array $row_RC Tableau contenant pour chaque round du RC, les flottes/défenses de chaque joueur
*/
function parseRCround ( $rawRC, $nb_rounds, $opponents, $victoire )
{
  $rawRC = preg_replace ( "/ \n/", '|', $rawRC );
  $row_RC = array();
  $row_RC_opponent = array (
    'P.transp.' => -1,
    'G.transp.' => -1,
    'Ch.léger' => -1,
    'Ch.lourd' => -1,
    'Croiseur' => -1,
    'V.bataille' => -1,
    'V.colonisation' => -1,
    'Recycleur' => -1,
    'Sonde' => -1,
    'Bombardier' => -1,
    'Destr.' => -1,
    'Rip' => -1,
    'sat.sol.' => -1,
    'Traqueur' => -1,
    'Missile' => -1,
    'L.léger.' => -1,
    'L.lourd' => -1,
    'Can.Gauss' => -1,
    'Art.ions' => -1,
    'Lanc.plasma' => -1,
    'P.bouclier' => -1,
    'G.bouclier' => -1,
  );

  $decoupe = explode ( 'points de dégâts||', $rawRC );
  for ( $idx_round = 0; $idx_round < $nb_rounds; $idx_round++ )
  {
    $row_RC[$idx_round] = array();
    for ( $idx_opp = 0; $idx_opp < sizeof ( $opponents ); $idx_opp++ )
    {
      $row_RC[$idx_round][$opponents[$idx_opp]] = $row_RC_opponent;
      $pattern = '/' . $opponents[$idx_opp] . ' \(\[.*?\]\)\|(Armes: \d*% Bouclier: \d*% Coque: \d*%\|)?Type[ \t](.*?)\|Nombre[ \t](.*?)\|/';
      preg_match ( $pattern, $decoupe[$idx_round], $reg );
      if ( isset ( $reg[2] ) )
      {
        $flotte = split ( "[ \t]", chop ( $reg[2] ) );
        $nombre = split ( "[ \t]", chop ( $reg[3] ) );
        foreach ( $flotte as $key => $val )
          $row_RC[$idx_round][$opponents[$idx_opp]][$val] = $nombre[$key];
      }
    }
    if ( $idx_round < $nb_rounds )
    {
      preg_match ( '/La flotte attaquante tire (\d*) fois avec une puissance totale de (-?\d*) sur le d.fenseur. Les boucliers du d.fenseur absorbent (\d*) points de d.g.ts/', $decoupe[$idx_round], $reg );
      if ( isset ( $reg[1] ) )
      {
        $row_RC[$idx_round]['attaque_tir'] = $reg[1];
        $row_RC[$idx_round]['attaque_puissance'] = $reg[2];
        $row_RC[$idx_round]['defense_bouclier'] = $reg[3];
      }
      else
      {
        $row_RC[$idx_round]['attaque_tir'] = 0;
        $row_RC[$idx_round]['attaque_puissance'] = 0;
        $row_RC[$idx_round]['defense_bouclier'] = 0;
      }
      preg_match ( "/La flotte d.fensive tire au total (\d*) fois avec une puissance totale de (-?\d*) sur l'attaquant. Les boucliers de l'attaquant absorbent (\d*)/", $decoupe[$idx_round], $reg );
      if ( isset ( $reg[1] ) )
      {
        $row_RC[$idx_round]['attaque_bouclier'] = $reg[3];
        $row_RC[$idx_round]['defense_tir'] = $reg[1];
        $row_RC[$idx_round]['defense_puissance'] = $reg[2];
      }
      else
      {
        $row_RC[$idx_round]['attaque_bouclier'] = 0;
        $row_RC[$idx_round]['defense_tir'] = 0;
        $row_RC[$idx_round]['defense_puissance'] = 0;
      }
    }
  }

  return ( $row_RC );
}

/**
* Reconstruction des RC
* @global $db
* @param int $id_RC RC à reconstituer
* @return string $template_RC reconstitué
*/
function UNparseRC ( $id_RC )
{
  global $db;

  $key_ships = array ( 'PC' => 'Petit cargo', 'GC' => 'Grand cargo', 'CHA' => 'Chasseur', 'CHABL' => 'Chasseur blindé', 
    'FREG' => 'Frégate', 'VC' => 'Vaisseau de combat', 'COLO' => 'Colonisateur', 'REC' => 'Recycleur', 
    'DRO' => 'Drone', 'TORP' => 'Torpilleur', 'LEV' => 'Leviathan.', 'ECNO' => 'Eclipse noire', 'ReSo' => 'Réflecteur');
  $key_defs = array ( 'CA' => 'C.automatique', 'LLE' => 'L.léger.', 'LLO' => 'L.lourd', 'CG' => 'Can.Gauss', 
    'AI' => 'Art.ions', 'LP' => 'Lanc.plasma', 'PB' => 'P.bouclier', 'GB' => 'Grand bouclier' );
  $base_ships = array ('PC' => array ( 400, 10, 5 ), 'GC' => array ( 1200, 25 , 5 ),
	'CHA' => array (250, 10, 50 ), 'CHABL' => array ( 550, 25, 150 ), 'FREG' => array ( 2700, 50, 400 ),
	'VC' => array (5000, 200, 1000 ), 'COLO' => array ( 3000, 100, 50 ), 'REC' => array ( 1600, 10, 1 ),
	'DRO' => array (100, 0.01, 0.01 ), 'TORP' => array ( 9000, 700, 1000 ), 'LEV' => array ( 14000, 750, 2500 ),
	'ECNO' => array (1000000, 100000, 200000 ), 'ReSo' => array ( 200, 1, 1 ));
	
  $base_defs = array ( 'CA' => array ( 2000, 20 , 80 ), 'LLE' => array ( 2000, 25, 100 ),
	'LLO' => array ( 8000, 100, 250 ), 'CG' => array ( 35000, 200, 1100 ), 'AI' => array ( 8000, 500, 150 ),
	'LP' => array ( 100000, 300, 3000 ), 'PB' => array ( 20000, 2000, 1 ), 'GB' => array ( 100000, 10000, 1 ) );

  // Récupération des constantes du RC
  $query = 'SELECT dateRC, coordinates, nb_rounds, victoire, pertes_A, pertes_D, gain_M, gain_C, 
    gain_D, debris_M, debris_C, lune FROM ' . TABLE_PARSEDRC . ' WHERE id_rc = ' . $id_RC;
  $result = $db->sql_query ( $query );
  list ( $dateRC, $coordinates, $nb_rounds, $victoire, $pertes_A, $pertes_D, $gain_M, $gain_C, $gain_D, 
    $debris_M, $debris_C, $lune ) = $db->sql_fetch_row ( $result );
  $dateRC = date ( 'd-m-Y H:i:s', $dateRC );
  $template = 'Les flottes suivantes se sont affrontées le ' . $dateRC . ' aux coordonnées ' . $coordinates . " :\n\n";
  
  // Récupération de chaque round du RC
  for ( $idx = 1; $idx <= $nb_rounds; $idx++ )
  {
    $query = 'SELECT id_rcround, attaque_tir, attaque_puissance, attaque_bouclier, defense_tir, 
      defense_puissance, defense_bouclier FROM ' . TABLE_PARSEDRCROUND . ' WHERE id_rc = ' . $id_RC . '
     AND numround = ' . $idx;
    $result_round = $db->sql_query ( $query );
    list ( $id_rcround, $attaque_tir, $attaque_puissance, $attaque_bouclier, $defense_tir, 
      $defense_puissance, $defense_bouclier ) = $db->sql_fetch_row ( $result_round );
    
    // Récupération de chaque attaquant du RC
    $query = 'SELECT player, coordinates, Armes, Bouclier, Blindage, PT, GT, CLE, CLO, CR, VB, VC, REC, 
      SE, BMD, LEV, ECNO, TRA FROM ' . TABLE_ROUND_ATTACK . ' WHERE id_rcround = ' . $id_rcround;
    $result_attack = $db->sql_query ( $query );
    while ( list ( $player, $coordinates, $Armes, $Bouclier, $Blindage, $PT, $GT, $CLE, $CLO, $CR, $VB, 
      $VC, $REC, $SE, $BMD, $LEV, $ECNO, $TRA ) = $db->sql_fetch_row ( $result_attack ) )
    {
      $key = '';
      $ship = 0;
      $vivant_att = false;
      $template .= 'Attaquant ' . $player . ' ([' . $coordinates . '])' . "\n" . 'Armes: ' . $Armes . 
        '% Bouclier: ' . $Bouclier . '% Coque: ' . $Blindage . '%' . "\n";
      $ship_type = 'Type';
      $ship_nombre = 'Nombre';
      $ship_armes = 'Armes';
      $ship_bouclier = 'Bouclier';
      $ship_protection = 'Coque';
      foreach ( $key_ships as $key => $ship )
      {
        if ( isset ( $$key ) && $$key > 0 )
        {
          $vivant_att = true;
          $ship_type .= "\t" . $ship;
          $ship_nombre .= "\t" . $$key;
          $ship_protection .= "\t" . round ( ( $base_ships[$key][0] * ( ( $Blindage / 10 ) * 0.1 + 1 ) ) / 10 );
          $ship_bouclier .= "\t" . round ( $base_ships[$key][1] * ( ( $Bouclier /10 ) * 0.1 + 1 ) );
          $ship_armes .= "\t" . round ( $base_ships[$key][2] * ( ( $Armes / 10 ) * 0.1 + 1 ) );
        }
      }
      if ( $vivant_att == true )
        $template .= $ship_type . "\n" . $ship_nombre . "\n" . $ship_armes . "\n" . $ship_bouclier . "\n" . $ship_protection . "\n\n";
      else
        $template .= 'Détruit !' . "\n\n";
    }// Fin récupération de chaque attaquant du RC
    
    // Récupération de chaque défenseur du RC
    $query = 'SELECT player, coordinates, Armes, Bouclier, Blindage, PT, GT, CLE, CLO, CR, VB, VC, REC, 
      SE, BMD, LEV, ECNO, TRA, CA, LLE, LLO, CG, AI, LP, PB, GB FROM ' . TABLE_ROUND_DEFENSE . ' WHERE 
      id_rcround = ' . $id_rcround;
    $result_defense = $db->sql_query ( $query );
    while ( list ( $player, $coordinates, $Armes, $Bouclier, $Blindage, $PT, $GT, $CLE, $CLO, $CR, $VB, 
      $VC, $REC, $SE, $BMD, $LEV, $ECNO, $TRA, $CA, $LLE, $LLO, $CG, $AI, $LP, $PB, $GB ) = $db->sql_fetch_row ( $result_defense ) )
    {
      $key = '';
      $ship = 0;
      $vivant_def = false;
      $template .= 'Défenseur ' . $player . ' ([' . $coordinates . '])' . "\n" . 'Armes: ' . $Armes . '% Bouclier: ' . $Bouclier . '% Coque: ' . $Blindage . '%' . "\n";
      $ship_type = 'Type';
      $ship_nombre = 'Nombre';
      $ship_armes = 'Armes';
      $ship_bouclier = 'Bouclier';
      $ship_protection = 'Coque';
      foreach ( $key_ships as $key => $ship )
      {
        if ( isset ( $$key ) && $$key > 0 )
        {
          $vivant_def = true;
          $ship_type .= "\t" . $ship;
          $ship_nombre .= "\t" . $$key;
          $ship_protection .= "\t" . round ( ( $base_ships[$key][0] * ( ( $Blindage / 10 ) * 0.1 + 1 ) ) / 10 );
          $ship_bouclier .= "\t" . round ( $base_ships[$key][1] * ( ( $Bouclier / 10 ) * 0.1 + 1 ) );
          $ship_armes .= "\t" . round ( $base_ships[$key][2] * ( ( $Armes / 10 ) * 0.1 + 1 ) );
        }
      }
      foreach ( $key_defs as $key => $def )
      {
        if ( isset ( $$key ) && $$key > 0 )
        {
          $vivant_def = true;
          $ship_type .= "\t" . $def;
          $ship_nombre .= "\t" . $$key;
          $ship_protection .= "\t" . round ( ( $base_defs[$key][0] * ( ( $Blindage / 10 ) * 0.1 + 1 ) ) / 10 );
          $ship_bouclier .= "\t" . round ( $base_defs[$key][1] * ( ( $Bouclier / 10 ) * 0.1 + 1 ) );
          $ship_armes .= "\t" . round ( $base_defs[$key][2] * ( ( $Armes / 10 ) * 0.1 + 1 ) );
        }
      }
      if ( $vivant_def == true )
        $template .= $ship_type . "\n" . $ship_nombre . "\n" . $ship_armes . "\n" . $ship_bouclier . "\n" . $ship_protection . "\n\n";
      else
        $template .= 'Détruit !' . "\n\n";
    }// Fin récupération de chaque défenseur du RC
    
    // Résultat du round
    if ( $attaque_tir != 0 || $defense_tir != 0 )
    {
      $template .= 'La flotte attaquante tire ' . $attaque_tir . ' fois avec une puissance totale de ' . $attaque_puissance . ' sur le défenseur. Les boucliers du défenseur absorbent ' . $defense_bouclier . ' points de dégâts' . "\n";
      $template .= 'La flotte défensive tire au total ' . $defense_tir . ' fois avec une puissance totale de ' . $defense_puissance . ' sur l\'attaquant. Les boucliers de l\'attaquant absorbent ' . $attaque_bouclier . ' points de dégâts' . "\n\n";
    }
  }// Fin récupération de chaque round du RC

  // Qui a remporté le combat ?
  switch ( $victoire )
  {
    case 'N':
      $template .= 'La bataille se termine par un match nul, les deux flottes rentrent vers leurs planètes respectives.' . "\n\n\n";
      break;
    case 'A':
      $template .= 'L\'attaquant a gagné la bataille !' . "\n" . 'Il emporte' . "\n" . $gain_M . ' unités de métal, ' . $gain_C . ' unités de Silicium et ' . $gain_D . ' unités de deutérium' . "\n\n\n";
      break;
    case 'D':
      $template .= 'Le défenseur a gagné la bataille !' . "\n\n\n";
      break;
  }
  
  // Pertes et champs de débris
  $template .= 'L\'attaquant a perdu au total ' . $pertes_A . ' unités.' . "\n";
  $template .= 'Le défenseur a perdu au total ' . $pertes_D . ' unités.' . "\n";
  $template .= 'Un champ de débris contenant ' . $debris_M . ' unités de métal et ' . $debris_C . ' unités de Silicium se forme dans l\'orbite de cette planète.' . "\n";
  $template .= 'La probabilité de création d\'une lune est de ' . $lune . ' %';
  
  return ( $template );
}

/**
* Enregistrement des RC
* @global $db
* @param string $rawRC RC brut à analyser
*/
function insert_RC ( $rawRC )
{
  global $db;
  $parsedRC = parseRC ( $rawRC );
  $query = 'INSERT IGNORE INTO ' . TABLE_PARSEDRC . '(dateRC, nb_rounds, victoire, pertes_A, pertes_D, 
    gain_M, gain_C, gain_D, debris_M, debris_C, lune, coordinates) VALUES (' . $parsedRC['dateRC'] . ',' . 
    $parsedRC['nb_rounds'] . ',"' . $parsedRC['victoire'] . '",' . $parsedRC['pertes_A'] . ',' . 
    $parsedRC['pertes_D'] . ',' . $parsedRC['gain_M'] . ',' . $parsedRC['gain_C'] . ',' . 
    $parsedRC['gain_D'] . ',' . $parsedRC['debris_M'] . ',' . $parsedRC['debris_C'] . ',' . 
    $parsedRC['lune'] . ',"' . $parsedRC['coordinates'] . '")';
  if ( ! $db->sql_query ( $query ) ) {
    $error = $db->sql_error ( $result );
    error_sql ( $error['message'] );
  }
  $id_RC = $db->sql_insertid();
  for ( $idx_round = 1; $idx_round <= $parsedRC['nb_rounds']; $idx_round++ )
  {
    $round = 'round' . $idx_round;
    log_ ( 'mod', ' enregistre le round ' . $idx_round );
    $query = 'INSERT IGNORE INTO ' . TABLE_PARSEDRCROUND . '(id_rc, numround, attaque_tir, attaque_puissance, 
      attaque_bouclier, defense_tir, defense_puissance, defense_bouclier) VALUES(' . $id_RC . ', ' . 
      $idx_round . ', "' . $parsedRC[$round]['attaque_tir'] . '", "' . $parsedRC[$round]['attaque_puissance'] . 
      '", "' . $parsedRC[$round]['attaque_bouclier'] . '", "' . $parsedRC[$round]['defense_tir'] . '", "' . 
      $parsedRC[$round]['defense_puissance'] . '", "' . $parsedRC[$round]['defense_bouclier'] . '")';
    if ( ! $db->sql_query ( $query ) ) {
      $error = $db->sql_error ( $result );
      error_sql ( $error['message'] );
    }
    $id_parsedround = $db->sql_insertid();
    foreach ( $parsedRC['attaquants'] as $opponent => $row )
    {
      $pseudo = $row['pseudo'];
      $query = 'INSERT IGNORE INTO ' . TABLE_ROUND_ATTACK . '(id_rcround, player, coordinates, Armes, 
        Bouclier, Blindage, PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, LEV, ECNO, TRA) VALUES (' . 
        $id_parsedround . ', "' . $row['pseudo'] . '", "' . $row['coordinates'] . '", ' . $row['armes'] . ', ' .
        $row['bouclier'] . ', ' . $row['protection'] . ', "' . $parsedRC[$round][$pseudo]['P.transp.'] . '", "' . 
        $parsedRC[$round][$pseudo]['G.transp.'] . '", "' . $parsedRC[$round][$pseudo]['Ch.léger'] . '", "' . 
        $parsedRC[$round][$pseudo]['Ch.lourd'] . '", "' . $parsedRC[$round][$pseudo]['Croiseur'] . '", "' . 
        $parsedRC[$round][$pseudo]['V.bataille'] . '", "' . $parsedRC[$round][$pseudo]['V.coloniReSoion'] . '", "' . 
        $parsedRC[$round][$pseudo]['Recycleur'] . '", "' . $parsedRC[$round][$pseudo]['Sonde'] . '", "' . 
        $parsedRC[$round][$pseudo]['Bombardier'] . '", "' . $parsedRC[$round][$pseudo]['Destr.'] . '", "' . 
        $parsedRC[$round][$pseudo]['Rip'] . '", "' . $parsedRC[$round][$pseudo]['Traqueur'] . '")';
      if ( ! $db->sql_query ( $query ) ) {
        $error = $db->sql_error ( $result );
        error_sql ( $error['message'] );
      }
    }
    foreach ( $parsedRC['defenseurs'] as $opponent => $row )
    {
      $pseudo = $row['pseudo'];
      $query = 'INSERT IGNORE INTO ' . TABLE_ROUND_DEFENSE . '(id_rcround, player, coordinates, Armes, 
        Bouclier, Blindage, PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, LEV, ECNO, ReSo, TRA, CA, TLM, ASA, 
        CP, AM, Dem, PB, GB) VALUES (' . $id_parsedround . ', "' . $row['pseudo'] . '", "' . $row['coordinates'] . '", ' . 
        $row['armes'] . ', ' .$row['bouclier'] . ', ' . $row['protection'] . ', "' . 
        $parsedRC[$round][$pseudo]['P.transp.'] . '", "' . $parsedRC[$round][$pseudo]['G.transp.'] . '", "' . 
        $parsedRC[$round][$pseudo]['Ch.léger'] . '", "' . $parsedRC[$round][$pseudo]['Ch.lourd'] . '", "' . 
        $parsedRC[$round][$pseudo]['Croiseur'] . '", "' . $parsedRC[$round][$pseudo]['V.bataille'] . '", "' . 
        $parsedRC[$round][$pseudo]['V.coloniReSoion'] . '", "' . $parsedRC[$round][$pseudo]['Recycleur'] . '", "' . 
        $parsedRC[$round][$pseudo]['Sonde'] . '", "' . $parsedRC[$round][$pseudo]['Bombardier'] . '", "' . 
        $parsedRC[$round][$pseudo]['Destr.'] . '", "' . $parsedRC[$round][$pseudo]['Rip'] . '", "' . 
        $parsedRC[$round][$pseudo]['ReSo.sol.'] . '", "' . $parsedRC[$round][$pseudo]['Traqueur'] . '", "' . 
        $parsedRC[$round][$pseudo]['Missile'] . '", "' . $parsedRC[$round][$pseudo]['L.léger.'] . '", "' . 
        $parsedRC[$round][$pseudo]['L.lourd'] . '", "' . $parsedRC[$round][$pseudo]['Can.Gauss'] . '", "' . 
        $parsedRC[$round][$pseudo]['Art.ions'] . '", "' . $parsedRC[$round][$pseudo]['Lanc.plasma'] . '", "' . 
        $parsedRC[$round][$pseudo]['P.bouclier'] . '", "' . $parsedRC[$round][$pseudo]['G.bouclier'] . '")';
	
      if ( ! $db->sql_query ( $query ) ) {
        $error = $db->sql_error ( $result );
        error_sql ( $error['message'] );
      }
    }
  }
  redirection ( 'index.php' );
}
?>
