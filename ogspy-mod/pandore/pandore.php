<?php
/***************************************************************************
*	filename	: pandore.php
*	version		: 0.5
*	desc.			: Calcul des points à partir des rapports d'espionnages et déduction de la flotte.
*	Authors		: Scaler - http://ogsteam.fr
*	created		: 12:56 01/11/2007
*	modified	: 14:03 08/01/2010
***************************************************************************/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//error_reporting(E_ALL | E_STRICT);
$mod_folder = "pandore";
$filename = 'mod/'.$mod_folder.'/version.txt';
if (file_exists($filename)) $file = file($filename);

require_once("mod/".$mod_folder."/lang/lang_fr.php");
if (file_exists("mod/".$mod_folder."/lang/lang_fr.php")) require_once("mod/".$mod_folder."/lang/lang_fr.php");
if (file_exists("mod/".$mod_folder."/lang/lang_fr.php")) require("mod/".$mod_folder."/lang/lang_fr.php");

$mod_name = 'Pandore';
$mod_version = trim($file[1]);
$link_pandore = "href='http://ogsteam.fr/sujet-4368' target='_blank'";
$pages['fichier'][0] = 'recherche'; $pages['texte'][0] = $lang['pandore_search']; $pages['admin'][0] = 0;
$pages['fichier'][1] = 'enregistrements'; $pages['texte'][1] = $lang['pandore_records']; $pages['admin'][1] = 0;
$pages['fichier'][2] = 'changelog'; $pages['texte'][2] = $lang['pandore_changelog']; $pages['admin'][2] = 0;

require_once("views/page_header.php");
if (!isset($pub_page)) $pub_page = $pages['fichier'][0];
echo "\n\t\t\t<table>\n\t\t\t\t<tr align='center'>\n";
for ($i=0; $i<count($pages['fichier']); $i++) {
	if (($pages['admin'][$i] && IsUserAdmin()) || (!$pages['admin'][$i])) {
		if ($pub_page != $pages['fichier'][$i]) echo "\t\t\t\t\t<td class='c' width='150' onclick=\"window.location = '?action=".$mod_name."&page=".$pages['fichier'][$i]."';\"><a style='cursor:pointer'>".$pages['texte'][$i]."</a></td>\n";
		else echo "\t\t\t\t\t<th width='150'>".$pages['texte'][$i]."</th>\n";
	}
}
echo "\t\t\t\t</tr>\n\t\t\t</table>\n<br />";
include($pub_page.".php");

echo "<div align=center><font size='2'>".sprintf($lang['pandore_created_by'],"0.5"," <a href=mailto:gon.freecks@gmail.com>Scaler</a> &copy; 2008")."</font><br>";
echo "<div align=center><font size='2'>".sprintf($lang['pandore_created_by'],$mod_version,"Shad &copy; 2011")."</font><br>";
echo "<font size='1'>".sprintf($lang['pandore_forum'],"<a ".$link_pandore.">","</a>").".</font></div>";
require_once("views/page_tail.php");
?>
