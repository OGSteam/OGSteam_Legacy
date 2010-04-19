<?php
/**
* recyclages.php 
 * @package Attaques
 * @author Verité
 * @link http://www.ogsteam.fr
 * @version : 0.8e
 */
?>

<SCRIPT language="JavaScript">
function setDateFrom(fromdate) {
	document.getElementById("date_from").value=fromdate;
}
function setDateTo(todate) {
	document.getElementById("date_to").value=todate;
}
function clear_box() {
	document.getElementById('rapport').value = "";
}
function valid() {
	document.forms.date.submit();
}
</script>

<?php

// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='attaques' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

//Définitions
global $db;
global $table_prefix;
define("TABLE_ATTAQUES_RECYCLAGES", $table_prefix."attaques_recyclages");
require_once("mod/Attaques/help.php");

//Gestion des dates
$date = date("j");
$mois = date("m");
$annee = date("Y");
$septjours = $date-7;
$yesterday = $date-1;

if($septjours < 1) $septjours = 1;
if($yesterday < 1) $yesterday = 1;

//Fonction d'ajout d'un rapport de recyclage
if (isset($pub_rapport))
{
	$pub_rapport = mysql_real_escape_string($pub_rapport);
	$pub_rapport = str_replace('.','',$pub_rapport);  // suppression des points, MAJ ogame 0.76 http://www.ogsteam.fr/forums/viewtopic.php?pid=27408#p27408
	
	//On regarde si le rapport soumis est valide
	if(stristr($pub_rapport, 'Collecteur ayant une capacitée de') === FALSE)
	{
		echo"<blink><font color='#FF0000'><big>Le rapport que vous avez soumis n'est pas un rapport de recyclage valide !!!</big></font></blink><br><br>";
	}
	else
	{
		
		//On récupère les données pour les coordonnées
		preg_match('#:\s(\d{1,2}:\d{1,3}:\d{1,2})#',$pub_rapport,$recy_coord);

		//On récupère les données pour le titane
		preg_match('#([0-9 ]+)\sde\stitane#',$pub_rapport,$recy_titane);
		$recy_titane = str_replace(" ","",$recy_titane[1]);
		
		//On récupère les données pour le carbone
		preg_match('#([0-9 ]+)\sde\scarbone#',$pub_rapport,$recy_carbone);
		$recy_carbone = str_replace(" ","",$recy_carbone[1]);
		
		//On récupère les données pour la date
		// Correction lié à http://www.ogsteam.fr/viewtopic.php?id=4443 - Fait le 15/08/2008 par Draliam - P.S. Merci Anabys
		/* DEPRECATED preg_match('#[a-zA-z]{3}\s([0-9]{2})\s([a-zA-Z]{3})\s(\d{2}):(\d{2}):(\d{2})#',$pub_rapport,$date_attack); */
		/* DEPRECATED $date_attack[2] = array_search($date_attack[2], $array = array(1 => 'Jan',2 => 'Fev', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec')); */
		preg_match('#(\d{1,2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2}):(\d{2})#',$pub_rapport,$date_attack);


		
		if( ($recy_coord == 0) || ($date_attack == 0) )
		{
			//On met le message de validation
			echo"<blink><font color='#FF0000'><big>Votre rapport de recyclage n'est pas complet !!!</big></font></blink><br><br>";
		}
		else 
			{
			// Correction lié à http://www.ogsteam.fr/viewtopic.php?id=4443 - Fait le 15/08/2008 par Draliam - P.S. Merci Anabys
			/* DEPRECATED $timestamp = mktime($date_attack[3], $date_attack[4], $date_attack[5], $date_attack[2], $date_attack[1], date("Y")); */
			$timestamp = mktime($date_attack[4],$date_attack[5],$date_attack[6],$date_attack[2],$date_attack[1],$date_attack[3]);
		
			//On vérifie que ce recyclage n'a pas déja été enregistrée
			$query = "SELECT recy_id FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_user_id=".$user_data[user_id]." AND recy_date=".$timestamp." AND recy_carbone=".$recy_carbone." AND recy_titane=".$recy_titane." AND recy_coord='$recy_coord[1]' ";
			$result = $db->sql_query($query);
			$nb = mysql_num_rows($result);
			
			
			if ($nb == 0)
			{
				//On insere ces données dans la base de données
				$query = "INSERT INTO ".TABLE_ATTAQUES_RECYCLAGES." ( `recy_id` , `recy_user_id` , `recy_coord` , `recy_date` , `recy_titane` , `recy_carbone` )
					VALUES (
						NULL , '$user_data[user_id]', '$recy_coord[1]', '$timestamp', '$recy_titane', '$recy_carbone'
					)";
				$db->sql_query($query);
				
				//On met le message de validation
				$valid="Enregistrement du recyclage effectué.";
				
				//On ajoute l'action dans le log
				$line = $user_data[user_name]." ajoute un recyclage dans le module de gestion des attaques";
				$fichier = "log_".date("ymd").'.log';
				$line = "/*".date("d/m/Y H:i:s").'*/ '.$line;
				write_file(PATH_LOG_TODAY.$fichier, "a", $line);
			}
			else
			{
			//On met le message de non validation
			$nonvalid="Vous avez déja enregistrée ce recyclage.";
			}
		}	
	}
}
//Fonction de suppression d'un rapport d'attaque
if (isset($pub_recy_id))
{
	$pub_recy_id = intval($pub_recy_id);

	//On récupère l'id de l'utilisateur qui a enregistré cette attaque
	$query = "SELECT recy_user_id FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_id='$pub_recy_id'";
	$result = $db->sql_query($query);
	list($user) = $db->sql_fetch_row($result);
	
	if($user == $user_data[user_id])
	{
		$query = "DELETE FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_id='$pub_recy_id'";
		$db->sql_query($query);
		echo"<blink><font color='FF0000'>Le recyclage a bien été supprimée.</font></blink>";
		
		//On ajoute l'action dans le log
		$line = $user_data[user_name]." supprime l'un de ses recyclage dans le module de gestion des attaques";
		$fichier = "log_".date("ymd").'.log';
		$line = "/*".date("d/m/Y H:i:s").'*/ '.$line;
		write_file(PATH_LOG_TODAY.$fichier, "a", $line);
	}
	else
	{
		echo"<blink><font color='FF0000'>Vous n'avez pas le droit d'effacer ce recyclage !!!</font></blink>";
		
		//On ajoute l'action dans le log
		$line = $user_data[user_name]." a tenté de supprimer un recyclage qui appartient à un autre utilisateurs dans le module de gestion des attaques";
		$fichier = "log_".date("ymd").'.log';
		$line = "/*".date("d/m/Y H:i:s").'*/ '.$line;
		write_file(PATH_LOG_TODAY.$fichier, "a", $line);
	}
}

