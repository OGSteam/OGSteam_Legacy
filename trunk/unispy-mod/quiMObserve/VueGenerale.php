<?php
/**
* Resume.php 
 * @package QuiMobserve(by Santory)
 * @author Sylar (this file)
 * @link http://www.ogsteam.fr
 * @version : 0.1
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
define("TABLE_QUIMOBSERVE", $table_prefix."MOD_quimobserve");
define("TABLE_UNIVERSE", $table_prefix."universe");

// Recherche de la planete la plus espionnée
//  ----> $tmp['cible'][x] et du nombre d'espionnage ------> $tmp['cible_hit'][x]
$i=0;
for($a=0;$a<$max_spy;$a++){
	$cible=$tableau['cible'][$a];
	$ok=1;
	for($j=0;$j<$i;$j++){
		if($tmp['cible'][$j]==$cible){
			$tmp['cible_hit'][$j]+=1;
			$ok=0;
		}
	}
	if($ok==1){
		$tmp['cible'][$i]=$cible;
		$tmp['cible_hit'][$i]=1;
		$i+=1;
	}
}
$top_cible=0;
for($j=0;$j<$i;$j++)
	if($tmp['cible_hit'][$j]>$tmp['cible_hit'][$top_cible])
		$top_cible=$j;
// Recherche du joueur le plus curieux
//  ----> $tmp['spyer'][x] et du nombre d'espionnage ------> $tmp['spyer_hit'][x]
$i=0;
for($a=0;$a<$max_spy;$a++){
	$cible=$tableau['spyer'][$a];
	$ok=1;
	for($j=0;$j<$i;$j++){
		if($tmp['spyer'][$j]==$cible){
			$tmp['spyer_hit'][$j]+=1;
			$ok=0;
		}
	}
	if($ok==1){
		$tmp['spyer'][$i]=$cible;
		$tmp['spyer_hit'][$i]=1;
		$i+=1;
	}
}
$top_spyer=0;
for($j=0;$j<$i;$j++)
	if($tmp['spyer_hit'][$j]>$tmp['spyer_hit'][$top_spyer])
		$top_spyer=$j;
// Recherche de l'alliance la plus curieuse
//  ----> $tmp['spyerally'][x] et du nombre d'espionnage ------> $tmp['spyerally_hit'][x]
$i=0;
for($a=0;$a<$max_spy;$a++){
	$cible=$tableau['spyerally'][$a];
	$ok=1;
	for($j=0;$j<$i;$j++){
		if($tmp['spyerally'][$j]==$cible){
			$tmp['spyerally_hit'][$j]+=1;
			$ok=0;
		}
	}
	if($ok==1){
		$tmp['spyerally'][$i]=$cible;
		$tmp['spyerally_hit'][$i]=1;
		$i+=1;
	}
}
$top_spyerally=0;
for($j=0;$j<$i;$j++)
	if($tmp['spyerally_hit'][$j]>$tmp['spyerally_hit'][$top_spyerally])
		$top_spyerally=$j;


// Initialisation des variables finales
$most['cible'] = $tmp['cible'][$top_cible]." </b>(".$tmp['cible_hit'][$top_cible].")";
$most['spyer'] = $tmp['spyer'][$top_spyer]." </b>(".$tmp['spyer_hit'][$top_spyer].")";
$most['spyerally'] = $tmp['spyerally'][$top_spyerally]." </b>(".$tmp['spyerally_hit'][$top_spyerally].")";
$most['spyperday'] =($max_spy/60);
$most['nbspys'] =$max_spy;

		
		$text = "<table>";
		$text .="<tr align=center>Les 10 derniers...</tr>";
		$text .= "<tr>";
		$text .= "<td align=\"center\" class=\"c\">Horaires</td>";
		$text .= "<td align=\"center\" class=\"c\">Planete</td>";
		$text .= "<td align=\"center\" class=\"c\">Espion</td>";
		$text .= "<td align=\"center\" class=\"c\">Alliane</td>";
		$test .= "</tr>";
		$cnt=0;
		for($i=0;$i<$max_spy;$i++){
			if(($tableau['cible'][$i]==$tmp['cible'][$top_cible])&&($cnt<10)){
					$cnt++;
					$text .= "<tr>";
					$text .= "<th align=\"center\">".date("(j/m) H:i:s",$tableau['date'][$i])."</th>";
					$text .= "<th align=\"center\">".$tableau['espion'][$i]."</th>";
					$text .= "<th align=\"center\">".$tableau['spyer'][$i]."</th>";
					$text .= "<th align=\"center\">".$tableau['spyerally'][$i]."</th>";
					$test .= "</tr>";
			}
		}
		$text .= "</table>";
		$text = htmlentities($text);
		$text = "this.T_TEMP=0;return escape('".$text."')";


echo"<fieldset><legend><b><font color='#80FFFF'>Général</font></b></legend>";
echo"<table><tr>";
echo"<td class='c' align='center' width='150'>Planète la plus espionnée :</td>";
echo"<td class='c' align='center' width='150'><font color='#FF4455'><b><a style='cursor:pointer' onmouseover=\"".$text."\">".$most['cible']."</a></b></font></td>";
echo"</tr><tr>";
echo"<td class='c' align='center' width='150'>Joueur le plus curieux :</td>";
echo"<td class='c' align='center' width='150'><font color='#FF4455'><b>".$most['spyer']."</b></font></td>";
echo"</tr><tr>";
echo"<td class='c' align='center' width='150'>Alliance la plus curieuse :</td>";
echo"<td class='c' align='center' width='150'><font color='#FF4455'><b>".$most['spyerally']."</b></font></td>";
echo"</tr><tr>";
echo"<td class='c' align='center' width='150'>Nombre d'Espionnage :</td>";
echo"<td class='c' align='center' width='150'><font color='#FF4455'><b>".$most['nbspys']."</b></font></td>";
echo"</tr></table>";
echo"</fieldset>";
?>
