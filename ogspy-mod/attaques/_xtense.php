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
        public $version = '2.0b8';
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
$xtense_version="2.00b3";

// Import des Rapports de combats
function attack_rc($rapport)
  {
  global $sql, $table_prefix, $attack_config, $user ;
  $rapport = remove_htm($rapport["content"]);
  //definition de la table attaques
  define("TABLE_ATTAQUES_ATTAQUES", $table_prefix."attaques_attaques");
  read_config();

  if (!preg_match('#Les\sflottes\ssuivantes\sse\ssont\saffrontées\sle\s(\d{2})\-(\d{2}) (\d{2}):(\d{2}):(\d{2}) :#',$rapport,$date))
    {
    return FALSE;
    }
    else
    {
		if (!preg_match('#(\d*)\sunités\sde\smétal,\s(\d*)\sunités\sde\scristal\set\s(\d*)\sunités\sde\sdeutérium#',$rapport,$ressources))
		  {
		  // Si l'attaquant pert alors il ne prend pas de ressources !!
      $ressources[1]=0;
      $ressources[2]=0;
      $ressources[3]=0;
      }
    preg_match('#attaquant\sa\sperdu\sau\stotal\s(\d*)\sunités#',$rapport,$pertesA);
    $pertes = $pertesA[1];
		$timestamp = mktime($date[3],$date[4],$date[5],$date[1],$date[2],date('Y'));
		
		//Puis les informations pour les coordonnées
		preg_match('#Défenseur\s.+\[(.+)]#',$rapport,$pre_coord);
		$coord_attaque = $pre_coord[1];
		
    //On vérifie que vous êtes bien l'attaquant
		preg_match('#Attaquant\s.{3,70}\[(.{5,8})]#',$rapport,$pre_coord);
		$coord_attaquant = $pre_coord[1];
		//On regarde dans les coordonnées de l'espace personnel du joueur qui insère les données via le plugin si les coordonnées de l'attaquant correspondent à une de ses planètes
    $query = "SELECT coordinates FROM ".TABLE_USER_BUILDING." WHERE user_id='".$user['id']."'";
    $result = $sql->query($query);
    $attaquant = 0;
    $defenseur = 0;
   	while(list($coordinates) = mysql_fetch_row($result))
	{
		if($coordinates == $coord_attaquant) $attaquant = 1;
		if($coordinates == $coord_attaque) $defenseur = 1;
	}
	if ($attaquant != 1 && $attack_config['defenseur'] != 1) 
    {
    return false;
    } 
    else 
    {
    if ($defenseur == 1 && $attack_config['defenseur'] == 1)
      {
      // récupération des pertes défenseurs
      preg_match('#défenseur\sa\sperdu\sau\stotal\s(\d*)\sunités#',$rapport,$pertesD);
      $pertes = $pertesD[1];
      //les coordonnées de l'attaque deviennent celle de l'attaquant
      $coord_attaque = $coord_attaquant;
      //on soustrait les ressources volées
      $ressources[1] = -$ressources[1];
      $ressources[2] = -$ressources[2];
      $ressources[3] = -$ressources[3];
      }
      
		//On vérifie que cette attaque n'a pas déja été enregistrée
		$query = "SELECT attack_id FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id='".$user['id']."' AND attack_date='$timestamp' AND attack_coord='$coord_attaque' ";
		$result = $sql->query($query);
		$nb = mysql_num_rows($result);
		
		if ($nb == 0)
		{
			//On insere ces données dans la base de données
			$query = "INSERT INTO ".TABLE_ATTAQUES_ATTAQUES." ( `attack_id` , `attack_user_id` , `attack_coord` , `attack_date` , `attack_metal` , `attack_cristal` , `attack_deut` , `attack_pertes` )
				VALUES (
					NULL , '".$user['id']."', '".$coord_attaque."', '".$timestamp."', '".$ressources[1]."', '".$ressources[2]."', '".$ressources[3]."', '".$pertes."')";
			$sql->query($query);
		}
	 }
  }
  return TRUE;
}

function attack_rr($rapport)
  {
  global $sql, $table_prefix, $attack_config, $user ;

  define("TABLE_ATTAQUES_RECYCLAGES", $table_prefix."attaques_recyclages");
  for($i=0; $i<count($rapport); $i++)
    {
        $timestamp = $rapport[$i]['time'];
        $coordonne = $rapport[$i]['coords'][0].":".$rapport[$i]['coords'][1].":".$rapport[$i]['coords'][2];
        //On vérifie que ce recyclage n'a pas déja été enregistrée
		$query = "SELECT recy_id FROM ".TABLE_ATTAQUES_RECYCLAGES." WHERE recy_user_id='".$user['id']."' AND recy_date='$timestamp' AND recy_coord='$coordonne' ";
		$result = $sql->query($query);
		$nb = mysql_num_rows($result);
        // Si on ne trouve rien
        if ($nb == 0)
		{
			//On insere ces données dans la base de données
			$query = "INSERT INTO ".TABLE_ATTAQUES_RECYCLAGES." ( `recy_id` , `recy_user_id` , `recy_coord` , `recy_date` , `recy_metal` , `recy_cristal` )
				VALUES (
					NULL , '".$user['id']."', '".$coordonne."', '".$timestamp."', '".$rapport[$i]['M_reco']."', '".$rapport[$i]['C_reco']."')";
			$sql->query($query);
		}
    }
    return TRUE;
  }
  
function remove_htm($rapport)
  {
  $rapport = stripslashes($rapport);
  $rapport = html_entity_decode($rapport);
  $rapport = strip_tags($rapport);
  $rapport = str_replace(".","",$rapport);
  return $rapport;
  }
function read_config()
  {
  global $attack_config,$sql;
//récupération des paramètres de config
  $query = "SELECT value FROM `".TABLE_MOD_CFG."` WHERE `mod`='Attaques' and `config`='config'";
  $result = $sql->query($query);
  while ($data = mysql_fetch_row($result)) 
    {
    $attack_config=unserialize($data[0]); 
    }
  }
?>