<?php
/***************************************************************************
*	filename	: user.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 15/11/2005
*	modified	: 22/08/2006 00:00:00
***************************************************************************/
/**
 * user.php Fonctions concernant les utilisateurs
 * @author Kyser
 * @version 1.0 Beta
* @package UniSpy
 */

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

//Vérification des droits
/**
* Verification des droits utilisateurs
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
 * Verification et Login d'un utilisateur
 * @modified ericalens 12/10/2006
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

				// ericalens: Redirection sur le $pub_goto défini ou sur la page par defaut
				if (!empty($pub_goto)) {
					redirection("index.php?action=".$pub_goto);
				} else {
					global $server_config;
					if (isset($server_config["default_login_page"])) {
						redirection("index.php?action=".$server_config["default_login_page"]);	
					}else redirection("index.php");
				}
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

// modifiée pour appel depuis module OGS Plugin
/**
* function user_ogs_login
* @param boolean default false $callfromogsplugin 
* @return 1 if inactive account|babyclass
* */
function user_ogs_login($callfromogsplugin=false) { // $callfromogsplugin=true permet d'éviter les redirections et les echo sur l'écran du navigateur
	global $db, $user_data, $user_auth, $server_config;
	global $pub_name, $pub_pass, $pub_ogsversion;

  if ($callfromogsplugin==false) {
    	if (!check_var($pub_name, "Pseudo_Groupname") || !check_var($pub_pass, "Password") || !check_var($pub_ogsversion, "Num")) {
    		die ("<!-- [ErrorFatal=19] Données transmises incorrectes  -->");
    	}
    
    	//Refus des version OGS antérieure à 060601
    	if (strcasecmp($pub_ogsversion, "060601") < 0) {
    		die ("<!-- [Login=0] La version d'univers Stratege utilisé n'est pas compatible avec ce serveur  -->");
    	}
	}

	if (isset($pub_name, $pub_pass)) {
		$request = "select user_id, user_active from ".TABLE_USER." where user_name = '".mysql_real_escape_string($pub_name)."' and user_password = '".md5(sha1($pub_pass))."'";
		$result = $db->sql_query($request);
		if (list($user_id, $user_active) = $db->sql_fetch_row($result)) {
			session_set_user_id($user_id);

			if ($user_auth["ogs_connection"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
				if ($callfromogsplugin==false) die ("<!-- [Login=0] [AccessDenied] Accès refusé  -->");
				else return 2; // connexion non autorisée
			}

			if ($user_active == 1) {
				$request = "update ".TABLE_USER." set user_lastvisit = ".time()." where user_id = ".$user_id;
				$db->sql_query($request);

				/*//Incompatible MySQL 4.0
				$request = "insert into ".TABLE_STATISTIC." values ('connection_ogs', '1')";
				$request .= " on duplicate key update statistic_value = statistic_value + 1";
				$db->sql_query($request);*/
				if ($callfromogsplugin==true) {
              $request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + 1";
      				$request .= " where statistic_name = 'connection_ogsplugin'";
      				$db->sql_query($request);
      				if ($db->sql_affectedrows() == 0) {
      					$request = "insert ignore into ".TABLE_STATISTIC." values ('connection_ogsplugin', '1')";
      					$db->sql_query($request);
      				}				
				} else {
              $request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + 1";
      				$request .= " where statistic_name = 'connection_ogs'";
      				$db->sql_query($request);
      				if ($db->sql_affectedrows() == 0) {
      					$request = "insert ignore into ".TABLE_STATISTIC." values ('connection_ogs', '1')";
      					$db->sql_query($request);
      				}
				}
			} else { // compte inactif
				    if ($callfromogsplugin==true) return 1; // compte inactif
			}
				
        if ($callfromogsplugin==false) log_('login_ogs');
				if ($callfromogsplugin==false) {
            echo "<!-- [Login=1] univers Stratege SharingDB -->"."\n";
    				echo "<!-- Servername = unispy -->"."\n";
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
		if ($callfromogsplugin==true) return 3; // paramètres login/mdp manquant
    else die ("<!-- [ErrorFatal=20] Données transmises incorrectes  -->");
}

/**
* Deconnection de l'utilisateur (log + femerture session)
* @version 3.02
*/
function user_logout() {
	log_("logout");
	session_close();
	redirection("index.php");
}
/**
* Verification de la validité de certaines variable
* @param string $type  "pseudo","groupname" ou "password"
* @param string $string chaine verifié
* @return boolean false si incorrect , la chaine verifié sinon
* @version 3.02
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

	$string = trim($string);
	if (strlen($string) < $length_min || strlen($string) > $length_max) {
		return false;
	}

	return $string;
}

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
* Regeneration du mot de passe utilisateur par l'admin
* Utilise $pub_user_id 
* @version 3.02
*/
function admin_regeneratepwd() {
	global $user_data;
	global $pub_user_id;

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

	$password = password_generator();
	user_set_general($pub_user_id, null, $password);

	$info = $pub_user_id."n".$password;
	log_("regeneratepwd", $pub_user_id);
	redirection("index.php?action=message&id_message=regeneratepwd_success&info=".$info);
}

function member_user_set() {
	global $db, $user_data;
	global $pub_pseudo, $pub_old_password, $pub_new_password, $pub_new_password2, $pub_galaxy, $pub_system, $pub_skin, $pub_disable_ip_check, $pub_env_language;

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

	//Controle que le pseudo n'est pas déjà utilisé
	$request = "select * from ".TABLE_USER." where user_name = '".mysql_real_escape_string($pub_pseudo)."' and user_id <> ".$user_id;
	$result = $db->sql_query($request);
	if ($db->sql_numrows($result) != 0) {
		redirection("index.php?action=message&id_message=member_modifyuser_failed_pseudolocked&info");
	}

	if (is_null($pub_disable_ip_check) || $pub_disable_ip_check != 1) $pub_disable_ip_check = 0;

	user_set_general($user_id, $pub_pseudo, $pub_new_password, null, $pub_galaxy, $pub_system, $pub_skin, $pub_disable_ip_check, $pub_env_language);
	redirection("index.php?action=profile");
}

function user_set_general($user_id, $user_name = null, $user_password = null, $user_lastvisit = null, $user_galaxy = null, $user_system = null, $user_skin = null, $disable_ip_check = null, $env_language = null) {
	global $db, $user_data, $server_config;

	if (!isset($user_id)) {
		redirection("index.php?action=message&id_message=errorfatal&info");
	}

	if (!empty($user_galaxy)) {
		$user_galaxy = intval($user_galaxy);
		if ($user_galaxy < 1 || $user_galaxy > $server_config["nb_galaxy"]) $user_galaxy = 1;
	}
	if (!empty($user_system)) {
		$user_system = intval($user_system);
		if ($user_system < 1 || $user_system > $server_config["nb_system"]) $user_system = 1;
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


  // $pub_env_language
  
  	//changement de la langue de l'interface
	if (!empty($env_language))
	$update .= ((strlen($update)>0) ? ", " : "")."user_language = '".$env_language."'";

	$request = "update ".TABLE_USER." set ".$update." where user_id = ".$user_id;
	$db->sql_query($request);

	if ($user_id == $user_data['user_id']) {
		log_("modify_account");
	}
	else {
		log_("modify_account_admin", $user_id);
	}
}

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

function user_set_stat($planet_added_web = null, $planet_added_ogs = null, $search = null, $spy_added_web = null, $spy_added_ogs = null, $rank_added_web = null, $rank_added_ogs = null, $planet_exported = null, $spy_exported = null, $rank_exported = null) {
	global $db, $user_data;

	$update = "";

	//Statistiques envoie systèmes solaire et rapport d'espionnages
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
* Recupere une information sur un (tous les) utilisateurs
* @param $user_id optionnel id utilisateur dont on veut les informations
* @return array Tableau d'informations renvoyé par mysql
* @version 3.02
* @modified 23/11 renvoi de l'ensemble des valeurs (au cas ou il y aurait des champs ajoutés dans la table)
*/
function user_get($user_id = false) {
	global $db;

        $request = "select * from ".TABLE_USER;
//request = "select user_id, user_name, user_password, user_active, user_regdate, user_lastvisit,".
// user_galaxy, user_system, user_admin, user_coadmin, management_user, management_ranking, disable_ip_check".
// from ".TABLE_USER;

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

function user_get_auth($user_id) {
	global $db;

	$user_info = user_get($user_id);
	$user_info = $user_info[0];
	if ($user_info["user_admin"] == 1 || $user_info["user_coadmin"] == 1) {
		$user_auth = array("server_set_system" => 1, "server_set_spy" => 1, "server_set_ranking" => 1, "server_show_positionhided" => 1,
		"ogs_connection" => 1, "ogs_set_system" => 1, "ogs_get_system" => 1, "ogs_set_spy" => 1, "ogs_get_spy" => 1, "ogs_set_ranking" => 1, "ogs_get_ranking" => 1);

		return $user_auth;
	}

	$request = "select server_set_system, server_set_spy, server_set_ranking, server_show_positionhided,";
	$request .= " ogs_connection, ogs_set_system, ogs_get_system, ogs_set_spy, ogs_get_spy, ogs_set_ranking, ogs_get_ranking";
	$request .= " from ".TABLE_GROUP." g, ".TABLE_USER_GROUP." u";
	$request .= " where g.group_id = u.group_id";
	$request .= " and user_id = ".$user_id;
	$result = $db->sql_query($request);

	if ($db->sql_numrows($result) > 0) {
		$user_auth = array("server_set_system" => 0, "server_set_spy" => 0, "server_set_ranking" => 0, "server_show_positionhided" => 0,
		"ogs_connection" => 0, "ogs_set_system" => 0, "ogs_get_system" => 0, "ogs_set_spy" => 0, "ogs_get_spy" => 0, "ogs_set_ranking" => 0, "ogs_get_ranking" => 0);

		while ($row = $db->sql_fetch_assoc($result)) {
			if ($row["server_set_system"] == 1) $user_auth["server_set_system"] = 1;
			if ($row["server_set_spy"] == 1) $user_auth["server_set_spy"] = 1;
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

function user_create() {
	global $db, $user_data;
	global $pub_pseudo;

	if (!check_var($pub_pseudo, "Pseudo_Groupname")) {
		redirection("index.php?action=message&id_message=errordata&info=1");
	}

	if (!isset($pub_pseudo)) {
		redirection("index.php?action=message&id_message=createuser_failed_general&info");
	}

	//Vérification des droits
	user_check_auth("user_create");

	if (!check_var($pub_pseudo, "Pseudo_Groupname")) {
		redirection("index.php?action=message&id_message=createuser_failed_pseudo&info");
	}

	$password = password_generator();
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

		$request = "insert into ".TABLE_USER_GROUP." (group_id, user_id) values (1, ".$user_id.")";
		$db->sql_query($request);

		$info = $user_id."n".$password;
		log_("create_account", $user_id);
		redirection("index.php?action=message&id_message=createuser_success&info=".$info);
	}
	else {
		exit();
		redirection("index.php?action=message&id_message=createuser_failed_pseudolocked&info=".$pub_pseudo);
	}
}

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

// modifs par Naqdazar, ajout variable définition appelant hors interface(ogsplugin): $callfromogsplugin
function user_set_empire($callfromogsplugin=false) {
	global $pub_typedata, $pub_data, $pub_planet_id, $pub_planet_name, $pub_fields, $pub_coordinates, $pub_temperature, $pub_satellite;
	global $pub_xp_mineur, $pub_xp_raideur;

	if (!isset($pub_typedata) || !isset($pub_data)) {
		if ($callfromogsplugin==false) redirection("index.php?action=message&id_message=errorfatal&info");
		else return false;
	}

	switch ($pub_typedata) {
		case "E" :
		$callfuncresult = user_set_all_empire($pub_data, $callfromogsplugin);
		if ($callfromogsplugin==true) return $callfuncresult;
		break;

		case "T" :
		$callfuncresult = user_set_xp($pub_xp_mineur, $pub_xp_raideur);
		break;
		
		default :
  		if ($callfromogsplugin==false) redirection("index.php?action=message&id_message=errorfatal&info");
  		else return false;
		break;
	}

	if ($callfromogsplugin==false) redirection("index.php?action=home&subaction=empire");
	else return true;
}

function user_set_xp($xp_mineur,$xp_raideur){
global $db, $user_data;

	$request = "select count(user_id) from ".TABLE_USER_TECHNOLOGY." where user_id = ".$user_data["user_id"];
	$result = $db->sql_query($request);
	$result = $db->sql_fetch_row($result);

	if ($result[0] == "1") {
		$request = "update ".TABLE_USER_TECHNOLOGY." set `xp_mineur` = '".$xp_mineur."',
`xp_raideur` = '".$xp_raideur."' WHERE `user_id` =".$user_data["user_id"] ;
		$db->sql_query($request);
	} else {
		redirection("index.php?action=message&id_message=errorfatal&info");
	}
}
function user_set_all_empire($data, $callfromogsplugin=false) {
	global $db, $user_data;
	global $pub_view, $pub_xp_mineur, $pub_xp_raideur;
	global $LANG;

	$data = stripcslashes($data);
//Fonction empire by PastisD
	
	$test_ogs = explode(chr(10),$data);
	
	$a = 0;
	for ($i = 0;$i < count($test_ogs);$i++)
	{
	  if (preg_match("/".$LANG["Home_Empire"]."(.*?)/",$test_ogs[$i])) 
	  {
	    $a = $i;
	  }
	}

	$ensemble = array();
	$noms = array('empire', 'production', 'stock', 'batiments', 'Flottes', 'divers', 'defenses', 'technologies');
	// supprime du tableau $test_ogs la partie production
	// Peut être utilisé plus tard dans une evolution de unispy :)
	$ensemble['empire'] = array_splice($test_ogs,$a,4);
	$ensemble['production'] = array_splice($test_ogs,$a+1,4);
	$ensemble['stock'] = array_splice($test_ogs,$a+2,3);
	$ensemble['batiments'] = array_splice($test_ogs,$a+3,15);
	$ensemble['Flottes'] = array_splice($test_ogs,$a+4,13);
	$ensemble['divers'] = array_splice($test_ogs,$a+5,1);
	$ensemble['defenses'] = array_splice($test_ogs,$a+6,10);
	$ensemble['technologies'] = array_splice($test_ogs,$a+7,20);


	// Découpage en tableau multi-dimensionnel
	// Les [\s] servent au découpage.
	// Le tableau contiendra tous ce qu'il y a dans la "vue globale"
	foreach($noms as $nom)
	{
	  for ($i = 0;$i < count($ensemble[$nom]);$i++)
	  {
	    $ensemble[$nom][$i] = array_map('trim',preg_split("/[\s]+[\s]+/",$ensemble[$nom][$i]));
	  }
	}
	for($i=0;$i<count($ensemble['technologies']);$i++)
	{
	array_shift($ensemble['technologies'][$i]);
	}
	for($i=0;$i<count($ensemble['batiments']);$i++)
	{
	$ensemble['batiments'][$i] = str_replace("X",0,$ensemble['batiments'][$i]);
	}
	
	for($i=1; $i<=count($ensemble[$nom][1]); $i++) {
			// ajout Naqdazar
			$planetname = $ensemble['empire'][0][$i];
			$coordinates = str_replace(array("[","]"),"",$ensemble['empire'][1][$i]);
			$case = substr($ensemble['empire'][2][$i],-3,3);

			preg_match("#\D+\d+\D+(\d+)\D+#",$ensemble['empire'][3][$i],$arr);
			$temperature = $arr[1];
			
			$request = "update ".TABLE_USER_BUILDING." set coordinates = '".$coordinates."', `fields` = ".$case." , Sat = ".$ensemble['divers'][0][$i];
			$request .= ",temperature=".$temperature.", Ti = ".$ensemble['batiments'][0][$i].", Ca = ".$ensemble['batiments'][1][$i].", Tr = ".$ensemble['batiments'][2][$i];
			$request .= ", CG = ".$ensemble['batiments'][3][$i].", CaT = ".$ensemble['batiments'][4][$i].", UdD = ".$ensemble['batiments'][5][$i];
			$request .= ", UdA = ".$ensemble['batiments'][6][$i].", UA = ".$ensemble['batiments'][7][$i].", STi = ".$ensemble['batiments'][8][$i];
			$request .= ", SCa = ".$ensemble['batiments'][9][$i].", STr = ".$ensemble['batiments'][10][$i].", CT = ".$ensemble['batiments'][11][$i];
			$request .= ", Ter = ".$ensemble['batiments'][12][$i].", HM = ".$ensemble['batiments'][13][$i].", CM = ".$ensemble['batiments'][14][$i].", planet_name = '".$planetname."'";
			$request .= " where user_id = ".$user_data["user_id"]." and planet_id = ".$i;
			
			$db->sql_query($request);
			if ($db->sql_affectedrows() == 0) {
				$request = "insert ignore into ".TABLE_USER_BUILDING." (user_id, planet_id, planet_name, coordinates, `fields`, temperature, Sat, Ti, Ca, Tr, CG, CaT, UdD, UdA, UA, STi, SCa, STr, CT, CM, Ter, HM)";
				$request .= " values (".$user_data["user_id"].", ".$i.", '".$planetname."', '".$coordinates."', ".$case.", ".$temperature.", ".$ensemble['divers'][0][$i];
				$request .= ", ".$ensemble['batiments'][0][$i].", ".$ensemble['batiments'][1][$i].", ".$ensemble['batiments'][2][$i];
				$request .= ", ".$ensemble['batiments'][3][$i].", ".$ensemble['batiments'][4][$i].", ".$ensemble['batiments'][5][$i];
				$request .= ", ".$ensemble['batiments'][6][$i].", ".$ensemble['batiments'][7][$i].", ".$ensemble['batiments'][8][$i];
				$request .= ", ".$ensemble['batiments'][9][$i].", ".$ensemble['batiments'][10][$i].", ".$ensemble['batiments'][11][$i];
				$request .= ", ".$ensemble['batiments'][12][$i].", ".$ensemble['batiments'][13][$i].", ".$ensemble['batiments'][14][$i].")";
				$db->sql_query($request);
			}

			$request = "delete from ".TABLE_USER_DEFENCE." where user_id = ".$user_data["user_id"]." and planet_id= ".$i;
			$db->sql_query($request);

			$request = "insert into ".TABLE_USER_DEFENCE." (user_id, planet_id, BFG, SBFG, PFC, DeF, PFI, AMD, CF, Ho, CME, EMP)";
			$request .= " values (".$user_data["user_id"].", ".$i.", ".$ensemble['defenses'][0][$i].", ".$ensemble['defenses'][1][$i].",".$ensemble['defenses'][2][$i].", ".$ensemble['defenses'][3][$i].", ".$ensemble['defenses'][4][$i].", ".$ensemble['defenses'][5][$i].", ".$ensemble['defenses'][6][$i].", ".$ensemble['defenses'][7][$i].", ".$ensemble['defenses'][8][$i].", ".$ensemble['defenses'][9][$i].")";
			$db->sql_query($request);
		}
		
			$request = "delete from ".TABLE_USER_TECHNOLOGY." where user_id = ".$user_data["user_id"];
			$db->sql_query($request);

			$request = "insert into ".TABLE_USER_TECHNOLOGY." (user_id, esp, Qua, Alli, SC, Raf, Armes, Bouclier, Blindage, Ther, Anti, HD, Imp, Warp, Smart, Ions, Aereon, Sca, Graviton, Admi, Expl";	
			$request .= ", xp_mineur, xp_raideur";
			$request .= ")";
			$request .= " values (".$user_data["user_id"].", ";

			for($i=0;$i<20;$i++){
				$request .= (max($ensemble['technologies'][$i]) == "-")? 0 : max($ensemble['technologies'][$i]);
				if($i<19)
					$request .= ",";
			}
			$request .= ", ".$pub_xp_mineur.",".$pub_xp_raideur;
			$request .= ")";

			$db->sql_query($request);
		


/*    if ($callfromogsplugin==false) {
    		if($pub_view=="planets") redirection("index.php?action=home&subaction=empire&view=".$pub_view."&alert_empire=true");
    		else redirection("index.php?action=home&subaction=empire&view=".$pub_view);
		} else return true;*/
}

function user_get_empire() {
	global $db, $user_data;

	$planet = array(false, "user_id" => "", "planet_name" => "", "coordinates" => "",
	"fields" => "", "fields_used" => "", "temperature" => "", "Sat" => "",
	"Ti" => 0, "Ca" => 0, "Tr" => 0,
	"CG" => 0, "CaT" => 0,
	"UdD" => 0, "UdA" => 0, "UA" => 0,
	"STi" => 0, "SCa" => 0, "STr" => 0,
	"CT" => 0, "CM" =>0, "Ter" => 0,
	"HM" => 0);

	$defence = array("BFG" => 0, "SBFG" => 0, "PFC" => 0,
	"DeF" => 0, "PFI" => 0, "AMD" => 0,
	"CF" => 0, "Ho" => 0,
	"CME" => 0, "EMP" => 0);

	$request = "select planet_id, planet_name, coordinates, `fields`, temperature, Sat, Ti, Ca, Tr, CG, CaT, UdD, UdA, UA, STi, SCa, STr, CT, CM, Ter, HM";
	$request .= " from ".TABLE_USER_BUILDING;
	$request .= " where user_id = ".$user_data["user_id"];
	$request .= " order by planet_id";
	$result = $db->sql_query($request);
	
	$nb_planets = $db->sql_numrows($result);
	$user_building = array_fill(1,$nb_planets>0?$nb_planets:1, $planet);
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

	$request = "select Esp, Qua, Alli, SC, Raf, Armes, Bouclier, Blindage, Ther, Anti, HD, Imp, Warp, Smart, Ions, Aereon, Sca, Graviton, Admi, Expl, xp_mineur, xp_raideur";
	$request .= " from ".TABLE_USER_TECHNOLOGY;
	$request .= " where user_id = ".$user_data["user_id"];
	$result = $db->sql_query($request);

	$user_technology = $db->sql_fetch_assoc($result);

	$request = "select planet_id, BFG, SBFG, PFC, DeF, PFI, AMD, CF, Ho, CME, EMP";
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
	
	$request = "UPDATE ".TABLE_USER_BUILDING." SET `planet_id` = `planet_id`-1 WHERE `planet_id`>".intval($pub_planet_id);
	$db->sql_query($request);
	
	$request = "UPDATE ".TABLE_USER_DEFENCE." SET `planet_id` = `planet_id`-1 WHERE `planet_id`>".intval($pub_planet_id);
	$db->sql_query($request);
	
	$request = "select * from ".TABLE_USER_BUILDING;
	$result = $db->sql_query($request);
	if ($db->sql_numrows($result) == 0) {
		$request = "delete from ".TABLE_USER_TECHNOLOGY." where user_id = ".$user_data["user_id"];
		$db->sql_query($request);
	}

	redirection("index.php?action=home&subaction=empire&view=".$pub_view);
}

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


	redirection("index.php?action=home&subaction=empire");
}

//Ajout d'un système favoris
function user_add_favorite() {
	global $db, $user_data, $server_config;
	global $pub_galaxy, $pub_system;

	if (!isset($pub_galaxy) || !isset($pub_system)) {
		redirection("index.php");
	}
	if (intval($pub_galaxy) < 1 || intval($pub_galaxy) > $server_config["galaxy"] || intval($pub_system) < 1 || intval($pub_system) > $server_config["system"]) {
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

//Suppression d'un système favoris
function user_del_favorite() {
	global $db, $user_data;
	global $pub_galaxy, $pub_system;

	if (!isset($pub_galaxy) || !isset($pub_system)) {
		redirection("index.php");
	}
	if (intval($pub_galaxy) < 1 || intval($pub_galaxy) > $server_config["galaxy"] || intval($pub_system) < 1 || intval($pub_system) > $server_config["system"]) {
		redirection("index.php?action=galaxy");
	}
	$request = "delete from ".TABLE_USER_FAVORITE." where user_id = ".$user_data["user_id"]." and galaxy = '".$pub_galaxy."' and system = ".$pub_system;
	$db->sql_query($request);

	redirection("index.php?action=galaxy&galaxy=".$pub_galaxy."&system=".$pub_system."");
}


//Récupération des rapports favoris
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

	$request = "select ".TABLE_USER_SPY.".spy_id, spy_galaxy, spy_system, spy_row, datadate, sender_id, ".TABLE_UNIVERSE.".ally, ".TABLE_UNIVERSE.".player, ".TABLE_UNIVERSE.".status";
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

//Ajout d'un rapport favoris
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

//Suppression d'un rapport favoris
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
 * Création d'un groupe $pub_groupname
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
 * Suppression du groupe $pub_group_id
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
	
	$request = "delete from ".TABLE_MOD_PERMS." where group_id = ".intval($pub_group_id);
	$db->sql_query($request);
	
	redirection("index.php?action=administration&subaction=group");
}

/**
* Retourne les acces à un mod donné
* @param : ID du groupe et ID du mod
* @ return bool vrai si groupe peut acceder au mod
* @ author itori 22/07/2007
* @Unispy version 1.1
*/
function group_mod_perms($group, $mod) {
global $db;
	
	if(empty($group)) return false;
	
	$request = "SELECT count(group_id) FROM ".TABLE_GROUP_PERMS." WHERE group_id = ".intval($group)." and mod_id=".intval($mod);
	$result = $db->sql_query($request);
	$result = $db->sql_fetch_row($result);
	return ($result[0] > 0 ? true : false);
}


/**
 * Verifie si l'utilisateur en cours est dans un groupe donné
 * @param mixed group ID du groupe OU Nom du groupe
 * @return bool vrai si l'utilisateur appartient au groupe
 * @author tsyr2ko 28/11/2006
 * @version 3.10
 */
function user_is_in_group($group) {

	global $db,$user_data;

	if (empty($group)) return false;

	$group_id = false;
	$group_name = false;

	if (is_int($group)) $group_id = true;
	else if (is_string($group)) $group_name = true;
	else return false;

	$request = "SELECT COUNT(user_id) FROM ";
    if ($group_name) {
        $request .= TABLE_GROUP . " AS gr LEFT JOIN " . TABLE_USER_GROUP . " AS user_gr ON gr.group_id = user_gr.group_id";
        $request .= " WHERE group_name = '" . mysql_real_escape_string($group) . "'";
    }
    else {
        $request .= TABLE_USER_GROUP;
        $request .= " WHERE group_id = '" . intval($group) . "'";
    }
    $request .= " AND user_id = '" . intval($user_data["user_id"]) . "' LIMIT 1";

	$result = $db->sql_query($request);
	list($isingroup) = $db->sql_fetch_row($result);
	
	return ($isingroup > 0 ? true : false);
}


/**
* Verifie si un user appartiens à un group ayant acces à un mod donné
* @return bool vrai si user peut acceder
* @author Itori 22/07/07
*/
function user_as_perms($user_id, $mod_id) {
	global $db;
	$ok = false;
	
	$group = usergroup_group($user_id);
	$request = "SELECT count(group_id) FROM ".TABLE_GROUP_PERMS." WHERE mod_id='".$mod_id."' ";
	$request .= "AND group_id in (";
	foreach($group as $group_id) {
		if ($ok) $request .= ",";
		$request .= $group_id['group_id'];
		$ok = true;
	}
	$request .= ")";
	$result = $db->sql_query($request);
	$result = $db->sql_fetch_row($result);
	
	return ($result[0] > 0 ? true:false);
}

/* version originale si problème(s) ... 
function user_is_in_group($groupname) {

	global $db,$user_data;

	if (empty($groupname)) return false;

	$request = "select group_id from ".TABLE_GROUP." where group_name like '".mysql_real_escape_string($groupname)."' limit 1";
	$result = $db->sql_query($request);

	if ( list($group_id) = $db->sql_fetch_row($result) ) {

		$request="SELECT count(*)"
			." FROM ".TABLE_USER_GROUP
			." WHERE user_id='".intval($user_data["user_id"])."' AND group_id='".$group_id."'";
		$result = $db->sql_query($request);

		list($isingroup) = $db->sql_fetch_row($result);

		if ($isingroup>=1) return true;
	}

	return false;
}
*/

/**
* Recupère les informations (row) de tout les groupes utilisateurs unispy
* @param int $group_id optionnel : id du groupe dont on veut recuperer les informations
* @return array tableau contenant les informations de groupes ou false
*/
function usergroup_get($group_id = false) {
	global $db, $user_data;

	//Vérification des droits
	user_check_auth("usergroup_manage");

	$request = "select group_id, group_name, ";
	$request .= " server_set_system, server_set_spy, server_set_ranking, server_show_positionhided,";
	$request .= " ogs_connection, ogs_set_system, ogs_get_system, ogs_set_spy, ogs_get_spy, ogs_set_ranking, ogs_get_ranking, unlimited_ratio";
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

function usergroup_setauth() {
	global $db, $user_data;
	global $pub_group_id, $pub_group_name,
	$pub_server_set_system, $pub_server_set_spy, $pub_server_set_ranking, $pub_server_show_positionhided,
	$pub_ogs_connection, $pub_ogs_set_system, $pub_ogs_get_system, $pub_ogs_set_spy, $pub_ogs_get_spy, $pub_unlimited_ratio,
	$pub_ogs_set_ranking, $pub_ogs_get_ranking;

	if (!check_var($pub_group_id, "Num") || !check_var($pub_group_name, "Pseudo_Groupname") ||
	!check_var($pub_server_set_system, "Num") || !check_var($pub_server_set_spy, "Num") || !check_var($pub_server_set_ranking, "Num") ||
	!check_var($pub_server_show_positionhided, "Num") || !check_var($pub_ogs_connection, "Num") || !check_var($pub_ogs_set_system, "Num") ||
	!check_var($pub_ogs_get_system, "Num") || !check_var($pub_ogs_set_spy, "Num") || !check_var($pub_ogs_get_spy, "Num") || !check_var($pub_unlimited_ratio, "Num") ||
	!check_var($pub_ogs_set_ranking, "Num") || !check_var($pub_ogs_get_ranking, "Num")) {
		redirection("index.php?action=message&id_message=errordata&info");
	}

	if (!isset($pub_group_id) || !isset($pub_group_name)) {
		redirection("index.php?action=message&id_message=errorfatal&info");
	}
	
	if (is_null($pub_server_set_system)) $pub_server_set_system = 0;
	if (is_null($pub_server_set_spy)) $pub_server_set_spy = 0;
	if (is_null($pub_server_set_ranking)) $pub_server_set_ranking = 0;
	if (is_null($pub_server_show_positionhided)) $pub_server_show_positionhided = 0;
	if (is_null($pub_ogs_connection)) $pub_ogs_connection = 0;
	if (is_null($pub_ogs_set_system)) $pub_ogs_set_system = 0;
	if (is_null($pub_ogs_get_system)) $pub_ogs_get_system = 0;
	if (is_null($pub_ogs_set_spy)) $pub_ogs_set_spy = 0;
	if (is_null($pub_ogs_get_spy)) $pub_ogs_get_spy = 0;
	if (is_null($pub_unlimited_ratio)) $pub_unlimited_ratio = 0;
	if (is_null($pub_ogs_set_ranking)) $pub_ogs_set_ranking = 0;
	if (is_null($pub_ogs_get_ranking)) $pub_ogs_get_ranking = 0;

	//Vérification des droits
	user_check_auth("usergroup_manage");

	log_("modify_usergroup", $pub_group_id);

	$request = "update ".TABLE_GROUP;
	$request .= " set group_name = '".mysql_real_escape_string($pub_group_name)."',";
	$request .= " server_set_system = '".intval($pub_server_set_system)."', server_set_spy = '".intval($pub_server_set_spy)."', server_set_ranking = '".intval($pub_server_set_ranking)."', server_show_positionhided = '".intval($pub_server_show_positionhided)."',";
	$request .= " ogs_connection = '".intval($pub_ogs_connection)."', ogs_set_system = '".intval($pub_ogs_set_system)."', ogs_get_system = '".intval($pub_ogs_get_system)."', ogs_set_spy = '".intval($pub_ogs_set_spy)."', ogs_get_spy = '".intval($pub_ogs_get_spy)."', unlimited_ratio = '".intval($pub_unlimited_ratio)."', ogs_set_ranking = '".intval($pub_ogs_set_ranking)."', ogs_get_ranking = '".intval($pub_ogs_get_ranking)."'";
	$request .= " where group_id = ".intval($pub_group_id);
	$db->sql_query($request);

	redirection("index.php?action=administration&subaction=group&group_id=".$pub_group_id);
}

/**
* Définie les permissions de mod pour le groupe
**/
function usergroup_setgroupperms() {
global $db;
global $pub_perms, $pub_group_id;

$perms = $pub_perms;
$group_id = $pub_group_id;

	if(!empty($perms) && !empty($group_id)){
	$request = "DELETE FROM ".TABLE_GROUP_PERMS." WHERE group_id=".$group_id;
	$db->sql_query($request);
	
	$request = "INSERT INTO ".TABLE_GROUP_PERMS."(group_id, mod_id) VALUES ";
	$next = false;
	foreach ($perms as $key => $mod) {
		if ($mod == "Y") {
			if ($next) $request .= ",";
			$request .= "('".$group_id."','".$key."')";
			$next = true;
		}
	}
	if ($next == true) $db->sql_query($request);
	}
redirection("index.php?action=administration&subaction=group&group_id=".$group_id);
}
/**
 * Renvoi les membres du groupe $group_id
 * @param int $group_id l'ID du groupe
 * @return array un tableau contenant le nom et utilisateur du groupe
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
* Renvoi les groupes du membre $user_id
* @param int $user_id l'ID de l'user
* @return array un tableau contenant l'id et le nom du groupe
*/
function usergroup_group($user_id) {
	global $db;
	
	if (!isset($user_id) || !is_numeric($user_id))redirection("index.php?action=message&id_message=errorfatal&info");
	
	$usergroup_group = array();
	
	$request = "select g.group_id, group_name from ".TABLE_GROUP." g, ".TABLE_USER_GROUP." ug";
	$request .= " where g.group_id = ug.group_id";
	$request .= " and user_id = ".intval($user_id);
	$request .= " order by group_id";
	$result = $db->sql_query($request);
	while ($row = $db->sql_fetch_assoc()){
		$usergroup_group[] = $row;
	}
	return $usergroup_group;
}

/**
 * Ajoute un nouveau utilisateur à un groupe
 * Les données sont passés via les globals $pub_user_id et $pub_group_id
 */
function usergroup_newmember() {
	global $db, $user_data;
	global $pub_user_id, $pub_group_id;

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

function user_set_stat_name($user_stat_name) {
	global $db, $user_data;

	$request = "update ".TABLE_USER." set user_stat_name = '".$user_stat_name."' where user_id = ".$user_data['user_id'];
	$db->sql_query($request);
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
	$sqlrecup = "SELECT planet_added_web, planet_added_ogs, planet_exported, search, spy_added_web, spy_added_ogs, spy_exported, rank_added_web, rank_added_ogs, rank_exported FROM ".TABLE_USER." WHERE user_id=".$player;
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
	
	//retourne le ratio	et calculs intermédiaires
	return $array;
}
/**
 * Fonction de test du ratio illimité
 */
function ratio_is_unlimited() {
    global $db, $user_data;
    
    if($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_user"] == 1) {
        return true;
    }
    else {  
        $query = "SELECT group_id FROM `".TABLE_GROUP."` WHERE unlimited_ratio = '1'";
        $result = $db->sql_query($query);
        while($row = $db->sql_fetch_row($result))
        {
            $group = intval($row[0]);
            if (user_is_in_group($group)){ return true; }
        }
        return false;
    }
}
?>
