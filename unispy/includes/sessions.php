<?php
/**
* Gestion des sessions utilisateurs
* @author Kyser http://www.ogsteam.fr
 * @version 1.0 Beta
* @package UniSpy
* @licence GPL
* @subpackage users
*/
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

/**
* Création d'une session Utilisateur
* Mise en place du cookie d'identification
* @param ??? Ip utilisateur , type ?
*/
function session_begin($user_ip) {
	global $db, $cookie_id, $server_config;

	$cookie_name = COOKIE_NAME;
	$cookie_time = $server_config["session_time"];
	$cookie_id = md5(uniqid(mt_rand(), true));

	$cookie_expire = time()+$cookie_time*60;

	if (strstr($_SERVER['HTTP_USER_AGENT'],"OGSClient") === false) {
		$request = "insert into ".TABLE_SESSIONS." (session_id, session_user_id, session_start, session_expire, session_ip) values (";
		$request .="'".$cookie_id."', 0, ".time().", ".$cookie_expire.", '".$user_ip."')";
		$db->sql_query($request, true, false) or die("Impossible d'initialiser la sessions");
	}
	else {
		$request = "delete from ".TABLE_SESSIONS." where session_ip = '".$user_ip."' and session_ogs = '1'";
		$db->sql_query($request, true, false) or die("Impossible d'initialiser la sessions");

		$request = "insert into ".TABLE_SESSIONS." (session_id, session_user_id, session_start, session_expire, session_ip, session_ogs) values (";
		$request .="'".$cookie_id."', 0, ".time().", ".$cookie_expire.", '".$user_ip."', '1')";
		$db->sql_query($request, true, false) or die("Impossible d'initialiser la sessions");
	}

	setcookie($cookie_name, $cookie_id, 0);
}

/**
* Recupération d'une session utilisateur existante ou création
* Utilise les variables globales : $user_ip, $cookie_id
*/
function session() {
	global $db, $user_ip, $cookie_id, $server_config;
	global $HTTP_COOKIE_VARS, $link_css;

	$cookie_id = "";
	$cookie_name = COOKIE_NAME;
	$cookie_time = $server_config["session_time"];

	//Purge des sessions expirée
	if ($server_config["session_time"] != 0) {
		$request = "delete from ".TABLE_SESSIONS." where session_expire < ".time();
		$db->sql_query($request, true, false);
	}

	$link_css = $server_config["default_skin"];

	//Récupération de l'id de session si cookie présent
	if (isset($HTTP_COOKIE_VARS[$cookie_name])) {
		$cookie_id = $HTTP_COOKIE_VARS[$cookie_name];

		//Vérification de la validité de le session
		$request = "select session_id from ".TABLE_SESSIONS.
		" where session_id = '".$cookie_id."'".
		" and session_ip = '".$user_ip."'";
		$result = $db->sql_query($request);

		if ($db->sql_numrows($result) != 1) {
			if ($server_config["disable_ip_check"] == 1) {
				//Mise à jour de l'adresse ip de session si le controle des ip est désactivé
				$request = "select session_id from ".TABLE_SESSIONS." left join ".TABLE_USER.
				" on session_user_id = user_id".
				" where session_id = '".$cookie_id."'".
				" and disable_ip_check = '1'";
				$result = $db->sql_query($request);

				if ($db->sql_numrows($result) > 0) {
					$request = "update ".TABLE_SESSIONS." set session_ip = '".$user_ip."' where session_id = '".$cookie_id."'";
					$db->sql_query($request, true, false);
				}
				else {
					$cookie_id = "";
				}
			}
			else {
				$cookie_id = "";

			}
		}
	}

	if ($cookie_id == "") {
		session_begin($user_ip);
	}
	else {
		$cookie_expire = time()+$cookie_time*60;
		$request = "update ".TABLE_SESSIONS." set session_expire = ".$cookie_expire." where session_id = '".$cookie_id."'";
		$db->sql_query($request, true, false);
	}

	session_set_user_data($cookie_id);
}

