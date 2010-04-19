<?php
/***********************************************************************
 * filename	:	index.php
 * desc.	:	Fichier principal
 * created	: 	06/11/2006 Mirtador
 *
 * *********************************************************************/
if (!defined('IN_SPYOGAME') && !defined('IN_UNISPY2')) {
	die("Hacking attempt");
}
if(!defined('IN_UNISPY2'))
	require_once("views/page_header.php");
extract($_GET,EXTR_PREFIX_ALL,'pub');//remplace import_request_variables par extract pour UniSpy
extract($_POST,EXTR_PREFIX_ALL,'pub');
//echo 'OKOK'.$pub_page;
echo "<table width='100%'>";

//version
$vertion='1.6f';
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