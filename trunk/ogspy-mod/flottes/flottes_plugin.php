<?php
/***************************************************************************
*	filename	: flottes_plugin.php
* @package Flottes 1.03
* @author Conrad des Dragons
*	created		: 19/12/2005
*	modified	: 30/07/2006 00:00:00
***************************************************************************/
/*
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
*/
/*
* fonction import par plugin
*/

function mod_flottes_plugin_shipbyid($idplan,$ship) {
	
	global $db, $table_prefix, $user_data;
	define("TABLE_MOD_FLOTTES", $table_prefix."mod_flottes");
	define("TABLE_MOD_FLOTTES_ADM", $table_prefix."mod_flottes_admin");

    if (defined("OGS_PLUGIN_DEBUG")) global $fp;
    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"=> entrée fonction mod_flottes_plugin_shipbyid!\n");
    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"planetid: ".$idplan." - contenu flotte: ".$ship."!\n");
    // $idplan = ID OGSpy de la planète format INT(11) valeurs comprise entre 1 et 18
    // $ship = texte brut écran flotte OGame équivalant au copié - collé classique pour ajouter des donnée dans OGSpy avant le plugin
    $user_empire = user_get_empire();
    $user_building = $user_empire["building"];
    
    require_once("./mod/flottes/flottes_lang.php");

//// Recherche du jeu 
/*
$request= "SELECT GAME, nbpla FROM ".TABLE_MOD_FLOTTES_ADM." WHERE group_name='mod_flottes'";
if($result = $db->sql_query($request)) {
	while($ligne = mysql_fetch_row($result)) {	
		$GA=$ligne[0];
		$PLA=$ligne[1];
	}
}
else {
	$GA='OGAME';
}	

if ($GA=='UNIVERS')
{

*/
/// fin de recherche

    $lines = array();
    $ship = stripcslashes($ship);
    $lines = explode(chr(10), $ship);
    $datei= mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
    $OK = false;
    $out=0;
    $mess="Mise à jour flotte";
    
    $get_ship = array("PT" => 0, "GT" => 0, "CLE" => 0, "CLO" => 0, "CR" => 0, "VB" => 0,
                        "VC" => 0, "REC" => 0, "SE" => 0, "BMD" => 0, "DST" => 0, "EDLM" => 0, "TRA" =>0, "SAT" =>0);
    
    foreach ($lines as $line) {
        $arr = array();
        $line = trim($line);

        if(strpos($line, "Type de vaisseau") === 0 ) {
            $OK = true;
            continue;
        }
        else {
            $out=2;
            $mess = "Ce n'est pas un écran de flotte";
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
    
    $sql="SELECT planet_id from ".TABLE_MOD_FLOTTES." WHERE planet_id=".$idplan." AND user_id=".$user_data['user_id'];
    if(!($result = mysql_query($sql))) {
        $out = 1;
        $mess=mysql_error();
        }    
    else {
        $result = $db->sql_query($sql);
    $nameid=mysql_num_rows($result) ;
    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"=> nameid :".$nameid."\n");
    
    if ($nameid==1)
    {
/// Si la planète existe déjà on met à jour les données
        $request = "UPDATE ".TABLE_MOD_FLOTTES." SET";
        foreach($get_ship as $key => $value) {
            $request .= " `".$key."`=".$value.", ";
        }
//        $request = substr($request, 0, strlen($request)-2);
        if (isset($user_building[$idplan]["planet_name"])& $user_building[$idplan]["planet_name"]!=''){
            $nom_planet=$user_building[$idplan]["planet_name"];
            $coord_planet=$user_building[$idplan]["coordinates"];
        }
        else {
            $nom_planet=$idplan;
            $coord_planet="0";
        }          
        if ($coord_planet=="" or $coord_planet==NULL) $coord_planet="0";
        
        $request .=" `planet_name`='".$nom_planet."', ";
        $request .=" `coordinates`='".$coord_planet."', ";
        $request .=" `date`=".$datei;
        $request .= " WHERE user_id=".$user_data['user_id'];
        $request .=" AND planet_id=".$idplan;
        $db->sql_query($request);
 if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"=> requête :".$request."\n");
    }
    else {
/// Sinon on créé la planète et on met à jour les données    
        $request = "INSERT INTO ".TABLE_MOD_FLOTTES." (user_id, planet_id) VALUES (".$user_data['user_id'].",  ".$idplan." )" ;
        if(!($result = $db->sql_query($request))) {
        $out = 1;
        $mess=mysql_error();
        }
        else {
        if (isset($user_building[$idplan]["planet_name"])& $user_building[$idplan]["planet_name"]!=''){
            $nom_planet=$user_building[$idplan]["planet_name"];
            $coord_planet=$user_building[$idplan]["coordinates"];
        }
        else {
            $nom_planet=$idplan;
            $coord_planet="0";
        }

        if ($coord_planet=="" or $coord_planet==NULL) $coord_planet="0";
        
        $request = "UPDATE ".TABLE_MOD_FLOTTES." SET planet_name ='".$nom_planet."'";
        $request .=", coordinates='".$coord_planet."'";
        $request .=", date=".$datei;
        $request .= " WHERE user_id=".$user_data['user_id'];
        $request .=" AND planet_id=".$idplan;
        $db->sql_query($request);
 if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"=> requête :".$request."\n");

        $request = "UPDATE ".TABLE_MOD_FLOTTES." SET";
        foreach($get_ship as $key => $value) {
            $request .= " `".$key."`=".$value.", ";
        }
        $request = substr($request, 0, strlen($request)-2);
        $request .= " WHERE user_id=".$user_data['user_id'];
                $request .=" AND planet_id=".$idplan;
        $db->sql_query($request);
               
        }
    }
    	$request= "DELETE FROM ".TABLE_MOD_FLOTTES." WHERE planet_id=0";
		$db->sql_query($request);
   
    }
    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"=> sortie fonction mod_flottes_plugin_shipbyid : ".$out."\n");
