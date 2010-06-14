<?php
/**
*   _xtense.php - fichier d'interface avec Xtense2
*   @package Attaques
*   @author ericc 
*   @link http://www.ogsteam.fr
*   @version : 0.8e
*   created	: 17/02/2008   
*   modified	: 
**/
// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");


if(class_exists("Callback")){
class Attaques_Callback extends Callback {
        public $version = '2.3.0';
        public function attack_rc($rapport){
			global $io;
			if(attack_rc($rapport))
				return Io::SUCCESS;
			else
				return Io::ERROR;
		}
        public function attack_rr($rapport){
			global $io;
			if(attack_rr($rapport))
				return Io::SUCCESS;
			else
				return Io::ERROR;
		}
        public function getCallbacks() {
                return array(
                        array(
                                'function' => 'attack_rc',
                                'type' => 'rc'
                        ),
                        array(
                                'function' => 'attack_rr',
                                'type' => 'rc_cdr'
                        )
                );
       }
}
}


// Version minimum de Xtense2
$xtense_version="2.3.0";

// Import des Rapports de combats
function attack_rc($rapport){
	global $db, $table_prefix, $attack_config, $user_data;
	define("TABLE_ATTAQUES_ATTAQUES", $table_prefix."attaques_attaques");
	read_config();

	if ($rapport['win'] == "D"){ // Si l'attaquant pert alors il ne prend pas de ressources !!
		$ressources[1] = 0;
		$ressources[2] = 0;
		$ressources[3] = 0;
	} else {
		$ressources[1] = $rapport['result']['win_metal'];
		$ressources[2] = $rapport['result']['win_cristal'];
		$ressources[3] = $rapport['result']['win_deut'];
	}
    
	$pertes = $rapport['result']['a_lost'];
	$timestamp = $rapport['date'];
	foreach ($rapport['n'] as $n){
		if($n['type'] == "D"){
			$coord_attaque = $n['coords'];
			break;
		} else {
			$query = $db->sql_query("SELECT count(planet_id) FROM ".TABLE_USER_BUILDING." WHERE user_id = '".$user_data['user_id']."' AND coordinates = '".$n['coords']."'");
			list($check) = $db->sql_fetch_row($query);
			if($check != 0)
				$coord_attaquant = $n['coords'];
		}
	}
	
	if(!isset($coord_attaquant))
		return false;
      
	//On vérifie que cette attaque n'a pas déja été enregistrée
	$query = "SELECT attack_id FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id='".$user_data['user_id']."' AND attack_date='$timestamp' AND attack_coord='$coord_attaque' ";
	$result = $db->sql_query($query);
	$nb = $db->sql_numrows($result);
	
	if ($nb == 0)
	{
		//On insere ces données dans la base de données
		$query = "INSERT INTO ".TABLE_ATTAQUES_ATTAQUES." ( `attack_id` , `attack_user_id` , `attack_coord` , `attack_date` , `attack_metal` , `attack_cristal` , `attack_deut` , `attack_pertes` )
			VALUES (
				NULL , '".$user_data['user_id']."', '".$coord_attaque."', '".$timestamp."', '".$ressources[1]."', '".$ressources[2]."', '".$ressources[3]."', '".$pertes."')";
		$db->sql_query($query);
	}
	
	return true;
}

function attack_rr($rapport){
	global $db, $table_prefix, $attack_config, $user_data ;

	define("TABLE_ATTAQUES_RECYCLAGES", $table_prefix."attaques_recyclages");
	for($i=0; $i<count($rapport); $i++)
	{
		$timestamp = $rapport[$i]['time'];
		$coordonne = $rapport[$i]['coords'][0].":".$rapport[$i]['coords'][1].":".$rapport[$i]['coords'][2];
		//On vérifie que ce recyclage n'a pas déja été enregistrée
		$query = "SELECT recy_id FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_user_id='".$user_data['user_id']."' AND recy_date='$timestamp' AND recy_coord='$coordonne' ";
		$result = $db->sql_query($query);
		$nb = $db->sql_numrows($result);
		// Si on ne trouve rien
		if ($nb == 0)
		{
			//On insere ces données dans la base de données
			$query = "INSERT INTO ".TABLE_ATTAQUES_RECYCLAGES." ( `recy_id` , `recy_user_id` , `recy_coord` , `recy_date` , `recy_metal` , `recy_cristal` )
				VALUES (
					NULL , '".$user_data['user_id']."', '".$coordonne."', '".$timestamp."', '".$rapport[$i]['M_reco']."', '".$rapport[$i]['C_reco']."')";
			$db->sql_query($query);
		}
	}
	return TRUE;
}

function read_config(){
	global $attack_config, $db;
	
	//récupération des paramètres de config
	$query = "SELECT value FROM `".TABLE_MOD_CFG."` WHERE `mod`='Attaques' and `config`='config'";
	$result = $db->sql_query($query);
	while ($data = $db->sql_fetch_row($result))
	$attack_config = unserialize($data[0]); 
}
?>