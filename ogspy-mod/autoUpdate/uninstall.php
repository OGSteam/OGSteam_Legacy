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
if(file_exists("mod/autoupdate/modupdate.xml")) {
	unlink("mod/autoupdate/modupdate.xml");
}
if(file_exists("mod/modupdate.xml")) {
	unlink("mod/modupdate.xml");
}
?>
