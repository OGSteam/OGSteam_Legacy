<?php
/**
* index.php 
 * @package Attaques
 * @author Verit� - r��crit par ericc
 * @link http://www.ogsteam.fr
 * @version : 0.8a
 */
//L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//On v�rifie que le mod est activ�
$query = "SELECT `active`,`root` FROM `".TABLE_MOD."` WHERE `action`='attaques' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die('Mod d�sactiv� !');
$result = $db->sql_query($query);
list($active,$root) = $db->sql_fetch_row($result);

// d�finition du dossier du modules
define('FOLDER_ATTCK','mod/'.$root);
//Definition des tables du module
define("TABLE_ATTAQUES_ATTAQUES", $table_prefix."attaques_attaques");
define("TABLE_ATTAQUES_RECYCLAGES", $table_prefix."attaques_recyclages");
define("TABLE_ATTAQUES_ARCHIVES", $table_prefix."attaques_archives");

/*if (isset($pub_subaction))
  {
  require_once (FOLDER_ATTCK."/barplot.php");
  break;
  }
  
if (isset($pub_graphic))
  {
  require_once (FOLDER_ATTCK."/lineplot.php");
  break;
  }
*/

//r�cup�ration des param�tres de config
$query = "SELECT value FROM `".TABLE_MOD_CFG."` WHERE `mod`='Attaques' and `config`='config'";
$result = $db->sql_query($query);
$config = $db->sql_fetch_row($result);
$config=unserialize($config[0]);

// Appel des fonctions du module
include(FOLDER_ATTCK."/attack_include.php");
/**
*R�cup�re le fichier de langue pour la langue appropri�
*/
if (!empty($server_config['language'])) {
	if (is_dir(FOLDER_ATTCK."/languages/".$server_config['language'])) {
		require_once(FOLDER_ATTCK."/languages/".$server_config['language']."/lang_main.php");
		require_once(FOLDER_ATTCK."/languages/".$server_config['language']."/help.php");
	} else {
		require_once(FOLDER_ATTCK."/languages/french/lang_main.php");
		require_once(FOLDER_ATTCK."/languages/french/help.php");
	}
} else {
	if (!is_dir(FOLDER_ATTCK."/languages/french")) {
		echo "Ret�l�charger le mod via : <a href='http://www.ogsteam.fr/downloadmod.php?mod=Attaques'>Zip link</a><br />\n";
		exit;
	} else {
		require_once(FOLDER_ATTCK."/languages/french/lang_main.php");
		require_once(FOLDER_ATTCK."/languages/french/help.php");
	}
}

// Ent�te du site
require_once("views/page_header.php");
// Insertion du css pour layer transparent si valider dans la configuration
if ($config['layer']==1)
{
include(FOLDER_ATTCK."/css.php");
}
//Menu
// Si la page a afficher n'est pas d�finie, on affiche la premi�re
if (!isset($pub_page)) $pub_page = "attaques";
menu($pub_page);

// Affichage du layer transparent
echo"<div class='attack_box'><div class='attack_box_background'> </div> <div class='attack_box_contents'>";
//On  affiche de la page demand�e
if ($pub_page == "attaques") include("attaques.php");
elseif ($pub_page == "recyclages") include("recyclages.php");
elseif ($pub_page == "bilan") include("bilan.php");
elseif ($pub_page == "bbcode") include("bbcode.php");
elseif ($pub_page == "archive") include("archives.php");
elseif ($pub_page == "statistiques") include("statistiques.php");
elseif ($pub_page == "admin") include("admin.php");
elseif ($pub_page == "changelog") include("changelog.php");
//Si la page a afficher n'est pas d�finie, on affiche la premi�re
else include("attaques.php");

// Fin du layer transparent
echo "</div></div>";
// Version number at the bottom of the page 
require_once (FOLDER_ATTCK."/footer.php");
echo "<br/>";
//Insertion du bas de page d'OGSpy
require_once("views/page_tail.php");

?>