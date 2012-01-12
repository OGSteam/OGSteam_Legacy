<?php
//definition des tables
global $table_prefix;
define("TABLE_EXPEDITION", $table_prefix."expedition");
define("TABLE_EXPEDITION_TYPE_1", $table_prefix."expedition_type_1");
define("TABLE_EXPEDITION_TYPE_2", $table_prefix."expedition_type_2");
/**
*
* @return int 0 => rapport non valide / 1 => traitement OK / 2 => rapport déjà existant
**/
function analyseRapport($raw)
{
  global $db, $user_data, $fp;
  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Début de l'enregistrement du rapport \"$raw\"\n");
  // on enleve les séparateurs
  $raw = preg_replace ( '/(\d+)\.(\d+)/', "$1$2", $raw );
  //Compatibilité UNIX/Windows
  $raw = str_replace("\r\n","\n",$raw);
  //Compatibilité IE/Firefox
  $raw = str_replace("\t",' ',$raw);
  //pour l'apostrophe !
  $raw = stripslashes($raw);
  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Pré-traitement du rapport \"$raw\"\n");
  // Tout d'abord si il a été soumis un RExp :
  $regExEntete = "/(\d+-\d+\s\d+:\d+:\d+)\s+Quartier\sgénéral\s+Résultat\sde\sl'expédition\s\[(\d+:\d+:\d+)\]\n+/i";
  $regExVaiss = "/.*?voici\sles\snouveaux\svaisseaux\s.*?\s:\s(.*?)\s\s/i";
  $regExRess = "/.*?Vous\savez\scollecté\s(\d+)\sunités\sde\s(.+?)\s\./i";
  
  if ( ! preg_match ( $regExEntete, $raw, $expDate ) )
  {
    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"L'entête du rapport n'est pas valide !\n");
    return 0;
  }
  else
  {
    $tmp = explode ( ' ', $expDate[1] );
    $date = explode ( '-', $tmp[0] );
    $heure = explode ( ':', $tmp[1] );
    if( $date[0] > date ( 'm' ) )
      $year = date('Y') - 1;
    else
      $year = date('Y');      
    $timestmp = mktime ( $heure[0], $heure[1], $heure[2], $date[0], $date[1], $year);
    $dateTmp = date('Y-m-d H:i:s', $timestmp);
    $tmp = explode ( ':', $expDate[2] );
    $galaxy = $tmp[0];
    $systeme = $tmp[1];
    $raw = $raw = str_replace ( "\n", ' ', preg_replace ( $regExEntete, '', $raw ) );
    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Date du rapport : $dateTmp / Système : $galaxy:$systeme\nRapport : \"$raw\"\n");
  }
  if ( defined ( 'OGS_PLUGIN_DEBUG' ) && ( ! isset ( $db ) || empty ( $db ) ) ) fwrite($fp,"\$db non défini !!!!\n");

  if ( preg_match ( $regExVaiss, $raw, $expsVaiss ) )
  {
    $units = 0;
    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Rapport de type vaisseaux : \"" . $expsVaiss[1] . "\"\n");
    $pt = $gt = $cle = $clo = $cr = $vb = $vc = $rec = $se = $bmb = $dst = $tra = 0;
    if(preg_match("/.*?Petit\stransporteur\s(\d+).*?/i", $expsVaiss[1], $reg))
    {
      $pt = $reg[1];
      $units += 4 * $pt;
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Petit transporteur : " . $reg[1] . "\n");
    }
    if(preg_match("/.*?Grand\stransporteur\s(\d+).*?/i", $expsVaiss[1], $reg))
    {
      $gt = $reg[1]; 
      $units += 12 * $gt;
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Grand transporteur : " . $reg[1] . "\n");
    }
    if(preg_match("/.*?Chasseur\sléger\s(\d+).*?/i", $expsVaiss[1], $reg))
    {
      $cle = $reg[1]; 
      $units += 4 * $cle;
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Chasseur léger : " . $reg[1] . "\n");
    }
    if(preg_match("/.*?Chasseur\slourd\s(\d+).*?/i", $expsVaiss[1], $reg))
    {
      $clo = $reg[1]; 
      $units += 10 * $clo;
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Chasseur lourd : " . $reg[1] . "\n");
    }
    if(preg_match("/.*?Croiseur\s(\d+).*?/i", $expsVaiss[1], $reg))
    {
      $cr = $reg[1]; 
      $units += 29 * $cr;
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Croiseur : " . $reg[1] . "\n");
    }
    if(preg_match("/.*?Vaisseau\sde\sbataille\s(\d+).*?/i", $expsVaiss[1], $reg))
    {
      $vb = $reg[1]; 
      $units += 60 * $vb;
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Vaisseau de bataille : " . $reg[1] . "\n");
    }
    if(preg_match("/.*?Vaisseau\sde\scolonisation\s(\d+).*?/i", $expsVaiss[1], $reg))
    {
      $vc = $reg[1]; 
      $units += 40 * $vc;
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Vaisseau de colonisation : " . $reg[1] . "\n");
    }
    if(preg_match("/.*?Recycleur\s(\d+).*?/i", $expsVaiss[1], $reg))
    {
      $rec = $reg[1]; 
      $units += 18 * $rec;
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Recycleur : " . $reg[1] . "\n");
    }
    if(preg_match("/.*?Sonde\sespionnage\s(\d+).*?/i", $expsVaiss[1], $reg))
    {
      $se = $reg[1]; 
      $units += $se;
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Sonde : " . $reg[1] . "\n");
    }
    if(preg_match("/.*?Bombardier\s(\d+).*?/i", $expsVaiss[1], $reg))
    {
      $bmb = $reg[1]; 
      $units += 90 * $bmb;
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Bombardier : " . $reg[1] . "\n");
    }
    if(preg_match("/.*?Destructeur\s(\d+).*?/i", $expsVaiss[1], $reg))
    {
      $dst = $reg[1]; 
      $units += 125 * $dst;
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Destructeur : " . $reg[1] . "\n");
    }
    if(preg_match("/.*?Traqueur\s(\d+).*?/i", $expsVaiss[1], $reg))
    {
      $tra = $reg[1]; 
      $units += 85 * $tra;
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Traqueur : " . $reg[1] . "\n");
    }
    $query = "Select * From " . TABLE_EXPEDITION . " Where user_id = ".$user_data['user_id']." and `date` = $timestmp and pos_galaxie = $galaxy and pos_sys = $systeme and type = 2";
    $result = mysql_query($query);
    if(mysql_num_rows($result) == 0)
    {
      $query = "Insert into " . TABLE_EXPEDITION . " (id, user_id, date, pos_galaxie, pos_sys, type) values ('', ".$user_data['user_id'].", $timestmp, $galaxy, $systeme, 2)";
      mysql_query($query);
      $idInsert = mysql_insert_id();
      $query = "Insert into " . TABLE_EXPEDITION_TYPE_2 . " (id, id_eXpedition, pt, gt, cle, clo, cr, vb, vc, rec, se, bmb, dst, tra, units) values ('', $idInsert, $pt, $gt, $cle, $clo, $cr, $vb, $vc, $rec, $se, $bmb, $dst, $tra, $units)";
      mysql_query($query);
    }
    else
      return 2;
  }
  elseif ( preg_match ( $regExRess, $raw, $expsRess ) )
  {
    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Rapport de type ressources : " . join ( '/', $expsRess ) . "\n");
    $typeRess = -1;
    $met = $cri = $deut = $antimat = 0;
    if ( $expsRess[2] == 'Métal' )
    {
      $met = $expsRess[1];
      $typeRess = 0;
    }
    if ( $expsRess[2] == 'Cristal' )
    {
      $cri = $expsRess[1];
      $typeRess = 1;
    }
    if ( $expsRess[2] == 'Deutérium' )
    {
      $deut = $expsRess[1];
      $typeRess = 2;
    }
    if ( $expsRess[2] == 'Antimatière' )
    {
      $antimat = $expsRess[1];
      $typeRess = 3;
    }
    if($typeRess == -1)
      return 3;
    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Ressource détectée : ${expsRess[2]} / Quantité : ${expsRess[1]}\n");
    $query = "Select * From " . TABLE_EXPEDITION . " Where user_id = ".$user_data['user_id']." and `date` = $timestmp and pos_galaxie = $galaxy and pos_sys = $systeme and type = 1";
    $result = mysql_query($query);
    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Rapport trouvé : " . mysql_num_rows($result) . "\n");
    if(mysql_num_rows($result) == 0)
    {
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Insertion rapport : Insert into " . TABLE_EXPEDITION . " (id, user_id, date, pos_galaxie, pos_sys, type) values ('', ".$user_data['user_id'].", $timestmp, $galaxy, $systeme, 1)\n");
      $query = "Insert into " . TABLE_EXPEDITION . " (id, user_id, date, pos_galaxie, pos_sys, type) values ('', ".$user_data['user_id'].", $timestmp, $galaxy, $systeme, 1)";
      mysql_query($query);
      $idInsert = mysql_insert_id();
      $query = "Insert into " . TABLE_EXPEDITION_TYPE_1 . " (id, id_eXpedition, typeRessource, metal, cristal, deuterium, antimatiere) values ('', $idInsert, $typeRess, $met, $cri, $deut, $antimat)";
      mysql_query($query);
    }
    else
      return 2;
  }
  else
  {
    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Rapport de type rien ou marchand\n");
    if ( preg_match ( "liste\sde\sclients\sprivilégiés", $expsRienouM[1] ) )
    {
      $query = "Select * From " . TABLE_EXPEDITION . " Where user_id = ".$user_data['user_id']." and `date` = $timestmp and pos_galaxie = $galaxy and pos_sys = $systeme and type = 3";
      $result = mysql_query ( $query );
      if ( mysql_num_rows ( $result ) == 0 )
      {
        $query = "Insert into " . TABLE_EXPEDITION . " (id, user_id, date, pos_galaxie, pos_sys, type) values ('', ".$user_data['user_id'].", $timestmp, $galaxy, $systeme, 3)";
        mysql_query ( $query );
        $idInsert = mysql_insert_id();
      }
      else
        return 2;
    }
    else
    {
      $query = "Select * From " . TABLE_EXPEDITION . " Where user_id = ".$user_data['user_id']." and `date` = $timestmp and pos_galaxie = $galaxy and pos_sys = $systeme and type = 0";
      $result = mysql_query ( $query );
      if ( mysql_num_rows($result) == 0 )
      {
        $query = "Insert into " . TABLE_EXPEDITION . " (id, user_id, date, pos_galaxie, pos_sys, type) values ('', ".$user_data['user_id'].", $timestmp, $galaxy, $systeme, 0)";
        mysql_query ( $query );
        $idInsert = mysql_insert_id();
      }
      else
        return 2;
    }
  }
  return 1;
}
?>