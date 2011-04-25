<?php
/** $Id$ **/
/**
* install.php Fichier d'installation
* @package [MOD] AutoUpdate
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 1.0c
* created	: 27/10/2006
* modified	: 18/01/2007
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

$query = "INSERT INTO ".TABLE_MOD." ( title, menu, action, root, link, version, active) VALUES ( 'AutoUpdate', 'Mise &agrave; jour<br />de [MOD]', 'autoupdate', 'autoupdate', 'autoupdate.php', '1.1', '1')";
$db->sql_query($query);
?>
