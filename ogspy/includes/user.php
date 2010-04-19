<?php
/** $Id$ **/
/**
* Functions relative à l'utilisateur
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

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
		if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_user"] != 1) redirection("?action=message&id_message=forbidden&info");
		break;

		case "user_update" :
		if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_user"] != 1) redirection("?action=message&id_message=forbidden&info");
		$info_user = user_get($user_id);
		if ($info_user === false) redirection("?action=message&id_message=deleteuser_failed&info");
		if (($info_user[0]["user_admin"] == 1 && $user_id != $user_data['user_id'])
		|| ($user_data["user_coadmin"] == 1 && $info_user[0]["user_coadmin"] == 1)
		|| (($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_user"] == 1)
		&& ($info_user[0]["user_coadmin"] == 1 || $info_user[0]["management_user"] == 1))) redirection("?action=message&id_message=forbidden&info");
		break;

		default:
		redirection("?action=message&id_message=errorfatal&info");
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

	if (!check_var($pub_login, "Pseudo_Groupname") || !check_var($pub_password, "Password") || !check_var($pub_goto, "Special", "#^[\w=&%+]+$#")) redirection("?action=message&id_message=errordata&info");

	if (!isset($pub_login) || !isset($pub_password)) redirection("?action=message&id_message=errorfatal&info");
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
				redirection("?action=".$pub_goto);
			}
			else redirection("?action=message&id_message=account_lock&info");
		}
		else redirection("?action=message&id_message=login_wrong&info");
	}
}

/**
 * Déconnection utilisateur
 */
function user_logout() {
	log_("logout");
	session_close();
	redirection("?");
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
	if (strlen($string) < $length_min || strlen($string) > $length_max) return false;

	return $string;
}

/**
 * Modification des droits ogspy d'un utilisateur par l'admin
 */
function admin_user_set() {
	global $user_data;
	global $pub_user_id, $pub_active, $pub_user_coadmin, $pub_management_user, $pub_management_ranking;
	global $pub_asc,$pub_desc;

	if (!check_var($pub_user_id, "Num") || !check_var($pub_active, "Num") || !check_var($pub_user_coadmin, "Num") || !check_var($pub_management_user, "Num") || !check_var($pub_management_ranking, "Num")) redirection("?action=message&id_message=errordata&info");

	if (!isset($pub_user_id) || !isset($pub_active)) redirection("?action=message&id_message=admin_modifyuser_failed&info");

	//Vérification des droits
	user_check_auth("user_update", $pub_user_id);

	if ($user_data["user_admin"] == 1) {
		if (!isset($pub_user_coadmin) || !isset($pub_management_user) || !isset($pub_management_ranking)) redirection("?action=message&id_message=admin_modifyuser_failed&info");
	}
	elseif ($user_data["user_coadmin"] == 1) {
		$pub_user_coadmin = null;
		if (!isset($pub_management_user) || !isset($pub_management_ranking)) redirection("?action=message&id_message=admin_modifyuser_failed&info");
	} else $pub_user_coadmin = $pub_management_user = null;
	if (user_get($pub_user_id) === false) redirection("?action=message&id_message=admin_modifyuser_failed&info");
	user_set_grant($pub_user_id, null, $pub_active, $pub_user_coadmin, $pub_management_user, $pub_management_ranking);

	$order = "";
	if (isset($pub_asc)) $order = "&asc=".$pub_asc;
	if (isset($pub_desc)) $order = "&desc=".$pub_desc;

	redirection("?action=administration&subaction=members".$order);
}

/**
 * Génération d'un mot de passe par l'admin pour un utilisateur
 */
function admin_regeneratepwd() {
	global $user_data;
	global $pub_user_id, $pub_new_pass;
//	$pass_id = "pub_pass_".$pub_user_id;
//	global $$pass_id;
	$new_pass = $pub_new_pass; //$$pass_id;

	if (!check_var($pub_user_id, "Num")) redirection("?action=message&id_message=errordata&info");

	if (!isset($pub_user_id)) redirection("?action=message&id_message=errorfatal&info");

	user_check_auth("user_update", $pub_user_id);

	if (user_get($pub_user_id) === false) redirection("?action=message&id_message=regeneratepwd_failed&info");
	if ($new_pass != "") $password = $new_pass;
	else $password = password_generator();
	user_set_general($pub_user_id, null, $password);

	$info = $pub_user_id.":".$password;
	log_("regeneratepwd", $pub_user_id);
	redirection("?action=message&id_message=regeneratepwd_success&info=".$info);
}

/**
 * Modification du profil par un utilisateur
 */
function member_user_set() {
	global $db, $user_data, $user_technology;
	global $pub_pseudo, $pub_old_password, $pub_new_password, $pub_new_password2, $pub_userlanguage, $pub_galaxy, $pub_system, $pub_row, $pub_skin, $pub_disable_ip_check, $pub_off_amiral, $pub_off_ingenieur, $pub_off_geologue, $pub_off_technocrate, $pub_user_stat_name, $pub_ally_stat_name;

	if (!check_var($pub_pseudo, "Text") || !check_var($pub_old_password, "Text") || !check_var($pub_new_password, "Text") || !check_var($pub_new_password2, "CharNum") || !check_var($pub_galaxy, "Num") || !check_var($pub_system, "Num") || !check_var($pub_row, "Num") || !check_var($pub_skin, "URL") || !check_var($pub_disable_ip_check, "Num")) redirection("?action=message&id_message=errordata&info");

	$user_id = $user_data["user_id"];
	$user_info = user_get($user_id);

	$password_validated = null;
	if (!isset($pub_pseudo) || !isset($pub_old_password) || !isset($pub_new_password) || !isset($pub_new_password2) || !isset($pub_galaxy) || !isset($pub_system) || !isset($pub_skin)) redirection("?action=message&id_message=member_modifyuser_failed&info");

	if ($pub_old_password != "" || $pub_new_password != "" || $pub_new_password2 != "") {
		if ($pub_old_password == "" || $pub_new_password == "" || $pub_new_password != $pub_new_password2) redirection("?action=message&id_message=member_modifyuser_failed_passwordcheck&info");
		if (md5(sha1($pub_old_password)) != $user_info[0]["user_password"]) redirection("?action=message&id_message=member_modifyuser_failed_passwordcheck&info");
		if (!check_var($pub_new_password, "Password")) redirection("?action=message&id_message=member_modifyuser_failed_password&info");
	}

	if (!check_var($pub_pseudo, "Pseudo_Groupname")) redirection("?action=message&id_message=member_modifyuser_failed_pseudo&info");

	// Language utilisateur
	if ($user_data['user_language'] != $pub_userlanguage) $db->sql_query("UPDATE ".TABLE_USER." SET `user_language` = '".$pub_userlanguage."' WHERE `user_id` = ".$user_id);

	//compte amiral
	if ($user_data['off_amiral'] == "0" && $pub_off_amiral == 1) $db->sql_query("UPDATE ".TABLE_USER." SET `off_amiral` = '1' WHERE `user_id` = ".$user_id);
	if ($user_data['off_amiral'] == 1 && (is_null($pub_off_amiral) || $pub_off_amiral != 1)) $db->sql_query("UPDATE ".TABLE_USER." SET `off_amiral` = '0' WHERE `user_id` = ".$user_id);

	//compte ingenieur
	if ($user_data['off_ingenieur'] == "0" && $pub_off_ingenieur == 1) $db->sql_query("UPDATE ".TABLE_USER." SET `off_ingenieur` = '1' WHERE `user_id` = ".$user_id);
	if ($user_data['off_ingenieur'] == 1 && (is_null($pub_off_ingenieur) || $pub_off_ingenieur != 1)) $db->sql_query("UPDATE ".TABLE_USER." SET `off_ingenieur` = '0' WHERE `user_id` = ".$user_id);

	//compte geologue
	if ($user_data['off_geologue'] == "0" && $pub_off_geologue == 1) $db->sql_query("UPDATE ".TABLE_USER." SET `off_geologue` = '1' WHERE `user_id` = ".$user_id);
	if ($user_data['off_geologue'] == 1 && (is_null($pub_off_geologue) || $pub_off_geologue != 1)) $db->sql_query("UPDATE ".TABLE_USER." SET `off_geologue` = '0' WHERE `user_id` = ".$user_id);

	//compte technocrate
	if ($user_data['off_technocrate'] == "0" && $pub_off_technocrate == 1) {
		$db->sql_query("UPDATE ".TABLE_USER." SET `off_technocrate` = '1' WHERE `user_id` = ".$user_id);
		$tech = $user_technology['Esp'] + 2;
		$db->sql_query("UPDATE ".TABLE_USER_TECHNOLOGY." SET `Esp` = ".$tech." WHERE `user_id` = ".$user_id);
	}
	if ($user_data['off_technocrate'] == 1 && (is_null($pub_off_technocrate) || $pub_off_technocrate != 1)) {
		$db->sql_query("UPDATE ".TABLE_USER." SET `off_technocrate` = '0' WHERE `user_id` = ".$user_id);
		$tech = $user_technology['Esp'] - 2;
		$db->sql_query("UPDATE ".TABLE_USER_TECHNOLOGY." SET `Esp` = ".$tech." WHERE `user_id` = ".$user_id);
	}

	//Contrôle que le pseudo ne soit pas déjà utilisé
	$request = "select * from ".TABLE_USER." where user_name = '".mysql_real_escape_string($pub_pseudo)."' and user_id <> ".$user_id;
	$result = $db->sql_query($request);
	if ($db->sql_numrows($result) != 0) redirection("?action=message&id_message=member_modifyuser_failed_pseudolocked&info");

	if (is_null($pub_disable_ip_check) || $pub_disable_ip_check != 1) $pub_disable_ip_check = 0;

	user_set_general($user_id, $pub_pseudo, $pub_new_password, null, $pub_galaxy, $pub_system, $pub_row, $pub_skin, $pub_disable_ip_check, $pub_user_stat_name, $pub_ally_stat_name);
	redirection("?action=profile");
}

/**
 * Entrée en BD de données utilisateurs
 */

function user_set_general($user_id, $user_name = null, $user_password = null, $user_lastvisit = null, $user_galaxy = null, $user_system = null, $user_row = null, $user_skin = null, $disable_ip_check = null, $user_stat_name = null, $ally_stat_name = null) {
	global $db, $user_data, $server_config;

	if (!isset($user_id)) redirection("?action=message&id_message=errorfatal&info");

	if (!empty($user_galaxy)) {
		$user_galaxy = intval($user_galaxy);
		if ($user_galaxy < 1 || $user_galaxy > intval($server_config['num_of_galaxies'])) $user_galaxy = 1;
	}
	if (!empty($user_system)) {
		$user_system = intval($user_system);
		if ($user_system < 1 || $user_system > intval($server_config['num_of_systems'])) $user_system = 1;
	}
	if (!empty($user_row)) {
		$user_row = intval($user_row);
		if ($user_row < 1 || $user_row > 15) $user_row = 1;
	}

	$update = "";

	//Pseudo et mot de passe
	if (!empty($user_name)) $update .= "user_name = '".mysql_real_escape_string($user_name)."'";
	if (!empty($user_password)) $update .= ((strlen($update)>0) ? ", " : "")."user_password = '".md5(sha1($user_password))."'";

	//Galaxy et système solaire du membre
	if (!empty($user_galaxy)) $update .= ((strlen($update)>0) ? ", " : "")."user_galaxy = '".$user_galaxy."'";
	if (!empty($user_system)) $update .= ((strlen($update)>0) ? ", " : "")."user_system = '".$user_system."'";
	if (!empty($user_system)) $update .= ((strlen($update)>0) ? ", " : "")."user_row = '".$user_row."'";

	//Dernière visite
	if (!empty($user_lastvisit)) $update .= ((strlen($update)>0) ? ", " : "")."user_lastvisit = '".$user_lastvisit."'";

	//Skin
	if (!is_null($user_skin)) {
		if (strlen($user_skin) > 0 && substr($user_skin, strlen($user_skin)-1) != "/") $user_skin .= "/";
		$update .= ((strlen($update)>0) ? ", " : "")."user_skin = '".mysql_real_escape_string($user_skin)."'";
	}

	//Pseudo InGame
	if (!is_null($user_stat_name)) $update .= ((strlen($update)>0) ? ", " : "")."user_stat_name = '".mysql_real_escape_string($user_stat_name)."'";
	
	//Ally InGame
	if (!is_null($ally_stat_name)) $update .= ((strlen($update)>0) ? ", " : "")."ally_stat_name = '".mysql_real_escape_string($ally_stat_name)."'";

	//Désactivation de la vérification de l'adresse ip
	if (!is_null($disable_ip_check)) $update .= ((strlen($update)>0) ? ", " : "")."disable_ip_check = '".$disable_ip_check."'";

	$request = "update ".TABLE_USER." set ".$update." where user_id = ".$user_id;
	$db->sql_query($request);

	if ($user_id == $user_data['user_id']) log_("modify_account");
	else log_("modify_account_admin", $user_id);
}

/**
 * Enregistrement des droits et status utilisateurs
 */
function user_set_grant($user_id, $user_admin = null, $user_active = null,
$user_coadmin = null, $management_user = null, $management_ranking = null) {
	global $db, $user_data;

	if (!isset($user_id)) redirection("?action=message&id_message=errorfatal&info");

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
	if (!is_null($user_coadmin) && $user_data['user_admin']!=0) $update .= ((strlen($update)>0) ? ", " : "")."user_coadmin = '".intval($user_coadmin)."'";

	//Gestion des membres
	if (!is_null($management_user)) $update .= ((strlen($update)>0) ? ", " : "")."management_user = '".intval($management_user)."'";

	//Gestion des classements
	if (!is_null($management_ranking)) $update .= ((strlen($update)>0) ? ", " : "")."management_ranking = '".intval($management_ranking)."'";

	$request = "update ".TABLE_USER." set ".$update." where user_id = ".$user_id;
	$db->sql_query($request);

	if ($user_id == $user_data['user_id']) log_("modify_account");
	else log_("modify_account_admin", $user_id);
}

/**
 * Enregistrement des statistiques utilisateurs
 */
