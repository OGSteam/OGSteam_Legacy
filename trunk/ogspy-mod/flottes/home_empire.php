<?php
/***************************************************************************
*	filename	: home_empire.php
*	desc.		: 1.05
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

if ($gameselect=='OGAME') require_once("parameters/lang_empire.php");

$user_empire = user_get_empire();
$user_building = $user_empire["building"];
$user_defence = $user_empire["defence"];
$user_technology = $user_empire["technology"];

$affplanet=compte_planet($user_data['user_id'],$nplapage,$gameselect);
//var_dump($affplanet);

if(!isset($pub_view) || $pub_view=="") $view = "0";
else $view = $pub_view;

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
		echo "<td class='c' align='center' colspan='".$affplanet[2]."' onClick=\"window.location = 'index.php?action=flottes&subaction2=empire&view=".$i."&flottes_user_id=".$user_data['user_id']."';\"><a style='cursor:pointer'><font color='lime'>".$lib_page[$i]."</font></a></td>";
	}
}

echo "</tr><tr>";
echo "<td class='c' colspan='". $nbcol2."'>Vue d'ensemble de votre empire</td>";
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
?>
</tr>
<tr>
	<th><a>Cases</a></th>
<?php
for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$fields = $user_building[$i]["fields"];
	if ($fields == "0") $fields = 0;
	$fields_used = $user_building[$i]["fields_used"];
	$Ter = $user_building[$i][$ter_lang];
	if ($Ter == "") $Ter = 0;
	$BaLu = $user_building[$i][$balu_lang];
	if ($BaLu == "") $BaLu = 0;

	echo "\t"."<th>".$fields_used." / ". ($fields!=0 ? ($fields+5*$Ter+3*$BaLu) : "") ."</th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Température Min.</a></th>
<?php
for ($i=$start;  $i<=$start+$nplapage-1 ; $i++) {
	$temperature_min = $user_building[$i]["temperature_min"];
	if ($temperature_min == "") $temperature_min = "&nbsp;";

	echo "\t"."<th>".$temperature_min."</th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Température Max.</a></th>
<?php
for ($i=$start;  $i<=$start+$nplapage-1 ; $i++) {
	$temperature_max = $user_building[$i]["temperature_max"];
	if ($temperature_max == "") $temperature_max = "&nbsp;";

	echo "\t"."<th>".$temperature_max."</th>"."\n";
}
$test_og=0;
if ($view == "1" || $gameselect=="OGAME") $test_og=1;

	echo "</tr><tr>";
	echo "<td class='c' colspan='". $nbcol2."'>Production théorique</td>";
	echo "</tr><tr>";
	echo '<th><a>'.$LANG["ogame_Metal"].'</a></th>';


for ($i=$start;  $i<=$start+$nplapage-1 ; $i++) {
	$M = $user_building[$i][$m_lang];
	if ($M != "") $production = production("M", $M, $user_data['off_geologue']);
	else $production = "&nbsp";

	echo "\t"."<th>".$production."</th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_Crystal"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1; $i++) {
	$C = $user_building[$i][$c_lang];
	if ($C != "") $production = production("C", $C, $user_data['off_geologue']);
	else $production = "&nbsp";

	echo "\t"."<th>".$production."</th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_Deuterium"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$D = $user_building[$i][$d_lang];
	$temperature = $user_building[$i]["temperature_max"];
	$CEF = $user_building[$i][$cef_lang];
	$CEF_consumption = consumption($cef_lang, $CEF);
	if ($D != "") $production = floor(production("D", $D, $user_data['off_geologue'], $temperature_max) - $CEF_consumption);
	else $production = "&nbsp";

	echo "\t"."<th>".$production."</th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Energie</a></th>
<?php
$product= array( "M" => 0, "C" => 0, "D" => 0,"ratio" => 1, "conso_E" => 0, "prod_E" => 0 );
for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$CES = $user_building[$i][$ces_lang];
	$CEF = $user_building[$i][$cef_lang];
	$Sat = $user_building[$i]["Sat"];
	if ($Sat=="") $sat=0;
	$temperature = $user_building[$i]["temperature"];

	$production_CES = $production_CEF = $production_Sat = 0;
	$production_CES = production($ces_lang, $CES);
	$production_CEF = production($cef_lang, $CEF);
	$production_Sat = production_sat($temperature_min, $temperature_max, $officier = 0);

	$production = $production_CES + $production_CEF + $production_Sat;
	if ($production == 0) $production = "&nbsp";

	echo "\t"."<th>".$production."</th>"."\n";
}
/*
if ($test_og==0) {
	} // fin de si $test_og==0
else {
	echo '</tr><tr> <td class="c" colspan="10">Bâtiments</td>';
}
*/	
echo "</tr><tr>";
echo "<td class='c' colspan='". $nbcol2."'>Bâtiments</td>";
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_MetalMine"].'</a></th>';

