<?php
/**
 * index.php 
 * @package Guerres
 * @author Verité
 * @link http://www.ogsteam.fr
 * @version 0.2e
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

//L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='guerres' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

//Définitions
global $db;
global $table_prefix;
require_once("views/page_header.php");

//Menu
echo"<form action='index.php' method='post'><input type='hidden' name='action' value='guerres'>
<input type='submit' name='page' value='Liste des guerres'>
<input type='submit' name='page' value='Ajouter une attaque'>
<input type='submit' name='page' value='Liste des attaques'>
<input type='submit' name='page' value='Resultats des guerres'>
<input type='submit' name='page' value='Espace BBCode'>
<input type='submit' name='page' value='Changelog'></form>";

//Si la page a afficher n'est pas définie, on affiche la première
if (!isset($pub_page)) $pub_page = "Liste des guerres";

//Sinon affichage de la page demandée
if ($pub_page == "Liste des guerres") include("guerres.php");

if ($pub_page == "Ajouter une attaque") include("new_attack.php");

if ($pub_page == "Liste des attaques") include("list_attack.php");

if ($pub_page == "Resultats des guerres") include("resultat_attack.php");

if ($pub_page == "Espace BBCode") include("bbcode.php");

if ($pub_page == "Changelog") include("changelog.php");
?>