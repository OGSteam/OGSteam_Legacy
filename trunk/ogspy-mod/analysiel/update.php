<?php
/**
 *	update..php Page analyseI
 *	@package	analyseI
 *	@author	benneb 
 *	created	: 10/02/2010   
 *	modified	: 11/02/2010  
 */

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;
if (file_exists('mod/analyseI/version.txt')) { 
	$file = file('mod/analyseI/version.txt'); 
}

// mise à jour du numéro de version
	$query  = "UPDATE `".TABLE_MOD."` SET `version` = ".trim($file[1])." WHERE `root` = 'analyseI'";
	$db->sql_query($query);
?>