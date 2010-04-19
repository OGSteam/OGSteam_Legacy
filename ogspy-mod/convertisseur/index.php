<?php
/**
* index.php Fichier principal
* @package convertisseur
* @author Mirtador
* @link http://www.ogsteam.fr
* created : 06/11/2006
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
require_once("views/page_header.php");
echo "<table width='100%'>";

//version
$result = $db->sql_query('SELECT `version` FROM `'.TABLE_MOD.'` WHERE `action`=\''.$pub_action.'\' AND `active`=\'1\' LIMIT 1');
if (!$db->sql_numrows($result)) die('Mod désactivé !');
$version = $db->sql_fetch_row($result);
$version = $version[0];

//menu

if ($pub_page != "Convertisseur" And (isset($pub_page))) {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=convertisseur&page=Convertisseur';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Convertisseur</font></a>";
	echo "</td>"."\n";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Convertisseur</a>";
	echo "</th>"."\n";
}

if ($pub_page != "historique") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=convertisseur&page=historique';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Historique des versions</font></a>";
	echo "</td>"."\n";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Historique des versions</a>";
	echo "</th>"."\n";
}

//Si la page a afficher n'est pas définie, on affiche la première

if (isset($pub_page))
{
}
else
{
	$pub_page = "Convertisseur";
}

if ($pub_page == "Convertisseur")
{
	include("convertisseur.php");
}


if ($pub_page == "historique")
{
	include("historique.php");
}
?>