function user_set_stat($planet_added_web = null, $planet_added_ogs = null, $search = null, $spy_added_web = null, $spy_added_ogs = null, $rank_added_web = null, $rank_added_ogs = null, $planet_exported = null, $spy_exported = null, $rank_exported = null) {
	global $db, $user_data;

	$update = "";

	//Statistiques envoi systèmes solaires et rapports d'espionnage
	if (!is_null($planet_added_web)) $update .= ((strlen($update)>0) ? ", " : "")."planet_added_web = planet_added_web + ".$planet_added_web;
	if (!is_null($planet_added_ogs)) $update .= ((strlen($update)>0) ? ", " : "")."planet_added_ogs = planet_added_ogs + ".$planet_added_ogs;
	if (!is_null($search)) $update .= ((strlen($update)>0) ? ", " : "")."search = search + ".$search;
	if (!is_null($spy_added_web)) $update .= ((strlen($update)>0) ? ", " : "")."spy_added_web = spy_added_web + ".$spy_added_web;
	if (!is_null($spy_added_ogs)) $update .= ((strlen($update)>0) ? ", " : "")."spy_added_ogs = spy_added_ogs + ".$spy_added_ogs;
	if (!is_null($rank_added_web)) $update .= ((strlen($update)>0) ? ", " : "")."rank_added_web = rank_added_web + ".$rank_added_web;
	if (!is_null($rank_added_ogs)) $update .= ((strlen($update)>0) ? ", " : "")."rank_added_ogs = rank_added_ogs + ".$rank_added_ogs;
	if (!is_null($planet_exported)) $update .= ((strlen($update)>0) ? ", " : "")."planet_exported = planet_exported + ".$planet_exported;
	if (!is_null($spy_exported)) $update .= ((strlen($update)>0) ? ", " : "")."spy_exported = spy_exported + ".$spy_exported;
	if (!is_null($rank_exported)) $update .= ((strlen($update)>0) ? ", " : "")."rank_exported = rank_exported + ".$rank_exported;

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
 
function user_get($user_id = false,$order_by='user_name') {
	global $db,$server_config;
	// Si c'est une ancienne version de bdd, ca peut généré des erreurs --> mettre  a jour !
	if (version_compare($server_config['version'],"3.05","<=")) return false;
	$request = "SELECT user_id, user_name, user_password, user_active, user_regdate, user_lastvisit, user_galaxy, user_system, user_row, user_admin, user_coadmin, user_language, management_user, management_ranking, disable_ip_check, planet_added_web, planet_added_ogs, search, spy_added_web, spy_added_ogs, rank_added_web, rank_added_ogs, planet_exported, spy_exported, rank_exported FROM ".TABLE_USER;

	if ($user_id !== false) $request .= " where user_id = ".$user_id;
	$request .= " order by ".$order_by;
	$result = $db->sql_query($request);

	$info_users = array();
	while ($row = $db->sql_fetch_assoc($result)) {
		$info_users[] = $row;
	}

	if (sizeof($info_users) == 0) return false;

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
		$tmp = user_get_mod_permissions(false,$user_id);
		$tmp = explode(',',$tmp);
		$user_auth = array("server_set_system" => 1, "server_set_spy" => 1, "server_set_rc" => 1,
		"server_set_ranking" => 1, "server_show_positionhided" => 1, "ogs_connection" => 1,
		"ogs_set_system" => 1, "ogs_get_system" => 1, "ogs_set_spy" => 1, "ogs_get_spy" => 1,
		"ogs_set_ranking" => 1, "ogs_get_ranking" => 1, "mod_restrict" => $tmp ,
		"mod_names" => user_get_mod_permissions(false,$user_id,1));

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
		$tmp = user_get_mod_permissions(false,$user_id);
		$user_auth["mod_restrict"] = explode(',',$tmp);
		$user_auth["mod_names"] = user_get_mod_permissions(false,$user_id,1);
	} else {
		$user_auth = array("server_set_system" => 0, "server_set_spy" => 0, "server_set_ranking" => 0, "server_show_positionhided" => 0,
		"ogs_connection" => 0, "ogs_set_system" => 0, "ogs_get_system" => 0, "ogs_set_spy" => 0, "ogs_get_spy" => 0, "ogs_set_ranking" => 0, "ogs_get_ranking" => 0, "mod_restrict" => Array(), "mod_names" => "");
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

	if (!check_var($pub_pseudo, "Pseudo_Groupname")) redirection("?action=message&id_message=errordata&info=1");

	if (!isset($pub_pseudo)) redirection("?action=message&id_message=createuser_failed_general&info");

	//Vérification des droits
	user_check_auth("user_create");

	if (!check_var($pub_pseudo, "Pseudo_Groupname")) redirection("?action=message&id_message=createuser_failed_pseudo&info=".$pub_pseudo);

	if (!check_var($pub_pass, "Password")) redirection("?action=message&id_message=createuser_failed_password&info=".$pub_pseudo);

	if ($pub_pass != "") $password = $pub_pass;
	else $password = password_generator();
	//$request = "select user_id from ".TABLE_USER." where user_name = '".mysql_real_escape_string($pub_pseudo)."'";
	$request = "select user_id from ".TABLE_USER." where user_name = '".$pub_pseudo."'";
	$result = $db->sql_query($request);
	if ($db->sql_numrows($result) == 0) {
		//$request = "insert into ".TABLE_USER." (user_name, user_password, user_regdate, user_active)".
		//" values ('".mysql_real_escape_string($pub_pseudo)."', '".md5(sha1($password))."', ".time().", '1')";
		$request = "insert into ".TABLE_USER." (user_name, user_password, user_regdate, user_active) values ('".$pub_pseudo."', '".md5(sha1($password))."', ".time().", '1')";
		$db->sql_query($request);
		$user_id = $db->sql_insertid();

		$request = "insert into ".TABLE_USER_GROUP." (group_id, user_id) values (".$pub_group_id.", ".$user_id.")";
		$db->sql_query($request);

		$info = $user_id.":".$password;
		log_("create_account", $user_id);
		user_set_grant($user_id, null, $pub_active, $pub_user_coadmin, $pub_management_user, $pub_management_ranking);
		redirection("?action=message&id_message=createuser_success&info=".$info);
	} else redirection("?action=message&id_message=createuser_failed_pseudolocked&info=".$pub_pseudo);
}

/**
 * Suppression d'un utilisateur ($pub_user_id)
 */
function user_delete() {
	global $db, $user_data;
	global $pub_user_id,$pub_asc,$pub_desc;

	if (!check_var($pub_user_id, "Num")) redirection("?action=message&id_message=errordata&info");

	if (!isset($pub_user_id) || $pub_user_id==$user_data['user_id']) redirection("?action=message&id_message=deleteuser_failed&info");

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

	$request = "delete from ".TABLE_USER_DEFENCE." where user_id = ".$pub_user_id;
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

	$request = "update ".TABLE_PARSEDSPY." set sender_id = 0 where sender_id = ".$pub_user_id;
	$db->sql_query($request);

	$request = "update ".TABLE_UNIVERSE." set last_update_user_id = 0 where last_update_user_id = ".$pub_user_id;
	$db->sql_query($request);

	session_close($pub_user_id);

	$order = "";
	if (isset($pub_asc)) $order = "&asc=".$pub_asc;
	if (isset($pub_desc)) $order = "&desc=".$pub_desc;

	redirection("?action=administration&subaction=members".$order);
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
 * Analyse les données envoyées et renvoi le type (batiment, defense, techno)
 */
function get_user_data_sent($data) {

	$batiment = $defense = $technologie = $overview = $fleet = false;

	// Y'a-t-il le texte de la mine de métal dans les données ?
	$regex = L_("Home_M","parsing");
	$regex = "/{$regex}/";
	if (preg_match($regex, $data, $arr)>0) $batiment = true;

	// Y'a-t-il le texte de l'usine de robot dans les données ?
	$regex = L_("Home_UdR","parsing");
	$regex = "/{$regex}/";
	if (preg_match($regex, $data, $arr)>0) $batiment = true;

	// Y'a-t-il le texte du lanceur de missile dans les données ?
	$regex = L_("defence_LM","parsing");
	$regex = "/{$regex}/";
	if (preg_match($regex, $data, $arr)>0) $defense = true;

/* supression des satellites de la table user_fleet
	// Y'a-t-il le texte du satelite soliare dans les données ?
	$regex = L_("Fleet_Sat","parsing");
	$regex = "/{$regex}/";
	if (preg_match($regex, $data, $arr)>0) $fleet = true;
*/

	// Y'a-t-il le texte de la techno ordinateur dans les données ?
	$regex = L_("tech_Ordi","parsing");
	$regex = "/{$regex}/";
	if (preg_match($regex, $data, $arr)>0) $technologie = true;

	// Y'a-t-il le texte de l'heure du serveur dans les données ?
	$regex = L_("OverView_Rename","parsing");
	$regex = "/{$regex}/";
	if (preg_match($regex, $data, $arr)>0) $overview = true;

	if ($overview)
		return "O";
	elseif ($defense&&$batiment) // Defense et batiment trouver ==> vue Empire
		return "E";
	elseif ($technologie)
		return "T";
	elseif ($batiment)
		return "B";
	elseif ($defense)
		return "D";
	elseif ($fleet)
		return "F";
	return NULL;
}

/**
 * Enregistrement des données Empires d'un utilisateur depuis la page Empire (copier/coller)
 */
function user_set_empire() {
	global $pub_typedata, $pub_data, $pub_planet_id, $pub_planet_name, $pub_fields, $pub_coordinates, $pub_temperature, $pub_satellite;

	$pub_typedata = get_user_data_sent($pub_data);

	if (!isset($pub_typedata) || !isset($pub_data)) redirection("?action=message&id_message=set_empire_failed_data&info=type_unknown");

	if (!isset($pub_planet_id) && $pub_typedata != 'E') redirection("?action=message&id_message=set_empire_failed_data&info=no_planet_selected");

	switch ($pub_typedata) {
		case "B" :
		if (!isset($pub_planet_name) || !isset($pub_fields) || !isset($pub_coordinates)|| !isset($pub_temperature) || !isset($pub_satellite)) redirection("?action=message&id_message=errorfatal&info");
		user_set_building($pub_data, $pub_planet_id, $pub_planet_name, $pub_fields, $pub_coordinates, $pub_temperature, $pub_satellite);
		break;

		case "T" :
		user_set_technology($pub_data);
		break;

		case "D" :
		if (!isset($pub_planet_name) || !isset($pub_fields) || !isset($pub_coordinates)|| !isset($pub_temperature) || !isset($pub_satellite)) redirection("?action=message&id_message=errorfatal&info");
		user_set_defence($pub_data, $pub_planet_id, $pub_planet_name, $pub_fields, $pub_coordinates, $pub_temperature, $pub_satellite);
		break;

		case "F" :
		if (!isset($pub_planet_name) || !isset($pub_fields) || !isset($pub_coordinates)|| !isset($pub_temperature) || !isset($pub_satellite)) redirection("?action=message&id_message=errorfatal&info");
		user_set_fleet($pub_data, $pub_planet_id, $pub_planet_name, $pub_fields, $pub_coordinates, $pub_temperature, $pub_satellite);
		break;

		case "E" :
		user_set_all_empire($pub_data);
		break;

		case "O" :
		user_set_overview($pub_data,$pub_planet_id);
		break;

		default :
		redirection("?action=message&id_message=errorfatal&info");
		break;
	}

	redirection("?action=home&subaction=empire&".$pub_view);
}

/**
 * Enregistrement de toutes les données empires par le Web (v0.83)
 */
function user_set_all_empire($data) {
global $user_data,$db;
	$return = Array();
	$error = false;

	// Nome, Coordinates, Fileds occupation
	$rx_coords = '[0-9]{1,2}:[0-9]{1,3}:[0-9]{1,2}';
	if (!preg_match_all("/\n(.*)\n\[({$rx_coords})\].\n([0-9]{1,3})\/([0-9]{1,3})/",$data,$out)) $error = true;

	// Récupération des noms, coordonnées et cases des planètes
	foreach($out[0] as $i => $v) {
		$return[] = Array('update'=>false,'planet_id'=>false,'planet_name'=> $out[1][$i],'coordinates'=>$out[2][$i],'cases_used'=>$out[3][$i],'fields'=>$out[4][$i]);
	}

	// récupération de tous les niveaux de chaques batiments/techno/defense/vaisseaux
	$list_building = Array('M'=>L_('Home_M',"parsing"),'C'=>L_('Home_C',"parsing"),'D'=>L_('Home_D',"parsing"),'CES'=>L_('Home_CES',"parsing"),'CEF'=>L_('Home_CEF',"parsing"),'UdR'=>L_('Home_UdR',"parsing"),'UdN'=>L_('Home_UdN',"parsing"),'CSp'=>L_('Home_CSp',"parsing"),'HM'=>L_('Home_HM',"parsing"),'HC'=>L_('Home_HC',"parsing"),'HD'=>L_('Home_HD',"parsing"),'Lab'=>L_('Home_Lab',"parsing"),'DdR'=>L_('Home_DdR',"parsing"),'Ter'=>L_('Home_Ter',"parsing"),'Silo'=>L_('Home_Silo',"parsing"),'BaLu'=>L_('Home_BaLu',"parsing"),'Pha'=>L_('Home_Pha',"parsing"),'PoSa'=>L_('Home_PoSa',"parsing"));
	$list_defense = Array('LM'=>L_('defence_LM',"parsing"),'LLE'=>L_('defence_LLE',"parsing"),'LLO'=>L_('defence_LLO',"parsing"),'CG'=>L_('defence_CG',"parsing"),'AI'=>L_('defence_AI',"parsing"),'LP'=>L_('defence_LP',"parsing"),'PB'=>L_('defence_PB',"parsing"),'GB'=>L_('defence_GB',"parsing"),'MIC'=>L_('defence_MIC',"parsing"),'MIP'=>L_('defence_MIP',"parsing"),);
	$list_tech = Array('Esp'=>L_('tech_Esp',"parsing"),'Ordi'=>L_('tech_Ordi',"parsing"),'Armes'=>L_('tech_Armes',"parsing"),'Bouclier'=>L_('tech_Bouclier',"parsing"),'Protection'=>L_('tech_Protection',"parsing"),'NRJ'=>L_('tech_NRJ',"parsing"),'Hyp'=>L_('tech_Hyp',"parsing"),'RC'=>L_('tech_RC',"parsing"),'RI'=>L_('tech_RI',"parsing"),'PH'=>L_('tech_PH',"parsing"),'Laser'=>L_('tech_Laser',"parsing"),'Ions'=>L_('tech_Ions',"parsing"),'Plasma'=>L_('tech_Plasma',"parsing"),'RRI' => L_('tech_RRI',"parsing"),'Graviton'=>L_('tech_Graviton',"parsing"),'Expeditions'=>L_('tech_Expeditions',"parsing"));
	$list_fleet = Array('PT'=>L_('Fleet_SC',"parsing"),'GT'=>L_('Fleet_LC',"parsing"),'CLE'=>L_('Fleet_LF',"parsing"),'CLO'=>L_('Fleet_HF',"parsing"),'CR'=>L_('Fleet_Cru',"parsing"),'VB'=>L_('Fleet_BS',"parsing"),'VC'=>L_('Fleet_CS',"parsing"),'REC'=>L_('Fleet_Rec',"parsing"),'SE'=>L_('Fleet_Spy',"parsing"),'BMD'=>L_('Fleet_Bom',"parsing"),'DST'=>L_('Fleet_Des',"parsing"),'EDLM'=>L_('Fleet_RIP',"parsing"),'TRA'=>L_('Fleet_BC',"parsing")); // ,'SAT'=>L_('Fleet_Sat',"parsing") supression des satellites dans la table user_fleet
	$list_moon = Array(L_('Home_BaLu'),L_('Home_Pha'),L_('Home_PoSa'));
	$get_level = array_merge($list_building,$list_defense,$list_tech,$list_fleet);
	unset($out);
	foreach($get_level as $sql_name => $level_name) {
		if (!preg_match_all("/{$level_name}([0-9\s\t\-\.^\(]+)\n/",$data,$levels_brut))
			$error = $level_name;
		if (isset($levels_brut[1])) {
			// Les niveaux sont par groupe de 2 ou 3, et séparé par x espaces ou tabulation....
			// Donc on regroupe le tout dans une chaine, et on cherche les valeurs numérique qu'on classe ensuite en tableau.
			// Au passage, on remplace les - par des 0 et les . par des vides.
			$levels = trim(str_replace('.','',str_replace('-','0',implode(' ',$levels_brut[1]))));
			preg_match_all('/[0-9]+/',$levels,$level);
			$level = $level[0];
			if (in_array($level_name,$list_moon)) {
				// Si ce sont des batiments de lune, on complète la liste des niveaux par des 0 au début jusqu'au nombre de coordonnées trouvée (on suppose donc que les lunes sont les dernières)
				// Au passage, on retient l'ID a partir duquel ce sont des lunes
				$t = array_fill(sizeOf($return),($moon_start_id=sizeOf($return)-sizeOf($level)),'0');
				$level = array_merge($t,$level);
			}
			foreach($return as $id => $planet_info) $return[$id][$sql_name] = isset($level[$id])?$level[$id]:'0';
		}
		if ($error!=false) redirection("?action=message&id_message=set_empire_failed_data&info=".$error);
	}

	// Recherche des planètes déjà existante dans la base de données
	$reqs = "SELECT planet_id,coordinates FROM `".TABLE_USER_BUILDING."` WHERE `user_id`='".$user_data['user_id']."' AND `planet_id`<10;";
	$id_used = $da_empire = Array();
	$db->sql_query($reqs);
	while ($row = $db->sql_fetch_assoc())
		$id_used[] = $da_empire[$row['coordinates']] = $row['planet_id'];

	// Pour chaque planète envoyée, on cherche le meilleur planet_id (celui existant pour les même coord, ou un libre)
	foreach($return as $id => $planet_data) {
		if ($id<$moon_start_id) {
			// Planètes....
			if (in_array($planet_data['coordinates'],array_keys($da_empire))) {
				// Les coordonnées sont déjà dans la base
				$return[$id]['update'] = true;
				$return[$id]['planet_id'] = $da_empire[$planet_data['coordinates']];
			} else {
				for ($i=1;$i<10;$i++) {
					if (!in_array($i,$id_used)) {
						$id_used[] = $i;
						$return[$id]['planet_id'] = $i;
						$da_empire[$planet_data['coordinates']] = $i;
						break;
					}
				}
			}
		} else {
			// Lunes....
			if (in_array($planet_data['coordinates'],array_keys($da_empire))) {
				$i = $return[$id]['planet_id'] = $da_empire[$planet_data['coordinates']]+9;
				$return[$id]['update'] = ($db->sql_numrows($db->sql_query("SELECT * FROM `".TABLE_USER_BUILDING."` WHERE `user_id`='{$user_data['user_id']}' AND `planet_id`='{$i}';"))>0);
			}
		}
	}

	// Suppression des technologies (evite de tester si update ou pas)
	$db->sql_query("DELETE FROM `".TABLE_USER_TECHNOLOGY."` WHERE `user_id`='{$user_data['user_id']}';");

	// Création des requètes
	$tables_to_update = Array('tech'=>TABLE_USER_TECHNOLOGY,'building'=>TABLE_USER_BUILDING,
		'defense'=>TABLE_USER_DEFENCE,'fleet'=>TABLE_USER_FLEET);
	unset($reqs);
	foreach($return as $id => $planet_data) {
		if ($planet_data['planet_id']==false)
			continue; // On a pas réussi a trouver de planet_id, donc l'empire est plein et cette planète n'y est pas : on l'évite.
		foreach($tables_to_update as $table_type => $table_name) {
			if (isset($reqs)&&$table_type=='tech')
				continue; // Si $reqs existe, alors on a déjà fait les techo avec la 1ere planete, donc on passe
			if (!isset($reqs)) $reqs = Array();
			$values = $sets = Array();
			if ($table_type=='building')
				// Pour les batiments, on rajoute quelques infos
				$values = Array('user_id'=>$user_data['user_id'],'planet_id'=>$planet_data['planet_id'],
					'planet_name'=>$planet_data['planet_name'],'coordinates'=>$planet_data['coordinates'],
					'fields'=>$planet_data['fields'],'Sat'=>$planet_data['SAT']);
			elseif ($table_type=='tech')
				// Pour les techno, on n'ajoute que le user_id
				$values = Array('user_id'=>$user_data['user_id']);
			else
				// Pour tout le reste, on ajoute user_id et planet_id
				$values = Array('user_id'=>$user_data['user_id'],'planet_id'=>$planet_data['planet_id']);
			// Défillement des valeurs à modifier
			foreach(${'list_'.$table_type} as $sql_name => $txt_name)
				$values[$sql_name] = $planet_data[$sql_name];
			if ($planet_data['update']) {
				// C'est une mise à jour, il faut utiliser UPDATE table SET aa = bb WHERE xx=yy
				$updates = $wheres = Array();
				foreach($values as $sql_name => $set) {
					if ($sql_name!='planet_id'&&$sql_name!='user_id') $updates[] = "`{$sql_name}` = '".mysql_real_escape_string(trim($set))."'";
					else $wheres[] = "`{$sql_name}`='".mysql_real_escape_string(trim($set))."'";
				}
				$reqs[] = "UPDATE `{$table_name}` SET ".implode(',',$updates)." WHERE ".implode(' AND ',$wheres);
			} else {
				// C'est une nouvelle planete, il faut utiliser INSERT INTO table (aa,bb,cc,vv) VALUES (AA,BB,CC,DD)
				$reqs[] = "INSERT INTO `{$table_name}` (`".implode("`,`",array_keys($values))."`) VALUES ('".implode("','",$values)."');";
			}
		}
	}

	// Exécution des requêtes.
	foreach($reqs as $req) $db->sql_query($req);

	//Remise en ordre des lunes selon la position des planètes
	user_set_all_empire_resync();

	// Retour à la vue empire.
	redirection("?action=home&subaction=empire&view=".$pub_view);
}

/**
 *  Remise en ordre des lunes selon la position des planètes
 */
function user_set_all_empire_resync() {
	global $db, $user_data;

	$planet_position = array();
	$moon_position = array();
	$moon_to_delete = array();

	// On récupére toutes les planètes
	$request = "select planet_id, coordinates from %s where user_id = {$user_data["user_id"]} and planet_id <= 9 order by planet_id";
	$result = $db->sql_query(sprintf($request,TABLE_USER_BUILDING));

	// On rempli le tableau en fonction des résultats
	while (list($planet_id, $coordinates) = $db->sql_fetch_row($result)) {
		$planet_position[$coordinates] = $planet_id;
	}

	// On récupére toutes les lunes
	$request = "select planet_id, coordinates from %s where user_id = {$user_data["user_id"]} and planet_id > 9 order by planet_id";
	$result = $db->sql_query(sprintf($request,TABLE_USER_BUILDING));

	// On recalcule l'ID en fonction des coordonnées par raport à celle des planetes
	while (list($planet_id, $coordinates) = $db->sql_fetch_row($result)) {

		// S'il n'y a pas de coordonnées dans la lune on l'efface, que faire d'autre ou sait pas trouverle nouvel ID... (bug à la création <OGSpy 4.0)
		if (!preg_match("/[0-9]{1,2}\:[0-9]{1,3}\:[0-9]{1,2}/",$coordinates,$matches))$moon_to_delete[] = $planet_id;

		// Les coordonnées existent : on cherche la planete correspondante :
		else {
			// Si elle existe, on recalcul l'ID
			if (isset($planet_position[$coordinates])) {
				// On a bien le nouvelle ID pour cette lune
				$moon_position[$planet_id] = $planet_position[$coordinates] + 9;
			}
			// Si elle existe pas ou plus, on supprime la lune
			else $moon_to_delete[] = $planet_id;
		}
	}
	// On efface les lunes en trop
	foreach ($moon_to_delete as $planet_id) {
		$request = "delete from %s where planet_id = %s and user_id = {$user_data["user_id"]} limit 1";
		$db->sql_query(sprintf($request,TABLE_USER_BUILDING,$planet_id));
		$db->sql_query(sprintf($request,TABLE_USER_DEFENCE,$planet_id));
	}

	// On reassigne le nouvel ID a chaque lunes qui en a besoin
	$request = "update %s set planet_id = %s where planet_id = %s and user_id = {$user_data["user_id"]}";
	foreach ($moon_position as $old_id => $new_id) {
		$db->sql_query(sprintf($request,TABLE_USER_BUILDING,0-$new_id,$old_id));
		$db->sql_query(sprintf($request,TABLE_USER_DEFENCE,0-$new_id,$old_id));
	}
	foreach ($moon_position as $new_id) {
		$db->sql_query(sprintf($request,TABLE_USER_BUILDING,$new_id,0-$new_id));
		$db->sql_query(sprintf($request,TABLE_USER_DEFENCE,$new_id,0-$new_id));
	}
}

/**
 * Enregistrement des batiments par le Web (formaté pour OGame v1)
 */
function user_set_building($data, $planet_id, $planet_name, $fields, $coordinates, $temperature, $satellite) {
	global $db, $user_data;
	global $pub_view, $server_config;

	$planet_name = trim($planet_name) != "" ? trim($planet_name) : "Inconnu";
	if (!check_var($planet_name, "Galaxy")) $planet_name = "";
	$sets['planet_name'] = $planet_name;

	$sets['fields'] = intval($fields);
	$sets['temperature'] = intval($temperature);
	$sets['Sat'] = intval($satellite);
	$coordinates_ok = "";
	if (sizeof(explode(":", $coordinates)) == 3 || sizeof(explode(".", $coordinates)) == 3) {
		if (sizeof(explode(":", $coordinates)) == 3) @list($galaxy, $system, $row) = explode(":", $coordinates);
		if (sizeof(explode(".", $coordinates)) == 3) @list($galaxy, $system, $row) = explode(".", $coordinates);
		if (intval($galaxy) >= 1 && intval($galaxy) <= intval($server_config['num_of_galaxies']) &&  intval($system) >= 1 &&  intval($system) <= intval($server_config['num_of_systems']) &&  intval($row) >= 1 &&  intval($row) <= 15) {
			$coordinates_ok = $coordinates;
		}
	}
	$set['coordinates'] = $coordinates_ok;

	if (!isset($planet_id)) redirection("?action=message&id_message=set_empire_failed_data&info");

	$planet_id = intval($planet_id);
	if (($pub_view=="planets" && ($planet_id < 1 || $planet_id > 9)) || ($pub_view=="lunes" && ($planet_id < 10 || $planet_id > 18)))
		redirection("?action=message&id_message=set_empire_failed_data&info");
	$sets['planet_id'] = $planet_id;
	$sets['user_id'] = $user_data['user_id'];

	$link_building = array(L_("Home_M","parsing") => "M", L_("Home_C","parsing") => "C", L_("Home_D","parsing") => "D",
	L_("Home_CES","parsing") => "CES", L_("Home_CEF","parsing") => "CEF", L_("Home_DdR","parsing") => "DdR",
	L_("Home_UdR","parsing") => "UdR", L_("Home_UdN","parsing") => "UdN", L_("Home_CSp","parsing") => "CSp",
	L_("Home_HM","parsing") => "HM", L_("Home_HC","parsing") => "HC", L_("Home_HD","parsing") => "HD",
	L_("Home_Lab","parsing") => "Lab", L_("Home_DdR","parsing") => "DdR", L_("Home_Ter","parsing") => "Ter",
	L_("Home_Silo","parsing") => "Silo", L_("Home_BaLu","parsing") => "BaLu", L_("Home_Pha","parsing") => "Pha",
	L_("Home_PoSa","parsing") => "PoSa");

	foreach($link_building as $parsing_name => $sql_name)
		if ($test=preg_match("/\n\s+{$parsing_name}\s?(\d+)\r/",$data,$match))
			$sets[$sql_name] = intval($match[1]);

	$where =  " WHERE user_id='".$user_data['user_id']."' AND planet_id='".$planet_id."'";
	$db->sql_query("SELECT planet_id FROM ".TABLE_USER_BUILDING.$where);
	if ($db->sql_numrows()>0) {
		unset($sets['user_id']);unset($sets['planet_id']);
		foreach($sets as $i => $v)
			$request[] = $i."='".$v."'";
		$request = "UPDATE ".TABLE_USER_BUILDING." set ".implode(',',$request).$where;
	} else {
		$request = "INSERT INTO ".TABLE_USER_BUILDING." (".implode(',',array_keys($sets)).") values ('".implode("','",$sets)."')";
	}
	$db->sql_query($request);
	redirection("?action=home&subaction=empire&view=".$pub_view);
}

/**
 * Enregistrement des technologies par le Web (formaté pour OGame v1)
 */
function user_set_technology($data) {
	global $db, $user_data;

	$link_technology = array(L_("tech_Esp","parsing") => "Esp", L_("tech_Ordi","parsing") => "Ordi",
	L_("tech_Armes","parsing") => "Armes", L_("tech_Bouclier","parsing") => "Bouclier", L_("tech_Protection","parsing") => "Protection",
	L_("tech_NRJ","parsing") => "NRJ", L_("tech_Hyp","parsing") => "Hyp", L_("tech_RC","parsing") => "RC", L_("techno_RI","parsing") => "RI",
	L_("tech_PH","parsing") => "PH", L_("tech_Laser","parsing") => "Laser", L_("tech_Ions","parsing") => "Ions", L_("tech_Plasma","parsing") => "Plasma",
	L_("tech_RRI","parsing") => "RRI", L_("tech_Graviton","parsing") => "Graviton", L_("tech_Expeditions","parsing") => "Expeditions");

	foreach($link_technology as $parsing_name => $sql_name)
		if ($test=preg_match("/\n\s+{$parsing_name}\s?(\d+)\r/",$data,$match))
			$sets[$sql_name] = intval($match[1]);

	if (!isset($sets)) redirection("?action=message&id_message=set_empire_failed_data&info");
	$sets['user_id'] = $user_data['user_id'];

	$db->sql_query("DELETE FROM ".TABLE_USER_TECHNOLOGY." WHERE user_id = ".$user_data["user_id"]);
	$request = "INSERT INTO ".TABLE_USER_TECHNOLOGY." (".implode(',',array_keys($sets)).") values ('".implode("','",$sets)."')";
	$db->sql_query($request);

	redirection("?action=home&subaction=empire");
}
/**
 * Enregistrement des défenses par le Web (formaté pour OGame v1)
 */
function user_set_defence($data, $planet_id, $planet_name, $fields, $coordinates, $temperature, $satellite) {
	global $db, $user_data;
	global $pub_view, $server_config;

	$planet_name = trim($planet_name) != "" ? trim($planet_name) : "Inconnu";
	if (!check_var($planet_name, "Galaxy")) $planet_name = "";
	$sets['planet_name'] = $planet_name;
	$sets['fields'] = intval($fields);
	$sets['temperature'] = intval($temperature);
	$sets['Sat'] = intval($satellite);
	$coordinates_ok = "";
	if (sizeof(explode(":", $coordinates)) == 3 || sizeof(explode(".", $coordinates)) == 3) {
		if (sizeof(explode(":", $coordinates)) == 3) @list($galaxy, $system, $row) = explode(":", $coordinates);
		if (sizeof(explode(".", $coordinates)) == 3) @list($galaxy, $system, $row) = explode(".", $coordinates);
		if (intval($galaxy) >= 1 && intval($galaxy) <= intval($server_config['num_of_galaxies']) &&  intval($system) >= 1 &&  intval($system) <= intval($server_config['num_of_systems']) &&  intval($row) >= 1 &&  intval($row) <= 15) {
			$coordinates_ok = $coordinates;
		}
	}
	$sets['coordinates'] = $coordinates_ok;
	if (!isset($planet_id)) redirection("?action=message&id_message=set_empire_failed_data&info");
	$planet_id = intval($planet_id);

	if (($pub_view=="planets" && ($planet_id < 1 || $planet_id > 9)) || ($pub_view=="lunes" && ($planet_id < 10 || $planet_id > 18)))
		redirection("?action=message&id_message=set_empire_failed_data&info");

	$where =  " WHERE user_id='".$user_data['user_id']."' AND planet_id='".$planet_id."'";
	$db->sql_query("SELECT planet_id FROM ".TABLE_USER_BUILDING.$where);
	if ($db->sql_numrows()>0) {
		foreach($sets as $i => $v)
			$request[] = $i."='".$v."'";
		$db->sql_query("UPDATE ".TABLE_USER_BUILDING." set ".implode(',',$request)." ".$where);
	} else {
		$sets['planet_id'] = $planet_id;
		$sets['user_id'] = $user_data['user_id'];
		$db->sql_query("INSERT INTO ".TABLE_USER_BUILDING." (".implode(',',array_keys($sets)).") values('".implode("','",$sets)."')");
	}
	unset($sets);
	$sets['planet_id'] = $planet_id;
	$sets['user_id'] = $user_data['user_id'];

	$link_defence = array(L_("defence_LM") => "LM", L_("defence_LLE") => "LLE", L_("defence_LLO") => "LLO",
	L_("defence_CG") => "CG", L_("defence_AI") => "AI", L_("defence_LP") => "LP",
	L_("defence_PB") => "PB", L_("defence_GB") => "GB",
	L_("defence_MIC") => "MIC", L_("defence_MIP") => "MIP");

	foreach($link_defence as $parsing_name => $sql_name)
		if ($test=preg_match("/\n\s+{$parsing_name}\s?([\d\.]+)\r/",$data,$match)) {
			$match[1] = str_replace('.','',$match[1]);
			$sets[$sql_name] = intval($match[1]);
		}

	if (count($sets)>2) {
		$db->sql_query("DELETE FROM ".TABLE_USER_DEFENCE." WHERE user_id = ".$user_data["user_id"]." AND planet_id= ".$planet_id);
		$request = "INSERT INTO ".TABLE_USER_DEFENCE." (".implode(',',array_keys($sets)).") value ('".implode("','",$sets)."')";
		$db->sql_query($request);
	}

	redirection("?action=home&subaction=empire&view=".$pub_view);
}

/**
 * Enregistrement des flottes par le Web (formaté pour OGame v1)
 */
function user_set_fleet($data, $planet_id, $planet_name, $fields, $coordinates, $temperature, $satellite) {
	global $db, $user_data;
	global $pub_view, $server_config;

	$planet_name = trim($planet_name) != "" ? trim($planet_name) : "Inconnu";
	if (!check_var($planet_name, "Galaxy")) $planet_name = "";
	$sets['planet_name'] = $planet_name;
	$sets['fields'] = intval($fields);
	$sets['temperature'] = intval($temperature);
	$sets['Sat'] = intval($satellite);
	$coordinates_ok = "";
	if (sizeof(explode(":", $coordinates)) == 3 || sizeof(explode(".", $coordinates)) == 3) {
		if (sizeof(explode(":", $coordinates)) == 3) @list($galaxy, $system, $row) = explode(":", $coordinates);
		if (sizeof(explode(".", $coordinates)) == 3) @list($galaxy, $system, $row) = explode(".", $coordinates);
		if (intval($galaxy) >= 1 && intval($galaxy) <= intval($server_config['num_of_galaxies']) &&  intval($system) >= 1 &&  intval($system) <= intval($server_config['num_of_systems']) &&  intval($row) >= 1 &&  intval($row) <= 15) {
			$coordinates_ok = $coordinates;
		}
	}
	$sets['coordinates'] = $coordinates_ok;
	if (!isset($planet_id)) redirection("?action=message&id_message=set_empire_failed_data&info");
	$planet_id = intval($planet_id);

	if (($pub_view=="planets" && ($planet_id < 1 || $planet_id > 9)) || ($pub_view=="lunes" && ($planet_id < 10 || $planet_id > 18)))
		redirection("?action=message&id_message=set_empire_failed_data&info");

	$where =  " WHERE user_id='".$user_data['user_id']."' AND planet_id='".$planet_id."'";
	$db->sql_query("SELECT planet_id FROM ".TABLE_USER_BUILDING.$where);
	if ($db->sql_numrows()>0) {
		foreach($sets as $i => $v)
			$request[] = $i."='".$v."'";
		$db->sql_query("UPDATE ".TABLE_USER_BUILDING." set ".implode(',',$request)." ".$where);
	} else {
		$sets['planet_id'] = $planet_id;
		$sets['user_id'] = $user_data['user_id'];
		$db->sql_query("INSERT INTO ".TABLE_USER_BUILDING." (".implode(',',array_keys($sets)).") values('".implode("','",$sets)."')");
	}
	unset($sets);
	$sets['planet_id'] = $planet_id;
	$sets['user_id'] = $user_data['user_id'];

	$link_fleet = array(L_("Fleet_SC") => "PT", L_("Fleet_LC") => "GT",
	L_("Fleet_LF") => "CLE", L_("Fleet_HF") => "CLO", L_("Fleet_Cru") => "CR",
	L_("Fleet_BS") => "VB", L_("Fleet_CS") => "VC", L_("Fleet_Rec") => "REC",
	L_("Fleet_Spy") => "SE", L_("Fleet_Bom") => "BMD",// L_("Fleet_Sat") => "SAT", supression des satellites de la table user_fleet
	L_("Fleet_Des") => "DST", L_("Fleet_RIP") => "EDLM", L_("Fleet_BC") => "TRA");

	foreach($link_fleet as $parsing_name => $sql_name)
		if ($test=preg_match("/\n\s+{$parsing_name}\s?([\d\.]+)\r/",$data,$match)) {
			$match[1] = str_replace('.','',$match[1]);
			$sets[$sql_name] = intval($match[1]);
		}

	if (count($sets)>2) {
		$db->sql_query("DELETE FROM ".TABLE_USER_FLEET." WHERE user_id = ".$user_data["user_id"]." AND planet_id= ".$planet_id);
		$request = "INSERT INTO ".TABLE_USER_FLEET." (".implode(',',array_keys($sets)).") value ('".implode("','",$sets)."')";
		$db->sql_query($request);
	}

	redirection("?action=home&subaction=empire&view=".$pub_view);
}

/**
 * Enregistrement de la vue Générale par le web
 */
function user_set_overview($data,$planet_id) {
	global $db, $user_data;

	$rx = Array(
		'planet_name' => "/".L_('OverView_Overview','parsing')." - (.*)/",
		'fields' => "/".L_('OverView_Diameter','parsing').".*\(\d+\/(\d+)\)/",
		'temperature' => "/".L_('OverView_Temperature','parsing').".*\d+\s.C.*\s(\d+).C/",
		'coordinates' => "/".L_('OverView_Position','parsing').".*\[(.*)\]/",
	);

	foreach($rx as $sql_name => $rx_name)
		if (preg_match($rx_name,$data,$match))
			$sets[$sql_name] = trim($match[1]);
	if (isset($sets['coordinates'])) {
		if (!isset($sets['planet_name'])) $sets['planet_name'] = '?';
		$where =  " WHERE user_id='".$user_data['user_id']."' AND planet_id='".$planet_id."'";
		$db->sql_query("SELECT planet_id FROM ".TABLE_USER_BUILDING.$where);
		if ($db->sql_numrows()>0) {
			foreach($sets as $i => $v)
				$request[] = $i."='".$v."'";
			$request = "UPDATE ".TABLE_USER_BUILDING." set ".implode(',',$request).$where;
		} else {
			$sets['planet_id'] = $planet_id;
			$sets['user_id'] = $user_data['user_id'];
			$request = "INSERT INTO ".TABLE_USER_BUILDING." (".implode(',',array_keys($sets)).") values ('".implode("','",$sets)."')";
		}
		$db->sql_query($request);
		return true;
	}
	return false;
}

/**
 * Récupération des données empire de l'utilisateur loggé
 * @comment On pourrait mettre un paramète $user_id optionnel
 */
function user_get_empire() {
	global $db, $user_data;

	$planet = array(false, "user_id" => "", "planet_name" => "", "coordinates" => "",
	"fields" => "", "fields_used" => "", "temperature" => "", "Sat" => "",
	"M" => 0, "C" => 0, "D" => 0,
	"CES" => 0, "CEF" => 0,
	"UdR" => 0, "UdN" => 0, "CSp" => 0,
	"HM" => 0, "HC" => 0, "HD" => 0,
	"Lab" => 0, "Ter" => 0, "Silo" => 0,
	"BaLu" => 0, "Pha" => 0, "PoSa" => 0, "DdR" => 0);

	$defence = array("LM" => 0, "LLE" => 0, "LLO" => 0,
	"CG" => 0, "AI" => 0, "LP" => 0,
	"PB" => 0, "GB" => 0,
	"MIC" => 0, "MIP" => 0);

	$fleet = array("PT" => 0, "GT" => 0,
	"CLE" => 0, "CLO" => 0, "CR" => 0,
	"VB" => 0, "VC" => 0, "REC" => 0,
	"SE" => 0, "BMD" => 0, "DST" => 0,
	"EDLM" => 0, "TRA" => 0 , "SAT" => 0);

	$request = "select planet_id, planet_name, `coordinates`, `fields`, temperature, Sat, M, C, D, CES, CEF, UdR, UdN, CSp, HM, HC, HD, Lab, Ter, Silo, BaLu, Pha, PoSa, DdR";
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
		unset($arr["Sat"]);
		$fields_used = array_sum(array_values($arr));

		$row["fields_used"] = $fields_used;
		$user_building[$row["planet_id"]] = $row;
		$user_building[$row["planet_id"]][0] = true;
	}

	$request = "select Esp, Ordi, Armes, Bouclier, Protection, NRJ, Hyp, RC, RI, PH, Laser, Ions, Plasma, RRI, Graviton, Expeditions";
	$request .= " from ".TABLE_USER_TECHNOLOGY;
	$request .= " where user_id = ".$user_data["user_id"];
	$result = $db->sql_query($request);

	$user_technology = $db->sql_fetch_assoc($result);

	$request = "select planet_id, LM, LLE, LLO, CG, AI, LP, PB, GB, MIC, MIP";
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

	$request = "select planet_id, PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, DST, EDLM, TRA";//, SAT"; suppression des satellites dans la table user_fleet
	$request .= " from ".TABLE_USER_FLEET;
	$request .= " where user_id = ".$user_data["user_id"];
	$request .= " order by planet_id";
	$result = $db->sql_query($request);

	$user_fleet = array_fill(1, 18, $fleet);
	
	while ($row = $db->sql_fetch_assoc($result)) {
		$planet_id = $row["planet_id"];
		unset($row["planet_id"]);
		$user_fleet[$planet_id] = $row;
		$user_fleet[$planet_id]["SAT"] = $user_building[$planet_id]["Sat"];
	}

	return array("building" => $user_building, "technology" => $user_technology, "defence" => $user_defence, "fleet" => $user_fleet);
}

/**
 * Suppression des données de batiments de l'utilisateur loggé
 */
function user_del_building() {
	global $db, $user_data;
	global $pub_planet_id, $pub_view;

	if (!check_var($pub_planet_id, "Num")) {
		redirection("?action=message&id_message=errordata&info");
	}
	if (!isset($pub_planet_id)) {
		redirection("?action=message&id_message=errorfatal&info");
	}

	$request = "delete from ".TABLE_USER_BUILDING." where user_id = ".$user_data["user_id"]." and planet_id = ".intval($pub_planet_id);
	$db->sql_query($request);

	$request = "delete from ".TABLE_USER_DEFENCE." where user_id = ".$user_data["user_id"]." and planet_id = ".intval($pub_planet_id);
	$db->sql_query($request);

	$request = "delete from ".TABLE_USER_FLEET." where user_id = ".$user_data["user_id"]." and planet_id = ".intval($pub_planet_id);
	$db->sql_query($request);

	$request = "select * from ".TABLE_USER_BUILDING." where planet_id <= 9";
	$result = $db->sql_query($request);
	if ($db->sql_numrows($result) == 0) {
		$request = "delete from ".TABLE_USER_TECHNOLOGY." where user_id = ".$user_data["user_id"];
		$db->sql_query($request);
	}

	redirection("?action=home&subaction=empire&view=".$pub_view);
}

/**
 * Déplacement des données de planète de la page empire
 */
function user_move_empire() {
	global $db, $user_data;
	global $pub_planet_id, $pub_left, $pub_right;

	if (!check_var($pub_planet_id, "Num")) {
		redirection("?action=message&id_message=errordata&info");
	}
	if (!isset($pub_planet_id) || (!isset($pub_left) && !isset($pub_right))) {
		redirection("?action=message&id_message=errorfatal&info");
	}

	$pub_planet_id = intval($pub_planet_id);
	if ($pub_planet_id < 1 || $pub_planet_id > 9) {
		redirection("?action=message&id_message=errorfatal&info");
	}
	if (isset($pub_left)) {
		// Si c'est la 1ere planete, on la passe en derniere plutot que de revenir sur la page sans rien faire
		//if ($pub_planet_id == 1) redirection("?action=home&subaction=empire");
		if ($pub_planet_id == 1) $new_position = 9;
		else $new_position = $pub_planet_id - 1;
	}
	elseif (isset($pub_right)) {
		// Idem
		//if ($pub_planet_id == 9) redirection("?action=home&subaction=empire");
		if ($pub_planet_id == 9) $new_position = 1;
		else $new_position = $pub_planet_id + 1;
	}
	// On modifie les 2 tables suivantes de la même manière :
	// Ancien ID => 0 - Nouvel ID
	// Nouvel ID => Ancien ID
	// 0 - Nouvel ID => Nouvel ID
	$request = "update %s set planet_id = %d where user_id = {$user_data['user_id']} and planet_id = %d";
	foreach(Array(TABLE_USER_BUILDING, TABLE_USER_DEFENCE) as $table_to_edit) {
		$db->sql_query(sprintf($request, $table_to_edit, 0-$new_position, $pub_planet_id));
		$db->sql_query(sprintf($request, $table_to_edit, $pub_planet_id, $new_position));
		$db->sql_query(sprintf($request, $table_to_edit, $new_position, 0-$new_position));
	}

	//Remise en ordre des lunes selon la position des planètes
	user_set_all_empire_resync();

	redirection("?action=home&subaction=empire");
}

/**
 * Ajout d'un système favori
 */
function user_add_favorite() {
	global $db, $user_data, $server_config;
	global $pub_galaxy, $pub_system;

	if (!isset($pub_galaxy) || !isset($pub_system)) {
		redirection("?");
	}
	if (intval($pub_galaxy) < 1 || intval($pub_galaxy) > intval($server_config['num_of_galaxies']) || intval($pub_system) < 1 || intval($pub_system) > intval($server_config['num_of_systems'])) {
		redirection("?action=galaxy");
	}

	$request = "select * from ".TABLE_USER_FAVORITE." where user_id = ".$user_data["user_id"];
	$result = $db->sql_query($request);
	$nb_favorites = $db->sql_numrows($result);

	if ($nb_favorites < $server_config["max_favorites"]) {
		$request = "insert ignore into ".TABLE_USER_FAVORITE." (user_id, galaxy, system) values (".$user_data["user_id"].", '".$pub_galaxy."', ".$pub_system.")";
		$db->sql_query($request);
		redirection("?action=galaxy&galaxy=".$pub_galaxy."&system=".$pub_system);
	}
	else {
		redirection("?action=message&id_message=max_favorites&info");
	}
}

/**
 * Suppression d'un système favori
 */
function user_del_favorite() {
	global $db, $user_data;
	global $pub_galaxy, $pub_system, $server_config;

	if (!isset($pub_galaxy) || !isset($pub_system)) {
		redirection("?");
	}
	if (intval($pub_galaxy) < 1 || intval($pub_galaxy) > intval($server_config['num_of_galaxies']) || intval($pub_system) < 1 || intval($pub_system) > intval($server_config['num_of_systems'])) {
		redirection("?action=galaxy");
	}
	$request = "delete from ".TABLE_USER_FAVORITE." where user_id = ".$user_data["user_id"]." and galaxy = '".$pub_galaxy."' and system = ".$pub_system;
	$db->sql_query($request);

	redirection("?action=galaxy&galaxy=".$pub_galaxy."&system=".$pub_system."");
}

/**
 * Récupération des rapports favoris
 */
function user_getfavorites_spy() {
	global $db, $user_data;
	global $sort, $sort2;

	if (!isset($sort) || !isset($sort2) || !is_numeric($sort) || !is_numeric($sort2)) {
		$orderby = "dateRE desc";
	}
	else {
		switch ($sort2) {
			case 0: $order .= " desc"; break;
			case 1: $order .= " asc"; break;
			default: $order .= " asc";
		}

		switch ($sort) {
			case 1: $orderby = "coordinates".$order.""; break;
			case 2: $orderby = "ally ".$order; break;
			case 3: $orderby = "player ".$order; break;
			case 4: $orderby = "moon ".$order; break;
			case 5: $orderby = "dateRE ".$order; break;
			default: $orderby = "dateRE ".$order;
		}
	}

	$favorite = array();

	$request = "select ".TABLE_PARSEDSPY.".id_spy, ".TABLE_PARSEDSPY.".galaxy, ".TABLE_PARSEDSPY.".system, ".TABLE_PARSEDSPY.".row, dateRE, sender_id, tu.moon, ta.name_ally, tp.name_player, tu.status";
	$request .= " from ".TABLE_PARSEDSPY.", ".TABLE_USER_SPY.", ".TABLE_UNIVERSE." tu,".TABLE_PLAYER." tp, ".TABLE_ALLY." ta ";
	$request .= " where tu.id_player = tp.id_player and tp.id_ally = ta.id_ally and user_id = ".$user_data["user_id"]." and tu.galaxy=".TABLE_PARSEDSPY.".galaxy and tu.system=".TABLE_PARSEDSPY.".system and tu.row=".TABLE_PARSEDSPY.".row and ".TABLE_USER_SPY.".spy_id=".TABLE_PARSEDSPY.".id_spy";
	$request .= " order by ".$orderby;
	$result = $db->sql_query($request);

	while (list($spy_id, $galaxy, $system, $row, $datadate, $sender_id, $moon, $ally, $player, $status) = $db->sql_fetch_row($result)) {
		$request = "select user_name from ".TABLE_USER;
		$request .= " where user_id=".$sender_id;
		$result_2 = $db->sql_query($request);
		list($user_name) = $db->sql_fetch_row($result_2);
		$favorite[$spy_id] = array("spy_id" => $spy_id, "spy_galaxy" => $galaxy, "spy_system" => $system, "spy_row" => $row, "player" => $player, "ally" => $ally, "moon" => $moon, "status" => $status, "datadate" => $datadate, "poster" => $user_name);
	}

	return $favorite;
}

/**
 * Ajout d'un rapport favori
 */
function user_add_favorite_spy() {
	global $db, $user_data, $server_config;
	global $pub_spy_id, $pub_galaxy, $pub_system, $pub_row,$pub_info;

	if (!check_var($pub_spy_id, "Num")) {
		redirection("?action=message&id_message=errordata&info");
	}

	if (!isset($pub_spy_id)) {
		redirection("?action=message&id_message=errorfatal&info");
	}

	$request = "select * from ".TABLE_USER_SPY." where user_id = ".$user_data["user_id"];
	$result = $db->sql_query($request);
	$nb_favorites = $db->sql_numrows($result);

	if ($nb_favorites < $server_config["max_favorites_spy"]) {
		$request = "insert ignore into ".TABLE_USER_SPY." (user_id, spy_id) values (".$user_data["user_id"].", ".$pub_spy_id.")";
		$db->sql_query($request);
		if (isset($pub_info)&&$pub_info==3)
			redirection("?action=show_reportspy&spy_id=".$pub_spy_id);
		else
			redirection("?action=show_reportspy&galaxy=".$pub_galaxy."&system=".$pub_system."&row=".$pub_row);
	}
	else {
		redirection("?action=message&id_message=max_favorites&info=_spy");
	}
}

/**
 * Suppression d'un rapport favori
 */
function user_del_favorite_spy() {
	global $db, $user_data;
	global $pub_spy_id, $pub_galaxy, $pub_system, $pub_row, $pub_info;

	if (!check_var($pub_spy_id, "Num")) {
		redirection("?action=message&id_message=errordata&info");
	}

	if (!isset($pub_spy_id)) {
		redirection("?action=message&id_message=errorfatal&info");
	}

	$request = "delete from ".TABLE_USER_SPY." where user_id = ".$user_data["user_id"]." and spy_id = '".$pub_spy_id."'";
	$db->sql_query($request);

	if (!isset($pub_info)) $pub_info = 1;

	switch($pub_info) {
		case 3: redirection("?action=show_reportspy&spy_id=".$pub_spy_id);
		case 2: redirection("?action=show_reportspy&galaxy=".$pub_galaxy."&system=".$pub_system."&row=".$pub_row);
		case 1: redirection("?action=home&subaction=spy");
		default: return true;
	}
}
/**
 * Récupération des informations relative au groupe sélectionné  (click sur un nom de groupe dans la gestion des groups)
 */
function usergroup_get_data() {
	global $pub_group_id;
	$membres = usergroup_member($pub_group_id);
	$modules = usergroup_modules_restrict($pub_group_id);
	$groupes = usergroup_get($pub_group_id);
	$str = Array();
	if (!$membres)
		$str['members'][] = '';
	else
		foreach($membres as $memb)
			$str['members'][] = $memb['user_id'].','.$memb['user_name'];
	if (!$modules)
		$str['modules'][] = '';
	else foreach($modules as $mod)
		$str['modules'][] = $mod['id'].','.$mod['title'];
	if ($groupes == false)
		$str['auth'] = "false";
	else
		$str['auth'] = explode(',',implode(',',$groupes));
	die(json_encode($str));
}

/**
 * Création d'un groupe (modifié selon l'addon GroupAdmin de Unibozu)
 */
function usergroup_create() {
	global $db, $user_data;
	global $pub_groupname;

	if (!isset($pub_groupname)) die(json_encode('false')); //redirection("?action=message&id_message=createusergroup_failed_general&info");

	//Vérification des droits
	user_check_auth("usergroup_manage");

	if (!check_var($pub_groupname, "Pseudo_Groupname")) {
		//redirection("?action=message&id_message=createusergroup_failed_groupname&info");
		die(json_encode('invalid'));
	}

	$request = "select group_id from ".TABLE_GROUP." where group_name = '".mysql_real_escape_string($pub_groupname)."'";
	$result = $db->sql_query($request);

	if ($db->sql_numrows($result) == 0) {
		$request = "insert into ".TABLE_GROUP." (group_name)".
		" values ('".mysql_real_escape_string($pub_groupname)."')";
		$db->sql_query($request);
		$group_id = $db->sql_insertid();

		log_("create_usergroup", $pub_groupname);
		//redirection("?action=administration&subaction=group&group_id=".$group_id);
		die(json_encode(Array($group_id,$pub_groupname)));
		return;
	}
	else {
		//redirection("?action=message&id_message=createusergroup_failed_groupnamelocked&info=".$pub_groupname);
		die(json_encode('allready'));
		return;
	}
}

/**
* Suppression d'un groupe utilisateur
*/
function usergroup_delete() {
	global $db, $user_data;
	global $pub_group_id;

	if (!check_var($pub_group_id, "Num")) {
		die(json_encode('false'));
		//redirection("?action=message&id_message=errordata&info");
	}

	if (!isset($pub_group_id)) {
		die(json_encode('false'));
		//redirection("?action=message&id_message=createusergroup_failed_general&info");
	}

	//Vérification des droits
	user_check_auth("usergroup_manage");

	if ($pub_group_id == 1) {
		die(json_encode('false'));
		//redirection("?action=administration&subaction=group&group_id=1");
	}

	log_("delete_usergroup", $pub_group_id);

	$request = "delete from ".TABLE_USER_GROUP." where group_id = ".intval($pub_group_id);
	$db->sql_query($request);

	$request = "delete from ".TABLE_GROUP." where group_id = ".intval($pub_group_id);
	$db->sql_query($request);

	die(json_encode('true'));
	//redirection("?action=administration&subaction=group");
}

/**
 * Renommer un Groupe
 */
function usergroup_rename() {
	global $db, $pub_group_id, $pub_group_name;

	if (!isset($pub_group_id) || !isset($pub_group_name) || !check_var($pub_group_name, 'Pseudo_Groupname') || !check_var($pub_group_id, 'Num')) {
		die(json_encode('false'));
	}
	//Vérification des droits
	user_check_auth("usergroup_manage");

	log_("modify_usergroup", $pub_group_id);

	$request = 'UPDATE '.TABLE_GROUP.' SET group_name = "'.$pub_group_name.'"  WHERE group_id = "'.$pub_group_id.'"';
	$db->sql_query($request);

	die(json_encode($pub_group_name));
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
		while ($row = $db->sql_fetch_assoc()) {
			$info_usergroup[] = $row;
		}
	}
	else {
		while ($row = $db->sql_fetch_assoc()) {
			$info_usergroup = $row;
		}
	}

	if (!isset($info_usergroup) || sizeof($info_usergroup) == 0) {
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
		die(json_encode('false')); //return 'false';
		//redirection("?action=message&id_message=errordata&info");
	}

	if (!isset($pub_group_id)/* || !isset($pub_group_name)*/) {
		die(json_encode('false')); //return 'false';
		//redirection("?action=message&id_message=errorfatal&info");
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

	$request = "update ".TABLE_GROUP." set";
	//$request .= " group_name = '".mysql_real_escape_string($pub_group_name)."',";
	$request .= " server_set_system = '".intval($pub_server_set_system)."', server_set_spy = '".intval($pub_server_set_spy)."', server_set_rc = '".intval($pub_server_set_rc)."', server_set_ranking = '".intval($pub_server_set_ranking)."', server_show_positionhided = '".intval($pub_server_show_positionhided)."',";
	$request .= " ogs_connection = '".intval($pub_ogs_connection)."', ogs_set_system = '".intval($pub_ogs_set_system)."', ogs_get_system = '".intval($pub_ogs_get_system)."', ogs_set_spy = '".intval($pub_ogs_set_spy)."', ogs_get_spy = '".intval($pub_ogs_get_spy)."', ogs_set_ranking = '".intval($pub_ogs_set_ranking)."', ogs_get_ranking = '".intval($pub_ogs_get_ranking)."'";
	$request .= " where group_id = ".intval($pub_group_id);
	$db->sql_query($request);
	die(json_encode('true')); //return 'true';
	//redirection("?action=administration&subaction=group&group_id=".$pub_group_id);
}

/**
 * Récupération de la liste des groupes
 */
function usergroup_list() {
	global $db, $user_data;

	//Vérification des droits
	user_check_auth("usergroup_manage");

	$request = 'SELECT group_id, group_name FROM '.TABLE_GROUP;
	$result = $db->sql_query($request);

	$list = array();
	while ($row = $db->sql_fetch_assoc()) {
		$list[] = $row;
	}
	return $list;
}

/**
 * Récupération des utilisateurs appartenant à un groupe
 * @param int $group_id Identificateur du groupe demandé
 * @return Array Liste des utilisateurs
 */
function usergroup_member($group_id) {
	global $db, $user_data;

	if (!isset($group_id) || !is_numeric($group_id)) {
		redirection("?action=message&id_message=errorfatal&info");
	}

	$usergroup_member = array(); $ok = false;

	$request = "select u.user_id, user_name from ".TABLE_USER." u, ".TABLE_USER_GROUP." g";
	$request .= " where u.user_id = g.user_id";
	$request .= " and group_id = ".intval($group_id);
	$request .= " order by user_name";
	$result = $db->sql_query($request);
	while ($row = $db->sql_fetch_assoc()) {
		$ok = true;
		$usergroup_member[] = $row;
	}

	if (!$ok)
		return false;
	else
		return $usergroup_member;
}

/**
 * Récupération des modules interdit à un groupe
 * @param int $group_id Identificateur du groupe demandé
 * @return Array Liste des mods
 *
 * $mode =
 * 	0 : Renvoi un tableau [x] => [id] [title], etc.
 *	2 : Renvoi un simple table [x] => [id], etc.
 *	1 : Renvoi un simple table [x] => [title], etc.
 */
function usergroup_modules_restrict($group_id,$mode = 0) {
	global $db, $user_data;

	if (!isset($group_id) || !is_numeric($group_id)) {
		redirection("?action=message&id_message=errorfatal&info");
	}

	$usergroup_mods = array(); $ok = false;

	$request = "select m.id from ".TABLE_MOD." m, ".TABLE_MOD_RESTRICT." r ";
	$request .= " where m.id = r.mod_id";
	$request .= " and r.group_id = ".intval($group_id);
	$request .= " order by m.id";
	$result = $db->sql_query($request);
	while ($row = $db->sql_fetch_assoc()) {
		$ok = true;
		if ($mode == 0)
			$usergroup_mods[] = $row;
		elseif ($mode == 1)
			$usergroup_mods[] = $row['title'];
		else
			$usergroup_mods[] = trim($row['id']);
	}
	$mods = Array();
	$request = "select m.id, m.title, m.mods from ".TABLE_MOD_CAT." m, ".TABLE_MOD_RESTRICT." r ";
	$request .= " where -m.id = r.mod_id";
	$request .= " and r.group_id = ".intval($group_id);
	$request .= " order by m.title";
	$result = $db->sql_query($request);
	while ($row = $db->sql_fetch_assoc()) {
		$ok = true;
		$mods[$row['id']] = $row['mods'];
		if ($mode == 0) {
			$row['id'] =  - trim($row['id']);
			$usergroup_mods[] = $row;
		}
		elseif ($mode == 1)
			$usergroup_mods[] = $row['title'];
		else
			$usergroup_mods[] =  - trim($row['id']);
	}
	if (!$ok) return false;
	if ($mode == 2||$mode == 1) {
		if ($mode == 1) $tag = 'title'; else $tag = 'id';
		// Rajout de l'id ou du titre des mods compris dans les categories presentes
		foreach($mods as $idx => $mbrs_str) {
			$mbrs = explode(' ',$mbrs_str);
			foreach($mbrs as $mbr) {
				$request = "select {$tag} from ".TABLE_MOD." ";
				$request .= " where id = ".$mbr;
				$request .= " order by {$tag}";
				$result = $db->sql_query($request);
				while ($row = $db->sql_fetch_assoc())
					if (!in_array($row[$tag],$usergroup_mods))
						$usergroup_mods[] = $row[$tag];
			}
		}
	}
	return $usergroup_mods;
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
		die(json_encode('false'));
		//redirection("?action=administration&subaction=group");
	}
	else {
		if (!check_var($pub_user_id, "Num") || !check_var($pub_group_id, "Num")) {
			die(json_encode('false'));
			//redirection("?action=message&id_message=errordata&info");
		}

		if (!isset($pub_user_id) || !isset($pub_group_id)) {
			die(json_encode('false'));
			//redirection("?action=message&id_message=errorfatal&info");
		}

		//Vérification des droits
		user_check_auth("usergroup_manage");

			$request = "select group_id from ".TABLE_GROUP." where group_id = ".intval($pub_group_id);
			$result = $db->sql_query($request);
			if ($db->sql_numrows($result) == 0) {
				die(json_encode('false'));
				//redirection("?action=administration&subaction=group");
			}

			$request = "select user_id from ".TABLE_USER." where user_id = ".intval($pub_user_id);
			$result = $db->sql_query($request);
			if ($db->sql_numrows($result) == 0) {
				die(json_encode('false'));
				//redirection("?action=administration&subaction=group");
			}

			$request = "insert ignore into ".TABLE_USER_GROUP." (group_id, user_id) values (".intval($pub_group_id).", ".intval($pub_user_id).")";
			$result = $db->sql_query($request);

			if ($db->sql_affectedrows() > 0) {
				log_("add_usergroup", array($pub_group_id, $pub_user_id));
			}

			die(json_encode($pub_user_id));
			//redirection("?action=administration&subaction=group&group_id=".$pub_group_id);
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
		die(json_encode('false'));
		//redirection("?action=message&id_message=errorfatal&info");
	}
	if (!check_var($pub_user_id, "Num") || !check_var($pub_group_id, "Num")) {
		die(json_encode('false'));
		//redirection("?action=message&id_message=errordata&info");
	}

	//Vérification des droits
	user_check_auth("usergroup_manage");

	$request = "delete from ".TABLE_USER_GROUP." where group_id = ".intval($pub_group_id)." and user_id = ".intval($pub_user_id);
	$result = $db->sql_query($request);

	if ($db->sql_affectedrows() > 0) {
		log_("del_usergroup", array($pub_group_id, $pub_user_id));
	}

	die(json_encode($pub_user_id));
	//redirection("?action=administration&subaction=group&group_id=".$pub_group_id);
}

