<?php
/**
 * guerres.php 
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
$date = date("j");
$mois = date("m");
$annee = date("Y");

//Fonction d'ajout d'une guerre
if ( (isset($pub_ally_1)) && (isset($pub_ally_2)) )
{
	$pub_ally_1 = mysql_real_escape_string($pub_ally_1);
	$pub_ally_2 = mysql_real_escape_string($pub_ally_2);
	
	$timestamp = mktime(0, 0, 0, $mois, $date, $annee);
	
	//On créer l'attaque dans la liste des attaques
	$query = "INSERT INTO ".TABLE_GUERRES_LISTE." ( `guerre_id` , `guerre_ally_1` , `guerre_ally_2` , `guerre_date_debut`)
			VALUES (
				NULL , '$pub_ally_1', '$pub_ally_2', '$timestamp'
			)";
		$db->sql_query($query);		
}

//Fonction de mise à jours de la db en cas de modif des info d'une guerre
if ( (isset($pub_modif_ally_1)) && (isset($pub_modif_ally_2)) )
{
	if (($user_data[user_admin] == 1) || ($user_data[user_coadmin] == 1))
	{
		$pub_modif_ally_1 = mysql_real_escape_string($pub_modif_ally_1);
		$pub_modif_ally_2 = mysql_real_escape_string($pub_modif_ally_2);
		
		$query  = "UPDATE ".TABLE_GUERRES_LISTE." SET guerre_ally_1='$pub_modif_ally_1' WHERE guerre_id='$pub_guerre_id' LIMIT 1";
		$db->sql_query($query);
		
		$query  = "UPDATE ".TABLE_GUERRES_LISTE." SET guerre_ally_2='$pub_modif_ally_2' WHERE guerre_id='$pub_guerre_id' LIMIT 1";
		$db->sql_query($query);	
	}
}

//Fonction de modif des info d'une guerre
if ( (isset($pub_modif)) )
{
	if (($user_data[user_admin] == 1) || ($user_data[user_coadmin] == 1))
	{
		//Requete pour afficher les infos sur le guerre selectionnée
		$query = "SELECT guerre_ally_1, guerre_ally_2, guerre_date_debut FROM ".TABLE_GUERRES_LISTE." WHERE guerre_id=".$pub_modif."";
		$result = $db->sql_query($query);
		
		list($guerre_ally_1, $guerre_ally_2, $guerre_date_debut) = $db->sql_fetch_row($result);
		
		//Création du field pour modifier les info de la guerre
		echo"<fieldset><legend><b><font color='#0080FF'> Modifier les informations concernant cette guerre : </font></b></legend>
		<p align='left'><form action='index.php' method='post'><input type='hidden' name='action' value='guerres'><input type='hidden' name='guerre_id' value='$pub_modif'>
		<font color='#00FF40'>Tag de votre alliance et tag de vos alliés :</font> <input type='text' name ='modif_ally_1' size='60' maxlength='255' value='$guerre_ally_1'>
		<br>
		<br>
		<font color='#FF0000'>Tag des alliances qui vous sont opposées :</font> <input type='text' name ='modif_ally_2' size='60' maxlength='255' value='$guerre_ally_2'>
		<br><br>
		<font color=yellow>N'oubliez pas de mettre [] autour des tags des alliances pour améliorer la visibilité</font>
		</p>
		<p><input type='submit' value='Modifiez'></form>";
		echo"</fieldset><br><br>";
		
		echo"<hr width='325px'>";
		echo"<p align='center'>Mod Guerres | Version 0.2b | <a href='mailto:verite@ogsteam.fr'>Vérité</a> |© 2006</p>";
		
		//Insertion du bas de page d'OGSpy
		require_once("views/page_tail.php");
		exit;
	}
}
	//Fonction de cloture d'une guerre
if (isset($pub_cloture))
{
	$pub_cloture = intval($pub_cloture);

	if (( $user_data[user_admin] == 1) || ($user_data[user_coadmin] == 1))
	{
		echo"<blink><font color='FF0000'><big>La guerre a bien été cloturée.Les résultats sont consultables une dernière fois. Pensez à les sauvegarder.</big></font></blink>";
		echo"<br><br>";
		
		//On affiche les résultats
		//Requete pour afficher les infos sur le guerre selectionnée
		$query = "SELECT guerre_ally_1, guerre_ally_2, guerre_date_debut FROM ".TABLE_GUERRES_LISTE." WHERE guerre_id=".$pub_cloture."";
		$result = $db->sql_query($query);
		
		list($guerre_ally_1, $guerre_ally_2, $guerre_date_debut) = $db->sql_fetch_row($result);
		
		//Requete pour afficher les resultats des attaques
		$query = "SELECT attack_metal, attack_cristal, attack_deut, attack_pertes_A, attack_pertes_D FROM ".TABLE_GUERRES_ATTAQUES."  WHERE guerres_id='$pub_cloture' GROUP BY guerres_id";
		$result = $db->sql_query($query);
		
		//Requete pour afficher les resultats des recyclages
		$query = "SELECT recy_metal, recy_cristal FROM ".TABLE_GUERRES_RECYCLAGES." WHERE guerre_id=".$pub_cloture." GROUP BY guerre_id";
		$result2 = $db->sql_query($query);
		
		$guerre_date_debut = strftime("%d %b %Y", $guerre_date_debut);
		
		//Création du field pour selectionner la guerre
		echo"<fieldset><legend><b><font color='#0080FF'> Résultats de la guerre : ".$guerre_ally_1." vs ".$guerre_ally_2." en BBCode</font></b></legend>";
		echo"<p align='left'>";
		$bbcode="[u][color=orange]Informations générales :[/color][/u]\n\n";
		$bbcode.="Guerre : [color=#00FF40]".$guerre_ally_1."[/color] vs [color=#FF0000]".$guerre_ally_2."[/color]\n";
		$bbcode.="En guerre depuis le : ".$guerre_date_debut."";
		
		list($attack_metal, $attack_cristal, $attack_deut, $attack_pertes_A, $attack_pertes_D) = $db->sql_fetch_row($result);
		list($recy_metal, $recy_cristal) = $db->sql_fetch_row($result2);
			
		$totalgains=$attack_metal+$attack_cristal+$attack_deut;
		$total_recy=$recy_metal+$recy_cristal;
		$renta=$totalgains+$total_recy-$attack_pertes_A;
		
		$bbcode.="[u][color=orange]Résulats pour les :[/color][color=#00FF40]".$guerre_ally_1."[/color][/u]\n\n";
		$attack_metal = number_format($attack_metal, 0, ',', ' ');
		$bbcode.="Métal gagné : ".$attack_metal."\n";
		$attack_cristal = number_format($attack_cristal, 0, ',', ' ');
		$bbcode.="Cristal gagné : ".$attack_cristal."\n";
		$attack_deut = number_format($attack_deut, 0, ',', ' ');
		$bbcode.="Deuterium gagné : ".$attack_deut."\n";
		$totalgains = number_format($totalgains, 0, ',', ' ');
		$bbcode.="[b]Soit un total de : ".$totalgains."[/b]\n\n";
		$attack_pertes_A = number_format($attack_pertes_A, 0, ',', ' ');
		$bbcode.="[b]Les pertes s'élèvent à : ".$attack_pertes_A."[/b]\n\n";
		$recy_metal = number_format($recy_metal, 0, ',', ' ');
		$bbcode.="Métal recyclé : ".$recy_metal."\n";
		$recy_cristal = number_format($recy_cristal, 0, ',', ' ');
		$bbcode.="Cristal recyclé : ".$recy_cristal."\n";
		$total_recy = number_format($total_recy, 0, ',', ' ');
		$bbcode.="[b]Soit un total de : ".$total_recy."[/b]\n\n";
		$renta = number_format($renta, 0, ',', ' ');
		$bbcode.="[b]La rentabilité est donc de : ".$renta."[/b]\n\n";
		$attack_pertes_D = number_format($attack_pertes_D, 0, ',', ' ');
		$bbcode.="[b]Les pertes infligées à l'ennemi sont de : ".$attack_pertes_D."[/b]\n\n";
		$bbcode.="Résulats finaux, la guerre étant cloturée\n\n";
		$bbcode.="[i]Ces pertes sont basées sur les rapports de combats et de recyclages enregistrés. Elles ne tiennnet pas compte d'eventuels missilages.[/i]\n\n";
		$bbcode.="[url=http://ogsteam.fr]Généré par le module guerres[/url]";
		echo"<a href='#haut' onclick='selectionner()'>Selectionner</a>";
		echo"<form method='post'><textarea rows='7' cols='15' id='bbcode'>$bbcode</textarea></form>";
		echo"</p>";
		echo"<br>";
		echo"<i>La mise en forme de ces résultats est assez simple afin de n'utiliser que les balises BBCode acceptées par la plupart des forums. Rien de vous empeche de rajouter des balises propres au forum ou vous allez poster.</i>";
		echo"</fieldset><br><br>";
		
		//Requete pour afficher la listes des attaques
	$query = "SELECT attack_id, attack_date, attack_name_A, attack_name_D, attack_coord, attack_metal, attack_cristal, attack_deut, attack_pertes_A, attack_pertes_D FROM ".TABLE_GUERRES_ATTAQUES."  WHERE guerres_id='$pub_cloture' ORDER BY attack_date";
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
	
	//Requete pour afficher la listes des recyclages
	$query = "SELECT recy_id, recy_date, recy_coord, recy_metal, recy_cristal FROM ".TABLE_GUERRES_RECYCLAGES." WHERE guerre_id=".$pub_cloture." ORDER BY recy_date";
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
		
		echo"<hr width='325px'>";
		echo"<p align='center'>Mod Guerres | Version 0.2 | <a href='mailto:verite@ogsteam.fr'>Vérité</a> |© 2006</p>";
		
		$query = "DELETE FROM ".TABLE_GUERRES_LISTE." WHERE guerre_id='$pub_cloture'";
		$db->sql_query($query);
		
		$query = "DELETE FROM ".TABLE_GUERRES_ATTAQUES." WHERE guerres_id='$pub_cloture'";
		$db->sql_query($query);
		
		$query = "DELETE FROM ".TABLE_GUERRES_RECYCLAGES." WHERE guerre_id='$pub_cloture'";
		$db->sql_query($query);
		
		//On ajoute l'action dans le log
		$line = $user_data[user_name]." cloture la guerre n°".$pub_cloture." dans le module guerres.";
		$fichier = "log_".date("ymd").'.log';
		$line = "/*".date("d/m/Y H:i:s").'*/ '.$line;
		write_file(PATH_LOG_TODAY.$fichier, "a", $line);
		exit;
	}
	
	else echo"<blink><font color='FF0000'>Vous n'avez pas le droit de supprimer cette guerre.</font></blink>";
}

