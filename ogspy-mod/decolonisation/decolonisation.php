<?php
/***************************************************************************
*	filename	: decolonisation.php
*	package		: Mod Decolonisation
*	version		: 0.7c
*	desc.			: Calcul des points par planète.
*	Authors		: Jojo.lam44 & Scaler - http://ogsteam.fr
*	created		: 11/08/2006
*	modified	: 01:50 01/06/2009
***************************************************************************/

//error_reporting(E_ALL);

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

$filename = "mod/decolonisation/version.txt";
if (file_exists($filename)) $file = file($filename);
$mod_version = trim($file[1]);
$mod_name = "decolonisation";
$changelog_link = "<a href='index.php?action=".$mod_name."&page=changelog'>";
$creator_name = "<a href=mailto:jojolam44@hotmail.com>Jojo.lam44</a> &copy; 2006<br />";
$modifier_name = "<a href=mailto:gon.freecks@gmail.com>Scaler</a> &copy; 2007";

$forum_link = "<a href='http://ogsteam.fr/sujet-1231' target='_blank'>";

require_once("mod/decolonisation/lang/lang_fr.php");
if (file_exists("mod/decolonisation/lang/lang_".$server_config['language'].".php")) require_once("mod/decolonisation/lang/lang_".$server_config['language'].".php");
if (file_exists("mod/decolonisation/lang/lang_".$user_data['user_language'].".php")) require("mod/decolonisation/lang/lang_".$user_data['user_language'].".php");

require_once("views/page_header.php");
if (!isset($pub_page)) $pub_page = "points";
include("$pub_page.php");

echo "<div align=center><font size='2'>".sprintf($lang['decolo_created_by'],$mod_version,$creator_name,$modifier_name)."</font><br />".
	"<font size='1'>".sprintf($lang['decolo_changelog'],$changelog_link,$forum_link).".</font></div>";
require_once("views/page_tail.php");
?>
