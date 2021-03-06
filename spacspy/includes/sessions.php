<?php
/** $Id$ **/
/**
* Fichier de gestion des sessions utilisaturs sur OGSpy
* @package OGSpy
* @subpackage Main
* @copyright Copyright &copy; 2007, http://www.ogsteam.fr/
* @created 06/12/2005
* @modified $Date$
* @author Kyser
* @link $HeadURL$
* @version 3.04b ( $Rev$ ) 
*/


/**
* Interdiction de l'appel direct
*/
if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}

/**
* D�marrage d'une session utilisateur
*/
function session_begin($user_ip) {
	global $db, $cookie_id, $server_config;

	$cookie_name = COOKIE_NAME;
	$cookie_time = ( $server_config["session_time"] == 0 ) ? 525600:$server_config["session_time"];
	$cookie_id = md5(uniqid(mt_rand(), true));

	$cookie_expire = time()+$cookie_time*60;

	if (strstr($_SERVER['HTTP_USER_AGENT'],"OGSClient") === false) {
		$request = "insert into ".TABLE_SESSIONS." (session_id, session_user_id, session_start, session_expire, session_ip) values (";
		$request .="'".$cookie_id."', 0, ".time().", ".$cookie_expire.", '".$user_ip."')";
		$db->sql_query($request, true, false) or die("Impossible d'initialiser la session");
	}
	else {
		$request = "delete from ".TABLE_SESSIONS." where session_ip = '".$user_ip."' and session_ogs = '1'";
		$db->sql_query($request, true, false) or die("Impossible d'initialiser la session");

		$request = "insert into ".TABLE_SESSIONS." (session_id, session_user_id, session_start, session_expire, session_ip, session_ogs) values (";
		$request .="'".$cookie_id."', 0, ".time().", ".$cookie_expire.", '".$user_ip."', '1')";
		$db->sql_query($request, true, false) or die("Impossible d'initialiser la session");
	}

	setcookie($cookie_name, $cookie_id, 0);
}

/**
* r�cup�re une eventuelle session en cours ou en cree une au besoin
*/
function session() {
	global $db, $user_ip, $cookie_id, $server_config;
	global $HTTP_COOKIE_VARS, $link_css;

	$cookie_id = "";
	$cookie_name = COOKIE_NAME;
	$cookie_time = ( $server_config["session_time"] == 0 ) ? 525600:$server_config["session_time"];

	//Purge des sessions expir�es 
	if ($server_config["session_time"] != 0) {
		$request = "delete from ".TABLE_SESSIONS." where session_expire < ".time();
		$db->sql_query($request, true, false);
	}

	$link_css = $server_config["default_skin"];

	//R�cup�ration de l'id de session si cookie pr�sent
	if (isset($HTTP_COOKIE_VARS[$cookie_name])) {
		$cookie_id = $HTTP_COOKIE_VARS[$cookie_name];

		//V�rification de la validit� de le session
		$request = "select session_id from ".TABLE_SESSIONS.
		" where session_id = '".$cookie_id."'".
		" and session_ip = '".$user_ip."'";
		$result = $db->sql_query($request);

		if ($db->sql_numrows($result) != 1) {
			if ( isset ( $server_config["disable_ip_check"] ) && $server_config["disable_ip_check"] == 1) {
				//Mise � jour de l'adresse ip de session si le contr�le des ip est d�sactiv�
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
* Mise � jour des sessions dans la BDD 
*/
function session_set_user_id($user_id, $lastvisit=0) {
	global $db, $user_ip, $cookie_id, $server_config;
	global $HTTP_COOKIE_VARS;

	$request = "update ".TABLE_SESSIONS." set session_user_id = ".$user_id.
	", session_lastvisit = ".$lastvisit.
	" where session_id = '".$cookie_id."'";
	if ( isset ( $server_config["disable_ip_check"] ) && $server_config["disable_ip_check"] != 1 )
	  $request .= " and session_ip = '".$user_ip."'";
	$db->sql_query($request);

	session_set_user_data($cookie_id);
}
/**
* Y a comme un probleme dans cette fonction... ne semble pas prendre de param�tres alors que la fonction pr�c�dente lui en donne un...
*/
function session_set_user_data($cookie_id) {
	global $db, $user_ip, $user_data, $user_auth, $server_config;
	global $link_css;

	$request = "select user_id, user_name, user_admin, user_coadmin, user_galaxy, user_system, user_skin, session_lastvisit, user_stat_name, ";
	$request .= "management_user, management_ranking, disable_ip_check";
	$request .= " from ".TABLE_USER." u, ".TABLE_SESSIONS." s";
	$request .= " where u.user_id = s.session_user_id";
	$request .= " and session_id = '".$cookie_id."'";
	$request .= " and session_ip = '".$user_ip."'";
	$result = $db->sql_query($request);

	if ($db->sql_numrows($result) == 1) {
		$user_data = $db->sql_fetch_assoc($result);
		if ($user_data["user_skin"] != "") $link_css = $user_data["user_skin"];
		else $link_css = $server_config["default_skin"];

		$user_auth = user_get_auth($user_data["user_id"]);
	}
	else {
		unset($user_data);
		unset($user_auth);
	}
}
/**
* Fermeture d'une session utilisateur
* @param int $user_id ID utilisateur , optionnel
*/
function session_close($user_id = false) {
	global $db, $user_ip, $cookie_id;

	if (!$user_id) {
		global $HTTP_COOKIE_VARS;

		$cookie_name = COOKIE_NAME;
		$cookie_id = $HTTP_COOKIE_VARS[$cookie_name];

		$request = "delete from ".TABLE_SESSIONS.
		" where session_id = '".$cookie_id."'";
		if ( isset ( $server_config["disable_ip_check"] ) && $server_config["disable_ip_check"] != 1 )
		  $request .= " and session_ip = '".$user_ip."'";
		$db->sql_query($request, true, false);
	}
	else {
		$request = "delete from ".TABLE_SESSIONS.
		" where session_user_id = ".$user_id;
		$db->sql_query($request, true, false);
	}
}

/**
* R�cup�ration des utiliReSoeur en ligne
*/
function session_whois_online() {
	global $db, $server_config;

	$cookie_time = ( $server_config["session_time"] == 0 ) ? 525600:$server_config["session_time"];

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
			$user_name = "Visiteur non identifi�";
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
