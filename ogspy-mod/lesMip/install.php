<?php
/**
* install.php Install le mod
* @package [MOD] Tout sur les MIP
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 0.4a
* created	: 21/08/2006
* modified	: 07/02/2007
*/

$query0 = "SELECT config_value FROM ".TABLE_CONFIG." WHERE config_name = 'version'";
$result0 = $db->sql_query($query0);
list($fetch) = $db->sql_fetch_row($result0);

switch ($fetch) {
	case "3.02c" :
		// Install avec numéro de version automatique pour la version 3.02c
		$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('','lesmip','Tout sur les MIP','lesmip','lesmip','mip.php','0.1','1')";
	break;
	
	case "3.03" :
		// Install avec numéro de version automatique pour la version 3.03
		$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('','lesmip','Tout sur les MIP','lesmip','lesmip','mip.php','0.1','1')";
	break;
	
	case "3.10dev" :
		// Install avec numéro de version automatique pour la version 3.10dev
		$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, menupos, tooltip, dateinstall, updated, noticeifnew, catuser, root, link, version, position, active) VALUES ('','lesmip','Tout sur les MIP','lesmip', '3', '".addslashes('<table width=\\\'250\\\'><tr><td class=\\\'c\\\' align=\\\'center\\\'>Sous-menu de Tout sur les MIP</td></tr><tr><th><div align=\\\'left\\\'><a style=\\\'cursor:pointer\\\' title=\\\'Simulation\\\' href=\\\'index.php?action=lesmip\\\'>Simulation</a><br /><a style=\\\'cursor:pointer\\\' title=\\\'Portée des missiles\\\' href=\\\'index.php?action=lesmip&sub=porte\\\'>Portée des missiles</a></div></th></tr></table>')."', '".time()."', '0', '0', '0', 'lesmip','mip.php','0.1', '-1', '1')";
	break;
	
	default :
		// Install avec numéro de version automatique pour les versions autres.
		$query = "INSERT INTO ".TABLE_MOD." (title, menu, action, root, link, version, active) VALUES ('lesmip','Tout sur les MIP','lesmip','lesmip','mip.php','0.1','1')";
	break;
}
$db->sql_query($query);

if (file_exists('mod/'.$pub_directory.'/version.txt')) {
	$file = file('mod/'.$pub_directory.'/version.txt');

	$db->sql_query('UPDATE '.TABLE_MOD.' SET `version` = \''.trim($file[1]).'\' WHERE `root` = \''.$pub_directory.'\'');
}
?>
