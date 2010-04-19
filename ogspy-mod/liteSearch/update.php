<?php

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}




$query = "UPDATE ".TABLE_MOD." SET `version`='1.2b' WHERE `action`='litesearch'";
$db->sql_query($query);


?>