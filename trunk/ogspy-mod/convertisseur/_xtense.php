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
$xtense_version="2.3.10";

if(class_exists("Callback")){
	class Convertisseur_Callback extends Callback {
	        public $version = '2.3.10';
	        
	        public function livraison($trade){
				global $io, $user_data;
				if(livraison($trade)){
					 $io->append_call_message("Livraison du joueur ".$trade['trader']." sur ma planète ".$trade['planet']." enrégistrée", Io::SUCCESS);
		        } else {
					$io->append_call_message("Livraison du joueur ".$trade['trader']." sur ma planète ".$trade['planet']." non enrégistrée", Io::ERROR);
				}
				return Io::SUCCESS;
			}
			public function livraison_me($trade_me){
				global $io, $user_data;
				if(livraison_me($trade_me)){
					 $io->append_call_message("Livraison sur planete amie (".$trade_me['planet'].") enregistrée", Io::SUCCESS);
		        } else {
					$io->append_call_message("Livraison sur planete amie (".$trade_me['planet'].") non enregistrée", Io::ERROR);
				}
				return Io::SUCCESS;
			}
			
	        public function getCallbacks() {
	                return array(
	                        array(
	                                'function' => 'livraison',
	                                'type' => 'trade'
	                        ),
	                        array(
	                                'function' => 'livraison_me',
	                                'type' => 'trade_me'
	                        )
	                );
	       }
	}
}
 
// Import des Livraisons de ressources
function livraison($trade){
  global $db, $table_prefix, $convertisseur_config, $user_data;
	//$trade = remove_htm($trade["content"]);
	//definition de la table Convertisseur
	define("TABLE_CONVERTISSEUR_COMMERCE", $table_prefix."convertisseur_commerce");
	read_config();
	
	$retour = false;
	// Verification de présence 
    $query = "SELECT * FROM " . TABLE_CONVERTISSEUR_COMMERCE . " WHERE commerce_date = ".$trade['time']." AND commerce_user_id = '".$user_data['user_id']."'AND commerce_planet = '".$trade['planet']."'";
    $result = $db->sql_query($query);
	$nb = mysql_num_rows($result);
	
	// Non enregistré	
	if ($nb == 0){
        $query = "INSERT INTO " . TABLE_CONVERTISSEUR_COMMERCE ."" .
        		"(`commerce_id`, `commerce_user_id`, `commerce_planet`, `commerce_trader`, `commerce_type`, `commerce_date`, `commerce_metal`, `commerce_cristal`, `commerce_deut`) " .
				"VALUES (NULL, '".$user_data['user_id']."', '".$trade['planet']."', '".htmlspecialchars($trade['trader'])."', " .
				"'1', '".$trade['time']."', '" . $trade['metal']."', '".$trade['cristal']."', '".$trade['deuterium']."')";
        $db->sql_query($query);
        $retour = true;        
    }
	return $retour;
}

// Import des Livraisons de ressources sur planètes amies
function livraison_me($trade_me) {
	global $db, $table_prefix, $convertisseur_config, $user_data;
	//$trade = remove_htm($trade["content"]);
	//definition de la table Convertisseur
	define("TABLE_CONVERTISSEUR_COMMERCE", $table_prefix."convertisseur_commerce");
	read_config();
	
	$retour = false;
	// Verification de présence 
    $query = "SELECT * FROM " . TABLE_CONVERTISSEUR_COMMERCE . " WHERE commerce_date = ".$trade_me['time']." AND commerce_user_id = ".$user_data['user_id']." AND commerce_planet = '".$trade_me['planet']."'";
    $result = $db->sql_query($query);
	$nb = mysql_num_rows($result);
	
	// Non enregistré	
	if ($nb == 0){
        $query = "INSERT INTO " . TABLE_CONVERTISSEUR_COMMERCE ."" .
        		"(`commerce_id`, `commerce_user_id`, `commerce_planet`, `commerce_trader`, `commerce_type`, `commerce_date`, `commerce_metal`, `commerce_cristal`, `commerce_deut`) " .
				"VALUES (NULL, '".$user_data['user_id']."', '".$trade_me['planet']."', '".$trade_me['trader']."', " .
				"'0', '".$trade_me['time']."', '" . $trade_me['metal']."', '".$trade_me['cristal']."', '".$trade_me['deuterium']."')";
        $db->sql_query($query);
        $retour = true;        
    }
	return $retour;
}


function remove_htm($trade) {
  $trade = stripslashes($trade);
  $trade = html_entity_decode($trade);
  $trade = strip_tags($trade);
  $trade = str_replace(".","",$trade);
  return $trade;
}

function read_config() {
  global $convertisseur_config,$db;
//récupération des paramètres de config
  $query = "SELECT value FROM `".TABLE_MOD_CFG."` WHERE `mod`='convertisseur' and `config`='config'";
  $result = $db->sql_query($query);
  while ($data = mysql_fetch_row($result)) {
    $convertisseur_config=unserialize($data[0]); 
  }
}
?>