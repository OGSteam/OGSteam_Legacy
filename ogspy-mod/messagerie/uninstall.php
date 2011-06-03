<?php
/**
* Fichier uninstall.php de désinstallation du Module Messagerie
* @package Messagerie
* @author ericalens <ericalens@ogsteam.fr> 
* @link http://www.ogsteam.fr http://doc.ogsteam.fr/modules_ogspy/classtrees_Messagerie.html
* @version 1.0
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
	}

global $db, $table_prefix;
define("TABLE_MESSAGES", $table_prefix."messages");
define("TABLE_MESSAGES_THREAD", $table_prefix."messages_thread");
define("TABLE_BOARD", $table_prefix."board");

$mod_uninstall_name = "Messagerie";
$mod_uninstall_table = TABLE_MESSAGES.','.TABLE_MESSAGES_THREAD.','.TABLE_BOARD;
uninstall_mod ($mod_uninstall_name, $mod_uninstall_table);
?>
