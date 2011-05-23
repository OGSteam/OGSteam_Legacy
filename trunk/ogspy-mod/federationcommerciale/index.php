<?php
/***********************************************************************
 * filename	:	index.php
 * desc.	:	Fichier principal
 * created	: 	06/11/2006 Mirtador
 *
 * *********************************************************************/
 //on fait un peut de sécuritée
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
//Débug
/*
error_reporting(E_ALL);
*/

//Si la page a afficher n'est pas définie, on affiche la première
if (!isset($pub_page))
{
	$pub_page = "Calculateur";
}

//On récupère la version actuel du mod et son nom
$query = 'SELECT `title`, `version` FROM `'.TABLE_MOD.'` WHERE `action`=\''.$pub_action.'\' AND `active`=\'1\' LIMIT 1';
$result = $db->sql_query($query);
if (!$db->sql_numrows($result)) die('Hacking attempt');
list($mod,$version) = $db->sql_fetch_row($result);

require_once("views/page_header.php");
include("calculateur.php");
echo "<table width='100%'>";

//menu
if ($pub_page != "Calculateur" And (isset($pub_page))) {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=federation_commerciale&page=Calculateur';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Calculateur</font></a>";
	echo "</td>"."\n";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Calculateur</a>";
	echo "</th>"."\n";
}

if ($pub_page != "sauvegarde_liste" And "sauvegarde_voir") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=federation_commerciale&page=sauvegarde_liste';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Sauvegarde</font></a>";
	echo "</td>"."\n";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Sauvegarde</a>";
	echo "</th>"."\n";
}

if ($pub_page != "historique") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=federation_commerciale&page=historique';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Historique des versions</font></a>";
	echo "</td>"."\n";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Historique des versions</a>";
	echo "</th>"."\n";
}

//on affiche les page
if ($pub_page == "Calculateur"){
	include("interface_calculateur.php");
}
if ($pub_page == "sauvegarder"){
	include("sauvegarder.php");
}
if ($pub_page == "sauvegarde_liste"){
	include("sauvegarde_liste.php");
}
if ($pub_page == "sauvegarde_voir"){
	include("sauvegarde_voir.php");
}
if ($pub_page == "historique"){
	include("historique.php");
}
?>