<?php
/**
* AnalysePlanettes.php 
 * @package QuiMobserve
 * @author Santory
 * @link http://www.ogsteam.fr
 * @version : 0.1d
 */

// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
//On vérifie que le mod est activé

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='QuiMobserve' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");


//Définitions
global $db;
global $table_prefix;
global $tableau;
define("TABLE_QUIMOBSERVE", $table_prefix."MOD_quimobserve");
define("TABLE_UNIVERSE", $table_prefix."universe");
$timestamp = 0;
$datadate = mktime (0,0,0,date("m",$timestamp),date("d",$timestamp),date("y",$timestamp));
$query_limit = "SELECT  `spy_planetteEspion`  ,  `spy_maplanette` , `datadate` ,  `pourcentage`  FROM `".TABLE_QUIMOBSERVE."` WHERE `datadate` >= $datadate and `sender_id` = ".$user_data['user_id']." ORDER BY `datadate` DESC";
$result=$db->sql_query($query_limit);
if($result=$db->sql_numrows($result)==0){
	$max_spy=0;
}else{
	$i = 0;
	while(list($spy_planetteEspion, $spy_maplanette, $datadate, $pourcentage)=$db->sql_fetch_row($result)){
		$spying_espion[$i]	= $spy_planetteEspion;
		$spying_cible[$i]	= $spy_maplanette;
		$spying_date[$i]	= $datadate;
		$spying_pourcentage[$i]	= $pourcentage;
		$i++;
	}
	$max_spy = $i;
}
$j=0;
for($j=0;$j<$max_spy;$j++){
	$dPoint = strpos($spying_espion[$j],":");
	$dPoint2 = strpos($spying_espion[$j],":",$dPoint+1);
	$galaxy = substr ($spying_espion[$j],0,$dPoint);
	$system = substr ($spying_espion[$j],$dPoint+1,$dPoint2-2);
	$row = substr ($spying_espion[$j],$dPoint2+1);
	$query_limit = "SELECT  `player`  ,  `ally`  FROM `".TABLE_UNIVERSE."` WHERE `galaxy` = ".$galaxy." and `system` = ".$system." and `row` = ".$row;
	$result=$db->sql_query($query_limit);
	while(list($player,$ally)=$db->sql_fetch_row($result)){
		$spyer = $player;
		$spyerally = $ally;
	}
	$dPoint = strpos($spying_cible[$j],":");
	$dPoint2 = strpos($spying_cible[$j],":",$dPoint+1);
	$gg = substr ($spying_cible[$j],0,$dPoint);
	$ss = substr ($spying_cible[$j],$dPoint+1,$dPoint2-2);
	$rr = substr ($spying_cible[$j],$dPoint2+1);
	if($gg==$galaxy){ // De la meme galaxie
		if($ss==$system){ // Du meme systeme
			if($rr>$row){
				$dist=1000+($rr-$row)*5; // Distance entre 2 planetes d'un meme systemes.
			}else{
				$dist=1000+($row-$rr)*5; 
			}
		}else{ // Pas du meme systeme
			if($ss>$system){
				$dist=2700+($ss-$system)*95; // Distance entre 2 systemes.
			}else{
				$dist=2700+($system-$ss)*95;
			}
		}
	}else{ // Pas la même galaxie.
		if($gg>$galaxy){
			$dist=($gg-$galaxy)*20000; // Distance entre 2 Galaxie.
		}else{
			$dist=($galaxy-$gg)*20000; 
		}
	}
	$tableau["date"][$j] = $spying_date[$j];
	$tableau["espion"][$j] = $spying_espion[$j];
	$tableau["espion_link"][$j] = $galaxy."&system=".$system;
	$tableau["spyer"][$j] = $spyer;
	$tableau["spyerally"][$j] = $spyerally;
	$tableau["distance"][$j] = $dist;
	$tableau["cible"][$j] = $spying_cible[$j];
	$tableau["pourcentage"][$j] = $spying_pourcentage[$j];
	$liste[$j] = $j;
}
if(!isset($pub_sort)) $pub_sort="date";
if(!isset($pub_ord)) $pub_ord="asc";
for($i=0;$i<$max_spy-1;$i++){
	$w=$i;
	for($j=$i+1;$j<$max_spy;$j++)
	{
		$a=strtolower($tableau[$pub_sort][$liste[$j]]);
		$b=strtolower($tableau[$pub_sort][$liste[$w]]);
		if( ($a < $b) && ($pub_ord=="desc") )
			$w=$j;
		if( ($a > $b) && ($pub_ord=="asc") ) 
			$w=$j;
	}
	if($w!=$i){
		$k=$liste[$i];
		$liste[$i]=$liste[$w];
		$liste[$w]=$k;
	}
}
require_once("mod/QuiMObserve/VueGenerale.php");
echo"<fieldset><legend><b><font color='#80FFFF'>Liste d'espionnage";
echo"</font></b></legend>";
if($max_spy!=0){
	echo"<table><tr>";
	echo"<td class='b' align='center' width = '150'>";
	echo"<a href='index.php?action=QuiMobserve&page=Accueil&sort=date&ord=desc'> <img src='images/desc.png'> </a> ";
	echo"<b>Date</b>";
	echo"<a href='index.php?action=QuiMobserve&page=Accueil&sort=date&ord=asc'> <img src='images/asc.png'> </a> ";
	echo"</td><td class='b' align='center' width = '150'>";
	echo"<a href='index.php?action=QuiMobserve&page=Accueil&sort=espion&ord=desc'> <img src='images/desc.png'> </a> ";
	echo"<b>Planète de départ</b>";
	echo"<a href='index.php?action=QuiMobserve&page=Accueil&sort=espion&ord=asc'> <img src='images/asc.png'> </a> ";
	echo"</td><td class='b' align='center' width = '150'>";
	echo"<a href='index.php?action=QuiMobserve&page=Accueil&sort=spyer&ord=desc'> <img src='images/desc.png'> </a> ";
	echo"<b>Joueur</b>";
	echo"<a href='index.php?action=QuiMobserve&page=Accueil&sort=spyer&ord=asc'> <img src='images/asc.png'> </a> ";
	echo"</td><td class='b' align='center' width = '100'>";
	echo"<a href='index.php?action=QuiMobserve&page=Accueil&sort=spyerally&ord=desc'> <img src='images/desc.png'> </a> ";
	echo"<b>Alliance</b>";
	echo"<a href='index.php?action=QuiMobserve&page=Accueil&sort=spyerally&ord=asc'> <img src='images/asc.png'> </a> ";
	echo"</td><td class='b' align='center' width = '90'>";
	echo"<a href='index.php?action=QuiMobserve&page=Accueil&sort=distance&ord=desc'> <img src='images/desc.png'> </a> ";
	echo"<b>Distance</b>";
	echo"<a href='index.php?action=QuiMobserve&page=Accueil&sort=distance&ord=asc'> <img src='images/asc.png'> </a> ";
	echo"</td><td class='b' align='center' width = '150'>";
	echo"<a href='index.php?action=QuiMobserve&page=Accueil&sort=cible&ord=desc'> <img src='images/desc.png'> </a> ";
	echo"<b>Planète Cible</b>";
	echo"<a href='index.php?action=QuiMobserve&page=Accueil&sort=cible&ord=asc'> <img src='images/asc.png'> </a> ";
	echo"</td><td class='b' align='center' width = '80'>";
	echo"<a href='index.php?action=QuiMobserve&page=Accueil&sort=pourcentage&ord=desc'> <img src='images/desc.png'> </a> ";
	echo"<b>%%</b>";
	echo"<a href='index.php?action=QuiMobserve&page=Accueil&sort=pourcentage&ord=asc'> <img src='images/asc.png'> </a> ";
	 echo "</td></tr>";
	$pages_lgs = 10;
	if(!isset($pub_pagenum)) $pub_pagenum = 1;
	$start=($pub_pagenum-1)*10;
	$stop=$start+$pages_lgs;
	if($stop>$max_spy) $stop=$max_spy;
	for($i=$start;$i<$stop;$i++){
		$j = $liste[$i];
		echo"<tr>";
		echo"<td class='b' align='center'><b>Le ".date("d/m/Y",$tableau["date"][$j])." à ".date("H:i:s", $tableau["date"][$j])."</b></td>"; 
		echo"<td class='c' align='center'><b><a href='index.php?action=galaxy&galaxy=".$tableau["espion_link"][$j]."'>".$tableau["espion"][$j]."</b></td>";
		echo"<td class='c' align='center'><b><a href='index.php?action=search&type_search=player&string_search=".$tableau["spyer"][$j]."&strict=on'>".$tableau["spyer"][$j]."</b></td>";
		echo"<td class='c' align='center'><b><a href='index.php?action=search&type_search=ally&string_search=".$tableau["spyerally"][$j]."&strict=on'>".$tableau["spyerally"][$j]."</b></td>";
		echo"<td class='c' align='center'><b>".$tableau["distance"][$j]."</b></td>";
		echo"<td class='c' align='center'><b>".$tableau["cible"][$j]."</b></td>";
		echo"<td class='c' align='center'><b>".$tableau["pourcentage"][$j]."%</b></td>";
		echo "</tr>";
	}
	echo"<tr>";
	echo"<td class='a' align='center'>";
	if($pub_pagenum==1)	{
		echo"'<i>Page Précédente</i>";
	}else{
		echo"<a href='index.php?action=QuiMobserve&page=Accueil&sort=".$pub_sort."&ord=".$pub_ord."&pagenum=".($pub_pagenum-1)."'>Page Précédente</a>";
	}
	echo"</td>";
	echo"<td class='a' align='center'>";
	if($pub_pagenum*10+1>$max_spy){
		echo"<i>Page Suivante</i>";
	}else{
		echo"<a href='index.php?action=QuiMobserve&page=Accueil&sort=".$pub_sort."&ord=".$pub_ord."&pagenum=".($pub_pagenum+1)."'>Page Suivante<a>";
	}
	echo"</td>";
	echo"<td class='d' align='center'><b> </b></td>";
	echo"<td class='d' align='center'><b> </b></td>";
	echo"<td class='d' align='center'><b> </b></td>";
	echo"<td class='d' align='center'><b> </b></td>";
	if(floor($max_spy/10)!=($max_spy/10))
		$max_page = floor($max_spy/10)+1;
	echo"<td class='c' align='center'><b> Page ".$pub_pagenum." sur ".$max_page."</b></td>";
	echo "</tr>";
	echo "</table>\n";
}else{
	echo "<div align='center'>Il n'y a aucun rapports d'espionnage dans la base de données.</div>";
}
str_replace('\n','^n',$debug);
echo "</fieldset>";
$pub_insert="yes";
require_once("mod/QuiMObserve/Insertion.php");
?>
