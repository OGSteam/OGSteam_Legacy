<?php
/**
* Config.php Donn�es globales.
* - Definition des tables
* - Creation des repertoires de journalisation
* - Forcage des Locales
 * @version 1.0 Beta
* @package UniSpy
* @subpackage main
*  @author Kyser & OGSteam
*  @link http://www.ogsteam.fr
*  @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

setlocale(LC_CTYPE, 'fr_FR.ISO-8859-1');

if (version_compare(PHP_VERSION, "5.1.0RC1") >= 0) {
	date_default_timezone_set("Europe/Paris");
}

if (!defined("INSTALL_IN_PROGRESS")) {
	//Tables utilis� par les programmes
	define("TABLE_CONFIG", $table_prefix."config");
	define("TABLE_GROUP", $table_prefix."group");
	define("TABLE_RANK_PLAYER_FLEET", $table_prefix."rank_player_fleet");
	define("TABLE_RANK_PLAYER_POINTS", $table_prefix."rank_player_points");
	define("TABLE_RANK_PLAYER_RESEARCH", $table_prefix."rank_player_research");
	define("TABLE_RANK_ALLY_FLEET", $table_prefix."rank_ally_fleet");
	define("TABLE_RANK_ALLY_POINTS", $table_prefix."rank_ally_points");
	define("TABLE_RANK_ALLY_RESEARCH", $table_prefix."rank_ally_research");
	define("TABLE_SESSIONS", $table_prefix."sessions");
	define("TABLE_SPY", $table_prefix."spy");
	define("TABLE_STATISTIC", $table_prefix."statistics");
	define("TABLE_UNIVERSE", $table_prefix."universe");
	define("TABLE_UNIVERSE_TEMPORARY", $table_prefix."universe_temporary");
	define("TABLE_USER", $table_prefix."user");
	define("TABLE_USER_BUILDING", $table_prefix."user_building");
	define("TABLE_USER_DEFENCE", $table_prefix."user_defence");
	define("TABLE_USER_FAVORITE", $table_prefix."user_favorite");
	define("TABLE_USER_GROUP", $table_prefix."user_group");
	define("TABLE_USER_SPY", $table_prefix."user_spy");
	define("TABLE_USER_TECHNOLOGY", $table_prefix."user_technology");
	define("TABLE_USER_PLANET", $table_prefix."user_planet");
	define("TABLE_MOD", $table_prefix."mod");
	define("TABLE_GROUP_PERMS", $table_prefix."group_perms");
}


//Param�tres session
define("COOKIE_NAME", "unispy_id");



//Activation du mode d�buggage
define("MODE_DEBUG", FALSE);

//Chemin d"acc�s aux ressources
if (!defined("INSTALL_IN_PROGRESS") && !defined("UPGRADE_IN_PROGRESS") && !defined("GRAPHIC")) define("PATH_LOG", "journal/");
else define("PATH_LOG", "../journal/");
$path_log_today = PATH_LOG.date("ymd")."/";
if (!is_dir($path_log_today)) {
	mkdir($path_log_today, 0777);
	fopen("$path_log_today/index.htm", "a");
}
define("PATH_LOG_TODAY", PATH_LOG.date("ymd")."/");



//Banni�re unispy
$banner_selected = "logo.png";
?>
