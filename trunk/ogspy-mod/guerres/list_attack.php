<?php
/**
 * list_attack.php 
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

if (isset($pub_attack_id) && ($user_data[user_admin] == 1) || ($user_data[user_coadmin] == 1))
{
	$pub_attack_id = intval($pub_attack_id);
	
	$query = "DELETE FROM ".TABLE_GUERRES_ATTAQUES." WHERE attack_id='$pub_attack_id'";
	$db->sql_query($query);
	echo"<blink><font color='FF0000'>L'attaque a bien été supprimée.</font></blink>";
	
	//On ajoute l'action dans le log
	$line = "[ADMIN] ".$user_data[user_name]." supprime une attaque dans le module guerres";
	$fichier = "log_".date("ymd").'.log';
	$line = "/*".date("d/m/Y H:i:s").'*/ '.$line;
	write_file(PATH_LOG_TODAY.$fichier, "a", $line);
}

if (isset($pub_recy_id) && ($user_data[user_admin] == 1) || ($user_data[user_coadmin] == 1))
{
	$pub_attack_id = intval($pub_recy_id);
	
	$query = "DELETE FROM ".TABLE_GUERRES_RECYCLAGES." WHERE recy_id='$pub_recy_id'";
	$db->sql_query($query);
	echo"<blink><font color='FF0000'>Le recyclage a bien été supprimé.</font></blink>";
	
	//On ajoute l'action dans le log
	$line = "[ADMIN] ".$user_data[user_name]." supprime un recyclage dans le module guerres";
	$fichier = "log_".date("ymd").'.log';
	$line = "/*".date("d/m/Y H:i:s").'*/ '.$line;
	write_file(PATH_LOG_TODAY.$fichier, "a", $line);
}

//Requete pour afficher la liste des guerres
$query = "SELECT guerre_id, guerre_ally_1, guerre_ally_2 FROM ".TABLE_GUERRES_LISTE." ORDER BY guerre_id ASC";
$result = $db->sql_query($query);

//Création du field pour selectionner la guerre
echo"<fieldset><legend><b><font color='#0080FF'> Selectionnez une guerre </font></b></legend>";
echo"Selectionnez la guerre pour laquelle vous souhaitez voir la liste des attaques et des recyclages :";
echo"<br>";
echo"<br>";
echo"<form action='index.php' method='post'><input type='hidden' name='action' value='guerres'><input type='hidden' name='page' value='Liste des attaques'>";
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
echo"<input type='submit' value='Selectionnez'>";
echo"</form>";
echo"</fieldset><br><br>";

