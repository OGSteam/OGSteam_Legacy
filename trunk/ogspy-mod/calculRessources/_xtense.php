<?php
/** _xtense.php 
Script d'interconnexion avec la barre d'outils Xtense v2.*/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Test si la class existe, Si elle n'existe pas alors le xtense2 installé est trop vieux.
if(class_exists("Callback")){

  // La class existe, alors on rajoute nos fonctions
  class CalculRessources_Callback extends Callback {
    
    // version minimale de la barre.
        public $version = '2.0b9';
    
    // Définition (utilisé à l'installation de xtense)
        public function getCallbacks() {
                return array(
                        array(
                                'function' => 'get_overview',
                                'type' => 'overview'
                        )
                );
    }
    // Fonction d'importation...
        public function get_overview($data){
      // Globals nécessaire (base de donnée, InputOuput vers la barre, utilisateur, et préfixe de la table
      global $sql,$io,$user,$table_prefix;
      
      // Définition du nom de la table (a importer d'un autre fichier pour ne pas l'avoir en multiple dans le dossier?)
      define("TABLE_CALCULRESS_USER",$table_prefix."mod_calculress");
      
      // recherche de l'ID de la planète ou de la lune
      $home = home_check($data['planet_type'], implode(':',$data['coords']));
      
      // Test si on a trouvé un ID et si les ressources sont présente (sécurité contre les plus anciennes barre d'outils qui ne renvoient pas les ressources);
      if(isset($home['id']) && isset($data['ressources'][1])){
		$request = "SELECT metal FROM ".TABLE_CALCULRESS_USER." WHERE user_id = ".$user['id']." and planet_id = ".$home['id'];
        if ($sql->check($request) == 0) {   //nouvel enregistrement
			$request = "INSERT INTO ".TABLE_CALCULRESS_USER." (user_id, planet_id, `date_heure`, metal, cristal, deut) VALUES (".$user['id'].", ".$home['id'].", '".date('Y-m-d H:i:s')."', ".$data['ressources'][0].", ".$data['ressources'][1].", ".$data['ressources'][2].")";
			$sql->query($request);}
        else { // enregistrement existant
			$request = "UPDATE ".TABLE_CALCULRESS_USER." set `date_heure` = '".date('Y-m-d H:i:s')."', metal = ".$data['ressources'][0].", cristal = ".$data['ressources'][1].", deut = ".$data['ressources'][2]." WHERE user_id = ".$user['id']." and planet_id = ".$home['id'];
			$sql->query($request);}
      }
      return Io::SUCCESS;
    }
  }
}
?>