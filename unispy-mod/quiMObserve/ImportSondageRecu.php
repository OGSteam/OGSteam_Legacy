<?php 
/** 
* ImportSondageRecu.php 
 * @package QuiMobserve 
 * @author santory 
 * @link http://www.ogsteam.fr 
 * @version : 0.1d 
 */ 

/** 
* Importation d'un Sondage dans le mod à partir d'une barre (extension firefox) 
* @param string $rapport 
* @return 0 si mod non activé 
* @return 1 si des espionnages ont été enregistré 
* @return 2 si les espionnages ont déja été inséré 
* @return 3 si aucun espionnages subit est detecté 
*/ 

// L'appel direct est interdit.... 
if (!defined('IN_SPYOGAME')) die("Hacking attempt"); 

function insert_raport_espionage($pub_espionage,$date,$pourcentage){ 
   global $db; 
   global $table_prefix; 
   global $user_data; 

   if (defined("OGS_PLUGIN_DEBUG")) global $fp;
   if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Entrée insert_raport_espionage\n");
   
   preg_match('#Une\sflotte\sennemie\sde\sla\splanète\s+(.*?)\s+\[(.*?)\]\s+a\sété\saperçue\sà\sproximité\sde\svotre\splanète\s+(.*?)\s+\[(.*?)\]#si',$pub_espionage,$planettes);

   //On vérifie que ce sondage n'a pas déja été enregistrée 
   $query = "SELECT spy_id FROM ".TABLE_QUIMOBSERVE." WHERE sender_id='".$user_data['user_id']."' AND datadate='".$date."' AND spy_planetteespion='".$planettes[2]."' "; 

   $result = $db->sql_query($query); 
   $nb = $db->sql_numrows($result); 
   if ($nb == 0) 
   { 
   //On insere ces données dans la base de données 
      $query = "INSERT INTO ".TABLE_QUIMOBSERVE." ( `spy_id` , `spy_planetteespion` , `spy_maplanette` , `sender_id` , `datadate` , `pourcentage` ) 
         VALUES ( 
            NULL , '".$planettes[2]."', '".$planettes[4]."', '".$user_data['user_id']."', '".$date."', '".$pourcentage."' 
         )"; 
      $db->sql_query($query); 
       
      //On met le message de validation 
      $retour = 1;
   } 
   else 
   { 
      $retour = 2;
   } 
  return($retour); 
} 
/**
* Importation d'un Sondage dans le mod à partir d'une barre (extension firefox)
* @param string $rapport
* @return 0 si mod non activé
* @return 1 si des espionnages ont été enregistré
* @return 2 si les espionnages ont déja été inséré
* @return 3 si aucun espionnages subit est detecté
*/
function import_espionages($rapport){ 
   //Définitions 
   global $db, $table_prefix, $user_data; 
   if (defined("OGS_PLUGIN_DEBUG")) global $fp; 
   define("TABLE_QUIMOBSERVE", $table_prefix."MOD_quimobserve");
   if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Entrée import_espionages, Rapport reçu :\n".$rapport);
    
   //On vérifie que le mod est activé 
   $query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='QuiMobserve' AND `active`='1' LIMIT 1"; 
   if (!$db->sql_numrows($db->sql_query($query))) return 0;

   $aretourner = 3;

   //$espionage = strip_tags($rapport);
   $espionage = $rapport;

    if (preg_match_all("#\s*((\d{2})\-(\d{2}) (\d{2}):(\d{2}):(\d{2})[\s,\t]+Contr.le\sa.rospatial(.*?)Probabilit.\sde\sdestruction\sde\sla\sflotte\sd'espionnage\s:\s(\d+)\s%)#si", $espionage,$matches)===false)
  	{
       if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"import_espionages: rien trouvé!\n");
       return 3; // rapport incorrecte
  	}
  	
	 if (preg_match("#((\d{2})\-(\d{2})\s+(\d{2}):(\d{2}):(\d{2})\s+\t+Contr.le\sa.rospatial(.*?)Probabilit.\sde\sdestruction\sde\sla\sflotte\sd.espionnage\s:\s(\d+)\s%)#si",$espionage,$matches)===false){
	
       if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"après  preg_match_all :".count($matches)."\nCaptures: \n1: $matches[1] \n2: $matches[2]\n 3: $matches[3]\n 4: $matches[4]\n 5: $matches[5]\n 6: $matches[6]\n 7: $matches[7]\n 8: $matches[8] ");

       if (count($matches)<2) SendHttpStatusCode("797", true, true, "Rapport espionnage ennemi mal déformaté!".count($matches));

   } else {
        if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"\nEntrée foreach\n");

        $year = date('Y');
        if(date('m') < $matches[2]){
           $year -= 1;
        }
        $timestamp = mktime($matches[4],$matches[5],$matches[6],$matches[2],$matches[3],$year);
        if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Appel insert_raport_espionage!\n");
        $retour = insert_raport_espionage($matches[7],$timestamp,$matches[8]);
        $aretourner = $retour;
    }

   if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"\nsortie foreach -> $aretourner\n");
   return($aretourner);
} 
?>
