<?php
/***************************************************************************
*	filename	: common.php
*	desc.		:
*	Author		: Kyser - http://ogs.servebbs.net/
*	created		: 15/11/2005
*	modified	: 22/08/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
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
if (!defined("OGSPY_INSTALLED") && !defined("INSTALL_IN_PROGRESS") && !defined("UPGRADE_IN_PROGRESS")) {
	header("Location: install/index.php");
	exit();
}

//Appel des fonctions
require_once("includes/config.php");
require_once("includes/functions.php");
require_once("includes/mysql.php");
require_once("includes/log.php");
require_once("includes/galaxy.php");
require_once("includes/user.php");
require_once("includes/sessions.php");
require_once("includes/help.php");
require_once("includes/mod.php");

//Connexion à la base de donnnées
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
		die("Impossible de se connecter à la base de données");
	}

	//Récupération et encodage de l'adresse ip
	$user_ip = $_SERVER['REMOTE_ADDR'];

	init_serverconfig();

	if (!defined("UPGRADE_IN_PROGRESS")) {
		session();
		maintenance_action();
	}
}

//BBClone
define("_BBC_PAGE_NAME", "OGSpy server");
define("_BBCLONE_DIR", "bbclone/");
define("COUNTER", _BBCLONE_DIR."mark_page.php");
if (is_readable(COUNTER)) include_once(COUNTER);

if (MODE_DEBUG) {
	error_reporting(E_ALL);
}
?>