//Requete pour afficher la liste des guerres
$query = "SELECT guerre_id, guerre_ally_1, guerre_ally_2, guerre_date_debut FROM ".TABLE_GUERRES_LISTE." ORDER BY guerre_id ASC";
$result = $db->sql_query($query);

//Création du field pour Ajouter une nouvelles guerres
echo"<fieldset><legend><b><font color='#0080FF'> Ajouter une nouvelle guerre </font></b></legend>
<font color='FFFFFF'><big><big>Pour ajouter une nouvelle guerre remplissez le formulaire ci-dessous :
</big></big></font>
<p align='left'><form action='index.php' method='post'><input type='hidden' name='action' value='guerres'>
<font color='#00FF40'>Tag de votre alliance et tag de vos alliés :</font> <input type='text' name ='ally_1' size='60' maxlength='255'>
<br>
<br>
<font color='#FF0000'>Tag des alliances qui vous sont opposées :</font> <input type='text' name ='ally_2' size='60' maxlength='255'>
<br><br>
<font color=yellow>N'oubliez pas de mettre [] autour des tags des alliances pour améliorer la visibilité</font>
</p>

<p><input type='submit' value='Ajouter'></form>";
echo"</fieldset><br><br>";

//Création du field pour voir les guerres en cours
echo"<fieldset><legend><b><font color='#0080FF'> Liste des guerres en cours </font></b></legend>";
echo"<p align='left'>";
while (list($guerre_id, $guerre_ally_1, $guerre_ally_2, $guerre_date_debut) = $db->sql_fetch_row($result))
{
	$guerre_date_debut = strftime("%d %b %Y", $guerre_date_debut);
	echo"- <font color='#00FF40'>".$guerre_ally_1."</font> vs <font color='#FF0000'>".$guerre_ally_2."</font> depuis le ".$guerre_date_debut."";
	
	if (( $user_data[user_admin] == 1) || ($user_data[user_coadmin] == 1)) echo " (<a href='index.php?action=guerres&modif=".$guerre_id."'>Modifier</a> | <a href='index.php?action=guerres&cloture=".$guerre_id."'>Cloturer</a>)";
	
	echo"<br><br>";
}
echo"</p>";
echo"</fieldset><br><br>";

echo"<hr width='325px'>";
echo"<p align='center'>Mod Guerres | Version ".$mod_version." | <a href='mailto:verite@ogsteam.fr'>Vérité</a> |© 2006</p>";

//Insertion du bas de page d'OGSpy
require_once("views/page_tail.php");
?>