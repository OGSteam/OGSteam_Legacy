<?php
/**
* install.php Installation du mod Xtense
* @package Xtense
*  @author Naqdazar, then modified by OGSteam
*  @link http://www.ogsteam.fr
*  @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}

if (!defined("OGSPY_INSTALLED") || defined("INSTALL_IN_PROGRESS") || defined("UPGRADE_IN_PROGRESS")) {
	require_once("../mod/Xtense/xtense_plugin_inc.php");

} else { 
	require_once("mod/Xtense/xtense_plugin_inc.php");
}

//On supprime l'entrée du mod dans la table, si celui ci est present
$query = "DELETE FROM ".TABLE_MOD." WHERE action='xtense'";
$db->sql_query($query);

//  Insertion du mod dans la table MOD
$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('','Xtense Plugin','Xtense Plugin','xtense','Xtense','index.php','".XTENSE_MODULE_VERSION."','1')";
$db->sql_query($query);

///////////////////////////////////////////////
//  Insertion dans la config des paramètres du mod  //
//////////////////////////////////////////////

//Paramètre du debug du plugin
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_debug', '0')";
$db->sql_query($query);

//Paramètre de la maintenance du plugin
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_maintenance', '0')";
$db->sql_query($query);

//Paramètre du log de la connexion du plugin
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogslogon', '1')";
$db->sql_query($query);

//Paramètre du log de la mise à jour de rapports d'espionnage
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsspyadd', '1')";
$db->sql_query($query);
	
//Paramètre du log de la mise à jour de galaxie
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsgalview', '1')";
$db->sql_query($query);
	
//Paramètre du log de la mise à jour classements joueurs
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsplayerstats', '1')";
$db->sql_query($query);

//Paramètre du log de la mise à jour classements alliances	
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsallystats', '1')";
$db->sql_query($query);

//Paramètre du log de la mise à jour classements alliance interne
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsallyhistory', '1')";
$db->sql_query($query);
	
//Paramètre du log de la mise à jour de la page bâtiments
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsuserbuildings', '1')";
$db->sql_query($query);

//Paramètre du log de la mise à jour de la page technologie
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsusertechnos', '1')";
$db->sql_query($query);

//Paramètre du log de la mise à jour de la page défense
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsuserdefence', '1')";
$db->sql_query($query);
	
//Paramètre du log de la mise à jour de la page empire(planètes)
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsuserplanetempire', '1')";
$db->sql_query($query);
	
//Paramètre du log de la mise à jour de la page empire(lunes)
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsusermoonempire', '1')";
$db->sql_query($query);

//Paramètre du log des echecs de requète base de données
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogssqlfailure', '1')";
$db->sql_query($query);

//Paramètre du numéro de l'univers
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_ogsplugin_numuniv', '1')";
$db->sql_query($query);

//Paramètre du nom de l'univers
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_ogsplugin_nameuniv', '?')";
$db->sql_query($query);

//Paramètre de bloquer les requètes provenant d'un serveur ogame non désigné
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_forcestricnameuniv', '0')";
$db->sql_query($query);
	
//Paramètre de tentative de connexion non autorisée/inconnue
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logunallowedconnattempt', '1')";
$db->sql_query($query);
	
//Paramètre de traitement des vues galaxies
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_handlegalaxyviews', '1')";		
$db->sql_query($query);

//Paramètre de traitement des classements joueur
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_handleplayerstats', '1')";
$db->sql_query($query);

//Paramètre de traitement des classements alliance
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_handleallystats', '1')";
$db->sql_query($query);

//Paramètre de traitement des rapports d'espionnage
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_handleespioreports', '1')";
$db->sql_query($query);

/////////////////////////////////////////////////////
//  Fin de l'insertion dans la config des paramètres du mod  //
////////////////////////////////////////////////////

//Copie du fichier xtense_plugin.php à la racine d'OGSpy
if (defined("OGSPY_INSTALLED") || defined("INSTALL_IN_PROGRESS") || defined("UPGRADE_IN_PROGRESS")) {
    @copy ( "../mod/Xtense/xtense_plugin.php", "../xtense_plugin.php" );
} else { 
    @copy ( "mod/Xtense/xtense_plugin.php", "xtense_plugin.php" );
}
?>
