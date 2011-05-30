<?php
/**
* update.php du mod Frames
* @package Mod Frames
* @author Naruto kun
* @link http://www.ogsteam.fr
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}
global $db, $table_prefix;

$query = "SELECT version FROM ".TABLE_MOD." WHERE `action`='frame'";
$mod_folder = "frame";
$mod_name = "ModFrames";
update_mod($mod_folder, $mod_name);

$result = $db->sql_query($query);
list($mod_version) = $db->sql_fetch_row($result);

define("TABLE_FRAME", $table_prefix."mod_frames");

if ($mod_version == "0.1" || $mod_version == "0.1a" || $mod_version == "0.1b" || $mod_version == "0.1c" || $mod_version == "0.1d" || $mod_version == "0.1e"){
$query = "ALTER TABLE ".TABLE_FRAME." CHANGE `url` `url` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL";
$db->sql_query($query);

$query = "ALTER TABLE ".TABLE_FRAME." CHANGE `name` `name` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL";
$db->sql_query($query);

$query = "ALTER TABLE ".TABLE_FRAME." DROP INDEX `frame_id`";
$db->sql_query($query);
}

$db->sql_query($query);
?>
