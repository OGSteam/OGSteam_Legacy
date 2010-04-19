<?php
/**
* install.php : Installation du Module
* @author ericalens <ericalens@ogsteam.fr> http://www.ogsteam.fr
* @copyright OGSteam 2006 
* @version 0.2
* @package Communication
*/
define("IN_SPYOGAME", true);
require_once("common.php");

/**
* Initialisation du Module par Insertions des données config par defaut
*/
function Communication_InitDB(){
	global $db;

	$query  = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('','Communication','Communication','Communication','Communication','communication.php','0.2','1');";
	$db->sql_query($query);

	$query = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('Communication_IRCServer','irc.sorcery.net');";
	$db->sql_query($query);

	$query = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('Communication_UniChan','#OGSTeam');";
	$db->sql_query($query);

	$query = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('Communication_MarketChan','#OGSMarket');";
	$db->sql_query($query);

	$query = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('Communication_AllyChan','');";
	$db->sql_query($query);
}

Communication_InitDB();

?>
