<?php
/**
* rank_maj.php 
* @package MAJ
* @author ben.12
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME')) {
   die("Hacking attempt");
}

define("TABLE_MAJ", $table_prefix."maj");

$admin = isset($pub_admin)?$pub_admin:0;

// Adiministration:
if(isset($pub_rank) && isset($pub_name_id) && ($user_data["user_admin"]==1 || $user_data["user_coadmin"]==1)) {
	
	if(is_numeric($pub_rank) && $pub_rank>=-6 && $pub_rank<=-1 && is_numeric($pub_name_id)) {
		$request = "update ".TABLE_MAJ." set name_id = ".intval($pub_name_id);
        $request .= " where div_type = ".intval($pub_rank);
        $db->sql_query($request);
        if ($db->sql_affectedrows() == 0) {
            $request = "insert ignore into ".TABLE_MAJ."(div_type, div_nb, name_id) values (".intval($pub_rank).", 0, ".intval($pub_name_id).")";
            $db->sql_query($request);
        }
	}
	redirection("index.php?action=mod_maj&subaction=rank&admin=".$admin);
}

//Affichage de l'administration:
$users = user_get();

if($user_data["user_admin"]==1 || $user_data["user_coadmin"]==1) {
   ?>
<table border='1'><tr>
	<td class='c' colspan='2'><a href="index.php?action=mod_maj&subaction=rank&admin=<?php echo $admin==1?0:1; ?>">Administration</td>
	</tr>
<?php if($admin) { ?>
	   <form action="index.php?action=mod_maj&subaction=rank&admin=<?php echo $admin; ?>" method="post">
	   <td>
	   
	   <table><tr>
	   <td class="c">Classement:</td>
       <td class="c">membre responsable:</td>
       </tr>
	   <tr><th>
	   <select name="rank">
               <option value="-1" selected>Joueurs Général</option>
               <option value="-2" >Joueurs Flotte</option>
               <option value="-3" >Joueurs Recherche</option>
               <option value="-4" >Alliances Général</option>
			   <option value="-5" >Alliances Flotte</option>
			   <option value="-6" >Alliances Recherche</option>
       </select>
       </th><th>
       <select name="name_id">
	   			<option value="0" selected>aucun</option>
               <?php
                   foreach($users as $v) {
				   		echo "<option value=".$v["user_id"].">".$v["user_name"]."</option>";
				   }
               ?>
       </select>
       </th></tr>
	   <tr><th colspan="2">
	   <input type="submit" value="envoyer" />
	   </th></tr></table>
	   
	   </td>
	   </form>
	   </tr>
<?php } ?>
</table>
   <?php
}
// fin d'administration

list($player_points_name, $player_points_date, $player_points_nb_rank, $player_points_rank, $player_points_user) = rank_maj("player_points");
list($player_fleet_name, $player_fleet_date, $player_fleet_nb_rank, $player_fleet_rank, $player_fleet_user) = rank_maj("player_fleet");
list($player_research_name, $player_research_date, $player_research_nb_rank, $player_research_rank, $player_research_user) = rank_maj("player_research");

list($ally_points_name, $ally_points_date, $ally_points_nb_rank, $ally_points_rank, $ally_points_user) = rank_maj("ally_points");
list($ally_fleet_name, $ally_fleet_date, $ally_fleet_nb_rank, $ally_fleet_rank, $ally_fleet_user) = rank_maj("ally_fleet");
list($ally_research_name, $ally_research_date, $ally_research_nb_rank, $ally_research_rank, $ally_research_user) = rank_maj("ally_research");

$rank_max_number = max(count($player_points_rank), count($player_fleet_rank), count($player_research_rank), count($ally_points_rank), count($ally_fleet_rank), count($ally_research_rank));

?>

<table>
<tr>
	<td class="c" colspan="<?php echo ($rank_max_number+4); ?>" align="center">Etat des mises à jour des Classements</td>
</tr>
<tr>
	<td class="c">&nbsp;</td>
	<td class="c">Membre responsable</td>
	<td class="c">Dernière m.à.j</td>
	<td class="c">Nombre de lignes m.à.j</td>
<?php

for($i=0;$i<$rank_max_number;$i++)
{
	echo '<td class="c" width="25">'.($i*100+1).' - '.($i*100+100).'</td>';
}

add_rank($player_points_name, $player_points_date, $player_points_nb_rank, $player_points_rank, $player_points_user, "player", $rank_max_number);
add_rank($player_fleet_name, $player_fleet_date, $player_fleet_nb_rank, $player_fleet_rank, $player_fleet_user, "player", $rank_max_number);
add_rank($player_research_name, $player_research_date, $player_research_nb_rank, $player_research_rank, $player_research_user, "player", $rank_max_number);
add_rank($ally_points_name, $ally_points_date, $ally_points_nb_rank, $ally_points_rank, $ally_points_user, "ally", $rank_max_number);
add_rank($ally_fleet_name, $ally_fleet_date, $ally_fleet_nb_rank, $ally_fleet_rank, $ally_fleet_user, "ally", $rank_max_number);
add_rank($ally_research_name, $ally_research_date, $ally_research_nb_rank, $ally_research_rank, $ally_research_user, "ally", $rank_max_number);
?>
</table>