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
	
	if(is_numeric($pub_rank) && $pub_rank>=-16 && $pub_rank<=-1 && is_numeric($pub_name_id)) {
		$request = "update ".TABLE_MAJ." set name_id = ".intval($pub_name_id);
        $request .= " where div_type = ".intval($pub_rank);
        $db->sql_query($request);
        if ($db->sql_affectedrows() == 0) {
            $request = "insert ignore into ".TABLE_MAJ."(div_type, div_nb, name_id) values (".intval($pub_rank).", 0, ".intval($pub_name_id).")";
            $db->sql_query($request);
        }
	}
	generate_mod_cache();
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
               <option value="-2" >Joueurs Economique</option>
               <option value="-3" >Joueurs Recherche</option>
               <option value="-4" >Joueurs Militaire</option>
               <option value="-5" >Joueurs Mil. Construit</option>
               <option value="-6" >Joueurs Mil. Perdu</option>
               <option value="-7" >Joueurs Mil. Détruit</option>
               <option value="-8" >Joueurs Mil. Honneur</option>
               <option value="-9" >Alliances Général</option>
			   <option value="-10" >Alliances Economique</option>
			   <option value="-11" >Alliances Recherche</option>
			   <option value="-12" >Alliances Militaire</option>
			   <option value="-13" >Alliances Mil. Construit</option>
			   <option value="-14" >Alliances Mil. Perdu</option>
			   <option value="-15" >Alliances Mil. Détruit</option>
			   <option value="-16" >Alliances Mil. Honneur</option>
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
list($player_economic_name, $player_economic_date, $player_economic_nb_rank, $player_economic_rank, $player_economic_user) = rank_maj("player_economic");
list($player_research_name, $player_research_date, $player_research_nb_rank, $player_research_rank, $player_research_user) = rank_maj("player_research");
list($player_military_name, $player_military_date, $player_military_nb_rank, $player_military_rank, $player_military_user) = rank_maj("player_military");
list($player_military_built_name, $player_military_built_date, $player_military_built_nb_rank, $player_military_built_rank, $player_military_built_user) = rank_maj("player_military_built");
list($player_military_loose_name, $player_military_loose_date, $player_military_loose_nb_rank, $player_military_loose_rank, $player_military_loose_user) = rank_maj("player_military_loose");
list($player_military_destruct_name, $player_military_destruct_date, $player_military_destruct_nb_rank, $player_military_destruct_rank, $player_military_destruct_user) = rank_maj("player_military_destruct");
list($player_military_honnor_name, $player_military_honnor_date, $player_military_honnor_nb_rank, $player_military_honnor_rank, $player_military_honnor_user) = rank_maj("player_military_honnor");

list($ally_points_name, $ally_points_date, $ally_points_nb_rank, $ally_points_rank, $ally_points_user) = rank_maj("ally_points");
list($ally_economic_name, $ally_economic_date, $ally_economic_nb_rank, $ally_economic_rank, $ally_economic_user) = rank_maj("ally_economic");
list($ally_research_name, $ally_research_date, $ally_research_nb_rank, $ally_research_rank, $ally_research_user) = rank_maj("ally_research");
list($ally_military_name, $ally_military_date, $ally_military_nb_rank, $ally_military_rank, $ally_military_user) = rank_maj("ally_military");
list($ally_military_built_name, $ally_military_built_date, $ally_military_built_nb_rank, $ally_military_built_rank, $ally_military_built_user) = rank_maj("ally_military_built");
list($ally_military_loose_name, $ally_military_loose_date, $ally_military_loose_nb_rank, $ally_military_loose_rank, $ally_military_loose_user) = rank_maj("ally_military_loose");
list($ally_military_destruct_name, $ally_military_destruct_date, $ally_military_destruct_nb_rank, $ally_military_destruct_rank, $ally_military_destruct_user) = rank_maj("ally_military_destruct");
list($ally_military_honnor_name, $ally_military_honnor_date, $ally_military_honnor_nb_rank, $ally_military_honnor_rank, $ally_military_honnor_user) = rank_maj("ally_military_honnor");


$rank_max_number = max(count($player_points_rank), count($player_economic_name), count($player_research_name), count($player_military_name), count($player_military_built_name), count($player_military_loose_name), count($player_military_destruct_name), count($player_military_honnor_name), count($ally_points_name), count($ally_economic_name), count($ally_research_name), count($ally_military_name), count($ally_military_built_name), count($ally_military_loose_name), count($ally_military_destruct_name), count($ally_military_honnor_name));

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
add_rank($player_economic_name, $player_economic_date, $player_economic_nb_rank, $player_economic_rank, $player_economic_user, "player", $rank_max_number);
add_rank($player_research_name, $player_research_date, $player_research_nb_rank, $player_research_rank, $player_research_user, "player", $rank_max_number);
add_rank($player_military_name, $player_military_date, $player_military_nb_rank, $player_military_rank, $player_military_user, "player", $rank_max_number);
add_rank($player_military_loose_name, $player_military_loose_date, $player_military_loose_nb_rank, $player_military_loose_rank, $player_military_loose_user, "player", $rank_max_number);
add_rank($player_military_loose_name, $player_military_loose_date, $player_military_loose_nb_rank, $player_military_loose_rank, $player_military_loose_user, "player", $rank_max_number);
add_rank($player_military_destruct_name, $player_military_destruct_date, $player_military_destruct_nb_rank, $player_military_destruct_rank, $player_military_destruct_user, "player", $rank_max_number);
add_rank($player_military_honnor_name, $player_military_honnor_date, $player_military_honnor_nb_rank, $player_military_honnor_rank, $player_military_honnor_user, "player", $rank_max_number);
add_rank($ally_points_name, $ally_points_date, $ally_points_nb_rank, $ally_points_rank, $ally_points_user, "ally", $rank_max_number);
add_rank($ally_economic_name, $ally_economic_date, $ally_economic_nb_rank, $ally_economic_rank, $ally_economic_user, "ally", $rank_max_number);
add_rank($ally_research_name, $ally_research_date, $ally_research_nb_rank, $ally_research_rank, $ally_research_user, "ally", $rank_max_number);
add_rank($ally_military_name, $ally_military_date, $ally_military_nb_rank, $ally_military_rank, $ally_military_user, "ally", $rank_max_number);
add_rank($ally_military_loose_name, $ally_military_loose_date, $ally_military_loose_nb_rank, $ally_military_loose_rank, $ally_military_loose_user, "ally", $rank_max_number);
add_rank($ally_military_loose_name, $ally_military_loose_date, $ally_military_loose_nb_rank, $ally_military_loose_rank, $ally_military_loose_user, "ally", $rank_max_number);
add_rank($ally_military_destruct_name, $ally_military_destruct_date, $ally_military_destruct_nb_rank, $ally_military_destruct_rank, $ally_military_destruct_user, "ally", $rank_max_number);
add_rank($ally_military_honnor_name, $ally_military_honnor_date, $ally_military_honnor_nb_rank, $ally_military_honnor_rank, $ally_military_honnor_user, "ally", $rank_max_number);


?>
</table>