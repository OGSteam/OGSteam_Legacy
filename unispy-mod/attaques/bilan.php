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
define("TABLE_ATTAQUES_ATTAQUES", $table_prefix."attaques_attaques");
require_once("mod/Attaques/help.php");

//Gestion des dates
$date = date("j");
$mois = date("m");
$annee = date("Y");
$septjours = $date-7;
$yesterday = $date-1;

if($septjours < 1) $septjours = 1;
if($yesterday < 1) $yesterday = 1;


//Si les dates d'affichage ne sont pas définies, on affiche par défaut les attaques du jours,
if(!isset($pub_date_from)) $pub_date_from = mktime(0, 0, 0, $mois, $date, $annee);
else $pub_date_from = mktime(0, 0, 0, $mois, $pub_date_from, $annee);

if(!isset($pub_date_to)) $pub_date_to = mktime(23, 59, 59, $mois, $date, $annee);
else $pub_date_to = mktime(23, 59, 59, $mois, $pub_date_to, $annee);

$pub_date_from = intval($pub_date_from);
$pub_date_to = intval($pub_date_to);



//Requete pour afficher la liste des attaques 
$query = "SELECT attack_coord, attack_date, attack_titane, attack_carbone, attack_tritium, attack_pertes, attack_id FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id=".$user_data["user_id"]." AND attack_date BETWEEN ".$pub_date_from." and ".$pub_date_to."  ORDER BY attack_date DESC,attack_id DESC";
$result = $db->sql_query($query);

//On recupère le nombre d'attaques
$nb_attack = mysql_num_rows($result);

//Cacul pour obtenir les gains
$query = "SELECT SUM(attack_titane), SUM(attack_carbone), SUM(attack_tritium), SUM(attack_pertes) FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id=".$user_data["user_id"]." AND attack_date BETWEEN ".$pub_date_from." and ".$pub_date_to." GROUP BY attack_user_id"; 
$resultgains = $db->sql_query($query);

//Cacul pour obtenir les gains des recyclages
$query = "SELECT SUM(recy_titane), SUM(recy_carbone) FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_user_id=".$user_data["user_id"]." AND recy_date BETWEEN ".$pub_date_from." and ".$pub_date_to." GROUP BY recy_user_id"; 
$resultgainsrecy = $db->sql_query($query);


//On récupère la date au bon format
$pub_date_from = strftime("%d %b %Y", $pub_date_from);
$pub_date_to = strftime("%d %b %Y", $pub_date_to);


//Création du field pour choisir l'affichage (attaque du jour, de la semaine ou du mois
echo"<fieldset><legend><b><font color='#0080FF'>Date d'affichage du bilan ";
echo help("changer_affichage");
echo"</font></b></legend>";

echo"Afficher le bilan : ";
echo"<form action='index.php?action=attaques&page=bilan' method='post' name='date'>";
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
echo"<fieldset><legend><b><font color='#0080FF'>Bilan du ".$pub_date_from." au ".$pub_date_to." </font></b></legend>";
echo"<table width='100%'><tr align='left'>";
		
//Résultat requete
list($attack_titane, $attack_carbone, $attack_tritium, $attack_pertes) = $db->sql_fetch_row($resultgains);	

//Résultat requete
list($recy_titane, $recy_carbone) = $db->sql_fetch_row($resultgainsrecy);	

//Calcul des gains totaux
$totalgains=$attack_titane+$attack_carbone+$attack_tritium;


echo"<table width='100%'><tr align='left'>";

// Afficher l'image du graphique
echo"<td width='410px' align='center'>";
?>
<img src="index.php?action=graphic_pie&values=<?php echo $attack_titane ?>_x_<?php echo $attack_carbone ?>_x_<?php echo $attack_tritium ?>_x_<?php echo $recy_titane ?>_x_<?php echo $recy_carbone ?>&legend=titane_x_carbone_x_tritiumerium_x_titane Recyclé_x_carbone Recyclé&title=Proportion%20des%20gains" alt="Pas de graphique disponible">
<?php
echo"</td>";

//Affichage des gains en titane, en carbone et en tritium
$attack_titane = number_format($attack_titane, 0, ',', ' ');
$attack_carbone = number_format($attack_carbone, 0, ',', ' ');
$attack_tritium = number_format($attack_tritium, 0, ',', ' ');
echo "<td><p align='left'><font color='#FFFFFF'><big><big><big>Titane gagné : ".$attack_titane."<br>Carbone gagné : ".$attack_carbone."<br>Tritium gagné : ".$attack_tritium."<br>";




//Calcul des gains totaux
$totalgainsrecy=$recy_titane+$recy_carbone;

//Calcul de la rentabilité
$renta = $totalgainsrecy+$totalgains-$attack_pertes;

//Affichage du total des gains
$totalgains = number_format($totalgains, 0, ',', ' ');
echo "<b>Soit un total de : ".$totalgains."</b><br><br>";

//Affichage du total des pertes
$attack_pertes = number_format($attack_pertes, 0, ',', ' ');
echo"<b>Total des pertes attaquant : ".$attack_pertes."</b>";

//Affichage de la rentabilité des attaques
$renta = number_format($renta, 0, ',', ' ');

//Affichage des gains en titane, en carbone et en tritium
$recy_titane = number_format($recy_titane, 0, ',', ' ');
$recy_carbone = number_format($recy_carbone, 0, ',', ' ');
echo "<p align='left'><font color='#FFFFFF'>Titane recyclé : ".$recy_titane."<br>Carbone recyclé : ".$recy_carbone."<br>";

//Affichage du total des gains
$totalgainsrecy = number_format($totalgainsrecy, 0, ',', ' ');
echo "<b>Soit un total de : ".$totalgainsrecy."</b><br><br>";


echo"<b>Rentabilité : ".$renta."</b>";
echo"</big></big>";
echo"</big></big></font></td></tr></table>";
echo"</p></fieldset><br><br>";


echo"<table width='100%'><tr align='left' valign='center'>";

echo"<br>";
echo"<br>";
echo"<hr width='325px'>";
echo"<p align='center'>Mod de Gestion des Attaques | Version 0.8e | <a href='mailto:verite@ogsteam.fr'>Vérité</a> |© 2006</p>";

//Insertion du bas de page d'OGSpy
require_once("views/page_tail.php");
?>