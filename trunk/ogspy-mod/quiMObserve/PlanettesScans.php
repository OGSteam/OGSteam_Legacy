<?php
/**
* index.php 
 * @package QuiMobserve
 * @author Santory
 * @link http://www.ogsteam.fr
 * @version : 0.1e
 */

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='QuiMobserve' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

define("TABLE_QUIMOBSERVE", $table_prefix."MOD_quimobserve");
//On vérifie les paramêtre
if(substr_count($pub_planeteEs,':')==2 && substr_count($pub_planeteMa,':')==2 && is_numeric($pub_periodes) ){

	$SaPlanete = split(':',$pub_planeteEs);
	$MaPlanete = split(':',$pub_planeteMa);
	if( is_numeric($SaPlanete[0]) && is_numeric($SaPlanete[1]) && is_numeric($SaPlanete[2]) && is_numeric($MaPlanete[0])&& is_numeric($MaPlanete[1])&& is_numeric($MaPlanete[2])){
		// recuperer les info sur la planete espion
		$query = "SELECT `name`, `player` FROM ".TABLE_UNIVERSE." WHERE `galaxy`= '".$SaPlanete[0]."' AND `system` = '".$SaPlanete[1]."' AND `row` ='".$SaPlanete[2]."'";
		$result=$db->sql_query($query);
		list($NomPlanet,$player)=$db->sql_fetch_row($result);
		// recuperer les info sur sa planete
		$query = "SELECT `name` FROM ".TABLE_UNIVERSE." WHERE `galaxy`= '".$MaPlanete[0]."' AND `system` = '".$MaPlanete[1]."' AND `row` ='".$MaPlanete[2]."'";
		$result=$db->sql_query($query);
		list($NomPlanet2)=$db->sql_fetch_row($result);

		if($player == ''){
			$player = "Inconnu";
		}

		// recuperer les scans
	  $timestamp = time()-(24*60*60*$pub_periodes);
	  $datadate = mktime (0,0,0,date("m",$timestamp),date("d",$timestamp),date("y",$timestamp));
		$query = "SELECT `datadate`, `pourcentage` FROM `".TABLE_QUIMOBSERVE."` WHERE `datadate` >= $datadate and `sender_id` = ".$user_data['user_id']."
							AND `spy_planetteEspion` = '".$pub_planeteEs."' AND `spy_maplanette` = '".$pub_planeteMa."' ORDER BY `datadate` asc ";
		$result=$db->sql_query($query);

		// affichage des scanns
		echo "<fieldset><legend><b><font color='#0080FF'>Info</font></b></legend>";	
		echo "<font size=\"2\">";
		echo "La planète <b>$NomPlanet</b> [$pub_planeteEs] de <b>$player</b> vous a scanné la planète <b>$NomPlanet2</b> [$pub_planeteMa] les :<br />";
		$flux = "";
		while(list($datadate, $pourcentage)=$db->sql_fetch_row($result)){
			$flux .= date("Y-m-d H:i:s", $datadate)." (".$pourcentage."%)<br />";
		}
		echo $flux;
		echo "</font>";	
		echo "</fieldset>";
			
	}else{
		error();
	}
}else{
	error();
}

function error(){
	echo "<fieldset><legend><b><font color='#FF0000'>Error</font></b></legend>";	
	echo "<font size=\"2\" color=\"#FF0000\">";
	echo "Paramètre incorrect.";
	echo "</font>";	
	echo "</fieldset>";
}
?>