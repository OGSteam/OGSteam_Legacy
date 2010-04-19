<?php
/**
* Module de Messagerie pour OGSpy - Fichier Install
* @package Messagerie
* @author ericalens <ericalens@ogsteam.fr> 
* @link http://www.ogsteam.fr
* @version 1.0
*/
if (!defined('IN_SPYOGAME')) die('Hacking attempt');
global $table_prefix;
define("TABLE_MESSAGES", $table_prefix."messages");
define("TABLE_MESSAGES_THREAD", $table_prefix."messages_thread");
define("TABLE_BOARD", $table_prefix."board");
function CreateTable() {
	global $db,$user_data;
	$sql = "CREATE TABLE `".TABLE_MESSAGES."` (
		`id` int(11) NOT NULL auto_increment,
		`fromid` int (11) NOT NULL,
		`toid` int (11) NOT NULL,
		`type` int (11) NOT NULL default 0,
		`sendeddate` int (11) NOT NULL,
		`subject` varchar(60) NOT NULL default '',
		`readed` tinyint(2) unsigned default 0,
		`message` TEXT NOT NULL,
		PRIMARY KEY (`id`)
		)";
	$db->sql_query($sql);

	$sql = "CREATE TABLE `".TABLE_MESSAGES_THREAD."` (
		`id` int(11) NOT NULL auto_increment,
		`boardid` int (11) NOT NULL,
		PRIMARY KEY (`id`)
		)";
	$db->sql_query($sql);

		
	$sql = "CREATE TABLE `".TABLE_BOARD."` (
		`id` int(11) NOT NULL auto_increment,
		`name` varchar(60) NOT NULL ,
		`description` varchar(250) NOT NULL default '',
		`writegroup` int (11) NOT NULL default 0,
		`readgroup` int (11) NOT NULL,
		`admingroup` int (11) NOT NULL default 0,
		PRIMARY KEY (`id`)
		)";
	$db->sql_query($sql);

	$sql = "INSERT INTO `".TABLE_BOARD."` (id,name,description,readgroup)
		VALUES(null,'News','Les dernières nouvelles',1)";
	$db->sql_query($sql);


	$sql = "INSERT INTO `".TABLE_BOARD."` (id,name,description,readgroup,writegroup)
		VALUES(null,'Public','Les discussions publiques',1,1)";
	$db->sql_query($sql);

	$msg = "Bonjour, <br> Le module <a href='http://ogsteam.fr'>OGSpy</a> de Messagerie vient d'être installé sur notre serveur.";

	$sql="INSERT INTO ".TABLE_MESSAGES_THREAD." (id,boardid) VALUES(null,1)";
	$db->sql_query($sql);

	$sql="INSERT INTO ".TABLE_MESSAGES." (id,fromid,toid,type,sendeddate,subject,message)
		VALUES(null,".$user_data["user_id"].",1,1,".time().",'Installation du module Messagerie','".mysql_real_escape_string($msg)."')";
	$db->sql_query($sql);


}
if (file_exists('mod/Messagerie/version.txt')) {
	$version_txt = file('mod/Messagerie/version.txt');

	$db->sql_query( 'INSERT INTO '.TABLE_MOD.' (id, title, menu, action, root, link, version, active) VALUES'
		." ('', 'Messagerie', 'Messagerie', 'Messagerie', 'Messagerie', 'Messagerie.php', '".trim($version_txt[1])."', '1')");
}

CreateTable();
?>
