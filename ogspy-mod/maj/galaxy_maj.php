<?php
/**
* galaxy_maj.php 
* @package MAJ
* @author ben.12
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME')) {
   die("Hacking attempt");
}

define("TABLE_MAJ", $table_prefix."maj");

$admin = isset($pub_admin)?$pub_admin:0;

$nbr_total_planet = $num_of_galaxies*$num_of_systems*15;


// Adiministration:
$step = ceil($num_of_systems/$server_config["step_maj"]);

if(((isset($pub_jours) && isset($pub_nbpg)) || (isset($pub_galaxy) && isset($pub_trache_system) && isset($pub_name_id))) && ($user_data["user_admin"]==1 || $user_data["user_coadmin"]==1)) {
	
	if(isset($pub_nbpg) && $pub_nbpg != $server_config["step_maj"] && is_numeric($pub_nbpg) && ($pub_nbpg==20 || $pub_nbpg==10 || $pub_nbpg==5 || $pub_nbpg==2 || $pub_nbpg==1)) {
		$request = "update ".TABLE_CONFIG." set config_value = '".$pub_nbpg."'";
		$request .= " where config_name = 'step_maj'";
		$db->sql_query($request);
	}
	
	if(isset($pub_jours) && is_numeric($pub_jours) && $pub_jours != $server_config["maj_step_jrs"]) {
		$request = "update ".TABLE_CONFIG." set config_value = '".$pub_jours."'";
		$request .= " where config_name = 'step_jrs'";
		$db->sql_query($request);
	}
	elseif(isset($pub_galaxy) && is_numeric($pub_galaxy) && $pub_galaxy>=1 && $pub_galaxy<=$num_of_galaxies && isset($pub_trache_system) && is_numeric($pub_trache_system) && $pub_trache_system>=0 && $pub_trache_system<=$server_config["step_maj"] && isset($pub_name_id) && is_numeric($pub_name_id)) {
		$request = "update ".TABLE_MAJ." set name_id = ".$pub_name_id;
        $request .= " where div_nb = ".(($pub_galaxy-1)*$server_config["step_maj"]+$pub_trache_system)." and div_type = ".$server_config["step_maj"];
        $db->sql_query($request);
        if ($db->sql_affectedrows() == 0) {
            $request = "insert ignore into ".TABLE_MAJ."(div_type, div_nb, name_id) values (".$server_config["step_maj"].", ".(($pub_galaxy-1)*$server_config["step_maj"]+$pub_trache_system).", ".$pub_name_id.")";
            $db->sql_query($request);
        }
	}
	redirection("index.php?action=mod_maj&admin=".$admin);
}

// Récupértion des données de mise à jour
list($statistic_maj, $nb_planets) = galaxy_maj($server_config["step_maj"], $server_config["maj_step_jrs"]);
$users = user_get();

//Affichage de l'administration:
if($user_data["user_admin"]==1 || $user_data["user_coadmin"]==1) {
   ?>
	   <table border='1'><tr>
		<td class='c' colspan='2'><a href="index.php?action=mod_maj&admin=<?php echo $admin==1?0:1; ?>">Administration</td>
	   </tr>
<?php if($admin) { ?>
	   <form action="index.php?action=mod_maj&admin=<?php echo $admin; ?>" method="post"><td>
	   <table><tr>
	   <td class="c">Jours d'interval:</td>
       <td class="c">Division des galaxies:</td>
       </tr>
	   <tr><th>
       <input name="jours" type="text" value="<?php echo $server_config["maj_step_jrs"]; ?>" maxlength="2" size="2"/>
       </th><th>
       <select name="nbpg">
               <option value="1" <?php if($server_config["step_maj"]==1) echo "selected"; ?>>1</option>
               <option value="2" <?php if($server_config["step_maj"]==2) echo "selected"; ?>>2</option>
               <option value="5" <?php if($server_config["step_maj"]==5) echo "selected"; ?>>5</option>
               <option value="10" <?php if($server_config["step_maj"]==10) echo "selected"; ?>>10</option>
			   <option value="20" <?php if($server_config["step_maj"]==20) echo "selected"; ?>>20</option>
       </select>
       </th></tr>
	   <tr><th colspan="2">
	   <input type="submit" value="envoyer" />
	   </th></tr></table>
	   </td></form>
	   <form action="index.php?action=mod_maj&admin=<?php echo $admin; ?>" method="post"><td>
	   <table><tr>
	   <td class="c">Galaxie:</td>
       <td class="c">tranche de systèmes:</td>
       <td class="c">membre responsable:</td>
	   </tr>
	   <tr><th>
       <select name="galaxy">
               <option value="1" selected>1</option>
               <?php
                   for($i=2; $i<=$num_of_galaxies; $i++) {
				   		echo "<option value=".$i.'>'.$i."</option>";
				   }
               ?>
       </select>
       </th><th>
       <select name="trache_system">
               <?php
                   for($i=0; $i<ceil($num_of_systems/$step); $i++) {
				   		echo "<option value=".$i.">".($i*$step+1)."-".((($i+1)*$step)<$num_of_systems ? (($i+1)*$step) : $num_of_systems)."</option>";
				   }
               ?>
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
       </th></tr><tr><th colspan="3">
	   <input type="submit" value="envoyer" />
	   </th></tr></table>
       </form></td></tr>
<?php } ?>
</table>
   <?php
}
// fin d'administration
?>
<table>
<tr>
	<td class="c" colspan="<?php echo ($num_of_galaxies>10?$num_of_galaxies/2:$num_of_galaxies)+2; ?>" align="center">Etat des mises à jour de l'univers</td>
</tr>
<tr>
	<td class="c" width="45" colspan="2">&nbsp;</td>
	<?php
		for($i=1; $i<=($num_of_galaxies>10?$num_of_galaxies/2:$num_of_galaxies); $i++) {
			echo '<td class="c" width="60">G'.$i.'</td>';
		}
	?>
</tr>
<?php
for ($system=1 ; $system<=$num_of_systems ; $system+=$step) {
	$up = $system+$step-1;
	if ($up > $num_of_systems) $up = $num_of_systems;

	echo "<tr>"."\n";
	echo "\t"."<td class='c' style='border-top:1px solid lime;border-left:1px solid lime;border-bottom:1px solid lime;' rowspan='3'>".$system." - ".$up."</td>";
	
	for($i=0; $i<3; $i++) {
		switch($i) {
			case 0:	$v = "user_name";
					echo "<td class='c' style='border-top:1px solid lime;' width='30'>Membre responsable</td>";
			break;
			case 1: $v = "last_update";
					echo "<td class='c' width='30'>Dernière m.à.j</td>";
			break;
			case 2: $v = "planet";
					echo "<td class='c' style='border-bottom:1px solid lime;' width='30'>Planètes m.à.j ces ".$server_config["maj_step_jrs"]." derniers jours</td>";
			break;
		}
		for ($galaxy=1 ; $galaxy<=($num_of_galaxies>10?$num_of_galaxies/2:$num_of_galaxies); $galaxy++) {
			$data = $statistic_maj[$galaxy][$system][$v];
			$color = "lime";
			$style = "";
			if($i==0) {
				$style = "border-top:1px solid lime;";
				$color = "#EEFF00";
			}
			if($i==1 and $data!=false) $data = "<span onmouseover=\"this.T_WIDTH=50;this.T_STICKY=false;this.T_TEMP=0;return escape('<table><tr><th>".formate_number($statistic_maj[$galaxy][$system]["nb_last_update"])." planètes</th></tr></table>')\">".strftime("%d %b %Y", $data)."</span>";
			elseif($i==1) $data = "-";
			if($i == 2) {
				$rate = ($statistic_maj[$galaxy][$system]["planet"]/(($up-$system+1)*15))*100;
				$color = get_color($rate);
				$data2 = "<br />(".round($rate, 1)."%)";
				if(round($rate, 1)<100) $data3 = "<br /><a href='index.php?action=mod_maj&subaction=obs&galaxy=".$galaxy."&system=".$system."' onmouseover=\"this.T_WIDTH=50;this.T_STICKY=false;this.T_TEMP=0;return escape('<table><tr><th>".formate_number(($up-$system+1)-$data/15)." systèmes</th></tr></table>')\"><font size='-3'>[obs.]</font></a>";
				else $data3 = "";
				$data = formate_number($data).$data2.$data3;
				$style = "border-bottom:1px solid lime;";
			}
			if($galaxy==$num_of_galaxies) $style .= "border-right:1px solid lime;";
			echo "<th width='30' style='".$style."'><font color='".$color."'>".$data."</font></th>";
		}
		echo "</tr>"."\n";
	}
}
?>
<tr>
	<td class="c" width="45" colspan="2">&nbsp;</td>
	<?php
		for($i=1; $i<=($num_of_galaxies>10?$num_of_galaxies/2:$num_of_galaxies); $i++) {
			echo '<td class="c" width="60">G'.$i.'</td>';
		}
	?>
</tr>
<?php
if($num_of_galaxies>10) {
echo "<tr><td colspan='".(($num_of_galaxies>10?$num_of_galaxies/2:$num_of_galaxies)+2)."'>&nbsp;</td></tr>";
echo "<tr>\n";
echo "\t<td class=\"c\" width=\"45\" colspan=\"2\">&nbsp;</td>\n";
	for($i=$num_of_galaxies/2+1; $i<=$num_of_galaxies; $i++) {
		echo '<td class="c" width="60">G'.$i.'</td>';
	}
echo "</tr>\n";
}
for ($system=1 ; $system<=$num_of_systems && $num_of_galaxies>10 ; $system+=$step) {
	$up = $system+$step-1;
	if ($up > $num_of_systems) $up = $num_of_systems;

	echo "<tr>"."\n";
	echo "\t"."<td class='c' style='border-top:1px solid lime;border-left:1px solid lime;border-bottom:1px solid lime;' rowspan='3'>".$system." - ".$up."</td>";
	
	for($i=0; $i<3; $i++) {
		switch($i) {
			case 0:	$v = "user_name";
					echo "<td class='c' style='border-top:1px solid lime;' width='30'>Membre responsable</td>";
			break;
			case 1: $v = "last_update";
					echo "<td class='c' width='30'>Dernière m.à.j</td>";
			break;
			case 2: $v = "planet";
					echo "<td class='c' style='border-bottom:1px solid lime;' width='30'>Planètes m.à.j ces ".$server_config["maj_step_jrs"]." derniers jours</td>";
			break;
		}
		for ($galaxy=$num_of_galaxies/2+1 ; $galaxy<=$num_of_galaxies ; $galaxy++) {
			$data = $statistic_maj[$galaxy][$system][$v];
			$color = "lime";
			$style = "";
			if($i==0) {
				$style = "border-top:1px solid lime;";
				$color = "#EEFF00";
			}
			if($i==1 and $data!=false) $data = "<span onmouseover=\"this.T_WIDTH=50;this.T_STICKY=false;this.T_TEMP=0;return escape('<table><tr><th>".formate_number($statistic_maj[$galaxy][$system]["nb_last_update"])." planètes</th></tr></table>')\">".strftime("%d %b %Y", $data)."</span>";
			elseif($i==1) $data = "-";
			if($i == 2) {
				$rate = ($statistic_maj[$galaxy][$system]["planet"]/(($up-$system+1)*15))*100;
				$color = get_color($rate);
				$data2 = "<br />(".round($rate, 1)."%)";
				if(round($rate, 1)<100) $data3 = "<br /><a href='index.php?action=mod_maj&subaction=obs&galaxy=".$galaxy."&system=".$system."' onmouseover=\"this.T_WIDTH=50;this.T_STICKY=false;this.T_TEMP=0;return escape('<table><tr><th>".formate_number(($up-$system+1)-$data/15)." systèmes</th></tr></table>')\"><font size='-3'>[obs.]</font></a>";
				else $data3 = "";
				$data = formate_number($data).$data2.$data3;
				$style = "border-bottom:1px solid lime;";
			}
			if($galaxy==$num_of_galaxies) $style .= "border-right:1px solid lime;";
			echo "<th width='30' style='".$style."'><font color='".$color."'>".$data."</font></th>";
		}
		echo "</tr>"."\n";
	}
}

if($num_of_galaxies>10) {
echo "<tr>\n";
echo "\t<td class=\"c\" width=\"45\" colspan=\"2\">&nbsp;</td>\n";
	for($i=$num_of_galaxies/2+1; $i<=$num_of_galaxies; $i++) {
		echo '<td class="c" width="60">G'.$i.'</td>';
	}
echo "</tr>\n";
}
?>
<tr>
	<td colspan="19">
		<b>Nombre total de planètes mises à jour ces <?php echo $server_config["step_jrs"]; ?> derniers jours: </b><font color="Lime"><b><?php echo formate_number($nb_planets); ?></b></font>/<?php echo formate_number($nbr_total_planet);?> (<?php echo round(($nb_planets/$nbr_total_planet)*100,1); ?>%)
	</td>
</tr>
</table>

<br>
<br>

<table>
<tr>
	<th>
<?php
	$sql = "SELECT user_name, count(*) as nb FROM ".TABLE_UNIVERSE.", ".TABLE_USER;
	$sql .= " WHERE user_id=last_update_user_id";
	$sql .= " GROUP BY last_update_user_id ORDER BY nb DESC";
	$result = $db->sql_query($sql);
	$user_name = "";
	$nb_planet = "";
	$autre = 0;
	$i = 1;
    while(list($un, $nb) = $db->sql_fetch_row($result)) {
		if($i>10) {
			$autre += $nb;
		} else {
			$user_name .= ($user_name!==''?'_x_':'').$un;
			$nb_planet .= ($nb_planet!==''?'_x_':'').$nb;
		}
		$i++;
	}

	echo "<img alt='Graphic indisponible' title='Mise à jour par utilisateurs' src='index.php?action=graphic_pie&values=".$nb_planet.($autre>0?'_x_'.$autre:'')."&legend=".$user_name.($autre>0?'_x_autres':'')."&title=Proportion%20de%20mises%20à%20jour%20par%20utilisateurs'>";

?>
	</th>
</tr>
</table>