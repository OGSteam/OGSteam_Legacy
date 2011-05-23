<?php
/*
* uninstall.php
* @package [MOD] Temp de Vol
* @author Snipe <santory@websantory.net>
* @version 0.1b
*	created		: 07/01/2007
*/

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;

$query = "DELETE FROM ".TABLE_MOD." WHERE title='tempsvols'";

$db->sql_query($query);
?>