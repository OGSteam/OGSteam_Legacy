<?php
/** 
* Common.php contient toute l'initialisation d'UniSpy. 
 *  - Inclusion des différents fichiers de fonctions du repertoire include 
*  - Suppression des données utilisateurs comprométantes 
*  - Connection à la base de donnée via l'initiation de $db 
* @package UniSpy
*  @subpackage main 
*  @author Kyser & OGSteam
*  @link http://www.ogsteam.fr
*  @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/ 

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

// PHP5 with register_long_arrays off?
if (!isset($HTTP_POST_VARS) && isset($_POST))
{
    $HTTP_POST_VARS = $_POST;
    $HTTP_GET_VARS = $_GET;
    $HTTP_SERVER_VARS = $_SERVER;
    $HTTP_COOKIE_VARS = $_COOKIE;
    $HTTP_ENV_VARS = $_ENV;
    $HTTP_POST_FILES = $_FILES;

    // _SESSION is the only superglobal which is conditionally set
    if (isset($_SESSION))
    {
        $HTTP_SESSION_VARS = $_SESSION;
    }
}

//Récupération des valeur GET, POST, COOKIE
@import_request_variables('GP', "pub_");

while (@ob_end_clean()); // vidage contenu éventuel tampon pour inscription header





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
if (!defined("UNISPY_INSTALLED") && !defined("INSTALL_IN_PROGRESS") && !defined("UPGRADE_IN_PROGRESS")) {
  	header("Location: install/index.php");
	exit();
}



//******************************************************************************
//******************************************************************************

//Appel des fonctions
require_once("includes/config.php");
require_once("includes/functions.php");
require_once("includes/mysql.php");
require_once("includes/log.php");
require_once("includes/galaxy.php");
require_once("includes/user.php");
require_once("includes/sessions.php");
require_once("includes/mod.php");
// *****************************************************************************
//******************************************************************************



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
		die("<a>Error opening mysql database</a>:".mysql_error());
	}

	//Récupération et encodage de l'adresse ip
	$user_ip = $_SERVER['REMOTE_ADDR'];
	$user_ip = encode_ip($user_ip);

// Initilisation variable config
	init_serverconfig();

	if (!defined("UPGRADE_IN_PROGRESS")) {
		session();
		maintenance_action();
	}
}



//******************************************************************************
//Appel des fichiers linguistiques
// déplacement avant include autres script, nécessaire pour help.php

/* if (!empty($server_config['language'])) {
	include_once("language/lang_".$server_config['language']."/lang_main.php"); 
} else require_once("language/lang_english/lang_main.php"); //Fichier anglais en premier dans le but d'avoir au moins une traduction anglaise si elle n'est pas disponible dans la langue désirée */

// $user_menu_language remplacé par $server_config['language'], $user_menu_language  défini dans session_set_user_data() de sessions.php

/**
 * Note [Unibozu]: lors de l'installation il ne faut pas charger ces fichiers de langue
 */
if (!defined('INSTALL_IN_PROGRESS')) {
	if (isset($user_menu_language) && !empty($user_menu_language) ) {
		include_once("language/lang_".$user_menu_language."/lang_main.php"); 
	} else require_once("language/lang_french/lang_main.php");
	
	if (!empty($server_config['language_parsing'])) {
		include_once("language/lang_".$server_config['language_parsing']."/lang_parsing.php"); 
	} else require_once("language/lang_french/lang_parsing.php");
}

//******************************************************************************

require_once("includes/help.php");

//BBClone
define("_BBC_PAGE_NAME", "unispy server");
define("_BBCLONE_DIR", "bbclone/");
define("COUNTER", _BBCLONE_DIR."mark_page.php");
if (is_readable(COUNTER)) include_once(COUNTER);

if (MODE_DEBUG) {
	error_reporting(E_ALL);
}
?>
