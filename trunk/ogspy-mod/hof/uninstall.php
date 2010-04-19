<?php
	if (!defined ('IN_SPYOGAME'))
		die ('Hacking attempt');
	
	global $db;
	
	if (!isset($table_prefix)) 
		global $table_prefix;

	define('TABLE_HOF_CONFIG', $table_prefix .'hof_config');
	define('TABLE_HOF_RECORDS', $table_prefix .'hof_records');
	define('TABLE_HOF_PROD', $table_prefix .'hof_prod');
	
	mysql_query('DELETE FROM '. TABLE_MOD .' WHERE root=\'hof\'');
	
	mysql_query('DROP TABLE '. TABLE_HOF_CONFIG .'');
	mysql_query('DROP TABLE '. TABLE_HOF_RECORDS .'');
	mysql_query('DROP TABLE '. TABLE_HOF_PROD .'');
?>