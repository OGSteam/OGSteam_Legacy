<?php
/**
*  update.php Mise à jour du module Arcade
* @package Arcade
* @author ericalens <ericalens@ogsteam.fr>
* @link http://www.ogsteam.fr
* @version 2.4
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

/**
* Fonction d'insertion d'une valeur de configuration dans la TABLE_CONFIG
*/

function SetConfig($key,$value,$dontchange=true){

	global $db;
	if ($dontchange) {
		global $server_config;
		if (isset($server_config["$key"])) return;
	}

	$query="REPLACE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('$key','$value') ";
		      
	$db->sql_query($query);

}

$query="SELECT version from ".TABLE_MOD." WHERE root='Arcade'";
$result=$db->sql_query($query);
$row=$db->sql_fetch_assoc($result);
$curversion=$row["version"];

switch ($curversion) {

	case "2.0":
		$query="ALTER TABLE `ogspy_arcade_game` CHANGE `image` `image` VARCHAR( 50 )  NOT NULL COMMENT 'Image associé'";
		$db->sql_query($query);
		SetConfig("arcade_onlinmins","10"); 
	case "2.1":

		$query="ALTER TABLE `ogspy_arcade` ADD `comment` TEXT NOT NULL COMMENT 'Commentaire du joueur';";
		$db->sql_query($query);
		$query="ALTER TABLE `ogspy_arcade` CHANGE `score` `score` float NOT NULL COMMENT 'Score Soumis'";
		$db->sql_query($query);
		
		$query="CREATE TABLE `ogspy_arcade_tourgame` (
			`id` int(11) NOT NULL auto_increment,
			`tournament_id` int(11) NOT NULL,
			`game_id` int(11) NOT NULL,
			PRIMARY KEY  (`id`)
			) ";
		$db->sql_query($query);
		
		$query="CREATE TABLE `ogspy_arcade_tournament` (
			  `id` int(11) NOT NULL auto_increment,
			  `name` varchar(150) NOT NULL,
			  `starttime` int(11) NOT NULL,
			  `endtime` int(11) NOT NULL,
			  PRIMARY KEY  (`id`)
			) ";
		$db->sql_query($query);

		$query="CREATE TABLE `ogspy_arcade_tourscore` (
			  `id` int(11) NOT NULL auto_increment,
			  `playername` varchar(30) NOT NULL,
			  `game_id` int(11) NOT NULL,
			  `score` float NOT NULL,
			  `scoredate` int(11) NOT NULL,
			  PRIMARY KEY  (`id`)
			) ";
		$db->sql_query($query);

}



$query="UPDATE ".TABLE_MOD." SET version='2.4' where root='Arcade'";
$db->sql_query($query);

?>
