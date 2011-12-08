<?php
if (!defined('IN_SPYOGAME'))
    die("Hacking attempt");
    
 $id = $db->sql_escape_string($pub_id);
 $first_date= $server_config['bigbrother'];
if ( is_numeric($id)){
         
        $requete = "select * from " . TABLE_PLAYER . "";
        $requete .= " where id = '" . $id . "' ";
                


            $affichage .= '<br /><table>';
            $affichage .= '<tr>';
            $affichage .=  '<td colspan="3" class="c">Actuellement</td>';
            $affichage .=  '	</tr>';
            $affichage .= '<tr>';
             $affichage .=  '<td width="100" class="c">name_player</td>';
             $affichage .=  '<td width="100" class="c">status</td>';
             $affichage .=  '<td width="100" class="c">alliance</td>';
            $affichage .=  '	</tr>';

            $result = $db->sql_query($requete);


            while ($row = $db->sql_fetch_assoc($result)) {
                $affichage .=  '<tr>';
                 $affichage .=  '<td class="b">' . $row['name_player'] . '</td>';
                 $affichage .=  '<td class="b">' . convert_status($row['status']) . '</td>';
                 $affichage .=  '<td class="b">' . convert_ally($row['id_ally']) . '</td>';
                $affichage .=  '</tr>';


            }
            $affichage .=  '</table>';
    
     
     
     
     
     
       $requete = "select * from " . TABLE_STORY_PLAYER . "";
       $requete .= " where id_player = '" . $id . "' ";


            $affichage .= '<br /><table>';
             $affichage .= '<tr>';
            $affichage .=  '<td colspan="4" class="c">Historique du joueur</td>';
            $affichage .=  '	</tr>';
            $affichage .= '<tr>';
            $affichage .=  '<td width="150" class="c">jusqu au</td>';
            $affichage .=  '<td width="100" class="c">Nom</td>';
            $affichage .=  '<td width="100" class="c">status</td>';
            $affichage .=  '<td width="100" class="c">alliance</td>';

            $affichage .=  '	</tr>';

            $result = $db->sql_query($requete);


            while ($row = $db->sql_fetch_assoc($result)) {
                $affichage .=  '<tr>';
                $affichage .=  '<td  class="b">' . strftime("%d %b %Y %H:%M:%S", $row['datadate']) . '</td>';
                $affichage .=  '<td  class="b">' . $row['name_player'] . '</td>';
                $affichage .=  '<td  class="b">' . convert_status($row['status']) . '</td>';
                $affichage .=  '<td  class="b">' .  convert_ally($row['id_ally']) . '</td>';
                $affichage .=  '	</tr>';


            }
            $affichage .=  '</table>';
    
    
    
    
    
    echo $affichage ;
    
    
    
    
    
    
    
    
    //////// recuperation des classement \\\\
    
    $ranking = array();
    $arraydate = array();
    //datadate 	rank 	player Croissant 	ally 	points
    $request = "SELECT R.datadate,  R.rank, R.points , R.player, R.ally , BIG.player_id ";
    $request .= " FROM ".TABLE_RANK_PLAYER_POINTS." as R ";
	$request .=  " INNER JOIN " . TABLE_RPP . " as BIG ";
    $request .=  "ON BIG.datadate = R.datadate and  BIG.rank = R.rank  ";
    $request .=  " WHERE  BIG.player_id = '".$id."' ";
    //	$request .=  " AND  R.datadate > '".$first_date."' ";
	$result = $db->sql_query($request);
       	while (list($datadate ,$rank, $points, $player , $ally) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["general"] = array("rank" => $rank, "points" => $points,"player" => $player, "ally" => $ally);
		$arraydate[]=$datadate;
	}
    
      $request = "SELECT R.datadate,  R.rank, R.points , R.player, R.ally , BIG.player_id ";
    $request .= " FROM ".TABLE_RANK_PLAYER_FLEET." as R ";
	$request .=  " INNER JOIN " . TABLE_RPF . " as BIG ";
    $request .=  "ON BIG.datadate = R.datadate and  BIG.rank = R.rank  ";
    $request .=  " WHERE  BIG.player_id = '".$id."' ";
    //	$request .=  " AND  R.datadate > '".$first_date."' ";
	$result = $db->sql_query($request);
      	while (list($datadate ,$rank, $points, $player , $ally) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["fleet"] = array("rank" => $rank, "points" => $points,"player" => $player, "ally" => $ally);
			$arraydate[]=$datadate;
	}
    
    
     $request = "SELECT R.datadate,  R.rank, R.points , R.player, R.ally , BIG.player_id ";
    $request .= " FROM ".TABLE_RANK_PLAYER_RESEARCH." as R ";
	$request .=  " INNER JOIN " . TABLE_RPR . " as BIG ";
    $request .=  "ON BIG.datadate = R.datadate and  BIG.rank = R.rank  ";
    $request .=  " WHERE  BIG.player_id = '".$id."' ";
    //	$request .=  " AND  R.datadate > '".$first_date."' ";
	$result = $db->sql_query($request);
        	while (list($datadate ,$rank, $points, $player , $ally) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["research"] = array("rank" => $rank, "points" => $points,"player" => $player, "ally" => $ally);
			$arraydate[]=$datadate;
	}
    

    
    


    
    
    
    
    
    
}

