<?php

/**
 *	uninstall.php Fichier de desinstallation du module modUpdate
 *	@package	modUpdate
 *	@author		Jibus 
 */

	if (!defined('IN_SPYOGAME')) {
		die("Hacking attempt");
	}
	
	require_once("./mod/modUpdate/modUpdIncl.php");
	
	global $db;

	$query = "DELETE FROM ".TABLE_MOD." WHERE title='".MODULE_NAME."'";
	$db->sql_query($query);
?>
