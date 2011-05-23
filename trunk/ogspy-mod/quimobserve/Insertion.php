<?php
/**
* Insertion.php 
 * @package QuiMobserve
 * @author Santory
 * @link http://www.ogsteam.fr
 * @version : 0.1d
 */

// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//On v�rifie que le mod est activ�
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='QuiMobserve' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

//D�finitions
global $db;
global $table_prefix;
define("TABLE_QUIMOBSERVE", $table_prefix."MOD_quimobserve");
define("TABLE_QUIMOBSERVE_ARCHIVE", $table_prefix."MOD_quimobserve_archive");
require_once("mod/QuiMObserve/help.php");

// Fonction d'archivage des ancien raport
function archive($jours){
  global $db;
  global $table_prefix;
  global $user_data;

	// On recupere le timestamp du 1er du mois etant la limite de conservation a 0:00:00
  $timestamp = time()-(24*60*60*$jours);
  $timestamp = mktime(0, 0, 0, date("m",$timestamp), 1, date("y",$timestamp) );

	//On recupere les raport plus vieux
  $query = "SELECT `spy_planetteEspion`, `spy_maplanette`, `sender_id`, count(*), FROM_UNIXTIME(`datadate`, '%Y%m') as `datadate2` FROM ".TABLE_QUIMOBSERVE." WHERE `datadate` < ".$timestamp." and `sender_id` = ".$user_data['user_id']." GROUP BY `spy_planetteEspion`, `spy_maplanette`, `datadate2`";
	$result=$db->sql_query($query);
  if($db->sql_numrows($result) > 0){
		//on stoque les nombres d'espionage par planette dans la tabla archive
    while (list($spy_planetteEspion, $spy_maplanette, $sender_id, $num, $datadate) = $db->sql_fetch_row($result)){
      $query = "INSERT INTO `".TABLE_QUIMOBSERVE_ARCHIVE."` ( `spy_id_archive` , `spy_planetteEspion` , `spy_maplanette` , `number` , `sender_id` , `datadate` )
								VALUES (
									NULL , '".$spy_planetteEspion."', '".$spy_maplanette."', '".$num."' , '".$user_data['user_id']."', '".$datadate."'
							);";
		  $db->sql_query($query);
    }  	
		//on efface tous c'est vieux raport
    $query = "DELETE FROM ".TABLE_QUIMOBSERVE." WHERE `datadate` < ".$timestamp." and `sender_id` = ".$user_data['user_id'] ;
    $db->sql_query($query);  
  } 
}

// on lance la fonction gerant les archive.
$jours_archive = 60;
archive($jours_archive);

//fonction inserant un raport
function insert_raport_espionage($pub_espionage,$date,$pourcentage){
  global $db;
  global $table_prefix;
  global $user_data;
	$retour="";
  preg_match('#Une\sflotte\sennemie\sde\sla\splan�te(.*?)\[(.*?)\]\sa\s�t�\saper�ue\s�\sproximit�\sde\svotre\splan�te(.*?)\[(.*?)\]#',$pub_espionage,$planettes);

  //On v�rifie que ce sondage n'a pas d�ja �t� enregistr�e
	$query = "SELECT spy_id FROM ".TABLE_QUIMOBSERVE." WHERE sender_id='".$user_data['user_id']."' AND datadate='".$date."' AND spy_planetteespion='".$planettes[2]."' ";

	$result = $db->sql_query($query);
	$nb = $db->sql_numrows($result);
	if ($nb == 0)
	{
	//On insere ces donn�es dans la base de donn�es
		$query = "INSERT INTO ".TABLE_QUIMOBSERVE." ( `spy_id` , `spy_planetteespion` , `spy_maplanette` , `sender_id` , `datadate`,  `pourcentage`)
			VALUES (
				NULL , '".$planettes[2]."', '".$planettes[4]."', '".$user_data['user_id']."', '".$date."', '".$pourcentage."' 
			)";
		$db->sql_query($query);
		
		//On met le message de validation
		$valid='Enregistrement du raport du '.strftime("%d %b %Y %Hh", $date).' effectu�.<br/>';
	
	}
	else
	{
		//On met le message de non validation
		$nonvalid='Vous avez d�ja enregistr�e le rapport d\'espionnages du '.strftime("%d %b %Y %Hh", $date).'. <br/>';
	}

  //Insertion du message de validation si d�fini
  if (isset($valid))
  {
    $retour ="<font color='00FF40' size=\"2\">".$valid."</font>";
  }
  //Insertion du message de non validation si d�fini
  if (isset($nonvalid))
  {
	  $retour = "<font color='FF0000' size=\"2\">".$nonvalid."</font>";
  }
  return($retour);
}



//Fonction d'ajout d'un rapport de combat
if (isset($pub_espionage))
{
	$pub_espionage = mysql_real_escape_string($pub_espionage);
  $pub_espionage = trim($pub_espionage);
	
	//Compatibilit� UNIX/Windows
	$pub_espionage = str_replace("\r\n","\n",$pub_espionage);
	//Compatibilit� IE/Firefox
	$pub_espionage = str_replace("\t",' ',$pub_espionage);
	
  $retour = "";
	//on recupere un tableau avec tous les raports.
  preg_match_all("#((\d{2})\-(\d{2}) (\d{2}):(\d{2}):(\d{2})\s+Contr�le\sa�rospatial(.*?)Probabilit�\sde\sdestruction\sde\sla\sflotte\sd(.*?)espionnage\s:\s(\d+)\s%)#si", $pub_espionage,$matches);
  foreach ($matches[1] as $key => $val){
		//on verifie si le mois en cours est inferieur au mois du sondage (pour eviter le bug du changement d ann�e)
		$year = date('Y');
		if(date('m') < $matches[2][$key]){
			$year -= 1; 
		}
		$timestamp = mktime($matches[4][$key],$matches[5][$key],$matches[6][$key],$matches[2][$key],$matches[3][$key],$year);
    $retour .= insert_raport_espionage($val,$timestamp,$matches[9][$key]);
  }
}
echo"<fieldset><legend><b><font color='#0080FF'>Ajouter un rapport d'espionnages";
echo help("ajouter_espionage");
if(!isset($pub_insert)) {
echo"</font></b></legend>
    <table width='65%' align='center'>
    <tr>
    <td align='center'><font color='FFFFFF' size=\"2\">Pour ajouter un nouvel espionnage, copiez un rapport d'espionnage, puis collez-le ci-dessous : 
    </font></td>
    </tr>
    <tr>
    <td><p><form action='index.php' method='post'><input type='hidden' name='action' value='Quimobserve'><textarea rows='6' name='espionage' cols='25'></textarea></p></td>
    </tr>
    <tr>
    <td align='center'><p><input type='submit' value='Ajouter'></form></td>
    </tr>";
}else{
echo"</font></b></legend>
    <table width='65%' align='center'>
    <tr>
    <td align='center'><font color='FFFFFF' size=\"2\">Pour ajouter un nouvel espionnage, collez-le ici : </font></td>
    <td><p><form action='index.php' method='post'><input type='hidden' name='action' value='Quimobserve'><textarea rows='1' name='espionage' cols='25'></textarea></p></td>
    <td align='center'><p><input type='submit' value='Ajouter'></form></td>
    </tr>";
}

//Insertion du message de validation si d�fini
if (isset($retour))
{
	echo"<tr><td align='center'><blink>$retour</blink>";
	echo"</td></tr>";
}
echo"</table></fieldset>";
?>