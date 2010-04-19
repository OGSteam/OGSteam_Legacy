<?php
/**
* update.php 
 * @package QuiMobserve
 * @author Santory
 * @link http://www.ogsteam.fr
 * @version : 0.1d
 */


if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db,$table_prefix;

define("TABLE_QUIMOBSERVE", $table_prefix."MOD_quimobserve");

if (file_exists('mod/QuiMObserve/version.txt')) { 
	$file = file('mod/QuiMObserve/version.txt'); 
}

//On récupère la version actuel du mod	
$query = "SELECT version FROM ".TABLE_MOD." WHERE action='QuiMobserve'";
$result = $db->sql_query($query);

list($version) = $db->sql_fetch_row($result);

if ($version == "0.1a" || $version == "0.1b" || $version == "0.1c"){
	$query  = "ALTER TABLE `".TABLE_QUIMOBSERVE."` ADD `pourcentage` INT( 1 ) NOT NULL DEFAULT '0';";
	$db->sql_query($query);
	$version == "0.1d";
}

// mise à jour du numéro de version
	$query  = 'UPDATE `'.TABLE_MOD.'` SET `version` = \''.trim($file[1]).'\' WHERE `title` = \'QuiMObserve\'';
	$db->sql_query($query);
?>