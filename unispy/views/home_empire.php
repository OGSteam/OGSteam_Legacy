<?php
/***************************************************************************
*	filename	: home_empire.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 17/12/2005
*	modified	: 30/07/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

require_once("includes/univers.php");

$user_empire = user_get_empire();
$user_building = $user_empire["building"];
$user_defence = $user_empire["defence"];
$user_technology = $user_empire["technology"];

$nb_planets = sizeof($user_empire["building"]);
$view = "planets";
$start = 1;
?>

<!-- DEBUT DU SCRIPT -->
<script language="JavaScript">
<?php

if(isset($pub_alert_empire) && $pub_alert_empire) echo 'message("'.$LANG["univers_Warning"].'");';

$name = $coordinates = $fields = $temperature = $satellite = "";
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$name .= "'".$user_building[$i]["planet_name"]."', ";
	$coordinates .= "'".$user_building[$i]["coordinates"]."', ";
	$fields .= "'".$user_building[$i]["fields"]."', ";
	$temperature .= "'".$user_building[$i]["temperature"]."', ";
	$satellite .= "'".$user_building[$i]["Sat"]."', ";
}

echo "var name = new Array(".substr($name, 0, strlen($name)-2).");"."\n";
echo "var coordinates = new Array(".substr($coordinates, 0, strlen($coordinates)-2).");"."\n";
echo "var fields = new Array(".substr($fields, 0, strlen($fields)-2).");"."\n";
echo "var temperature = new Array(".substr($temperature, 0, strlen($temperature)-2).");"."\n";
echo "var satellite = new Array(".substr($satellite, 0, strlen($satellite)-2).");"."\n";
?>
var select_planet = false;

function autofill(planet_id, planet_selected) {

	var i = 1;
	var lign = 0;
	var id = 0;
	var lim = 46;
	var max_planets = <?php echo $nb_planets; ?>;

	for(i = 1; i <=max_planets; i++) {
		for(lign = 1; lign <= lim; lign++) {
			id = lign + '_' +  i;
			document.getElementById(id).style.color = 'lime';
		}
	}

	for(i = 1; i <= lim; i++) {
		id = i + '_' +planet_id;
		document.getElementById(id).style.color = 'yellow';
	}

	return(true);
}

function clear_text2() {
	
		document.post2.data.value = "";
	
}

function message(msg) {
	alert("\n"+msg);
}
</script>
<!-- FIN DU SCRIPT -->

<table width="100%">
<tr>
	<td class="c" colspan="<?php echo $nb_planets +1 ?>"><?php echo $LANG["homeempire_HeadTitle"];?></td>
</tr>
<tr>
<?php
	echo "<th colspan='".($nb_planets + 1)."'><a>".$LANG["univers_Planets"]."</a></th>";


?>
	</tr>
<form method="POST" name="post2" enctype="multipart/form-data" action="index.php">
<tr>
	<input type="hidden" name="action" value="set_empire">
	<input type="hidden" name="view" value="<?php echo $view; ?>">
	<th><a><?php echo $LANG["homeempire_Paste"];?></a></th>
	<th colspan="<?php echo ($nb_planets < 10) ? 5:($nb_planets-5-2);?>" ><textarea name="data" rows="2"  onFocus='clear_text2()'><?php echo $LANG["homeempire_Textarea"];?></textarea></th>	
	<th colspan="2">
		<label for ="empire" style="display:block;float:left;"><input name="typedata" value="E" id="empire" type="radio" checked / ><a><?php echo $LANG["univers_Empire"];?></a></label><br />
		<label for ="tech" style="display:block;float:left;"><input name="typedata" value="T" id="tech" type="radio"/ ><a><?php echo $LANG["univers_Tech"];?></a></label><br />
	</th>
	<th colspan="3"><?php echo $LANG["homeempire_xp_mineur"]; ?> :<input type="text" name="xp_mineur" size="2" maxlength="2" value="<?php echo ($user_technology["xp_mineur"] == "")? 0:$user_technology["xp_mineur"]?>"><br/>
	<?php echo $LANG["homeempire_xp_raideur"]; ?> :<input type="text" name="xp_raideur" size="2" maxlength="2" value="<?php echo ($user_technology["xp_raideur"] == "")? 0:$user_technology["xp_raideur"]?>"></th>
	<th colspan="2"><input type="submit" value="<?php echo $LANG["homeempire_Send"];?>"></th>
</tr>
<tr>
	<th width="10%"><a><?php echo $LANG["homeempire_SelectPlanet"];?></a></th>
	<?php for ($i=1;$i<=$nb_planets;$i++){ ?>
	<th width="<?php echo (90/($nb_planets)); ?>%"><input name="planet_id" value="<?php echo $i; ?>" type="radio" onclick="select_planet = autofill(<?php echo $i; ?>);"></th>
	<?php } ?>
	
</tr>
</form>
<tr>
	<td class="c" colspan="<?php echo ($nb_planets +1);?>"><?php echo $LANG["homeempire_GeneralInfo"];?></td>
</tr>
<tr>
	<th>&nbsp;</th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	echo "\t<th>";
	echo "<input type='image' title='".sprintf($LANG["homeempire_LeftMove"], $user_building[$i]["planet_name"])."' src='images/previous.png' onclick=\"window.location = 'index.php?action=move_planet&planet_id=".$i."&view=".$view."&left';\">&nbsp;&nbsp";
	echo "<input type='image' title='".sprintf($LANG["homeempire_DeletePlanet"], $user_building[$i]["planet_name"])."' src='images/drop.png' onclick=\"window.location = 'index.php?action=del_planet&planet_id=".$i."&view=".$view."';\">&nbsp;&nbsp;";
	//if (!isset($pub_view) || $pub_view == "planets")
	echo "<input type='image' title='".sprintf($LANG["homeempire_RightMove"], $user_building[$i]["planet_name"])."' src='images/next.png' onclick=\"window.location = 'index.php?action=move_planet&planet_id=".$i."&view=".$view."&right';\">";
	echo "</th>\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Planet"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$name = $user_building[$i]["planet_name"];
	if ($name == "") $name = "&nbsp;";

	echo "\t"."<th><a>".$name."</a></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Coordinates"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$coordinates = $user_building[$i]["coordinates"];
	if ($coordinates == "") $coordinates = "&nbsp;";
	else $coordinates = "[".$coordinates."]";

	echo "\t"."<th>".$coordinates."</th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Field"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$fields = $user_building[$i]["fields"];
	if ($fields == "0") $fields = 0;
	$fields_used = $user_building[$i]["fields_used"];
	$Ter = $user_building[$i]["Ter"];
	if ($Ter == "") $Ter = 0;

	echo "\t"."<th>".$fields_used." / ". ($fields!=0 ? ($fields+5*$Ter) : "") ."</th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Temperature"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$temperature = $user_building[$i]["temperature"];
	if ($temperature == "") $temperature = "&nbsp;";

	echo "\t"."<th>".$temperature."</th>"."\n";
}
?>
</tr>
<tr>
	<td class="c" colspan="<?php echo ($nb_planets +1);?>"><?php echo $LANG["homeempire_Production"];?></td>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Titane"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$Ti = $user_building[$i]["Ti"];
	if ($Ti != "") $production = production("Ti", $Ti,$user_empire['technology']['Alli']);
	else $production = "&nbsp";

	echo "\t"."<th>".$production."</th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Carbon"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$Ca = $user_building[$i]["Ca"];
	if ($Ca != "") $production = production("Ca", $Ca,$user_empire['technology']['SC']);
	else $production = "&nbsp";

	echo "\t"."<th>".$production."</th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Tritium"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$Tr = $user_building[$i]["Tr"];
	$temperature = $user_building[$i]["temperature"];
	$CaT = $user_building[$i]["CaT"];
	$CaT_consumption = consumption("CaT", $CaT);
	if ($Tr != "") $production = production("Tr", $Tr,$user_empire['technology']['Raf'], $temperature) - $CaT_consumption;
	else $production = "&nbsp";

	echo "\t"."<th>".$production."</th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Energy"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CG = $user_building[$i]["CG"];
	$CaT = $user_building[$i]["CaT"];
	$Sat = $user_building[$i]["Sat"];
	$temperature = $user_building[$i]["temperature"];

	$production_CG = $production_CaT = $production_Sat = 0;
	$production_CG = production("CG", $CG);
	$production_CaT = production("CaT", $CaT);
	$production_Sat = production_sat($temperature) * $Sat;

	$production = $production_CG + $production_CaT + $production_Sat;
	if ($production == 0) $production = "&nbsp";

	echo "\t"."<th>".$production."</th>"."\n";
}
?>
</tr>
<tr>
	<td class="c" colspan="<?php echo ($nb_planets +1);?>"><?php echo $LANG["univers_Building"];?></td>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_TitaneMine"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$Ti = $user_building[$i]["Ti"];
	if ($Ti == "") $Ti = "&nbsp;";

	echo "\t"."<th><font color='lime' id='15_".($i+1-$start)."'>".$Ti."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_CarbonMine"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$Ca = $user_building[$i]["Ca"];
	if ($Ca == "") $C = "&nbsp;";

	echo "\t"."<th><font color='lime' id='16_".($i+1-$start)."'>".$Ca."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_TritiumExtractor"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$Tr = $user_building[$i]["Tr"];
	if ($Tr == "") $Tr = "&nbsp;";

	echo "\t"."<th><font color='lime' id='17_".($i+1-$start)."'>".$Tr."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_GeothermalPlant"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CG = $user_building[$i]["CG"];
	if ($CG == "") $CG = "&nbsp;";

	echo "\t"."<th><font color='lime' id='20_".($i+1-$start)."'>".$CG."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_TritiumPlant"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CaT = $user_building[$i]["CaT"];
	if ($CaT == "") $CaT = "&nbsp;";

	echo "\t"."<th><font color='lime' id='21_".($i+1-$start)."'>".$CaT."</font></th>"."\n";
}


//else echo '</tr><tr> <td class="c" colspan="10">Bâtiments</td>';
?>
</tr>
<tr><th><a><?php echo $LANG["univers_DroidFactory"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$UdD = $user_building[$i]["UdD"];
	if ($UdD == "") $UdD = "&nbsp;";

	echo "\t"."<th><font color='lime' id='1_".($i+1-$start)."'>".$UdD."</font></th>"."\n";
}

?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_AndroidsFactory"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$UdA = $user_building[$i]["UdA"];
	if ($UdA == "") $UdA = "&nbsp;";

	echo "\t"."<th><font color='lime' id='22_".($i+1-$start)."'>".$UdA."</font></th>"."\n";
}

?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_ArmsFactory"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$UA = $user_building[$i]["UA"];
	if ($UA == "") $UA = "&nbsp;";

	echo "\t"."<th><font color='lime' id='2_".($i+1-$start)."'>".$UA."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_TitaneStorage"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$STi = $user_building[$i]["STi"];
	if ($STi == "") $STi = "&nbsp;";

	echo "\t"."<th><font color='lime' id='3_".($i+1-$start)."'>".$STi."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_CarbonStorage"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$SCa = $user_building[$i]["SCa"];
	if ($SCa == "") $SCa = "&nbsp;";

	echo "\t"."<th><font color='lime' id='4_".($i+1-$start)."'>".$SCa."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_TritiumStorage"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$STr = $user_building[$i]["STr"];
	if ($STr == "") $STr = "&nbsp;";

	echo "\t"."<th><font color='lime' id='5_".($i+1-$start)."'>".$STr."</font></th>"."\n";
}


?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_MolecularConverter"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CM = $user_building[$i]["CM"];
	if ($CM == "") $CM = "&nbsp;";

	echo "\t"."<th><font color='lime' id='30_".($i+1-$start)."'>".$CM."</font></th>"."\n";
}

?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_TechnicalCenter"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	if ($CT == "") $CT = "&nbsp;";

	echo "\t"."<th><font color='lime' id='23_".($i+1-$start)."'>".$CT."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Terraformer"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$Ter = $user_building[$i]["Ter"];
	if ($Ter == "") $Ter = "&nbsp;";

	echo "\t"."<th><font color='lime' id='24_".($i+1-$start)."'>".$Ter."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_MissileSilo"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$HM = $user_building[$i]["HM"];
	if ($HM == "") $HM = "&nbsp;";

	echo "\t"."<th><font color='lime' id='25_".($i+1-$start)."'>".$HM."</font></th>"."\n";
}

?>
</tr>
<tr>
	<td class="c" colspan="<?php echo ($nb_planets +1);?>"><?php echo $LANG["homeempire_Others"];?></td>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Satellite"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$Sat = $user_building[$i]["Sat"];
	if ($Sat == "") $Sat = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6_".($i+1-$start)."'>".$Sat."</font></th>"."\n";
}

?>
</tr>
<tr>
	<td class="c" colspan="<?php echo ($nb_planets +1);?>"><?php echo $LANG["univers_Technology"];?></td>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Espionage"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	$Esp = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Esp = $user_technology["Esp"] != "" ? $user_technology["Esp"] : "0";
		$requirement = $technology_requirement["Esp"];
		
		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == "0") {
				if ($CT < $value) $Esp = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Esp = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='26_".(($i+1-$start))."'>".$Esp."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Quantum"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	$Qua = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Qua = $user_technology["Qua"] != "" ? $user_technology["Qua"] : "0";
		$requirement = $technology_requirement["Qua"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == "0") {
				if ($CT < $value) $Qua = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Qua = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='27_".($i+1-$start)."'>".$Qua."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Alloys"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	$Alli = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Alli = $user_technology["Alli"] != "" ? $user_technology["Alli"] : "0";
		$requirement = $technology_requirement["Alli"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == "0") {
				if ($CT < $value) $Alli = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Alli = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='28_".($i+1-$start)."'>".$Alli."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_CarbonStrat"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	$SC = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$SC = $user_technology["SC"] != "" ? $user_technology["SC"] : "0";
		$requirement = $technology_requirement["SC"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == "0") {
				if ($CT < $value) $SC = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$SC = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='29_".($i+1-$start)."'>".$SC."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Refinery"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	$Raf = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Raf = $user_technology["Raf"] != "" ? $user_technology["Raf"] : "0";
		$requirement = $technology_requirement["Raf"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == "0") {
				if ($CT < $value) $Raf = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Raf = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='31_".($i+1-$start)."'>".$Raf."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Armament"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	$Armes = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Armes = $user_technology["Armes"] != "" ? $user_technology["Armes"] : "0";
		$requirement = $technology_requirement["Armes"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == "0") {
				if ($CT < $value) $Armes = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Armes = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='32_".($i+1-$start)."'>".$Armes."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Shield"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	$Bouclier = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Bouclier = $user_technology["Bouclier"] != "" ? $user_technology["Bouclier"] : "0";
		$requirement = $technology_requirement["Bouclier"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == "0") {
				if ($CT < $value) $Bouclier = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Bouclier = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='33_".($i+1-$start)."'>".$Bouclier."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Armour"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	$Blindage = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Blindage = $user_technology["Blindage"] != "" ? $user_technology["Blindage"] : "0";
		$requirement = $technology_requirement["Blindage"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == "0") {
				if ($CT < $value) $Blindage = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Blindage = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='34_".($i+1-$start)."'>".$Blindage."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Thermodynamics"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	$Ther = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Ther = $user_technology["Ther"] != "" ? $user_technology["Ther"] : "0";
		$requirement = $technology_requirement["Ther"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == "0") {
				if ($CT < $value) $Ther = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Ther = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='35_".($i+1-$start)."'>".$Ther."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Antimatter"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	$Anti = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Anti = $user_technology["Anti"] != "" ? $user_technology["Anti"] : "0";
		$requirement = $technology_requirement["Anti"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == "0") {
				if ($CT < $value) $Anti = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Anti = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='36_".($i+1-$start)."'>".$Anti."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Hyperdrive"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	$HD = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$HD = $user_technology["HD"] != "" ? $user_technology["HD"] : "0";
		$requirement = $technology_requirement["HD"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == "0") {
				if ($CT < $value) $HD = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$HD = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='37_".($i+1-$start)."'>".$HD."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_ImpulseDrive"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	$Imp = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Imp = $user_technology["Imp"] != "" ? $user_technology["Imp"] : "0";
		$requirement = $technology_requirement["Imp"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == "0") {
				if ($CT < $value) $Imp = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Imp = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='38_".($i+1-$start)."'>".$Imp."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Warp"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	$Warp = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Warp = $user_technology["Warp"] != "" ? $user_technology["Warp"] : "0";
		$requirement = $technology_requirement["Warp"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == "0") {
				if ($CT < $value) $Warp = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Warp = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='39_".($i+1-$start)."'>".$Warp."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Smart"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	$Smart = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Smart = $user_technology["Smart"] != "" ? $user_technology["Smart"] : "0";
		$requirement = $technology_requirement["Smart"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == "0") {
				if ($CT < $value) $Smart = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Smart = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='40_".($i+1-$start)."'>".$Smart."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Ions"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	$Ions = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Ions = $user_technology["Ions"] != "" ? $user_technology["Ions"] : "0";
		$requirement = $technology_requirement["Ions"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == "0") {
				if ($CT < $value) $Ions = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Ions = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='41_".($i+1-$start)."'>".$Ions."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Aereon"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	$Aereon = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Aereon = $user_technology["Aereon"] != "" ? $user_technology["Aereon"] : "0";
		$requirement = $technology_requirement["Aereon"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == "0") {
				if ($CT < $value) $Aereon = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Aereon = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='42_".($i+1-$start)."'>".$Aereon."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_GreatComputer"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	$Sca = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Sca = $user_technology["Sca"] != "" ? $user_technology["Sca"] : "0";
		$requirement = $technology_requirement["Sca"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == "0") {
				if ($CT < $value) $Sca = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Sca = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='43_".($i+1-$start)."'>".$Sca."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Graviton"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	$Graviton = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Graviton = $user_technology["Graviton"] != "" ? $user_technology["Graviton"] : "0";
		$requirement = $technology_requirement["Graviton"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == "0") {
				if ($CT < $value) $Graviton = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Graviton = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='44_".($i+1-$start)."'>".$Graviton."</font></th>"."\n";
}

?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Administration"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	$Admi = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Admi = $user_technology["Admi"] != "" ? $user_technology["Admi"] : "0";
		$requirement = $technology_requirement["Admi"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == "0") {
				if ($CT < $value) $Admi = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Admi = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='45_".($i+1-$start)."'>".$Admi."</font></th>"."\n";
}

?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Exploitation"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CT = $user_building[$i]["CT"];
	$Expl = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Expl = $user_technology["Expl"] != "" ? $user_technology["Expl"] : "0";
		$requirement = $technology_requirement["Expl"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == "0") {
				if ($CT < $value) $Expl = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Expl = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='46_".($i+1-$start)."'>".$Expl."</font></th>"."\n";
}

?>
</tr>
<tr>
	<td class="c" colspan="<?php echo ($nb_planets+1);?>"><?php echo $LANG["univers_Defence"];?></td>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_RocketLauncher"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$BFG = $user_defence[$i]["BFG"];
	if ($BFG == "") $BFG = "&nbsp;";

	echo "\t"."<th><font color='lime' id='7_".($i+1-$start)."'>".$BFG."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_LightLaser"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$SBFG = $user_defence[$i]["SBFG"];
	if ($SBFG == "") $SBFG = "&nbsp;";

	echo "\t"."<th><font color='lime' id='8_".($i+1-$start)."'>".$SBFG."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_HeavyLaser"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$PFC = $user_defence[$i]["PFC"];
	if ($PFC == "") $PFC = "&nbsp;";

	echo "\t"."<th><font color='lime' id='9_".($i+1-$start)."'>".$PFC."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_GaussCannon"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$DeF = $user_defence[$i]["DeF"];
	if ($DeF == "") $DeF = "&nbsp;";

	echo "\t"."<th><font color='lime' id='10_".($i+1-$start)."'>".$DeF."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_IonCannon"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$PFI = $user_defence[$i]["PFI"];
	if ($PFI == "") $PFI = "&nbsp;";

	echo "\t"."<th><font color='lime' id='11_".($i+1-$start)."'>".$PFI."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_PlasmaTuret"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$AMD = $user_defence[$i]["AMD"];
	if ($AMD == "") $AMD = "&nbsp;";

	echo "\t"."<th><font color='lime' id='12_".($i+1-$start)."'>".$AMD."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_SmallShield"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CF = $user_defence[$i]["CF"];
	if ($CF == "") $CF = "&nbsp;";

	echo "\t"."<th><font color='lime' id='13_".($i+1-$start)."'>".$CF."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_LargeShield"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$Ho = $user_defence[$i]["Ho"];
	if ($Ho == "") $Ho = "&nbsp;";

	echo "\t"."<th><font color='lime' id='14_".($i+1-$start)."'>".$Ho."</font></th>"."\n";
}

?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_AntiBallisticMissiles"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CME = $user_defence[$i]["CME"];
	if ($CME == "") $CME = "&nbsp;";

	echo "\t"."<th><font color='lime' id='19_".($i+1-$start)."'>".$CME."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_InterplanetaryMissiles"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$EMP = $user_defence[$i]["EMP"];
	if ($EMP == "") $EMP = "&nbsp;";

	echo "\t"."<th><font color='lime' id='18_".($i+1-$start)."'>".$EMP."</font></th>"."\n";
}
?>
</tr>
</table>