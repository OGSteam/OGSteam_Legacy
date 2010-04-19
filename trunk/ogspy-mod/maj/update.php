<?php
/**
* update.php du mod MAJ
* @package MAJ
* @author ben.12
* @link http://www.ogsteam.fr
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db, $server_config;

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
	$query = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('popup_maj_step_rank_player_alert', '10')";
	$db->sql_query($query);
}

if(!isset($server_config['popup_maj_step_rank_ally_alert'])) {
	$query = "INSERT INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('popup_maj_step_rank_ally_alert', '10')";
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

$query = "UPDATE ".TABLE_MOD." SET `version`='0.3c' WHERE `action`='mod_maj'";
$db->sql_query($query);
?>