/**
 * Effacement d'un module insterdit pour un groupe
 */
function usergroup_delmod() {
	global $db, $pub_mod_id, $pub_group_id;
	if (!isset($pub_mod_id) || !isset($pub_group_id)) {
		die(json_encode('false'));
		//redirection("?action=message&id_message=errorfatal&info");
	}
	if (!check_var($pub_mod_id, "Num") || !check_var($pub_group_id, "Num")) {
		die(json_encode('false'));
		//redirection("?action=message&id_message=errordata&info");
	}
	//Vérification des droits
	user_check_auth("usergroup_manage");
	$request = "delete from ".TABLE_MOD_RESTRICT." where group_id = ".intval($pub_group_id)." and mod_id = ".$pub_mod_id;
	$result = $db->sql_query($request);
	die(json_encode($pub_mod_id));
}

/**
 * Ajout d'un module interdit pour un groupe
 */
function usergroup_newmod() {
	global $db, $pub_mod_id, $pub_group_id;
	if (!check_var($pub_mod_id, "Num") || !check_var($pub_group_id, "Num"))
		die(json_encode('false'));

	if (!isset($pub_mod_id) || !isset($pub_group_id))
		die(json_encode('false'));

	//Vérification des droits
	user_check_auth("usergroup_manage");

	$request = "select group_id from ".TABLE_GROUP." where group_id = ".intval($pub_group_id);
	$result = $db->sql_query($request);
	if ($db->sql_numrows($result) == 0)
		die(json_encode('false'));

	$request = "select id from ".TABLE_MOD." where id = ".intval($pub_mod_id);
	$result = $db->sql_query($request);
	if ($db->sql_numrows($result) == 0) {
		$request = "select id from ".TABLE_MOD_CAT." where id = ".(0-intval($pub_mod_id));
		$result = $db->sql_query($request);
		if ($db->sql_numrows($result) == 0)
			return 'false';
	}
	$request = "insert ignore into ".TABLE_MOD_RESTRICT." (group_id, mod_id) values (".intval($pub_group_id).", ".intval($pub_mod_id).")";
	$result = $db->sql_query($request);

	die(json_encode($pub_mod_id));
}

