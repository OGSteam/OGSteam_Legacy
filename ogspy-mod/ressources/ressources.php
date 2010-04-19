<?php
/***************************************************************************
*	filename	: ressources.php
*	package		: Mod Ressources
*	version		: 0.2b
*	desc.			: Calcul des ressources disponibles.
*	Author		: Scaler - http://ogsteam.fr
*	created		: 11/08/2006
*	modified	: 19:14 20/01/2010
***************************************************************************/

//error_reporting(E_ALL);

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

$filename = "mod/Ressources/version.txt";
if (file_exists($filename)) $file = file($filename);
$mod_version = trim($file[1]);
$mod_name = "ressources";
$changelog_link = "<a href='?action=".$mod_name."&page=changelog'>";
$creator_name = "<a href=mailto:gon.freecks@gmail.com>Scaler</a> &copy; 2010";

$forum_link = "<a href='http://ogsteam.fr/sujet-5627' target='_blank'>";

require_once("mod/Ressources/lang/lang_en.php");
if (file_exists("mod/Ressources/lang/lang_".$server_config['language'].".php")) require_once("mod/Ressources/lang/lang_".$server_config['language'].".php");
if (file_exists("mod/Ressources/lang/lang_".$user_data['user_language'].".php")) require_once("mod/Ressources/lang/lang_".$user_data['user_language'].".php");

// Changement du format des dates
setlocale(LC_TIME, $lang['ressources_locale']);

require_once("views/page_header.php");
if (!isset($pub_page)) $pub_page = "calculs";
include("$pub_page.php");

echo "<div align=center><font size='2'>".sprintf($lang['ressources_created_by'],$mod_version,$creator_name)."</font><br />".
	"<font size='1'>".sprintf($lang['ressources_changelog'],$changelog_link,$forum_link,"</a>").".</font></div>";
require_once("views/page_tail.php");
?>
