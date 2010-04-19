<?php
/***************************************************************************
*	filename	: home_simulation.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 19/12/2005
*	modified	: 06/08/2006 11:40:18
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

$user_empire = user_get_empire();
$user_building = $user_empire["building"];
$user_defence = $user_empire["defence"];

$nb_planets = sizeof($user_empire["building"]);
?>
<SCRIPT LANGUAGE=Javascript SRC="js/univers_formula.js"></SCRIPT>

<table width='<?php echo $nb_planets * 100?>'>
<tr>
	<td class="c">
		<input type='hidden' id='nb_planets' value='<?php echo $nb_planets;?>'/>
		<input type='hidden' id='tech_Alli' value='<?php echo $user_empire["technology"]["Alli"];?>'/>
		<input type='hidden' id='tech_SC' value='<?php echo $user_empire["technology"]["SC"];?>'/>
		<input type='hidden' id='tech_Raf' value='<?php echo $user_empire["technology"]["Raf"];?>'/>
		<input type='hidden' id='xp_mineur' value='<?php echo $user_empire["technology"]["xp_mineur"];?>'/>
		<input type='hidden' id='uni_speed' value='<?php echo $server_config["uni_speed"];?>'/>
	</td>
<?php

for ($i=1 ; $i<=$nb_planets ; $i++) {
	$name = $user_building[$i]["planet_name"];
	if ($name == "") $name = "xxx";
	
	echo "\t"."<td class='c' colspan='2'><a>".$name."<a></td>"."\n";
}
?>
	<td class="c"><?php echo $LANG["homesimulation_Totals"];?></td>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Coordinates"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$coordinates = $user_building[$i]["coordinates"];
	if ($coordinates == "") $coordinates = "&nbsp;";
	else $coordinates = "[".$coordinates."]";

	echo "\t"."<th colspan='2'>".$coordinates."</th>"."\n";
}
?>
	<td>&nbsp;</td>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Field"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$fields = $user_building[$i]["fields"];
	if ($fields == "0") $fields = "?";
	$fields_used = $user_building[$i]["fields_used"];
	if ($fields_used > 0) {
		$fields = $fields_used." / ".$fields;
	}
	else $fields = "&nbsp;";

	echo "\t"."<th colspan='2'>".$fields."</th>"."\n";
}
?>
	<td>&nbsp;</td>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Temperature"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$temperature = $user_building[$i]["temperature"];
	if ($temperature == "") $temperature = "&nbsp;";

	echo "\t"."<th colspan='2'>".$temperature."<input id='Temp_".$i."' type='hidden' value='".$temperature."'></th>"."\n";
}
?>
	<td>&nbsp;</td>
</tr>

<!--
Energie
-->

<tr>
	<td class="c" colspan="<?php echo 2*$nb_planets+2;?>"><?php echo $LANG["homesimulation_Energies"];?></th>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_GeothermalPlant"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CG = $user_building[$i]["CG"];
	echo "\t"."<th><input type='text' id='CG_".$i."' size='2' maxlength='2' value='".$CG."' onchange='update_page();'></th>"."\n";

	echo "\t"."<th>";
	echo "<select id='CG_".$i."_percentage' onchange='update_page();' onKeyUp='update_page();'>";
	for ($j=100 ; $j>=0 ; $j -= 10) {
		echo "<option value='".$j."'>".$j."%</option>";
	}
	echo "</select></th>"."\n";
}
?>
	<td>&nbsp;</td>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_TritiumPlant"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$CaT = $user_building[$i]["CaT"];
	echo "\t"."<th><input type='text' id='CaT_".$i."' size='2' maxlength='2' value='".$CaT."' onchange='update_page();'></th>"."\n";

	echo "\t"."<th>";
	echo "<select id='CaT_".$i."_percentage' onchange='update_page();' onKeyUp='update_page();'>";
	for ($j=100 ; $j>=0 ; $j -= 10) {
		echo "<option value='".$j."'>".$j."%</option>";
	}
	echo "</select></th>"."\n";
}
?>
	<td>&nbsp;</td>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Satellite"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$Sat = $user_building[$i]["Sat"];
	echo "\t"."<th><input type='text' id='Sat_".$i."' size='2' maxlength='5' value='".$Sat."' onchange='update_page();'></th>"."\n";

	echo "\t"."<th>";
	echo "<select id='Sat_".$i."_percentage' onchange='update_page();' onKeyUp='update_page();'>";
	for ($j=100 ; $j>=0 ; $j -= 10) {
		echo "<option value='".$j."'>".$j."%</option>";
	}
	echo "</select></th>"."\n";
}
?>
	<td>&nbsp;</td>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Energy"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><div id='NRJ_".$i."'>-</div></font></th>"."\n";
}
?>
	<th><div id="NRJ">-</div></th>
</tr>

<!--
Métal
-->

<tr>
	<td class="c" colspan="<?php echo $nb_planets*2+2;?>"><?php echo $LANG["univers_TitaneMine"];?></td>
</tr>
<tr>
	<th><a><?php echo $LANG["homesimulation_Level"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$Ti = $user_building[$i]["Ti"];
	echo "\t"."<th><input type='text' id='Ti_".$i."' size='2' maxlength='2' value='".$Ti."' onchange='update_page();'></th>"."\n";

	echo "\t"."<th>";
	echo "<select id='Ti_".$i."_percentage' onchange='update_page();' onKeyUp='update_page();'>";
	for ($j=100 ; $j>=0 ; $j -= 10) {
		echo "<option value='".$j."'>".$j."%</option>";
	}
	echo "</select></th>"."\n";
}
?>
	<td>&nbsp;</td>
</tr>
<tr>
	<th><a><?php echo $LANG["homesimulation_ConsumptionEnergy"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><div id='Ti_".$i."_conso'>-</div></font></th>"."\n";
}
?>
	<th><div id="Ti_conso">-</div></th>
</tr>
<tr>
	<th><a><?php echo $LANG["homesimulation_Production"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><div id='Ti_".$i."_prod'>-</div></font></th>"."\n";
}
?>
	<th><div id="Ti_prod">-</div></th>
</tr>

<!--
Cristal
-->

<tr>
	<td class="c" colspan="<?php echo $nb_planets*2+2;?>"><?php echo $LANG["univers_CarbonMine"];?></td>
</tr>
<tr>
	<th><a><?php echo $LANG["homesimulation_Level"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$Ca = $user_building[$i]["Ca"];
	echo "\t"."<th><input type='text' id='Ca_".$i."' size='2' maxlength='2' value='".$Ca."' onchange='update_page();'></th>"."\n";

	echo "\t"."<th>";
	echo "<select id='Ca_".$i."_percentage' onchange='update_page();' onKeyUp='update_page();'>";
	for ($j=100 ; $j>=0 ; $j -= 10) {
		echo "<option value='".$j."'>".$j."%</option>";
	}
	echo "</select></th>"."\n";
}
?>
	<td>&nbsp;</td>
</tr>
<tr>
	<th><a><?php echo $LANG["homesimulation_ConsumptionEnergy"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><div id='Ca_".$i."_conso'>-</div></font></th>"."\n";
}
?>
	<th><div id="Ca_conso">-</div></th>
</tr>
<tr>
	<th><a><?php echo $LANG["homesimulation_Production"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><div id='Ca_".$i."_prod'>-</div></font></th>"."\n";
}
?>
	<th><div id="Ca_prod">-</div></th>
</tr>

<!--
Deutérium
-->

<tr>
	<td class="c" colspan="<?php echo $nb_planets*2+2;?>"><?php echo $LANG["univers_TritiumExtractor"];?></td>
</tr>
<tr>
	<th><a><?php echo $LANG["homesimulation_Level"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$Tr = $user_building[$i]["Tr"];
	echo "\t"."<th><input type='text' id='Tr_".$i."' size='2' maxlength='2' value='".$Tr."' onchange='update_page();'></th>"."\n";

	echo "\t"."<th>";
	echo "<select id='Tr_".$i."_percentage' onchange='update_page();' onKeyUp='update_page();'>";
	for ($j=100 ; $j>=0 ; $j -= 10) {
		echo "<option value='".$j."'>".$j."%</option>";
	}
	echo "</select></th>"."\n";
}
?>
	<td>&nbsp;</td>
</tr>
<tr>
	<th><a><?php echo $LANG["homesimulation_ConsumptionEnergy"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><font color='lime'><div id='Tr_".$i."_conso'>-</div></font></th>"."\n";
}
?>
	<th><div id="Tr_conso">-</div></th>
</tr>
<tr>
	<th><a><?php echo $LANG["homesimulation_Production"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><div id='Tr_".$i."_prod'>-</div></font></th>"."\n";
}
?>
	<th><div id="Tr_prod">-</div></th>
</tr>
<?php /** Coupure du nombre de pts par planète 
<tr>
	<td class="c" colspan="<?php echo $nb_planets*2+2;?>"><?php echo $LANG["homesimulation_PointsPerPlanet"];?></th>
</tr>
<tr>
<th><a><?php echo $LANG["univers_Building"];?></a></th>
<?php
$lab_max = 0;
for ($i=1 ; $i<=$nb_planets ; $i++) {
	echo "\t<input type='hidden' id='building_".$i."' value='".implode(array_slice($user_building[$i],11), "<>")."' />";
	echo "\t"."<th colspan='2'><font color='lime'><div id='building_pts_".$i."'>-</div></font></th>"."\n";
	if($lab_max < $user_building[$i]["Lab"]) $lab_max = $user_building[$i]["Lab"];
}
?>
	<th><font color='white'><div id='total_b_pts'>-</div></font></th>
</tr>
<tr>
<th><a><?php echo $LANG["univers_Defence"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	echo "\t<input type='hidden' id='defence_".$i."' value='".implode($user_defence[$i], "<>")."' />";
	echo "\t<th colspan='2'><font color='lime'><div id='defence_pts_".$i."'>-</div></font></th>"."\n";
}
?>
	<th><font color='white'><div id='total_d_pts'>-</div></font></th>
</tr>
<tr>
	<th><a><?php echo $LANG["univers_Satellite"];?></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	echo "\t<input type='hidden' id='sat_lune_".$i."' value=".($user_building[$i+9]["Sat"]!="" ? $user_building[$i+9]["Sat"] : 0)." />";
	echo "\t"."<th colspan='2'><font color='lime'><div id='sat_pts_".$i."'>-</div></font></th>"."\n";
}
?>
	<th><div id="total_sat_pts">-</div></th>
</tr>
<tr>
<th><a><font color='yellow'><?php echo $LANG["homesimulation_Totals"];?></font></a></th>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	echo "\t"."<th colspan='2'><font color='white'><div id='total_pts_".$i."'>-</div></font></th>"."\n";
}
?>
<th><font color='white'><div id='total_pts'>-</div></font></th>
</tr>
<tr>
<th><a><?php echo $LANG["univers_Technology"];?></a></th>
<?php

for ($i=1 ; $i<=$nb_planets ; $i++) {
	if($user_empire["technology"]!=NULL && $user_building[$i]["Lab"] == $lab_max) {
	echo "\t<input type='hidden' id='n_techno' value='".implode(array_keys($user_empire["technology"]),"<>")."' />";
	echo "\t<input type='hidden' id='techno' value='".implode($user_empire["technology"], "<>")."' />";
	echo "\t"."<th colspan='2'><font color='lime'><div id='techno_pts'>-</div></font></th>"."\n";
	}
	else echo "<th colspan='2'><font color='lime'>-</font></th>";
}
?>
	<th>-</th>
</tr>
<tr>
	<td class="c">&nbsp;</td>
<?php
for ($i=1 ; $i<=$nb_planets ; $i++) {
	$name = $user_building[$i]["planet_name"];
	if ($name == "") $name = "xxx";
	
	echo "\t"."<td class='c' colspan='2'><a>".$name."<a></td>"."\n";
}
?>
	<td class='c'><?php echo $LANG["homesimulation_Totals"];?></td>
</tr> */?>
</table>
<script language="JavaScript">
update_page();
</script>