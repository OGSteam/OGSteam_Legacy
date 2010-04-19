<?php




define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';


// Load the index.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/index.php';
define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT.'header.php';


///ogpt
$lien="empire.php";
$page_title = "Empire";
require_once PUN_ROOT.'ogpt/include/ogpt.php';
/// fin ogpt


?>
<?php



echo'<div class="blockform"><h2><span> Empire</span></h2><div class="box"><div class="infldset">';


     echo '<table border="0" cellpadding="2" cellspacing="0" align="center"';
 echo'<tr><th><b><a href="empire.php">Planetes</a></th><th><b><a href="empire.php?lunes">Lunes</a></th><th><b><a href="empire.php?calc">Ocalc</a></th><th><b><a href="empire.php?deco">Decolonisation</a></th></tr> </table>';

 echo '<table border="0" cellpadding="2" cellspacing="0" align="center"';
 if (isset($_GET['deco']))
    {
    	
 
 
 
$user_empire = user_get_empire();
$user_building = $user_empire["building"];
$user_defence = $user_empire["defence"];
$user_technology = $user_empire["technology"];
$sep_mille = '.';


$nbre_planete=0;
$lune=0;
for ($i=1 ; $i<=9 ; $i++) {
	if ($user_building[$i][0]) {
		$nbre_planete += 1;
		$planete[$nbre_planete] = $i;
		if ($user_building[$i+9]["planet_name"]) $lune = 1;
	}
}


?>

<table width="100%">
<tr>
	<td class="c" colspan="<?php echo $nbre_planete + 1; ?>">Mod Décolonisation</td>
</tr>
<tr>
	<th><a>Nom</a></th>
<?php
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$name[$planete[$i]] = $user_building[$planete[$i]]["planet_name"];
	if ($name[$planete[$i]] == "") $name[$planete[$i]] = "&nbsp;";

	echo "\t<th><a>".$name[$planete[$i]]."</a></th>\n";
}
?>
</tr>
<tr>
	<th><a>Coordonnées</a></th>
<?php
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$coordinates = $user_building[$planete[$i]]["coordinates"];
	if ($coordinates == "") $coordinates = "&nbsp;";
	else $coordinates = "[".$coordinates."]";

	echo "\t<th>".$coordinates."</th>\n";
}
?>
</tr>
<tr>
	<th><a>Température</a></th>
<?php
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$temperature[$planete[$i]] = $user_building[$planete[$i]]["temperature"];
	if ($temperature[$planete[$i]] == "") $temperature[$planete[$i]] = "&nbsp;";

	echo "\t<th>".$temperature[$planete[$i]]."</th>\n";
}
?>
</tr>
<tr>
	<td class="c" colspan="<?php echo $nbre_planete + 1; ?>">Points <?php echo $lang_empire["Batiment"] ?></td><td class="c" style="text-align:center">Totaux</td>
</tr>
<tr>
	<th><a><?php echo $lang_building["M"] ?></a></th>
