<?php
/** $Id$ **/
/**
* Install du module
* @package varAlly
* @author Aeris
* @link http://ogsteam.fr
* @version 1.0.0
 */
if (!defined('IN_SPYOGAME')) die('Hacking attempt');
include('./parameters/id.php');
global $db;
$is_ok = false;
$mod_folder = "varally";
$is_ok = install_mod ($mod_folder);
if ($is_ok == true)
	{
		$queries = array();
		$queries[] = 'INSERT IGNORE INTO '.TABLE_CONFIG.' (config_name, config_value) VALUES (\'nbrjoueur\',\'3\')';
		$queries[] = 'INSERT IGNORE INTO '.TABLE_CONFIG.' (config_name, config_value) VALUES (\'tagAlly\',\'\')';
		$queries[] = 'INSERT IGNORE INTO '.TABLE_CONFIG.' (config_name, config_value) VALUES (\'tagAllySpy\',\'\')';
		$queries[] = 'INSERT IGNORE INTO '.TABLE_CONFIG.' (config_name, config_value) VALUES (\'bilAlly\',\'\')';
		$queries[] = 'INSERT IGNORE INTO '.TABLE_CONFIG.' (config_name, config_value) VALUES (\'tblAlly\',\'varally\')';
		$queries[] = 'CREATE TABLE IF NOT EXISTS `'.$table_prefix.'varally` (
			`datadate` int(11) NOT NULL default \'0\',
			`player` varchar(30) NOT NULL default \'\',
			`ally` varchar(100) NOT NULL default \'\',
			`points` int(11) NOT NULL default \'0\',
			`sender_id` int(11) NOT NULL default \'0\',
			PRIMARY KEY  (`datadate`,`player`)
		)';

		foreach ($queries as $query) {
		$db->sql_query($query);
		}
	}
else
	{
		echo  "<script>alert('D�sol�, un probl�me a eu lieu pendant l'installation, corrigez les probl�mes survenue et r�essayez.');</script>";
	}
?>
