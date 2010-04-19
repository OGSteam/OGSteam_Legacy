<?php

/**
 * Fonctions OGS_protocol ( ofi, petit potam , et qui sait ...)
 * @package OGSpy
 * @subpackage main
 * @author Machine
 * @copyright Copyright &copy; 2007, http://ogsteam.fr/
 */

if (!defined('IN_SPYOGAME'))
	die("Hacking attempt");

/**
 * Login d'un utilisateur OGS_protocol
 */
function user_ogs_login()
{
	global $db, $user_data, $user_auth, $server_config;
			global $pub_name, $pub_pass, $pub_ogsversion;
	
			if (!check_var($pub_name, "Pseudo_Groupname") || !check_var($pub_pass, "Password") || !check_var($pub_ogsversion, "Num")) {
					die ("<!-- [ErrorFatal=19] Données transmises incorrectes  -->");
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
									echo "<!-- ServerInfo = By Kyser , http://ogsteam.fr -->"."\n\n";

	
									exit();
							}
					}
			}
			die ("<!-- [ErrorFatal=20] Données transmises incorrectes  -->");
}

/**
 * verif presence mod petit potam
 */
function verif_petitpotam()
{
	global $db, $user_data, $user_auth, $server_config;
	global $pub_name, $pub_pass, $pub_ogsversion;
	$retour = false;
	$request = "select action , active FROM " . TABLE_MOD ." where action = 'petitpotam'  and active = 1 ";
	$mod = $db->sql_query($request);
	if (!$db->sql_numrows($mod)) {
		$retour = false;
	} else {
		$retour = true;
	}

	return $retour ; }


?>
