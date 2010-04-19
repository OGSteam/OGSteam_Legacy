<?php
/**
* attaques.php 
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
define("TABLE_ATTAQUES_ATTAQUES", $table_prefix."attaques_attaques");
define("TABLE_ATTAQUES_RECYCLAGES", $table_prefix."attaques_recyclages");
define("TABLE_ATTAQUES_ARCHIVES", $table_prefix."attaques_archives");
require_once("mod/Attaques/help.php");

//Gestion des dates
$date = date("j");
$mois = date("m");
$annee = date("Y");
$septjours = $date-7;
$yesterday = $date-1;

if($septjours < 1) $septjours = 1;
if($yesterday < 1) $yesterday = 1;

//Fonction d'ajout d'un rapport de combat
if (isset($pub_rapport))
{
	$pub_rapport = mysql_real_escape_string($pub_rapport);

  $pub_rapport = str_replace(".","",$pub_rapport);  
	//Compatibilité UNIX/Windows
	$pub_rapport = str_replace("\r\n","\n",$pub_rapport);
	//Compatibilité IE/Firefox
	$pub_rapport = str_replace("\t",' ',$pub_rapport);
	
	//On regarde si le rapport soumis est un RC

	// Correction lié à http://ogsteam.fr/viewtopic.php?id=3284 - Fait le 15/08/2008 par Draliam - A la demande de davfun
	/* DEPRECATED if (!preg_match('#Les\sflottes\ssuivantes\sse\ssont\saffrontées\sle\s(\d{1,2})\-(\d{2}) (\d{2}):(\d{2}):(\d{2})#',$pub_rapport,$date))*/
	if (!preg_match('#Les\sflottes\ssuivantes\sse\ssont\saffrontées\sle\s(\d{1,2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2}):(\d{2})#',$pub_rapport,$date))
	{
		$nonvalid = "Le texte inséré n'est pas un rc valide. Enregistrement de l'attaque non effectué !!!";
	} 
	else
	{

		preg_match('#Attaquant\s(.*)#',$pub_rapport,$attaquant);
		preg_match('#Defenseur\s(.*)#',$pub_rapport,$defenseur);
		preg_match('#attaquant\sa\sperdu\sau\stotal\s([0-9 ]+)\sunités#',$pub_rapport,$pertesA);
		preg_match('#([0-9 ]+)\sunités\sde\stitane,\s([0-9 ]+)\sunités\sde\scarbone\set\s([0-9 ]+)\sunités\sde\stritium#',$pub_rapport,$ressources);
		
		$pertesA = str_replace(" ","",$pertesA);
		$ressources = str_replace(" ","",$ressources);
		// Correction lié à http://ogsteam.fr/viewtopic.php?id=3284 - Fait le 15/08/2008 par Draliam - A la demande de davfun
		/* DEPRECATED $timestamp = mktime($date[3],$date[4],$date[5],$date[2],$date[1],date('Y')); */
		$timestamp = mktime($date[4],$date[5],$date[6],$date[2],$date[1],$date[3]);
		
		//Puis les informations pour les coordonnées
		preg_match('#Defenseur\s.+\s\((.+)\)#',$pub_rapport,$pre_coord);
		$coord_attaque = $pre_coord[1];
		
		//On vérifie que cette attaque n'a pas déja été enregistrée
		$query = "SELECT attack_id FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id='$user_data[user_id]' AND attack_date='$timestamp' AND attack_coord='$coord_attaque' ";
		$result = $db->sql_query($query);
		$nb = mysql_num_rows($result);
		
		if ($nb == 0)
		{
			//On insere ces données dans la base de données
			$query = "INSERT INTO ".TABLE_ATTAQUES_ATTAQUES." ( `attack_id` , `attack_user_id` , `attack_coord` , `attack_date` , `attack_titane` , `attack_carbone` , `attack_tritium` , `attack_pertes` )
				VALUES (
					NULL , '$user_data[user_id]', '$coord_attaque', '$timestamp', '$ressources[1]', '$ressources[2]', '$ressources[3]', '$pertesA[1]'
				)";
			$db->sql_query($query);
			
			//On met le message de validation
			$valid="Enregistrement de l'attaque effectué.";
			
			//On ajoute l'action dans le log
			$line = $user_data[user_name]." ajoute une attaque dans le module de gestion des attaques";
			$fichier = "log_".date("ymd").'.log';
			$line = "/*".date("d/m/Y H:i:s").'*/ '.$line;
			write_file(PATH_LOG_TODAY.$fichier, "a", $line);
		}
		else
		{
			//On met le message de non validation
			$nonvalid="Vous avez déja enregistrée cette attaques.";
		}
	}
}

