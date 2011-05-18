<?php
/***************************************************************************
*	filename	: index.php
*	desc.		: début du script du module "Présentation Alliance"
*	Authors	: Sylar - sylar@ogsteam.fr
*	created	: 23/02/2008
*	modified	: 18/05/2011
*	version	: 1.0
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

?>
<table width="100%">

		<table>
		<tr align="center">
<?php
if (!isset($pub_page)) $pub_page = "accueil.php";
//Menu Acceuil
if ($pub_page != "accueil") echo '<td class="c" width="150"><a href="index.php?action=presentation_alliance&page=accueil" style="color: lime;"';
	else echo '<th width="150"><a';
    echo '>Accueil</a></td>',"\n";
//Menu Editions
if ($pub_page != "edition") echo '<td class="c" width="150"><a href="index.php?action=presentation_alliance&page=edition&id=0" style="color: lime;"';
	else echo '<th width="150"><a';
    echo '>Edition</a></td>',"\n";
//Menu Upload
if ($pub_page != "upload") echo '<td class="c" width="150"><a href="index.php?action=presentation_alliance&page=upload" style="color: lime;"';
	else echo '<th width="150"><a';
    echo '>Upload</a></td>',"\n";
//Menu Changelog
if ($pub_page != "changelog") echo '<td class="c" width="150"><a href="index.php?action=presentation_alliance&page=changelog" style="color: lime;"';
	else echo '<th width="150"><a';
    echo '>Changelog</a></td>',"\n";
	?>
		</tr>
		</table>


<?php
	switch ($pub_page) {
		case "acceuil" :
		require_once("mod/presentationAlliance/pages/accueil.php");
		break;

		case "edition" :
		require_once("mod/presentationAlliance/pages/edition.php");
		break;
		
		case "upload" :
		require_once("mod/presentationAlliance/pages/upload.php");
		break;
		
		case "changelog" :
		require_once("mod/presentationAlliance/pages/changelog.php");
		break;

		default:
		require_once("mod/presentationAlliance/pages/accueil.php");
		break;
	}
?>
	


<?php

// Footer du mod
include_once(FILE_FOOTER);

// Footer OGSpy
require_once("views/page_tail.php");

// Debug
debug_log("",1);
?>