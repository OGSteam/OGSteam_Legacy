<?php
/**
* install.php Install le mod sur OGSpy
* @package [MOD] RCConv
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 0.5c
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

$query0 = "SELECT config_value FROM ".TABLE_CONFIG." WHERE config_name = 'version' LIMIT 1";
$result0 = $db->sql_query($query0);
list($fetch) = $db->sql_fetch_row($result0);

if ($fetch >= "3.10dev") {
	// Install avec numéro de version automatique pour la version 3.10dev
	$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, menupos, tooltip, dateinstall, updated, noticeifnew, catuser, root, link, version, position, active) VALUES ('', 'RCConv', 'RCConv', 'RCConv', '3', '".addslashes('<table width=\\\'250\\\'><tr><td class=\\\'c\\\' align=\\\'center\\\'>Sous-menu de RCConv</td></tr><tr><th><div align=\\\'left\\\'><a style=\\\'cursor:pointer\\\' title=\\\'Convertisseur de RC\\\' href=\\\'index.php?action=RCConv\\\'>Convertisseur de RC</a><br /><a style=\\\'cursor:pointer\\\' title=\\\'Convertisseur de RR\\\' href=\\\'index.php?action=RCConv&page=RR\\\'>Convertisseur de RR</a><br /><a style=\\\'cursor:pointer\\\' title=\\\'Définir les couleurs\\\' href=\\\'index.php?action=RCConv&page=cookie\\\'>Définir les couleurs</a></div></th></tr></table>')."', '".time()."', '0', '0', '0', 'RCConv', 'index.php', '0.1', '-1', '1')";
} else {
	// Install pour les autres versions
	$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('', 'RCConv', 'RCConv', 'RCConv', 'RCConv', 'index.php', '0.2b', '1')";
}
$db->sql_query($query);

if (file_exists('mod/'.$pub_directory.'/version.txt')) {
	$file = file('mod/'.$pub_directory.'/version.txt');

	$db->sql_query('UPDATE '.TABLE_MOD.' SET `version` = \''.trim($file[1]).'\' WHERE `root` = \''.$pub_directory.'\'');
}
?>