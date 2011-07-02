<?php
/***************************************************************************
*	filename	: home_simulation.php
*	desc.		: 1.03
*	Author		: 
*	created		: 
*	modified	: 
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

if (!defined('IN_MOD_FLOTTES')) {
	die("Hacking attempt");
}

require_once("./mod/flottes/flottes_lang.php");
$user_empire = user_get_empire();
$user_building = $user_empire["building"];
$user_defence = $user_empire["defence"];

$affplanet=compte_planet($user_data['user_id'],$nplapage,$gameselect);
//echo $affplanet[0]." - ".$affplanet[1]." - ".$affplanet[2]." - ".$affplanet[3];

if(!isset($pub_view) || $pub_view=="") $view = "0";
else $view = $pub_view;
$start = $view=="0" ? 1 : ($view*$nplapage)+1;

?>
<SCRIPT LANGUAGE=Javascript SRC="js/ogame_formula.js"></SCRIPT>

<table width="100%">
<tr>
<?php
if ($affplanet[1]==0) {
	$nbcol1=$affplanet[2];
	$nbcol2=10;
}
else {
	$nbcol1=($nplapage+1)-($affplanet[2]*$affplanet[1]);
	$nbcol2=$nplapage+1;
}
for ($i=0 ; $i<=$affplanet[1] ; $i++) {
	if ($view == $i) {
		echo "<th colspan='".$nbcol1."'><a>".$lib_page[$i]."</a></th>";
	} 
	else {
		echo "<td class='c' align='center' colspan='".$affplanet[2]."' onClick=\"window.location = 'index.php?action=flottes&subaction2=simul&view=".$i."&flottes_user_id=".$user_data['user_id']."';\"><a style='cursor:pointer'><font color='lime'>".$lib_page[$i]."</font></a></td>";
	}
}
echo "</tr><tr>";
?>
	<td class="c"></td>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$name = $user_building[$i]["planet_name"];
	if ($name == "") $name = "xxx";
	
	echo "\t"."<td class='c' colspan='2'><a>".$name."<a></td>"."\n";
}
?>
	<td class="c">Totaux</td>
</tr>
<tr>
	<th><a>Coordonnées</a></th>
<?php
for ($$i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$coordinates = $user_building[$i]["coordinates"];
	if ($coordinates == "") $coordinates = "&nbsp;";
	else $coordinates = "[".$coordinates."]";

	echo "\t"."<th colspan='2'>".$coordinates."</th>"."\n";
}
?>
	<td>&nbsp;</td>
</tr>
<tr>
	<th><a>Cases</a></th>
<?php
for ($$i=$start ; $i<=$start+$nplapage-1 ; $i++) {
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
	<th><a>Température</a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
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
	<td class="c" colspan="19">Energies</th>
</tr>
<tr>
	<th><a><?php echo $LANG["ogame_SolarPlant"]; ?></a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$CES = $user_building[$i][$ces_lang];
	echo "\t"."<th><input type='text' id='CES_".$i."' size='2' maxlength='2' value='".$CES."' onchange='update_page();'></th>"."\n";

	echo "\t"."<th>";
	echo "<select id='CES_".$i."_percentage' onchange='update_page();' onKeyUp='update_page();'>";
	for ($j=100 ; $j>=0 ; $j=$j-10) {
		echo "<option value='".$j."'>".$j."%</option>";
	}
	echo "</select></th>"."\n";
}
?>
	<td>&nbsp;</td>
</tr>
<tr>
	<th><a><?php $LANG["ogame_FusionReactor"]; ?></a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$CEF = $user_building[$i][$cef_lang];
	echo "\t"."<th><input type='text' id='CEF_".$i."' size='2' maxlength='2' value='".$CEF."' onchange='update_page();'></th>"."\n";

	echo "\t"."<th>";
	echo "<select id='CEF_".$i."_percentage' onchange='update_page();' onKeyUp='update_page();'>";
	for ($j=100 ; $j>=0 ; $j=$j-10) {
		echo "<option value='".$j."'>".$j."%</option>";
	}
	echo "</select></th>"."\n";
}
?>
	<td>&nbsp;</td>
</tr>
<tr>
	<th><a><?php echo $LANG["ogame_Satellite"];?></a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$Sat = $user_building[$i]["Sat"];
	echo "\t"."<th><input type='text' id='Sat_".$i."' size='2' maxlength='5' value='".$Sat."' onchange='update_page();'></th>"."\n";

	echo "\t"."<th>";
	echo "<select id='Sat_".$i."_percentage' onchange='update_page();' onKeyUp='update_page();'>";
	for ($j=100 ; $j>=0 ; $j=$j-10) {
		echo "<option value='".$j."'>".$j."%</option>";
	}
	echo "</select></th>"."\n";
}
?>
	<td>&nbsp;</td>
</tr>
<tr>
	<th><a><?php echo $LANG["ogame_Energy"];?></a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><div id='NRJ_".$i."'>-</div></font></th>"."\n";
}
?>
	<th><div id="NRJ">-</div></th>
</tr>

<!--
Métal
-->

<tr>
	<td class="c" colspan="19"><?php echo $LANG["ogame_MetalMine"];?></td>
</tr>
<tr>
	<th><a>Niveau</a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$M = $user_building[$i][$m_lang];
	echo "\t"."<th><input type='text' id='M_".$i."' size='2' maxlength='2' value='".$M."' onchange='update_page();'></th>"."\n";

	echo "\t"."<th>";
	echo "<select id='M_".$i."_percentage' onchange='update_page();' onKeyUp='update_page();'>";
	for ($j=100 ; $j>=0 ; $j=$j-10) {
		echo "<option value='".$j."'>".$j."%</option>";
	}
	echo "</select></th>"."\n";
}
?>
	<td>&nbsp;</td>
</tr>
<tr>
	<th><a>Consommation Energie</a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><div id='M_".$i."_conso'>-</div></font></th>"."\n";
}
?>
	<th><div id="M_conso">-</div></th>
</tr>
<tr>
	<th><a>Production</a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><div id='M_".$i."_prod'>-</div></font></th>"."\n";
}
?>
	<th><div id="M_prod">-</div></th>
</tr>

<!--
Cristal
-->

<tr>
	<td class="c" colspan="19"><?php echo $LANG["ogame_CrystalMine"];?></td>
</tr>
<tr>
	<th><a>Niveau</a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$C = $user_building[$i][$c_lang];
	echo "\t"."<th><input type='text' id='C_".$i."' size='2' maxlength='2' value='".$C."' onchange='update_page();'></th>"."\n";

	echo "\t"."<th>";
	echo "<select id='C_".$i."_percentage' onchange='update_page();' onKeyUp='update_page();'>";
	for ($j=100 ; $j>=0 ; $j=$j-10) {
		echo "<option value='".$j."'>".$j."%</option>";
	}
	echo "</select></th>"."\n";
}
?>
	<td>&nbsp;</td>
</tr>
<tr>
	<th><a>Consommation Energie</a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><div id='C_".$i."_conso'>-</div></font></th>"."\n";
}
?>
	<th><div id="C_conso">-</div></th>
</tr>
<tr>
	<th><a>Production</a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><div id='C_".$i."_prod'>-</div></font></th>"."\n";
}
?>
	<th><div id="C_prod">-</div></th>
</tr>

<!--
Deutérium
-->

<tr>
	<td class="c" colspan="19"><?php echo $LANG["ogame_DeuteriumSynthesizer"];?></td>
</tr>
<tr>
	<th><a>Niveau</a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$D = $user_building[$i][$d_lang];
	echo "\t"."<th><input type='text' id='D_".$i."' size='2' maxlength='2' value='".$D."' onchange='update_page();'></th>"."\n";

	echo "\t"."<th>";
	echo "<select id='D_".$i."_percentage' onchange='update_page();' onKeyUp='update_page();'>";
	for ($j=100 ; $j>=0 ; $j=$j-10) {
		echo "<option value='".$j."'>".$j."%</option>";
	}
	echo "</select></th>"."\n";
}
?>
	<td>&nbsp;</td>
</tr>
<tr>
	<th><a>Consommation Energie</a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><font color='lime'><div id='D_".$i."_conso'>-</div></font></th>"."\n";
}
?>
	<th><div id="D_conso">-</div></th>
</tr>
<tr>
	<th><a>Production</a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><div id='D_".$i."_prod'>-</div></font></th>"."\n";
}
?>
	<th><div id="D_prod">-</div></th>
</tr>
<tr>
	<td class="c" colspan="19">Poids en points de chaque planete</th>
</tr>
<tr>
<th><a>Batiments</a></th>
<?php
$lab_max = 0;
for ($i=$start ; $i<=$start+$nplapage-1; $i++) {
	echo "\t<input type='hidden' id='building_".$i."' value='".implode(array_slice($user_building[$i],11), "<>")."' />";
	echo "\t"."<th colspan='2'><font color='lime'><div id='building_pts_".$i."'>-</div></font></th>"."\n";
	if($lab_max < $user_building[$i][$lab_lang]) $lab_max = $user_building[$i][$lab_lang];
}
?>
	<th><font color='white'><div id='total_b_pts'>-</div></font></th>
</tr>
<tr>
<th><a>Défences</a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	echo "\t<input type='hidden' id='defence_".$i."' value='".implode($user_defence[$i], "<>")."' />";
	echo "\t<th colspan='2'><font color='lime'><div id='defence_pts_".$i."'>-</div></font></th>"."\n";
}
?>
	<th><font color='white'><div id='total_d_pts'>-</div></font></th>
</tr>
<tr>
<th><a>Lunes</a></th>
<?php
for ($i=10 ; $i<=18 ; $i++) {
	echo "\t<input type='hidden' id='lune_b_".$i."' value='".implode(array_slice($user_building[$i],11), "<>")."' />";
	echo "\t<input type='hidden' id='lune_d_".$i."' value='".implode($user_defence[$i], "<>")."' />";
	echo "\t<th colspan='2'><font color='lime'><div id='lune_pts_".$i."'>-</div></font></th>"."\n";
}
?>
	<th><font color='white'><div id='total_lune_pts'>-</div></font></th>
</tr>
<tr>
	<th><a>Satellites</a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	echo "\t<input type='hidden' id='sat_lune_".$i."' value=".($user_building[$i+9]["Sat"]!="" ? $user_building[$i+9]["Sat"] : 0)." />";
	echo "\t"."<th colspan='2'><font color='lime'><div id='sat_pts_".$i."'>-</div></font></th>"."\n";
}
?>
	<th><div id="total_sat_pts">-</div></th>
</tr>
<tr>
<th><a><font color='yellow'>Totaux</font></a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	echo "\t"."<th colspan='2'><font color='white'><div id='total_pts_".$i."'>-</div></font></th>"."\n";
}
?>
<th><font color='white'><div id='total_pts'>-</div></font></th>
</tr>
<tr>
<th><a>Technologies</a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	if($user_empire["technology"]!=NULL && $user_building[$i][$lab_lang] == $lab_max) {
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
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$name = $user_building[$i]["planet_name"];
	if ($name == "") $name = "xxx";
	
	echo "\t"."<td class='c' colspan='2'><a>".$name."<a></td>"."\n";
}
?>
	<td class='c'>Totaux</td>
</tr>
</table>
<script language="JavaScript">
update_page();
</script>