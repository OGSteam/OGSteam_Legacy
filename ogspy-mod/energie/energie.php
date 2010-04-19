<?php
/***************************************************************************
*	filename	: energie.php
*	package		: Mod Energie
*	version		: 0.7
*	desc.			: Calcul du moyen de production d'énergie le plus rentable
*	Authors		: Scaler - http://ogsteam.fr
*	created		: 10:30 08/11/2007
*	modified	: 02:10 30/08/2008
***************************************************************************/

//error_reporting(E_ALL);

if (!defined('IN_SPYOGAME')) die("Hacking attempt");
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='energie' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

$filename = "mod/Energie/version.txt";
if (file_exists($filename)) $file = file($filename);
$mod_version = trim($file[1]);
$mod_name = "energie";
$changelog_link = "<a href='index.php?action=".$mod_name."&page=changelog'>";
$mod_creator = "<a href=mailto:gon.freecks@gmail.com>Scaler</a> &copy; 2007";
$forum_link = "<a href='http://ogsteam.fr/sujet-3964' target='_blank'>";

require_once("mod/Energie/lang/lang_fr.php");
if (file_exists("mod/Energie/lang/lang_".$server_config['language'].".php")) require_once("mod/Energie/lang/lang_".$server_config['language'].".php");
if (file_exists("mod/Energie/lang/lang_".$user_data['user_language'].".php")) require("mod/Energie/lang/lang_".$user_data['user_language'].".php");

require_once("views/page_header.php");
if (!isset($pub_page)) $pub_page = "calcul";
include("$pub_page.php");

echo "<div align=center><font size='2'>".sprintf($lang['energy_created_by'],$mod_version,$mod_creator)."</font><br>".
	"<font size='1'>".sprintf($lang['energy_changelog'],$changelog_link,$forum_link).".</font></div>\n";
require_once("views/page_tail.php");
?>
