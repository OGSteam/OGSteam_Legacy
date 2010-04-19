<?php
/**
* install.php du Mod MAJ
* @package MAJ
* @author ben.12
* @link http://www.ogsteam.fr
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db, $table_prefix, $server_config;

define("TABLE_MAJ", $table_prefix."maj");

if(!isset($server_config['step_maj'])) {
	$query = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('step_maj', '2')";
	$db->sql_query($query);
}

if(!isset($server_config['step_jrs'])) {
	$query = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('step_jrs', '15')";
	$db->sql_query($query);
}

if(!isset($server_config['popup_maj_active'])) {
	$query = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('popup_maj_active', '0')";
	$db->sql_query($query);
}

if(!isset($server_config['popup_maj_seuil_alert'])) {
	$query = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('popup_maj_seuil_alert', '70')";
	$db->sql_query($query);
}

if(!isset($server_config['popup_maj_step_rank_player_alert'])) {
	$query = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('popup_maj_step_rank_player_alert', '15')";
	$db->sql_query($query);
}

if(!isset($server_config['popup_maj_step_rank_ally_alert'])) {
	$query = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('popup_maj_step_rank_ally_alert', '15')";
	$db->sql_query($query);
}

if(!isset($server_config['popup_maj_num_rank_player_alert'])) {
	$query = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('popup_maj_num_rank_player_alert', '500')";
	$db->sql_query($query);
}

if(!isset($server_config['popup_maj_num_rank_ally_alert'])) {
	$query = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('popup_maj_num_rank_ally_alert', '500')";
	$db->sql_query($query);
}

$query = "CREATE TABLE IF NOT EXISTS ".TABLE_MAJ." ("
		." div_nb int(11) NOT NULL default '0',"
		." div_type int(11) NOT NULL default '0',"
		." name_id int(11) NOT NULL default '0',"
		." UNIQUE KEY `div_nb` (`div_nb` , `div_type`, `name_id`)"
		.")";
$db->sql_query($query);

$query = "INSERT IGNORE INTO ".TABLE_MOD." (title, menu, action, root, link, version, active) VALUES ('Mise à jour','Mise à jour','mod_maj','MAJ','maj.php','0.3c','1')";
$db->sql_query($query);
?>