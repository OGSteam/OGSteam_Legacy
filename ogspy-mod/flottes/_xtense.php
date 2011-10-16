<?php
/***************************************************************************
*   filename    : _xtense.php
*   desc.       : liaison avec xtense2
*   Author      : AirBAT
*   created     : 19/04/2008
*   by          : AirBAT
*   modified    : -
*   last modif. : created
***************************************************************************/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");


if(class_exists("Callback")){
	class flottes_Callback extends Callback {
		public $version = '2.3.9';
		public function flottes_import_fleet($rapport){
			global $io;
			if(flottes_import_fleet($rapport))
				return Io::SUCCESS;
			else
				return Io::ERROR;
		}
		public function getCallbacks() {
			return array(
				array(
					'function' => 'flottes_import_fleet',
					'type' => 'fleet'
				)
			);
	   }
	}
}


// TEST XTENSE2
global $xtense_version, $table_prefix;
$xtense_version = "2.3.9";

// Definitions
define("TABLE_MOD_FLOTTES", $table_prefix."mod_flottes");
define("TABLE_MOD_FLOTTES_ADM", $table_prefix."mod_flottes_admin");

function flottes_import_fleet($fleet) {

    global $user_data;
    //dump($fleet);
    return flottes_import($user_data['user_id'], $fleet['coords'], $fleet['planet_name'], $fleet['planet_type'], $fleet['fleet']);

}

function flottes_import($user_id, $coords, $planet_name, $planet_type, $fleet) {
    
    global $db;
    
    // Les coordonnees sous forme de chaïne
    $coord = $coords[0].":".$coords[1].":".$coords[2];
    // Le Timestamp pour l'enregistrement
    $datei = mktime(0, 0 , 0, date("m"), date("d"), date("Y"));
    $action = home_check($planet_type, $coord);
    //dump($action);
    
    $request="SELECT planet_id from ".TABLE_MOD_FLOTTES." WHERE planet_id=".$action['id']." AND user_id=".$user_id;

    if($db->sql_numrows($db->sql_query($request)) != 0)
        return update_fleet($user_id, $action['id'], $planet_name, $coord, $datei, $fleet);
    else
        return add_fleet($user_id, $action['id'], $planet_name, $coord, $datei, $fleet);
    
    // Jamais atteint
    return FALSE;
}

function add_fleet($user_id, $planet_id, $planet_name, $coord, $time, $fleet) {

    global $db;
    
    $request = "INSERT INTO ".TABLE_MOD_FLOTTES." (user_id, planet_id) VALUES (".$user_id.",  ".$planet_id." )" ;
    if(!($result = $db->sql_query($request))) {
        return FALSE;
    }
    
    return update_fleet($user_id, $planet_id, $planet_name, $coord, $time, $fleet);
}

function update_fleet($user_id, $planet_id, $planet_name, $coord, $time, $fleet) {

    global $db;
    
    $request = "UPDATE ".TABLE_MOD_FLOTTES." SET";
    foreach($fleet as $key => $value) {
        switch ($key) {
            case "RE":
                $request .= " `REC`=".$value.", ";
                break;
            case "BM":
                $request .= " `BMD`=".$value.", ";
                break;
            case "DE":
                $request .= " `DST`=".$value.", ";
                break;
            case "TR":
                $request .= " `TRA`=".$value.", ";
                break;
            case "SS":
                $request .= " `SAT`=".$value.", ";
                break;
            default:
                $request .= " `".$key."`=".$value.", ";
        }
    }
    
    $request .=" `planet_name`='".$planet_name."', ";
    $request .=" `coordinates`='".$coord."', ";
    $request .=" `date`=".$time;
    $request .=" WHERE user_id=".$user_id;
    $request .=" AND planet_id=".$planet_id;
    //dump($request);
    $db->sql_query($request);

    return TRUE;
}

// Ajout automatique du callback par xtense
function flottes_get_callbacks() {

    return array(
        array(
        'function' => 'flottes_import_fleet',
        'type' => 'fleet',
        'active' => 1
        )
    );

}
?>