/**
* Mise à jour d'une session
*/
function session_set_user_id($user_id, $lastvisit=0) {
	global $db, $user_ip, $cookie_id, $server_config;
	global $HTTP_COOKIE_VARS;

	//Purge des sessions expirée
	if ($server_config["session_time"] == 0) {
		$request = "select session_ogs from ".TABLE_SESSIONS." where session_id = '".$cookie_id."'";
		$result = $db->sql_query($request);
		while (list($session_ogs) = $db->sql_fetch_row($result)) {
			$request = "delete from ".TABLE_SESSIONS." where session_user_id = ".$user_id." and session_ogs = '".$session_ogs."'";
			$db->sql_query($request);
		}
	}

	$request = "update ".TABLE_SESSIONS." set session_user_id = ".$user_id.
	", session_lastvisit = ".$lastvisit.
	" where session_id = '".$cookie_id."'".
	" and session_ip = '".$user_ip."'";
	$db->sql_query($request);

	session_set_user_data($cookie_id);
}
/**
* Mise a jour des données utilisateurs
* @internal Je me demande l'utilité des tests de debuts de fonctions, 
* puisqu'au moment de la publication du fichier on sait a quelle version on est... la 3.10 pour l'instant
*/
function session_set_user_data() {
	global $db, $user_ip, $user_data, $user_auth, $cookie_id, $server_config;
	global $link_css, $user_menu_language;

	if (preg_match("#^0.300([b-f])?$#", $server_config["version"])) {
		$request = "select user_id, user_name, user_admin, user_galaxy, user_system, user_skin";
	}
	elseif (preg_match("#^0.301(b)?$#", $server_config["version"])) {
		$request = "select user_id, user_name, user_admin, user_galaxy, user_system, user_skin, session_lastvisit";
	}
	elseif (preg_match("#^3.02(b)?$#", $server_config["version"])) {
		$request = "select user_id, user_name, user_admin, user_coadmin, user_galaxy, user_system, user_skin, session_lastvisit, user_stat_name, ";
		$request .= "management_user, management_ranking";
	}
	else {
		$request = "select user_id, user_name, user_admin, user_coadmin, user_galaxy, user_system, user_skin, session_lastvisit, user_stat_name, ";
		$request .= "management_user, management_ranking, disable_ip_check, user_language";
	}

	$request .= " from ".TABLE_USER." u, ".TABLE_SESSIONS." s";
	$request .= " where u.user_id = s.session_user_id";
	$request .= " and session_id = '".$cookie_id."'";
	$request .= " and session_ip = '".$user_ip."'";
	$result = $db->sql_query($request);

	if ($db->sql_numrows($result) == 1) {
		$user_data = $db->sql_fetch_assoc($result);
		if ($user_data["user_skin"] != "") $link_css = $user_data["user_skin"];
		else $link_css = $server_config["default_skin"];
		
		// ajout code pour choix par défaut de la langue des menu pour l'utilisateur
		if ($user_data["user_language"] != "") $user_menu_language = $user_data["user_language"];
		else $user_menu_language = $server_config["language"];
	
		if (preg_match("#^1.0(.*)?$#", $server_config["version"])) {
			$user_auth = user_get_auth($user_data["user_id"]);
		}
		
	}
	else {
		unset($user_data);
		unset($user_auth);
	}
}
/**
* Cloture de session utilisateur
*/
function session_close($user_id = false) {
	global $db, $user_ip, $cookie_id;

	if (!$user_id) {
		global $HTTP_COOKIE_VARS;

		$cookie_name = COOKIE_NAME;
		$cookie_id = $HTTP_COOKIE_VARS[$cookie_name];

		$request = "delete from ".TABLE_SESSIONS.
		" where session_id = '".$cookie_id."'".
		" and session_ip = '".$user_ip."'";
		$db->sql_query($request, true, false);
	}
	else {
		$request = "delete from ".TABLE_SESSIONS.
		" where session_user_id = ".$user_id;
		$db->sql_query($request, true, false);
	}
}
/**
* Recherche des utilisateurs online
* Note: à traduire
* @return array Membres identifiés et non identifiés
*/
function session_whois_online() {
	global $db, $server_config;

	$cookie_time = $server_config["session_time"];

	$request = "select user_name, session_start, session_expire, session_ip, session_ogs";
	$request .= " from ".TABLE_SESSIONS." left join ".TABLE_USER;
	$request .= " on session_user_id = user_id";
	$request .= " order by user_name";
	$result = $db->sql_query($request);

	$guests = $members = array();
	while (list($user_name, $session_start, $session_expire, $session_ip, $session_ogs) = $db->sql_fetch_row($result)) {
		$time_lastactivity = $session_expire - $cookie_time*60;
		$session_ip = decode_ip($session_ip);

		if (is_null($user_name)) {
			$user_name = "Visiteur non identifié";
			$guests[] = array("user" => $user_name, "time_start" => $session_start, "time_lastactivity" => $time_lastactivity, "ip" => $session_ip, "ogs" => 0);
		}
		else {
			$members[] = array("user" => $user_name, "time_start" => $session_start, "time_lastactivity" => $time_lastactivity, "ip" => $session_ip, "ogs" => $session_ogs);
		}
	}
	$online = array_merge($members, $guests);

	return $online;
}
?>