if (isset($pub_guerre))
{
	$pub_guerre = intval($pub_guerre);
	
	//Requete pour afficher les resultats des attaques
	$query = "SELECT attack_id, attack_date, attack_name_A, attack_name_D, attack_coord, attack_metal, attack_cristal, attack_deut, attack_pertes_A, attack_pertes_D FROM ".TABLE_GUERRES_ATTAQUES."  WHERE guerres_id='$pub_guerre' ORDER BY attack_date";
	$result = $db->sql_query($query);
	
	//On recupère le nombre d'attaques
	$nb_attack = mysql_num_rows($result);
	
	//Requete pour afficher les resultats des recyclages
	$query = "SELECT recy_id, recy_date, recy_coord, recy_metal, recy_cristal FROM ".TABLE_GUERRES_RECYCLAGES." WHERE guerre_id=".$pub_guerre." ORDER BY recy_date";
	$result2 = $db->sql_query($query);
	
	//On recupère le nombre de recyclages
	$nb_recy = mysql_num_rows($result2);
	
	//Création du field pour voir la liste des attaques
	echo"<fieldset><legend><b><font color='#0080FF'>Liste des attaques de la guerre selectionnée ";
	echo" : ".$nb_attack." attaque(s) ";
	echo"</font></b></legend>";
	
	//Tableau donnant la liste des attaques
	echo"<table width='100% id='table1'>";
	echo"<tr>";
	echo"<td class=".c." align=".center."><b>Coord</b></td>";
	echo"<td class=".c." align=".center."><b>Date</b></td>";
	echo"<td class=".c." align=".center."><b>Nom Attaquant</b></td>";
	echo"<td class=".c." align=".center."><b>Nom Defenseur</b></td>";
	echo"<td class=".c." align=".center."><b>Métal Gagné</b></td>";
	echo"<td class=".c." align=".center."><b>Cristal Gagné</b></td>";
	echo"<td class=".c." align=".center."><b>Deuterium Gagné</b></td>";
	echo"<td class=".c." align=".center."><b>Pertes Attaquant</b></td>";
	echo"<td class=".c." align=".center."><b>Pertes Defenseur</b></td>";
	
	if ( ($user_data[user_admin] == 1) || ($user_data[user_coadmin] == 1) )
	{
		echo"<td class=".c." align=".center."><b><font color='#FF0000'>Supprimer</font></b></td>";
	}
	echo"</tr>";
	
	while(list($attack_id, $attack_date, $attack_name_A, $attack_name_D, $attack_coord, $attack_metal, $attack_cristal, $attack_deut, $attack_pertes_A, $attack_pertes_D) = $db->sql_fetch_row($result))
	{
		$attack_metal = number_format($attack_metal, 0, ',', ' ');
		$attack_cristal = number_format($attack_cristal, 0, ',', ' ');
		$attack_deut = number_format($attack_deut, 0, ',', ' ');
		$attack_pertes_A = number_format($attack_pertes_A, 0, ',', ' ');
		$attack_pertes_D = number_format($attack_pertes_D, 0, ',', ' ');
		echo"<th width='10%' align='center'>".$attack_coord."</th>";
		$attack_date = strftime("%d %b %Y %Hh%M", $attack_date);
		echo"<th width='10%' align='center'>".$attack_date."</th>";
		echo"<th width='10%' align='center'>".$attack_name_A."</th>";
		echo"<th width='10%' align='center'>".$attack_name_D."</th>";
		echo"<th width='10%' align='center'>".$attack_metal."</th>";
		echo"<th width='10%' align='center'>".$attack_cristal."</th>";
		echo"<th width='10%' align='center'>".$attack_deut."</th>";
		echo"<th width='10%' align='center'>".$attack_pertes_A."</th>";
		echo"<th width='10%' align='center'>".$attack_pertes_D."</th>";
		
		if ( ($user_data[user_admin] == 1) || ($user_data[user_coadmin] == 1) )
		{
			echo"<th width='5%' align='center' valign='middle'><form action='index.php' method='post'><input type='hidden' name='action' value='guerres'><input type='hidden' name='guerre' value='$pub_guerre'><input type='hidden' name='page' value='Liste des attaques'><input type='hidden' name='attack_id' value='$attack_id'><input type='submit'	value='Supprimer' name='B1' style='color: #FF0000'></form></th>";
		}
		
		echo"</tr>
		<tr>";
	}
echo"</tr>";
echo"</table>";

echo"</fieldset>";
echo"<br><br>";


//Création du field pour voir la liste des recyclages
	echo"<fieldset><legend><b><font color='#0080FF'>Liste des recyclages de la guerre selectionnée ";
	echo" : ".$nb_recy." recyclage(s) ";
	echo"</font></b></legend>";
	
	//Tableau donnant la liste des attaques
	echo"<table width='100% id='table1'>";
	echo"<tr>";
	echo"<td class=".c." align=".center."><b>Coord</b></td>";
	echo"<td class=".c." align=".center."><b>Date</b></td>";
	echo"<td class=".c." align=".center."><b>Métal Recyclé</b></td>";
	echo"<td class=".c." align=".center."><b>Cristal Recyclé</b></td>";
	
	if ( ($user_data[user_admin] == 1) || ($user_data[user_coadmin] == 1) )
	{
		echo"<td class=".c." align=".center."><b><font color='#FF0000'>Supprimer</font></b></td>";
	}
	echo"</tr>";
	
	while(list($recy_id, $recy_date, $recy_coord, $recy_metal, $recy_cristal) = $db->sql_fetch_row($result2))
	{
		$recy_metal = number_format($recy_metal, 0, ',', ' ');
		$recy_cristal = number_format($recy_cristal, 0, ',', ' ');
		echo"<th width='10%' align='center'>".$recy_coord."</th>";
		$recy_date = strftime("%d %b %Y %Hh%M", $recy_date);
		echo"<th width='10%' align='center'>".$recy_date."</th>";
		echo"<th width='10%' align='center'>".$recy_metal."</th>";
		echo"<th width='10%' align='center'>".$recy_cristal."</th>";

		
		if ( ($user_data[user_admin] == 1) || ($user_data[user_coadmin] == 1) )
		{
			echo"<th width='5%' align='center' valign='middle'><form action='index.php' method='post'><input type='hidden' name='action' value='guerres'><input type='hidden' name='guerre' value='$pub_guerre'><input type='hidden' name='page' value='Liste des attaques'><input type='hidden' name='recy_id' value='$recy_id'><input type='submit'	value='Supprimer' name='B1' style='color: #FF0000'></form></th>";
		}
		
		echo"</tr>
		<tr>";
	}
echo"</tr>";
echo"</table>";

echo"</fieldset>";
echo"<br><br>";
}

echo"<hr width='325px'>";
echo"<p align='center'>Mod Guerres | Version ".$mod_version." | <a href='mailto:verite@ogsteam.fr'>Vérité</a> |© 2006</p>";

//Insertion du bas de page d'OGSpy
require_once("views/page_tail.php");
?>