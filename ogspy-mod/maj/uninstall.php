<?php
/**
* uninstall.php du mod MAJ
* @package MAJ
* @author ben.12
* @link http://www.ogsteam.fr
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db, $table_prefix, $server_config;
define("TABLE_MAJ", $table_prefix."maj");

if(isset($server_config['step_maj'])) {
	$query = "DELETE FROM ".TABLE_CONFIG." WHERE `config_name`='step_maj'";
	$db->sql_query($query);
}

if(isset($server_config['step_jrs'])) {
	$query = "DELETE FROM ".TABLE_CONFIG." WHERE `config_name`='step_jrs'";
	$db->sql_query($query);
}

if(isset($server_config['popup_maj_active'])) {
	$query = "DELETE FROM ".TABLE_CONFIG." WHERE `config_name`='popup_maj_active'";
	$db->sql_query($query);
}

if(isset($server_config['popup_maj_seuil_alert'])) {
	$query = "DELETE FROM ".TABLE_CONFIG." WHERE `config_name`='popup_maj_seuil_alert'";
	$db->sql_query($query);
}

if(isset($server_config['popup_maj_step_rank_player_alert'])) {
	$query = "DELETE FROM ".TABLE_CONFIG." WHERE `config_name`='popup_maj_step_rank_player_alert'";
	$db->sql_query($query);
}

if(isset($server_config['popup_maj_step_rank_ally_alert'])) {
	$query = "DELETE FROM ".TABLE_CONFIG." WHERE `config_name`='popup_maj_step_rank_ally_alert'";
	$db->sql_query($query);
}

if(isset($server_config['popup_maj_num_rank_player_alert'])) {
	$query = "DELETE FROM ".TABLE_CONFIG." WHERE `config_name`='popup_maj_num_rank_player_alert'";
	$db->sql_query($query);
}

if(isset($server_config['popup_maj_num_rank_ally_alert'])) {
	$query = "DELETE FROM ".TABLE_CONFIG." WHERE `config_name`='popup_maj_num_rank_ally_alert'";
	$db->sql_query($query);
}

$query = "DROP TABLE ".TABLE_MAJ;
$db->sql_query($query);
?>
