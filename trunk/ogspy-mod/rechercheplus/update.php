<?php
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;

$query = "UPDATE ".TABLE_MOD." SET version='0.4e' WHERE `action`='recherche_plus'";
$db->sql_query($query);
?>