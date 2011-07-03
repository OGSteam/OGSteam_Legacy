<style type="text/css">
@import url("./mod/flottes/style.css");
</style>

<?php
/***************************************************************************
*    filename    : function_flottes.php
*    desc.       : 1.0.3
*    Link        : http://www.ogsteam.fr 
*    Author      :  Conrad des Dragons
*    created     : 
*    modified    : AirBAT
***************************************************************************/
//secu
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
// fin de secu

// insertion du langage flotte
require_once("./mod/flottes/flottes_lang.php");

// Fonctions
function mod_flottes_get_ship($ship, $add=false) {
	$user_empire = user_get_empire();
	$user_building = $user_empire["building"];
// FLOTTESTOEMPIRE ajout de $table_prefix dans global
	global $user_data, $mod_flottes_lang, $db,$members_data,$table_prefix;

	$lines = array();
	$ship = stripcslashes($ship);
	$ship =str_replace("PT-5","PT",$ship );
	$ship =str_replace("GT-50","GT",$ship );
	$lines = explode(chr(10), $ship);
	$datei= mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
	$OK = false;
	$out="";
	$get_ship = array("PT" => 0, "GT" => 0, "CLE" => 0, "CLO" => 0, "CR" => 0, "VB" => 0, "VC" => 0, "REC" => 0, "SE" => 0, "BMD" => 0, "DST" => 0, "EDLM" => 0, "TRA" =>0, "SAT" =>0);

	foreach ($lines as $line) {
		$arr = array();
		$line = trim($line);

		if(strpos($line, "Type de vaisseau") === 0 ) {
			$OK = true;
			continue;
		}

		// On enlève le séparateur décimal
		$line = str_replace('.', '', $line);

		if($OK && preg_match("/^([\D\s]+)\s+(\d+)/", $line, $arr)) {
			foreach($mod_flottes_lang as $key => $name) {
				if($name==trim($arr[1])) {
					$get_ship[$key] = $arr[2];
					break;
				}
			}
			continue;
		}
	}

	if ($get_ship["SAT"]==0)
	{
		$get_ship["SAT"]=$user_building[$_POST['planet_id']]["Sat"];
	}

	if($add) {
		if (isset($_POST['planet_id'])){
			$request = "DELETE FROM ".TABLE_MOD_FLOTTES." WHERE user_id=".$user_data['user_id']." AND planet_id=".$_POST['planet_id'];

			if(!($result = $db->sql_query($request))) {
				$out = "Erreur de base de donnée";
				echo  $out;
			}

			else $result = $db->sql_query($request);
		}

		else {
			$out = "selectionnez une planète.";
		}

	}

	else
	{
		$request = "UPDATE ".TABLE_MOD_FLOTTES." SET ".TABLE_MOD_FLOTTES.".planet_id=(SELECT ".TABLE_USER_BUILDING.".planet_id FROM ".TABLE_USER_BUILDING." WHERE ";
		$request .=TABLE_USER_BUILDING.".planet_name=".TABLE_MOD_FLOTTES.".planet_name AND ";
		$request .=TABLE_USER_BUILDING.".coordinates=".TABLE_MOD_FLOTTES.".coordinates AND ";
		$request .=TABLE_USER_BUILDING.".user_id=".TABLE_MOD_FLOTTES.".user_id )";
		$request .="  WHERE ".TABLE_MOD_FLOTTES.".user_id=".$user_data['user_id']." " ;

		if(!($result = $db->sql_query($request))) {
			$out = "Erreur de base de donnée";
			echo  $out;
		}

		$sql="SELECT planet_id from ".TABLE_MOD_FLOTTES." WHERE planet_id=".$_POST['planet_id']." AND user_id=".$user_data['user_id'];

		if(!($result = mysql_query($sql))) 
		{
			$out .= "selectionnez une planète.";
        }

		else 
        {
			$result = $db->sql_query($sql);
			$nameid=mysql_num_rows($result) ;

			if ($nameid==1)
			{
				$request = "UPDATE ".TABLE_MOD_FLOTTES." SET";
				foreach($get_ship as $key => $value) 
				{
					$request .= " `".$key."`=".$value.", ";
				}

				if (isset($user_building[$_POST['planet_id']]["planet_name"])& $user_building[$_POST['planet_id']]["planet_name"]!='')
				{
					$nom_planet=$user_building[$_POST['planet_id']]["planet_name"];
					$coord_planet=$user_building[$_POST['planet_id']]["coordinates"];
				}

				else 
				{
					$nom_planet=$_POST['planet_id'];
					$coord_planet="0";
				}

				if ($coord_planet=="" or $coord_planet==NULL) $coord_planet="0";

				$request .=" `planet_name`='".$nom_planet."', ";
				$request .=" `coordinates`='".$coord_planet."', ";
				$request .=" `date`=".$datei;
				$request .= " WHERE user_id=".$user_data['user_id'];
				$request .=" AND planet_id=".$_POST['planet_id'];
				$db->sql_query($request);
				$request= "DELETE FROM ".TABLE_MOD_FLOTTES." WHERE planet_id=0";
				$db->sql_query($request);
			}

			else 
			{
				$request = "INSERT INTO ".TABLE_MOD_FLOTTES." (user_id, planet_id) VALUES (".$user_data['user_id'].",  ".$_POST['planet_id']." )" ;

				if(!($result = $db->sql_query($request))) 
				{
					$out = "selectionnez une planète.";
				}

				else 
				{
					if (isset($user_building[$_POST['planet_id']]["planet_name"])& $user_building[$_POST['planet_id']]["planet_name"]!='')
					{
						$nom_planet=$user_building[$_POST['planet_id']]["planet_name"];
						$coord_planet=$user_building[$_POST['planet_id']]["coordinates"];
					}

					else 
					{
						$nom_planet=$_POST['planet_id'];
						$coord_planet="0";
					}

					if ($coord_planet=="" or $coord_planet==NULL) $coord_planet="0";

					$request = "UPDATE ".TABLE_MOD_FLOTTES." SET planet_name ='".$nom_planet."'";
					$request .=", coordinates='".$coord_planet."'";
					$request .=", date=".$datei;
					$request .= " WHERE user_id=".$user_data['user_id'];
					$request .=" AND planet_id=".$_POST['planet_id'];
					$db->sql_query($request);
					$request = "UPDATE ".TABLE_MOD_FLOTTES." SET";

					foreach($get_ship as $key => $value) 
					{
						$request .= " `".$key."`=".$value.", ";
					}

					$request = substr($request, 0, strlen($request)-2);
					$request .= " WHERE user_id=".$user_data['user_id'];
					$request .=" AND planet_id=".$_POST['planet_id'];
					$db->sql_query($request);
					$request= "DELETE FROM ".TABLE_MOD_FLOTTES." WHERE planet_id=0";
					$db->sql_query($request);
				}
			}		
		}
	}
}

