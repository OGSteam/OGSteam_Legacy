<?php
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $server_config;
require_once("mod/decolonisation/lang/lang_fr.php");
if (file_exists("mod/decolonisation/lang/lang_".$server_config['language'].".php")) require_once("mod/decolonisation/lang/lang_".$server_config['language'].".php");

$filename = 'mod/decolonisation/version.txt';
if (file_exists($filename)) $file = file($filename);

$query = "INSERT INTO ".TABLE_MOD." (title, menu, action, root, link, version, active) VALUES ('".$lang['decolo_nization']."','".$lang['decolo_nization']."','decolonisation','decolonisation','decolonisation.php','".trim($file[1])."','1')";
$db->sql_query($query);
?>
