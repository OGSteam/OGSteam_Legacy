<?php
/***************************************************************************
*	filename	: common.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 15/11/2005
*	modified	: 30/08/2006 00:00:00
***************************************************************************/
/**
* Common.php contient toute l'initialisation d'OGSPY.
*  - Inclusion des différents fichiers de fonctions du repertoire include
*  - Suppression des données utilisateurs comprométantes
*  - Connection à la base de donnée via l'initiation de $db
*  @package OGSpy
*  @subpackage main
*  @author Kyser
*  @link http://ogs.servebbs.net
*/
if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

//Récupération des valeur GET, POST, COOKIE
@import_request_variables('GP', "pub_");

foreach ($_GET as $secvalue) {
	if ((eregi("<[^>]*script*\"?[^>]*>", $secvalue)) ||
	(eregi("<[^>]*object*\"?[^>]*>", $secvalue)) ||
	(eregi("<[^>]*iframe*\"?[^>]*>", $secvalue)) ||
	(eregi("<[^>]*applet*\"?[^>]*>", $secvalue)) ||
	(eregi("<[^>]*meta*\"?[^>]*>", $secvalue)) ||
	(eregi("<[^>]*style*\"?[^>]*>", $secvalue)) ||
	(eregi("<[^>]*form*\"?[^>]*>", $secvalue)) ||
	(eregi("<[^>]*img*\"?[^>]*>", $secvalue)) ||
	(eregi("\([^>]*\"?[^)]*\)", $secvalue)) ||
	(eregi("\"", $secvalue))) {
		die ("I don't like you...");
	}
}

foreach ($_POST as $secvalue) {
    if ((eregi("<[^>]*script*\"?[^>]*>", $secvalue)) ||    (eregi("<[^>]*style*\"?[^>]*>", $secvalue))) {
        Header("Location: index.php");
        die();
    }
}

//Récupération des paramètres de connexion à la base de données
require_once("parameters/id.php");
if (!defined("OGSMARKET_INSTALLED") && !defined("INSTALL_IN_PROGRESS") && !defined("UPGRADE_IN_PROGRESS")) {
	header("Location: install/index.php");
	exit();
}

//Appel des fonctions
require_once("includes/config_install.php");
require_once("includes/functions.php");
require_once("includes/mysql.php");
require_once("includes/login.php");
require_once("includes/functions2.php");
require_once("includes/user.php");
//require_once("includes/sessions.php");
//require_once("includes/help.php");
//require_once("includes/mod.php");

//Connexion à la base de données
if (!defined("INSTALL_IN_PROGRESS")) {
	$db = false;
	if (is_array($db_host)) {
		for ($i=0 ; $i<sizeof($db_host) ; $i++) {
			$db = new sql_db($db_host[$i], $db_user[$i], $db_password[$i], $db_database[$i]);
			if ($db->db_connect_id) {
				break;
			}
		}
	}
	else {
		$db = new sql_db($db_host, $db_user, $db_password, $db_database);
	}

	if (!$db->db_connect_id) {
		die("".$LANG["common_impo"]."");
	}

	//Récupération et encodage de l'adresse ip
	$user_ip = $_SERVER['REMOTE_ADDR'];
	$user_ip = encode_ip($user_ip);

	init_serverconfig();

	if (!defined("UPGRADE_IN_PROGRESS")) {
		session();
		maintenance_action();
	}
}

?>
