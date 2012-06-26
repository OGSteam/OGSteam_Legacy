<?php
/// a voir
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
 
$element = $data->getElementsByTagName('serverdata'); 
                
foreach($element as $elements)
{
$a = $elements->getElementsByTagName('a')->item(0)->nodeValue; 
$n = $elements->getElementsByTagName('n')->item(0)->nodeValue; 
$p = $elements->getElementsByTagName('p')->item(0)->nodeValue; 
$d = $elements->getElementsByTagName('d')->item(0)->nodeValue; 
$s = $elements->getElementsByTagName('s')->item(0)->nodeValue; 

$query[] = '(' . valid_date((int)$d) . ', ' . (int)$p .  ', "' . quote(utf8_decode($n)) . '", "' . quote(utf8_decode($a)) . '", ' . (int)$s . ', ' . $user_data['user_id'] . ')';

} 

$db->sql_query('REPLACE INTO ' . $table .  ' (datadate, rank, player, ally, points, sender_id) VALUES ' . implode(',', $query));
//echo 'REPLACE INTO ' . $table .  ' (datadate, rank, player, ally, points, sender_id) VALUES ' . implode(',', $query);
die;

    
    
}
  
function universe($mydata)
{
     global $db,$user_data,$pub_sub_value , $table_can_use ,$pub_table;
     
     $g = (int)$pub_sub_value ;
     
$query = array();
$mydata = '<?xml version="1.0" encoding="UTF-8"?>'.$mydata;
$data = new DomDocument();
$data->loadXML(utf8_encode($mydata));
 
// on recupere la list de noeud 
$element = $data->getElementsByTagName('serverdata'); 

// dans un premier temps on recupere le timestamp de la maj
$timestamp = $element->item(0)->getElementsByTagName('d')->item(0)->nodeValue;

// on supprime de la table uni tout ce qui est plus ancien

$request = "DELETE FROM ".$table_can_use[$pub_table]." WHERE last_update < ".$timestamp." and galaxy = ".$g ;
$db->sql_query($request);

// on prepare la requete
$query = array();
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
 //<serverdata>
  //  <n>Akira</n>
  //  <a>KISSCOOL</a>
  //  <st />
  //  <g>1</g>
 //   <s>1</s>
 //   <r>6</r>
 //   <pn>N�o-Tokyo</pn>
  //  <m>33620234</m>
 //   <mn>SOL</mn>
  //  <d>1340203405</d>
 // </serverdata>

$query[] = '("' .$db->sql_escape_string($n). '", "' .$db->sql_escape_string($a).  '", "' .$db->sql_escape_string($st). '", ' .(int)$g. ', ' . (int)$s . ', ' . (int)$r . ', "' . $db->sql_escape_string($pn) . '","' . (int)$m . '",' .(int)$d. ', ' .(int)$u. ')';

} 

// var_dump($query) ;
$table = $table_can_use[$pub_table];

$db->sql_query('INSERT IGNORE INTO ' . $table .  ' ( player , ally, status,galaxy,system,row,name,moon,last_update,last_update_user_id) VALUES ' . implode(',', $query));
//echo 'INSERT IGNORE INTO ' . $table .  ' ( player , ally, status,galaxy,system,row,name,moon,last_update,last_update_user_id) VALUES ' . implode(',', $query);
die;  
  
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
