<?php
/***********************************************************************
 * filename	:	index.php
 * desc.	:	Fichier principal
 * created	: 	06/11/2006 Mirtador
 * @package autonomie
 * @author Mirtador
 * @link http://www.ogsteam.fr
 *
 * *********************************************************************/
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
require_once("views/page_header.php");
echo "<table width='100%'>";

//On récupère la version actuel du mod et son nom
$query = 'SELECT `title`, `version` FROM `'.TABLE_MOD.'` WHERE `action`=\''.$pub_action.'\' AND `active`=\'1\' LIMIT 1';
$result = $db->sql_query($query);
if (!$db->sql_numrows($result)) die('Hacking attempt');
list($mod,$version) = $db->sql_fetch_row($result);

//Si la page a afficher n'est pas définie, on affiche la première

if (!isset($pub_page))
	$pub_page = "autonomie";

//menu

if ($pub_page != "autonomie") {
	echo "\t\t\t"."<td class='c' width='150'>";
	echo "<a href='index.php?action=autonomie&page=autonomie'><font color='lime'>Autonomie</font></a>";
	echo "</td>"."\n";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Autonomie</a>";
	echo "</th>"."\n";
}

if ($pub_page != "historique") {
	echo "\t\t\t"."<td class='c' width='150'>";
	echo "<a href='index.php?action=autonomie&page=historique'><font color='lime'>Historique des versions</font></a>";
	echo "</td>"."\n";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Historique des versions</a>";
	echo "</th>"."\n";
}

if ($pub_page == "autonomie")
{
	include("autonomie.php");
}


if ($pub_page == "historique")
{
	include("historique.php");
}

//insertion du pied de page
echo'<table><p align=\'center\'><a href="">'.$mod.'</a> | Version '.$version.' | Mirtador | 2006</p></table>';
echo"Autonomie de production des mines, calcul des GT...<br>
Par <a href='http://board.ogsteam.fr/forums/message_send.php?id=4498'>Mirtador</a>, modifié par <a href='http://board.ogsteam.fr/forums/message_send.php?id=227'>oXid_FoX</a>.<br />
<a href='http://board.ogsteam.fr/forums/sujet-2388-mod-autonomie'>Informations</a>";

//Insertion du bas de page d'OGSpy
require_once("views/page_tail.php");
?>
