<?php
	/*
		- MAJ a partir de la 1.1
	*/
	
	$select_v	= mysql_query('SELECT version FROM '. TABLE_MOD .' WHERE title = \'HoF\'');
	$v			= mysql_fetch_row($select_v);
	
	if ($v[0] == '1.1' OR $v[0] == '1.0a' OR $v[0] == '1.0' OR $v[0] == '1.0.0')
	{
		mysql_query(
			'ALTER TABLE '. $table_prefix .'hof_prod
				CHANGE m m DECIMAL(15,6) UNSIGNED NOT NULL,
				CHANGE c c DECIMAL(15,6) UNSIGNED NOT NULL,
				CHANGE d d DECIMAL(15,6) UNSIGNED NOT NULL');
	}
	
	/*
		- MAJ du numero de la version
	*/
	
	$filename = 'mod/hof/version.txt';
	
	if (file_exists($filename))
	$file = file($filename);
	
	mysql_query('UPDATE '. TABLE_MOD .' SET version=\''. trim($file[1]) .'\' WHERE title = \'HoF\'');
?>