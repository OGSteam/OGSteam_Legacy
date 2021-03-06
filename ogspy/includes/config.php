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

// D�finitions des noms des tables de la BDD
if (!defined("INSTALL_IN_PROGRESS")) {
	//Tables utilis�es par les programmes
	define("TABLE_CONFIG", $table_prefix."config");
	define("TABLE_GROUP", $table_prefix."group");
	define("TABLE_RANK_PLAYER_POINTS", $table_prefix."rank_player_points");
	define("TABLE_RANK_ALLY_POINTS", $table_prefix."rank_ally_points");
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
	define("TABLE_MOD_CFG", $table_prefix."mod_config");
	define("TABLE_PARSEDSPY", $table_prefix."parsedspy");
	define("TABLE_PARSEDRC", $table_prefix."parsedRC");
	define("TABLE_PARSEDRCROUND", $table_prefix."parsedRCRound");
	define("TABLE_ROUND_ATTACK", $table_prefix."round_attack");
	define("TABLE_ROUND_DEFENSE", $table_prefix."round_defense");
    
    // nouvelle table v3 ogame
    // joueur
    define("TABLE_RANK_PLAYER_ECO", $table_prefix."rank_player_economique"); // economique
    define("TABLE_RANK_PLAYER_TECHNOLOGY", $table_prefix."rank_player_technology"); // recherche
    define("TABLE_RANK_PLAYER_MILITARY", $table_prefix."rank_player_military"); // militaire
    define("TABLE_RANK_PLAYER_MILITARY_BUILT", $table_prefix."rank_player_military_built"); // militaire construit
    define("TABLE_RANK_PLAYER_MILITARY_LOOSE", $table_prefix."rank_player_military_loose"); // militaire perdu
    define("TABLE_RANK_PLAYER_MILITARY_DESTRUCT", $table_prefix."rank_player_military_destruct"); // militaire detruit
    define("TABLE_RANK_PLAYER_HONOR", $table_prefix."rank_player_honor"); //point d honneur
    // fin joueur
    // alliance
    define("TABLE_RANK_ALLY_ECO", $table_prefix."rank_ally_economique"); // economique
    define("TABLE_RANK_ALLY_TECHNOLOGY", $table_prefix."rank_ally_technology"); // recherche
    define("TABLE_RANK_ALLY_MILITARY", $table_prefix."rank_ally_military"); // militaire
    define("TABLE_RANK_ALLY_MILITARY_BUILT", $table_prefix."rank_ally_military_built"); // militaire construit
    define("TABLE_RANK_ALLY_MILITARY_LOOSE", $table_prefix."rank_ally_military_loose"); // militaire perdu
    define("TABLE_RANK_ALLY_MILITARY_DESTRUCT", $table_prefix."rank_ally_military_destruct"); // militaire detruit
    define("TABLE_RANK_ALLY_HONOR", $table_prefix."rank_ally_honor"); //point d honneur
    // fin alliance
    // fin nouvelle table
    
    // table a supp apres transition ogame v3
    define("TABLE_RANK_PLAYER_FLEET", $table_prefix."rank_player_fleet"); // ancien classement flotte
    define("TABLE_RANK_PLAYER_RESEARCH", $table_prefix."rank_player_research"); // ancien classement recherche
    define("TABLE_RANK_ALLY_FLEET", $table_prefix."rank_ally_fleet");// ancien classement flotte
    define("TABLE_RANK_ALLY_RESEARCH", $table_prefix."rank_ally_research");// ancien classement recherche
    // fin table a supp
    
}


//Param�tres session
define("COOKIE_NAME", "ogspy_id");



//Activation du mode d�buggage
define("MODE_DEBUG", FALSE);

//Chemin d'acc�s aux ressources
if (!defined("INSTALL_IN_PROGRESS") && !defined("UPGRADE_IN_PROGRESS") && !defined("GRAPHIC")) define("PATH_LOG", "journal/");
else define("PATH_LOG", "../journal/");
$path_log_today = PATH_LOG.date("ymd")."/";
if (!is_dir($path_log_today)) {
	mkdir($path_log_today);
	chmod($path_log_today, 0777);
	fclose(fopen("$path_log_today/index.htm", "a"));
}
define("PATH_LOG_TODAY", PATH_LOG.date("ymd")."/");


//Banni�re OGSPY
$banner[] = "logos/logo.png";

srand(time());
shuffle($banner);
$banner_selected = $banner[0];
?>
