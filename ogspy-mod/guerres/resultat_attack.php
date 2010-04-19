<?php
/**
 * resultat_attack.php 
 * @package Guerres
 * @author Verité
 * @link http://www.ogsteam.fr
 * @version 0.2e
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='guerres' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

//Définitions
global $db;
global $table_prefix;
define("TABLE_GUERRES_LISTE", $table_prefix."guerres_listes");
define("TABLE_GUERRES_ATTAQUES", $table_prefix."guerres_attaques");
define("TABLE_GUERRES_RECYCLAGES", $table_prefix."guerres_recyclages");

//Requete pour afficher la liste des guerres
$query = "SELECT guerre_id, guerre_ally_1, guerre_ally_2 FROM ".TABLE_GUERRES_LISTE." ORDER BY guerre_id ASC";
$result = $db->sql_query($query);

//Création du field pour selectionner la guerre
echo"<fieldset><legend><b><font color='#0080FF'> Selectionnez une guerre </font></b></legend>";
echo"Selectionnez la guerre dont vous souhaitez visualiser les résultats :";
echo"<br>";
echo"<br>";
echo"<form action='index.php' method='post'><input type='hidden' name='action' value='guerres'><input type='hidden' name='page' value='Resultats des guerres'>";
echo"<select name='guerre'>";
echo"<br>";
echo"<br>";
echo"<option selected>Selectionnez une guerre</option><br>";

while (list($guerre_id, $guerre_ally_1, $guerre_ally_2) = $db->sql_fetch_row($result))
{
	//on recupère le nombre de guerre en cours
	$nb_guerres = mysql_num_rows($result);

	//Si ce  nombre est égal à 1 on selectionne cette guerre automatiquement
	if ($nb_guerres == 1)$pub_guerre = $guerre_id;

	echo"<option value='$guerre_id'>".$guerre_ally_1." vs ".$guerre_ally_2."</option>";
}
echo"</select>";
echo"<input type='submit' value='Voir les resulats'>";
echo"</form>";
echo"</fieldset><br><br>";

if (isset($pub_guerre))
{
	$pub_guerre = intval($pub_guerre);
	
	//Requete pour afficher les infos sur le guerre selectionnée
	$query = "SELECT guerre_ally_1, guerre_ally_2, guerre_date_debut FROM ".TABLE_GUERRES_LISTE." WHERE guerre_id=".$pub_guerre."";
	$result = $db->sql_query($query);
	
	list($guerre_ally_1, $guerre_ally_2, $guerre_date_debut) = $db->sql_fetch_row($result);
	
	//Requete pour afficher les resultats des attaques
	$query = "SELECT SUM(attack_metal)as metal, SUM(attack_cristal)as cristal, SUM(attack_deut) as deut, SUM(attack_pertes_A) as pertes_a, SUM(attack_pertes_D)as pertes_d FROM ".TABLE_GUERRES_ATTAQUES."  WHERE guerres_id='$pub_guerre'";
	$result = $db->sql_query($query);
	
	//Requete pour afficher les resultats des recyclages
	$query = "SELECT SUM(recy_metal) as re_metal, SUM(recy_cristal)as re_cristal FROM ".TABLE_GUERRES_RECYCLAGES." WHERE guerre_id=".$pub_guerre."";
	$result2 = $db->sql_query($query);
	
	$guerre_date_debut = strftime("%d %b %Y", $guerre_date_debut);

	//Création du field pour selectionner la guerre
	echo"<fieldset><legend><b><font color='#0080FF'> Résultats de la guerre : ".$guerre_ally_1." vs ".$guerre_ally_2." </font></b></legend>";
	echo"<p align='left'>";
	echo"<u><big>Informations générales :</big></u>";
	echo"<br><br>";
	echo"Guerre : <font color='#00FF40'>".$guerre_ally_1."</font> vs <font color='#FF0000'>".$guerre_ally_2."</font>";
	echo"<br>";
	echo"En guerre depuis le : ".$guerre_date_debut."";
	
	list($metal, $cristal, $deut, $pertes_a, $pertes_d) = $db->sql_fetch_row($result);
	list($re_metal, $re_cristal) = $db->sql_fetch_row($result2);
		
		echo"<br><br>";
		echo"<u><big>Résulats pour les : <font color='#00FF40'>".$guerre_ally_1."</font></big></u>";
		
		$totalgains=$metal+$cristal+$deut;
		$total_recy=$re_metal+$re_cristal;
		$renta=$totalgains+$total_recy-$pertes_a;
		
		echo"<br><br>";
		$metal = number_format($metal, 0, ',', ' ');
		echo"Métal gagné : ".$metal."<br>";
		$cristal = number_format($cristal, 0, ',', ' ');
		echo"Cristal gagné : ".$cristal."<br>";
		$deut = number_format($deut, 0, ',', ' ');
		echo"Deuterium gagné : ".$deut."<br>";
		$totalgains = number_format($totalgains, 0, ',', ' ');
		echo"<b>Soit un total de : ".$totalgains."</b><br><br>";
		$pertes_a = number_format($pertes_a, 0, ',', ' ');
		echo"<b>Les pertes s'élèvent à : ".$pertes_a."</b><br><br>";
		$re_metal = number_format($re_metal, 0, ',', ' ');
		echo"Métal recyclé : ".$re_metal."<br>";
		$re_cristal = number_format($re_cristal, 0, ',', ' ');
		echo"Cristal recyclé : ".$re_cristal."<br>";
		$total_recy = number_format($total_recy, 0, ',', ' ');
		echo"<b>Soit un total de : ".$total_recy."</b><br><br>";
		$renta = number_format($renta, 0, ',', ' ');
		$pertes_d = number_format($pertes_d, 0, ',', ' ');
		echo"<b><big>La rentabilité est donc de : ".$renta."</big></b><br><br>";
		echo"<b><big>Les pertes infligées à l'ennemi sont de : ".$pertes_d."</big></b><br><br></p>";
		echo"<i>Ces pertes sont basées sur les rapports de combats et de recyclages enregistrés. Elles ne tiennnet pas compte d'eventuels missilages.</i>";
	echo"</fieldset><br><br>";
}

echo"<hr width='325px'>";
echo"<p align='center'>Mod Guerres | Version 0.2e | <a href='mailto:verite@ogsteam.fr'>Vérité</a> |© 2006</p>";

//Insertion du bas de page d'OGSpy
require_once("views/page_tail.php");
?>