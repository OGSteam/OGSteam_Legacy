<?php
if (!defined('IN_SPYOGAME'))
    die("Hacking attempt");

$id = $db->sql_escape_string($pub_id);
$first_date = $server_config['bigbrother'];
if (is_numeric($id)) {


    $affichage .= '<br />';
    $affichage .= '<br /><table>';
    $affichage .= '<tr>';
    $affichage .= '<td colspan="6" class="c">Depuis le ' . strftime("%d %b %Y %H:%M:%S",
        $first_date) . '</td>';
    $affichage .= '</tr>';
    $affichage .= '<tr>';
    //     $affichage .=  '<td class="c">id : ' . $cache_ally[$id]['id'] . '</td>';
    $affichage .= '<td colspan="6"  class="c">Alliance : ' . $cache_ally[$id]['tag'] .
        '</td>';
    $affichage .= '</tr>';

    $tab = null;
    $i = 0;
    /// recherche joueur actuel
    $requete = "select * from " . TABLE_PLAYER . "";
    $requete .= " where id_ally = '" . $id . "' ";
    $result = $db->sql_query($requete);
    $nb_req_1 = $db->sql_numrows($result);
    while ($row = $db->sql_fetch_assoc($result)) {

        $tab[$i][0] = '<a href="index.php?action=bigbrother&subaction=player&id=' . $row['id'] .
            '">' . $row['name_player'] . '</a>';
        $tab[$i][1] = convert_status($row['status']);
        $i++;

    }

    $i = 0;
    // recherche joueur ancien
    $requete = "select * from " . TABLE_STORY_PLAYER . "";
    $requete .= " where id_ally = '" . $id . "' ";
    
    $result = $db->sql_query($requete);
    $nb_req_2 = $db->sql_numrows($result);
    while ($row = $db->sql_fetch_assoc($result)) {
        // nous n'affichons que si n est plus dans l alliance
        if ($cache_player[$row['id_player']]['id_ally']!= $row['id_ally'] )
        {
        $tab[$i][2] = strftime("%d %b %Y %H:%M:%S", $row['datadate']);
        if ($row['name_player'] == $cache_player[$row['id_player']]['name_player']) {
            $add = "";
        } else {
            $add = " (Actuellement : '" . $cache_player[$row['id_player']]['name_player'] .
                "') ";
        }
        $tab[$i][3] = '<a href="index.php?action=bigbrother&subaction=player&id=' . $row['id_player'] .
            '">' . $row['name_player'] . '</a> ' . $add . ' ';
        if ($row['status'] == $cache_player[$row['id_player']]['status']) {
            $add = "";
        } else {
            $add = " (Actuellement : '" . $cache_player[$row['id_player']]['status'] . "') ";
        }
        $tab[$i][4] = ' ' . convert_status($row['status']) . $add . '';
        if ($row['id_ally'] == $cache_player[$row['id_player']]['id_ally']) {
            $add = "";
        } else {
            $add = " (Actuellement : '" . convert_ally($cache_player[$row['id_player']]['id_ally']) .
                "') ";
        }
        $tab[$i][5] = '' . convert_ally($row['id_ally']) . $add . '';


        $i++;
        }
    }

    $nb_row = max($nb_req_1, $i);


    $affichage .= '<tr>';
    $affichage .= '<td colspan="2" class="c">Joueurs référencés (' . $nb_req_1 .
        ')</td>';
    $affichage .= '<td colspan="4" class="c">Anciennement dans l alliance (' . $i .
        ')</td>';
    $affichage .= '</tr>';

    $affichage .= '<tr>';
    $affichage .= '<td class="c">name_player</td>';
    $affichage .= '<td class="c">status</td>';
    $affichage .= '<td class="c">date</td>';
    $affichage .= '<td class="c">Nom</td>';
    $affichage .= '<td class="c">status</td>';
    $affichage .= '<td class="c">alliance</td>';
    $affichage .= '</tr>';


    for ($i = 0; $i < $nb_row; $i++) {
        $affichage .= '<tr>';
        $affichage .= '<td class="b">' . $tab[$i][0] . '</td>';
        $affichage .= '<td class="b">' . $tab[$i][1] . '</td>';
        $affichage .= '<td class="b">' . $tab[$i][2] . '</td>';
        $affichage .= '<td class="b">' . $tab[$i][3] . '</td>';
        $affichage .= '<td class="b">' . $tab[$i][4] . '</td>';
        $affichage .= '<td class="b">' . $tab[$i][5] . '</td>';

        $affichage .= '</tr>';


    }


    $affichage .= '</table>';

    echo $affichage;

}





