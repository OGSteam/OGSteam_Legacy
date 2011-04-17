<?php

/**
 *	update.php Fichier de maj du module modUpdate
 *	@package	modUpdate
 *	@author		Jibus 
 */

	if (!defined('IN_SPYOGAME')) {
		die("Hacking attempt");
	}

	require_once("./mod/modUpdate/modUpdIncl.php");
		
	global $db;
	
	$db->sql_query("UPDATE ".TABLE_MOD." SET version='".MODULE_VERSION."' WHERE title='".MODULE_NAME."'");

?>