/**
 * Récupére les permissions d'un joueur en fonction du ou des groupes dans lesquels il est
 */
function user_get_permissions($perm,$userid) {
	global $db;
	$request = "SELECT {$perm} FROM ".TABLE_GROUP." a, ".TABLE_USER_GROUP." b WHERE a.group_id = b.group_id AND user_id = '{$userid}'";
	$result = $db->sql_query($request);
	$retour = false;
	while ($row = $db->sql_fetch_row($result))
		if ($row[0] == "1") $retour = true;
	return $retour;
}

/**
 * Récupére les permissions d'un joueur pour un mod en fonction du ou des groupes dans lesquels il est
 * Si $mod_id est faux, alors on renvoi une chaine contenant tous les mods interdit pour cet user.
 */
function user_get_mod_permissions($mod_id,$userid,$names=0) {
	global $db, $server_config;
	// Récupère les id des groupes dans lequel se trouve le $userid
	$request = "SELECT group_id FROM ".TABLE_USER_GROUP." ";
	$request.= "WHERE user_id = '{$userid}'";
	$result = $db->sql_query($request);
	if ($db->sql_numrows($result) == 0) return ($mod_id==false?"":true); // Il n'est dans aucun groupe, dans ce cas il a accès a ce mod

	// On met les groupes du membre dans le tableau $group_id
	while ($row = $db->sql_fetch_assoc($result))
		$group_id[] = $row['group_id'];

	// On récupére un tableau des mods interdits pour chaque groupe
	// On renvoi un tableau $group_restriction contenant autant d'enregistrement que de group qui accueil le membre
	// Chaque enresgistrement contient un tableau contenant les mods interdit.
	// si un enresgistrement est vide, ca veut dire qu'un groupe n'a aucune restriction, dans ce cas inutile d'analyser le reste : le membre a tous les accès
	foreach ($group_id as $gid) {
		// routine exécutée à l'installe, et si la version etait 3.05 ou avant, ca va générer un bug SQL
		if (version_compare($server_config['version'],'3.05','>')) {
			$a = usergroup_modules_restrict($gid,(($mod_id==false)&&($names==1)?1:2));
		}
		else $a = false;
		if ($a!=false) // Il y a des restrictions
			$group_restriction[] = $a;
		else // Il n'y en a pas, alors on peut sortir OK, car le membre est dans un groupe sans aucune interdiction
			return ($mod_id==false?"":true);
	}

	// A-t-on ciblé un mod en particulier ?
	if ($mod_id == false) {// NON

		// On prends le 1er groupe en référence.
		// On compare chacun de ses mods interdit voir s'ils sont aussi interdit dans les autre.
		// Si c'est le cas, on note le groupe, sinon on l'oubli
		$group1_restrict = $group_restriction[0];
		foreach($group1_restrict as $module) {
			$ok = true;
			foreach($group_restriction as $m_list) {
				if (!in_array($module,$m_list)) $ok = false;
			}
			if ($ok == true) // ce module est interdit dans tous les groupes
				$return_list[] = $module;
		}
		// Si y'a une liste de module interdit, on la renvoi sous forme de chaine, sinon on renvoi rien
		return (isset($return_list)?implode(", ",$return_list):"");
	}
							// OUI
	// Enfin, on verifie que le mod est interdit dans tous les groupes : sinon, le membre y a accès
	foreach ($group_restriction as $m_list) {
		if (!in_array($mod_id,$m_list)) return true;
	}
	return false;
}