//Si les dates d'affichage ne sont pas définies, on affiche par défaut les attaques du jours,
if(!isset($pub_date_from)) $pub_date_from = mktime(0, 0, 0, $mois, $date, $annee);
else $pub_date_from = mktime(0, 0, 0, $mois, $pub_date_from, $annee);

if(!isset($pub_date_to)) $pub_date_to = mktime(23, 59, 59, $mois, $date, $annee);
else $pub_date_to = mktime(23, 59, 59, $mois, $pub_date_to, $annee);

$pub_date_from = intval($pub_date_from);
$pub_date_to = intval($pub_date_to);

//Requete pour afficher la liste des recyclages
$query = "SELECT recy_coord, recy_date, recy_titane, recy_carbone, recy_id FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_user_id=".$user_data["user_id"]." AND recy_date BETWEEN ".$pub_date_from." and ".$pub_date_to."  ORDER BY recy_date DESC,recy_id DESC";
$result = $db->sql_query($query);

//On recupère le nombre de recyclages
$nb_recy = mysql_num_rows($result);

//Cacul pour obtenir les gains des recyclages
$query = "SELECT SUM(recy_titane), SUM(recy_carbone) FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_user_id=".$user_data["user_id"]." AND recy_date BETWEEN ".$pub_date_from." and ".$pub_date_to." GROUP BY recy_user_id"; 
$resultgains = $db->sql_query($query);

//On récupère la date au bon format
$pub_date_from = strftime("%d %b %Y", $pub_date_from);
$pub_date_to = strftime("%d %b %Y", $pub_date_to);

//Création du field pour Ajouter un nouveau recyclage
echo"<fieldset><legend><b><font color='#0080FF'>Ajouter un nouveau recyclage ";
echo help("ajouter_recy");
echo"</font></b></legend>
	<table width='60%' align='center'>
	<tr>
	<td align='center'><font color='FFFFFF'><big><big>Pour ajouter un nouveau recyclage, copiez le rapport de recyclage, puis collez le dessous :
	</big></big></font></td>
	</tr>
	<tr>
	<td><p><form action='index.php?action=attaques&page=recyclages' method='post'><input type='hidden' name='date_from' value='$pub_date_from'><input type='hidden' name='date_to' value='$pub_date_to'><textarea rows='6' name='rapport' id='rapport' cols='25' onFocus='clear_box()'>ATTENTION :\n\n Vous devez copier l'intégralités du rapport de recyclage, y compris la date et l'heure du recyclage.</textarea></p></td>
	</tr>
	<tr>
	<td align='center'><p><input type='submit' value='Ajouter'></form></td>
	</tr>";

//Insertion du message de validation si défini
if (isset($valid))
{
	echo"<tr><td align='center'><blink><font color='00FF40'>";
	echo $valid;
	echo"</font></blink>";
	echo"</td></tr>";
}
//Insertion du message de non validation si défini
if (isset($nonvalid))
{
	echo"<tr><td align='center'><blink><font color='FF0000'>".$nonvalid."</td></tr>";
	echo"</font></blink>";
}
echo"</table></fieldset><br><br>";

//Création du field pour choisir l'affichage (attaque du jour, de la semaine ou du mois
echo"<fieldset><legend><b><font color='#0080FF'>Date d'affichage des recyclages ";
echo help("changer_affichage");
echo"</font></b></legend>";

