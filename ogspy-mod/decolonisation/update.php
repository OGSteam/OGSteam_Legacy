<?php
if (!defined('IN_SPYOGAME')) die('Hacking attempt');

$filename = 'mod/decolonisation/version.txt';
if (file_exists($filename)) $file = file($filename);

$query = "UPDATE ".TABLE_MOD." SET version='".trim($file[1])."' WHERE `action`='decolonisation' ";
$db->sql_query ( $query );
?>