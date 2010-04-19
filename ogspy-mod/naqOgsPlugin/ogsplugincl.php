<?php

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}


global $server_config;

// définition des constantes globales de version
define("OGP_MODULE_NAME","naq_ogsplugmod");
define("OGP_MODULE_ACTION","naq_ogsplugmod");
define("OGP_MODULE_VERSION","2.2.9");

$ogsplugin_menutooltip = "<font color=\"white\">Module d&#39;administration du module OGS Plugin  v".OGP_MODULE_VERSION." pour OGSpy 3.02c/UniSpy 1.0</font>";
 
// Est-on sur UniSpy
if (strcasecmp($server_config["version"],"1.0")>=0 && file_exists('includes/univers.php')) {
    define("SERVER_IS_UNISPY", true);
    
} else if ((strcasecmp($server_config["version"],"3.10")>=0 || strcasecmp($server_config["version"],"3.02")>=0) && file_exists('includes/ogame.php')) {
      define("SERVER_IS_OGSPY", true);
}
 
/**
 * Met à jour une valeur de la table config
 **/
function do_insertvalue($valuename, $content) {
        global $db;
      	$request = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('".mysql_escape_string($valuename)."', '".mysql_escape_string($content)."')";
      	$db->sql_query($request);
}
 
/**
 * Initialise toutes les valeurs de la table CONFIG dont le module a besoin
 **/
function OGP_CheckVarsInsideDB() {
  global $db;
	 
	 //
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_modlanguage', 'french')";
	$db->sql_query($query);	 
	
	do_insertvalue('naq_newmenupos', '3');

  // position du menu d'administration / info utilisateur
  $query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_modlanguage', 'french')";
	$db->sql_query($query);

	 // Variable pour distinction Ogame/E-Univers
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_gametype', 'ogame')";
	$db->sql_query($query);

   
   //
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_logogslogon', '1')";
	$db->sql_query($query);

	//
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_logogsspyadd', '1')";
	$db->sql_query($query);
	
	
	//
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_logogsgalview', '1')";
	$db->sql_query($query);
	
	//
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_logogsplayerstats', '1')";
	$db->sql_query($query);  //naq_logogsplayerstats - naq_logogsallystats -  naq_logogsallyhistory - naq_logogssqlfailure
	
	//	
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_logogsallystats', '1')";
	$db->sql_query($query);
	
	//
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_logogsallyhistory', '1')";
	$db->sql_query($query);
	//		
	
	// Var pages
	//logogsuserbuildings
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_logogsuserbuildings', '1')";
	$db->sql_query($query);
	
	//logogsusertechnos
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_logogsusertechnos', '1')";
	$db->sql_query($query);
	
	//logogsuserdefence
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_logogsuserdefence', '1')";
	$db->sql_query($query);
	
	// var  pages empires
	//logogsuserplanetempire
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_logogsuserplanetempire', '1')";
	$db->sql_query($query);
	
	//logogsuserplanetmoon
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_logogsusermoonempire', '1')";
	$db->sql_query($query);
	
	//
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_logogssqlfailure', '1')";
	$db->sql_query($query);
	
	
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_ogsplugin_numuniv', '1')";
	$db->sql_query($query);
	
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_ogsportailurl', 'fr')";
	$db->sql_query($query);
  
  $query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_ogsplugin_nameuniv', '?')";
	$db->sql_query($query);
	
	// variables rubriques divers
	
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_forceupdate_outdatedext', '0')";
	$db->sql_query($query);
  
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_ogsactivate_debuglog', '0')";
	$db->sql_query($query);  	
	
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_forcestricnameuniv', '0')";
	$db->sql_query($query);
	
	//http version - ogshttp_headerver
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_ogshttp_headerver', '1')";
	$db->sql_query($query);	
	
	// naq_logunallowconnattempt - identifiant inconnu
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_logunallowedconnattempt', '1')";
	$db->sql_query($query);
	
	// Gestion Pages
  $query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_handlegalaxyviews', '1')";		
	$db->sql_query($query);
	
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_handleplayerstats', '1')";
  $db->sql_query($query);
	
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_handleallystats', '1')";
  $db->sql_query($query);
	
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_handleespioreports', '1')";
  $db->sql_query($query);
  
  // diplomatie
	// naq_ogspnaalliesnames
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('allied', '')";
  $db->sql_query($query); 	
    
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_ogsenemyallies', '')";
  $db->sql_query($query);
	
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_ogstradingallies', '')";
  $db->sql_query($query);  
	// naq_ogspnaalliesnames
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_ogspnaalliesnames', '')";
  $db->sql_query($query); 
  
  // plugin redirection
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_notifyplugredirect', '')";
  $db->sql_query($query);  
	
	$query = "INSERT IGNORE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('naq_plugredirectmsg', '')";
  $db->sql_query($query);   
  	
}