for ($i=$start;  $i<=$start+$nplapage-1 ; $i++) {
	$M = $user_building[$i][$m_lang];
	if ($M == "") $M = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$M."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_CrystalMine"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$C = $user_building[$i][$c_lang];
	if ($C == "") $C = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$C."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_DeuteriumSynthesizer"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$D = $user_building[$i][$d_lang];
	if ($D == "") $D = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$D."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_SolarPlant"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1; $i++) {
	$CES = $user_building[$i][$ces_lang];
	if ($CES == "") $CES = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$CES."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_FusionReactor"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$CEF = $user_building[$i][$cef_lang];
	if ($CEF == "") $CEF = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$CEF."</font></th>"."\n";
}



echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_RoboticsFactory"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$UdR = $user_building[$i][$udr_lang];
	if ($UdR == "") $UdR = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$UdR."</font></th>"."\n";
}


echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_NaniteFactory"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$UdN = $user_building[$i][$udn_lang];
	if ($UdN == "") $UdN = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$UdN."</font></th>"."\n";
}

 // fin de si $test_og==0

echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_Shipyard"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$CSp = $user_building[$i][$csp_lang];
	if ($CSp == "") $CSp = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$CSp."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_MetalStorage"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$HM = $user_building[$i][$hm_lang];
	if ($HM == "") $HM = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$HM."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_CrystalStorage"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$HC = $user_building[$i][$hc_lang];
	if ($HC == "") $HC = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$HC."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_DeuteriumTank"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$HD = $user_building[$i][$hd_lang];
	if ($HD == "") $HD = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$HD."</font></th>"."\n";
}

if($test_og==0) {
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_ResearchLab"].'</a></th>';

for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$Lab = $user_building[$i][$lab_lang];
	if ($Lab == "") $Lab = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$Lab."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_Terraformer"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$Ter = $user_building[$i][$ter_lang];
	if ($Ter == "") $Ter = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$Ter."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_MissileSilo"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$Silo = $user_building[$i][$silo_lang];
	if ($Silo == "") $Silo = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$Silo."</font></th>"."\n";
}
if ($gameselect=="UNIVERS") {
	echo "</tr><tr>";
	echo '<th><a>'.$LANG["ogame_Converter"].'</a></th>';

	for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
		$CM = $user_building[$i][$cm_lang];
		if ($CM == "") $CM = "&nbsp;";

		echo "\t"."<th><font color='lime' id='6".($i)."'>".$CM."</font></th>"."\n";
	}
}

} // fin de si $test_og==0
else {
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_LunarBase"].'</a></th>';


for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$BaLu = $user_building[$i][$balu_lang];
	if ($BaLu == "") $BaLu = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$BaLu."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_SensorPhalanx"].'</a></th>';


for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$Pha = $user_building[$i][$pha_lang];
	if ($Pha == "") $Pha = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$Pha."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_JumpGate"].'</a></th>';


for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$PoSa = $user_building[$i][$posa_lang];
	if ($PoSa == "") $PoSa = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$PoSa."</font></th>"."\n";
}

} // fin de sinon $test_og==0

echo "</tr><tr>";
echo "<td class='c' colspan='". $nbcol2."'>".$LANG["ogame_Technology"]."</td>";
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_EspionageTechnology"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$Lab = $user_building[$i][$lab_lang];
	$Esp = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Esp = $user_technology[$esp_lang] != "" ? $user_technology[$esp_lang] : "0";
		$requirement = $technology_requirement[$esp_lang];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $Esp = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Esp = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$Esp."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_ComputerTechnology"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$Lab = $user_building[$i][$lab_lang];
	$Ordi = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Ordi = $user_technology[$ordi_lang] != "" ? $user_technology[$ordi_lang] : "0";
		$requirement = $technology_requirement[$ordi_lang];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $Ordi = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Ordi = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$Ordi."</font></th>"."\n";
}
if ($gameselect=="UNIVERS") {

echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_Alliages"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$Lab = $user_building[$i][$lab_lang];
	$Alli = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Alli = $user_technology[$alli_lang] != "" ? $user_technology[$alli_lang] : "0";
		$requirement = $technology_requirement[$alli_lang];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $Alli = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Alli = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$Alli."</font></th>"."\n";
}

echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_Strat"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$Lab = $user_building[$i][$lab_lang];
	$sc = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$SC = $user_technology[$sc_lang] != "" ? $user_technology[$sc_lang] : "0";
		$requirement = $technology_requirement[$sc_lang];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $SC = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$SC = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$SC."</font></th>"."\n";
}

echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_Raffinerie"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$Lab = $user_building[$i][$lab_lang];
	$Raf = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Raf = $user_technology[$raf_lang] != "" ? $user_technology[$raf_lang] : "0";
		$requirement = $technology_requirement[$raf_lang];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $Raf = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Raf = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$Raf."</font></th>"."\n";
}
}

echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_WeaponsTechnology"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$Lab = $user_building[$i][$lab_lang];
	$Armes = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Armes = $user_technology[$armes_lang] != "" ? $user_technology[$armes_lang] : "0";
		$requirement = $technology_requirement[$armes_lang];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $Armes = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Armes = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$Armes."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_ShieldingTechnology"].'</a></th>';

for ($i=$start;  $i<=$start+$nplapage-1 ; $i++) {
	$Lab = $user_building[$i][$lab_lang];
	$Bouclier = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Bouclier = $user_technology[$bouclier_lang] != "" ? $user_technology[$bouclier_lang] : "0";
		$requirement = $technology_requirement[$bouclier_lang];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $Bouclier = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Bouclier = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$Bouclier."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_ArmourTechnology"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$Lab = $user_building[$i][$lab_lang];
	$Protection = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Protection = $user_technology[$protec_lang] != "" ? $user_technology[$protec_lang] : "0";
		$requirement = $technology_requirement[$protec_lang];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $Protection = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Protection = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$Protection."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_EnergyTechnology"].'</a></th>';

for ($i=$start;  $i<=$start+$nplapage-1 ; $i++) {
	$Lab = $user_building[$i][$lab_lang];
	$NRJ = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$NRJ = $user_technology[$nrj_lang] != "" ? $user_technology[$nrj_lang] : "0";
		$requirement = $technology_requirement[$nrj_lang];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $NRJ = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$NRJ = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$NRJ."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_HyperspaceTechnology"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$Lab = $user_building[$i][$lab_lang];
	$Hyp = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Hyp = $user_technology[$hyp_lang] != "" ? $user_technology[$hyp_lang] : "0";
		$requirement = $technology_requirement[$hyp_lang];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $Hyp = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Hyp = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$Hyp."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_CombustionDrive"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$Lab = $user_building[$i][$lab_lang];
	$RC = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$RC = $user_technology[$rc_lang] != "" ? $user_technology[$rc_lang] : "0";
		$requirement = $technology_requirement[$rc_lang];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $RC = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$RC = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$RC."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_ImpulseDrive"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$Lab = $user_building[$i][$lab_lang];
	$RI = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$RI = $user_technology[$ri_lang] != "" ? $user_technology[$ri_lang] : "0";
		$requirement = $technology_requirement[$ri_lang];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $RI = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$RI = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$RI."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_HyperspaceDrive"].'</a></th>';

for ($i=$start;  $i<=$start+$nplapage-1 ; $i++) {
	$Lab = $user_building[$i][$lab_lang];
	$PH = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$PH = $user_technology[$ph_lang] != "" ? $user_technology[$ph_lang] : "0";
		$requirement = $technology_requirement[$ph_lang];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $PH = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$PH = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$PH."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_LaserTechnology"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$Lab = $user_building[$i][$lab_lang];
	$Laser = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Laser = $user_technology[$laser_lang] != "" ? $user_technology[$laser_lang] : "0";
		$requirement = $technology_requirement[$laser_lang];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $Laser = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Laser = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$Laser."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_IonTechnology"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$Lab = $user_building[$i][$lab_lang];
	$Ions = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Ions = $user_technology[$ions_lang] != "" ? $user_technology[$ions_lang] : "0";
		$requirement = $technology_requirement[$ions_lang];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $Ions = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Ions = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$Ions."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_PlasmaTechnology"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$Lab = $user_building[$i][$lab_lang];
	$Plasma = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Plasma = $user_technology[$plasma_lang] != "" ? $user_technology[$plasma_lang] : "0";
		$requirement = $technology_requirement[$plasma_lang];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $Plasma = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Plasma = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$Plasma."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_IntergalacticResearchNetwork"].'</a></th>';

for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$Lab = $user_building[$i][$lab_lang];
	$RRI = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$RRI = $user_technology[$rri_lang] != "" ? $user_technology[$rri_lang] : "0";
		$requirement = $technology_requirement[$rri_lang];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $RRI = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$RRI = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$RRI."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_AstrophysiqueTechnology"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$Lab = $user_building[$i][$lab_lang];
	$Astrophysique = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Astrophysique = $user_technology[$astro_lang] != "" ? $user_technology[$astro_lang] : "0";
		$requirement = $technology_requirement[$astro_lang];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $Astrophysique = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Astrophysique = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$Astrophysique."</font></th>"."\n";
}
echo "</tr><tr>";
echo '<th><a>'.$LANG["ogame_GravitonTechnology"].'</a></th>';

for ($i=$start ;  $i<=$start+$nplapage-1 ; $i++) {
	$Lab = $user_building[$i][$lab_lang];
	$Graviton = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Graviton = $user_technology[$grav_lang] != "" ? $user_technology[$grav_lang] : "0";
		$requirement = $technology_requirement[$grav_lang];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $Graviton = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Graviton = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$Graviton."</font></th>"."\n";
}
}
 // fin de si view="planets"
?>
</tr>

</table>