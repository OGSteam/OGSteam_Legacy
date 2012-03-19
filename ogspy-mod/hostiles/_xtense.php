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
				if($hostile['clean']==null){
					if(hostile_fleet($hostile)){
						$io->append_call_message("Flotte hostile en direction de ".$hostile['destination_name']." enregistrée", Io::SUCCESS);
						//return Io::SUCCESS;
			        } else {
						$io->append_call_message("Flotte hostile en direction de ".$hostile['destination_name']." non enrégistrée", Io::WARNING);
			        	//return Io::WARNING;
					}
				} else {
					if(clean_hostile_for_user($hostile)){
						$io->append_call_message("Aucune flotte hostile détectée, les données de l'utilisateur ont été supprimée", Io::SUCCESS);
					}
				}
				return Io::SUCCESS;
				
			}
			
	        public function getCallbacks() { 
	        	return array('function' => 'hostiles', 
	        				'type' => 'hostiles'); 
	        }
	}
}
 
// Nettoyage des données de l'utilisateur
function clean_hostile_for_user($hostile){
	global $db, $table_prefix, $convertisseur_config, $user_data;
	//$trade = remove_htm($trade["content"]);
	//definition de la table Convertisseur
	define("TABLE_HOSTILES", $table_prefix."hostiles");
	define("TABLE_HOSTILES_ATTACKS", $table_prefix."hostiles_attacks");
	define("TABLE_HOSTILES_COMPOSITION", $table_prefix."hostiles_composition");
	
	// Y'a t-il des infos de base de l'attaque
	$query = "SELECT id_attack FROM " . TABLE_HOSTILES . " WHERE `user_id`='".$user_data['user_id']."'";
	$result = $db->sql_query($query);
	$nbHostiles = mysql_num_rows($result);
	
	// Non enregistré
	if ($nbHostiles != 0){	
		$query = "DELETE FROM " . TABLE_HOSTILES . " WHERE `user_id`='".$user_data['user_id']."'";
		$db->sql_query($query);
		
		while(list($id_attack) = $db->sql_fetch_row($result) ){
			$query = "DELETE FROM " . TABLE_HOSTILES_ATTACKS . " WHERE id_attack = '" . $id_attack . "'";
			$db->sql_query($query);
			 
			$query = "DELETE FROM " . TABLE_HOSTILES_COMPOSITION . " WHERE id_attack = '" . $id_attack . "'";
			$db->sql_query($query);
		}
		return true;
	}
	return false;
}

