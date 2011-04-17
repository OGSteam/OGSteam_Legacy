<?php

/**
 *	install.php Fichier d'installation du module modUpdate
 *	@package	modUpdate
 *	@author		Jibus 
 */

	if (!defined('IN_SPYOGAME')) {
		die("Hacking attempt");
	}
	
	require_once("./mod/modUpdate/modUpdIncl.php");
	
	global $db;
	
	//Insertion du champs pour la declaration du module dans OGSpy
	$query  = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('','".MODULE_NAME."','modUpdate','".MODULE_ACTION."','modUpdate','modUpdate.php','".MODULE_VERSION."','1');";
	$db->sql_query($query,false,true);
	
?>
