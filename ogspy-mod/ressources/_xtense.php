<?php
/** _xtense.php 
Script d'interconnexion avec la barre d'outils Xtense v2.*/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Test si la class existe, Si elle n'existe pas alors le xtense2 installé est trop vieux.
if(class_exists("Callback")){
	
	// La class existe, alors on rajoute nos fonctions
	class Ressources_Callback extends Callback {
		
		// version minimale de la barre.
		public $version = '2.3.0';
		
		// Définition (utilisé à l'installation de xtense)
		public function getCallbacks() {return array(array('function' => 'get_overview', 'type' => 'overview'));}
		
		// Fonction d'importation...
		public function get_overview($data) {
			
			// Globals nécessaire (base de donnée, InputOuput vers la barre, utilisateur, et préfixe de la table
			global $db,$io,$user_data,$table_prefix;
			
			// Définition du nom de la table (à importer d'un autre fichier pour ne pas l'avoir en multiple dans le dossier?)
			define("TABLE_USER_RESSOURCES",$table_prefix."user_ressources");
			
			// Recherche de l'ID de la planète ou de la lune
			$home = home_check($data['planet_type'], implode(':',$data['coords']));
			
			// Test si on a trouvé un ID et si les ressources sont présente (sécurité contre les plus anciennes barre d'outils qui ne renvoient pas les ressources);
			if (isset($home['id']) && isset($data['ressources'][1])) {
				$request = "SELECT metal FROM ".TABLE_USER_RESSOURCES." WHERE user_id = ".$user_data['user_id']." and planet_id = ".$home['id'];
				if ($db->sql_numrows($db->sql_query($request)) == 0) {
					//nouvel enregistrement
					$request = "INSERT INTO ".TABLE_USER_RESSOURCES." (user_id, planet_id, timestamp, metal, crystal, deuterium) VALUES (".$user_data['user_id'].", ".$home['id'].", ".time().", ".$data['ressources'][0].", ".$data['ressources'][1].", ".$data['ressources'][2].")";
					$db->sql_query($request);
				} else {
					// enregistrement existant
					$request = "UPDATE ".TABLE_USER_RESSOURCES." set timestamp = ".time().", metal = ".$data['ressources'][0].", crystal = ".$data['ressources'][1].", deuterium = ".$data['ressources'][2]." WHERE user_id = ".$user_data['user_id']." and planet_id = ".$home['id'];
					$db->sql_query($request);
				}
			}
			return Io::SUCCESS;
		}
	}
}
?>