/// $out = 0 si import OK
/// $out = 1 si n'a pas trouvé la planète    
/// $out = 2 si le texte envoyé ne contient pas 'Type de vaisseau'
/// en cas d'échec, la variable $mess prend la valeur de l'erreur SQL
    return $out;
}

function mod_flottes_plugin_shipbyname($nplan,$ship) {
	
	// $nplan = Texte contenant le nom et les coordonnées de la planète ex: TRUlulu [4:245:3]
	// $ship = texte brut écran flotte OGame équivalant au copié - collé classique pour ajouter des donnée dans OGSpy avant le plugin
	global $db, $table_prefix, $user_data;
	define("TABLE_MOD_FLOTTES", $table_prefix."mod_flottes");
	define("TABLE_MOD_FLOTTES_ADM", $table_prefix."mod_flottes_admin");
	
	if (defined("OGS_PLUGIN_DEBUG")) global $fp;
    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"=> entrée fonction mod_flottes_plugin_ship!\n");
    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"planetid: ".$nplan." - contenu flotte: ".$ship."!\n");
	
	$user_empire = user_get_empire();
	$user_building = $user_empire["building"];
	
	 require_once("mod/flottes/flottes_lang.php");
	//Flotte
	/*
	$flottes_lang["planet_name"]= "Nom Planet";
	$flottes_lang["coordinates"]= "Coordonnées";
	$flottes_lang["planet_id"]= "ID Planet";
	$flottes_lang["PT"] = "Petit transporteur";
	$flottes_lang["GT"] = "Grand transporteur";
	$flottes_lang["CLE"] = "Chasseur léger";
	$flottes_lang["CLO"] = "Chasseur lourd";
	$flottes_lang["CR"] = "Croiseur";
	$flottes_lang["VB"] = "Vaisseau de bataille";
	$flottes_lang["VC"] = "Vaisseau de colonisation";
	$flottes_lang["REC"] = "Recycleur";
	$flottes_lang["SE"] = "Sonde espionnage";
	$flottes_lang["BMD"] = "Bombardier";
	$flottes_lang["DST"] = "Destructeur";
	$flottes_lang["EDLM"] = "Étoile de la mort";
	$flottes_lang["TRA"] = "Traqueur";
	$flottes_lang["SAT"] = "Satellite solaire";
	*/
	
	$lines = array();
	$ship = stripcslashes($ship);
	$lines = explode(chr(10), $ship);
	$datei= mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
	$OK = false;
	$out=0;
	$idplan=0;
	$mess="Mise à jour flotte";
	$namplan=array();
	$coorplan=array();
	$nplan=trim($nplan);
	$valid=0;
/// extraction de l'id planète	
	$patcoor="/[0-9:]{4,8}/";
	$patname="#^[^ ]+\s#";
	
	if(preg_match($patname, $nplan, $namplan)) {
		
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"namplan :".$namplan[0]."-".$valid."-!\n");
		if (substr($namplan[0],0,4)=="lune"){
			$valid=9;
		}
		else $valid=0;
	}
	else {
		$out=1;	
	}
	
	if(preg_match($patcoor, $nplan, $coorplan)) {
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"coorplan :".$coorplan[0]."-".$valid."-!\n");
		for ($i=1 ; $i<=18 ; $i++) {
			$coord = $user_building[$i]["coordinates"];
			if ($coord == $coorplan[0] ) {
				$idplan = $i;
				if ($idplan<10) $idplan=$idplan+$valid;
				break;
			}
		}
	}
	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"idplan :".$idplan."!\n");
