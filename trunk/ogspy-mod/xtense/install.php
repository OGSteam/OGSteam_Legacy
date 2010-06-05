<?php
/**
 * @package Xtense
 * @author Unibozu
 * @licence GNU
 */

if (!defined('IN_SPYOGAME')) die("Hacking Attemp!");
$root = $pub_directory;

require_once('mod/'.$root.'/includes/config.php');
	
//---- Creation de la table des Callbacks
$db->sql_query("CREATE TABLE IF NOT EXISTS `".TABLE_XTENSE_CALLBACKS."` (
  `id` int(3) NOT NULL auto_increment,
  `mod_id` int(3) NOT NULL,
  `function` varchar(30) NOT NULL,
  `type` enum('overview','system','ally_list','buildings','research','fleet','fleetSending','defense','spy','ennemy_spy','rc','rc_cdr', 'msg', 'ally_msg', 'expedition','ranking_player_fleet','ranking_player_points','ranking_player_research','ranking_ally_fleet','ranking_ally_points','ranking_ally_research') NOT NULL,
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mod_id` (`mod_id`,`type`),
  KEY `active` (`active`)
)");

$db->sql_query("CREATE TABLE IF NOT EXISTS `".TABLE_XTENSE_GROUPS."` (
  `group_id` int(4) NOT NULL,
  `system` tinyint(4) NOT NULL,
  `ranking` tinyint(4) NOT NULL,
  `empire` tinyint(4) NOT NULL,
  `messages` tinyint(4) NOT NULL,
  PRIMARY KEY  (`group_id`)
)");

//---- Creation configuration Xtense
$db->sql_query("REPLACE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES
	('xtense_allow_connections', '1'),
	('xtense_log_empire', '0'),
	('xtense_log_ranking', '1'),
	('xtense_log_spy', '1'),
	('xtense_log_system', '1'),
	('xtense_log_ally_list', '1'),
	('xtense_log_messages', '1'),
	('xtense_log_reverse', '0'),
	('xtense_log_ogspy', '1'),
	('xtense_strict_admin', '0'),
	('xtense_universe', 'htt://uni1.ogame.fr'),
	('xtense_keep_log', '14'),
	('xtense_plugin_root', '0'),
	('xtense_spy_autodelete', '1')
");

$db->sql_query("REPLACE INTO ".TABLE_XTENSE_GROUPS." (`group_id`, `system`, `ranking`, `empire`, `messages`) VALUES
	('1', '1', '1', '1', '1')");
$db->sql_query("REPLACE INTO ".TABLE_MOD." (action, title, menu, root, link, version, active, admin_only) VALUES
	('xtense', 'Xtense', '<span onclick=\"window.open(this.parentNode.href, \'Xtense\', \'width=750, height=550, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no\'); return false;\">Xtense</span>', '{$root}', 'index.php', '{$mod_version}', '1', '1')");
	
echo "<a onclick=\"window.open('index.php?action=Xtense', 'Xtense', 'width=720, height=500, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no');\"><font color='red' size='9'>Autorisez la pop-up ou cliquez ici!</font></a><script type=\"text/javascript\"><!-- \nwindow.onload = window.open('index.php?action=Xtense', 'Xtense', 'width=720, height=500, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no');\n--></script>";
?>