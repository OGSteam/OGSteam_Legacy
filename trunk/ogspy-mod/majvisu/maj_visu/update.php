<?php

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}




$query = "UPDATE ".TABLE_MOD." SET `version`='1.1a' WHERE `action`='maj_visu'";
$db->sql_query($query);


?>