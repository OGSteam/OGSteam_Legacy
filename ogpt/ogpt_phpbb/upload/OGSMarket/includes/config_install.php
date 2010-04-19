<?php
/**
* Config.php Données globales.
* - Definition des tables
* - Creation des repertoires de journalisation
* - Forcage des Locales
* @package OGSpy
* @subpackage main
* @author Kyser
* @link http://ogs.servebbs.net
*/
if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

setlocale(LC_CTYPE, 'fr_FR.ISO-8859-1');

if (version_compare(PHP_VERSION, "5.1.0RC1") >= 0) {
	date_default_timezone_set("Europe/Paris");
}

if (!defined("INSTALL_IN_PROGRESS")) {
	//Tables utilisé par les programmes
	define("TABLE_CONFIG", $table_prefix."config");
	define("TABLE_SESSIONS", $table_prefix."sessions");
	define("TABLE_STATISTIC", $table_prefix."statistics");
	define("TABLE_UNIVERS", $table_prefix."univers");
	define("TABLE_USER", $phpbb_table_prefix."user");
	define("TABLE_INFOS", $table_prefix."infos");
	define("TABLE_COMMENT", $table_prefix."comment");
	define("TABLE_MENU", $table_prefix."menu");
	define("TABLE_TRADE", $table_prefix."trade");
	define("TABLE_TRADE_DEALS", $table_prefix."trade_deals");
	define("TABLE_OGSPY", $table_prefix."user_ogspy_auth");

}


//Paramètres session
define("COOKIE_NAME", "ogsmarket_id");



//Activation du mode débuggage
define("MODE_DEBUG", FALSE);

//Chemin d"accès aux ressources
if (!defined("INSTALL_IN_PROGRESS") && !defined("UPGRADE_IN_PROGRESS") && !defined("GRAPHIC")) define("PATH_LOG", "journal/");
else define("PATH_LOG", "../journal/");
$path_log_today = PATH_LOG.date("ymd")."/";
if (!is_dir($path_log_today)) {
	mkdir($path_log_today, 0777);
	fopen("$path_log_today/index.htm", "a");
}
define("PATH_LOG_TODAY", PATH_LOG.date("ymd")."/");



//Bannière OGSPY
$banner[] = "";
$banner[] = "";
$banner[] = "";

srand(time());
shuffle($banner);
$banner_selected = $banner[0];
?>
