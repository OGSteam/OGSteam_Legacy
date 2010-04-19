<?php
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;

$query = "DELETE FROM ".TABLE_MOD." WHERE title='Usines'";

$db->sql_query($query);
?>