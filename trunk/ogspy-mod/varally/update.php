<?php
/** $Id$ **/
/**
* Mise � jour du module
* @package varAlly
* @author Aeris
* @version 1.0.0
* @link http://ogsteam.fr
 */
define('IN_SPYOGAME', true);
include('./parameters/id.php');
global $db;

$mod_folder = "varally";
$mod_name = "varally";
update_mod 	($mod_folder,$mod_name);

$queries = array();
$queries[] = 'CREATE TABLE IF NOT EXISTS `'.$table_prefix.'varally` (
	`datadate` int(11) NOT NULL default \'0\',
	`player` varchar(30) NOT NULL default \'\',
	`ally` varchar(100) NOT NULL default \'\',
	`points` int(11) NOT NULL default \'0\',
	`sender_id` int(11) NOT NULL default \'0\',
	PRIMARY KEY  (`datadate`,`player`)
)';

$queries[] = 'INSERT IGNORE INTO '.TABLE_CONFIG.' (config_name, config_value) VALUES (\'nbrjoueur\',\'3\')';
$queries[] = 'INSERT IGNORE INTO '.TABLE_CONFIG.' (config_name, config_value) VALUES (\'tagAlly\',\'\')';
$queries[] = 'INSERT IGNORE INTO '.TABLE_CONFIG.' (config_name, config_value) VALUES (\'tagAllySpy\',\'\')';
$queries[] = 'INSERT IGNORE INTO '.TABLE_CONFIG.' (config_name, config_value) VALUES (\'bilAlly\',\'\')';
$queries[] = 'INSERT IGNORE INTO '.TABLE_CONFIG.' (config_name, config_value) VALUES (\'tblAlly\',\'varally\')';


foreach ($queries as $query) {
	$db->sql_query($query);
}
?>