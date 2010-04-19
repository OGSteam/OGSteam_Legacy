<?php
/***************************************************************************
*	filename	: home_simulation.php
*	desc.		:
*	Author		: Kyser - http://ogsteam.fr/
*	created		: 19/12/2005
*	modified	: 06/08/2006 11:40:18
***************************************************************************/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}
$user_empire = user_get_empire();
$user_building = $user_empire["building"];
$user_defence = $user_empire["defence"];
?>
<SCRIPT LANGUAGE=Javascript SRC="js/spaccon_formula.js"></SCRIPT>

<table width="1200">
<tr>
	<td class="c"></td>
<?php
for ($i=1 ; $i<=9 ; $i++) {
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
for ($i=1 ; $i<=9 ; $i++) {
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
for ($i=1 ; $i<=9 ; $i++) {
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
for ($i=1 ; $i<=9 ; $i++) {
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
	<td class="c" colspan="20">Energies</th>
</tr>
<tr>
	<th><a>CES</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$CES = $user_building[$i]["CES"];
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
	<th><a>CEF</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$CEF = $user_building[$i]["CEF"];
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
	<th><a>Réflecteurs</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$ReSo = $user_building[$i]["ReSo"];
	echo "\t"."<th><input type='text' id='ReSo_".$i."' size='2' maxlength='5' value='".$ReSo."' onchange='update_page();'></th>"."\n";

	echo "\t"."<th>";
	echo "<select id='ReSo_".$i."_percentage' onchange='update_page();' onKeyUp='update_page();'>";
	for ($j=100 ; $j>=0 ; $j=$j-10) {
		echo "<option value='".$j."'>".$j."%</option>";
	}
	echo "</select></th>"."\n";
}
?>
	<td>&nbsp;</td>
</tr>
<tr>
	<th><a>Energie</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><div id='NRJ_".$i."'>-</div></font></th>"."\n";
}
?>
	<th><div id="NRJ">-</div></th>
</tr>

<!--
Acier
-->

<tr>
	<td class="c" colspan="20">Acier</td>
</tr>
<tr>
	<th><a>Niveau</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$M = $user_building[$i]["M"];
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
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><div id='M_".$i."_conso'>-</div></font></th>"."\n";
}
?>
	<th><div id="M_conso">-</div></th>
</tr>
<tr>
	<th><a>Production</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><div id='M_".$i."_prod'>-</div></font></th>"."\n";
}
?>
	<th><div id="M_prod">-</div></th>
</tr>

<!--
Silicium
-->

<tr>
	<td class="c" colspan="20">Silicium</td>
</tr>
<tr>
	<th><a>Niveau</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$C = $user_building[$i]["C"];
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
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><div id='C_".$i."_conso'>-</div></font></th>"."\n";
}
?>
	<th><div id="C_conso">-</div></th>
</tr>
<tr>
	<th><a>Production</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><div id='C_".$i."_prod'>-</div></font></th>"."\n";
}
?>
	<th><div id="C_prod">-</div></th>
</tr>

<!--
Deutéride
-->

<tr>
	<td class="c" colspan="20">Deutéride</td>
</tr>
<tr>
	<th><a>Niveau</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$D = $user_building[$i]["D"];
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
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><font color='lime'><div id='D_".$i."_conso'>-</div></font></th>"."\n";
}
?>
	<th><div id="D_conso">-</div></th>
</tr>
<tr>
	<th><a>Production</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th colspan='2'><font color='lime'><div id='D_".$i."_prod'>-</div></font></th>"."\n";
}
?>
	<th><div id="D_prod">-</div></th>
</tr>
<tr>
	<td class="c" colspan="20">Poids en points de chaque planète</th>
</tr>
<tr>
<th><a>Bâtiments</a></th>
<?php
$lab_max = 0;
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t<input type='hidden' id='building_".$i."' value='".implode(array_slice($user_building[$i],11), "<>")."' />";
	echo "\t"."<th colspan='2'><font color='lime'><div id='building_pts_".$i."'>-</div></font></th>"."\n";
	if($lab_max < $user_building[$i]["Lab"]) $lab_max = $user_building[$i]["Lab"];
}
?>
	<th><font color='white'><div id='total_b_pts'>-</div></font></th>
</tr>
<tr>
<th><a>Défenses</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
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
	<th><a>Réflecteurs</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t<input type='hidden' id='ReSo_lune_".$i."' value=".($user_building[$i+9]["ReSo"]!="" ? $user_building[$i+9]["ReSo"] : 0)." />";
	echo "\t"."<th colspan='2'><font color='lime'><div id='ReSo_pts_".$i."'>-</div></font></th>"."\n";
}
?>
	<th><div id="total_ReSo_pts">-</div></th>
</tr>
<tr>
<th><a><font color='yellow'>Totaux</font></a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th colspan='2'><font color='white'><div id='total_pts_".$i."'>-</div></font></th>"."\n";
}
?>
<th><font color='white'><div id='total_pts'>-</div></font></th>
</tr>
<tr>
<th><a>Technologies</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	if($user_empire["technology"]!=NULL && $user_building[$i]["Lab"] == $lab_max) {
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
for ($i=1 ; $i<=9 ; $i++) {
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