//On verifie si il y a des attaques qui ne sont pas du mois actuel
$query = "SELECT MONTH(FROM_UNIXTIME(attack_date)) AS month, YEAR(FROM_UNIXTIME(attack_date)) AS year, SUM(attack_titane) AS titane, SUM(attack_carbone) AS carbone, SUM(attack_tritium) AS tritium, SUM(attack_pertes) as pertes FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id=".$user_data[user_id]." AND MONTH(FROM_UNIXTIME(attack_date)) <> $mois GROUP BY month"; 
$result = $db->sql_query($query);

$nb_result = mysql_num_rows($result);

//Si le nombre d'attaques n'appartenant pas au mois actuel est different de 0, on entre alors dans la partie sauvegarde des résultats anterieurs
if ($nb_result != 0)
{
	echo "<font color='#FF0000'>Vos attaques du ou des mois précédent(s) ont été supprimé(s). Seuls les gains restent accessibles dans la partie Espace Archives<br>La liste de vos attaques qui viennent d'être supprimées est consultable une dernière fois. Pensez à la sauvegarder !!!</font>";

	while (list($month, $year, $titane, $carbone, $tritium, $pertes) = $db->sql_fetch_row($result))
	{
		//On recupère la liste complète des attaques de la période afin de pouvoir les compter
		$query = "SELECT attack_coord, attack_date, attack_titane, attack_carbone, attack_tritium, attack_pertes FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id=".$user_data["user_id"]." AND MONTH(FROM_UNIXTIME(attack_date))=".$month." AND YEAR(FROM_UNIXTIME(attack_date))=".$year."";
		$list = $db->sql_query($query);
		
		$nb_ancattack = mysql_num_rows($list);
		
		//On recupere les gains des recyclages
		$query = "SELECT SUM(recy_titane) as titane_recy, SUM(recy_carbone) as carbone_recy FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_user_id=".$user_data["user_id"]." AND MONTH(FROM_UNIXTIME(recy_date))=".$month." AND YEAR(FROM_UNIXTIME(recy_date))=".$year." GROUP BY recy_user_id"; 
		$resultrecy = $db->sql_query($query);
		
		//On definit le timestamp
		$timestamp = mktime(0, 0, 0, $month, 01, $year);
		
		list($titane_recy, $carbone_recy) = $db->sql_fetch_row($resultrecy);
		
		//On sauvegarde les résultats
		$query = "INSERT INTO ".TABLE_ATTAQUES_ARCHIVES." ( `archives_id` , `archives_user_id` , `archives_nb_attaques` , `archives_date` , `archives_titane` , `archives_carbone` , `archives_tritium` , `archives_pertes`, `archives_recy_titane`, `archives_recy_carbone` )
				VALUES (
					NULL , '$user_data[user_id]', '$nb_ancattack', '$timestamp', '$titane', '$carbone', '$tritium' , '$pertes', '$titane_recy', '$carbone_recy'
				)";
			$db->sql_query($query);
		
		//On supprime les attaques qui viennent d'être sauvegardées
		$query = "DELETE FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id='$user_data[user_id]' AND MONTH(FROM_UNIXTIME(attack_date))=".$month." AND YEAR(FROM_UNIXTIME(attack_date))=".$year."";
		$db->sql_query($query);
		
		//On supprime les recyclages qui viennent d'être sauvegardés
		$query = "DELETE FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_user_id='$user_data[user_id]' AND MONTH(FROM_UNIXTIME(recy_date))=".$month." AND YEAR(FROM_UNIXTIME(recy_date))=".$year."";
		$db->sql_query($query);
		
		//On prépare la liste des attaques en BBCode
		$bbcode = "[color=orange][b]Liste des attaques de ".$user_data[user_name]."[/b] [/color]\n";
		$bbcode .="du 01/".$month."/".$year." au 31/".$month."/".$year."\n\n";
		
		while (list($attack_coord, $attack_date, $attack_titane, $attack_carbone, $attack_tritium, $attack_pertes) = $db->sql_fetch_row($list))
		{
			$attack_date = strftime("%d %b %Y %Hh%M", $attack_date);
			$bbcode .="Le ".$attack_date." victoire en ".$attack_coord.".\n";
			$bbcode .="[color=#00FF40]".$attack_titane."[/color] de titane, [color=#00FF40]".$attack_carbone."[/color] de carbone et [color=#00FF40]".$attack_tritium."[/color] de tritium ont été rapportés.\n";
			$bbcode .="Les pertes s'élèvent à [color=red]".$attack_pertes."[/color].\n\n";
		}
		
		$bbcode .="[url=http://www.ogsteam.fr/forums/sujet-1358-mod-gestion-attaques]Généré par le module de gestion des attaques[/url]";
		
		echo"<br><br>";
		echo"<fieldset><legend><b><font color='#0080FF'>Liste de vos attaques du 01/".$month."/".$year." au 31/".$month."/".$year."</font></legend>";
		echo"<br>";
		echo"<form method='post'><textarea rows='10' cols='15' id='$bbcode'>$bbcode</textarea></form></fieldset>";
	}
	
	echo"<br>";
	echo"<br>";
	echo"<p align='center'>Mod de Gestion des Attaques | Version 0.8e | <a href='mailto:verite@ogsteam.fr'>Vérité</a> |© 2006</p>";
	
	//Insertion du bas de page d'OGSpy
	require_once("views/page_tail.php");
	
	//On ajoute l'action dans le log
	$line = "La listes des attaques de ".$user_data[user_name]." a été supprimée. Les gains ont été archivés dans le module de gestion des attaques";
	$fichier = "log_".date("ymd").'.log';
	$line = "/*".date("d/m/Y H:i:s").'*/ '.$line;
	write_file(PATH_LOG_TODAY.$fichier, "a", $line);	
	
	exit;
}

