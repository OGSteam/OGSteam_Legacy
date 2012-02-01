<?php
/*
* install.php
* @mod ZoneCheck
* @author Gorn
* @fileversion 2.5
*
* 0 = pas de changement
* 1 = status
* 2 = lune
* 4 = alliance
* 8 = nom
* 16 = planète
* 32 = colonisation
*/

if ( !defined ( 'IN_SPYOGAME' ) )
    die ( 'Hacking attempt' );

global $db, $table_prefix, $server_config;
define ( 'TABLE_MOD_ZONECHECK', $table_prefix . 'ZoneCheck' );
define ( 'TABLE_MOD_ZONECHECK_CFG', $table_prefix . 'ZoneCheck_config' );
define ( 'TABLE_MOD_ZONECHECK_HST', $table_prefix . 'ZoneCheck_histo' );

$is_ok = FALSE;
$mod_folder = "zonecheck";
$is_ok = install_mod ($mod_folder);
if ($is_ok == true)
	{
		if ( !isset ( $server_config['num_of_galaxies'] ) && !isset ( $num_of_galaxies ) )
			$num_of_galaxies = $server_config['num_of_galaxies'];
		elseif ( isset ( $server_config['num_of_galaxies'] ) )
			$num_of_galaxies = $server_config['num_of_galaxies'];

		$query = 'CREATE TABLE IF NOT EXISTS `' . TABLE_MOD_ZONECHECK . '` (
		`galaxy` enum ( ';
		for ( $idx_g = 1; $idx_g < $num_of_galaxies+1; $idx_g++)
		$query .= '\'' . $idx_g . '\', ';
		$query .= '\'' . ( $idx_g + 1 ) . '\'';
		$query .= ' ) NOT NULL default \'' . $num_of_galaxies . '\',
		`system` smallint ( 3 ) NOT NULL default \'0\',
		`row` enum ( \'1\', \'2\', \'3\', \'4\', \'5\', \'6\', \'7\', \'8\', \'9\', \'10\', \'11\', \'12\', \'13\', \'14\', \'15\' ) NOT NULL default \'1\',
		`moon` enum ( \'0\', \'1\' ) NOT NULL default \'0\',
		`name` varchar ( 50 ) NOT NULL default \'\',
		`ally` varchar ( 50 ) default NULL,
		`player` varchar ( 50 ) default NULL,
		`status` varchar ( 5 ) NOT NULL default \'\',
		`last_update` int ( 11 ) NOT NULL default \'0\',
		`status_changed` enum ( \'0\', \'1\', \'2\', \'3\', \'4\', \'5\', \'6\', \'7\', \'8\', \'9\', \'10\', \'11\', \'12\', \'13\', \'14\', \'15\', \'16\', \'17\', \'18\', \'19\', \'20\', \'21\', \'22\', \'23\', \'24\', \'25\', \'26\', \'27\', \'28\', \'29\', \'30\', \'31\', \'32\' ) NOT NULL default \'0\',
		UNIQUE KEY `univers` ( `galaxy`, `system`, `row` )
		);';
		$db->sql_query ( $query );

		if ( ! defined ( 'TABLE_MOD_CFG' ) )
			{
				$query = 'CREATE TABLE IF NOT EXISTS `' . TABLE_MOD_ZONECHECK_CFG . '` (
				`nb_system` SMALLINT(3) DEFAULT 50,
				`block` CHAR(7) DEFAULT "#FFAAD4",
				`moon` CHAR(7) DEFAULT "#0066CC",
				`deco` CHAR(7) DEFAULT "#DDBB66",
				`vac` CHAR(7) DEFAULT "#99FFFF",
				`inactif` CHAR(7) DEFAULT "#FF7F00",
				`unstatus` CHAR(7) DEFAULT "#FFAA2A",
				`colo` CHAR(7) DEFAULT "#FF0000",
				`less` CHAR(7) DEFAULT "#FF2A00",
				`middle` CHAR(7) DEFAULT "#FFAA2A",
				`more` CHAR(7) DEFAULT "#FFFF2A",
				`outofdate` CHAR(7) DEFAULT "#FFFFFF",
				`affichage` VARCHAR(255)
				);';
				$db->sql_query ( $query );
				$query = 'INSERT IGNORE INTO ' . TABLE_MOD_ZONECHECK_CFG . ' VALUES ( 50, "#FFAAD4", "#0066CC", "#DDBB66", "##99FFFF", "#FF7F00", "#FFAA2A", "#FF0000", "#FF2A00", "#FFAA2A", "#FFFF2A", "#FFFFFF", "\inactif|I|Lune|Colonisation")';
				$db->sql_query ( $query );
			}
		else
			{
				$query = 'INSERT IGNORE INTO ' . TABLE_MOD_CFG . ' VALUES ( "ZoneCheck", "nb_system", "50" ), 
				( "ZoneCheck", "block", "#FFAAD4" ), 
				( "ZoneCheck", "moon", "#0066CC" ), 
				( "ZoneCheck", "deco", "#DDBB66" ), 
				( "ZoneCheck", "vac", "##99FFFF" ), 
				( "ZoneCheck", "inactif", "#FF7F00" ), 
				( "ZoneCheck", "unstatus", "#FFAA2A" ), 
				( "ZoneCheck", "colo", "#FF0000" ), 
				( "ZoneCheck", "less", "#FF2A00" ), 
				( "ZoneCheck", "middle", "#FFAA2A" ), 
				( "ZoneCheck", "more", "#FFFF2A" ), 
				( "ZoneCheck", "outofdate", "#FFFFFF" ), 
				( "ZoneCheck", "affichage", "\\\\(.*i.*\\\\)|I|Lune|Colonisation" )';
				$db->sql_query ( $query );
			}

		$query = 'CREATE TABLE IF NOT EXISTS `' . TABLE_MOD_ZONECHECK_HST . '` (
			`coordinates` varchar(9) NOT NULL default "",
			`oldname` varchar(50) NOT NULL default "",
			`newname` varchar(50) NOT NULL default "",
			`ally` varchar(50) NOT NULL default "",
			`type` enum("P","A") NOT NULL default "P",
			`date` int(11) NOT NULL default "0",
			PRIMARY KEY  (`oldname`,`newname`),
			KEY `coordinates` (`coordinates`))';
			$db->sql_query ( $query );

		$query = 'INSERT IGNORE INTO `' . TABLE_MOD_ZONECHECK . '` ( `galaxy`, `system`, `row`, `moon`, `name`, `ally`, `player`, `status`, `last_update` ) SELECT `galaxy`, `system`, `row`, `moon`, `name`, `ally`, `player`, `status`, `last_update` FROM ' . TABLE_UNIVERSE;
		$db->sql_query($query);

	}		
else
	{
		echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
	}
?>
