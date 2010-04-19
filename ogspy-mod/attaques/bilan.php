<?php
/**
* bilan.php 
 * @package Attaques
 * @author Verité
 * @link http://www.ogsteam.fr
 * @version : 0.8a
 */

// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='attaques' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

// Appel des Javascripts
echo"<script type='text/javascript' language='javascript' src='".FOLDER_ATTCK."/attack.js'></script>";

//Définitions
global $db, $table_prefix;

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
$query = "SELECT attack_coord, attack_date, attack_metal, attack_cristal, attack_deut, attack_pertes, attack_id FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id=".$user_data["user_id"]." AND attack_date BETWEEN ".$pub_date_from." and ".$pub_date_to."  ORDER BY attack_date DESC,attack_id DESC";
$result = $db->sql_query($query);

//On recupère le nombre d'attaques
$nb_attack = mysql_num_rows($result);

//Cacul pour obtenir les gains
$query = "SELECT SUM(attack_metal), SUM(attack_cristal), SUM(attack_deut), SUM(attack_pertes) FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id=".$user_data["user_id"]." AND attack_date BETWEEN ".$pub_date_from." and ".$pub_date_to." GROUP BY attack_user_id"; 
$resultgains = $db->sql_query($query);

//Cacul pour obtenir les gains des recyclages
$query = "SELECT SUM(recy_metal), SUM(recy_cristal) FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_user_id=".$user_data["user_id"]." AND recy_date BETWEEN ".$pub_date_from." and ".$pub_date_to." GROUP BY recy_user_id"; 
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
list($attack_metal, $attack_cristal, $attack_deut, $attack_pertes) = $db->sql_fetch_row($resultgains);	

//Résultat requete
list($recy_metal, $recy_cristal) = $db->sql_fetch_row($resultgainsrecy);	

//Calcul des gains totaux
$totalgains=$attack_metal+$attack_cristal+$attack_deut;

echo"<table width='100%'><tr align='left'>";

// Afficher l'image du graphique
echo"<td width='410px' align='center'>";
if ((!isset($attack_metal)) && (!isset($attack_cristal)) && (!isset($attack_deut)) && (!isset($attack_pertes)))
   {
   echo "Pas de graphique disponible";
   }else{
   echo "<img src='index.php?action=graphic_pie&values=".$attack_metal."_x_".$attack_cristal."_x_".$attack_deut."_x_".$recy_metal."_x_".$recy_cristal."&legend=Metal_x_Cristal_x_Deutérium_x_Metal Recyclé_x_Cristal Recyclé&title=Proportion%20des%20gains' alt='Pas de graphique disponible'>";
 }

echo"</td>";

//Affichage des gains en métal, en cristal et en deut
$attack_metal = number_format($attack_metal, 0, ',', ' ');
$attack_cristal = number_format($attack_cristal, 0, ',', ' ');
$attack_deut = number_format($attack_deut, 0, ',', ' ');
echo "<td><p align='left'><font color='#FFFFFF'><big><big><big>M&eacute;tal gagn&eacute; : ".$attack_metal."<br>Cristal gagn&eacute; : ".$attack_cristal."<br>Deut&eacute;rium gagn&eacute; : ".$attack_deut."<br>";

//Calcul des gains totaux
$totalgainsrecy=$recy_metal+$recy_cristal;

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

//Affichage des gains en métal, en cristal et en deut
$recy_metal = number_format($recy_metal, 0, ',', ' ');
$recy_cristal = number_format($recy_cristal, 0, ',', ' ');
echo "<p align='left'><font color='#FFFFFF'>Métal recyclé : ".$recy_metal."<br>Cristal recyclé : ".$recy_cristal."<br>";

//Affichage du total des gains
$totalgainsrecy = number_format($totalgainsrecy, 0, ',', ' ');
echo "<b>Soit un total de : ".$totalgainsrecy."</b><br><br>";


echo"<b>Rentabilité : ".$renta."</b>";
echo"</big></big>";
echo"</big></big></font></td></tr></table>";
echo"</p></fieldset>";

if ($config['histo']==1)
{
echo"<fieldset><legend><b><font color='#0080FF'>Historique mensuel</font></b></legend>";
echo "<img src='index.php?action=attaques&subaction=bilan' alt='pas de graphique disponible' />";
echo"</fieldset>";
}
echo"<br />";
echo"<br />";
?>