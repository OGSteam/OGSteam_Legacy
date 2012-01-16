<?php
if (!defined('IN_SPYOGAME'))
    die("Hacking attempt");

$total = player_count("total");
$actif = player_count("actif");
$attente = player_count("attente");
$rip = $total - $actif - $attente; /// si valeur négative pb avec jointure ....
$total_ally = ally_count("total");
$actif_ally = ally_count("actif");
$rip_ally = $total_ally - $actif_ally;




?>

<table>
<tr>
<td colspan="4" class="c" >Depuis le <?php echo strftime("%d %b %Y %H:%M:%S", $server_config['bigbrother']); ?></td>
</tr>
<tr>
<td colspan="2" class="c" >Joueur</td>
<td colspan="2" class="c"  >Alliance</td>
</tr>
<tr>
<td  width="250"  class="b"  >Nombre de joueur Total :</td>
<td width="50" class="b"  ><?php echo $total; ?></td>
<td  width="250" class="b"  >Nombre de ally Total :</td>
<td width="50" class="b"  ><?php echo $total_ally; ?></td>
</tr>
<tr>
<td  width="250"  class="b"  >Nombre de joueur actif :</td>
<td width="50" class="b"  ><?php echo $actif; ?></td>
<td  width="250" class="b"  >Nombre de ally actif :</td>
<td width="50" class="b"  ><?php echo $actif_ally; ?></td>
</tr>
<tr>
<td  width="250"  class="b"  >Nombre de joueur disparu :</td>
<td width="50" class="b"  ><?php echo $rip; ?></td>
<td  width="250" class="b"  >Nombre de ally disparu : ( ou non renseigné )</td>
<td width="50" class="b"  ><?php echo $rip_ally; ?></td>
</tr>
<tr>
<td  width="250"  class="b"  >Nombre de joueur en attente :</td>
<td width="50" class="b"  ><?php echo $attente; ?></td>
<td  width="250" class="b"  ></td>
<td width="50" class="b"  ></td>
</tr>
</table>
<br />


 <?php
          
            $requete = "select COUNT(" . TABLE_PLAYER . ".id) as compteur," . TABLE_PLAYER . ".status from " . TABLE_PLAYER . " ";
            $requete .= "JOIN " . TABLE_UNI . " ";
            $requete .= "ON " . TABLE_UNI . ".id_player = " . TABLE_PLAYER . ".id ";
            $requete .= " GROUP BY " . TABLE_PLAYER . ".status ";

    $result = $db->sql_query($requete);
    $legend = null;
    $value = null;
    
     while ($row = $db->sql_fetch_assoc($result)) {
        if ($row['status'] == ""){
            $row['status'] = 'Actif';
        }
        $legend[]=$row['status'] ;
        $value[]= $row['compteur'];
        
        }



$pie_player="";
echo "<table><tr><td  width=\"600\">";
echo "<div id='pie_player'>";
echo "Pas de données dans la base";
echo "</div>";
echo "</td></tr></table>";
if (isset($value) && isset ($legend))
{
$pie_player = create_pie(implode($value, "_x_"), implode($legend, "_x_"),
        "Dernière répartition des joueurs actifs", "pie_player");    
    
}
// autrement on affiche rien : on prepare juste l affichage du script

    
echo $pie_player;
?>