function buttons_bar($subaction)
{
	global $user_data;
    
    // mise en place de la banniere
    echo '<table class="flottes_h">';
    echo '<tr>';
    echo '<td class="flottes_h">Mod Flottes</td>';
    echo '</tr>';
    echo '</table>';

    // mise en place du menu
	echo '<table class="menu">';
	echo '<tr align="center">';

	// ------------------------

	//  BOUTON Insertion
		if ($subaction == "insert"){
			echo '<td class="menu_on" width="12.5%">Insertion de flotte</td>'."\n";
		}
		else 
		{
			echo '<td class="menu_off" width="12.5%" onclick="window.location = \'index.php?action=flottes&subaction=insert\';">'."\n";
			echo 'Insertion de flotte'."\n";
			echo '</td>'."\n";
		}
	// ------------------------

	//  BOUTON Flottes
		if (($subaction == "flottes")||(!isset($subaction))){
			echo '<td class="menu_on" width="12.5%">Flottes</td>'."\n";
		}
		else 
		{
			echo '<td class="menu_off" width="12.5%" onclick="window.location = \'index.php?action=flottes&subaction=flottes\';">'."\n";
			echo 'Flottes'."\n";
			echo '</td>'."\n";
		}
	// ------------------------

	//  BOUTON BBCode
		if ($subaction == "bbcode"){
			echo '<td class="menu_on" width="12.5%">Export BBCode</td>'."\n";
		}
		else 
		{
			echo '<td class="menu_off" width="12.5%" onclick="window.location = \'index.php?action=flottes&subaction=bbcode\';">'."\n";
			echo 'Export BBCode'."\n";
			echo '</td>'."\n";
		}
	// ------------------------

    //  BOUTON BBCode 2
        if ($subaction == "bbcode2"){
            echo '<td class="menu_on" width="12.5%">Export BBCode Détaillé</td>'."\n";
        }
        else 
        {
        echo '<td class="menu_off" width="12.5%" onclick="window.location = \'index.php?action=flottes&subaction=bbcode2\';">'."\n";
        echo 'Export BBCode Détaillé'."\n";
        echo '</td>'."\n";
        }
    // ------------------------

	//  BOUTON MyBB
 		if ($subaction == "mybb"){
 			echo '<td class="menu_on" width="12.5%">Export MyBB Détaillé</td>'."\n";
 		}
 		else 
 		{
 			echo '<td class="menu_off" width="12.5%" onclick="window.location = \'index.php?action=flottes&subaction=mybb\';">'."\n";
 			echo 'Export MyBB Détaillé'."\n";
 			echo '</td>'."\n";
 		}
 	// ------------------------

	//  BOUTON Graphe
		if ($subaction == "graphe"){
			echo '<td class="menu_on" width="12.5%">Graphe de répartition de flotte</td>'."\n";
		}
		else 
		{
			echo '<td class="menu_off" width="12.5%" onclick="window.location = \'index.php?action=flottes&subaction=graphe\';">'."\n";
			echo 'Graphe de répartition de flotte'."\n";
			echo '</td>'."\n";
		}
	// ------------------------

	//  BOUTON Admin
	if($user_data["user_admin"] == 1 ){
		if ($subaction == "admin"){
			echo '<td class="menu_on" width="12.5%">Administration</td>'."\n";
		}
		else 
		{
			echo '<td class="menu_off" width="12.5%" onclick="window.location = \'index.php?action=flottes&subaction=admin\';">'."\n";
			echo 'Administration'."\n";
			echo '</td>'."\n";
		}
	}
    // ------------------------
    
    //  BOUTON Xtense2
    if($user_data["user_admin"] == 1 ){
        if ($subaction == "xtense2"){
            echo '<td class="menu_on" width="12.5%">Xtense2</td>'."\n";
        }
        else 
        {
            echo '<td class="menu_off" width="12.5%" onclick="window.location = \'index.php?action=flottes&subaction=xtense2\';">'."\n";
            echo 'Xtense2'."\n";
            echo '</td>'."\n";
        }
    }
	echo '</tr>'."\n";
	echo '</table>'."\n";
}
// fin du menu
// ------------------------

