<?php
/**
 * uninstall.php 
 
Procédure de désinstallationn du mod.

 * @package QuiMSonde
 * @author Sylar
 * @link http://www.ogsteam.fr
 * @version : 1.5
 * dernière modification : 27.04.08
 * Largement inspiré du formidable mod QuiMObserve de Santory
 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Global et définition
global $db,$table_prefix;
define("TABLE_QMS", $table_prefix."QuiMeSonde");
define("TABLE_QMS_config", $table_prefix."QuiMeSonde_config");
define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");
define("FOLDER_QMS","mod/QuiMSonde");
include(FOLDER_QMS."/includes/lang_french.php");
// Quelle version on désinstalle ?
if (file_exists(FOLDER_QMS.'/version.txt')) {
	list($mod_name,$version) = file(FOLDER_QMS.'/version.txt'); 
	$mod_name = trim($mod_name);
	$version = trim($version);
}else
	die($lang['qms_version.txt_not_found']);

//Suppression des tables
$db->sql_query("DROP TABLE IF EXISTS ".TABLE_QMS.";");
$db->sql_query("DROP TABLE IF EXISTS ".TABLE_QMS_config.";");//*/
	
// On récupère l'id du mod pour xtense... (merci Paradoxx)
$result = $db->sql_query("SELECT id FROM ".TABLE_MOD." WHERE title='$mod_name'");
list($mod_id) = $db->sql_fetch_row($result);

// Suppression de la liaison entre Xtense v2 et QuiMSonde (merci Paradoxx!)

// On regarde si la table xtense_callbacks existe :
$result = $db->sql_query('show tables from '.$db->dbname.' like "'.TABLE_XTENSE_CALLBACKS.'" ');
if($db->sql_numrows($result) != 0){

	//Maintenant on regarde si QuiMSonde est dedans normalement oui mais on est jamais trop prudent...
	$result = $db->sql_query("Select * From ".TABLE_XTENSE_CALLBACKS." where mod_id = $mod_id");

	// S'il est dedans : alors on l'enlève!
	if($db->sql_numrows($result) != 0)
		$db->sql_query("DELETE FROM ".TABLE_XTENSE_CALLBACKS." where mod_id = $mod_id");
}

// Suppression de la ligne, dans la table des mods.
$db->sql_query("DELETE FROM ".TABLE_MOD." WHERE title='$mod_name'");

?>