<?php  
/** 
Fichier installation du mod recycleurs 
@author deusirae 
@package recycleurs 
@version 1.0a 
@link http://ogsteam.fr 
**/ 
require_once("common.php"); 

//L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $db, $table_prefix;
$is_ok = false;
$mod_folder = "recycleur";
$is_ok = install_mod ($mod_folder);
if ($is_ok == true)
	{
		define("TABLE_recycleurs", $table_prefix."recycleurs");
		define("TABLE_phalanges", $table_prefix."phalanges");
		
		$query="DROP TABLE IF EXISTS ".TABLE_phalanges."";
		$db->sql_query($query);

		$query="DROP TABLE IF EXISTS ".TABLE_recycleurs."";
		$db->sql_query($query);


		$query = "CREATE TABLE ".TABLE_recycleurs." (
			`id` INT NOT NULL AUTO_INCREMENT ,
			`user_name` VARCHAR( 255 ) NOT NULL default '0',
			`galaxie` VARCHAR( 1 ) NOT NULL ,
			`systeme` VARCHAR( 3 ) NOT NULL ,
			`position` VARCHAR( 2 ) NOT NULL ,
			`porte` VARCHAR( 50 ) NOT NULL ,
			`nombrerecy` VARCHAR( 255 ) NOT NULL ,
			`time` int(11) NOT NULL default '0',
			PRIMARY KEY ( `id` ) 
		)";
		$db->sql_query($query);

		$query = "CREATE TABLE ".TABLE_phalanges." (
			`id` INT NOT NULL AUTO_INCREMENT ,
			`user_name` VARCHAR( 255 ) NOT NULL default '0',
			`galaxie` VARCHAR( 1 ) NOT NULL ,
			`systeme` VARCHAR( 3 ) NOT NULL ,
			`position` VARCHAR( 2 ) NOT NULL ,
			`systemea` VARCHAR( 3 ) NOT NULL ,
			`systemep` VARCHAR( 3 ) NOT NULL ,
			`time` int(11) NOT NULL default '0',
			PRIMARY KEY ( `id` ) 
		)";
		$db->sql_query($query);
	}
else
	{
		echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
	}
?>