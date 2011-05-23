<?php
/**
 * qms_plugin.php 

Script d'interconnexion avec la barre d'outils Xtense.

 * @package QuiMSonde
 * @author Sylar
 * @link http://www.ogsteam.fr
 * @version : 1.5c
 * dernière modification : 14.08.08
 * Largement inspiré du formidable mod QuiMObserve de Santory
 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
global $table_prefix;
define("TABLE_QMS", $table_prefix."QuiMeSonde");
define("TABLE_QMS_config", $table_prefix."QuiMeSonde_config");
define("FOLDER_QMS","mod/QuiMSonde");
define("FOLDER_LANG","mod/QuiMSonde/lang");
// Les langues
include(FOLDER_LANG."/lang_french.php");
//-------------------------------------------------------------------------------------------------------------------
// Renvoi le vrai #id du joueur qui s'est fait espionné (dans le cas d'un sitting, c'est pas forcement le même qui est connecté)
function get_real_sender_id($position){
	global $db;
	$query_limit = "SELECT  `user_id`  FROM `".TABLE_USER_BUILDING."` WHERE `coordinates` = '".$position."'";
	$result=$db->sql_query($query_limit);
	list($user_id)=$db->sql_fetch_row($result);
	return $user_id;
}
//-------------------------------------------------------------------------------------------------------------------
// Renvoi la valeur de la configuration "$key"
function get_qms_config($key,$userid=0,$strict=0){
	global $db, $result;
	$where='AND `user_id`= '.$userid;
	$query_limit = "SELECT  `valeur`  FROM `".TABLE_QMS_config."` WHERE `config` = '".$key."' ".$where;
	$result=$db->sql_query($query_limit);
	$nb = $db->sql_numrows($result);
	list($valeur)=$db->sql_fetch_row($result);
	if(!$valeur && $userid!=0 && $strict==0){
		$query_limit = "SELECT  `valeur`  FROM `".TABLE_QMS_config."` WHERE `config` = '".$key."' AND `user_id`= 0";
		$result=$db->sql_query($query_limit);
		$nb = $db->sql_numrows($result);
		list($valeur)=$db->sql_fetch_row($result);
		$count=$db->sql_numrows($result);
	}
	return (!$valeur?false:$valeur);
}
//-------------------------------------------------------------------------------------------------------------------
// Modifie la valeur de la configuration "$key"
function set_qms_config($value,$key,$userid=0){
	global $db;
	$test=get_qms_config($key,$userid,1);
	qms_debug("set_qms_config : La valeur ".$test);
	if($test!=false)
		$query = "UPDATE `".TABLE_QMS_config."` SET `valeur` = '".stripslashes($value)."' WHERE `config`= '".$key."' AND `user_id`= ".$userid;
	else
		$query = "INSERT INTO ".TABLE_QMS_config." ( `user_id`,`config` , `valeur`) VALUES ( '".$userid."' , '".$key."' , '".$value."' )";
	$result=$db->sql_query($query);
	return $result;
}
//----------------------------------------------------------------------------------------------------------------------------------------------------//
function get_coord($position){	// Renvoi le rang de la planète par rapport à une position formatée GG:SS:RR
	$dPoint = strpos($position,":");	
	$galaxy = substr ($position,0,$dPoint);
	$tmp = substr ($position,$dPoint+1);	
	$dPoint2 = strpos($tmp,":");	
	$system = substr($tmp,0,$dPoint2); 	
	$row = substr ($tmp,$dPoint2+1);	
	return array($galaxy,$system,$row); 
}
//----------------------------------------------------------------------------------------------------------------------------------------------------//
function get_user_id($position){	// recupére le nom du joueur et l'alliance d'une certaine position
	global $db;	
	$coord=get_coord($position);
	$player = "?";	
	$ally = "";	
	if($coord[0]&&$coord[1]&&$coord[2]){
		$query_limit = "SELECT  `player` , `ally`  FROM `".TABLE_UNIVERSE."` WHERE `galaxy` = ".$coord[0]." and `system` = ".$coord[1]." and `row` = ".$coord[2];		
		$result=$db->sql_query($query_limit);		
		list($player,$ally)=$db->sql_fetch_row($result);	
	}	
	return array($player,$ally);
}
//-------------------------------------------------------------------------------------------------------------------
function get_distance($depart,$arrive){			// Renvoi la distance entre 2 planètes
	$c_dep=get_coord($depart);
	$c_arr=get_coord($arrive);
	if($c_dep[0]==$c_arr[0])									// De la meme galaxie
		if($c_dep[1]==$c_arr[1])								// Du meme système
			if($c_dep[2]>$c_arr[2])
				$dist=1000+($c_dep[2]-$c_arr[2])*5;		// Distance entre 2 planètes d'un meme systèmes.
			else
				$dist=1000+($c_arr[2]-$c_dep[2])*5; 
		else															// Pas du même système
			if($c_dep[1]>$c_arr[1])
				$dist=2700+($c_dep[1]-$c_arr[1])*95;		// Distance entre 2 systèmes.
			else
				$dist=2700+($c_arr[1]-$c_dep[1])*95;
	else																// Pas la même galaxie.
		if($c_dep[0]>$c_arr[0])
			$dist=($c_dep[0]-$c_arr[0])*20000;				// Distance entre 2 Galaxie.
		else
			$dist=($c_arr[0]-$c_dep[0])*20000; 
	return $dist;
}
//----------------------------------------------------------------------------------------------------------------------------------------------------//
function add_espionnage($string,$fp=""){      // Ajoute un rapport d'espionnage dans la table sql
	global $db, $user_data, $lang;
	//on recupere heure date et probabilité.
	preg_match_all($lang['regex_xtense1_date_heure'], $string,$out);
	//on verifie si le mois en cours est inferieur au mois du sondage (pour eviter le bug du changement d année)
	$year = date('Y');
	if(date('m') < $out[2][0])	$year -= 1; 
	$date = mktime($out[4][0],$out[5][0],$out[6][0],$out[2][0],$out[3][0],$year);
	//on recherche les coordonnées
	$test = preg_match_all($lang['regex_xtense1_coord'],$out[7][0],$position);
	$esp_name = $position[1][0];
	$esp_coor = $position[2][0];
	$cib_name = $position[1][1];
	$cib_coor = $position[2][1];
	if((strlen($esp_coor)+strlen($cib_coor)>=10)){	// si on a bien trouve les position
		$retour = 2;
		$real_sender_id = get_real_sender_id($cib_coor);
		if($real_sender_id==0) $real_sender_id = $user_data['user_id'];
		$query = "SELECT id FROM ".TABLE_QMS." WHERE sender_id='".$real_sender_id."' AND datadate='".$date."' AND position='".$esp_coor."' ";
		$result = $db->sql_query($query);
		$nb = $db->sql_numrows($result);
		if ($nb == 0){	// et que le rapport n'existe pas deja
			$userid=get_user_id($esp_coor);
			if(!$userid[0]) $userid[0]="?";
			// on l'ajoute à la table
			$distance=get_distance($esp_coor,$position[0][1]);
			$query = "INSERT INTO ".TABLE_QMS." ( `id` , `sender_id` , `position` , `position_name`, `joueur`,`alliance`,`distance`,`cible` , `cible_name`,  `datadate`,  `pourcentage`) VALUES ( NULL, '".$real_sender_id."' , '".$esp_coor."', '".$esp_name."', '".$userid[0]."', '".$userid[1]."', '".$distance."', '".$cib_coor."', '".$cib_name."', '".$date."', '".$out[8][0]."' 	)";
			$result = $db->sql_query($query);
			$retour=1;//$result;
		}
	} else $retour = 0;
	if (defined("XTENSE_PLUGIN_DEBUG")&&$fp) 
		fwrite($fp, "add_espionage(".(strlen($position[0][0])+strlen($position[0][1]))."[".$position[0][0]."]".$userid[0]."(".$userid[1].") > [".$position[0][1]."], date=$date,".$out[8][0]."%) = ".(($retour==1)?'OK':(($retour==2)?'DOUBLON':'ERREUR'))."\n");
	return $retour;
}
?>