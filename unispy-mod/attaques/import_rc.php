<?php
/**
* import_rc.php
 * @package Attaques
 * @author Verité
 * @link http://www.ogsteam.fr
 * @version : 0.8e
 */

/**
* Importation d'un RC dans le mod à partir d'une barre (extension firefox)
* @param string $rapport Rapport à importer
* @return 0 si mod non activé
* @return 1 si RC non valide
* @return 2 si $pseudo n'est pas l'attaquant du RC
* @return 3 si le RC a déja été enregistré
* @return 4 si le RC à bien été inséré
**/
function import_rc($rapport)
{
   //Définitions
   global $db, $table_prefix, $user_data;
   define("TABLE_ATTAQUES_ATTAQUES", $table_prefix."attaques_attaques");
   
   //On vérifie que le mod est activé
   $query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='attaques' AND `active`='1' LIMIT 1";
   if (!$db->sql_numrows($db->sql_query($query))) return 0;

   $rapport = str_replace(".","",$rapport);  
   //Compatibilité UNIX/Windows
   $rapport = str_replace("\r\n","\n",$rapport);
   //Compatibilité IE/Firefox
   $rapport = str_replace("\t",' ',$rapport);
   
   //On regarde si le rapport soumis est un RC
   if (!preg_match('#Les\sflottes\ssuivantes\sse\ssont\saffrontées\sle\s(\d{2})\-(\d{2}) (\d{2}):(\d{2}):(\d{2}) :#',$rapport,$date))
   {
      return 1;
   }
   
   //On vérifie que le pseudo de l'attaquant est bien le pseudo du joueur
   
	//On recupère les coordonnées de l'attaquant ( a revoir car solution de bourrin en attendant de comprendre pourquoi j'y arrive pas avec preg_match() )
	$attaquant = strstr($rapport,Attaquant);
	$attaquant = explode("(", $attaquant);
	$attaquant = explode(")", $attaquant[1]);
	$coord_attaquant = $attaquant[0];
   
   //On regarde dans les coordonnées de l'espace personnel du joueur qui insère les données via le plugin si les coordonnées de l'attaquant correspondent à une de ses planètes
   $query = "SELECT coordinates FROM ".TABLE_USER_BUILDING." WHERE user_id='$user_data[user_id]'";
   $result = $db->sql_query($query);
   
   	while(list($coordinates) = $db->sql_fetch_row($result))
	{
		if($coordinates == $coord_attaquant) $attaquant = 1;
	}
	
	if($attaquant != 1) return 2;
	
   preg_match('#attaquant\sa\sperdu\sau\stotal\s(\d*)\sunités#',$rapport,$pertesA);
   preg_match('#(\d*)\sunités\sde\smétal,\s(\d*)\sunités\sde\scristal\set\s(\d*)\sunités\sde\sdeutérium#',$rapport,$ressources);
      
   $timestamp = mktime($date[3],$date[4],$date[5],$date[1],$date[2],date('Y'));
      
   //Puis les informations pour les coordonnées
   preg_match('#Défenseur\s.+\s\((.+)\)#',$rapport,$pre_coord);
  $coord_attaque = $pre_coord[1];
   
   //On vérifie que cette attaque n'a pas déja été enregistrée
   $query = "SELECT attack_id FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id='$user_data[user_id]' AND attack_date='$timestamp' AND attack_coord='$coord_attaque' ";
   $result = $db->sql_query($query);
   $nb = mysql_num_rows($result);
   if ($nb != 0) return 3;
   
   //On insere ces données dans la base de données
   $query = "INSERT INTO ".TABLE_ATTAQUES_ATTAQUES." ( `attack_id` , `attack_user_id` , `attack_coord` , `attack_date` , `attack_metal` , `attack_cristal` , `attack_deut` , `attack_pertes` )
      VALUES (
         NULL , '$user_data[user_id]', '$coord_attaque', '$timestamp', '$ressources[1]', '$ressources[2]', '$ressources[3]', '$pertesA[1]'
      )";
   $db->sql_query($query);
   
   //On ajoute l'action dans le log
   $line = $user_data[user_name]." ajoute une attaque dans le module de gestion des attaques via le plugin Xtense";
   $fichier = "log_".date("ymd").'.log';
   $line = "/*".date("d/m/Y H:i:s").'*/ '.$line;
   write_file(PATH_LOG_TODAY.$fichier, "a", $line);
   
   //Et on valide l'ajout du rc
   return 4;
}
?> 