/**
 * A quoi sert donc cette fonction ? :p (a enregistrer dans la base de donnée le nom ingme du joueur, utilisé pour la page de statistique de l'espace personnel)
 */
function user_set_stat_name($user_stat_name) {
	global $db, $user_data;

	$request = "update ".TABLE_USER." set user_stat_name = '".$user_stat_name."' where user_id = ".$user_data['user_id'];
	$db->sql_query($request);
}
/**
 * A quoi sert donc cette fonction ? :p (a enregistrer dans la base de donnée le l'ally ingme du joueur, utilisé pour la page de statistique de l'espace personnel)
 */
function ally_set_stat_name($ally_stat_name) {
	global $db, $user_data;

	$request = "update ".TABLE_USER." set ally_stat_name = '".$ally_stat_name."' where user_id = ".$user_data['user_id'];
	$db->sql_query($request);
}

/**
 * Suppression d'un rapport d'espionnage
 */
function user_del_spy() {
	global $db, $user_data;
	global $pub_spy_id, $pub_galaxy, $pub_system, $pub_row, $pub_info;

	if (!check_var($pub_spy_id, "Num")) {
		redirection("?action=message&id_message=errordata&info");
	}

	if (!isset($pub_spy_id)) {
		redirection("?action=message&id_message=errorfatal&info");
	}

	if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1)
	{
			$request = "delete from ".TABLE_PARSEDSPY." where id_spy = '".$pub_spy_id."'";
			$db->sql_query($request);
	}

	if (!isset($pub_info)) $pub_info = 1;

	switch($pub_info) {
		case 2: redirection("?action=show_reportspy&galaxy=".$pub_galaxy."&system=".$pub_system."&row=".$pub_row);
		case 1: redirection("?action=home&subaction=spy");
		default: return true;
	}
}

