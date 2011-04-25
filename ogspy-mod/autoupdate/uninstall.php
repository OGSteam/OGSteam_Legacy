<?php
/** $Id$ **/
/**
* uninstall.php Désinstall le mod
* @package [MOD] AutoUpdate
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 1.0
* created	: 27/10/2006
* modified	: 19/01/2007
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

$query = "DELETE FROM ".TABLE_MOD." WHERE title='autoupdate'";
$db->sql_query($query);
if(file_exists("mod/autoupdate/modupdate.json")) {
	unlink("mod/autoupdate/modupdate.json");
}
if(file_exists("mod/modupdate.json")) {
	unlink("mod/modupdate.json");
}
?>