// Import des Livraisons de ressources
function hostile_fleet($hostile){
  global $db, $table_prefix, $convertisseur_config, $user_data;
	//$trade = remove_htm($trade["content"]);
	//definition de la table Convertisseur
	define("TABLE_HOSTILES", $table_prefix."hostiles");
	define("TABLE_HOSTILES_ATTACKS", $table_prefix."hostiles_attacks");
	define("TABLE_HOSTILES_COMPOSITION", $table_prefix."hostiles_composition");
  	
	$retour = false;
	// Verification de présence 
	if($hostile['id']!=null){
		$vague = 0;
		if($hostile['id_vague']!=null){
			$vague = $hostile['id_vague'];
		}
		
		// Y'a t-il des infos de base de l'attaque		
		$query = "SELECT * FROM " . TABLE_HOSTILES . " WHERE `id_attack`='".$hostile['id']."'";
		$result = $db->sql_query($query);
		$nbHostiles = mysql_num_rows($result);
		
		// Non enregistré
		if ($nbHostiles == 0){
			$query = "INSERT INTO " . TABLE_HOSTILES ."(`id_attack`"
			                                           .", `user_id`"
			                                           .", `player_id`"
			                                           .", `ally_id`"
			                                           .", `arrival_time`) " .
										"VALUES ('".$hostile['id']
												."', '".$user_data['user_id']
												."', '".$hostile['player_id']
												."', '".$hostile['ally_id']."', '"
												.$hostile['arrival_time']."')";
		    $db->sql_query($query);
		} else {
			$query = "UPDATE " . TABLE_HOSTILES ." SET `arrival_time`='".$hostile['arrival_time']."' WHERE `id_attack`='".$hostile['id']."'";
			$db->sql_query($query);
		}
		
		// Y'a t-il des infos précises de l'attaque
		$query = "SELECT * FROM " . TABLE_HOSTILES_ATTACKS . " WHERE `id_attack`='".$hostile['id']."' and `id_vague`='".$vague."'";
		$result = $db->sql_query($query);
		$nbHostiles = mysql_num_rows($result);
		
	    // Enregistrer les infos précises de l'attaque
		if ($nbHostiles == 0){
			$query = "INSERT INTO " . TABLE_HOSTILES_ATTACKS ."(`id_attack`"
			.",`id_vague`"
			.",`attacker`"
			.",`origin_planet`"
			.",`origin_coords`"
			.",`cible_planet`"
			.",`cible_coords`) " .
															"VALUES ('".$hostile['id']
			."', '".$hostile['id_vague']
			."', '".$hostile['attacker']
			."', '".$hostile['origin_planet']
			."', '".$hostile['origin_coords']
			."', '".$hostile['cible_planet']
			."', '".$hostile['cible_coords']."')";
			$db->sql_query($query);
		} else {
			$query = "DELETE FROM " . TABLE_HOSTILES_ATTACKS ." WHERE `id_attack`='".$hostile['id']."' and `id_vague`='".$vague."'";
			$db->sql_query($query);
			
			$query = "INSERT INTO " . TABLE_HOSTILES_ATTACKS ."(`id_attack`"
			.",`id_vague`"
			.",`attacker`"
			.",`origin_planet`"
			.",`origin_coords`"
			.",`cible_planet`"
			.",`cible_coords`) " .
															"VALUES ('".$hostile['id']
			."', '".$hostile['id_vague']
			."', '".$hostile['attacker']
			."', '".$hostile['origin_planet']
			."', '".$hostile['origin_coords']
			."', '".$hostile['cible_planet']
			."', '".$hostile['cible_coords']."')";
			$db->sql_query($query);
		}
		
		
		
		// Y'a t-il des infos précises de l'attaque
		$query = "SELECT * FROM " . TABLE_HOSTILES_COMPOSITION . " WHERE `id_attack`='".$hostile['id']."' and `id_vague`='".$vague."'";
		$result = $db->sql_query($query);
		$nbHostiles = mysql_num_rows($result);
		
		
		// Enregistrer la composition de l'attaque
		if ($nbHostiles == 0){
			$composition = explode(",",$hostile['composition_flotte']);
			$count = count($composition);
			for ($i = 0; $i < $count; $i++) {
				$fleet = explode(":",$composition[$i]);
				
				$query = "INSERT INTO " . TABLE_HOSTILES_COMPOSITION ."(`id_attack`"
																	.",`id_vague`"
																	.",`type_ship`"
																	.",`nb_ship`) "
						."VALUES ('".$hostile['id']
							."', '".$hostile['id_vague']
							."', '".$fleet[0]
							."', '".$fleet[1]."')";			
				$db->sql_query($query);
			}
		} else {
			$query = "DELETE FROM " . TABLE_HOSTILES_COMPOSITION ." WHERE `id_attack`='".$hostile['id']."' and `id_vague`='".$vague."'";
			$db->sql_query($query);
			
			$composition = explode(",",$hostile['composition_flotte']);
			$count = count($composition);
			for ($i = 0; $i < $count; $i++) {
				$fleet = explode(":",$composition[$i]);
			
				$query = "INSERT INTO " . TABLE_HOSTILES_COMPOSITION ."(`id_attack`"
				.",`id_vague`"
				.",`type_ship`"
				.",`nb_ship`) "
				."VALUES ('".$hostile['id']
				."', '".$hostile['id_vague']
				."', '".$fleet[0]
				."', '".$fleet[1]."')";
				$db->sql_query($query);
			}
		}
		
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
?>