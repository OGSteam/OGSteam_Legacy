<?php
/**
* index.php 
 * @package QuiMobserve
 * @author Santory
 * @link http://www.ogsteam.fr
 * @version : 0.1e
 */

//L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='QuiMobserve' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

//Définitions
global $db;
global $table_prefix;

//Si la page a afficher n'est pas définie, on affiche la première
if (!isset($pub_page)) $pub_page = "Accueil";

if($pub_page == "InfoPlanette" || $pub_page == "PlanettesScans"  ){
	require_once("views/page_header_2.php");	
}else{
	require_once("views/page_header.php");	
}

function menu($pub_page){
	//Menu
	$pages=array('Accueil','Insertion','Analyse des Planètes','Interpolation des Joueurs / Alliances','Espace Archives','Changelog');
	

	
	echo '		<table>
			<tr align="center">';
	foreach($pages as $onglet){
		if ($pub_page != $onglet) {
			echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=QuiMobserve&page=$onglet';\">";
			echo "<a style='cursor:pointer'><font color='lime'>$onglet</font></a>";
			echo "</td>";
		}
		else {
			echo "\t\t\t"."<th width='150'>";
			echo "<a>$onglet</a>";
			echo "</th>";
		}
	}
	echo "\t\t</tr>\n\t\t</table>";
}

switch ($pub_page){
	case "Accueil" : menu($pub_page);include("Accueil.php");break;
	case "Insertion" : menu($pub_page);include("Insertion.php");break;
	case "Analyse des Planètes" : menu($pub_page);include("AnalysePlanettes.php");break;
	case "Interpolation des Joueurs / Alliances" : menu($pub_page);include("Interpolation.php");break;
	case "Espace Archives" : menu($pub_page);include("Archives.php");break;
	case "Changelog" : menu($pub_page);include("changelog.php");break;
	
	case "InfoPlanette" : include("InfoPlanette.php");break;
	case "PlanettesScans" : include("PlanettesScans.php");break;
}

//Insertion du bas de page d'OGSpy
include("footer.php");

if($pub_page == "InfoPlanette" || $pub_page == "PlanettesScans"  ){
	require_once("views/page_tail_2.php");	
}else{
	require_once("views/page_tail.php");	
}

?>