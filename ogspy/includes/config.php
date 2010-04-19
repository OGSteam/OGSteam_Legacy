<?php
/** $Id$ **/
/**
* Fichier de configuration communes
* @package OGSpy
* @subpackage Main
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @modified $Date$
* @author Kyser
* @link $HeadURL$
* @version 3.04b ( $Rev$ ) 
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

setlocale(LC_CTYPE, 'fr_FR.ISO-8859-1');

if (version_compare(PHP_VERSION, "5.1.0RC1") >= 0) {
	date_default_timezone_set("Europe/Paris");
}

// Définitions des noms des tables de la BDD
if (!defined("INSTALL_IN_PROGRESS") || defined("UPGRADE_IN_PROGRESS")) {
	//Tables utilisées par les programmes
	define("TABLE_ALLY", $table_prefix."ally");
	define("TABLE_CONFIG", $table_prefix."config");
	define("TABLE_HISTORY", $table_prefix."history");
	define("TABLE_GROUP", $table_prefix."group");
	define("TABLE_MP", $table_prefix."mp");
	define("TABLE_PLAYER", $table_prefix."player");
	define("TABLE_RANK_PLAYER_FLEET", $table_prefix."rank_player_fleet");
	define("TABLE_RANK_PLAYER_POINTS", $table_prefix."rank_player_points");
	define("TABLE_RANK_PLAYER_RESEARCH", $table_prefix."rank_player_research");
	define("TABLE_RANK_ALLY_FLEET", $table_prefix."rank_ally_fleet");
	define("TABLE_RANK_ALLY_POINTS", $table_prefix."rank_ally_points");
	define("TABLE_RANK_ALLY_RESEARCH", $table_prefix."rank_ally_research");
	define("TABLE_SESSIONS", $table_prefix."sessions");
	define("TABLE_STATISTIC", $table_prefix."statistics");
	define("TABLE_UNIVERSE", $table_prefix."universe");
	define("TABLE_UNIVERSE_TEMPORARY", $table_prefix."universe_temporary");
	define("TABLE_USER", $table_prefix."user");
	define("TABLE_USER_BUILDING", $table_prefix."user_building");
	define("TABLE_USER_DEFENCE", $table_prefix."user_defence");
	define("TABLE_USER_FLEET", $table_prefix."user_fleet");
	define("TABLE_USER_FAVORITE", $table_prefix."user_favorite");
	define("TABLE_USER_GROUP", $table_prefix."user_group");
	define("TABLE_USER_SPY", $table_prefix."user_spy");
	define("TABLE_USER_TECHNOLOGY", $table_prefix."user_technology");
	define("TABLE_USER_PLANET", $table_prefix."user_planet");
	define("TABLE_MOD", $table_prefix."mod");
	define("TABLE_MOD_CAT", $table_prefix."mod_cat");
	define("TABLE_MOD_RESTRICT", $table_prefix."mod_restrict");
	define("TABLE_PARSEDSPY", $table_prefix."parsedspy");
	define("TABLE_PARSEDRC", $table_prefix."parsedRC");
	define("TABLE_PARSEDRCROUND", $table_prefix."parsedRCRound");
	define("TABLE_ROUND_ATTACK", $table_prefix."round_attack");
	define("TABLE_ROUND_DEFENSE", $table_prefix."round_defense");
}


//Paramètres session
define("COOKIE_NAME", "ogspy_id");


//Chemin d'accès aux ressources
if (!defined("INSTALL_IN_PROGRESS") && !defined("GRAPHIC")){
	define("PATH_LOG", "journal/");
	define("PATH_TPL", "templates/");
} else {
	define("PATH_LOG", "../journal/");
	define("PATH_TPL", "../templates/");
}
if (is_writable(PATH_LOG))
{
	$path_log_today = PATH_LOG.date("y-m")."/";
	if (!is_dir($path_log_today)) {
		mkdir($path_log_today);
		chmod($path_log_today, 0777);
		fclose(fopen("$path_log_today/index.htm", "a"));
	}
	define("PATH_LOG_TODAY", $path_log_today);
}

// Chemin d'accès à la racine du serveur et au dossier de lang
if(!preg_match('`(.*)/install\/.*.php`',$_SERVER["SCRIPT_FILENAME"],$matches))
	preg_match('`(.*)/index.php`',$_SERVER["SCRIPT_FILENAME"],$matches);
define("PATH_MAIN", $matches[1]);
define("PATH_LANG", $matches[1]."/lang/");
define("PATH_PICTURES", $matches[1]."images/");

//Mises a jour de mods
define('TEMP_Folder','./parameters/');
define('XML_file',"http://board.ogsteam.fr/download/modxml2.xml");

//Bannière OGSPY
$banner[] = "OgameSpy2.jpg";
$banner[] = "OgameSpy.gif";
$banner[] = "OGSteam.gif";

srand(time());
shuffle($banner);
$banner_selected = $banner[0];



?>
