<?php
/**
* index.php 
 * @package Attaques - UniSpy
 * @author Verit�
 * @link http://www.ogsteam.fr
 * @version : 0.8e
 */

//L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//On v�rifie que le mod est activ�
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='attaques' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

//D�finitions
global $db;
global $table_prefix;
require_once("views/page_header.php");

//Menu
?>
<a href="index.php?action=attaques&page=attaques">Attaques du mois</a> |
<a href="index.php?action=attaques&page=recyclages">Recyclages du mois</a> |
<a href="index.php?action=attaques&page=bilan">Bilan</a> |
<a href="index.php?action=attaques&page=bbcode">Espace BBCode</a> |
<a href="index.php?action=attaques&page=archive">Espace Archives</a> |
<a href="index.php?action=attaques&page=changelog">Changelog</a>
<br><br>
<?php
//On  affiche de la page demand�e
if ($pub_page == "attaques") include("attaques.php");
elseif ($pub_page == "recyclages") include("recyclages.php");
elseif ($pub_page == "bilan") include("bilan.php");
elseif ($pub_page == "bbcode") include("bbcode.php");
elseif ($pub_page == "archive") include("archives.php");
elseif ($pub_page == "changelog") include("changelog.php");

//Si la page a afficher n'est pas d�finie, on affiche la premi�re
else include("attaques.php");
?>