?>
<br />
<table>
<tr>
	<td colspan="13" class="c">Historique du classement joueur</td>
</tr>
<tr>
	<td  class="c">Date</td>
	<td colspan="4" class="c">Pts Général</td>
	<td colspan="4" class="c">Pts Flotte</td>
	<td colspan="4" class="c">Pts Recherche</td>
</tr>
<?php
$arraydate = array_unique ($arraydate);
ksort($arraydate);
for ($i = 0; $i < count($arraydate); $i++) {
    echo '<tr>';
	echo '<th>'.strftime("%d %b %Y %H:%M:%S", $arraydate[$i]).'</th>';
//	echo '<td class="b">'.$ranking[$arraydate[$i]]['general']['player'].'</td>';
//	echo '<td class="b">'.$ranking[$arraydate[$i]]['general']['player'].'</td>';
if (isset($ranking[$arraydate[$i]]['general']['rank']))
{
echo '<td class="c">'.($ranking[$arraydate[$i]]['general']['player']).'</td>';
echo '<th>'.($ranking[$arraydate[$i]]['general']['ally']).'</th>';
echo '<td class="b">'.formate_number($ranking[$arraydate[$i]]['general']['rank']).'</td>';
echo '<th>'.formate_number($ranking[$arraydate[$i]]['general']['points']).'</th>';
}
else
{
  echo '<th></th>';
  echo '<th></th>';  
echo '<th></th>';
  echo '<th></th>';  
}
if (isset($ranking[$arraydate[$i]]['fleet']['rank']))
{
echo '<td class="c">'.($ranking[$arraydate[$i]]['fleet']['player']).'</td>';
echo '<th>'.($ranking[$arraydate[$i]]['fleet']['ally']).'</th>';
echo '<td class="b">'.formate_number($ranking[$arraydate[$i]]['fleet']['rank']).'</td>';
echo '<th>'.formate_number($ranking[$arraydate[$i]]['fleet']['points']).'</th>';
}
else
{
  echo '<th></th>';
  echo '<th></th>';  
  echo '<th></th>';
  echo '<th></th>';  

}
if (isset($ranking[$arraydate[$i]]['research']['rank']))
{
	echo '<td class="c">'.($ranking[$arraydate[$i]]['research']['player']).'</td>';
	echo '<th>'.($ranking[$arraydate[$i]]['research']['ally']).'</th>';
	echo '<td class="b">'.formate_number($ranking[$arraydate[$i]]['research']['rank']).'</td>';
	echo '<th>'.formate_number($ranking[$arraydate[$i]]['research']['points']).'</th>';
}
else
{
  echo '<th></th>';
  echo '<th></th>'; 
  echo '<th></th>';
  echo '<th></th>';  
 
}
	echo '</tr>';
  
  
  
  
}






?>
</table>
<?php

