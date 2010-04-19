<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt");


global $db, $table_prefix , $user, $db,$xtense_version,$table_prefix;
$xtense_version = "2.0b5";
///define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");
define("TABLE_PANDORE_SPY",	$table_prefix."pandorespy");



// TEST XTENSE2

 if(class_exists("Callback")){
class pandorespy_Callback extends Callback {
        public $version = '2.0b8';
        public function pandorespy($system){
			global $io;
			if(pandorespy($system))
				return Io::SUCCESS;
			else
				return Io::ERROR;
		}
        public function getCallbacks() {
                return array(
                        array(
                                'function' => 'pandorespy',
                                'type' => 'system'
                        )
                );
       }
}
}








function pandorespy($system) {
global $sql, $user;

  // dump($system);
	

	  ///donnée a traiter
/// timestamp actuel
$time=time() ;
 $user_id= $user['id'];
         
        
		// On boucle dans la liste des résultats et on insert dans la DB
  for ($i=0; $i < count($system['data']); $i++)
      {
		$rows= ($i+1);
		 /// travail sur la date avec variable $la (timmer en seconde ))a determiner ulterieurement
        
	///par defaut, personne est absente	
	$la=0;
  
  		/// galaxie 
  		$gal=$system['galaxy'];
  		$gal.=':';
  		$gal.=$system['system'];
		$gal.=':';
		$gal.=$rows;
		$pos_galaxie=$system['galaxy'];
  		$pos_sys=$system['system'];
  		$pos_pos=$rows;
 	
 
  		$player=$system['data'][''.$rows.'']['player'];
        $body=$system['data'][''.$rows.'']['activity'];
          
		 // trier activity
		 $presence=$body;
		 if ( $presence =="*"){$presence=0;}
		 if ($body !==""){$la=1;}
		 //supression de " min"
		  
	  	$presence=str_replace(' min', '', $presence);
		//on force les variables numerique
		settype($presence, "integer");
 		settype($time, "integer");
 		$date=$time;
 		settype($date, "integer");
		$date=$date-(60*$presence);
	
		//annee
		$annee=date('Y', $date); 
		// mois
		$mois=date('n', $date); 
        // jour
		$jour_num=date('j', $date);  
  		$jour =date('l', $date); 
  		/// heure
  		$heure=date('G', $date); 
  		/// heure
  		$minute=date('i', $date); 



		  //test
        $query = "INSERT INTO ".TABLE_PANDORE_SPY." 
		(id, date, presence , la ,  annee , mois , jour_num , jour , heure ,  minute  , gal , pos_galaxie, pos_sys , pos_pos,player , body , user_id )
		 VALUES 
		 ('', $date , '".$presence."' , $la , $annee ,  $mois ,$jour_num , '".$jour."', $heure , $minute , '".$gal."' ,$pos_galaxie, $pos_sys, $pos_pos  , '".$player."' ,  '".$body."', $user_id)";
        $sql->query($query);
     



	}

    



}



?>