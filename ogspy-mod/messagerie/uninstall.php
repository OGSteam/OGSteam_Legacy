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

global $table_prefix;

define("TABLE_MESSAGES", $table_prefix."messages");
define("TABLE_MESSAGES_THREAD", $table_prefix."messages_thread");
define("TABLE_BOARD", $table_prefix."board");


// La suppression du mod dans la table de mod est faites par OGSpy
// (Donc pas besoin de la faire dans le fichier uninstall.php)

// Suppression des tables spécifiques au module
// Remarque : aucune confirmation demandé... BOUM sur les messages si erreur de manip...
// Mais pas de protocole de confirmation implémenté dans les autres modules... à réfléchir peut etre

$query="DROP TABLE IF EXISTS `".TABLE_MESSAGES."`";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS `".TABLE_MESSAGES_THREAD."`";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS `".TABLE_BOARD."`";
$db->sql_query($query);
?>