//Fonction de suppression d'un rapport d'attaque
if (isset($pub_attack_id))
{
	$pub_attack_id = intval($pub_attack_id);

	//On récupère l'id de l'utilisateur qui a enregistré cette attaque
	$query = "SELECT attack_user_id FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_id='$pub_attack_id'";
	$result = $db->sql_query($query);
	list($user) = $db->sql_fetch_row($result);
	
	if($user == $user_data[user_id])
	{
		$query = "DELETE FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_id='$pub_attack_id'";
		$db->sql_query($query);
		echo"<blink><font color='FF0000'>L'attaque a bien été supprimée.</font></blink>";
		
		//On ajoute l'action dans le log
		$line = $user_data[user_name]." supprime l'une de ses attaque dans le module de gestion des attaques";
		$fichier = "log_".date("ymd").'.log';
		$line = "/*".date("d/m/Y H:i:s").'*/ '.$line;
		write_file(PATH_LOG_TODAY.$fichier, "a", $line);
	}
	else
	{
		echo"<blink><font color='FF0000'>Vous n'avez pas le droit d'effacer cette attaque !!!</font></blink>";
		
		//On ajoute l'action dans le log
		$line = $user_data[user_name]." a tenté de supprimer une attaque qui appartient à un autre utilisateurs dans le module de gestion des attaques";
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

//Si le choix de l'ordre n'est pas définis on met celui par defaut
if(!isset($pub_order_by)) $pub_order_by ="attack_date";
else $pub_order_by = mysql_real_escape_string($pub_order_by);

if(!isset($pub_sens)) $pub_sens = "DESC";
elseif($pub_sens == 2) $pub_sens = "DESC";
elseif($pub_sens == 1) $pub_sens = "ASC";

//Requete pour afficher la liste des attaques 
$query = "SELECT attack_coord, attack_date, attack_titane, attack_carbone, attack_tritium, attack_pertes, attack_id FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id=".$user_data["user_id"]." AND attack_date BETWEEN ".$pub_date_from." and ".$pub_date_to."  ORDER BY ".$pub_order_by." ".$pub_sens."";
$result = $db->sql_query($query);

//On recupère le nombre d'attaques
$nb_attack = mysql_num_rows($result);

//Cacul pour obtenir les gains
$query = "SELECT SUM(attack_titane), SUM(attack_carbone), SUM(attack_tritium), SUM(attack_pertes) FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id=".$user_data["user_id"]." AND attack_date BETWEEN ".$pub_date_from." and ".$pub_date_to." GROUP BY attack_user_id"; 
$resultgains = $db->sql_query($query);

//On récupère la date au bon format
$pub_date_from = strftime("%d %b %Y", $pub_date_from);
$pub_date_to = strftime("%d %b %Y", $pub_date_to);


//Création du field pour Ajouter une nouvelles attaque
echo"<fieldset><legend><b><font color='#0080FF'>Ajouter une nouvelle attaque ";
echo help("ajouter_attaque");
echo"</font></b></legend>
	<table width='60%' align='center'>
	<tr>
	<td align='center'><font color='FFFFFF'><big><big>Pour ajouter une nouvelle attaque, copiez un rapport de combat, puis collez le ci-dessous :
	</big></big></font></td>
	</tr>
	<tr>
	<td><p><form action='index.php?action=attaques&page=attaques' method='post'><input type='hidden' name='date_from' value='$pub_date_from'><input type='hidden' name='date_to' value='$pub_date_to'><textarea rows='6' name='rapport' cols='25'></textarea></p></td>
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
echo"<fieldset><legend><b><font color='#0080FF'>Date d'affichage des attaques ";
echo help("changer_affichage");
echo"</font></b></legend>";

echo"Afficher mes attaques : ";
echo"<form action='index.php?action=attaques&page=attaques' method='post' name='date'>";
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
echo"<fieldset><legend><b><font color='#0080FF'>Résultats des attaques du ".$pub_date_from." au ".$pub_date_to." ";
echo help("resultats");
echo"</font></b></legend>";

//Résultat requete
list($attack_titane, $attack_carbone, $attack_tritium, $attack_pertes) = $db->sql_fetch_row($resultgains);	

//Calcul des gains totaux
$totalgains=$attack_titane+$attack_carbone+$attack_tritium;

//Calcul de la rentabilité
$renta = $totalgains-$attack_pertes;

echo"<table width='100%'><tr align='left'>";

// Afficher l'image du graphique
echo"<td width='410px' align='center'>";
?>
<img src="index.php?action=graphic_pie&values=<?php echo $attack_titane ?>_x_<?php echo $attack_carbone ?>_x_<?php echo $attack_tritium ?>&legend=Titane_x_Carbone_x_Tritium&title=Proportion%20des%20gains%20des%20attaques%20affich%E9es" alt="Pas de graphique disponible">
<?php
echo"</td>";

//Affichage des gains en titane, en carbone et en tritium
$attack_titane = number_format($attack_titane, 0, ',', ' ');
$attack_carbone = number_format($attack_carbone, 0, ',', ' ');
$attack_tritium = number_format($attack_tritium, 0, ',', ' ');
echo "<td><p align='left'><font color='#FFFFFF'><big><big><big>Titane gagné : ".$attack_titane."<br>Carbone gagné : ".$attack_carbone."<br>Tritium gagné : ".$attack_tritium."<br>";

//Affichage du total des gains
$totalgains = number_format($totalgains, 0, ',', ' ');
echo "<b>Soit un total de : ".$totalgains."</b><br><br>";

//Affichage du total des pertes
$attack_pertes = number_format($attack_pertes, 0, ',', ' ');
echo"<b>Total des pertes attaquant : ".$attack_pertes."</b>";

//Affichage de la rentabilité des attaques
$renta = number_format($renta, 0, ',', ' ');

echo"<br><br><b>Rentabilité : ".$renta."</b>";
echo"</big></big>";
echo"</big></big></font></td></tr></table>";
echo"</p></fieldset><br><br>";

//Création du field pour voir la liste des attaques
echo"<fieldset><legend><b><font color='#0080FF'>Liste des attaques du ".$pub_date_from." au ".$pub_date_to." ";
echo" : ".$nb_attack." attaque(s) ";
echo help("liste_attaques");
echo"</font></b></legend>";

//Debut du lien pour le changement de l'ordre d'affichage
$link ="index.php?action=attaques&date_from=".$pub_date_from."&date_to=".$pub_date_to."";

//Tableau donnant la liste des attaques
echo"<table width='100%'>";
echo"<tr>";
echo"<td class=".c." align=".center."><a href='".$link."&order_by=attack_coord&sens=1'><img src='".$prefixe."images/asc.png'></a> <b>Coordonnées</b> <a href='".$link."&order_by=attack_coord&sens=2'><img src='".$prefixe."images/desc.png'></a></td>";
echo"<td class=".c." align=".center."><a href='".$link."&order_by=attack_date&sens=1'><img src='".$prefixe."images/asc.png'></a> <b>Date de l'Attaque</b> <a href='".$link."&order_by=attack_date&sens=2'><img src='".$prefixe."images/desc.png'></a></td>";
echo"<td class=".c." align=".center."><a href='".$link."&order_by=attack_titane&sens=1'><img src='".$prefixe."images/asc.png'></a> <b>Titane Gagné</b> <a href='".$link."&order_by=attack_titane&sens=2'><img src='".$prefixe."images/desc.png'></a></td>";
echo"<td class=".c." align=".center."><a href='".$link."&order_by=attack_carbone&sens=1'><img src='".$prefixe."images/asc.png'></a> <b>Carbone Gagné</b> <a href='".$link."&order_by=attack_carbone&sens=2'><img src='".$prefixe."images/desc.png'></a></td>";
echo"<td class=".c." align=".center."><a href='".$link."&order_by=attack_tritium&sens=1'><img src='".$prefixe."images/asc.png'></a> <b>Tritium Gagné</b> <a href='".$link."&order_by=attack_tritium&sens=2'><img src='".$prefixe."images/desc.png'></a></td>";
echo"<td class=".c." align=".center."><a href='".$link."&order_by=attack_pertes&sens=1'><img src='".$prefixe."images/asc.png'></a> <b>Pertes Attaquant</b> <a href='".$link."&order_by=attack_pertes&sens=2'><img src='".$prefixe."images/desc.png'></a></td>";
echo"<td class=".c." align=".center."><b><font color='#FF0000'>Supprimer</font></b></td>";

echo"</tr>";
echo"<tr>";

while( list($attack_coord, $attack_date, $attack_titane, $attack_carbone, $attack_tritium, $attack_pertes, $attack_id) = $db->sql_fetch_row($result) )
{
	$attack_date = strftime("%d %b %Y %Hh%M", $attack_date);
	$attack_titane = number_format($attack_titane, 0, ',', ' ');
	$attack_carbone = number_format($attack_carbone, 0, ',', ' ');
	$attack_tritium = number_format($attack_tritium, 0, ',', ' ');
	$attack_pertes = number_format($attack_pertes, 0, ',', ' ');
	$coord = explode(":", $attack_coord);
    echo"<th align='center'><a href='index.php?action=galaxy&galaxy=".$coord[0]."&system=".$coord[1]."'>".$attack_coord."</th>";
	echo"<th align='center'>".$attack_date."</th>";
	echo"<th align='center'>".$attack_titane."</th>";
	echo"<th align='center'>".$attack_carbone."</th>";
	echo"<th align='center'>".$attack_tritium."</th>";
	echo"<th align='center'>".$attack_pertes."</th>";
	echo"<th align='center' valign='middle'><form action='index.php?action=attaques&page=attaques' method='post'><input type='hidden' name='date_from' value='$pub_date_from'><input type='hidden' name='date_to' value='$pub_date_to'><input type='hidden' name='attack_id' value='$attack_id'><input type='submit'	value='Supprimer' name='B1' style='color: #FF0000'></form></th>";
	echo"</tr>";
	echo"<tr>";
}
echo"</tr>";
echo"</table>";

echo"</fieldset>";

echo"<br>";
echo"<br>";
echo"<hr width='325px'>";
echo"<p align='center'>Mod de Gestion des Attaques | Version 0.8e | <a href='mailto:verite@ogsteam.fr'>Vérité</a> | © 2006</p>";

//Insertion du bas de page d'OGSpy
require_once("views/page_tail.php");
?>
