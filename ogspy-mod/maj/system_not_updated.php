<?php
/**
* system_not_updated.php 
* @package MAJ
* @author ben.12
* @link http://www.ogsteam.fr
*/
	//$num_of_galaxies = 50;
	//$num_of_systems = 100;

$step = ceil($num_of_systems/$server_config["step_maj"]);
$days = $server_config["step_jrs"];

if(isset($pub_galaxy) && is_numeric($pub_galaxy) && isset($pub_system) && is_numeric($pub_system)) {
	$galaxy = $pub_galaxy;
	$system = $pub_system;
} else {
	$galaxy = 0;
	$system = 1;
}

?>
<form action='index.php?action=mod_maj&subaction=obs' method='POST'>
<table>
<tr>
	<td class="c" align="center" colspan='2'>Système non mis à jour ces <?php echo $server_config['step_jrs'] ?> derniers jours pour:</td>
</tr>
<tr><th>
	Galaxie
</th><th>
	Tranche de systèmes
</th></tr>
<tr><th>
       <select name="galaxy">
               <option value="1" selected>1</option>
               <?php
                   for($i=2; $i<=$num_of_galaxies; $i++) {
				   		echo "<option value=".$i.($galaxy==$i?" selected":"").'>'.$i."</option>";
				   }
               ?>
       </select>
       </th><th>
       <select name="system">
               <?php
                   for($i=1; $i<$num_of_systems; $i+=$step) {
						$up = $i+$step-1;
						if ($up > $num_of_systems) $up = $num_of_systems;
				   		echo "<option value=".$i.($system==$i?" selected":"").">".$i."-".$up."</option>";
				   }
               ?>
       </select>
</th></tr>
<tr>
<td class="c" align="center" colspan='2'><input type='submit' value='Chercher' /></td>
</tr>
</table>
</form>


<?php
if($galaxy != 0) {
	$up = $system+$step-1;
	if ($up > $num_of_systems) $up = $num_of_systems;
	
	$obsolete = get_system_obs($galaxy, $system);
	
	echo "<table>\n";
	echo "<tr>\n";
	echo "\t<td class='c' width='110'>Système solaire</td><td class='c' width='110'>Date mise à jour</td>\n";
	echo "\t<td class='c' width='110'>Système solaire</td><td class='c' width='110'>Date mise à jour</td>\n";
	echo "\t<td class='c' width='110'>Système solaire</td><td class='c' width='110'>Date mise à jour</td>\n";
	echo "\t<td class='c' width='110'>Système solaire</td><td class='c' width='110'>Date mise à jour</td>\n";
	echo "</tr>\n";

	$i = $index = 0;
	foreach ($obsolete as $value) {
		$index++;
		if ($i==4) {
			$i=0;
			echo "</tr>"."\n";
			echo "<tr>";
		}
		$date = strftime("%d %b %Y %H:%M", $value["last_update"]);
		$color = $i&1 ? "magenta" : "lime";

		$coordinates = $value["galaxy"].":".$value["system"];
		echo "<th><font color='".$color."'>".$coordinates."</font></th><th><font color='".$color."'>".$date."</font></th>";
		$i++;
	}
	for ($i ; $i<4 ; $i++) {
		echo "<th>&nbsp;</th><th>&nbsp;</th>";
	}
	
	echo "</table>\n";

}
?>