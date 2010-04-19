<?php
/**
 *	uninstall..php Page analyseI
 *	@package	analyseI
 *	@author	benneb 
 *	created	: 10/02/2010   
 *	modified	: 10/02/2010  
 */

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;
global $table_prefix;

// suppression de la table inactivite si elle existe
$query = "DROP TABLE IF EXISTS `".$table_prefix.'inactivite'."`";
$db->sql_query($query);

$query = "DELETE FROM ".TABLE_MOD." WHERE root='analyseI'";

$db->sql_query($query);
?>