<?php
$building_cumulate_M_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_M[$planete[$i]] = 0;
	$building_cumulate_M[$planete[$i]] = intval(75 * (1 - pow(1.5 , $user_building[$planete[$i]]["M"])) / ((1 - 1.5) * 1000)) ;
	if ($building_cumulate_M[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_M[$planete[$i]], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_M_tot += $building_cumulate_M[$planete[$i]];
}
if ($building_cumulate_M_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_M_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["C"] ?></a></th>
<?php
$building_cumulate_C_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_C[$planete[$i]] = intval(72 * (1 - pow(1.6 , $user_building[$planete[$i]]["C"])) / ((1- 1.6) * 1000)) ;
	if ($building_cumulate_C[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_C[$planete[$i]], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_C_tot += $building_cumulate_C[$planete[$i]];
}
if ($building_cumulate_C_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_C_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["D"] ?></a></th>
<?php
$building_cumulate_D_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_D[$planete[$i]] = intval(300 * (1 - pow(1.5 , $user_building[$planete[$i]]["D"])) / ((1 - 1.5) * 1000)) ;
	if ($building_cumulate_D[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_D[$planete[$i]], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_D_tot += $building_cumulate_D[$planete[$i]];
}
if ($building_cumulate_D_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_D_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["CES"] ?></a></th>
<?php
$building_cumulate_CES_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_CES[$planete[$i]] = intval(105 * (1 - pow(1.5 , $user_building[$planete[$i]]["CES"])) / ((1 - 1.5) * 1000)) ;
	if ($building_cumulate_CES[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_CES[$planete[$i]], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_CES_tot += $building_cumulate_CES[$planete[$i]];
}
if ($building_cumulate_CES_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_CES_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["CEF"] ?></a></th>
<?php
$building_cumulate_CEF_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_CEF[$planete[$i]] = intval(1440 * (1 - pow(1.8 , $user_building[$planete[$i]]["CEF"])) / ((1 - 1.8) * 1000)) ;
	if ($building_cumulate_CEF[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_CEF[$planete[$i]], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_CEF_tot += $building_cumulate_CEF[$planete[$i]];
}
if ($building_cumulate_CEF_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_CEF_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["UdR"] ?></a></th>
<?php
$building_cumulate_UdR_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_UdR[$planete[$i]] = intval(720 * (1 - pow(2 , $user_building[$planete[$i]]["UdR"])) / ((1 - 2) * 1000)) ;
	if ($building_cumulate_UdR[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_UdR[$planete[$i]], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_UdR_tot += $building_cumulate_UdR[$planete[$i]];
}
if ($building_cumulate_UdR_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_UdR_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["UdN"] ?></a></th>
<?php
$building_cumulate_UdN_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_UdN[$planete[$i]] = intval(1600000 * (1 - pow(2 , $user_building[$planete[$i]]["UdN"])) / ((1 - 2) * 1000)) ;
	if ($building_cumulate_UdN[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_UdN[$planete[$i]], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_UdN_tot += $building_cumulate_UdN[$planete[$i]];
}
if ($building_cumulate_UdN_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_UdN_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["CSp"] ?></a></th>
<?php
$building_cumulate_CSp_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_CSp[$planete[$i]] = intval(700 * (1 - pow(2 , $user_building[$planete[$i]]["CSp"])) / ((1 - 2) * 1000)) ;
	if ($building_cumulate_CSp[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_CSp[$planete[$i]], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_CSp_tot += $building_cumulate_CSp[$planete[$i]];
}
if ($building_cumulate_CSp_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_CSp_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["HM"] ?></a></th>
<?php
$building_cumulate_HM_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_HM[$planete[$i]] = intval(2000 * (1 - pow(2 , $user_building[$planete[$i]]["HM"])) / ((1 - 2) * 1000)) ;
	if ($building_cumulate_HM[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_HM[$planete[$i]], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_HM_tot += $building_cumulate_HM[$planete[$i]];
}
if ($building_cumulate_HM_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_HM_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["HC"] ?></a></th>
<?php
$building_cumulate_HC_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_HC[$planete[$i]] = intval(3000 * (1 - pow(2 , $user_building[$planete[$i]]["HC"])) / ((1 - 2) * 1000)) ;
	if ($building_cumulate_HC[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_HC[$planete[$i]], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_HC_tot += $building_cumulate_HC[$planete[$i]];
}
if ($building_cumulate_HC_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_HC_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["HD"] ?></a></th>
<?php
$building_cumulate_HD_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_HD[$planete[$i]] = intval(4000 * (1 - pow(2 , $user_building[$planete[$i]]["HD"])) / ((1 - 2) * 1000)) ;
	if ($building_cumulate_HD[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_HD[$planete[$i]], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_HD_tot += $building_cumulate_HD[$planete[$i]];
}
if ($building_cumulate_HD_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_HD_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["Lab"] ?></a></th>
<?php
$building_cumulate_Lab_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_Lab[$planete[$i]] = intval(800 * (1 - pow(2 , $user_building[$planete[$i]]["Lab"])) / ((1 - 2) * 1000)) ;
	if ($building_cumulate_Lab[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_Lab[$planete[$i]], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_Lab_tot += $building_cumulate_Lab[$planete[$i]];
}
if ($building_cumulate_Lab_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_Lab_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["Ter"] ?></a></th>
<?php
$building_cumulate_Ter_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_Ter[$planete[$i]] = intval(150000 * (1 - pow(2 , $user_building[$planete[$i]]["Ter"])) / ((1 - 2) * 1000)) ;
	if ($building_cumulate_Ter[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_Ter[$planete[$i]], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_Ter_tot += $building_cumulate_Ter[$planete[$i]];
}
if ($building_cumulate_Ter_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_Ter_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["Silo"] ?></a></th>
<?php
$building_cumulate_Silo_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_Silo[$planete[$i]] = intval(41000 * (1 - pow(2 , $user_building[$planete[$i]]["Silo"])) / ((1 - 2) * 1000)) ;
	if ($building_cumulate_Silo[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_Silo[$planete[$i]], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_Silo_tot += $building_cumulate_Silo[$planete[$i]];
}
if ($building_cumulate_Silo_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_Silo_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<?php
$building_cumulate_DdR = array(0,0,0,0,0,0,0,0,0,0);
if ($ddr == 1):
?>
<tr>
	<th><a><?php echo $lang_building["DdR"] ?></a></th>
<?php
$building_cumulate_DdR_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_DdR[$planete[$i]] = intval(60000 * (1 - pow(2 , $user_building[$planete[$i]]["DdR"])) / ((1 - 2) * 1000)) ;
	if ($building_cumulate_DdR[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_DdR[$planete[$i]], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_DdR_tot += $building_cumulate_DdR[$planete[$i]];
}
if ($building_cumulate_DdR_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_DdR_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<?php endif; ?>
<tr>
	<th><a>Satellite solaire</a></th>
<?php
$building_cumulate_Sat_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_Sat[$planete[$i]] = 2.5 * $user_building[$planete[$i]]["Sat"];
	if ($building_cumulate_Sat[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_Sat[$planete[$i]], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_Sat_tot += $building_cumulate_Sat[$planete[$i]];
}
if ($building_cumulate_Sat_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_Sat_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a>Sous-total</a></th>
<?php
$total_batiments_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$total_batiments[$planete[$i]] = $building_cumulate_M[$planete[$i]] + $building_cumulate_C[$planete[$i]] + $building_cumulate_D[$planete[$i]] + $building_cumulate_CES[$planete[$i]] + $building_cumulate_CEF[$planete[$i]] + $building_cumulate_UdR[$planete[$i]] + $building_cumulate_UdN[$planete[$i]] + $building_cumulate_CSp[$planete[$i]] + $building_cumulate_HM[$planete[$i]] + $building_cumulate_HC[$planete[$i]] + $building_cumulate_HD[$planete[$i]] + $building_cumulate_Lab[$planete[$i]] + $building_cumulate_Ter[$planete[$i]] + $building_cumulate_Silo[$planete[$i]] + $building_cumulate_DdR[$planete[$i]] + $building_cumulate_Sat[$planete[$i]];
	if ($total_batiments[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($total_batiments[$planete[$i]], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$total_batiments_tot += $total_batiments[$planete[$i]];
}
if ($total_batiments_tot < "1") $affich = "&nbsp;";
else $affich = number_format($total_batiments_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<td class="c" colspan="<?php echo $nbre_planete+2; ?>">Points <?php echo $lang_empire["Défense"] ?></td>
</tr>
<tr>
	<th><a><?php echo $lang_defence["LM"] ?></a></th>
<?php
$user_defence_tot["LM"] = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$user_defence[$planete[$i]]["LM"] = 2 * $user_defence[$planete[$i]]["LM"];
	if ($user_defence[$planete[$i]]["LM"] < "1") $affich = "&nbsp;";
	else $affich = number_format($user_defence[$planete[$i]]["LM"], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$user_defence_tot["LM"] += $user_defence[$planete[$i]]["LM"];
}
if ($user_defence_tot["LM"] < "1") $affich = "&nbsp;";
else $affich = number_format($user_defence_tot["LM"], 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_defence["LLE"] ?></a></th>
<?php
$user_defence_tot["LLE"] = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$user_defence[$planete[$i]]["LLE"] = 2 * $user_defence[$planete[$i]]["LLE"];
	if ($user_defence[$planete[$i]]["LLE"] < "1") $affich = "&nbsp;";
	else $affich = number_format($user_defence[$planete[$i]]["LLE"], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$user_defence_tot["LLE"] += $user_defence[$planete[$i]]["LLE"];
}
if ($user_defence_tot["LLE"] < "1") $affich = "&nbsp;";
else $affich = number_format($user_defence_tot["LLE"], 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_defence["LLO"] ?></a></th>
<?php
$user_defence_tot["LLO"] = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$user_defence[$planete[$i]]["LLO"] = 8 * $user_defence[$planete[$i]]["LLO"];
	if ($user_defence[$planete[$i]]["LLO"] < "1") $affich = "&nbsp;";
	else $affich = number_format($user_defence[$planete[$i]]["LLO"], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$user_defence_tot["LLO"] += $user_defence[$planete[$i]]["LLO"];
}
if ($user_defence_tot["LLO"] < "1") $affich = "&nbsp;";
else $affich = number_format($user_defence_tot["LLO"], 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_defence["CG"] ?></a></th>
<?php
$user_defence_tot["CG"] = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$user_defence[$planete[$i]]["CG"] = 37 * $user_defence[$planete[$i]]["CG"];
	if ($user_defence[$planete[$i]]["CG"] < "1") $affich = "&nbsp;";
	else $affich = number_format($user_defence[$planete[$i]]["CG"], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$user_defence_tot["CG"] += $user_defence[$planete[$i]]["CG"];
}
if ($user_defence_tot["CG"] < "1") $affich = "&nbsp;";
else $affich = number_format($user_defence_tot["CG"], 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_defence["AI"] ?></a></th>
<?php
$user_defence_tot["AI"] = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$user_defence[$planete[$i]]["AI"] = 8 * $user_defence[$planete[$i]]["AI"];
	if ($user_defence[$planete[$i]]["AI"] < "1") $affich = "&nbsp;";
	else $affich = number_format($user_defence[$planete[$i]]["AI"], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$user_defence_tot["AI"] += $user_defence[$planete[$i]]["AI"];
}
if ($user_defence_tot["AI"] < "1") $affich = "&nbsp;";
else $affich = number_format($user_defence_tot["AI"], 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_defence["LP"] ?></a></th>
<?php
$user_defence_tot["LP"] = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$user_defence[$planete[$i]]["LP"] = 130 * $user_defence[$planete[$i]]["LP"];
	if ($user_defence[$planete[$i]]["LP"] < "1") $affich = "&nbsp;";
	else $affich = number_format($user_defence[$planete[$i]]["LP"], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$user_defence_tot["LP"] += $user_defence[$planete[$i]]["LP"];
}
if ($user_defence_tot["LP"] < "1") $affich = "&nbsp;";
else $affich = number_format($user_defence_tot["LP"], 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_defence["PB"] ?></a></th>
<?php
$user_defence_tot["PB"] = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$user_defence[$planete[$i]]["PB"] = 20 * $user_defence[$planete[$i]]["PB"];
	if ($user_defence[$planete[$i]]["PB"] < "1") $affich = "&nbsp;";
	else $affich = number_format($user_defence[$planete[$i]]["PB"], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$user_defence_tot["PB"] += $user_defence[$planete[$i]]["PB"];
}
if ($user_defence_tot["PB"] < "1") $affich = "&nbsp;";
else $affich = number_format($user_defence_tot["PB"], 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_defence["GB"] ?></a></th>
<?php
$user_defence_tot["GB"] = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$user_defence[$planete[$i]]["GB"] = 100 * $user_defence[$planete[$i]]["GB"];
	if ($user_defence[$planete[$i]]["GB"] < "1") $affich = "&nbsp;";
	else $affich = number_format($user_defence[$planete[$i]]["GB"], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$user_defence_tot["GB"] += $user_defence[$planete[$i]]["GB"];
}
if ($user_defence_tot["GB"] < "1") $affich = "&nbsp;";
else $affich = number_format($user_defence_tot["GB"], 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_defence["MIC"] ?></a></th>
<?php
$user_defence_tot["MIC"] = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$user_defence[$planete[$i]]["MIC"] = 10 * $user_defence[$planete[$i]]["MIC"];
	if ($user_defence[$planete[$i]]["MIC"] < "1") $affich = "&nbsp;";
	else $affich = number_format($user_defence[$planete[$i]]["MIC"], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$user_defence_tot["MIC"] += $user_defence[$planete[$i]]["MIC"];
}
if ($user_defence_tot["MIC"] < "1") $affich = "&nbsp;";
else $affich = number_format($user_defence_tot["MIC"], 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_defence["MIP"] ?></a></th>
<?php
$user_defence_tot["MIP"] = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$user_defence[$planete[$i]]["MIP"] = 25 * $user_defence[$planete[$i]]["MIP"];
	if ($user_defence[$planete[$i]]["MIP"] < "1") $affich = "&nbsp;";
	else $affich = number_format($user_defence[$planete[$i]]["MIP"], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$user_defence_tot["MIP"] += $user_defence[$planete[$i]]["MIP"];
}
if ($user_defence_tot["MIP"] < "1") $affich = "&nbsp;";
else $affich = number_format($user_defence_tot["MIP"], 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a>Sous-total</a></th>
<?php
$total_defence_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$total_defence[$planete[$i]] = $user_defence[$planete[$i]]["LM"] + $user_defence[$planete[$i]]["LLE"] + $user_defence[$planete[$i]]["LLO"] + $user_defence[$planete[$i]]["CG"] + $user_defence[$planete[$i]]["AI"] + $user_defence[$planete[$i]]["LP"] + $user_defence[$planete[$i]]["PB"] + $user_defence[$planete[$i]]["GB"] + $user_defence[$planete[$i]]["MIC"] + $user_defence[$planete[$i]]["MIP"];
	if ($total_defence[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($total_defence[$planete[$i]], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$total_defence_tot += $total_defence[$planete[$i]];
}
if ($total_defence_tot < "1") $affich = "&nbsp;";
else $affich = number_format($total_defence_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<?php if ($lune==1) : ?>
<tr>
	<td class="c">Points <?php echo $lang_empire["Batiment"] ?> Lune</td>
 <?php
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$name[$planete[$i]+9] = $user_building[$planete[$i]+9]["planet_name"];
	if ($name[$planete[$i]+9] == "") $name[$planete[$i]+9] = "&nbsp;";
	echo "\t<td class='c' style='text-align:center'><a>".$name[$planete[$i]+9]."</a></td>\n";
}
?>
	<td class="c" style="text-align:center">Totaux</td>
</tr>
<tr>
	<th><a><?php echo $lang_building["UdR"] ?></a></th>
<?php
$building_cumulate_UdRL_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_UdR[$planete[$i]+9] = intval(720 * (1 - pow(2 , $user_building[$planete[$i]+9]["UdR"])) / ((1 - 2) * 1000)) ;
	if ($building_cumulate_UdR[$planete[$i]+9] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_UdR[$planete[$i]+9], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_UdRL_tot += $building_cumulate_UdR[$planete[$i]+9];
}
if ($building_cumulate_UdRL_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_UdRL_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["CSp"] ?></a></th>
<?php
$building_cumulate_CSpL_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_CSp[$planete[$i]+9] = intval(700 * (1 - pow(2 , $user_building[$planete[$i]+9]["CSp"])) / ((1 - 2) * 1000)) ;
	if ($building_cumulate_CSp[$planete[$i]+9] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_CSp[$planete[$i]+9], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_CSpL_tot += $building_cumulate_CSp[$planete[$i]+9];
}
if ($building_cumulate_CSpL_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_CSpL_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["HM"] ?></a></th>
<?php
$building_cumulate_HML_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_HM[$planete[$i]+9] = intval(2000 * (1 - pow(2 , $user_building[$planete[$i]+9]["HM"])) / ((1 - 2) * 1000)) ;
	if ($building_cumulate_HM[$planete[$i]+9] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_HM[$planete[$i]+9], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_HML_tot += $building_cumulate_HM[$planete[$i]+9];
}
if ($building_cumulate_HML_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_HML_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["HC"] ?></a></th>
<?php
$building_cumulate_HCL_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_HC[$planete[$i]+9] = intval(3000 * (1 - pow(2 , $user_building[$planete[$i]+9]["HC"])) / ((1 - 2) * 1000)) ;
	if ($building_cumulate_HC[$planete[$i]+9] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_HC[$planete[$i]+9], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_HCL_tot += $building_cumulate_HC[$planete[$i]+9];
}
if ($building_cumulate_HCL_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_HCL_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["HD"] ?></a></th>
<?php
$building_cumulate_HDL_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_HD[$planete[$i]+9] = intval(4000 *(1 - pow(2 , $user_building[$planete[$i]+9]["HD"])) / ((1 - 2) * 1000)) ;
	if ($building_cumulate_HD[$planete[$i]+9] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_HD[$planete[$i]+9], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_HDL_tot += $building_cumulate_HD[$planete[$i]+9];
}
if ($building_cumulate_HDL_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_HDL_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["BaLu"] ?></a></th>
<?php
$building_cumulate_BaLu_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_BaLu[$planete[$i]+9] = intval(80000 * (1 - pow(2 , $user_building[$planete[$i]+9]["BaLu"])) / ((1 - 2) * 1000)) ;
	if ($building_cumulate_BaLu[$planete[$i]+9] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_BaLu[$planete[$i]+9], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_BaLu_tot += $building_cumulate_BaLu[$planete[$i]+9];
}
if ($building_cumulate_BaLu_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_BaLu_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["Pha"] ?></a></th>
<?php
$building_cumulate_Pha_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_Pha[$planete[$i]+9] = intval(80000 * (1 - pow(2 , $user_building[$planete[$i]+9]["Pha"])) / ((1 - 2) * 1000)) ;
	if ($building_cumulate_Pha[$planete[$i]+9] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_Pha[$planete[$i]+9], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_Pha_tot += $building_cumulate_Pha[$planete[$i]+9];
}
if ($building_cumulate_Pha_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_Pha_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["PoSa"] ?></a></th>
<?php
$building_cumulate_PoSa_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_PoSa[$planete[$i]+9] = intval(8000000 * (1 - pow(2 , $user_building[$planete[$i]+9]["PoSa"])) / ((1 - 2) * 1000)) ;
	if ($building_cumulate_PoSa[$planete[$i]+9] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_PoSa[$planete[$i]+9], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_PoSa_tot += $building_cumulate_PoSa[$planete[$i]+9];
}
if ($building_cumulate_PoSa_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_PoSa_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a>Satellite solaire</a></th>
<?php
$building_cumulate_SatL_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$building_cumulate_Sat[$planete[$i]+9] = 2.5 * $user_building[$planete[$i]+9]["Sat"];
	if ($building_cumulate_Sat[$planete[$i]+9] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate_Sat[$planete[$i]+9], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_SatL_tot += $building_cumulate_Sat[$planete[$i]+9];
}
if ($building_cumulate_SatL_tot < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_SatL_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a>Sous-total</a></th>
<?php
$total_batimentsL_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$total_batiments[$planete[$i]+9] = $building_cumulate_UdR[$planete[$i]+9] + $building_cumulate_CSp[$planete[$i]+9] + $building_cumulate_HM[$planete[$i]+9] + $building_cumulate_HC[$planete[$i]+9] + $building_cumulate_HD[$planete[$i]+9] + $building_cumulate_BaLu[$planete[$i]+9] + $building_cumulate_Pha[$planete[$i]+9] + $building_cumulate_PoSa[$planete[$i]+9] + $building_cumulate_Sat[$planete[$i]+9];
	if ($total_batiments[$planete[$i]+9] < "1") $affich = "&nbsp;";
	else $affich = number_format($total_batiments[$planete[$i]+9], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$total_batimentsL_tot += $total_batiments[$planete[$i]+9];
}
if ($total_batimentsL_tot < "1") $affich = "&nbsp;";
else $affich = number_format($total_batimentsL_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<td class="c" colspan="<?php echo $nbre_planete+2; ?>">Points <?php echo $lang_empire["Défense"] ?> Lune</td>
</tr>
<tr>
	<th><a><?php echo $lang_defence["LM"] ?></a></th>
<?php
$user_defenceL_tot["LM"] = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$user_defence[$planete[$i]+9]["LM"] = 2 * $user_defence[$planete[$i]+9]["LM"];
	if ($user_defence[$planete[$i]+9]["LM"] < "1") $affich = "&nbsp;";
	else $affich = number_format($user_defence[$planete[$i]+9]["LM"], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$user_defenceL_tot["LM"] += $user_defence[$planete[$i]+9]["LM"];
}
if ($user_defenceL_tot["LM"] < "1") $affich = "&nbsp;";
else $affich = number_format($user_defenceL_tot["LM"], 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_defence["LLE"] ?></a></th>
<?php
$user_defenceL_tot["LLE"] = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$user_defence[$planete[$i]+9]["LLE"] = 2 * $user_defence[$planete[$i]+9]["LLE"];
	if ($user_defence[$planete[$i]+9]["LLE"] < "1") $affich = "&nbsp;";
	else $affich = number_format($user_defence[$planete[$i]+9]["LLE"], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$user_defenceL_tot["LLE"] += $user_defence[$planete[$i]+9]["LLE"];
}
if ($user_defenceL_tot["LLE"] < "1") $affich = "&nbsp;";
else $affich = number_format($user_defenceL_tot["LLE"], 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_defence["LLO"] ?></a></th>
<?php
$user_defenceL_tot["LLO"] = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$user_defence[$planete[$i]+9]["LLO"] = 8 * $user_defence[$planete[$i]+9]["LLO"];
	if ($user_defence[$planete[$i]+9]["LLO"] < "1") $affich = "&nbsp;";
	else $affich = number_format($user_defence[$planete[$i]+9]["LLO"], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$user_defenceL_tot["LLO"] += $user_defence[$planete[$i]+9]["LLO"];
}
if ($user_defenceL_tot["LLO"] < "1") $affich = "&nbsp;";
else $affich = number_format($user_defenceL_tot["LLO"], 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_defence["CG"] ?></a></th>
<?php
$user_defenceL_tot["CG"] = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$user_defence[$planete[$i]+9]["CG"] = 37 * $user_defence[$planete[$i]+9]["CG"];
	if ($user_defence[$planete[$i]+9]["CG"] < "1") $affich = "&nbsp;";
	else $affich = number_format($user_defence[$planete[$i]+9]["CG"], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$user_defenceL_tot["CG"] += $user_defence[$planete[$i]+9]["CG"];
}
if ($user_defenceL_tot["CG"] < "1") $affich = "&nbsp;";
else $affich = number_format($user_defenceL_tot["CG"], 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_defence["AI"] ?></a></th>
<?php
$user_defenceL_tot["AI"] = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$user_defence[$planete[$i]+9]["AI"] = 8 * $user_defence[$planete[$i]+9]["AI"];
	if ($user_defence[$planete[$i]+9]["AI"] < "1") $affich = "&nbsp;";
	else $affich = number_format($user_defence[$planete[$i]+9]["AI"], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$user_defenceL_tot["AI"] += $user_defence[$planete[$i]+9]["AI"];
}
if ($user_defenceL_tot["AI"] < "1") $affich = "&nbsp;";
else $affich = number_format($user_defenceL_tot["AI"], 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_defence["LP"] ?></a></th>
<?php
$user_defenceL_tot["LP"] = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$user_defence[$planete[$i]+9]["LP"] = 130 * $user_defence[$planete[$i]+9]["LP"];
	if ($user_defence[$planete[$i]+9]["LP"] < "1") $affich = "&nbsp;";
	else $affich = number_format($user_defence[$planete[$i]+9]["LP"], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$user_defenceL_tot["LP"] += $user_defence[$planete[$i]+9]["LP"];
}
if ($user_defenceL_tot["LP"] < "1") $affich = "&nbsp;";
else $affich = number_format($user_defenceL_tot["LP"], 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_defence["PB"] ?></a></th>
<?php
$user_defenceL_tot["PB"] = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$user_defence[$planete[$i]+9]["PB"] = 20 * $user_defence[$planete[$i]+9]["PB"];
	if ($user_defence[$planete[$i]+9]["PB"] < "1") $affich = "&nbsp;";
	else $affich = number_format($user_defence[$planete[$i]+9]["PB"], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$user_defenceL_tot["PB"] += $user_defence[$planete[$i]+9]["PB"];
}
if ($user_defenceL_tot["PB"] < "1") $affich = "&nbsp;";
else $affich = number_format($user_defenceL_tot["PB"], 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a><?php echo $lang_defence["GB"] ?></a></th>
<?php
$user_defenceL_tot["GB"] = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$user_defence[$planete[$i]+9]["GB"] = 100 * $user_defence[$planete[$i]+9]["GB"];
	if ($user_defence[$planete[$i]+9]["GB"] < "1") $affich = "&nbsp;";
	else $affich = number_format($user_defence[$planete[$i]+9]["GB"], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$user_defenceL_tot["GB"] += $user_defence[$planete[$i]+9]["GB"];
}
if ($user_defenceL_tot["GB"] < "1") $affich = "&nbsp;";
else $affich = number_format($user_defenceL_tot["GB"], 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a>Sous-total</a></th>
<?php
$total_defenceL_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$total_defence[$planete[$i]+9] = $user_defence[$planete[$i]+9]["LM"] + $user_defence[$planete[$i]+9]["LLE"] + $user_defence[$planete[$i]+9]["LLO"] + $user_defence[$planete[$i]+9]["CG"] + $user_defence[$planete[$i]+9]["AI"] + $user_defence[$planete[$i]+9]["LP"] + $user_defence[$planete[$i]+9]["PB"] + $user_defence[$planete[$i]+9]["GB"];
	if ($total_defence[$planete[$i]+9] < "1") $affich = "&nbsp;";
	else $affich = number_format($total_defence[$planete[$i]+9], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$total_defenceL_tot += $total_defence[$planete[$i]+9];
}
if ($total_defenceL_tot < "1") $affich = "&nbsp;";
else $affich = number_format($total_defenceL_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<?php endif; ?>
<tr>
	<td class="c" colspan="<?php echo $nbre_planete+2; ?>">Total</td>
</tr>
<tr>
	<th><a>Total</a></th>
<?php
$total_general_tot = 0;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$total_general[$planete[$i]] = $total_batiments[$planete[$i]] + $total_defence[$planete[$i]] + $total_batiments[$planete[$i]+9] + $total_defence[$planete[$i]+9];
	if ($total_general[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($total_general[$planete[$i]], 0, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$total_general_tot += $total_general[$planete[$i]];
}
if ($total_general_tot < "1") $affich = "&nbsp;";
else $affich = number_format($total_general_tot, 0, ',', $sep_mille);
echo "\t<th>".$affich."</th>\n";
?>
</tr>
<tr>
	<th><a>Pourcentage des points</a></th>
<?php
if (!isset($points)) $points = $total_general_tot;
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	$pourcentage[$planete[$i]] = 100 * $total_general[$planete[$i]] / $points;
	if ($pourcentage[$planete[$i]] < "0.1") $affich = "&nbsp;";
	else $affich = number_format($pourcentage[$planete[$i]], 1, ',', $sep_mille);
	echo "\t<th><font color='lime'>".$affich." %</font></th>\n";
}
$pourcentage_tot = 100 * $total_general_tot / $points;
if ($pourcentage_tot < "0.1") $affich = "&nbsp;";
else $affich = number_format($pourcentage_tot, 1, ',', $sep_mille);
echo "\t<th>".$affich." %</th>\n";
?>
</tr>
<tr>
	<td></td>
<?php
$graph_values = '';
$graph_legend = '';
for ($i=1 ; $i<=$nbre_planete ; $i++) {
	if ($graph_values != '') {
		$graph_values .= '_x_';
		$graph_legend .= '_x_';
	}
	$graph_values .= intval($total_general[$planete[$i]]);
	$graph_legend .= $name[$planete[$i]];
	$name[$planete[$i]] = $user_building[$planete[$i]]["planet_name"];
	if ($name[$planete[$i]] == "") $name[$planete[$i]] = "&nbsp;";
	echo "\t<td class='c' style='text-align:center'><a>".$name[$planete[$i]]."</a></td>\n";
}
?>
	<td class="c" style="text-align:center">Totaux</td>
</tr>
</table>
<br/>
<?php
if ($total_general_tot < $points) {
	$graph_values .= '_x_'.intval($points - $total_general_tot);
	$graph_legend .= '_x_Autre';
}
echo "<center><img src='pandore_graph.php?hauteur=300&largeur=500&values=".$graph_values."&legend=".$graph_legend."&title=Proportion%20en%20points%20des%20differentes%20planètes' title='Proportion en points des differentes planètes' alt='Pas de graphique disponible'></center>";

?>
<br/>
<br/>

<?php

 
 
 
 
 
 
 
 
 
 }
 
 
 
 
 
 
 
 
 
 
else if (isset($_GET['calc']))
    {
    	
 
$user_empire = user_get_empire();
$user_building = $user_empire["building"];
$user_technology = $user_empire["technology"];



?>
<script language="javascript" src="ogpt/js/formule.js"></script>


<script type="text/javascript">
var batimentsOGSpy = new Array();

<?php
$j=0;
for ($i=1;$i<=9;$i++)
{
	if ($user_building[$i]['planet_name'] != '')
	{
		echo "batimentsOGSpy[".$j."]= new Array('".
			$user_building[$i]['planet_name']."','".
			$user_building[$i]['M']."','".
			$user_building[$i]['C']."','".
			$user_building[$i]['D']."','".
			$user_building[$i]['CES']."','".
			$user_building[$i]['CEF']."','".
			$user_building[$i]['UdR']."','".
			$user_building[$i]['UdN']."','".
			$user_building[$i]['CSp']."','".
			$user_building[$i]['HM']."','".
			$user_building[$i]['HC']."','".
			$user_building[$i]['HD']."','".
			$user_building[$i]['Lab']."','".
			$user_building[$i]['Silo']."','".
			$user_building[$i]['Ter']."','".
			$user_building[$i]['BaLu']."','".
			$user_building[$i]['Pha']."','".
			$user_building[$i]['PoSa']."');\n";
		$j++;		
	}
}

echo "technologiesOGSpy = new Array('".
		$user_technology['Esp']."','".
		$user_technology['Ordi']."','".
		$user_technology['Armes']."','".
		$user_technology['Bouclier']."','".
		$user_technology['Protection']."','".
		$user_technology['NRJ']."','".
		$user_technology['Hyp']."','".
		$user_technology['RC']."','".
		$user_technology['RI']."','".
		$user_technology['PH']."','".
		$user_technology['Laser']."','".
		$user_technology['Ions']."','".
		$user_technology['Plasma']."','".
		$user_technology['RRI']."','".
		$user_technology['Expeditions']."','".
		$user_technology['Graviton']."');\n";
?>

function chargement ()
{

	var i = 0;
	while (	(i<batimentsOGSpy.length) && (batimentsOGSpy[i][0] != document.getElementById('planete').options[document.getElementById('planete').selectedIndex].text) )
	{
		i++;
	}
	
	resetData();
	
	if (!(i == batimentsOGSpy.length))
	{
		document.getElementById('robot').value = batimentsOGSpy[i][6];
		document.getElementById('chantier').value= batimentsOGSpy[i][8];
		document.getElementById('nanite').value = batimentsOGSpy[i][7];
		
		k=1;
		for ( j=0; j<batimentsOGSpy.length; j++ )
		{
			if (i==j)
			{
				document.getElementById('labopm').value = batimentsOGSpy[j][12];
			} else {
				document.getElementById('labo'+k).value = batimentsOGSpy[j][12];
				k++;
			}
		}
		document.getElementById('reseau').value = technologiesOGSpy[13];
		laboEqui();
		
		for ( j=0 ; j<arrayBatiments.length; j++ )
		{
			bat = arrayBatiments[j]+"_actuel";
			document.getElementById(bat).value=batimentsOGSpy[i][j+1];
		}
		for ( j=0 ; j<arrayTechnologies.length; j++ )
		{
			bat = arrayTechnologies[j]+"_actuel";
			document.getElementById(bat).value=technologiesOGSpy[j];
		}
		document.getElementById('graviton_actuel').value=technologiesOGSpy[14];
	}
}
</script>

<center>

<fieldset><legend><b>Gestion</b></legend>
<div><input type="submit" value="Sauvegarder les données" onClick="javascript:sauvegarde()"> <input type="submit" value="Restaurer les données" onClick="javascript:restaure()"> <input type="submit" value="Changelog" onClick="javascript:inverse('changelog')"> <select id="planete" onChange="javascript:chargement()"><option>Planètes OGSpy</option>
<?php
for ($i=1;$i<=9;$i++)
{
	if ( $user_building[$i]['planet_name'] != '' )
	{
		echo "<option>".$user_building[$i]['planet_name']."</option>";
	}
}
?>
</select> <input type="submit" value="Reset" onClick="javascript:resetData()"></div>
<div id="changelog" style="display:none; text-align:left;">
<center><font size="5">Changelog</font></center>
	<b>18/04/2008</v>
<ol style="list-style-type: none;">
	<li>v0.5
	<ul type="disc">
		<li>Ajout du calcul des transports</li>
		<li>Ajout du script de désintallation</li>
		<li>Controle de sécurité pour éviter l'erreur de "Duplicate Entry"</li>
	</ul>
</ol>	
	<b>18/04/2008</v>
<ol style="list-style-type: none;">
	<li>v0.4d
	<ul type="disc">
		<li>Fix d'un bug à l'installation</li>
	</ul>
</ol>	
	<b>16/04/2008</v>
<ol style="list-style-type: none;">
	<li>v0.4c
	<ul type="disc">
		<li>Ajout de la technologie expéditions</li>
		<li>Modification du fichier install</li>
		<li>Correction du chemin pour atteindre formule.js</li>
	</ul>
</ol>	
    <b>04/03/2007</b>
<ol style="list-style-type: none;">
	<li>v0.4
	<ul type="disc">
		<li>Ajout du traqueur</li>
		<li>Correction du bug d'affichage qui ne permmetait pas de voir les ressources</li>
		<li>Modification du prix du traqueur</li>
		<li>Installation des Install/Update qui récupére le n° de version dans le fichier version.txt</li>
	</ul>
</ol>
    <b>09/08/2006</b>
<ol style="list-style-type: none;">
	<li>v0.3
	<ul type="disc">
		<li>Correction du problème des prix du terraformeur (merci ben_12)</li>
		<li>Correction du non-rafraichissement des temps si modifications du niveau de l'usine de robots et de nanites ou du chantier spatial</li>
	</ul>
</ol>
    <b>09/07/2006</b>
<ol style="list-style-type: none;">
	<li>v0.2
	<ul type="disc">
		<li>Correction d'un bug empêchant le calcul des technologies</li>
		<li>Correction d'un problème de calcul de l'énergie nécessaire au graviton (merci Corwin)</li>
		<li>Ajout de la fonction reset</li>
	</ul>
</ol>
    <b>08/07/2006</b>
<ol style="list-style-type: none;">
	<li>v0.1
	<ul type="disc">
		<li>Sortie d'OGSCalc en mod OGSpy</li>
	</ul>
</ol>
</div>
</fieldset>
<br>
<br>
<fieldset><legend><b>Vos technologies</b></legend>
<table>
<tr><td>
	<table>
	<tr>
	<td class="c" style="text-align:center">Usine de robot:</td><th><input type="text" id="robot" size="2" maxlength="2" value="0" onBlur="javascript:rafraichiRobot()"></th>
	</tr><tr>
	<td class="c" style="text-align:center">Chantier spatial:</td><th><input type="text" id="chantier" size="2" maxlength="2" value="0" onBlur="javascript:rafraichiChantier()"></th>
	</tr><tr>
	<td class="c" style="text-align:center">Usine de nanites:</td><th><input type="text" id="nanite" size="2" maxlength="2" value="0" onBlur="javascript:rafraichiRobot();rafraichiChantier()"></th>
	</tr>
	</table>
</td><td>
	<table>
	<tr><td class="c" style="text-align:center">
	Planète de développement:</td><th><input type="text" id="labopm" size="2" maxlength="2" value="0" onBlur="javascript:laboEqui()"></th>
	<td class="c" style="text-align:center" colspan="6">Laboratoires de recherche</td></tr>
	<tr><td class="c" style="text-align:center">
	Planète 1:</td><th><input type="text" id="labo1" size="2" maxlength="2" value="0" onBlur="javascript:laboEqui()">
	</th><td class="c" style="text-align:center">
	Planète 2:</td><th><input type="text" id="labo2" size="2" maxlength="2" value="0" onBlur="javascript:laboEqui()">
	</th><td class="c" style="text-align:center">
	Planète 3:</td><th><input type="text" id="labo3" size="2" maxlength="2" value="0" onBlur="javascript:laboEqui()">
	</th><td class="c" style="text-align:center">
	Planète 4:</td><th><input type="text" id="labo4" size="2" maxlength="2" value="0" onBlur="javascript:laboEqui()">
	</th></tr>
	<tr><td class="c" style="text-align:center">
	Planète 5:</td><th><input type="text" id="labo5" size="2" maxlength="2" value="0" onBlur="javascript:laboEqui()">
	</th><td class="c" style="text-align:center">
	Planète 6:</td><th><input type="text" id="labo6" size="2" maxlength="2" value="0" onBlur="javascript:laboEqui()">
	</th><td class="c" style="text-align:center">
	Planète 7:</td><th><input type="text" id="labo7" size="2" maxlength="2" value="0" onBlur="javascript:laboEqui()">
	</th><td class="c" style="text-align:center">
	Planète 8:</td><th><input type="text" id="labo8" size="2" maxlength="2" value="0" onBlur="javascript:laboEqui()">
	</th></tr>
	</table>
</td></tr><tr><td colspan="2" align="center">
	Réseau de recherche intergalactique: <input type="text" id="reseau" size="2" maxlength="2" value="0" onBlur="javascript:laboEqui()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Laboratoire équivalent: <input type="text" id="laboequi" size="2" maxlength="2" readonly value="0">
</td></tr></table>
</fieldset>
<br>
<br>
<fieldset><legend><b>Bâtiments</b></legend>
<table>
<tr><td class="c" style="text-align:center">
Nom</td><td class="c" style="text-align:center">
Niveau actuel</td><td class="c" style="text-align:center">
Niveau voulu</td><td class="c" style="text-align:center">
Métal requis</td><td class="c" style="text-align:center">
Cristal requis</td><td class="c" style="text-align:center">
Deutérium requis</td><td class="c" style="text-align:center">
Durée de construction</td>
</tr>
<tr><th>
Mine de métal</th><th>
<input type="text" id="mine_metal_actuel" size="2" maxlength="2" onBlur="javascript:batiment('mine_metal',60,15,0,1.5);" value="0"></th><th>
<input type="text" id="mine_metal_voulu" size="2" maxlength="2" onBlur="javascript:batiment('mine_metal',60,15,0,1.5)" value="0"></th><th>
<input type="text" id="mine_metal_metal" size="15" readonly value="0"></th><th>
<input type="text" id="mine_metal_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="mine_metal_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="mine_metal_temps" size="15" readonly value="-">
<input type="hidden" id="mine_metal_sec" size="15" value="0"></th>
</tr><tr><th>
Mine de cristal</th><th>
<input type="text" id="mine_cristal_actuel" size="2" maxlength="2" onBlur="javascript:batiment('mine_cristal',48,24,0,1.6)" value="0"></th><th>
<input type="text" id="mine_cristal_voulu" size="2" maxlength="2" onBlur="javascript:batiment('mine_cristal',48,24,0,1.6)" value="0"></th><th>
<input type="text" id="mine_cristal_metal" size="15" readonly value="0"></th><th>
<input type="text" id="mine_cristal_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="mine_cristal_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="mine_cristal_temps" size="15" readonly value="-">
<input type="hidden" id="mine_cristal_sec" size="15" value="0"></th>
</tr><tr><th>
Synthétiseur de deutérium</th><th>
<input type="text" id="synthetiseur_deuterium_actuel" size="2" maxlength="2" onBlur="javascript:batiment('synthetiseur_deuterium',225,75,0,1.5)" value="0"></th><th>
<input type="text" id="synthetiseur_deuterium_voulu" size="2" maxlength="2" onBlur="javascript:batiment('synthetiseur_deuterium',225,75,0,1.5)" value="0"></th><th>
<input type="text" id="synthetiseur_deuterium_metal" size="15" readonly value="0"></th><th>
<input type="text" id="synthetiseur_deuterium_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="synthetiseur_deuterium_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="synthetiseur_deuterium_temps" size="15" readonly value="-">
<input type="hidden" id="synthetiseur_deuterium_sec" size="15" value="0"></th>
</tr><tr><th>
Centrale solaire</th><th>
<input type="text" id="centrale_solaire_actuel" size="2" maxlength="2" onBlur="javascript:batiment('centrale_solaire',75,30,0,1.5)" value="0"></th><th>
<input type="text" id="centrale_solaire_voulu" size="2" maxlength="2" onBlur="javascript:batiment('centrale_solaire',75,30,0,1.5)" value="0"></th><th>
<input type="text" id="centrale_solaire_metal" size="15" readonly value="0"></th><th>
<input type="text" id="centrale_solaire_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="centrale_solaire_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="centrale_solaire_temps" size="15" readonly value="-">
<input type="hidden" id="centrale_solaire_sec" size="15" value="0"></th>
</tr><tr><th>
Réacteur à fusion</th><th>
<input type="text" id="reacteur_fusion_actuel" size="2" maxlength="2" onBlur="javascript:batiment('reacteur_fusion',900,360,180,1.8)" value="0"></th><th>
<input type="text" id="reacteur_fusion_voulu" size="2" maxlength="2" onBlur="javascript:batiment('reacteur_fusion',900,360,180,1.8)" value="0"></th><th>
<input type="text" id="reacteur_fusion_metal" size="15" readonly value="0"></th><th>
<input type="text" id="reacteur_fusion_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="reacteur_fusion_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="reacteur_fusion_temps" size="15" readonly value="-">
<input type="hidden" id="reacteur_fusion_sec" size="15" value="0"></th>
</tr><tr><th>
Usine de robots</th><th>
<input type="text" id="usine_robots_actuel" size="2" maxlength="2" onBlur="javascript:batiment('usine_robots',400,120,200,2)" value="0"></th><th>
<input type="text" id="usine_robots_voulu" size="2" maxlength="2" onBlur="javascript:batiment('usine_robots',400,120,200,2)" value="0"></th><th>
<input type="text" id="usine_robots_metal" size="15" readonly value="0"></th><th>
<input type="text" id="usine_robots_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="usine_robots_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="usine_robots_temps" size="15" readonly value="-">
<input type="hidden" id="usine_robots_sec" size="15" value="0"></th>
</tr><tr><th>
Usine de nanites</th><th>
<input type="text" id="usine_nanites_actuel" size="2" maxlength="2" onBlur="javascript:batiment('usine_nanites',1000000,500000,100000,2)" value="0"></th><th>
<input type="text" id="usine_nanites_voulu" size="2" maxlength="2" onBlur="javascript:batiment('usine_nanites',1000000,500000,100000,2)" value="0"></th><th>
<input type="text" id="usine_nanites_metal" size="15" readonly value="0"></th><th>
<input type="text" id="usine_nanites_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="usine_nanites_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="usine_nanites_temps" size="15" readonly value="-">
<input type="hidden" id="usine_nanites_sec" size="15" value="0"></th>
</tr><tr><th>
Chantier spatial</th><th>
<input type="text" id="chantier_spatial_actuel" size="2" maxlength="2" onBlur="javascript:batiment('chantier_spatial',400,200,100,2)" value="0"></th><th>
<input type="text" id="chantier_spatial_voulu" size="2" maxlength="2" onBlur="javascript:batiment('chantier_spatial',400,200,100,2)" value="0"></th><th>
<input type="text" id="chantier_spatial_metal" size="15" readonly value="0"></th><th>
<input type="text" id="chantier_spatial_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="chantier_spatial_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="chantier_spatial_temps" size="15" readonly value="-">
<input type="hidden" id="chantier_spatial_sec" size="15" value="0"></th>
</tr><tr><th>
Hangar de metal</th><th>
<input type="text" id="hangar_metal_actuel" size="2" maxlength="2" onBlur="javascript:batiment('hangar_metal',2000,0,0,2)" value="0"></th><th>
<input type="text" id="hangar_metal_voulu" size="2" maxlength="2" onBlur="javascript:batiment('hangar_metal',2000,0,0,2)" value="0"></th><th>
<input type="text" id="hangar_metal_metal" size="15" readonly value="0"></th><th>
<input type="text" id="hangar_metal_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="hangar_metal_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="hangar_metal_temps" size="15" readonly value="-">
<input type="hidden" id="hangar_metal_sec" size="15" value="0"></th>
</tr><tr><th>
Hangar de cristal</th><th>
<input type="text" id="hangar_cristal_actuel" size="2" maxlength="2" onBlur="javascript:batiment('hangar_cristal',2000,1000,0,2)" value="0"></th><th>
<input type="text" id="hangar_cristal_voulu" size="2" maxlength="2" onBlur="javascript:batiment('hangar_cristal',2000,1000,0,2)" value="0"></th><th>
<input type="text" id="hangar_cristal_metal" size="15" readonly value="0"></th><th>
<input type="text" id="hangar_cristal_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="hangar_cristal_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="hangar_cristal_temps" size="15" readonly value="-">
<input type="hidden" id="hangar_cristal_sec" size="15" value="0"></th>
</tr><tr><th>
Réservoir de deutérium</th><th>
<input type="text" id="reservoir_deuterium_actuel" size="2" maxlength="2" onBlur="javascript:batiment('reservoir_deuterium',2000,2000,0,2)" value="0"></th><th>
<input type="text" id="reservoir_deuterium_voulu" size="2" maxlength="2" onBlur="javascript:batiment('reservoir_deuterium',2000,2000,0,2)" value="0"></th><th>
<input type="text" id="reservoir_deuterium_metal" size="15" readonly value="0"></th><th>
<input type="text" id="reservoir_deuterium_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="reservoir_deuterium_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="reservoir_deuterium_temps" size="15" readonly value="-">
<input type="hidden" id="reservoir_deuterium_sec" size="15" value="0"></th>
</tr><tr><th>
Laboratoire</th><th>
<input type="text" id="laboratoire_actuel" size="2" maxlength="2" onBlur="javascript:batiment('laboratoire',200,400,200,2)" value="0"></th><th>
<input type="text" id="laboratoire_voulu" size="2" maxlength="2" onBlur="javascript:batiment('laboratoire',200,400,200,2)" value="0"></th><th>
<input type="text" id="laboratoire_metal" size="15" readonly value="0"></th><th>
<input type="text" id="laboratoire_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="laboratoire_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="laboratoire_temps" size="15" readonly value="-">
<input type="hidden" id="laboratoire_sec" size="15" value="0"></th>
</tr><tr><th>
Silo à missiles</th><th>
<input type="text" id="silo_missiles_actuel" size="2" maxlength="2" onBlur="javascript:batiment('silo_missiles',20000,20000,1000,2)" value="0"></th><th>
<input type="text" id="silo_missiles_voulu" size="2" maxlength="2" onBlur="javascript:batiment('silo_missiles',20000,20000,1000,2)" value="0"></th><th>
<input type="text" id="silo_missiles_metal" size="15" readonly value="0"></th><th>
<input type="text" id="silo_missiles_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="silo_missiles_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="silo_missiles_temps" size="15" readonly value="-">
<input type="hidden" id="silo_missiles_sec" size="15" value="0"></th>
</tr><tr><th>
Terraformeur</th><th>
<input type="text" id="terraformeur_actuel" size="2" maxlength="2" onBlur="javascript:batiment('terraformeur',1000,50000,100000,2)" value="0"></th><th>
<input type="text" id="terraformeur_voulu" size="2" maxlength="2" onBlur="javascript:batiment('terraformeur',1000,50000,100000,2)" value="0"></th><th>
<input type="text" id="terraformeur_metal" size="15" readonly value="0"></th><th>
<input type="text" id="terraformeur_cristal" size="15" readonly value="0"></th><th>
énergie:<input type="text" id="terraformeur_deuterium" size="15" readonly value="0"></td><th>
<input type="text" id="terraformeur_temps" size="15" readonly value="-">
<input type="hidden" id="terraformeur_sec" size="15" value="0"></th>
</tr><tr><td class="c" style="text-align:center" colspan="3">
TOTAL</td><th>
<input type="text" id="batiments_metal" size="15" readonly value="0"></th><th>
<input type="text" id="batiments_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="batiments_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="batiments_temps" size="15" readonly value="-">
<input type="hidden" id="batiments_sec" size="15" value="0"></th>
</tr><tr><td colspan="7" class="c">
Un total de <span id="batiments_ressources" style="color:#FF0080;font-weight:bold;">
0</span> ressources, soit <span id="batiments_pt" style="color:#0080FF;font-weight:bold;">
0</span> PT ou <span id="batiments_gt" style="color:#80FF00;font-weight:bold;">
0</span> GT
</td></tr></table>
</fieldset><br>
<fieldset><legend><b>Bâtiments spéciaux</b></legend>
<table>
<tr><td class="c" style="text-align:center">
Nom</td><td class="c" style="text-align:center">
Niveau actuel</td><td class="c" style="text-align:center">
Niveau voulu</td><td class="c" style="text-align:center">
Métal requis</td><td class="c" style="text-align:center">
Cristal requis</td><td class="c" style="text-align:center">
Deutérium requis</td><td class="c" style="text-align:center">
Durée de construction</td>
</tr><tr><th>
Base lunaire</th><th>
<input type="text" id="base_lunaire_actuel" size="2" maxlength="2" onBlur="javascript:batimentSpeciaux('base_lunaire',20000,40000,20000,2)" value="0"></th><th>
<input type="text" id="base_lunaire_voulu" size="2" maxlength="2" onBlur="javascript:batimentSpeciaux('base_lunaire',20000,40000,20000,2)" value="0"></th><th>
<input type="text" id="base_lunaire_metal" size="15" readonly value="0"></th><th>
<input type="text" id="base_lunaire_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="base_lunaire_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="base_lunaire_temps" size="15" readonly value="-">
<input type="hidden" id="base_lunaire_sec" size="15" value="0"></th>
</tr><tr><th>
Phalange de capteurs</th><th>
<input type="text" id="phalange_capteurs_actuel" size="2" maxlength="2" onBlur="javascript:batimentSpeciaux('phalange_capteurs',20000,40000,20000,2)" value="0"></th><th>
<input type="text" id="phalange_capteurs_voulu" size="2" maxlength="2" onBlur="javascript:batimentSpeciaux('phalange_capteurs',20000,40000,20000,2)" value="0"></th><th>
<input type="text" id="phalange_capteurs_metal" size="15" readonly value="0"></th><th>
<input type="text" id="phalange_capteurs_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="phalange_capteurs_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="phalange_capteurs_temps" size="15" readonly value="-">
<input type="hidden" id="phalange_capteurs_sec" size="15" value="0"></th>
</tr><tr><th>
Porte de saut spatial</th><th>
<input type="text" id="porte_saut_spatial_actuel" size="2" maxlength="2" onBlur="javascript:batimentSpeciaux('porte_saut_spatial',2000000,4000000,2000000,2)" value="0"></th><th>
<input type="text" id="porte_saut_spatial_voulu" size="2" maxlength="2" onBlur="javascript:batimentSpeciaux('porte_saut_spatial',2000000,4000000,2000000,2)" value="0"></th><th>
<input type="text" id="porte_saut_spatial_metal" size="15" readonly value="0"></th><th>
<input type="text" id="porte_saut_spatial_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="porte_saut_spatial_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="porte_saut_spatial_temps" size="15" readonly value="-">
<input type="hidden" id="porte_saut_spatial_sec" size="15" value="0"></th>
</tr><tr><th>
Dépôt de ravitaillement</th><th>
<input type="text" id="depot_ravitaillement_actuel" size="2" maxlength="2" onBlur="javascript:batimentSpeciaux('depot_ravitaillement',20000,40000,0,2)" value="0"></th><th>
<input type="text" id="depot_ravitaillement_voulu" size="2" maxlength="2" onBlur="javascript:batimentSpeciaux('depot_ravitaillement',20000,40000,0,2)" value="0"></th><th>
<input type="text" id="depot_ravitaillement_metal" size="15" readonly value="0"></th><th>
<input type="text" id="depot_ravitaillement_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="depot_ravitaillement_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="depot_ravitaillement_temps" size="15" readonly value="-">
<input type="hidden" id="depot_ravitaillement_sec" size="15" value="0"></th>
</tr><tr><td class="c" style="text-align:center" colspan="3">
TOTAL</td><th>
<input type="text" id="batiments_speciaux_metal" size="15" readonly value="0"></th><th>
<input type="text" id="batiments_speciaux_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="batiments_speciaux_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="batiments_speciaux_temps" size="15" readonly value="-">
<input type="hidden" id="batiments_speciaux_sec" size="15" value="0"></th>
</tr><tr><td colspan="7" class="c">
Un total de <span id="batiments_speciaux_ressources" style="color:#FF0080;font-weight:bold;">
0</span> ressources, soit <span id="batiments_speciaux_pt" style="color:#0080FF;font-weight:bold;">
0</span> PT ou <span id="batiments_speciaux_gt" style="color:#80FF00;font-weight:bold;">
0</span> GT
</td></tr></table>
</fieldset><br>
<fieldset><legend><b>Technologies</b></legend>
<table>
<tr><td class="c" style="text-align:center">
Nom</td><td class="c" style="text-align:center">
Niveau actuel</td><td class="c" style="text-align:center">
Niveau voulu</td><td class="c" style="text-align:center">
Métal requis</td><td class="c" style="text-align:center">
Cristal requis</td><td class="c" style="text-align:center">
Deutérium requis</td><td class="c" style="text-align:center">
Durée de construction</td>
</tr>
<tr><th>
Espionnage</th><th>
<input type="text" id="espionnage_actuel" size="2" maxlength="2" onBlur="javascript:technologie('espionnage',200,1000,200,2)" value="0"></th><th>
<input type="text" id="espionnage_voulu" size="2" maxlength="2" onBlur="javascript:technologie('espionnage',200,1000,200,2)" value="0"></th><th>
<input type="text" id="espionnage_metal" size="15" readonly value="0"></th><th>
<input type="text" id="espionnage_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="espionnage_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="espionnage_temps" size="15" readonly value="-">
<input type="hidden" id="espionnage_sec" size="15" value="0"></th>
</tr><tr><th>
Ordinateur</th><th>
<input type="text" id="ordinateur_actuel" size="2" maxlength="2" onBlur="javascript:technologie('ordinateur',0,400,600,2)" value="0"></th><th>
<input type="text" id="ordinateur_voulu" size="2" maxlength="2" onBlur="javascript:technologie('ordinateur',0,400,600,2)" value="0"></th><th>
<input type="text" id="ordinateur_metal" size="15" readonly value="0"></th><th>
<input type="text" id="ordinateur_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="ordinateur_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="ordinateur_temps" size="15" readonly value="-">
<input type="hidden" id="ordinateur_sec" size="15" value="0"></th>
</tr><tr><th>
Armes</th><th>
<input type="text" id="armes_actuel" size="2" maxlength="2" onBlur="javascript:technologie('armes',800,200,0,2)" value="0"></th><th>
<input type="text" id="armes_voulu" size="2" maxlength="2" onBlur="javascript:technologie('armes',800,200,0,2)" value="0"></th><th>
<input type="text" id="armes_metal" size="15" readonly value="0"></th><th>
<input type="text" id="armes_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="armes_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="armes_temps" size="15" readonly value="-">
<input type="hidden" id="armes_sec" size="15" value="0"></th>
</tr><tr><th>
Bouclier</th><th>
<input type="text" id="bouclier_actuel" size="2" maxlength="2" onBlur="javascript:technologie('bouclier',200,600,0,2)" value="0"></th><th>
<input type="text" id="bouclier_voulu" size="2" maxlength="2" onBlur="javascript:technologie('bouclier',200,600,0,2)" value="0"></th><th>
<input type="text" id="bouclier_metal" size="15" readonly value="0"></th><th>
<input type="text" id="bouclier_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="bouclier_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="bouclier_temps" size="15" readonly value="-">
<input type="hidden" id="bouclier_sec" size="15" value="0"></th>
</tr><tr><th>
Protection des vaisseaux</th><th>
<input type="text" id="protection_vaisseaux_actuel" size="2" maxlength="2" onBlur="javascript:technologie('protection_vaisseaux',1000,0,0,2)" value="0"></th><th>
<input type="text" id="protection_vaisseaux_voulu" size="2" maxlength="2" onBlur="javascript:technologie('protection_vaisseaux',1000,0,0,2)" value="0"></th><th>
<input type="text" id="protection_vaisseaux_metal" size="15" readonly value="0"></th><th>
<input type="text" id="protection_vaisseaux_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="protection_vaisseaux_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="protection_vaisseaux_temps" size="15" readonly value="-">
<input type="hidden" id="protection_vaisseaux_sec" size="15" value="0"></th>
</tr><tr><th>
Energie</th><th>
<input type="text" id="energie_actuel" size="2" maxlength="2" onBlur="javascript:technologie('energie',0,800,400,2)" value="0"></th><th>
<input type="text" id="energie_voulu" size="2" maxlength="2" onBlur="javascript:technologie('energie',0,800,400,2)" value="0"></th><th>
<input type="text" id="energie_metal" size="15" readonly value="0"></th><th>
<input type="text" id="energie_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="energie_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="energie_temps" size="15" readonly value="-">
<input type="hidden" id="energie_sec" size="15" value="0"></th>
</tr><tr><th>
Hyperespace</th><th>
<input type="text" id="hyperespace_actuel" size="2" maxlength="2" onBlur="javascript:technologie('hyperespace',0,4000,2000,2)" value="0"></th><th>
<input type="text" id="hyperespace_voulu" size="2" maxlength="2" onBlur="javascript:technologie('hyperespace',0,4000,2000,2)" value="0"></th><th>
<input type="text" id="hyperespace_metal" size="15" readonly value="0"></th><th>
<input type="text" id="hyperespace_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="hyperespace_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="hyperespace_temps" size="15" readonly value="-">
<input type="hidden" id="hyperespace_sec" size="15" value="0"></th>
</tr><tr><th>
Réacteur à combustion</th><th>
<input type="text" id="reacteur_combustion_actuel" size="2" maxlength="2" onBlur="javascript:technologie('reacteur_combustion',400,0,600,2)" value="0"></th><th>
<input type="text" id="reacteur_combustion_voulu" size="2" maxlength="2" onBlur="javascript:technologie('reacteur_combustion',400,0,600,2)" value="0"></th><th>
<input type="text" id="reacteur_combustion_metal" size="15" readonly value="0"></th><th>
<input type="text" id="reacteur_combustion_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="reacteur_combustion_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="reacteur_combustion_temps" size="15" readonly value="-">
<input type="hidden" id="reacteur_combustion_sec" size="15" value="0"></th>
</tr><tr><th>
Réacteur à impulsion</th><th>
<input type="text" id="reacteur_impulsion_actuel" size="2" maxlength="2" onBlur="javascript:technologie('reacteur_impulsion',2000,4000,600,2)" value="0"></th><th>
<input type="text" id="reacteur_impulsion_voulu" size="2" maxlength="2" onBlur="javascript:technologie('reacteur_impulsion',2000,4000,600,2)" value="0"></th><th>
<input type="text" id="reacteur_impulsion_metal" size="15" readonly value="0"></th><th>
<input type="text" id="reacteur_impulsion_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="reacteur_impulsion_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="reacteur_impulsion_temps" size="15" readonly value="-">
<input type="hidden" id="reacteur_impulsion_sec" size="15" value="0"></th>
</tr><tr><th>
Propulsion hyperespace</th><th>
<input type="text" id="propulsion_hyperespace_actuel" size="2" maxlength="2" onBlur="javascript:technologie('propulsion_hyperespace',10000,20000,6000,2)" value="0"></th><th>
<input type="text" id="propulsion_hyperespace_voulu" size="2" maxlength="2" onBlur="javascript:technologie('propulsion_hyperespace',10000,20000,6000,2)" value="0"></th><th>
<input type="text" id="propulsion_hyperespace_metal" size="15" readonly value="0"></th><th>
<input type="text" id="propulsion_hyperespace_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="propulsion_hyperespace_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="propulsion_hyperespace_temps" size="15" readonly value="-">
<input type="hidden" id="propulsion_hyperespace_sec" size="15" value="0"></th>
</tr><tr><th>
Laser</th><th>
<input type="text" id="laser_actuel" size="2" maxlength="2" onBlur="javascript:technologie('laser',200,100,0,2)" value="0"></th><th>
<input type="text" id="laser_voulu" size="2" maxlength="2" onBlur="javascript:technologie('laser',200,100,0,2)" value="0"></th><th>
<input type="text" id="laser_metal" size="15" readonly value="0"></th><th>
<input type="text" id="laser_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="laser_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="laser_temps" size="15" readonly value="-">
<input type="hidden" id="laser_sec" size="15" value="0"></th>
</tr><tr><th>
Ion</th><th>
<input type="text" id="ion_actuel" size="2" maxlength="2" onBlur="javascript:technologie('ion',1000,300,100,2)" value="0"></th><th>
<input type="text" id="ion_voulu" size="2" maxlength="2" onBlur="javascript:technologie('ion',1000,300,100,2)" value="0"></th><th>
<input type="text" id="ion_metal" size="15" readonly value="0"></th><th>
<input type="text" id="ion_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="ion_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="ion_temps" size="15" readonly value="-">
<input type="hidden" id="ion_sec" size="15" value="0"></th>
</tr><tr><th>
Plasma</th><th>
<input type="text" id="plasma_actuel" size="2" maxlength="2" onBlur="javascript:technologie('plasma',2000,4000,1000,2)" value="0"></th><th>
<input type="text" id="plasma_voulu" size="2" maxlength="2" onBlur="javascript:technologie('plasma',2000,4000,1000,2)" value="0"></th><th>
<input type="text" id="plasma_metal" size="15" readonly value="0"></th><th>
<input type="text" id="plasma_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="plasma_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="plasma_temps" size="15" readonly value="-">
<input type="hidden" id="plasma_sec" size="15" value="0"></th>
</tr><tr><th>
Réseau de recherche</th><th>
<input type="text" id="reseau_recherche_actuel" size="2" maxlength="2" onBlur="javascript:technologie('reseau_recherche',240000,400000,160000,2)" value="0"></th><th>
<input type="text" id="reseau_recherche_voulu" size="2" maxlength="2" onBlur="javascript:technologie('reseau_recherche',240000,400000,160000,2)" value="0"></th><th>
<input type="text" id="reseau_recherche_metal" size="15" readonly value="0"></th><th>
<input type="text" id="reseau_recherche_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="reseau_recherche_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="reseau_recherche_temps" size="15" readonly value="-">
<input type="hidden" id="reseau_recherche_sec" size="15" value="0"></th>
</tr><tr><th>
Expéditions</th><th>
<input type="text" id="expeditions_actuel" size="2" maxlength="2" onBlur="javascript:technologie('expeditions',4000,8000,4000,2)" value="0"></th><th>
<input type="text" id="expeditions_voulu" size="2" maxlength="2" onBlur="javascript:technologie('expeditions',4000,8000,4000,2)" value="0"></th><th>
<input type="text" id="expeditions_metal" size="15" readonly value="0"></th><th>
<input type="text" id="expeditions_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="expeditions_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="expeditions_temps" size="15" readonly value="-">
<input type="hidden" id="expeditions_sec" size="15" value="0"></th>
</tr><tr><th>
Graviton</th><th>
<input type="text" id="graviton_actuel" size="2" maxlength="2" onBlur="javascript:graviton()" value="0"></th><th>
<input type="text" id="graviton_voulu" size="2" maxlength="2" onBlur="javascript:graviton()" value="0"></th><th colspan="3">
énergie: <input type="text" id="graviton" size="15" readonly value="0"></td><th>
instantané</th>
</tr><tr><td class="c" style="text-align:center" colspan="3">
TOTAL</td><th>
<input type="text" id="technologies_metal" size="15" readonly value="0"></th><th>
<input type="text" id="technologies_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="technologies_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="technologies_temps" size="15" readonly value="-">
<input type="hidden" id="technologies_sec" size="15" value="0"></th>
</tr><tr><td colspan="7" class="c">
Un total de <span id="technologies_ressources" style="color:#FF0080;font-weight:bold;">
0</span> ressources, soit <span id="technologies_pt" style="color:#0080FF;font-weight:bold;">
0</span> PT ou <span id="technologies_gt" style="color:#80FF00;font-weight:bold;">
0</span> GT
</td></tr></table>
</fieldset><br>
<fieldset><legend><b>Vaisseaux</b></legend>
<table>
<tr><td class="c" style="text-align:center">
Nom</td><td class="c" style="text-align:center">
Quantité voulue</td><td class="c" style="text-align:center">
Métal requis</td><td class="c" style="text-align:center">
Cristal requis</td><td class="c" style="text-align:center">
Deutérium requis</td><td class="c" style="text-align:center">
Durée de construction</td>
</tr>
<tr><th>
Petit transporteur</th><th>
<input type="text" id="pt_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('pt',2000,2000,0)" value="0"></th><th>
<input type="text" id="pt_metal" size="15" readonly value="0"></th><th>
<input type="text" id="pt_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="pt_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="pt_temps" size="15" readonly value="-">
<input type="hidden" id="pt_sec" size="15" value="0"></th>
</tr><tr><th>
Grand transporteur</th><th>
<input type="text" id="gt_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('gt',6000,6000,0)" value="0"></th><th>
<input type="text" id="gt_metal" size="15" readonly value="0"></th><th>
<input type="text" id="gt_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="gt_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="gt_temps" size="15" readonly value="-">
<input type="hidden" id="gt_sec" size="15" value="0"></th>
</tr><tr><th>
Chasseur léger</th><th>
<input type="text" id="cle_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('cle',3000,1000,0)" value="0"></th><th>
<input type="text" id="cle_metal" size="15" readonly value="0"></th><th>
<input type="text" id="cle_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="cle_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="cle_temps" size="15" readonly value="-">
<input type="hidden" id="cle_sec" size="15" value="0"></th>
</tr><tr><th>
Chasseur lourd</th><th>
<input type="text" id="clo_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('clo',6000,4000,0)" value="0"></th><th>
<input type="text" id="clo_metal" size="15" readonly value="0"></th><th>
<input type="text" id="clo_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="clo_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="clo_temps" size="15" readonly value="-">
<input type="hidden" id="clo_sec" size="15" value="0"></th>
</tr><tr><th>
Croiseur</th><th>
<input type="text" id="cr_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('cr',20000,7000,2000)" value="0"></th><th>
<input type="text" id="cr_metal" size="15" readonly value="0"></th><th>
<input type="text" id="cr_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="cr_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="cr_temps" size="15" readonly value="-">
<input type="hidden" id="cr_sec" size="15" value="0"></th>
</tr><tr><th>
Vaisseau de bataille</th><th>
<input type="text" id="vb_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('vb',45000,15000,0)" value="0"></th><th>
<input type="text" id="vb_metal" size="15" readonly value="0"></th><th>
<input type="text" id="vb_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="vb_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="vb_temps" size="15" readonly value="-">
<input type="hidden" id="vb_sec" size="15" value="0"></th>
</tr><tr><th>
Traqueur</th><th>
<input type="text" id="traq_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('traq',30000,40000,15000)" value="0"></th><th>
<input type="text" id="traq_metal" size="15" readonly value="0"></th><th>
<input type="text" id="traq_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="traq_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="traq_temps" size="15" readonly value="-">
<input type="hidden" id="traq_sec" size="15" value="0"></th>
</tr><tr><th>
Bombardier</th><th>
<input type="text" id="bb_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('bb',50000,25000,15000)" value="0"></th><th>
<input type="text" id="bb_metal" size="15" readonly value="0"></th><th>
<input type="text" id="bb_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="bb_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="bb_temps" size="15" readonly value="-">
<input type="hidden" id="bb_sec" size="15" value="0"></th>
</tr><tr><th>
Destructeur</th><th>
<input type="text" id="dest_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('dest',60000,50000,15000)" value="0"></th><th>
<input type="text" id="dest_metal" size="15" readonly value="0"></th><th>
<input type="text" id="dest_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="dest_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="dest_temps" size="15" readonly value="-">
<input type="hidden" id="dest_sec" size="15" value="0"></th>
</tr><tr><th>
Etoile de la Mort</th><th>
<input type="text" id="edlm_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('edlm',5000000,4000000,1000000)" value="0"></th><th>
<input type="text" id="edlm_metal" size="15" readonly value="0"></th><th>
<input type="text" id="edlm_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="edlm_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="edlm_temps" size="15" readonly value="-">
<input type="hidden" id="edlm_sec" size="15" value="0"></th>
</tr><tr><th>
Recycleur</th><th>
<input type="text" id="recycleur_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('recycleur',10000,6000,2000)" value="0"></th><th>
<input type="text" id="recycleur_metal" size="15" readonly value="0"></th><th>
<input type="text" id="recycleur_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="recycleur_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="recycleur_temps" size="15" readonly value="-">
<input type="hidden" id="recycleur_sec" size="15" value="0"></th></tr><tr><th>
Vaisseau de colonisation</th><th>
<input type="text" id="vc_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('vc',10000,20000,10000)" value="0"></th><th>
<input type="text" id="vc_metal" size="15" readonly value="0"></th><th>
<input type="text" id="vc_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="vc_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="vc_temps" size="15" readonly value="-">
<input type="hidden" id="vc_sec" size="15" value="0"></th>
</tr><tr><th>
Sonde d'espionnage</th><th>
<input type="text" id="sonde_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('sonde',0,1000,0)" value="0"></th><th>
<input type="text" id="sonde_metal" size="15" readonly value="0"></th><th>
<input type="text" id="sonde_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="sonde_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="sonde_temps" size="15" readonly value="-">
<input type="hidden" id="sonde_sec" size="15" value="0"></th>
</tr><tr><th>
Satellite solaire</th><th>
<input type="text" id="satellite_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('satellite',0,2000,500)" value="0"></th><th>
<input type="text" id="satellite_metal" size="15" readonly value="0"></th><th>
<input type="text" id="satellite_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="satellite_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="satellite_temps" size="15" readonly value="-">
<input type="hidden" id="satellite_sec" size="15" value="0"></th>
</tr><tr><td class="c" style="text-align:center" colspan="2">
TOTAL</td><th>
<input type="text" id="vaisseaux_metal" size="15" readonly value="0"></th><th>
<input type="text" id="vaisseaux_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="vaisseaux_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="vaisseaux_temps" size="15" readonly value="-">
<input type="hidden" id="vaisseaux_sec" size="15" value="0"></th>
</tr><tr><td colspan="7" class="c">
Un total de <span id="vaisseaux_ressources" style="color:#FF0080;font-weight:bold;">
0</span> ressources, soit <span id="vaisseaux_pt" style="color:#0080FF;font-weight:bold;">
0</span> PT ou <span id="vaisseaux_gt" style="color:#80FF00;font-weight:bold;">
0</span> GT
</td></tr></table>
</fieldset>
<br>
<fieldset><legend><b>Défense</b></legend>
<table>
<tr><td class="c" style="text-align:center">
Nom</td><td class="c" style="text-align:center">
Quantité voulue</td><td class="c" style="text-align:center">
Métal requis</td><td class="c" style="text-align:center">
Cristal requis</td><td class="c" style="text-align:center">
Deutérium requis</td><td class="c" style="text-align:center">
Durée de construction</td>
</tr>
<tr><th>
Lance-missile</th><th>
<input type="text" id="lm_voulu" size=5 maxlength="5" onBlur="javascript:defense('lm',2000,0,0)" value="0"></th><th>
<input type="text" id="lm_metal" size="15" readonly value="0"></th><th>
<input type="text" id="lm_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="lm_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="lm_temps" size="15" readonly value="-">
<input type="hidden" id="lm_sec" size="15" value="0"></th>
</tr><tr><th>
Artillerie légère</th><th>
<input type="text" id="ale_voulu" size=5 maxlength="5" onBlur="javascript:defense('ale',1500,500,0)" value="0"></th><th>
<input type="text" id="ale_metal" size="15" readonly value="0"></th><th>
<input type="text" id="ale_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="ale_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="ale_temps" size="15" readonly value="-">
<input type="hidden" id="ale_sec" size="15" value="0"></th>
</tr><tr><th>
Artillerie lourde</th><th>
<input type="text" id="alo_voulu" size=5 maxlength="5" onBlur="javascript:defense('alo',6000,2000,0)" value="0"></th><th>
<input type="text" id="alo_metal" size="15" readonly value="0"></th><th>
<input type="text" id="alo_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="alo_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="alo_temps" size="15" readonly value="-">
<input type="hidden" id="alo_sec" size="15" value="0"></th>
</tr><tr><th>
Canon à ion</th><th>
<input type="text" id="canon_ion_voulu" size=5 maxlength="5" onBlur="javascript:defense('canon_ion',2000,6000,0)" value="0"></th><th>
<input type="text" id="canon_ion_metal" size="15" readonly value="0"></th><th>
<input type="text" id="canon_ion_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="canon_ion_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="canon_ion_temps" size="15" readonly value="-">
<input type="hidden" id="canon_ion_sec" size="15" value="0"></th>
</tr><tr><th>
Canon de Gauss</th><th>
<input type="text" id="gauss_voulu" size=5 maxlength="5" onBlur="javascript:defense('gauss',20000,15000,2000)" value="0"></th><th>
<input type="text" id="gauss_metal" size="15" readonly value="0"></th><th>
<input type="text" id="gauss_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="gauss_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="gauss_temps" size="15" readonly value="-">
<input type="hidden" id="gauss_sec" size="15" value="0"></th>
</tr><tr><th>
Lanceur de plasma</th><th>
<input type="text" id="lp_voulu" size=5 maxlength="5" onBlur="javascript:defense('lp',50000,50000,30000)" value="0"></th><th>
<input type="text" id="lp_metal" size="15" readonly value="0"></th><th>
<input type="text" id="lp_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="lp_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="lp_temps" size="15" readonly value="-">
<input type="hidden" id="lp_sec" size="15" value="0"></th>
</tr><tr><th>
Petit bouclier</th><th>
<input type="text" id="pb_voulu" size=5 maxlength="5" onBlur="javascript:defense('pb',10000,10000,0)" value="0"></th><th>
<input type="text" id="pb_metal" size="15" readonly value="0"></th><th>
<input type="text" id="pb_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="pb_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="pb_temps" size="15" readonly value="-">
<input type="hidden" id="pb_sec" size="15" value="0"></th>
</tr><tr><th>
Grand bouclier</th><th>
<input type="text" id="gb_voulu" size=5 maxlength="5" onBlur="javascript:defense('gb',50000,50000,30000)" value="0"></th><th>
<input type="text" id="gb_metal" size="15" readonly value="0"></th><th>
<input type="text" id="gb_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="gb_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="gb_temps" size="15" readonly value="-">
<input type="hidden" id="gb_sec" size="15" value="0"></th>
</tr><tr><th>
Missile d'interception</th><th>
<input type="text" id="min_voulu" size=5 maxlength="5" onBlur="javascript:defense('min',8000,0,2000)" value="0"></th><th>
<input type="text" id="min_metal" size="15" readonly value="0"></th><th>
<input type="text" id="min_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="min_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="min_temps" size="15" readonly value="-">
<input type="hidden" id="min_sec" size="15" value="0"></th>
</tr><tr><th>
Missile intergalactique</th><th>
<input type="text" id="mip_voulu" size=5 maxlength="5" onBlur="javascript:defense('mip',12500,2500,10000)" value="0"></th><th>
<input type="text" id="mip_metal" size="15" readonly value="0"></th><th>
<input type="text" id="mip_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="mip_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="mip_temps" size="15" readonly value="-">
<input type="hidden" id="mip_sec" size="15" value="0"></th>
</tr><tr><td class="c" style="text-align:center" colspan="2">
TOTAL</td><th>
<input type="text" id="defenses_metal" size="15" readonly value="0"></th><th>
<input type="text" id="defenses_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="defenses_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="defenses_temps" size="15" readonly value="-">
<input type="hidden" id="defenses_sec" size="15" value="0"></th>
</tr><tr><td colspan="7" class="c">
Un total de <span id="defenses_ressources" style="color:#FF0080;font-weight:bold;">
0</span> ressources, soit <span id="defenses_pt" style="color:#0080FF;font-weight:bold;">
0</span> PT ou <span id="defenses_gt" style="color:#80FF00;font-weight:bold;">
0</span> GT
</td></tr></table>
</fieldset>
<br>
<fieldset><legend><b>TOTAL</b></legend>
<table>
<tr><td class="c" style="text-align:center">
Métal requis</td><td class="c" style="text-align:center">
Cristal requis</td><td class="c" style="text-align:center">
Deutérium requis</td><td class="c" style="text-align:center">
Durée de construction</td>
</tr>
<tr><th>
<input type="text" id="total_metal" size="15" readonly value="0"></th><th>
<input type="text" id="total_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="total_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="total_temps" size="15" readonly value="-">
<input type="hidden" id="total_sec" size="15" value="0"></th>
</tr><tr><td colspan="7" class="c">
un total de <span id="total_ressources" style="color:#FF0080;font-weight:bold;">
0</span> ressources, soit <span id="total_pt" style="color:#0080FF;font-weight:bold;">
0</span> PT ou <span id="total_gt" style="color:#80FF00;font-weight:bold;">
0</span> GT
</td></tr></table>
</fieldset>


</center>
<table>
<?php   	
 
 
 
 
 
 
    	
    	
   	 }
 
 
 
 
 
 
 
 
 
 
 
     ///////////////////////////////////////////////////////////////////////// LUNE ////////////////////
   else if (isset($_GET['lunes']))
    {


  // création du tableau baiment vide :
$i=10;
	while (18 >= $i)
	    {

             $bat[$i][user_id]='-';
             $bat[$i][planet_id]='-';
            $bat[$i][planet_name]='-';
            $bat[$i][coordinates]='-';
            $bat[$i][fields]='-';
            $bat[$i][temperature]='-';
            $bat[$i][Sat]='-';
            $bat[$i][Sat_percentage]='-';
            $bat[$i][M]='-';
            $bat[$i][M_percentage]='-';
            $bat[$i][C]='-';
            $bat[$i][C_Percentage]='-';
            $bat[$i][D]='-';
            $bat[$i][D_percentage]='-';
            $bat[$i][CES]='-';
            $bat[$i][CES_percentage]='-';
            $bat[$i][CEF]='-';
            $bat[$i][CEF_percentage]='-';
            $bat[$i][UdR]='-';
            $bat[$i][UdN]='-';
            $bat[$i][CSp]='-';
            $bat[$i][HM]='-';
            $bat[$i][HC]='-';
            $bat[$i][HD]='-';
            $bat[$i][Lab]='-';
            $bat[$i][Ter]='-';
            $bat[$i][DdR]='-';
            $bat[$i][Silo]='-';
            $bat[$i][BaLu]='-';
            $bat[$i][Pha]='-';
            $bat[$i][PoSa]='-';
            $bat[$i][LM]='-';
            //def
             $bat[$i][LLE]='-';
             $bat[$i][LLO]='-';
             $bat[$i][CG]='-';
             $bat[$i][AI]='-';
             $bat[$i][LP]='-';
             $bat[$i][PB]='-';
             $bat[$i][GB]='-';
             $bat[$i][MIC]='-';
             $bat[$i][MIP]='-';

            $i=$i+1;
     }
///fin de creation de tableau vide

?>
 <?php

 // recherche des planetes et batiments
 $sql = 'SELECT * FROM '.$pun_config["ogspy_prefix"].'user_building where user_id ='.$pun_user['id_ogspy'].' and planet_id >= 10 and planet_id <= 18  ORDER BY planet_id asc';
	    $result = $db->query($sql);



	    while($empire = $db->fetch_assoc($result))
	    {
                $i=$empire['planet_id'];

             $bat[$i][user_id]=$empire['user_id'];
             $bat[$i][planet_id]=$empire['planet_id'];
            $bat[$i][planet_name]=$empire['planet_name'];
            $bat[$i][coordinates]=$empire['coordinates'];
            $bat[$i][fields]=$empire['fields'];
            $bat[$i][temperature]=$empire['temperature'];
            $bat[$i][Sat]=$empire['Sat'];
            $bat[$i][Sat_percentage]=$empire['Sat_percentage'];
            $bat[$i][M]=$empire['M'];
            $bat[$i][M_percentage]=$empire['M_percentage'];
            $bat[$i][C]=$empire['C'];
            $bat[$i][C_Percentage]=$empire['C_Percentage'];
            $bat[$i][D]=$empire['D'];
            $bat[$i][D_percentage]=$empire['D_percentage'];
            $bat[$i][CES]=$empire['CES'];
            $bat[$i][CES_percentage]=$empire['CES_percentage'];
            $bat[$i][CEF]=$empire['CEF'];
            $bat[$i][CEF_percentage]=$empire['CEF_percentage'];
            $bat[$i][UdR]=$empire['UdR'];
            $bat[$i][UdN]=$empire['UdN'];
            $bat[$i][CSp]=$empire['CSp'];
            $bat[$i][HM]=$empire['HM'];
            $bat[$i][HC]=$empire['HC'];
            $bat[$i][HD]=$empire['HD'];
            $bat[$i][Lab]=$empire['Lab'];
            $bat[$i][Ter]=$empire['Ter'];
          $bat[$i][DdR]=$empire['DdR'];
            $bat[$i][Silo]=$empire['Silo'];
          $bat[$i][BaLu]=$empire['BaLu'];
            $bat[$i][Pha]=$empire['Pha'];
            $bat[$i][PoSa]=$empire['PoSa'];
   ;
     }
  // recherche des planetes et batiments
 $sql = 'SELECT * FROM '.$pun_config["ogspy_prefix"].'user_defence where user_id ='.$pun_user['id_ogspy'].' and planet_id >= 10 and planet_id <= 18 ORDER BY planet_id asc';
	    $result = $db->query($sql);



	    while($empire = $db->fetch_assoc($result))
	    {
            $i=$empire['planet_id'];

             $bat[$i][LM]=$empire['LM'];
             $bat[$i][LLE]=$empire['LLE'];
             $bat[$i][LLO]=$empire['LLO'];
             $bat[$i][CG]=$empire['CG'];
             $bat[$i][AI]=$empire['AI'];
             $bat[$i][LP]=$empire['LP'];
             $bat[$i][PB]=$empire['PB'];
             $bat[$i][GB]=$empire['GB'];
             $bat[$i][MIC]=$empire['MIC'];
             $bat[$i][MIP]=$empire['MIP'];

   ;
     }





 echo'<tr><th colspan="10"><b>Vue d\'ensemble de votre empire</b></th></tr> ';



   ///utilisation fonctio tableau pour creation ligne a ligne
   //num de planete
     $tableau=tableau_bis_lune ( 'planete' , 'planet_id' );
 echo ''.$tableau.'';

   //nom de planete
     $tableau=tableau_lune ( 'Nom' , 'planet_name' );
 echo ''.$tableau.'';

  //nom de planete
     $tableau=tableau_lune ( 'Coordonnée' , 'coordinates' );
 echo ''.$tableau.'';

   //cases
     $tableau=tableau_lune ( 'cases' , 'fields' );
 echo ''.$tableau.'';

   //temerature
     $tableau=tableau_lune ( 'température' , 'temperature' );
 echo ''.$tableau.'';


echo'<tr><th colspan="10"><b>Divers</b></th></tr> ';

 //nb de sat
     $tableau=tableau_lune ( 'Satellite solaire' , 'Sat' );
 echo ''.$tableau.'';


echo'<tr><th colspan="10"><b>Batiments</b></th></tr> ';

//D
     $tableau=tableau_lune ( 'Usine de robot' , 'UdR' );
 echo ''.$tableau.'';
//D
     $tableau=tableau_lune ( 'Usine de nanite' , 'UdN' );
 echo ''.$tableau.'';
//D
     $tableau=tableau_lune ( 'Chantier spatial' , 'CSp' );
 echo ''.$tableau.'';
//D
     $tableau=tableau_lune ( 'Hangar de métal' , 'HM' );
 echo ''.$tableau.'';

     $tableau=tableau_lune ( 'Hangar de Cristal' , 'HC' );
 echo ''.$tableau.'';

     $tableau=tableau_lune ( 'Hangar de deterium' , 'HD' );
 echo ''.$tableau.'';
//D
     $tableau=tableau_lune ( 'Base lunaire' , 'BaLu' );
 echo ''.$tableau.'';

//D
     $tableau=tableau_lune ( 'Phalange' , 'Pha' );
 echo ''.$tableau.'';
//D
     $tableau=tableau_lune ( 'Porte de saut' , 'PoSa' );
 echo ''.$tableau.'';


 echo'<tr><th colspan="10"><b>Defenses</b></th></tr> ';

  ///def

     $tableau=tableau_lune ( 'Lance missiles' , 'LM' );
 echo ''.$tableau.'';

    $tableau=tableau_lune ( 'Laser leger' , 'LLE' );
 echo ''.$tableau.'';

    $tableau=tableau_lune ( 'Laser lourd' , 'LLO' );
 echo ''.$tableau.'';

    $tableau=tableau_lune ( 'Canon de gauss' , 'CG' );
 echo ''.$tableau.'';

    $tableau=tableau_lune ( 'Artillerie a ions' , 'AI' );
 echo ''.$tableau.'';

    $tableau=tableau_lune ( 'Lanceur de lasma' , 'LP' );
 echo ''.$tableau.'';

    $tableau=tableau_lune ( 'Petit bouclier' , 'PB' );
 echo ''.$tableau.'';

    $tableau=tableau_lune ( 'Grand bouclier' , 'GB' );
 echo ''.$tableau.'';


    }

 ////////////////////////////////////////////////////////////////fin lune debut planete /////////////////////////////////////////////////
else
{
  // création du tableau baiment vide :
$i=1;
	while (9 >= $i)
	    {

             $bat[$i][user_id]='-';
             $bat[$i][planet_id]='-';
            $bat[$i][planet_name]='-';
            $bat[$i][coordinates]='-';
            $bat[$i][fields]='-';
            $bat[$i][temperature]='-';
            $bat[$i][Sat]='-';
            $bat[$i][Sat_percentage]='-';
            $bat[$i][M]='-';
            $bat[$i][M_percentage]='-';
            $bat[$i][C]='-';
            $bat[$i][C_Percentage]='-';
            $bat[$i][D]='-';
            $bat[$i][D_percentage]='-';
            $bat[$i][CES]='-';
            $bat[$i][CES_percentage]='-';
            $bat[$i][CEF]='-';
            $bat[$i][CEF_percentage]='-';
            $bat[$i][UdR]='-';
            $bat[$i][UdN]='-';
            $bat[$i][CSp]='-';
            $bat[$i][HM]='-';
            $bat[$i][HC]='-';
            $bat[$i][HD]='-';
            $bat[$i][Lab]='-';
            $bat[$i][Ter]='-';
            $bat[$i][DdR]='-';
            $bat[$i][Silo]='-';
            $bat[$i][BaLu]='-';
            $bat[$i][Pha]='-';
            $bat[$i][PoSa]='-';
            $bat[$i][LM]='-';
            //def
             $bat[$i][LLE]='-';
             $bat[$i][LLO]='-';
             $bat[$i][CG]='-';
             $bat[$i][AI]='-';
             $bat[$i][LP]='-';
             $bat[$i][PB]='-';
             $bat[$i][GB]='-';
             $bat[$i][MIC]='-';
             $bat[$i][MIP]='-';
             ///

             $bat[$i][Esp]='-';
               $bat[$i][Ordi]='-';
               $bat[$i][Armes]='-';
               $bat[$i][Bouclier]='-';
               $bat[$i][Protection]='-';
               $bat[$i][NRJ]='-';
               $bat[$i][Hyp]='-';
               $bat[$i][RC]='-';
               $bat[$i][RI]='-';
               $bat[$i][PH]='-';
               $bat[$i][Laser]='-';
               $bat[$i][Ions]='-';
               $bat[$i][Plasma]='-';
               $bat[$i][RRI]='-';
               $bat[$i][Graviton]='-';
               $bat[$i][Expeditions]='-';

            $i=$i+1;
     }
///fin de creation de tableau vide

?>
 <?php

 // recherche des planetes et batiments
 $sql = 'SELECT * FROM '.$pun_config["ogspy_prefix"].'user_building where user_id ='.$pun_user['id_ogspy'].' and planet_id <=9 ORDER BY planet_id asc';
	    $result = $db->query($sql);



	    while($empire = $db->fetch_assoc($result))
	    {
                $i=$empire['planet_id'];

             $bat[$i][user_id]=$empire['user_id'];
             $bat[$i][planet_id]=$empire['planet_id'];
            $bat[$i][planet_name]=$empire['planet_name'];
            $bat[$i][coordinates]=$empire['coordinates'];
            $bat[$i][fields]=$empire['fields'];
            $bat[$i][temperature]=$empire['temperature'];
            $bat[$i][Sat]=$empire['Sat'];
            $bat[$i][Sat_percentage]=$empire['Sat_percentage'];
            $bat[$i][M]=$empire['M'];
            $bat[$i][M_percentage]=$empire['M_percentage'];
            $bat[$i][C]=$empire['C'];
            $bat[$i][C_Percentage]=$empire['C_Percentage'];
            $bat[$i][D]=$empire['D'];
            $bat[$i][D_percentage]=$empire['D_percentage'];
            $bat[$i][CES]=$empire['CES'];
            $bat[$i][CES_percentage]=$empire['CES_percentage'];
            $bat[$i][CEF]=$empire['CEF'];
            $bat[$i][CEF_percentage]=$empire['CEF_percentage'];
            $bat[$i][UdR]=$empire['UdR'];
            $bat[$i][UdN]=$empire['UdN'];
            $bat[$i][CSp]=$empire['CSp'];
            $bat[$i][HM]=$empire['HM'];
            $bat[$i][HC]=$empire['HC'];
            $bat[$i][HD]=$empire['HD'];
            $bat[$i][Lab]=$empire['Lab'];
            $bat[$i][Ter]=$empire['Ter'];
          $bat[$i][DdR]=$empire['DdR'];
            $bat[$i][Silo]=$empire['Silo'];
          $bat[$i][BaLu]=$empire['BaLu'];
            $bat[$i][Pha]=$empire['planet_id'];
            $bat[$i][PoSa]=$empire['PoSa'];
   ;
     }
  // recherche des planetes et batiments
 $sql = 'SELECT * FROM '.$pun_config["ogspy_prefix"].'user_defence where user_id ='.$pun_user['id_ogspy'].' and planet_id <=9 ORDER BY planet_id asc';
	    $result = $db->query($sql);



	    while($empire = $db->fetch_assoc($result))
	    {
            $i=$empire['planet_id'];

             $bat[$i][LM]=$empire['LM'];
             $bat[$i][LLE]=$empire['LLE'];
             $bat[$i][LLO]=$empire['LLO'];
             $bat[$i][CG]=$empire['CG'];
             $bat[$i][AI]=$empire['AI'];
             $bat[$i][LP]=$empire['LP'];
             $bat[$i][PB]=$empire['PB'];
             $bat[$i][GB]=$empire['GB'];
             $bat[$i][MIC]=$empire['MIC'];
             $bat[$i][MIP]=$empire['MIP'];

   ;
     }

 $k=1;
// recherche des techno
 $sql = 'SELECT * FROM '.$pun_config["ogspy_prefix"].'user_technology where user_id ='.$pun_user['id_ogspy'].' ';
	    $result = $db->query($sql);



	    while($empire = $db->fetch_assoc($result))
	    {

           	while (9 >= $k)
	    {
               $bat[$k][Esp]=$empire['Esp'];
               $bat[$k][Ordi]=$empire['Ordi'];
               $bat[$k][Armes]=$empire['Armes'];
               $bat[$k][Bouclier]=$empire['Bouclier'];
               $bat[$k][Protection]=$empire['Protection'];
               $bat[$k][NRJ]=$empire['NRJ'];
               $bat[$k][Hyp]=$empire['Hyp'];
               $bat[$k][RC]=$empire['RC'];
               $bat[$k][RI]=$empire['RI'];
               $bat[$k][PH]=$empire['PH'];
               $bat[$k][Laser]=$empire['Laser'];
               $bat[$k][Ions]=$empire['Ions'];
               $bat[$k][Plasma]=$empire['Plasma'];
               $bat[$k][RRI]=$empire['RRI'];
               $bat[$k][Graviton]=$empire['Graviton'];
               $bat[$k][Expeditions]=$empire['Expeditions'];

               $k=$k+1;

            }

     }




 echo'<tr><th colspan="'.($i+1).'"><b>Vue d\'ensemble de votre empire</b></th></tr> ';



   ///utilisation fonctio tableau pour creation ligne a ligne
   //num de planete
     $tableau=tableau_bis ( 'planete' , 'planet_id' );
 echo ''.$tableau.'';

   //nom de planete
     $tableau=tableau ( 'Nom' , 'planet_name' );
 echo ''.$tableau.'';

  //nom de planete
     $tableau=tableau ( 'Coordonnée' , 'coordinates' );
 echo ''.$tableau.'';

   //cases
     $tableau=tableau ( 'cases' , 'fields' );
 echo ''.$tableau.'';

   //temerature
     $tableau=tableau ( 'température' , 'temperature' );
 echo ''.$tableau.'';


echo'<tr><th colspan="'.($i+1).'"><b>Divers</b></th></tr> ';

 //nb de sat
     $tableau=tableau ( 'Satellite solaire' , 'Sat' );
 echo ''.$tableau.'';


echo'<tr><th colspan="'.($i+1).'"><b>Batiments</b></th></tr> ';

 //M
     $tableau=tableau ( 'Mine de métal' , 'M' );
 echo ''.$tableau.'';


 //C
     $tableau=tableau ( 'Mine de cristal' , 'C' );
 echo ''.$tableau.'';

//D
     $tableau=tableau ( 'Mine de deuterium' , 'D' );
 echo ''.$tableau.'';

//D
     $tableau=tableau ( 'Centrale electrique solaire' , 'CES' );
 echo ''.$tableau.'';
//D
     $tableau=tableau ( 'Centrale életrique a fusion' , 'CEF' );
 echo ''.$tableau.'';
//D
     $tableau=tableau ( 'Usine de robot' , 'UdR' );
 echo ''.$tableau.'';
//D
     $tableau=tableau ( 'Usine de nanite' , 'UdN' );
 echo ''.$tableau.'';
//D
     $tableau=tableau ( 'Chantier spatial' , 'CSp' );
 echo ''.$tableau.'';
//D
     $tableau=tableau ( 'Hangar de métal' , 'HM' );
 echo ''.$tableau.'';

     $tableau=tableau ( 'Hangar de Cristal' , 'HC' );
 echo ''.$tableau.'';

     $tableau=tableau ( 'Hangar de deterium' , 'HD' );
 echo ''.$tableau.'';
//D
     $tableau=tableau ( 'Laboratoire de recherche' , 'Lab' );
 echo ''.$tableau.'';

//D
     $tableau=tableau ( 'Terraformeur' , 'Ter' );
 echo ''.$tableau.'';
//D
     $tableau=tableau ( 'Silo' , 'Silo' );
 echo ''.$tableau.'';


 echo'<tr><th colspan="'.($i+1).'"><b>Defenses</b></th></tr> ';

  ///def

     $tableau=tableau ( 'Lance missiles' , 'LM' );
 echo ''.$tableau.'';

    $tableau=tableau ( 'Laser leger' , 'LLE' );
 echo ''.$tableau.'';

    $tableau=tableau ( 'Laser lourd' , 'LLO' );
 echo ''.$tableau.'';

    $tableau=tableau ( 'Canon de gauss' , 'CG' );
 echo ''.$tableau.'';

    $tableau=tableau ( 'Artillerie a ions' , 'AI' );
 echo ''.$tableau.'';

    $tableau=tableau ( 'Lanceur de lasma' , 'LP' );
 echo ''.$tableau.'';

    $tableau=tableau ( 'Petit bouclier' , 'PB' );
 echo ''.$tableau.'';

    $tableau=tableau ( 'Grand bouclier' , 'GB' );
 echo ''.$tableau.'';

    $tableau=tableau ( 'Missile d\'interception' , 'MIC' );
 echo ''.$tableau.'';

    $tableau=tableau ( 'Missile interplanetaire' , 'MIP' );
 echo ''.$tableau.'';


 echo'<tr><th colspan="'.($i+1).'"><b>Recherches</b></th></tr> ';

    $tableau=tableau ( 'Espionnage' , 'Esp' );
 echo ''.$tableau.'';

    $tableau=tableau ( 'Ordinateur' , 'Ordi' );
 echo ''.$tableau.'';

   $tableau=tableau ( 'Armes' , 'Armes' );
 echo ''.$tableau.'';

   $tableau=tableau ( 'Bouclier' , 'Bouclier' );
 echo ''.$tableau.'';

   $tableau=tableau ( 'Protection' , 'Protection' );
 echo ''.$tableau.'';

   $tableau=tableau ( 'Energie' , 'NRJ' );
 echo ''.$tableau.'';

   $tableau=tableau ( 'Hyperespace' , 'Hyp' );
 echo ''.$tableau.'';

   $tableau=tableau ( 'Reacteur à combustion' , 'RC' );

 echo ''.$tableau.'';
   $tableau=tableau ( 'Reacteur a impulsion' , 'RI' );

 echo ''.$tableau.'';
   $tableau=tableau ( 'propulsion hyperespace' , 'PH' );

 echo ''.$tableau.'';
   $tableau=tableau ( 'Laser' , 'Laser' );

 echo ''.$tableau.'';
   $tableau=tableau ( 'Ions' , 'Ions' );

 echo ''.$tableau.'';
   $tableau=tableau ( 'Plasma' , 'Plasma' );

 echo ''.$tableau.'';
   $tableau=tableau ( 'Réseau de recherche' , 'RRI' );

 echo ''.$tableau.'';
   $tableau=tableau ( 'Graviton' , 'Graviton' );

 echo ''.$tableau.'';

   $tableau=tableau ( 'Expedition' , 'Expeditions' );

 echo ''.$tableau.'';



}


   echo'</table> ';




echo'</div></div></div>';

?>





<?php



require PUN_ROOT.'footer.php';