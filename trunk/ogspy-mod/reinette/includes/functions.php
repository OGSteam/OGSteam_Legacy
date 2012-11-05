<?php
global $table_prefix;

define("TABLE_TMP", $table_prefix."tmp_universe");




function valid_date($time)
{
    /// il faut garder le format ogspy ( toutes les 8 heeures ... ) )
   $temp= getdate($time);
   
   // on format la date
   $temp['seconds'] = 0;
   $temp['minutes'] = 0;
   if ($temp['hours'] >= 0 && $temp['hours'] < 8 ){ $temp['hours'] = 0; } 
   if ($temp['hours'] >= 8 && $temp['hours'] < 16 ){ $temp['hours'] = 8; } 
   if ($temp['hours'] >= 16 && $temp['hours'] < 24 ){ $temp['hours'] = 16; } 
   $temp['hours'] = 0;
    
   $time = mktime($temp['hours'], $temp['minutes'], $temp['seconds'], $temp['mon'], $temp['mday'],$temp['year'] ); 
   return $time;
}


function generique_rank_player($mydata,$table)
{
     global $db,$user_data;

  $query = array();
  $mydata = '<?xml version="1.0" encoding="UTF-8"?>'.$mydata;

   $data = new DomDocument();
 $data->loadXML(utf8_encode($mydata));
 
$element = $data->getElementsByTagName('x'); 
$nb_total = 0;

// si pas de noeud on previent ( bug)
if ($element->length==0) { 
  db_xml::generate_simple_xlm(array('ref' => 'Message ogspy', 'cause' => 'Aucun noeud enfant '.$table), 'Echec');

die;
} 
                
foreach($element as $elements)
{
$nb_total++;    
$a = $elements->getElementsByTagName('a')->item(0)->nodeValue; 
$n = $elements->getElementsByTagName('n')->item(0)->nodeValue; 
$p = $elements->getElementsByTagName('p')->item(0)->nodeValue; 
$d = $elements->getElementsByTagName('d')->item(0)->nodeValue; 
$s = $elements->getElementsByTagName('s')->item(0)->nodeValue; 

$query[] = '(' . valid_date((int)$d) . ', ' . (int)$p .  ', "' . quote(utf8_decode($n)) . '", "' . quote(utf8_decode($a)) . '", ' . (int)$s . ', ' . $user_data['user_id'] . ')';

} 

$db->sql_query('REPLACE INTO ' . $table .  ' (datadate, rank, player, ally, points, sender_id) VALUES ' . implode(',', $query));
//echo 'REPLACE INTO ' . $table .  ' (datadate, rank, player, ally, points, sender_id) VALUES ' . implode(',', $query);
db_xml::generate_simple_xlm(array('ref' => 'Message ogspy', 'cause' => 'Insertion de '.$nb_total.' lignes'), 'Réussi');

die;

    
    
}
  
