<?php
/***************************************************************************
*	filename	: index.php
*	desc.		: d�but du script du module "Pr�sentation Alliance"
*	Authors	: Sylar - sylar@ogsteam.fr
*	created	: 23/02/2008
*	modified	: 18/05/2011
*	version	: 1.0
***************************************************************************/
if (!defined('IN_SPYOGAME')) 	die("Hacking attempt");

// Menu OGSpy
require_once("views/page_header.php");

// D�finitions
global $mod_name;
$mod_name = "presentationalliance";

// Tout se passe dans config
require_once("mod/".$mod_name."/config.php");

// Si le dossier de sortie n'existe toujours pas, on demande � l'utilisateur
if(!is_dir(FOLDER_OUTPUT))
{
	echo"<center><h1>Mod Pr�sentation alliance</h1></center>";
	echo"<br/><br/><br/><br/><font color='white'><blink>Veuillez cr�er le dossier : '".FOLDER_OUTPUT."'</blink></font>";
	exit();
}

?>
<table width="100%">

		<table>
		<tr align="center">
<?php
if (!isset($pub_page)) $pub_page = "accueil.php";
//Menu Acceuil
if ($pub_page != "accueil") echo '<td class="c" width="150"><a href="index.php?action='.$mod_name.'&page=accueil" style="color: lime;"';
	else echo '<th width="150"><a';
    echo '>Accueil</a></td>',"\n";
//Menu Editions
if ($pub_page != "edition") echo '<td class="c" width="150"><a href="index.php?action='.$mod_name.'&page=edition&id=0" style="color: lime;"';
	else echo '<th width="150"><a';
    echo '>Edition</a></td>',"\n";
//Menu Upload
if ($pub_page != "upload") echo '<td class="c" width="150"><a href="index.php?action='.$mod_name.'&page=upload" style="color: lime;"';
	else echo '<th width="150"><a';
    echo '>Upload</a></td>',"\n";
//Menu Changelog
if ($pub_page != "changelog") echo '<td class="c" width="150"><a href="index.php?action='.$mod_name.'&page=changelog" style="color: lime;"';
	else echo '<th width="150"><a';
    echo '>Changelog</a></td>',"\n";
	?>
		</tr>
		</table>


<?php
	switch ($pub_page) {
		case "acceuil" :
		require_once("mod/".$mod_name."/pages/accueil.php");
		break;

		case "edition" :
		require_once("mod/".$mod_name."/pages/edition.php");
		break;
		
		case "upload" :
		require_once("mod/".$mod_name."/pages/upload.php");
		break;
		
		case "changelog" :
		require_once("mod/".$mod_name."/pages/changelog.php");
		break;

		default:
		require_once("mod/".$mod_name."/pages/accueil.php");
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