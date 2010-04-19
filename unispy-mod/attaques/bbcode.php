<?php
/**
* bbcode.php 
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

function selectionner() {
	document.getElementById('bbcode').select();
}

function selectionner2() {
	document.getElementById('bbcode2').select();
}

function selectionner3() {
	document.getElementById('bbcode3').select();
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
define("TABLE_ATTAQUES_ATTAQUES", $table_prefix."attaques_attaques");
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

//Si les dates d'affichage ne sont pas définies, on affiche par défaut les attaques du jours,
if(!isset($pub_date_from)) $pub_date_from = mktime(0, 0, 0, $mois, $date, $annee);
else $pub_date_from = mktime(0, 0, 0, $mois, $pub_date_from, $annee);

if(!isset($pub_date_to)) $pub_date_to = mktime(23, 59, 59, $mois, $date, $annee);
else $pub_date_to = mktime(23, 59, 59, $mois, $pub_date_to, $annee);

$pub_date_from = intval($pub_date_from);
$pub_date_to = intval($pub_date_to);

//Requete pour afficher la liste des attaques 
$query = "SELECT attack_coord, attack_date, attack_titane, attack_carbone, attack_tritium, attack_pertes, attack_id FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id=".$user_data["user_id"]." AND attack_date BETWEEN ".$pub_date_from." and ".$pub_date_to."  ORDER BY attack_date DESC,attack_id DESC";
$attaques = $db->sql_query($query);

//Requete pour afficher la liste des recyclages
$query = "SELECT recy_coord, recy_date, recy_titane, recy_carbone, recy_id FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_user_id=".$user_data["user_id"]." AND recy_date BETWEEN ".$pub_date_from." and ".$pub_date_to."  ORDER BY recy_date DESC,recy_id DESC";
$recyclages = $db->sql_query($query);

//Requete pour obtenir les gains des attaques
$query = "SELECT SUM(attack_titane), SUM(attack_carbone), SUM(attack_tritium), SUM(attack_pertes) FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id=".$user_data["user_id"]." AND attack_date BETWEEN ".$pub_date_from." and ".$pub_date_to." GROUP BY attack_user_id"; 
$resultgains = $db->sql_query($query);

//Requete pour obtenir les gains des recyclages
$query = "SELECT SUM(recy_titane), SUM(recy_carbone) FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_user_id=".$user_data["user_id"]." AND recy_date BETWEEN ".$pub_date_from." and ".$pub_date_to." GROUP BY recy_user_id";
$resultgains_recy = $db->sql_query($query);

//On recupère le nombre d'attaques
$nb_attack = mysql_num_rows($attaques);

//On recupère le nombre de recyclages
$nb_recy = mysql_num_rows($recyclages);

//On récupère la date au bon format
$pub_date_from = strftime("%d %b %Y", $pub_date_from);
$pub_date_to = strftime("%d %b %Y", $pub_date_to);

//Création du field pour choisir l'affichage (attaque du jour, de la semaine ou du mois
echo"<fieldset><legend><b><font color='#0080FF'>Date d'affichage des attaques et des recyclages en BBCode ";
echo help("changer_affichage");
echo"</font></b></legend>";

echo"Afficher mes attaques et mes recyclages en BBCode : ";
echo"<form action='index.php?action=attaques&page=bbcode' method='post' name='date'>";
echo"du : <input type='text' name='date_from' id='date_from' size='2' maxlength='2' value='$pub_date_from' /> ";
echo"au : ";
echo"<input type='text' name='date_to' id='date_to' size='2' maxlength='2' value='$pub_date_to' />";
echo"<br>";
?>		
<a href="#haut" onclick="javascript: setDateFrom('<?php echo $date; ?>'); setDateTo('<?php echo $date; ?>');  valid();">du jour</a> |
<a href="#haut" onclick="javascript: setDateFrom('<?php echo $yesterday; ?>'); setDateTo('<?php echo $yesterday; ?>'); valid();">de la veille</a> | 
<a href="#haut" onclick="javascript: setDateFrom('<?php echo $septjours ; ?>'); setDateTo('<?php echo $date; ?>'); valid();">des 7 derniers jours</a> |
<a href="#haut" onclick="javascript: setDateFrom('01'); setDateTo('<?php echo $date; ?>'); valid();">du mois</a>
<?php
echo"<br><br>";
echo"<input type='submit' value='Afficher' name='B1'></form>";
echo"</fieldset>";
echo"<br><br>";

$bbcode = "[color=orange][b]Liste des attaques de ".$user_data[user_name]."[/b] [/color]\n";
$bbcode .="du ".$pub_date_from." au ".$pub_date_to."\n\n";

//Résultat requete
while (list($attack_coord, $attack_date, $attack_titane, $attack_carbone, $attack_tritium, $attack_pertes) = $db->sql_fetch_row($attaques))
{	
	$attack_date = strftime("%d %b %Y à %Hh%M", $attack_date);
	$attack_titane = number_format($attack_titane, 0, ',', ' ');
	$attack_carbone = number_format($attack_carbone, 0, ',', ' ');
	$attack_tritium = number_format($attack_tritium, 0, ',', ' ');
	$attack_pertes = number_format($attack_pertes, 0, ',', ' ');
	$bbcode .="Le ".$attack_date." victoire en ".$attack_coord.".\n";
	$bbcode .="[color=#00FF40]".$attack_titane."[/color] de métal, [color=#00FF40]".$attack_carbone."[/color] de carbone et [color=#00FF40]".$attack_tritium."[/color] de tritiumerium ont été rapportés.\n";
	$bbcode .="Les pertes s'élèvent à [color=red]".$attack_pertes."[/color].\n\n";
}
$bbcode .="[url=http://www.ogsteam.fr/forums/sujet-1358-mod-gestion-attaques]Généré par le module de gestion des attaques[/url]";


//Création du field pour voir la liste des attaques en BBCode
echo"<fieldset><legend><b><font color='#0080FF'>Liste des attaques en BBCode du ".$pub_date_from." au ".$pub_date_to." ";
echo help("bbcode");
echo"</font></b></legend>";
echo"<p align='left'><a href='#haut' onclick='selectionner()'>Selectionner</a></p>";
echo"<form method='post'><textarea rows='7' cols='15' id='bbcode'>$bbcode</textarea></form></fieldset>";
echo"<br>";
echo"<br>";
echo"</fieldset>";

$bbcode = "[color=orange][b]Liste des recyclages de ".$user_data[user_name]."[/b] [/color]\n";
$bbcode .="du ".$pub_date_from." au ".$pub_date_to."\n\n";

//Résultat requete
while (list($recy_coord, $recy_date, $recy_titane, $recy_carbone,) = $db->sql_fetch_row($recyclages))
{	
	$recy_date = strftime("%d %b %Y à %Hh%M", $recy_date);
	$recy_titane = number_format($recy_titane, 0, ',', ' ');
	$recy_carbone = number_format($recy_carbone, 0, ',', ' ');
	$bbcode .="Le ".$recy_date." recyclage en ".$recy_coord.".\n";
	$bbcode .="[color=#00FF40]".$recy_titane."[/color] de métal, [color=#00FF40]".$recy_carbone."[/color] de carbone ont été recyclés.\n\n";
}
$bbcode .="[url=http://www.ogsteam.fr/forums/sujet-1358-mod-gestion-attaques]Généré par le module de gestion des attaques[/url]";


//Création du field pour voir la liste des recyclages en BBCode
echo"<fieldset><legend><b><font color='#0080FF'>Liste des recyclages en BBCode du ".$pub_date_from." au ".$pub_date_to." ";
echo help("bbcode");
echo"</font></b></legend>";
echo"<p align='left'><a href='#haut' onclick='selectionner2()'>Selectionner</a></p>";
echo"<form method='post'><textarea rows='7' cols='15' id='bbcode2'>$bbcode</textarea></form></fieldset>";
echo"<br>";
echo"<br>";
echo"</fieldset>";

//Résultat requetes
list($attack_titane, $attack_carbone, $attack_tritium, $attack_pertes) = $db->sql_fetch_row($resultgains);
list($recy_titane, $recy_carbone) = $db->sql_fetch_row($resultgains_recy);	
	
//Calcul des gains totaux
$totalgains=$attack_titane+$attack_carbone+$attack_tritium+$recy_titane+$recy_carbone;

//Calcul de la rentabilité
$renta = $totalgains-$attack_pertes;

//Formatage
$attack_titane = number_format($attack_titane, 0, ',', ' ');
$attack_carbone = number_format($attack_carbone, 0, ',', ' ');
$attack_tritium = number_format($attack_tritium, 0, ',', ' ');
$totalgains = number_format($totalgains, 0, ',', ' ');
$attack_pertes = number_format($attack_pertes, 0, ',', ' ');
$recy_titane = number_format($recy_titane, 0, ',', ' ');
$recy_carbone = number_format($recy_carbone, 0, ',', ' ');
$renta = number_format($renta, 0, ',', ' ');

//On prépare les resultats au format bbcode
$bbcode = "[color=orange][b]Résultats des attaques et recyclages de ".$user_data[user_name]."[/b] [/color]\n";
$bbcode .="du ".$pub_date_from." au ".$pub_date_to."\n\n";
$bbcode .="Nombre d'attaques durant cette periode : ".$nb_attack."\n\n";
$bbcode .="Titane gagné : [color=#00FF40]".$attack_titane."[/color]\n";
$bbcode .="Carbone gagné : [color=#00FF40]".$attack_carbone."[/color]\n";
$bbcode .="Tritium gagné : [color=#00FF40]".$attack_tritium."[/color]\n\n";
$bbcode .="Total des ressources gagnées : [color=#00FF40]".$totalgains."[/color]\n";
$bbcode .="Total des pertes attaquant : [color=#FF0000]".$attack_pertes."[/color]\n\n";
$bbcode .="Nombre de recyclages durant cette periode : ".$nb_recy."\n\n";
$bbcode .="Titane recyclé : [color=#00FF40]".$recy_titane."[/color]\n";
$bbcode .="Carbone recyclé : [color=#00FF40]".$recy_carbone."[/color]\n\n";
if ($renta > 0) $bbcode .="Rentabilité : [color=#00FF40]".$renta."[/color]\n\n";
else $bbcode .="Rentabilité : [color=#FF0000]".$renta."[/color]\n\n";
$bbcode .="[url=http://www.ogsteam.fr/forums/sujet-1358-mod-gestion-attaques]Généré par le module de gestion des attaques[/url]";


//Création du field pour voir les gains en BBCode
echo"<fieldset><legend><b><font color='#0080FF'>Gains en BBCode du ".$pub_date_from." au ".$pub_date_to." ";
echo help("bbcode");
echo"</font></b></legend>";
echo"<p align='left'><a href='#haut' onclick='selectionner3()'>Selectionner</a></p>";
echo"<form method='post'><textarea rows='7' cols='15' id='bbcode3'>$bbcode</textarea></form></fieldset>";
echo"<br>";
echo"<br>";
echo"</fieldset>";

echo"<hr width='325px'>";
echo"<p align='center'>Mod de Gestion des Attaques | Version 0.8e | <a href='mailto:verite@ogsteam.fr'>Vérité</a> |© 2006</p>";

//Insertion du bas de page d'OGSpy
require_once("views/page_tail.php");
?>