function universe($mydata)
{
global $db,$user_data,$pub_sub_value , $table_can_use ,$pub_table,$pub_min,$pub_max;
    
$g = (int)$pub_sub_value ;
     
$query = array();
$mydata = '<?xml version="1.0" encoding="UTF-8"?>'.$mydata;
$data = new DomDocument();
$data->loadXML(utf8_encode($mydata));
 
// on recupere la list de noeud 
$element = $data->getElementsByTagName('x'); 

// dans un premier temps on recupere le timestamp de la maj
$timestamp = $element->item(0)->getElementsByTagName('d')->item(0)->nodeValue;

// on prepare la requete
$query = array();

// si pas de noeud on previent ( bug)
if ($element->length==0) { 
  db_xml::generate_simple_xlm(array('ref' => 'Message ogspy', 'cause' => 'Aucun noeud enfant '.$table), 'Echec');

die;
} 


$timestamp = $timestamp ;



foreach($element as $elements)
{
  
  $n =  iif($elements->getElementsByTagName('n')->item(0)->nodeValue == null ||$elements->getElementsByTagName('n')->item(0)->nodeValue == "", "" ,quote(utf8_decode($elements->getElementsByTagName('n')->item(0)->nodeValue))); 
  $a =  iif($elements->getElementsByTagName('a')->item(0)->nodeValue == null ||$elements->getElementsByTagName('a')->item(0)->nodeValue == "", "" ,quote(utf8_decode($elements->getElementsByTagName('a')->item(0)->nodeValue))); 
  $st =  quote(utf8_decode($elements->getElementsByTagName('st')->item(0)->nodeValue));
  $g =  (int)$elements->getElementsByTagName('g')->item(0)->nodeValue;
  $s =  (int)$elements->getElementsByTagName('s')->item(0)->nodeValue;
  $r =  (int)$elements->getElementsByTagName('r')->item(0)->nodeValue;
  $pn =  iif($n=="" , "" , quote(utf8_decode($elements->getElementsByTagName('pn')->item(0)->nodeValue))); 
  $m =  iif((int)$elements->getElementsByTagName('m')->item(0)->nodeValue < 1, 0 ,1);  
  //$mn = iif($m==0 , "" , quote(utf8_decode($elements->getElementsByTagName('mn')->item(0)->nodeValue))); 
  $d =  (int)$elements->getElementsByTagName('d')->item(0)->nodeValue;
  $u =  $user_data['user_id'];
  


$query[] = '("' .$db->sql_escape_string($n). '", "' .$db->sql_escape_string($a).  '", "' .$db->sql_escape_string($st). '", "' .(int)$g. '", "' . (int)$s . '", "' . (int)$r . '", "' . $db->sql_escape_string($pn) . '","' . (int)$m . '","' .(int)$d. '","' .(int)$u. '")';
  
     }
     
   
 //} 

// var_dump($query) ;
$table = $table_can_use[$pub_table];

if (count($query) > 0 ){
    
 // on remplit la table tampon  
$db->sql_query('REPLACE INTO ' . TABLE_TMP .  ' ( player , ally, status,galaxy,system,row,name,moon,last_update ,last_update_user_id) VALUES ' . implode(',', $query));
//$db->sql_query('REPLACE INTO ' . $table .  ' ( player , ally, status,galaxy,system,row,name,moon,last_update,last_update_user_id , gate, phalanx) VALUES ' . implode(',', $query));

// requete de mise a jour a partir du tampon
$req_update = "";
$req_update .= " UPDATE ".TABLE_UNIVERSE." as U INNER JOIN ".TABLE_TMP." as T ";
$req_update .= " ON ";
$req_update .= "  ( U.galaxy = T.galaxy AND U.row = T.row  AND U.system = T.system )   ";
$req_update .= " SET ";
$req_update .= " U.moon = T.moon , U.name = T.name  , U.ally = T.ally , U.player = T.player , U.status = T.status   , U.last_update = T.last_update   , U.last_update_user_id = T.last_update_user_id  ";
$req_update .= " WHERE  ";
$req_update .= "  U.last_update < T.last_update ";

$db->sql_query($req_update);

// on vide la table tampon
$req_truncate = " ";
$req_truncate.= "TRUNCATE ".TABLE_TMP." ";
$db->sql_query($req_truncate);

 db_xml::generate_simple_xlm(array('ref' => 'Message ogspy', 'cause' => 'Mise a jour de  '.count($query).' lignes'), 'Reussi');

//echo 'INSERT IGNORE INTO ' . $table .  ' ( player , ally, status,galaxy,system,row,name,moon,last_update,last_update_user_id) VALUES ' . implode(',', $query);
die;  
  }
  else{
    //$db->sql_query('REPLACE INTO ' . $table .  ' ( player , ally, status,galaxy,system,row,name,moon,last_update,last_update_user_id) VALUES ' . implode(',', $query));
db_xml::generate_simple_xlm(array('ref' => 'Message ogspy', 'cause' => 'Mise a jour de 0 lignes'), 'Reussi');

//echo 'INSERT IGNORE INTO ' . $table .  ' ( player , ally, status,galaxy,system,row,name,moon,last_update,last_update_user_id) VALUES ' . implode(',', $query);
die;  
  }
}      


function rank_player_points($mydata,$table)
{
   generique_rank_player($mydata,$table);
}
function rank_player_eco($mydata,$table)
{
   generique_rank_player($mydata,$table);
}
function rank_player_Research($mydata,$table)
{
   generique_rank_player($mydata,$table);
}
function rank_player_Military($mydata,$table)
{
     generique_rank_player($mydata,$table);
  // var_dump("erreur !!!! nom implementé");
}
function rank_player_Military_Built($mydata,$table)
{
   generique_rank_player($mydata,$table);
}
function rank_player_Military_Destroyed($mydata,$table)
{
   generique_rank_player($mydata,$table);
}
function rank_player_Military_Lost($mydata,$table)
{
   generique_rank_player($mydata,$table);
}
function rank_player_honnor($mydata,$table)
{
   generique_rank_player($mydata,$table);
}

function quote($str)
{
    return (MAGIC_QUOTES ? $str : addslashes($str));
}

function iif($condition,$ok,$nok='') {
	return ($condition ? $ok : $nok);
}