function sauve_color($TCF,$TCFO,$TCFU,$TCFP,$TCFA,$TCB1,$TCB2,$TCB3,$TCB4,$TCB5,$TGA,$TPLA){

	global $db;

	$request = "UPDATE ".TABLE_MOD_FLOTTES_ADM." SET color_fleet='".$TCF."', color_fleet_old='".$TCFO."', color_fleet_user='".$TCFU."', ";
	$request .="color_fleet_point='".$TCFP."', color_fleet_alli='".$TCFA."', ";
	$request .="color_bbc_1='".$TCB1."', color_bbc_2='".$TCB2."', color_bbc_3='".$TCB3."', color_bbc_4='".$TCB4."', color_bbc_5='".$TCB5."',  ";
	$request .="GAME='".$TGA."', nbpla='".$TPLA."'  ";
	$request .="WHERE group_name='mod_flottes'";

	if($result = $db->sql_query($request)) {
		$out="Couleurs mises à jour";
		}

	else {
		$out = "selectionnez une planète.";
	}
	echo  $out;
}

function compte_planet($iduser,$nbpla,$game){

    // FLOTTESTOEMPIRE ajout de $table_prefix dans global

	global $user_data, $mod_flottes_lang, $db,$members_data,$table_prefix;
	
	if (!isset($nbpla) || $nbpla==0) $nbpla=$nb_planet;

	$request = "select planet_id ";
    $request .= " from " . TABLE_USER_BUILDING;
    $request .= " where user_id = " . $iduser;
    $request .= " and planet_id < 299 ";
    $request .= " order by planet_id";

    $result = $db->sql_query($request);

    $nbplanet = $db->sql_numrows($result);

	if ($nbplanet<$nbpla) { 
		 $page=0;
	}

	elseif( $game=='OGAME')  {
		$page=1;
	}

	else {
		$page=floor($nbplanet/$nbpla);
	}

	$nbpla++;
	$col=floor($nbpla/($page+1));
	$affpla=array($nbplanet,$page,$col,$nbpla);
	return $affpla;
}

function active_xtense2($act) {
    
    global $db, $table_prefix;
    
    define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");
    define("TABLE_MOD", $table_prefix."mod");
    
    if ($act == "active"){
        $q_modid = 'SELECT `id` FROM `'.TABLE_MOD.'` WHERE `title`="Flottes" LIMIT 1';
        $r_modid = $db->sql_query($q_modid);
        $r_modid1 = $db->sql_fetch_row($r_modid);
        $mod_id = $r_modid1[0];
        $db->sql_query("INSERT INTO ".TABLE_XTENSE_CALLBACKS." (mod_id, function, type, active) VALUES ('$mod_id', 'flottes_import_fleet', 'fleet', 1)");
    }

    if ($act == "desactive"){
        $q_modid = 'SELECT `id` FROM `'.TABLE_MOD.'` WHERE `title`="Flottes" LIMIT 1';
        $r_modid = $db->sql_query($q_modid);
        $r_modid1 = $db->sql_fetch_row($r_modid);
        $mod_id = $r_modid1[0];
        $db->sql_query("DELETE FROM ".TABLE_XTENSE_CALLBACKS." WHERE `mod_id`='$mod_id'");
    }

}
?>