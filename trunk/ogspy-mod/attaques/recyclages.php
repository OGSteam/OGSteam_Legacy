<?php
/**
* recyclages.php 
 * @package Attaques
 * @author Verité/ericc
 * @link http://www.ogsteam.fr
 * @version : 0.8b
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


//Fonction de suppression d'un rapport d'attaque
if (isset($pub_recy_id))
{
	$pub_recy_id = intval($pub_recy_id);

	//On récupère l'id de l'utilisateur qui a enregistré cette attaque
	$query = "SELECT recy_user_id FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_id='$pub_recy_id'";
	$result = $db->sql_query($query);
	list($user) = $db->sql_fetch_row($result);
	
	if($user == $user_data['user_id'])
	{
		$query = "DELETE FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_id='$pub_recy_id'";
		$db->sql_query($query);
		echo"<blink><font color='FF0000'>Le recyclage a bien été supprimée.</font></blink>";
		
		//On ajoute l'action dans le log
		$line = $user_data['user_name']." supprime l'un de ses recyclage dans le module de gestion des attaques";
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
$query = "SELECT recy_coord, recy_date, recy_metal, recy_cristal, recy_id FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_user_id=".$user_data["user_id"]." AND recy_date BETWEEN ".$pub_date_from." and ".$pub_date_to."  ORDER BY recy_date DESC,recy_id DESC";
$result = $db->sql_query($query);

//On recupère le nombre de recyclages
$nb_recy = mysql_num_rows($result);

//Cacul pour obtenir les gains des recyclages
$query = "SELECT SUM(recy_metal), SUM(recy_cristal) FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_user_id=".$user_data["user_id"]." AND recy_date BETWEEN ".$pub_date_from." and ".$pub_date_to." GROUP BY recy_user_id"; 
$resultgains = $db->sql_query($query);

//On récupère la date au bon format
$pub_date_from = strftime("%d %b %Y", $pub_date_from);
$pub_date_to = strftime("%d %b %Y", $pub_date_to);

//Création du field pour choisir l'affichage (attaque du jour, de la semaine ou du mois
echo"<fieldset><legend><b><font color='#0080FF'>Date d'affichage des recyclages ";
echo help("changer_affichage");
echo"</font></b></legend>";

echo"Afficher mes recyclages : ";
echo"<form action='index.php?action=attaques&page=recyclages' method='post' name='date'>";
echo"du : <input type='text' name='date_from' id='date_from' size='11' maxlength='2' value='$pub_date_from' /> ";
echo"au : ";
echo"<input type='text' name='date_to' id='date_to' size='11' maxlength='2' value='$pub_date_to' />";
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
list($recy_metal, $recy_cristal) = $db->sql_fetch_row($resultgains);	

//Calcul des gains totaux
$totalgains=$recy_metal+$recy_cristal;

echo"<table width='100%'><tr align='left' valign='center'>";

// Afficher l'image du graphique
echo"<td width='410px' align='center'>";
if ((!isset($recy_metal)) && (!isset($recy_cristal)))
   {
   echo "Pas de graphique disponible";
   }else{
   echo "<img src='index.php?action=graphic_pie&values=".$recy_metal."_x_".$recy_cristal."&legend=Metal_x_Cristal&title=Proportion%20des%20gains%20des%20recyclages%20affich%E9es' alt='Pas de graphique disponible'>";
   }
echo"</td>";

//Affichage des gains en métal, en cristal et en deut
$recy_metal = number_format($recy_metal, 0, ',', ' ');
$recy_cristal = number_format($recy_cristal, 0, ',', ' ');
echo "<td><p align='left'><font color='#FFFFFF'><big><big><big>Métal recyclé : ".$recy_metal."<br>Cristal recyclé : ".$recy_cristal."<br><br>";

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
echo"<td class=".'c'." align=".'center'."><b>Coordonnées</b></td>";
echo"<td class=".'c'." align=".'center'."><b>Date du recyclage</b></td>";
echo"<td class=".'c'." align=".'center'."><b>Métal Recyclé</b></td>";
echo"<td class=".'c'." align=".'center'."><b>Cristal Recyclé</b></td>";
echo"<td class=".'c'." align=".'center'."><b><font color='#FF0000'>Supprimer</font></b></td>";

echo"</tr>";
echo"<tr>";

while( list($recy_coord, $recy_date, $recy_metal, $recy_cristal, $recy_id) = $db->sql_fetch_row($result) )
{
	$recy_date = strftime("%d %b %Y à %Hh%M", $recy_date);
	$recy_metal = number_format($recy_metal, 0, ',', ' ');
	$recy_cristal = number_format($recy_cristal, 0, ',', ' ');
	echo"<th align='center'>".$recy_coord."</th>";
	echo"<th align='center'>".$recy_date."</th>";
	echo"<th align='center'>".$recy_metal."</th>";
	echo"<th align='center'>".$recy_cristal."</th>";
	echo"<th align='center' valign='middle'><form action='index.php?action=attaques&page=recyclages' method='post'><input type='hidden' name='date_from' value='$pub_date_from'><input type='hidden' name='date_to' value='$pub_date_to'><input type='hidden' name='recy_id' value='$recy_id'><input type='submit'	value='Supprimer' name='B1' style='color: #FF0000'></form></th>";
	echo"</tr>";
	echo"<tr>";
}
echo"</tr>";
echo"</table>";
echo"</fieldset>";

if ($config['histo']==1)
{
echo"<fieldset><legend><b><font color='#0080FF'>Historique mensuel</font></b></legend>";
echo "<img src='index.php?action=attaques&subaction=recyclage' alt='pas de graphique disponible' />";
echo"</fieldset>";
}
echo"<br>";
echo"<br>";
?>
