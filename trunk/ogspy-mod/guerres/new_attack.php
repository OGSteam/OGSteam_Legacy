<?php
/**
 * new_attack.php 
 * @package Guerres
 * @author Verité
 * @link http://www.ogsteam.fr
 * @version 0.2e
 * @licence http://opensource.org/licenses/gpl-license.php GNU Public License
*/

?>
<SCRIPT language="JavaScript">
function clear_box() 
{
	document.getElementById('rapport').value = "";
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

//Gestion des dates
$date = date("j");
$mois = date("m");
$annee = date("Y");

//Fonction d'ajout d'une attaque ou d'un recyclage
if ( (isset($pub_rapport)) && (isset($pub_guerre_id)) )
{
	$pub_rapport = mysql_real_escape_string($pub_rapport);
	
	//Compatibilité UNIX/Windows
	$pub_rapport = str_replace("\r\n","\n",$pub_rapport);
	//Compatibilité IE/Firefox
	$pub_rapport = str_replace("\t",' ',$pub_rapport);
	//Compatibilité Ogame 0.76
	//$pub_rapport = str_replace(".","",$pub_rapport);
	$pub_rapport = str_replace("-",' ',$pub_rapport);
	$regex ="/^[\w]['&;]*[^0-9_-]{4,256}[\w][^0-9_-]$/x"; 
	//On regarde si le rapport soumis est un RC
    if (!preg_match('#Les\sflottes\ssuivantes\ss\'aff#',$pub_rapport,$date))
	//rontent\s((\d{2})\-(\d{2})\-(\d{4})\s(\d{2}):(\d{2}):(\d{2})):#',$pub_rapport,$date))
	{
		//On regarde si le rapport soumis est un rapport de reyclage
		if(stristr($regex,$pub_rapport, 'recycleurs ont une capacité totale de') === FALSE)
		{
			echo"<blink><font color='#FF0000'><big><big>Le rapport que vous avez soumis n'est pas un rapport de combat ou un rapport de recyclage valide !!!</big></big></font></blink><br><br>";
		}
		
		else
		{
			//On récupère les données pour les coordonnées
			$pre_coord = explode("[", $pub_rapport);
			$pre_coord2 = explode("]", $pre_coord[1]);
			$recy_coord = $pre_coord2[0];
			
			//On récupère les données pour le métal
			$pre_recy = strstr($pub_rapport,collecté);
			$pre_recy_metal = explode(" ",$pre_recy);
			$recy_metal = floatval($pre_recy_metal[1]);
			
			//On récupère les données pour le cristal
			$pre_recy_cristal = strstr($pre_recy,et);
			$pre_recy_cristal2 = explode(" ",$pre_recy_cristal);
			$recy_cristal = floatval($pre_recy_cristal2[1]);
			
			//On récupère les données pour la date
			$date_attack = explode("-", $pub_rapport);
			$date_attack = explode(" ", $date_attack[1]);
			$date_attaque=$date_attack[0];
			$temps = explode(":", $pub_rapport);
			$hour = explode(" ", $temps[0]);
			$hour = $hour[1];
			$minute = $temps[1];
			$second = explode(" ", $temps[2]);
			$second = $second[0];
			
			if( ($recy_coord == 0) || ($date_attaque == 0) )
			{
				//On met le message de validation
				echo"<blink><font color='#FF0000'><big>Votre rapport de recyclage n'est pas complet !!!</big></font></blink><br><br>";
			}
			else 
			{
				$timestamp = mktime($hour, $minute, $second, $mois, $date_attaque, $annee);
						
				//On vérifie que ce recyclage n'a pas déja été enregistrée
				$query = "SELECT recy_id FROM ".TABLE_GUERRES_RECYCLAGES." WHERE guerre_id='$pub_guerre_id' AND recy_date='$timestamp' AND recy_coord='$recy_coord'";
				$result = $db->sql_query($query);
				$nb = mysql_num_rows($result);
				
				if ($nb == 0)
				{
					//On insere ces données dans la base de données
					$query = "INSERT INTO ".TABLE_GUERRES_RECYCLAGES." ( `recy_id` , `guerre_id` , `recy_date` , `recy_coord` , `recy_metal` , `recy_cristal` )
						VALUES (
							NULL , '$pub_guerre_id', '$timestamp', '$recy_coord', '$recy_metal', '$recy_cristal'
						)";
					$db->sql_query($query);
					
					//On met le message de validation
					echo"<blink><font color='#00FF40'><big>Votre rapport de recyclage a bien été enregistré !!!</big></font></blink><br><br>";
					
					//On ajoute l'action dans le log
					$line = $user_data[user_name]." ajoute un recyclage dans le module guerres";
					$fichier = "log_".date("ymd").'.log';
					$line = "/*".date("d/m/Y H:i:s").'*/ '.$line;
					write_file(PATH_LOG_TODAY.$fichier, "a", $line);
				}
				else
				{
					//On met le message de non validation
					echo"<blink><font color='#FFF0000'><big>Ce rapport de recyclage a déja été enregistré !!!</big></font></blink><br><br>";
				}
			}
		}
	}
	else
	{
		preg_match('#Attaquant\s(.*)#',$pub_rapport,$attaquant);
		preg_match('#Défenseur\s(.*)#',$pub_rapport,$defenseur);
		preg_match('#attaquant\sa\sperdu\sau\stotal\s(\d*)\sunités\.#',$pub_rapport,$pertesA);
		preg_match('#attaquant\sa\sperdu\sau\stotal\s(\d*)\sunités#',$pub_rapport,$pertesD);
		preg_match('#(\d*)\sunités\sde\smétal,\s(\d*)\sunités\sde\scristal\set\s(\d*)\sunités\sde\sdeutérium#',$pub_rapport,$ressources);
		
		$pre_name_A = explode(" (", $attaquant[1]);
		$attaquant[1] = $pre_name_A[0];
		
		$pre_name_B = explode(" (", $defenseur[1]);
		$defenseur[1] = $pre_name_B[0];
		
		//Puis les informations pour les coordonnées
		$pre_coord = strstr($pub_rapport,Défenseur);
		$pre_coord2 = explode("(", $pre_coord);
		$pre_coord3 = explode(")", $pre_coord2[1]);
		$coord_attaque = $pre_coord3[0];
		
		$timestamp = mktime($date[3],$date[4],$date[5],$date[1],$date[2],date('Y'));
		
		//On vérifie que cette attaque n'a pas déja été enregistrée
		$query = "SELECT attack_id FROM ".TABLE_GUERRES_ATTAQUES." WHERE guerres_id='$pub_guerre_id' AND attack_date='$timestamp' AND attack_name_A='$attaquant[1]' AND attack_name_D='$defenseur[1]' AND attack_coord='$coord_attaque'";
		$result = $db->sql_query($query);
		$nb = mysql_num_rows($result);
		
		if ($nb == 0)
		{
			//On insere ces données dans la base de données
			$query = "INSERT INTO ".TABLE_GUERRES_ATTAQUES." ( `attack_id` , `guerres_id` , `attack_date` , `attack_name_A` , `attack_name_D` , `attack_coord` , `attack_metal`, `attack_cristal`, `attack_deut`, `attack_pertes_A`, `attack_pertes_D` )
				VALUES (
					NULL , '$pub_guerre_id', '$timestamp', '$attaquant[1]', '$defenseur[1]', '$coord_attaque', '$ressources[1]', '$ressources[2]', '$ressources[3]', '$pertesA[1]', '$pertesD[1]'
				)";
			$db->sql_query($query);
			
			//On met le message de validation
			echo"<blink><font color='#00FF40'><big>Votre rapport de combat a bien été enregistré !!!</big></font></blink><br><br>";
			
			//On ajoute l'action dans le log
			$line = $user_data[user_name]." ajoute une attaque dans le module guerres";
			$fichier = "log_".date("ymd").'.log';
			$line = "/*".date("d/m/Y H:i:s").'*/ '.$line;
			write_file(PATH_LOG_TODAY.$fichier, "a", $line);
		}
		else
		{
			//On met le message de non validation
			echo"<blink><font color='#FF0000'><big>Cette attaque à déja été enregistrée !!!</big></font></blink><br><br>";
		}
	}
}

//Requete pour afficher la liste des guerres
$query = "SELECT guerre_id, guerre_ally_1, guerre_ally_2 FROM ".TABLE_GUERRES_LISTE." ORDER BY guerre_id ASC";
$result = $db->sql_query($query);

//Création du field pour selectionner la guerre
echo"<fieldset><legend><b><font color='#0080FF'> Selectionnez une guerre </font></b></legend>";
echo"Selectionnez la guerre pour laquelle vous souhaitez ajouter une attaques ou un recyclage :";
echo"<br>";
echo"<br>";
echo"<form action='index.php' method='post'><input type='hidden' name='action' value='guerres'><input type='hidden' name='page' value='Ajouter une attaque'>";
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
	
	if($pub_guerre == 0) 
	{
		echo"<hr width='325px'>";
		echo"<p align='center'>Mod Guerres | Version 0.2e | <a href='mailto:verite@ogsteam.fr'>Vérité</a> |© 2006</p>";
		
		//Insertion du bas de page d'OGSpy
		require_once("views/page_tail.php");
		exit;
	}
	//Requete pour afficher la liste des guerres
	$query = "SELECT guerre_id, guerre_ally_1, guerre_ally_2 FROM ".TABLE_GUERRES_LISTE." WHERE guerre_id=".$pub_guerre."";
	$result = $db->sql_query($query);
	
	list($guerre_id, $guerre_ally_1, $guerre_ally_2) = $db->sql_fetch_row($result);
	
	//Création du field pour Ajouter une nouvelles attaque
	echo"<fieldset><legend><b><font color='#0080FF'>Ajouter une nouvelle attaque ou recyclage";
	echo"</font></b></legend>
	<table width='70%' align='center'>
	<tr>
	<td align='center'><font color='FFFFFF'><big><big>Pour ajouter une nouvelle attaque ou recyclage, copiez un rapport de combat, puis collez le ci-dessous.
	<br>
	Attention ne postez pas un rapport de combat et un rapport de recyclage en même temps.
	<br>
	<br>
	</big></big>
	<form action='index.php' method='post'><input type='hidden' name='action' value='guerres'><input type='hidden' name='page' value='Ajouter une attaque'><input type='hidden' name='guerre_id' value='$guerre_id'>
	</font></td>
	</tr>
	<tr>
	<td><p>
	<textarea rows='6' name='rapport' id='rapport' cols='25' onFocus='clear_box()'>Vous allez ajouter une attaque ou un recyclage pour la guerre ".$guerre_ally_1." vs ".$guerre_ally_2."</textarea></p></td>
	</tr>
	<tr>
	<td align='center'><p><input type='submit' value='Ajouter'></form></td>
	</tr>";
	echo"</table>";
	echo"</fieldset>";
	echo"<br><br>";
}

echo"<hr width='325px'>";
echo"<p align='center'>Mod Guerres | Version ".$mod_version." | <a href='mailto:verite@ogsteam.fr'>Vérité</a> |© 2006</p>";

//Insertion du bas de page d'OGSpy
require_once("views/page_tail.php");
?>
