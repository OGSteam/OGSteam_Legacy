<?php
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $server_config;
global $table_prefix;
define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");
require_once("mod/Ressources/lang/lang_en.php");
if (file_exists("mod/Ressources/lang/lang_".$server_config['language'].".php")) require_once("mod/Ressources/lang/lang_".$server_config['language'].".php");

$query = "SELECT id FROM ".TABLE_MOD." WHERE action = 'ressources'";
$result = $db->sql_query($query);
list($mod_id) = $db->sql_fetch_row($result);

$query = "SHOW TABLES FROM ".$db->dbname." LIKE '".TABLE_XTENSE_CALLBACKS."'";
$result = $db->sql_query($query);
if ($db->sql_numrows($result) != 0) {
	$query = "SELECT * FROM ".TABLE_XTENSE_CALLBACKS." WHERE mod_id = ".$mod_id;
	$result = $db->sql_query($query);
	if ($db->sql_numrows($result) != 0) {
		$query = "DELETE FROM ".TABLE_XTENSE_CALLBACKS." WHERE mod_id = ".$mod_id;
		$db->sql_query($query);
		echo "<script>alert(".$lang['ressources_xtense_rem'].");</script>";
	}
}

$db->sql_query("DROP TABLE IF EXISTS `".$table_prefix."mod_ressources_hide`");
$db->sql_query("DROP TABLE IF EXISTS `".$table_prefix."mod_ressources_trade`");
$db->sql_query("DROP TABLE IF EXISTS `".$table_prefix."mod_ressources_construction`");
?>
