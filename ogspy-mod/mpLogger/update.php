<?php
/**
 * update.php 

Script de mise à jour

 * @package MP_Logger
 * @author Sylar
 * @link http://www.ogsteam.fr
 * @version : 0.1
 * dernière modification : 16.10.07
 * Module de capture des messages entre joueurs
 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $db,$table_prefix;

define("TABLE_MPC", $table_prefix."MP_Logger");
define("FOLDER_MPC","mod/MP_Logger");

if (file_exists(FOLDER_MPC.'/version.txt')) { 
	$file = file(FOLDER_MPC.'/version.txt'); 
}

// mise à jour du numéro de version
	$query  = 'UPDATE `'.TABLE_MOD.'` SET `version` = \''.trim($file[1]).'\' WHERE `title` = \'MP_Logger\'';
	$db->sql_query($query);
?>