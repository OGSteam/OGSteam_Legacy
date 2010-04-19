<?php
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db, $table_prefix;

define("TABLE_FRAME", $table_prefix."mod_frames");

$query = "CREATE TABLE ".TABLE_FRAME." ("
		." `id` INT( 15 ) NOT NULL AUTO_INCREMENT,"
		." `name` VARCHAR( 255 ) NOT NULL ,"
		." `url` VARCHAR( 255 ) NOT NULL ,"
		." `frame_id` INT( 15 ) NOT NULL ,"
		." `hauteur` INT( 15 ) NOT NULL DEFAULT '50' ,"
		." UNIQUE (`id`)"
		.")";
$db->sql_query($query);

if (file_exists('mod/ModFrame/version.txt'))
	$file = file('mod/ModFrame/version.txt'); 

$query = "INSERT INTO ".TABLE_MOD." ( title, menu, action, root, link, version, active) VALUES ('Mod Frame','Mod Frame','ModFrame','ModFrame','index.php','".trim($file[1])."','1')";
$db->sql_query($query);
?>