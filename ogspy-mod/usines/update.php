<?php
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}


$filename = 'mod/usines/version.txt';
if (file_exists($filename)) $file = file($filename);

global $table_prefix;


$query = "UPDATE ".TABLE_MOD." SET version='".trim($file[1])."' WHERE action='usines'";
$db->sql_query($query);
?>

?>