<?php
/**
* xtense_plugin_mod_func.php
* @package Xtense
*  @author Naqdazar, then modified by OGSteam
*  @link http://www.ogsteam.fr
*  @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

if (!defined('IN_SPACSPY')) die("Hacking attempt");

//Définitions
global $db;

//On vérifie que le mod est activé
$result = $db->sql_query('SELECT `version` FROM `'.TABLE_MOD.'` WHERE `action`=\''.$pub_action.'\' AND `active`=\'1\' LIMIT 1');
if (!$db->sql_numrows($result)) die('Mod désactivé !');
$mod_version = $db->sql_fetch_row($result);

define("XTENSE_MODULE_NAME","Xtense Plugin");
define("XTENSE_MODULE_ACTION","xtense");
define("XTENSE_MODULE_VERSION",$mod_version[0]);

function set_xtense_plugin_config() {
    global $db, $pub_debug, $pub_maintenance;
    global $pub_logogslogon, $pub_logogsspyadd, $pub_logogsgalview, $pub_logogsplayerstats, $pub_logogsallystats,$pub_logogsallyhistory, $pub_logogssqlfailure;
    global $pub_logogsuserbuildings, $pub_logogsusertechnos, $pub_logogsuserdefence;
    global $pub_logogsuserplanetempire, $pub_logogsusermoonempire;  
    global $pub_ogsplugin_numuniv, $pub_ogsplugin_nameuniv;
    global $pub_forcestricnameuniv, $pub_logunallowedconnattempt; // à completer
    global $pub_handlegalaxyviews, $pub_handleplayerstats, $pub_handleallystats, $pub_handleespioreports;
	
	///////////////////////////////////////////
	//  Update de la config des paramètres du mod  //
	//////////////////////////////////////////
	
	//Paramètre de la maintenance du plugin
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_maintenance."' where config_name = 'xtense_maintenance'";
	$db->sql_query($request);
	
	//Paramètre du debug du plugin
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_debug."' where config_name = 'xtense_debug'";
	$db->sql_query($request);
	
	//Paramètre du log de la connexion du plugin
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogslogon."' where config_name = 'xtense_logogslogon'";
	$db->sql_query($request);

    //Paramètre du log de la mise à jour de rapports d'espionnage
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogsspyadd."' where config_name = 'xtense_logogsspyadd'";
	$db->sql_query($request);

    //Paramètre du log de la mise à jour de galaxie
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogsgalview."' where config_name = 'xtense_logogsgalview'";
	$db->sql_query($request);

    //Paramètre du log de la mise à jour classements joueurs
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogsplayerstats."' where config_name = 'xtense_logogsplayerstats'";
	$db->sql_query($request);

    //Paramètre du log de la mise à jour classements alliances
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogsallystats."' where config_name = 'xtense_logogsallystats'";
	$db->sql_query($request);

    ////Paramètre du log de la mise à jour classements alliance interne
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogsallyhistory."' where config_name = 'xtense_logogsallyhistory'";
	$db->sql_query($request);
	
	//Paramètre du log de la mise à jour de la page bâtiments
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogsuserbuildings."' where config_name = 'xtense_logogsuserbuildings'";
	$db->sql_query($request);  

	//Paramètre du log de la mise à jour de la page technologie
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogsusertechnos."' where config_name = 'xtense_logogsusertechnos'";
	$db->sql_query($request);  

	//Paramètre du log de la mise à jour de la page défense
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogsuserdefence."' where config_name = 'xtense_logogsuserdefence'";
	$db->sql_query($request);  	
	
	//Paramètre du log de la mise à jour de la page empire(planètes)
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogsuserplanetempire."' where config_name = 'xtense_logogsuserplanetempire'";
	$db->sql_query($request);
	
	//Paramètre du log de la mise à jour de la page empire(lunes)
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogsusermoonempire."' where config_name = 'xtense_logogsusermoonempire'";
	$db->sql_query($request);
	
	//Paramètre de tentative de connexion non autorisée/inconnue
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logunallowedconnattempt."' where config_name = 'xtense_logunallowedconnattempt'";
	$db->sql_query($request);
	
	//Paramètre de traitement des vues galaxies
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_handlegalaxyviews."' where config_name = 'xtense_handlegalaxyviews'";
	$db->sql_query($request);
	
	//Paramètre de traitement des classements joueur
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_handleplayerstats."' where config_name = 'xtense_handleplayerstats'";
	$db->sql_query($request);
	
	//Paramètre de traitement des classements alliance
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_handleallystats."' where config_name = 'xtense_handleallystats'";
	$db->sql_query($request);
	
	//Paramètre de traitement des rapports d'espionnage
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_handleespioreports."' where config_name = 'xtense_handleespioreports'";
	$db->sql_query($request);
	
	//Paramètre de bloquer les requètes provenant d'un serveur ogame non désigné
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_forcestricnameuniv."' where config_name = 'xtense_forcestricnameuniv'";
	$db->sql_query($request);

	//Paramètre du log des echecs de requète base de données
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogssqlfailure."' where config_name = 'xtense_logogssqlfailure'";
	$db->sql_query($request);
	
	//Paramètre du numéro de l'univers
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_ogsplugin_numuniv."' where config_name = 'xtense_ogsplugin_numuniv'";
	$db->sql_query($request);

	//Paramètre du nom de l'univers
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_ogsplugin_nameuniv."' where config_name = 'xtense_ogsplugin_nameuniv'";
	$db->sql_query($request);

	/////////////////////////////////////////////////
	//  Fin de l'update de la config des paramètres du mod  //
	////////////////////////////////////////////////
	
	//Retour à la page de config
    redirection("index.php?action=xtense");
}

?>