echo"Afficher mes recyclages : ";
echo"<form action='index.php?action=attaques&page=recyclages' method='post' name='date'>";
echo"du : <input type='text' name='date_from' id='date_from' size='2' maxlength='2' value='$pub_date_from' /> ";
echo"au : ";
echo"<input type='text' name='date_to' id='date_to' size='2' maxlength='2' value='$pub_date_to' />";
echo"<br>";
?>		
<a href="#haut" onclick="javascript: setDateFrom('<?php echo $date; ?>'); setDateTo('<?php echo $date; ?>'); valid();">du jour</a> |
<a href="#haut" onclick="javascript: setDateFrom('<?php echo $yesterday; ?>'); setDateTo('<?php echo $yesterday; ?>'); valid();">de la veille</a> | 
<a href="#haut" onclick="javascript: setDateFrom('<?php echo $septjours ; ?>'); setDateTo('<?php echo $date; ?>'); valid();">des 7 derniers jours</a> |
<a href="#haut" onclick="javascript: setDateFrom('01'); setDateTo('<?php echo $date; ?>'); valid();">du mois</a>
<?php
echo"<br><br>";
echo"<input type='submit' value='Afficher' name='B1'></form>";
echo"</fieldset>";
echo"<br><br>";

//Création du field pour voir les gains des attaques
echo"<fieldset><legend><b><font color='#0080FF'>Résultats des recyclages du ".$pub_date_from." au ".$pub_date_to." ";
echo help("resultats");
echo"</font></b></legend>";

//Résultat requete
list($recy_titane, $recy_carbone) = $db->sql_fetch_row($resultgains);	

//Calcul des gains totaux
$totalgains=$recy_titane+$recy_carbone;

echo"<table width='100%'><tr align='left' valign='center'>";

// Afficher l'image du graphique
echo"<td width='410px' align='center'>";
?>
<img src="index.php?action=graphic_pie&values=<?php echo $recy_titane ?>_x_<?php echo $recy_carbone ?>&legend=titane_x_Carbone&title=Proportion%20des%20gains%20des%20recyclages%20affich%E9es" alt="Pas de graphique disponible">
<?php
echo"</td>";

//Affichage des gains en titane, en carbone et en deut
$recy_titane = number_format($recy_titane, 0, ',', ' ');
$recy_carbone = number_format($recy_carbone, 0, ',', ' ');
echo "<td><p align='left'><font color='#FFFFFF'><big><big><big>Titane recyclé : ".$recy_titane."<br>Carbone recyclé : ".$recy_carbone."<br><br>";

//Affichage du total des gains
$totalgains = number_format($totalgains, 0, ',', ' ');
echo "<b>Soit un total de : ".$totalgains."</b><br><br>";

echo"</big></big>";
echo"</big></big></font></td></tr></table>";
echo"</p></fieldset><br><br>";

//Création du field pour voir la liste des attaques
echo"<fieldset><legend><b><font color='#0080FF'>Liste des recyclages du ".$pub_date_from." au ".$pub_date_to." ";
echo" : ".$nb_recy." recyclage(s) ";
echo help("liste_recy");
echo"</font></b></legend>";

//Tableau donnant la liste des attaques
echo"<table width='100%'>";
echo"<tr>";
echo"<td class=".c." align=".center."><b>Coordonnées</b></td>";
echo"<td class=".c." align=".center."><b>Date du recyclage</b></td>";
echo"<td class=".c." align=".center."><b>titane Recyclé</b></td>";
echo"<td class=".c." align=".center."><b>Carbone Recyclé</b></td>";
echo"<td class=".c." align=".center."><b><font color='#FF0000'>Supprimer</font></b></td>";

echo"</tr>";
echo"<tr>";

while( list($recy_coord, $recy_date, $recy_titane, $recy_carbone, $recy_id) = $db->sql_fetch_row($result) )
{
	$recy_date = strftime("%d %b %Y à %Hh%M", $recy_date);
	$recy_titane = number_format($recy_titane, 0, ',', ' ');
	$recy_carbone = number_format($recy_carbone, 0, ',', ' ');
	echo"<th align='center'>".$recy_coord."</th>";
	echo"<th align='center'>".$recy_date."</th>";
	echo"<th align='center'>".$recy_titane."</th>";
	echo"<th align='center'>".$recy_carbone."</th>";
	echo"<th align='center' valign='middle'><form action='index.php?action=attaques&page=recyclages' method='post'><input type='hidden' name='date_from' value='$pub_date_from'><input type='hidden' name='date_to' value='$pub_date_to'><input type='hidden' name='recy_id' value='$recy_id'><input type='submit'	value='Supprimer' name='B1' style='color: #FF0000'></form></th>";
	echo"</tr>";
	echo"<tr>";
}
echo"</tr>";
echo"</table>";

echo"</fieldset>";

echo"<br>";
echo"<br>";
echo"<hr width='325px'>";
echo"<p align='center'>Mod de Gestion des Attaques | Version 0.8e | <a href='mailto:verite@ogsteam.fr'>Vérité</a> |© 2006</p>";

//Insertion du bas de page d'OGSpy
require_once("views/page_tail.php");
?>
