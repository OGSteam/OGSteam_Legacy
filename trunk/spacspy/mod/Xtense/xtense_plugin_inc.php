<?php
/**
* xtense_plugin_inc.php
* @package Xtense
*  @author Naqdazar, then modified by OGSteam
*  @link http://www.ogsteam.fr
*  @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}

global $server_config;

//Definitions
define("XTENSE_MODULE_NAME","Xtense Plugin");
define("XTENSE_MODULE_ACTION","xtense");
define("XTENSE_MODULE_VERSION","1.1.0");
 
function CheckVarsInsideDB() {
  	 global $db;
	 //
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogslogon', '1')";
	$db->sql_query($query);

	//
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsspyadd', '1')";
	$db->sql_query($query);
	
	
	//
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsgalview', '1')";
	$db->sql_query($query);
	
	//
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsplayerstats', '1')";
	$db->sql_query($query);
	
	//	
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsallystats', '1')";
	$db->sql_query($query);
	
	//
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsallyhistory', '1')";
	$db->sql_query($query);
	//
	
	
	
	
	
	// Var pages
	//logogsuserbuildings
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsuserbuildings', '1')";
	$db->sql_query($query);
	
	//logogsusertechnos
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsusertechnos', '1')";
	$db->sql_query($query);
	
	//logogsuserdefence
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsuserdefence', '1')";
	$db->sql_query($query);
	
	// var  pages empires
	//logogsuserplanetempire
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsuserplanetempire', '1')";
	$db->sql_query($query);
	
	//logogsuserplanetmoon
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogsusermoonempire', '1')";
	$db->sql_query($query);
	
	//
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logogssqlfailure', '1')";
	$db->sql_query($query);
	
	
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_ogsplugin_numuniv', '1')";
	$db->sql_query($query);
	
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_ogsplugin_nameuniv', '?')";
	$db->sql_query($query);
	
	
	
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_forcestricnameuniv', '0')";
	$db->sql_query($query);
	
	//http version - ogshttp_headerver
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_ogshttp_headerver', '1')";
	$db->sql_query($query);	
	
	// naq_logunallowconnattempt - identifiant inconnu
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_logunallowedconnattempt', '1')";
	$db->sql_query($query);
	
	// Gestion Pages
  $query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_handlegalaxyviews', '1')";		
	$db->sql_query($query);
	
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_handleplayerstats', '1')";
  $db->sql_query($query);
	
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_handleallystats', '1')";
  $db->sql_query($query);
	
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_handleespioreports', '1')";
  $db->sql_query($query);
  
  // diplomatie
	// naq_ogspnaalliesnames
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('allied', '')";
  $db->sql_query($query); 	
    
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_ogsenemyallies', '')";
  $db->sql_query($query);
	
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_ogstradingallies', '')";
  $db->sql_query($query);  
	// naq_ogspnaalliesnames
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_ogspnaalliesnames', '')";
  $db->sql_query($query); 
  
  // plugin redirection
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_notifyplugredirect', '')";
  $db->sql_query($query);  
	
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('xtense_plugredirectmsg', '')";
  $db->sql_query($query);   
  	
}

?>
