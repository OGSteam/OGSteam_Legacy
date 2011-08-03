<?php
/**
 * bbcode.php 
 * @package Guerres
 * @author Verité
 * @link http://www.ogsteam.fr
 * @version 0.2e
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
?>

<SCRIPT language="JavaScript">
function selectionner() {
		document.getElementById('bbcode').select();
	}
function selectionner2() {
		document.getElementById('bbcode2').select();
	}
function selectionner3() {
		document.getElementById('bbcode3').select();
	}
</script>

<?php
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
echo"Selectionnez la guerre dont vous souhaitez visualiser les résultats en BBCode :";
echo"<br>";
echo"<br>";
echo"<form action='index.php' method='post'><input type='hidden' name='action' value='guerres'><input type='hidden' name='page' value='Espace BBCode'>";
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
echo"<input type='submit' value='Voir les resulats en BBCode'>";
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
	echo"<fieldset><legend><b><font color='#0080FF'> Résultats de la guerre : ".$guerre_ally_1." vs ".$guerre_ally_2." en BBCode</font></b></legend>";
	echo"<p align='left'>";
	$bbcode="[u][color=orange]Informations générales :[/color][/u]\n\n";
	$bbcode.="Guerre : [color=#00FF40]".$guerre_ally_1."[/color] vs [color=#FF0000]".$guerre_ally_2."[/color]\n";
	$bbcode.="En guerre depuis le : ".$guerre_date_debut."\n\n";
	
	list($metal, $cristal, $deut, $pertes_a, $pertes_d) = $db->sql_fetch_row($result);
	list($re_metal, $re_cristal) = $db->sql_fetch_row($result2);

	$totalgains=$metal+$cristal+$deut;
	$total_recy=$re_metal+$re_cristal;
	$renta=$totalgains+$total_recy-$pertes_a;
	
	$bbcode.="[u][color=orange]Résulats pour les :[/color][color=#00FF40]".$guerre_ally_1."[/color][/u]\n\n";
	$metal = number_format($metal, 0, ',', ' ');
	$bbcode.="Métal gagné : ".$metal."\n";
	$cristal = number_format($cristal, 0, ',', ' ');
	$bbcode.="Cristal gagné : ".$cristal."\n";
	$deut = number_format($deut, 0, ',', ' ');
	$bbcode.="Deuterium gagné : ".$deut."\n";
	$totalgains = number_format($totalgains, 0, ',', ' ');
	$bbcode.="[b]Soit un total de : ".$totalgains."[/b]\n\n";
	$pertes_a = number_format($pertes_a, 0, ',', ' ');
	$bbcode.="[b]Les pertes s'élèvent à : ".$pertes_a."[/b]\n\n";
	$re_metal = number_format($re_metal, 0, ',', ' ');
	$bbcode.="Métal recyclé : ".$re_metal."\n";
	$re_cristal = number_format($re_cristal, 0, ',', ' ');
	$bbcode.="Cristal recyclé : ".$re_cristal."\n";
	$total_recy = number_format($total_recy, 0, ',', ' ');
	$bbcode.="[b]Soit un total de : ".$total_recy."[/b]\n\n";
	$renta = number_format($renta, 0, ',', ' ');
	$bbcode.="[b]La rentabilité est donc de : ".$renta."[/b]\n\n";
	$pertes_d = number_format($pertes_d, 0, ',', ' ');
	$bbcode.="[b]Les pertes infligées à l'ennemi sont de : ".$pertes_d."[/b]\n\n";
	$bbcode.="[i]Ces pertes sont basées sur les rapports de combats et de recyclages enregistrés. Elles ne tiennnet pas compte d'eventuels missilages.[/i]\n\n";
	$bbcode.="[url=http://ogsteam.fr]Généré par le module guerres[/url]";
	echo"<a href='#haut' onclick='selectionner()'>Selectionner</a>";
	echo"<form method='post'><textarea rows='7' cols='15' id='bbcode'>$bbcode</textarea></form>";
	echo"</p>";
	echo"<br>";
	echo"<i>La mise en forme de ces résultats est assez simple afin de n'utiliser que les balises BBCode acceptées par la plupart des forums. Rien de vous empeche de rajouter des balises propres au forum ou vous allez poster.</i>";
	echo"</fieldset><br><br>";

	//Requete pour afficher les resultats des attaques
	$query = "SELECT attack_id, attack_date, attack_name_A, attack_name_D, attack_coord, attack_metal, attack_cristal, attack_deut, attack_pertes_A, attack_pertes_D FROM ".TABLE_GUERRES_ATTAQUES."  WHERE guerres_id='$pub_guerre' ORDER BY attack_date";
	$result = $db->sql_query($query);
	
	$bbcode2="[u][color=orange]Listes des attaques pour les :[/color][color=#00FF40]".$guerre_ally_1."[/color][/u]\n\n";
	
	while(list($attack_id, $attack_date, $attack_name_A, $attack_name_D, $attack_coord, $attack_metal, $attack_cristal, $attack_deut, $attack_pertes_A, $attack_pertes_D) = $db->sql_fetch_row($result))
	{
		$attack_date = strftime("%d %b %Y à %Hh%M", $attack_date);
		$attack_metal = number_format($attack_metal, 0, ',', ' ');
		$attack_cristal = number_format($attack_cristal, 0, ',', ' ');
		$attack_deut = number_format($attack_deut, 0, ',', ' ');
		$attack_pertes_A = number_format($attack_pertes_A, 0, ',', ' ');
		$attack_pertes_D = number_format($attack_pertes_D, 0, ',', ' ');
		$bbcode2 .="Le ".$attack_date." bataille en ".$attack_coord.".\n";
		$bbcode2 .="".$attack_name_A." vs ".$attack_name_D."\n";
		$bbcode2 .="[color=#00FF40]".$attack_metal."[/color] de métal, [color=#00FF40]".$attack_cristal."[/color] de cristal et [color=#00FF40]".$attack_deut."[/color] de deuterium ont été rapportés.\n";
		$bbcode2 .="Les pertes pour ".$attack_name_A." s'élèvent à [color=red]".$attack_pertes_A."[/color].\n";
		$bbcode2 .="Les pertes pour ".$attack_name_D." s'élèvent à [color=#00FF40]".$attack_pertes_D."[/color].\n\n";
	}
	$bbcode2.="[url=http://ogsteam.fr]Généré par le module Guerres[/url]";
	
	echo"<fieldset><legend><b><font color='#0080FF'> Liste des attaques pour les : ".$guerre_ally_1." en BBCode</font></b></legend>";
	echo"<p align='left'>";
	echo"<a href='#haut' onclick='selectionner2()'>Selectionner</a>";
	echo"<form method='post'><textarea rows='7' cols='15' id='bbcode2'>$bbcode2</textarea></form>";
	echo"</p>";
	echo"<br>";
	echo"<i>La mise en forme de ces résultats est assez simple afin de n'utiliser que les balises BBCode acceptées par la plupart des forums. Rien de vous empeche de rajouter des balises propres au forum ou vous allez poster.</i>";
	echo"</fieldset><br><br>";
	
	//Requete pour afficher les resultats des recyclages
	$query = "SELECT recy_id, recy_date, recy_coord, recy_metal, recy_cristal FROM ".TABLE_GUERRES_RECYCLAGES." WHERE guerre_id=".$pub_guerre." ORDER BY recy_date";
	$result2 = $db->sql_query($query);
	
	$bbcode3="[u][color=orange]Listes des recyclages pour les :[/color][color=#00FF40]".$guerre_ally_1."[/color][/u]\n\n";
	
	while(list($recy_id, $recy_date, $recy_coord, $recy_metal, $recy_cristal) = $db->sql_fetch_row($result2))
	{
		$recy_date = strftime("%d %b %Y à %Hh%M", $recy_date);
		$recy_metal = number_format($recy_metal, 0, ',', ' ');
		$recy_cristal = number_format($recy_cristal, 0, ',', ' ');
		$bbcode3 .="Le ".$recy_date." recyclage en ".$recy_coord.".\n";
		$bbcode3 .="[color=#00FF40]".$recy_metal."[/color] de métal et [color=#00FF40]".$recy_cristal."[/color] de cristal ont été recyclés.\n\n";
	}
	
	$bbcode3.="[url=http://ogsteam.fr]Généré par le module Guerres[/url]";
	
	echo"<fieldset><legend><b><font color='#0080FF'> Liste des recyclages pour les : ".$guerre_ally_1." en BBCode</font></b></legend>";
	echo"<p align='left'>";
	echo"<a href='#haut' onclick='selectionner3()'>Selectionner</a>";
	echo"<form method='post'><textarea rows='7' cols='15' id='bbcode3'>$bbcode3</textarea></form>";
	echo"</p>";
	echo"<br>";
	echo"<i>La mise en forme de ces résultats est assez simple afin de n'utiliser que les balises BBCode acceptées par la plupart des forums. Rien de vous empeche de rajouter des balises propres au forum ou vous allez poster.</i>";
	echo"</fieldset><br><br>";
}

echo"<hr width='325px'>";
echo"<p align='center'>Mod Guerres | Version ".$mod_version." | <a href='mailto:verite@ogsteam.fr'>Vérité</a> |© 2006</p>";

//Insertion du bas de page d'OGSpy
require_once("views/page_tail.php");
?>
