<?php
/**
* import_rc.php
 * @package Attaques
 * @author Verit�
 * @link http://www.ogsteam.fr
 * @version : 0.8e
 */

/**
* Importation d'un RC dans le mod � partir d'une barre (extension firefox)
* @param string $rapport Rapport � importer
* @return 0 si mod non activ�
* @return 1 si RC non valide
* @return 2 si $pseudo n'est pas l'attaquant du RC
* @return 3 si le RC a d�ja �t� enregistr�
* @return 4 si le RC � bien �t� ins�r�
**/
function import_rc($rapport)
{
   //D�finitions
   global $db, $table_prefix, $user_data;
   define("TABLE_ATTAQUES_ATTAQUES", $table_prefix."attaques_attaques");
   
   //On v�rifie que le mod est activ�
   $query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='attaques' AND `active`='1' LIMIT 1";
   if (!$db->sql_numrows($db->sql_query($query))) return 0;

   $rapport = str_replace(".","",$rapport);  
   //Compatibilit� UNIX/Windows
   $rapport = str_replace("\r\n","\n",$rapport);
   //Compatibilit� IE/Firefox
   $rapport = str_replace("\t",' ',$rapport);
   
   //On regarde si le rapport soumis est un RC
   if (!preg_match('#Les\sflottes\ssuivantes\sse\ssont\saffront�es\sle\s(\d{2})\-(\d{2}) (\d{2}):(\d{2}):(\d{2}) :#',$rapport,$date))
   {
      return 1;
   }
   
   //On v�rifie que le pseudo de l'attaquant est bien le pseudo du joueur
   
	//On recup�re les coordonn�es de l'attaquant ( a revoir car solution de bourrin en attendant de comprendre pourquoi j'y arrive pas avec preg_match() )
	$attaquant = strstr($rapport,Attaquant);
	$attaquant = explode("(", $attaquant);
	$attaquant = explode(")", $attaquant[1]);
	$coord_attaquant = $attaquant[0];
   
   //On regarde dans les coordonn�es de l'espace personnel du joueur qui ins�re les donn�es via le plugin si les coordonn�es de l'attaquant correspondent � une de ses plan�tes
   $query = "SELECT coordinates FROM ".TABLE_USER_BUILDING." WHERE user_id='$user_data[user_id]'";
   $result = $db->sql_query($query);
   
   	while(list($coordinates) = $db->sql_fetch_row($result))
	{
		if($coordinates == $coord_attaquant) $attaquant = 1;
	}
	
	if($attaquant != 1) return 2;
	
   preg_match('#attaquant\sa\sperdu\sau\stotal\s(\d*)\sunit�s#',$rapport,$pertesA);
   preg_match('#(\d*)\sunit�s\sde\sm�tal,\s(\d*)\sunit�s\sde\scristal\set\s(\d*)\sunit�s\sde\sdeut�rium#',$rapport,$ressources);
      
   $timestamp = mktime($date[3],$date[4],$date[5],$date[1],$date[2],date('Y'));
      
   //Puis les informations pour les coordonn�es
   preg_match('#D�fenseur\s.+\s\((.+)\)#',$rapport,$pre_coord);
  $coord_attaque = $pre_coord[1];
   
   //On v�rifie que cette attaque n'a pas d�ja �t� enregistr�e
   $query = "SELECT attack_id FROM ".TABLE_ATTAQUES_ATTAQUES." WHERE attack_user_id='$user_data[user_id]' AND attack_date='$timestamp' AND attack_coord='$coord_attaque' ";
   $result = $db->sql_query($query);
   $nb = mysql_num_rows($result);
   if ($nb != 0) return 3;
   
   //On insere ces donn�es dans la base de donn�es
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