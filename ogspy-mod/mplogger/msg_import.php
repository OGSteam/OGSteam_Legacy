<?
/**
 * mpc_import.php 

Importation d'un message

 * @package MP_Logger
 * @author Sylar
 * @link http://www.ogsteam.fr
 * @version : 0.1
 * dernière modification : 16.10.07
 * Module de capture des messages entre joueurs
 */
// L'appel direct est interdit
//if (!defined('IN_SPYOGAME')) die("Hacking attempt");

include("mpl_includes.php");

// Renvoi les message d'un joueur $userID
function send_message_from_game($chaine,$fp="")
{
	global $db,$user_data;
	$retour=0;
	$motif = "#((\d{2})\-(\d{2}) (\d{2}):(\d{2}):(\d{2})\s(.*))#si";
	preg_match_all($motif, $chaine,$out);
	//on verifie si le mois en cours est inferieur au mois du sondage (pour eviter le bug du changement d année)
	$year = date('Y');
	if(date('m') < $out[2][0])	$year -= 1; 
	$datadate = mktime($out[4][0],$out[5][0],$out[6][0],$out[2][0],$out[3][0],$year);
	$texte = explode("|",$out[7][0]);
	$expediteur = $texte[0];
	$contenu = trim(str_replace("'","\'",$texte[1]));
	$motif = "#((.*)\])\s(.*)\s#si";
	preg_match_all($motif, $expediteur,$out);
	$expediteur = trim($out[1][0]);
	$titre = trim($out[3][0]);
	$retour = 2;
	$query = "SELECT id FROM ".TABLE_MPC." WHERE sender_id='".$user_data['user_id']."' AND datadate='".$datadate."' AND expediteur='".$expediteur."' ";
	$result = $db->sql_query($query);
	$nb = $db->sql_numrows($result);
	if ($nb == 0 && $expediteur!="" && $titre!=""){	// et que le rapport n'existe pas deja ou que la capture a éhcouée
		$query = "INSERT INTO ".TABLE_MPC." ( `id` , `sender_id` ,`datadate`, `expediteur` , `titre` , `contenu`) VALUES ( NULL, '".$user_data['user_id']."' , '".$datadate."', '".$expediteur."', '".$titre."', '".$contenu."' 	)";
		$result = $db->sql_query($query);
		$retour = 1;
	}
	if (defined("XTENSE_PLUGIN_DEBUG")&&$fp) fwrite($fp, "send_message_from_game($expediteur, $titre, date=$datadate) = ".(($retour==1)?'OK':($retour==2)?'DOUBLON':'ERREUR')."\n");
	return $retour;
}

 ?>