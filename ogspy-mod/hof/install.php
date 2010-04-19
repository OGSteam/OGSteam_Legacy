<?php
	if (!defined('IN_SPYOGAME'))
		die ('Hacking attempt');
	
	global $db;
	
	if (!isset($table_prefix)) 
		global $table_prefix;

	define('TABLE_HOF_CONFIG', $table_prefix .'hof_config');
	define('TABLE_HOF_RECORDS', $table_prefix .'hof_records');
	define('TABLE_HOF_PROD', $table_prefix .'hof_prod');
	
	define('TABLE_FLOTTES', $table_prefix .'mod_flottes');

	$filename = 'mod/hof/version.txt';
	
	if (file_exists($filename))
		$file = file($filename);

	mysql_query(
		'INSERT INTO '. TABLE_MOD .' (id, title, menu, action, root, link, version, position, active, admin_only)
		VALUES (\'\', \'HoF\', \'Hall of Fame\', \'hof\', \'hof\', \'hof.php\', \''. trim($file[1]) .'\', \'-1\', \'1\', \'0\')');
	
	
	/* Suppression des table si elles existent deja */
	
	mysql_query('DROP TABLE IF EXISTS '. TABLE_HOF_CONFIG .'');
	mysql_query('DROP TABLE IF EXISTS '. TABLE_HOF_RECORDS .'');
	mysql_query('DROP TABLE IF EXISTS '. TABLE_HOF_PROD .'');	
	
	/* Creation des tables */
	
	mysql_query(
		'CREATE TABLE '. TABLE_HOF_PROD .' (
			pseudo VARCHAR(30) NOT NULL,
			m DECIMAL(15,6) UNSIGNED NOT NULL,
			c DECIMAL(15,6) UNSIGNED NOT NULL,
			d DECIMAL(15,6) UNSIGNED NOT NULL,
			PRIMARY KEY (pseudo)
			) ENGINE = MYISAM');
	
	mysql_query(
		'CREATE TABLE '. TABLE_HOF_CONFIG .' (
			parameter VARCHAR(20) NOT NULL,
			value VARCHAR(40) NOT NULL
			) ENGINE = MYISAM');
	
	mysql_query(
		'CREATE TABLE '. TABLE_HOF_RECORDS .' (
			id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
			id_cat TINYINT UNSIGNED NOT NULL,
			nom TINYTEXT NOT NULL,
			valeur INT UNSIGNED NOT NULL,
			pseudos TEXT NOT NULL,
			PRIMARY KEY (id)
			) ENGINE = MYISAM');
	
	
	/*
		- Remplissage des tables
	*/
	
	require_once('mod/hof/pages/functions.php');
	require_once('mod/hof/pages/arrays.php');
	
	// Configuration
	fillTableConfig();
	
	// Records
	fillTableRecords($nameBatiment, $nameLabo, $nameFlotte, $nameDefense);
	
	
	/*
		Suppression des defenses et de la flotte d'un utilisateur qui n'existe pas
	*/
	
	// Defense
	$select_defense = mysql_query('SELECT DISTINCT user_id FROM '. TABLE_USER_DEFENCE .'');
	
	while ($defense = mysql_fetch_array($select_defense))
	{
		$select_userID	= mysql_query('SELECT user_id FROM '. TABLE_USER .'');
		$user_exist		= false;
		
		while ($userID = mysql_fetch_array($select_userID))
		{
			if ($userID['user_id'] == $defense['user_id'])
				$user_exist = true;
		}
		
		if (!$user_exist)
			mysql_query('DELETE FROM '. TABLE_USER_DEFENCE .' WHERE user_id=\''. $defense['user_id'] .'\'');
	}
	
	// Flotte, si le mod flotte existe	
	$select_mod	= mysql_query('SELECT title FROM '. TABLE_MOD .' WHERE title=\'Flottes\'');
	$mod		= mysql_fetch_array($select_mod);
	
	if (!empty ($mod))
	{
		$select_flotte = mysql_query('SELECT DISTINCT user_id FROM '. TABLE_FLOTTES .'') or exit(mysql_error());
		
		while ($flotte = mysql_fetch_array($select_flotte))
		{
			$select_userID	= mysql_query('SELECT user_id FROM '. TABLE_USER .'') or exit(mysql_error());
			$user_exist		= false;
			
			while ($userID = mysql_fetch_array($select_userID))
			{
				if ($userID['user_id'] == $flotte['user_id'])
					$user_exist = true;
			}
			
			if (!$user_exist)
				mysql_query('DELETE FROM '. TABLE_FLOTTES .' WHERE user_id=\''. $flotte['user_id'] .'\'') or exit(mysql_error());
		}
	}
?>