function OGP_CreatePlugModsTable() {

global $db;

// première créaiton de table pour version plugin supérieur à 1.3.0
// version OGSPY 3.1 non sortie à cette date 18jan07

/*


## 
## Structure de la table `ogspy_plugin_import`
## recense les fonctions d`importation utilisable par le plugin

CREATE TABLE `ogspy_plugin_import` (
  `function_id` int(11) NOT NULL auto_increment,
  `mod_name` varchar(20) NOT NULL default '' COMMENT ' nom du module ayant enregistré la fonction',
  `mod_version` varchar(15) NOT NULL default '' COMMENT ' version du module',
  `mod_root_name` varchar(255) NOT NULL default '' COMMENT 'chemin racine du module',
  `function_file_name` varchar(255) NOT NULL default '' COMMENT 'fichier php contenant la fonction',
  `function_name` varchar(30) NOT NULL default '' COMMENT 'nom de la fonction',
  `ogame_pageid` smallint(4) unsigned NOT NULL default '0' COMMENT 'id de la page prise en charge',
  `text_content` enum('0','1') NOT NULL default '0' COMMENT '0 si html, 1 si texte',
  `sender_name` enum('0','1') NOT NULL default '0' COMMENT '0=pseudo ogspy, 1=pseudo joueur dans la barre (pour rapport de combat)',
  `message_type` enum('0','1','2','3','4','5','6','7') NOT NULL default '0' COMMENT 'quels types de message pris en charge pour les modules concernés: 0=tous, 1=respio, 2=rcombat, 3=r recyl, 4=espio ennemi, 5=retour de flotte, 6= msg perso',
  `planet_ident` enum('0','1') NOT NULL default '1' COMMENT ' 0=par id table 0-9/10-18 , 1=nom planet+coordonnée(contenu boite Ogame eg Terria [2:310:12])  pour fonction en ayant besoin',
  `private_man` enum('0','1','2') NOT NULL default '0' COMMENT 'gère les données de manière commune ou privée(traitement pour le joueur)   - 0=public, 1=privé, 2=mixte',
  `function_active` enum('0','1') NOT NULL default '1' COMMENT 'fonction active ou pas, si inactif ne pas appeler!',
  PRIMARY KEY  (`function_id`)
) 


*/

// vérifier version plugin dans table 

	/* Désactivé pour l'instant
  $query  = "CREATE TABLE IF NOT EXISTS `".$table_prefix."plugin_import` (";
	$query .= "`function_id` int(11) NOT NULL auto_increment,";
	$query .= "`mod_name` varchar(20) NOT NULL default '' COMMENT ' nom du module ayant enregistré la fonction',";
  $query .= "`mod_version` varchar(15) NOT NULL default '' COMMENT ' version du module',";	
  $query .= "`mod_root_name` varchar(255) NOT NULL default '' COMMENT 'chemin racine du module',";
  $query .= "`function_file_name` varchar(255) NOT NULL default '' COMMENT 'fichier php contenant la fonction',";
  $query .= "`function_name` varchar(30) NOT NULL default '' COMMENT 'nom de la fonction',";
  $query .= "`ogame_pageid` smallint(4) unsigned NOT NULL default '0' COMMENT 'id de la page prise en charge',";
  $query .= "`text_content` enum('0','1') NOT NULL default '0' COMMENT '0 si html, 1 si texte',";
  $query .= "`sender_name` enum('0','1') NOT NULL default '0' COMMENT '0=pseudo ogspy, 1=pseudo joueur dans la barre (pour rapport de combat)',";
  $query .= "`message_type` enum('0','1','2','3','4','5','6','7') NOT NULL default '0' COMMENT 'quels types de message pris en charge pour les modules concernés: 0=tous, 1=respio, 2=rcombat, 3=r recyl, 4=espio ennemi, 5=retour de flotte, 6= msg perso',";
  $query .= "`planet_ident` enum('0','1') NOT NULL default '1' COMMENT ' 0=par id table 0-9/10-18 , 1=nom planet+coordonnée(contenu boite Ogame eg Terria [2:310:12])  pour fonction en ayant besoin',";
  $query .= "`private_man` enum('0','1','2') NOT NULL default '0' COMMENT 'gère les données de manière commune ou privée(traitement pour le joueur)   - 0=public, 1=privé, 2=mixte',";    
  $query .= "`function_active` enum('0','1') NOT NULL default '1' COMMENT 'fonction active ou pas, si inactif ne pas appeler!',";
  $query .= "PRIMARY KEY  (function_id) );";
  $db->sql_query($query);  */

}

?>
