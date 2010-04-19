<?php
/***************************************************************************
*	filename	: index.php
*	desc.		: début du script du module "Présentation Alliance"
*	Authors	: Sylar - sylar@ogsteam.fr
*	created	: 23/02/2008
*	modified	: 25/02/2008
*	version	: 0.1
***************************************************************************/
if (!defined('IN_SPYOGAME')) 	die("Hacking attempt");

// Définitions
global $mod_name;
$mod_name = "presentation_alliance";

// Tout se passe dans config
require_once("config.php");

// Menu OGSpy
require_once("views/page_header.php");

// Si le dossier de sortie n'existe toujours pas, on demande à l'utilisateur
if(!is_dir(FOLDER_OUTPUT))
{
	echo"<center><h1>Mod Présentation alliance</h1></center>";
	echo"<br/><br/><br/><br/><font color='white'><blink>Veuillez créer le dossier : '".FOLDER_OUTPUT."'</blink></font>";
	exit();
}

// Titre
echo"<center><font size='50' face='Verdana' color='#CECECE'>- Présentation alliance -</font></center>";

// Affichage du menu
$return = $target = "";
if(!isset($pub_page)) $pub_page = $menu[0]['lien'];
foreach($menu as $btn)
	if (($btn['admin'] && $user_data["user_admin"] == 1) || (!$btn['admin']))
	{
		$return .= "\t<td class='b' width='80' valign='center' height='30' onclick=\"window.location = 'index.php?action=".$mod_name."&page=".$btn['lien']."';\">\n";
		$return .= "\t\t<b><font color='".($pub_page==$btn['lien']?"white":"grey")."'>".$btn['titre']."</font></b>\n\t</td>\n";
	}
echo "\n\n<!-- menu -->\n<table><tbody><tr align='center'>".$return."\n</tr></tbody></table>\n";

// Affichage de la page demandée
echo "\n\n<!-- page ".$pub_page.".php -->\n";
include_once(FOLDER_PAGES."/".$pub_page.".php");

// Footer du mod
include_once(FILE_FOOTER);

// Footer OGSpy
require_once("views/page_tail.php");

// Debug
debug_log("",1);
?>