//datadate 	rank 	ally 	number_member 	points 	points_per_member 	sender_id



  //////// recuperation des classement \\\\
    
    $ranking = array();
    $arraydates = array();
    //datadate 	rank 	player Croissant 	ally 	points
    $request = "SELECT R.datadate ,	R.rank ,	R.ally ,	R.number_member ,	R.points , 	R.points_per_member ,  BIG.ally_id ";
    $request .= " FROM ".TABLE_RANK_ALLY_POINTS." as R ";
	$request .=  " INNER JOIN " . TABLE_RAP . " as BIG ";
    $request .=  "ON BIG.datadate = R.datadate and  BIG.rank = R.rank  ";
    $request .=  " WHERE  BIG.ally_id = '".$id."' ";
    //	$request .=  " AND  R.datadate > '".$first_date."' ";
	$result = $db->sql_query($request);
       	while (list($datadate,$rank,$ally,$number_member,$points ,$points_per_member) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["general"] = array("rank" => $rank, "ally" => $ally, "nb" => $number_member,"point" => $points, "points_per_member" => $points_per_member);
		$arraydates[]=$datadate;
	}

    $request = "SELECT R.datadate ,	R.rank ,	R.ally ,	R.number_member ,	R.points , 	R.points_per_member ,  BIG.ally_id ";
   $request .= " FROM ".TABLE_RANK_ALLY_FLEET." as R ";
	$request .=  " INNER JOIN " . TABLE_RAF . " as BIG ";
    $request .=  "ON BIG.datadate = R.datadate and  BIG.rank = R.rank  ";
    $request .=  " WHERE  BIG.ally_id = '".$id."' ";
   //	$request .=  " AND  R.datadate > '".$first_date."' ";
	$result = $db->sql_query($request);
      	 	while (list($datadate,$rank,$ally,$number_member,$points ,$points_per_member) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["fleet"] =  array("rank" => $rank, "ally" => $ally, "nb" => $number_member,"point" => $points, "points_per_member" => $points_per_member);
			$arraydates[]=$datadate;
	}
    
    
  $request = "SELECT R.datadate ,	R.rank ,	R.ally ,	R.number_member ,	R.points , 	R.points_per_member ,  BIG.ally_id ";
      $request .= " FROM ".TABLE_RANK_ALLY_RESEARCH." as R ";
	$request .=  " INNER JOIN " . TABLE_RAR . " as BIG ";
    $request .=  "ON BIG.datadate = R.datadate and  BIG.rank = R.rank  ";
    $request .=  " WHERE  BIG.ally_id = '".$id."' ";
    //	$request .=  " AND  R.datadate > '".$first_date."' ";
	$result = $db->sql_query($request);
        	 	while (list($datadate,$rank,$ally,$number_member,$points ,$points_per_member) = $db->sql_fetch_row($result)) {
		$ranking[$datadate]["research"] =   array("rank" => $rank, "ally" => $ally, "nb" => $number_member,"point" => $points, "points_per_member" => $points_per_member);
			$arraydates[]=$datadate;
	}
    

    
    


?>

<br />
<table>
<tr>
	<td colspan="13" class="c">Historique du classement alliance</td>
</tr>
<tr>
	<td  class="c">Date</td>
	<td colspan="5" class="c">Pts Général</td>
	<td colspan="5" class="c">Pts Flotte</td>
	<td colspan="5" class="c">Pts Recherche</td>
</tr>
<?php

$arraydates = array_unique ($arraydates);
sort($arraydates);


foreach($arraydates AS $arraydate)
{
    echo '<tr>';
	echo '<th>'.strftime("%d %b %Y %H:%M:%S", $arraydate).'</th>';
//	echo '<td class="b">'.$ranking[$arraydate]['general']['player'].'</td>';
//	echo '<td class="b">'.$ranking[$arraydate]['general']['player'].'</td>';
if (isset($ranking[$arraydate]['general']['rank']))
{
echo '<td class="c">'.($ranking[$arraydate]['general']['rank']).'</td>';
echo '<th>'.($ranking[$arraydate]['general']['ally']).'</th>';
echo '<td class="b">'.formate_number($ranking[$arraydate]['general']['nb']).'</td>';
echo '<th>'.formate_number($ranking[$arraydate]['general']['point']).'</th>';
echo '<th>'.formate_number($ranking[$arraydate]['general']['points_per_member']).'</th>';

}
else
{
  echo '<th></th>';
  echo '<th></th>';  
echo '<th></th>';
  echo '<th></th>';  
  echo '<th></th>';  
}
if (isset($ranking[$arraydate]['fleet']['rank']))
{
echo '<td class="c">'.($ranking[$arraydate]['fleet']['rank']).'</td>';
echo '<th>'.($ranking[$arraydate]['fleet']['ally']).'</th>';
echo '<td class="b">'.formate_number($ranking[$arraydate]['fleet']['nb']).'</td>';
echo '<th>'.formate_number($ranking[$arraydate]['fleet']['point']).'</th>';
echo '<th>'.formate_number($ranking[$arraydate]['fleet']['points_per_member']).'</th>';
}
else
{
  echo '<th></th>';
  echo '<th></th>';  
  echo '<th></th>';
  echo '<th></th>';  
 echo '<th></th>';  

}
if (isset($ranking[$arraydate]['research']['rank']))
{
echo '<td class="c">'.($ranking[$arraydate]['research']['rank']).'</td>';
echo '<th>'.($ranking[$arraydate]['research']['ally']).'</th>';
echo '<td class="b">'.formate_number($ranking[$arraydate]['research']['nb']).'</td>';
echo '<th>'.formate_number($ranking[$arraydate]['research']['point']).'</th>';
echo '<th>'.formate_number($ranking[$arraydate]['research']['points_per_member']).'</th>';}
else
{
  echo '<th></th>';
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




