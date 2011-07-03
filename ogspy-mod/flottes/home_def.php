<?php
/***************************************************************************
*	filename	: home_def.php
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
require_once("./includes/".$phpfonc.".php");
//require_once("parameters/lang_empire.php");

$user_flottes = user_get_empire();
$user_building = $user_flottes["building"];
$user_defence = $user_flottes["defence"];
$user_technology = $user_flottes["technology"];

$affplanet=compte_planet($user_data['user_id'],$nplapage,$gameselect);
//var_dump($affplanet);

if(!isset($pub_view) || $pub_view=="") $view = "0";
else $view = $pub_view;
$start = $view=="0" ? 1 : ($view*$nplapage)+1;
?>
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
		echo "<td class='c' align='center' colspan='".$affplanet[2]."' onClick=\"window.location = 'index.php?action=flottes&subaction2=def&view=".$i."&flottes_user_id=".$user_data['user_id']."';\"><a style='cursor:pointer'><font color='lime'>".$lib_page[$i]."</font></a></td>";
	}
}

echo "</tr><tr>";
echo "<td class='c' colspan='". $nbcol2."'>Vue d'ensemble de votre défense</td>";
echo "</tr><tr>";
echo "<th width='10%'><a>Nom</a></th>";

for ($i=0 ; $i<=$affplanet[1] ; $i++) {
	if ($view == $i) {
		$start = $view=="0" ? 101 : ($view*$nplapage)+1;
	} 
	else {
		$start = $view=="1" ? 201 : ($view*$nplapage)+1;
	}
	
	
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$name = $user_building[$i]["planet_name"];
	echo "\t"."<th width='8%'><label for='".$i."'>".$name."</label></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Coordonnées</a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$il=$i;
	$coordinates = $user_building[$i]["coordinates"];
	if ($coordinates == "" || ($user_building[$i]["planet_name"] == "" && $view=="1")) $coordinates = "&nbsp;";
	else $coordinates = "[".$coordinates."]";
//	if ($view=="1") $il=$i+$nplapage;
//		else $il=$i;
	echo "\t"."<th><label for='".$il."'>".$coordinates."</label></th>"."\n";
}

echo "</tr><tr>";
echo "<td class='c' colspan='". $nbcol2."'>Défenses</td>";
echo "</tr>";
?>
	<th><a><?php echo $LANG["ogame_RocketLauncher"]; ?></a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$LM = $user_defence[$i][$lm_lang];
	if ($LM == "") $LM = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$LM."</font></th>"."\n";
}

echo "</tr><tr>";
echo	"<th><a>". $LANG["ogame_LightLaser"]."</a></th>";

for ($i=$start ; $i<=$start+$nplapage-1; $i++) {
	$LLE = $user_defence[$i][$lle_lang];
	if ($LLE == "") $LLE = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$LLE."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["ogame_HeavyLaser"]; ?></a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$LLO = $user_defence[$i][$llo_lang];
	if ($LLO == "") $LLO = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$LLO."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["ogame_GaussCannon"]; ?></a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$CG = $user_defence[$i][$cg_lang];
	if ($CG == "") $CG = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$CG."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["ogame_IonCannon"]; ?></a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1; $i++) {
	$AI = $user_defence[$i][$ai_lang];
	if ($AI == "") $AI = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$AI."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["ogame_PlasmaTuret"]; ?></a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$LP = $user_defence[$i][$lp_lang];
	if ($LP == "") $LP = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$LP."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["ogame_SmallShield"]; ?></a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$PB = $user_defence[$i][$pb_lang];
	if ($PB == "") $PB = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$PB."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["ogame_LargeShield"]; ?></a></th>
<?php
for ($i=$start ;$i<=$start+$nplapage-1 ; $i++) {
	$GB = $user_defence[$i][$gb_lang];
	if ($GB == "") $GB = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$GB."</font></th>"."\n";
}

//if($view == "planets") {
?>
</tr>
<tr>
	<th><a><?php echo $LANG["ogame_AntiBallisticMissiles"]; ?></a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$MIC = $user_defence[$i][$mic_lang];
	if ($MIC == "") $MIC = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$MIC."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $LANG["ogame_InterplanetaryMissiles"]; ?></a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$MIP = $user_defence[$i][$mip_lang];
	if ($MIP == "") $MIP = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$MIP."</font></th>"."\n";
}

} // fin de si view="planets"
?>
</tr>
</table>