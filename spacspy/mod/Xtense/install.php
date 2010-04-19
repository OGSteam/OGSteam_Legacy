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

//On supprime l'entr�e du mod dans la table, si celui ci est present
$query = "DELETE FROM ".TABLE_MOD." WHERE action='xtense'";
$db->sql_query($query);

//  Insertion du mod dans la table MOD
$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('','Xtense Plugin','Xtense Plugin','xtense','Xtense','index.php','".XTENSE_MODULE_VERSION."','1')";
$db->sql_query($query);

///////////////////////////////////////////////
//  Insertion dans la config des param�tres du mod  //
//////////////////////////////////////////////

//Param�tre du debug du plugin
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_debug', '0')";
$db->sql_query($query);

//Param�tre de la maintenance du plugin
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_maintenance', '0')";
$db->sql_query($query);

//Param�tre du log de la connexion du plugin
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogslogon', '1')";
$db->sql_query($query);

//Param�tre du log de la mise � jour de rapports d'espionnage
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsspyadd', '1')";
$db->sql_query($query);
	
//Param�tre du log de la mise � jour de galaxie
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsgalview', '1')";
$db->sql_query($query);
	
//Param�tre du log de la mise � jour classements joueurs
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsplayerstats', '1')";
$db->sql_query($query);

//Param�tre du log de la mise � jour classements alliances	
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsallystats', '1')";
$db->sql_query($query);

//Param�tre du log de la mise � jour classements alliance interne
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsallyhistory', '1')";
$db->sql_query($query);
	
//Param�tre du log de la mise � jour de la page b�timents
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsuserbuildings', '1')";
$db->sql_query($query);

//Param�tre du log de la mise � jour de la page technologie
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsusertechnos', '1')";
$db->sql_query($query);

//Param�tre du log de la mise � jour de la page d�fense
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsuserdefence', '1')";
$db->sql_query($query);
	
//Param�tre du log de la mise � jour de la page empire(plan�tes)
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsuserplanetempire', '1')";
$db->sql_query($query);
	
//Param�tre du log de la mise � jour de la page empire(lunes)
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsusermoonempire', '1')";
$db->sql_query($query);

//Param�tre du log des echecs de requ�te base de donn�es
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogssqlfailure', '1')";
$db->sql_query($query);

//Param�tre du num�ro de l'univers
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_ogsplugin_numuniv', '1')";
$db->sql_query($query);

//Param�tre du nom de l'univers
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_ogsplugin_nameuniv', '?')";
$db->sql_query($query);

//Param�tre de bloquer les requ�tes provenant d'un serveur ogame non d�sign�
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_forcestricnameuniv', '0')";
$db->sql_query($query);
	
//Param�tre de tentative de connexion non autoris�e/inconnue
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logunallowedconnattempt', '1')";
$db->sql_query($query);
	
//Param�tre de traitement des vues galaxies
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_handlegalaxyviews', '1')";		
$db->sql_query($query);

//Param�tre de traitement des classements joueur
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_handleplayerstats', '1')";
$db->sql_query($query);

//Param�tre de traitement des classements alliance
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_handleallystats', '1')";
$db->sql_query($query);

//Param�tre de traitement des rapports d'espionnage
$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_handleespioreports', '1')";
$db->sql_query($query);

/////////////////////////////////////////////////////
//  Fin de l'insertion dans la config des param�tres du mod  //
////////////////////////////////////////////////////

//Copie du fichier xtense_plugin.php � la racine d'OGSpy
if (defined("OGSPY_INSTALLED") || defined("INSTALL_IN_PROGRESS") || defined("UPGRADE_IN_PROGRESS")) {
    @copy ( "../mod/Xtense/xtense_plugin.php", "../xtense_plugin.php" );
} else { 
    @copy ( "mod/Xtense/xtense_plugin.php", "xtense_plugin.php" );
}
?>