/**
 * Parsing des RC
 * @param string $rawRC RC à parser
 * @return int $return identifiant du RC
 */
function parseRC ($rawRC)
{
	// Suppression des '\', et gestion des retours charriots/sauts de ligne
	$rawRC = str_replace ('\\', '', preg_replace ("/\n|\r|\r\n/", " \n", $rawRC));
	// Suppression des '.' dans les nombres
	while (preg_match ('/\d+\.\d+/', $rawRC))
		$rawRC = preg_replace ('/(\d+)\.(\d+)/', "$1$2", $rawRC);
	$return = array (
		'dateRC' => '',
		'nb_rounds' => 0,
		'attaquants' => array (),
		'defenseurs' => array (),
		'victoire' => 'A',
		'pertes_A' => 0,
		'pertes_D' => 0,
		'gain_M' => -1,
		'gain_C' => -1,
		'gain_D' => -1,
		'debris_M' => -1,
		'debris_C' => -1,
		'lune' => 0,
		'coordinates' => '1:1:1',
	'galaxy' => '1',
	'system' => '1',
	'row' => '1');

	// Extraction du timestamp pour la date du RC
	preg_match (L_('incusr_regexRC_date') , $rawRC, $reg);
	$jourRC = trim ($reg[2]);
	$moisRC = trim ($reg[1]);
	$heureRC = trim ($reg[3]);
	$minutesRC = trim ($reg[4]);
	$secondesRC = trim ($reg[5]);
	$anneeRC = date('Y') - (date('n')<intval($moisRC)?1:0); // changement d'année depuis la date du RC
	$return['dateRC'] = mktime ($heureRC, $minutesRC, $secondesRC, $moisRC, $jourRC, $anneeRC);

	// Extraction du nom, des coordonnées et des techs de l'attaquant et du défenseur
	$opponents = array();
	preg_match_all (L_('incusr_regexRC_AttName'), $rawRC, $reg);
	for ($idx = 0; $idx < sizeof ($reg[0]); $idx++)
	{
	$coords = explode(':',$reg[2][$idx]);
		$return['attaquants'][] = array (
			'pseudo' =>$reg[1][$idx],
			'coordinates' => $reg[2][$idx],
		'galaxy' => $coords[0],
		'system' => $coords[1],
		'row' => $coords[2],
			'armes' => $reg[4][$idx],
			'bouclier' => $reg[5][$idx],
			'protection' => $reg[6][$idx]);
		$opponents[] = $reg[1][$idx];
	}
	preg_match_all (L_('incusr_regexRC_DefName'), $rawRC, $reg);
	for ($idx = 0; $idx < sizeof ($reg[0]); $idx++)
	{
	$coords = explode(':',$reg[2][$idx]);
		if ($idx == 0) {
		$return['coordinates'] = $reg[2][$idx];
		$return['galaxy'] = $coords[0];
		$return['system'] = $coords[1];
		$return['row'] = $coords[2];
	}
		$return['defenseurs'][] = array (
			'pseudo' => $reg[1][$idx],
			'coordinates' => $reg[2][$idx],
			'galaxy' => $coords[0],
			'system' => $coords[1],
			'row' => $coords[2],
			'armes' => $reg[4][$idx],
			'bouclier' => $reg[5][$idx],
			'protection' => $reg[6][$idx]);
		$opponents[] = $reg[1][$idx];
	}

	// Comptage du nombre de roungs
	$return['nb_rounds'] = substr_count ($rawRC, L_('incusr_regexRC_AttShoot')) + 1;

	// Extraction des pertes
	preg_match (L_('incusr_regexRC_AttLoss'), $rawRC, $reg);
	$return['pertes_A'] = trim ($reg[1]);
	preg_match (L_('incusr_regexRC_DefLoss'), $rawRC, $reg);
	$return['pertes_D'] = trim ($reg[1]);

	// Extraction du champ de débris et du pourcentage de lune
	preg_match (L_('incusr_regexRC_Debris'), $rawRC, $reg);
	$return['debris_M'] = trim ($reg[1]);
	$return['debris_C'] = trim ($reg[2]);
	if (preg_match (L_('incusr_regexRC_Moon'), $rawRC, $reg))
		$return['lune'] = trim ($reg[1]);

	// Extraction du résultat du RC
	// A = victoire de l'attaquant
	// D = victoire du défenseur
	// N = match nul
	if (preg_match (L_('incusr_regexRC_AttWin'), $rawRC))
	{
		$return['victoire'] = 'A';
		// Extraction des ressources gagnées
		preg_match (L_('incusr_regexRC_Resouces'), $rawRC, $reg);
		$return['gain_M'] = trim ($reg[1]);
		$return['gain_C'] = trim ($reg[2]);
		$return['gain_D'] = trim ($reg[3]);
	}
	elseif (preg_match (L_('incusr_regexRC_DefWin'), $rawRC))
		$return['victoire'] = 'D';
	else
		$return['victoire'] = 'N';

	$tmp = parseRCround ($rawRC, $return['nb_rounds'], $opponents, $return['victoire']);

	$idx = 1;
	foreach ($tmp as $array)
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
function parseRCround ($rawRC, $nb_rounds, $opponents, $victoire)
{
	$rawRC = preg_replace ("/ \n/", '|', $rawRC);
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
		'Sat.sol.' => -1,
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

	$decoupe = explode (L_('incusr_regexRC_PtsDegats') , $rawRC);
	for ($idx_round = 0; $idx_round < $nb_rounds; $idx_round++)
	{
		$row_RC[$idx_round] = array();
		for ($idx_opp = 0; $idx_opp < sizeof ($opponents); $idx_opp++)
		{
			$row_RC[$idx_round][$opponents[$idx_opp]] = $row_RC_opponent;
			$pattern = '/'.$opponents[$idx_opp].L_('incusr_regexRC_Flight');
			preg_match ($pattern, $decoupe[$idx_round], $reg);
			if (isset ($reg[2]))
			{
				$flotte = split ("[ \t]", chop ($reg[2]));
				$nombre = split ("[ \t]", chop ($reg[3]));
				foreach ($flotte as $key => $val)
					$row_RC[$idx_round][$opponents[$idx_opp]][$val] = $nombre[$key];
			}
		}
		if ($idx_round < $nb_rounds)
		{
			preg_match (L_('incusr_regexRC_AttRound'), $decoupe[$idx_round], $reg);
			if (isset ($reg[1]))
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
			preg_match (L_('incusr_regexRC_DefRound'), $decoupe[$idx_round], $reg);
			if (isset ($reg[1]))
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

	return ($row_RC);
}

/**
 * Reconstruction des RC
 * @global $db
 * @param int $id_RC RC à reconstituer
 * @return string $template_RC reconstitué

TODO:
 Faire un affichage plus sexy, au lieu de tenter de refaire celui de OGame...
 A la limite, créer une table archive, avec le texte ogame en brut pour le resortir sans galère ;)

 Pour les RC en général : listing et triage voir permissions?

 */
function UNparseRC ($id_RC) {
	global $db;

	$key_ships = array ('PT' => 'P.transp.', 'GT' => 'G.transp.', 'CLE' => 'Ch.léger', 'CLO' => 'Ch.lourd',
		'CR' => 'Croiseur', 'VB' => 'V.bataille', 'VC' => 'V.colonisation', 'REC' => 'Recycleur',
		'SE' => 'Sonde', 'BMD' => 'Bombardier', 'DST' => 'Destr.', 'EDLM' => 'Rip', 'SAT' => 'Sat.sol.',
		'TRA' => 'Traqueur');
	$key_defs = array ('LM' => 'Missile', 'LLE' => 'L.léger.', 'LLO' => 'L.lourd', 'CG' => 'Can.Gauss',
		'AI' => 'Art.ions', 'LP' => 'Lanc.plasma', 'PB' => 'P.bouclier', 'GB' => 'G.bouclier');
	$base_ships = array ('PT' => array (4000, 10, 5), 'GT' => array (12000, 25 , 5), 'CLE' => array (
		4000, 10, 50), 'CLO' => array (10000, 25, 150), 'CR' => array (27000, 50, 400), 'VB' => array (
		60000, 200, 1000), 'VC' => array (30000, 100, 50), 'REC' => array (16000, 10, 1), 'SE' => array (
		1000, 0, 0), 'BMD' => array (75000, 500, 1000), 'DST' => array (110000, 500, 2000), 'EDLM' => array (
		9000000, 50000, 200000), 'SAT' => array (2000, 1, 1), 'TRA' => array (70000, 400, 700));
	$base_defs = array ('LM' => array (2000, 20 , 80), 'LLE' => array (2000, 25, 100), 'LLO' => array (
		8000, 100, 250), 'CG' => array (35000, 200, 1100), 'AI' => array (8000, 500, 150), 'LP' => array (
		100000, 300, 3000), 'PB' => array (20000, 2000, 1), 'GB' => array (100000, 10000, 1));

	// Récupération des constantes du RC
	$query = 'SELECT dateRC, galaxy, system, row, nb_rounds, victoire, pertes_A, pertes_D, gain_M, gain_C,
		gain_D, debris_M, debris_C, lune FROM '.TABLE_PARSEDRC.' WHERE id_rc = '.$id_RC;
	$result = $db->sql_query ($query);
	list ($dateRC, $galaxy, $system, $row, $nb_rounds, $victoire, $pertes_A, $pertes_D, $gain_M, $gain_C, $gain_D,
		$debris_M, $debris_C, $lune) = $db->sql_fetch_row ($result);
	$dateRC = date (L_('incusr_RC_Date'), $dateRC);
	$template = L_('incusr_RC_Title', $dateRC, $galaxy.":".$system.":".$row)."\n\n";

	// Récupération de chaque round du RC
	for ($idx = 1; $idx <= $nb_rounds; $idx++)
	{
		$query = 'SELECT id_rcround, attaque_tir, attaque_puissance, attaque_bouclier, defense_tir,
			defense_puissance, defense_bouclier FROM '.TABLE_PARSEDRCROUND.' WHERE id_rc = '.$id_RC.'
		 AND numround = '.$idx;
		$result_round = $db->sql_query ($query);
		list ($id_rcround, $attaque_tir, $attaque_puissance, $attaque_bouclier, $defense_tir,
			$defense_puissance, $defense_bouclier) = $db->sql_fetch_row ($result_round);

		// Récupération de chaque attaquant du RC
		$query = 'SELECT player, galaxy, system, row, Armes, Bouclier, Protection, PT, GT, CLE, CLO, CR, VB, VC, REC,
			SE, BMD, DST, EDLM, TRA FROM '.TABLE_ROUND_ATTACK.' WHERE id_rcround = '.$id_rcround;
		$result_attack = $db->sql_query ($query);
		while (list ($player, $galaxy, $system, $row, $Armes, $Bouclier, $Protection, $PT, $GT, $CLE, $CLO, $CR, $VB,
			$VC, $REC, $SE, $BMD, $DST, $EDLM, $TRA) = $db->sql_fetch_row ($result_attack))
		{
			$key = '';
			$ship = 0;
			$vivant_att = false;
			$template .= L_('incusr_RC_Att', $player." ([{$galaxy}:{$system}:{$row}])",$Armes,$Bouclier,$Protection)."\n";
			$ship_type = L_('incusr_RC_Type');
			$ship_nombre = L_('incusr_RC_Nombre');
			$ship_armes = L_('incusr_RC_Armes');
			$ship_bouclier = L_('incusr_RC_Bouclier');
			$ship_protection = L_('incusr_RC_Coque');
			foreach ($key_ships as $key => $ship)
			{
				if (isset ($$key) && $$key > 0)
				{
					$vivant_att = true;
					$ship_type .= "\t".$ship;
					$ship_nombre .= "\t".$$key;
					$ship_protection .= "\t".round (($base_ships[$key][0] * (($Protection / 10) * 0.1 + 1)) / 10);
					$ship_bouclier .= "\t".round ($base_ships[$key][1] * (($Bouclier /10) * 0.1 + 1));
					$ship_armes .= "\t".round ($base_ships[$key][2] * (($Armes / 10) * 0.1 + 1));
				}
			}
			if ($vivant_att == true)
				$template .= $ship_type."\n".$ship_nombre."\n".$ship_armes."\n".$ship_bouclier."\n".$ship_protection."\n\n";
			else
				$template .= L_('incusr_RC_Detruit')."\n\n";
		}// Fin récupération de chaque attaquant du RC

		// Récupération de chaque défenseur du RC
		$query = 'SELECT player, galaxy, system, row, Armes, Bouclier, Protection, PT, GT, CLE, CLO, CR, VB, VC, REC,
			SE, BMD, DST, EDLM, TRA, LM, LLE, LLO, CG, AI, LP, PB, GB FROM '.TABLE_ROUND_DEFENSE.' WHERE
			id_rcround = '.$id_rcround;
		$result_defense = $db->sql_query ($query);
		while (list ($player, $galaxy, $system, $row, $Armes, $Bouclier, $Protection, $PT, $GT, $CLE, $CLO, $CR, $VB,
			$VC, $REC, $SE, $BMD, $DST, $EDLM, $TRA, $LM, $LLE, $LLO, $CG, $AI, $LP, $PB, $GB) = $db->sql_fetch_row ($result_defense))
		{
			$key = '';
			$ship = 0;
			$vivant_def = false;
			$template .= L_('incusr_RC_Def', $player." ([{$galaxy}:{$system}:{$row}])",$Armes,$Bouclier,$Protection)."\n";
			$ship_type = L_('incusr_RC_Type');
			$ship_nombre = L_('incusr_RC_Nombre');
			$ship_armes = L_('incusr_RC_Armes');
			$ship_bouclier = L_('incusr_RC_Bouclier');
			$ship_protection = L_('incusr_RC_Coque');
			foreach ($key_ships as $key => $ship)
			{
				if (isset ($$key) && $$key > 0)
				{
					$vivant_def = true;
					$ship_type .= "\t".$ship;
					$ship_nombre .= "\t".$$key;
					$ship_protection .= "\t".round (($base_ships[$key][0] * (($Protection / 10) * 0.1 + 1)) / 10);
					$ship_bouclier .= "\t".round ($base_ships[$key][1] * (($Bouclier / 10) * 0.1 + 1));
					$ship_armes .= "\t".round ($base_ships[$key][2] * (($Armes / 10) * 0.1 + 1));
				}
			}
			foreach ($key_defs as $key => $def)
			{
				if (isset ($$key) && $$key > 0)
				{
					$vivant_def = true;
					$ship_type .= "\t".$def;
					$ship_nombre .= "\t".$$key;
					$ship_protection .= "\t".round (($base_defs[$key][0] * (($Protection / 10) * 0.1 + 1)) / 10);
					$ship_bouclier .= "\t".round ($base_defs[$key][1] * (($Bouclier / 10) * 0.1 + 1));
					$ship_armes .= "\t".round ($base_defs[$key][2] * (($Armes / 10) * 0.1 + 1));
				}
			}
			if ($vivant_def == true)
				$template .= $ship_type."\n".$ship_nombre."\n".$ship_armes."\n".$ship_bouclier."\n".$ship_protection."\n\n";
			else
				$template .= L_('incusr_RC_Detruit')."\n\n";
		}// Fin récupération de chaque défenseur du RC

		// Résultat du round
		if ($attaque_tir != 0 || $defense_tir != 0)
		{
		$template .= L_('incusr_RC_AttShoot',$attaque_tir,$attaque_puissance,$defense_bouclier)."\n";
			$template .= L_('incusr_RC_DefShoot',$defense_tir,$defense_puissance,$attaque_bouclier)."\n\n";
		}
	}// Fin récupération de chaque round du RC

	// Qui a remporté le combat ?
	switch ($victoire)
	{
		case 'N':
			$template .= L_('incusr_RC_MatchNul')."\n\n\n";
			break;
		case 'A':
			$template .= L_('incusr_RC_AttWin',$gain_M,$gain_C,$gain_D)."\n\n\n";
			break;
		case 'D':
			$template .= L_('incusr_RC_DefWin')."\n\n\n";
			break;
	}

	// Pertes et champs de débris
	$template .= L_('incusr_RC_AttPertes',$pertes_A)."\n";
	$template .= L_('incusr_RC_DefPertes',$pertes_D)."\n";
	$template .= L_('incusr_RC_CDR',$debris_M,$debris_C)."\n";
	$template .= L_('incusr_RC_Proba',$lune);

	return ($template);
}

/**
 * Enregistrement des RC
 * @global $db
 * @param string $rawRC RC brut à analyser
 */
function insert_RC ($rawRC) {
	global $db;
	$parsedRC = parseRC ($rawRC);
	$query = 'INSERT IGNORE INTO '.TABLE_PARSEDRC.'(dateRC, nb_rounds, victoire, pertes_A, pertes_D,
		gain_M, gain_C, gain_D, debris_M, debris_C, lune, galaxy, system, row, coordinates) VALUES ('.$parsedRC['dateRC'].','.
		$parsedRC['nb_rounds'].',"'.$parsedRC['victoire'].'",'.$parsedRC['pertes_A'].','.
		$parsedRC['pertes_D'].','.$parsedRC['gain_M'].','.$parsedRC['gain_C'].','.
		$parsedRC['gain_D'].','.$parsedRC['debris_M'].','.$parsedRC['debris_C'].','.
		$parsedRC['lune'].',"'.$parsedRC['galaxy'].'","'.$parsedRC['system'].'","'.$parsedRC['row'].'","'.
	$parsedRC['coordinates'].'")';
	if (! $db->sql_query ($query)) {
		$error = $db->sql_error ($result);
		error_sql ($error['message']);
	}
	$id_RC = $db->sql_insertid();
	for ($idx_round = 1; $idx_round <= $parsedRC['nb_rounds']; $idx_round++)
	{
		$round = 'round'.$idx_round;
		$query = 'INSERT IGNORE INTO '.TABLE_PARSEDRCROUND.'(id_rc, numround, attaque_tir, attaque_puissance,
			attaque_bouclier, defense_tir, defense_puissance, defense_bouclier) VALUES('.$id_RC.', '.
			$idx_round.', "'.$parsedRC[$round]['attaque_tir'].'", "'.$parsedRC[$round]['attaque_puissance'].
			'", "'.$parsedRC[$round]['attaque_bouclier'].'", "'.$parsedRC[$round]['defense_tir'].'", "'.
			$parsedRC[$round]['defense_puissance'].'", "'.$parsedRC[$round]['defense_bouclier'].'")';
		if (! $db->sql_query ($query)) {
			$error = $db->sql_error ($result);
			error_sql ($error['message']);
		}
		$id_parsedround = $db->sql_insertid();
		foreach ($parsedRC['attaquants'] as $opponent => $row)
		{
			$pseudo = $row['pseudo'];
		$query = 'INSERT IGNORE INTO '.TABLE_ROUND_ATTACK.'(id_rcround, player, coordinates, galaxy, system, row, Armes,
				Bouclier, Protection, PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, DST, EDLM, TRA) VALUES ('.
				$id_parsedround.', "'.$row['pseudo'].'", "'.$row['coordinates'].'", "'.$row['galaxy'].'", "'.
		$row['system'].'", "'.$row['row'].'", '.$row['armes'].', '.$row['bouclier'].', '.$row['protection'].', "'.
		$parsedRC[$round][$pseudo]['P.transp.'].'", "'.$parsedRC[$round][$pseudo]['G.transp.'].'", "'.
		$parsedRC[$round][$pseudo]['Ch.léger'].'", "'.$parsedRC[$round][$pseudo]['Ch.lourd'].'", "'.
		$parsedRC[$round][$pseudo]['Croiseur'].'", "'.$parsedRC[$round][$pseudo]['V.bataille'].'", "'.
		$parsedRC[$round][$pseudo]['V.colonisation'].'", "'.$parsedRC[$round][$pseudo]['Recycleur'].'", "'.
		$parsedRC[$round][$pseudo]['Sonde'].'", "'.$parsedRC[$round][$pseudo]['Bombardier'].'", "'.
		$parsedRC[$round][$pseudo]['Destr.'].'", "'.$parsedRC[$round][$pseudo]['Rip'].'", "'.
		$parsedRC[$round][$pseudo]['Traqueur'].'")';
			if (! $db->sql_query ($query)) {
				$error = $db->sql_error ($result);
				error_sql ($error['message']);
			}
		}
		foreach ($parsedRC['defenseurs'] as $opponent => $row)
		{
			$pseudo = $row['pseudo'];
			$query = 'INSERT IGNORE INTO '.TABLE_ROUND_DEFENSE.'(id_rcround, player, coordinates, galaxy, system, row, Armes,
				Bouclier, Protection, PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, DST, EDLM, SAT, TRA, LM, LLE, LLO,
				CG, AI, LP, PB, GB) VALUES ('.$id_parsedround.', "'.$row['pseudo'].'", "'.$row['coordinates'].'", "'.
		$row['galaxy'].'", "'.$row['system'].'", "'.$row['row'].'", '.$row['armes'].', '.$row['bouclier'].', '.
		$row['protection'].', "'.$parsedRC[$round][$pseudo]['P.transp.'].'", "'.$parsedRC[$round][$pseudo]['G.transp.'].
		'", "'.$parsedRC[$round][$pseudo]['Ch.léger'].'", "'.$parsedRC[$round][$pseudo]['Ch.lourd'].'", "'.
				$parsedRC[$round][$pseudo]['Croiseur'].'", "'.$parsedRC[$round][$pseudo]['V.bataille'].'", "'.
				$parsedRC[$round][$pseudo]['V.colonisation'].'", "'.$parsedRC[$round][$pseudo]['Recycleur'].'", "'.
				$parsedRC[$round][$pseudo]['Sonde'].'", "'.$parsedRC[$round][$pseudo]['Bombardier'].'", "'.
				$parsedRC[$round][$pseudo]['Destr.'].'", "'.$parsedRC[$round][$pseudo]['Rip'].'", "'.
				$parsedRC[$round][$pseudo]['Sat.sol.'].'", "'.$parsedRC[$round][$pseudo]['Traqueur'].'", "'.
				$parsedRC[$round][$pseudo]['Missile'].'", "'.$parsedRC[$round][$pseudo]['L.léger.'].'", "'.
				$parsedRC[$round][$pseudo]['L.lourd'].'", "'.$parsedRC[$round][$pseudo]['Can.Gauss'].'", "'.
				$parsedRC[$round][$pseudo]['Art.ions'].'", "'.$parsedRC[$round][$pseudo]['Lanc.plasma'].'", "'.
				$parsedRC[$round][$pseudo]['P.bouclier'].'", "'.$parsedRC[$round][$pseudo]['G.bouclier'].'")';
			if (! $db->sql_query ($query)) {
				$error = $db->sql_error ($result);
				error_sql ($error['message']);
			}
		}
	}
	log_("load_rc", $id_RC);
	redirection ("?action=galaxy&galaxy={$parsedRC['galaxy']}&system={$parsedRC['system']}");
}

/**
 * Suppression d'un raport de combat ($pub_rc_id)
 */
function user_del_rc() {
	global $db, $user_data;
	global $pub_rc_id,$pub_galaxy,$pub_system,$pub_row;

	if (!isset($pub_rc_id) || !check_var($pub_rc_id, "Num")) {
		redirection("?action=message&id_message=errordata&info");
	}

	$result = $db->sql_query("select id_rcround from ".TABLE_PARSEDRCROUND." where id_rc = ".$pub_rc_id);
	$rnd_to_delete = Array();
	while($id_rcround = $db->sql_fetch_row($result)) {
		$rnd_to_delete[] = $id_rcround[0];
	}

	$request = "delete from %s where id_rc = ".$pub_rc_id;
	$db->sql_query(sprintf($request,TABLE_PARSEDRC));
	$db->sql_query(sprintf($request,TABLE_PARSEDRCROUND));

	foreach($rnd_to_delete as $round) {
		$db->sql_query("delete from ".TABLE_ROUND_ATTACK." where id_rcround = ".$round);
		$db->sql_query("delete from ".TABLE_ROUND_DEFENSE." where id_rcround = ".$round);
	}

	log_("delete_rc", $pub_rc_id);
	redirection("?action=show_reportrc&galaxy={$pub_galaxy}&system={$pub_system}&row={$pub_row}");
}

/**
 * Fonction de calcul du ratio
 * @param int $player user_id ID du joueur
 * @return array ratio et divers calculs intermédiaires pour l'utilisateur en question
 * @author Bousteur 25/11/2006
 */
function ratio_calc($player) {
		global $db, $user_data;

		//récupération des données nécessaires
		$sqlrecup = "SELECT planet_added_web, planet_added_ogs, planet_exported, search, spy_added_web, spy_added_ogs, spy_exported, rank_added_web, rank_added_ogs, rank_exported FROM ".TABLE_USER." WHERE user_id='".$player."'";
		$result = $db->sql_query($sqlrecup);
		list($planet_added_web, $planet_added_ogs, $planet_exported, $search, $spy_added_web, $spy_added_ogs, $spy_exported, $rank_added_web, $rank_added_ogs, $rank_exported) = $db->sql_fetch_row($result);
		$request = "select sum(planet_added_web + planet_added_ogs), ";
		$request .= "sum(spy_added_web + spy_added_ogs), ";
		$request .= "sum(rank_added_web + rank_added_ogs), ";
		$request .= "sum(search) ";
		$request .= "from ".TABLE_USER;
		$resultat = $db->sql_query($request);
		list($planetimporttotal, $spyimporttotal, $rankimporttotal, $searchtotal) = $db->sql_fetch_row($resultat);
		$query = "SELECT COUNT(user_id) as count FROM ".TABLE_USER;
		$result = $db->sql_query($query);
		if ($db->sql_numrows($result) > 0) {
				$row = $db->sql_fetch_assoc($result);
				$max = $row['count'];
		}
		//pour éviter la division par zéro
		if ($planetimporttotal == 0) $planetimporttotal = 1;
		if ($spyimporttotal == 0) $spyimporttotal = 1;
		if ($rankimporttotal == 0) $rankimporttotal = 1;
		if ($searchtotal == 0) $searchtotal = 1;

		//et on commence le calcul
		$ratio_planet = ($planet_added_web + $planet_added_ogs) / $planetimporttotal;
		$ratio_spy = ($spy_added_web + $spy_added_ogs) / $spyimporttotal;
		$ratio_rank = ($rank_added_web + $rank_added_ogs) / $rankimporttotal;
		$ratio = ($ratio_planet * 4 + $ratio_spy * 2 + $ratio_rank) / (4 + 2 + 1);

		$ratio_planet_penality = ($planet_added_web + $planet_added_ogs - $planet_exported) / $planetimporttotal;
		$ratio_spy_penality = (($spy_added_web + $spy_added_ogs) - $spy_exported) / $spyimporttotal;
		$ratio_rank_penality = (($rank_added_web + $rank_added_ogs) - $rank_exported) / $rankimporttotal;
		$ratio_penality = ($ratio_planet_penality * 4 + $ratio_spy_penality * 2 + $ratio_rank_penality) / (4 + 2 + 1);

		$ratio_search = $search / $searchtotal;
		$ratio_searchpenality = ($ratio - $ratio_search);

		$result = ($ratio + $ratio_penality + $ratio_searchpenality) * 1000;
		$array = array($result,$ratio_searchpenality,$ratio_search,$ratio_penality,$ratio_rank_penality,$ratio_spy_penality,$ratio_planet_penality);

		//retourne le ratio et calculs intermédiaires
		return $array;
}
/*
 * Retourne le ratio pour un joueur donnée
 * @param $v = statistique du joueur (depuis suer_statistic)
* @param $planetimport, $spyimport, $rankimport, $search : statistique globale du serveur.
* @return Array(ratio,color);
*/
function get_ratio($v,$planetimport,$spyimport,$rankimport,$search) {
	$ratio_planet = ($v["planet_added_web"] + $v["planet_added_ogs"]) / $planetimport;
	$ratio_spy = ($v["spy_added_web"] + $v["spy_added_ogs"]) / $spyimport;
	$ratio_rank = ($v["rank_added_web"] + $v["rank_added_ogs"]) / $rankimport;
	$ratio = ($ratio_planet * 4 + $ratio_spy * 2 + $ratio_rank) / (3 + 2 + 1);

	$ratio_planet_penality = ($v["planet_added_web"] + $v["planet_added_ogs"] - $v["planet_exported"]) / $planetimport;
	$ratio_spy_penality = (($v["spy_added_web"] + $v["spy_added_ogs"]) - $v["spy_exported"]) / $spyimport;
	$ratio_rank_penality = (($v["rank_added_web"] + $v["rank_added_ogs"]) - $v["rank_exported"]) / $rankimport;
	$ratio_penality = ($ratio_planet_penality * 4 + $ratio_spy_penality * 2 + $ratio_rank_penality) / (3 + 2 + 1);

	$ratio_search = $v["search"] / $search;
	$ratio_searchpenality = ($ratio - $ratio_search);

	$couleur = $ratio_penality > 0 ? "lime" : "red";

	$result = ($ratio + $ratio_penality + $ratio_searchpenality) * 1000;
	if ($result < 0) $color = "red";
	elseif ($result == 0) $color = "white";
	elseif ($result < 100) $color = "orange";
	else $color = "lime";
	return Array($result,$color);
}

/**
 * Fonction de test d'autorisation d'effectuer une action en fonction du ratio ou de l'appartenance à un groupe qui a un ratio illimité
 * @return bool vrai si l'utilisateur peut faire des recherches
 * @author Bousteur 28/11/2006
 */
function ratio_is_ok() {
		global $user_data, $server_config;
		static $result;

		if ($result != null) return $result;
		if (isset($server_config["block_ratio"]) && $server_config["block_ratio"] == 1) {
		if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_user"] == 1) {
			return true;
		} else {
			$result = ratio_calc($user_data['user_id']);
			$result = $result[0] >= $server_config["ratio_limit"];
			return $result;
		}
	} else {
		return true;
	}
}
?>