//	echo " : ".$namplan[0]." - ".$idplan." - ".$coorplan[0];
/// extraction de la flotte	
	$get_ship = array("PT" => 0, "GT" => 0, "CLE" => 0, "CLO" => 0, "CR" => 0, "VB" => 0,
						"VC" => 0, "REC" => 0, "SE" => 0, "BMD" => 0, "DST" => 0, "EDLM" => 0, "TRA" =>0, "SAT" =>0);
	
	foreach ($lines as $line) {
		$arr = array();
		$line = trim($line);

		if(strpos($line, "Type de vaisseau") === 0 ) {
			$OK = true;
			continue;
		}
		else {
			$out=2;
			$mess = "Ce n'est pas un écran de flotte";
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
	
	$sql="SELECT planet_id from ".TABLE_MOD_FLOTTES." WHERE planet_id=".$idplan." AND user_id=".$user_data['user_id'];
	if(!($result = mysql_query($sql))) {
		$out = 1;
		$mess=mysql_error();
		}	
	else {
		$result = $db->sql_query($sql);
	$nameid=mysql_num_rows($result) ;
	
	if ($nameid==1)
	{
/// Si la planète existe déjà on met à jour les données
		$request = "UPDATE ".TABLE_MOD_FLOTTES." SET";
		foreach($get_ship as $key => $value) {
			$request .= " `".$key."`=".$value.", ";
		}
//		$request = substr($request, 0, strlen($request)-2);
		if (isset($user_building[$idplan]["planet_name"])& $user_building[$idplan]["planet_name"]!=''){
			$nom_planet=$user_building[$idplan]["planet_name"];
			$coord_planet=$user_building[$idplan]["coordinates"];
		}
		else {
			$nom_planet=$idplan;
			$coord_planet="0";
		}
		
		if ($coord_planet=="" or $coord_planet==NULL) $coord_planet="0";
		
		$request .=" `planet_name`='".$nom_planet."', ";
		$request .=" `coordinates`='".$coord_planet."', ";
		$request .=" `date`=".$datei;
		$request .= " WHERE user_id=".$user_data['user_id'];
		$request .=" AND planet_id=".$idplan;
		$db->sql_query($request);
	}
	else {
/// Sinon on créé la planète et on met à jour les données	
		$request = "INSERT INTO ".TABLE_MOD_FLOTTES." (user_id, planet_id) VALUES (".$user_data['user_id'].",  ".$idplan." )" ;
		if(!($result = $db->sql_query($request))) {
		$out = 1;
		$mess=mysql_error();
		}
		else {
			if (isset($user_building[$idplan]["planet_name"])& $user_building[$idplan]["planet_name"]!=''){
				$nom_planet=$user_building[$idplan]["planet_name"];
				$coord_planet=$user_building[$idplan]["coordinates"];
			}
			else {
				$nom_planet=$idplan;
				$coord_planet="0";
			}

			if ($coord_planet=="" or $coord_planet==NULL) $coord_planet="0";
		
			$request = "UPDATE ".TABLE_MOD_FLOTTES." SET planet_name ='".$nom_planet."'";
			$request .=", coordinates='".$coord_planet."'";
			$request .=", date=".$datei;
			$request .= " WHERE user_id=".$user_data['user_id'];
			$request .=" AND planet_id=".$idplan;
			$db->sql_query($request);
	
			$request = "UPDATE ".TABLE_MOD_FLOTTES." SET";
			foreach($get_ship as $key => $value) {
					$request .= " `".$key."`=".$value.", ";
			}
			$request = substr($request, 0, strlen($request)-2);
			$request .= " WHERE user_id=".$user_data['user_id'];
			$request .=" AND planet_id=".$idplan;
			$db->sql_query($request);	
				
		}
	}
		$request= "DELETE FROM ".TABLE_MOD_FLOTTES." WHERE planet_id=0";
		$db->sql_query($request);
	
	}
/// $out = 0 si import OK
/// $out = 1 si n'a pas trouvé la planète	
/// $out = 2 si le texte envoyé ne contient pas 'Type de vaisseau'
/// en cas d'échec, la variable $mess prend la valeur de l'erreur SQL
	return $out;
}

?>
