<?php
/**
*   _xtense.php - fichier d'interface avec Xtense2
*   @package Convertisseur
*   @author Jedinight 
*   @link http://www.ogsteam.fr
*   @version : 0.1
*   created	: 07/07/2011   
*   modified	: 
**/
// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Version minimum de Xtense2
$xtense_version="2.4.0";

if(class_exists("Callback")){
	class Hostiles_Callback extends Callback {
	        public $version = '2.4.0';
	        
	        public function hostiles($hostile){
				global $io, $user_data;
				if(hostile_fleet($hostile)){
					$io->append_call_message("Flotte hostile en direction de ".$hostile['destination_name']." a été enregistrée", Io::SUCCESS);
					//return Io::SUCCESS;
		        } else {
					$io->append_call_message("Flotte hostile en direction de ".$hostile['destination_name']." non enrégistrée", Io::WARNING);
		        	//return Io::WARNING;
				}
			}
			
	        public function getCallbacks() { 
	        	return array('function' => 'hostiles', 
	        				'type' => 'hostiles'); 
	        }
	}
}
 
// Import des Livraisons de ressources
function hostile_fleet($hostile){
  global $db, $table_prefix, $convertisseur_config, $user_data;
	//$trade = remove_htm($trade["content"]);
	//definition de la table Convertisseur
	define("TABLE_HOSTILES", $table_prefix."hostiles");
	define("TABLE_HOSTILES_ATTACKS", $table_prefix."hostiles_attacks");
	define("TABLE_HOSTILES_COMPOSITION", $table_prefix."hostiles_composition");
  
	//read_config();
	
	$retour = false;
	// Verification de présence 
	if($hostile['id']!=null){
	    $query = "DELETE FROM " . TABLE_HOSTILES . " WHERE id_attack = '".$hostile['id']."'";
	    $db->sql_query($query);
	    
	    $query = "DELETE FROM " . TABLE_HOSTILES_ATTACKS . " WHERE id_attack = '".$hostile['id']."'";
	    $db->sql_query($query);
	    
	    $query = "DELETE FROM " . TABLE_HOSTILES_COMPOSITION . " WHERE id_attack = '".$hostile['id']."'";
	    $db->sql_query($query);
	    
		// Non enregistré		
		$query = "INSERT INTO " . TABLE_HOSTILES ."(`id_attack`, `user_id`, `player_id`, `ally_id`, `arrival_time`) " .
									"VALUES ('".$hostile['id']."', '".$user_data['user_id']."', '".$hostile['player_id']."', '".$hostile['ally_id']."', '".$hostile['arrival_time']."')";
		
	    $db->sql_query($query);
	    	    
		$query = "INSERT INTO " . TABLE_HOSTILES_ATTACKS ."(`id_attack`,`id_vague`,`attacker`,`origin_planet`,`origin_coords`,`cible_planet`,`cible_coords`) " .
											"VALUES ('".$hostile['id']."', '".$hostile['id_vague']."', '".$hostile['attacker']."', '".$hostile['origin_planet']."', '".$hostile['origin_coords']."', '".$hostile['cible_planet']."', '".$hostile['cible_coords']."')";
		
		$db->sql_query($query);
		
	    $retour = true;
	}
    
	return $retour;
}


function remove_htm($hostile) {
  $hostile = stripslashes($hostile);
  $hostile = html_entity_decode($hostile);
  $hostile = strip_tags($hostile);
  $hostile = str_replace(".","",$hostile);
  return $hostile;
}
/*
function read_config() {
  global $convertisseur_config,$db;
//récupération des paramètres de config
  $query = "SELECT value FROM `".TABLE_MOD_CFG."` WHERE `mod`='convertisseur' and `config`='config'";
  $result = $db->sql_query($query);
  while ($data = mysql_fetch_row($result)) {
    $convertisseur_config=unserialize($data[0]); 
  }
}*/
?>