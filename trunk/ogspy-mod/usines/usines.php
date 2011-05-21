<?php
/***************************************************************************
*	filename	: usines.php
*	desc.		:
*	Author		: Jojo.lam44 - http://ogs.servebbs.net/
*	created		: 10/08/2006
*	modified	: 10/08/2006 13:48
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
require_once("views/page_header.php");

require_once("includes/ogame.php");

require_once("parameters/lang_empire.php");

$start = 101; // pour planetes
$nb_planete = find_nb_planete_user(); // nb de planetes dans bdd
$user_empire = user_get_empire();
$user_building = $user_empire["building"];
?>

<table width="100%">
<tr>
	<td class="c" colspan="10">Mod Optimisation des Usines</td>
</tr>
<tr>
	<th><a>Nom</a></th>
<?php


for ($i=$start ; $i<=$start+$nb_planete-1 ; $i++) {
	$name[$i] = $user_building[$i]["planet_name"];
	if ($name[$i] == "") $name[$i] = "&nbsp;";

	echo "\t"."<th><a>".$name[$i]."</a></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Coordonnées</a></th>
<?php
for ($i=$start ; $i<=$start+$nb_planete-1 ; $i++) {
	$coordinates = $user_building[$i]["coordinates"];
	if ($coordinates == "") $coordinates = "&nbsp;";
	else $coordinates = "[".$coordinates."]";

	echo "\t"."<th>".$coordinates."</th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Température minimum</a></th>
<?php
for ($i=$start ; $i<=$start+$nb_planete-1 ; $i++) {
	$temperature[$i] = $user_building[$i]["temperature_min"];
	if ($temperature[$i] == "") $temperature[$i] = "&nbsp;";

	echo "\t"."<th>".$temperature[$i]."</th>"."\n";
}
?>
</tr>
<tr>
	<td class="c" colspan="10"><?php echo $lang_empire["Batiment"] ?></td>
</tr>
<tr>
	<th><a><?php echo $lang_building["UdR"] ?></a></th>
<?php
for ($i=$start ; $i<=$start+$nb_planete-1 ; $i++) {
	$UdR[$i] = $user_building[$i]["UdR"];
	if ($UdR[$i] == "") $UdR[$i] = "&nbsp;";

	echo "\t"."<th><font color='lime'>".$UdR[$i]."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["CSp"] ?></a></th>
<?php
for ($i=$start ; $i<=$start+$nb_planete-1 ; $i++) {
	$CSp[$i] = $user_building[$i]["CSp"];
	if ($CSp[$i] == "") $CSp[$i] = "&nbsp;";

	echo "\t"."<th><font color='lime'>".$CSp[$i]."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["UdN"] ?></a></th>
<?php
for ($i=$start ; $i<=$start+$nb_planete-1 ; $i++) {
	$UdN[$i] = $user_building[$i]["UdN"];
	if ($UdN[$i] == "") $UdN[$i] = "&nbsp;";

	echo "\t"."<th><font color='lime'>".$UdN[$i]."</font></th>"."\n";
}
?>
</tr>
<tr>
	<td class="c" colspan="10">Production</td>
</tr>
<tr>
	<th><a><?php echo $lang_building["M"] ?></a></th>
<?php
for ($i=$start ; $i<=$start+$nb_planete-1 ; $i++) {
	$M = $user_building[$i]["M"];
	if ($M != "") $production_M[$i] = production("M", $M);
	else $production_M[$i] = "&nbsp;";
	
	echo "\t"."<th><font color='lime'>".$production_M[$i]."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["C"] ?></a></th>
<?php
for ($i=$start ; $i<=$start+$nb_planete-1 ; $i++) {
	$C = $user_building[$i]["C"];
	if ($C != "") $production_C[$i] = production("C", $C);
	else $production_C[$i] = "&nbsp;";
	
	echo "\t"."<th><font color='lime'>".$production_C[$i]."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a><?php echo $lang_building["D"] ?></a></th>
<?php
for ($i=$start ; $i<=$start+$nb_planete-1 ; $i++) {
	$D = $user_building[$i]["D"];
	$temperature = $user_building[$i]["temperature"];
	$CEF = $user_building[$i]["CEF"];
	$CEF_consumption = consumption("CEF", $CEF);
	if ($D != "") $production_D[$i] = production("D", $D, $temperature) - $CEF_consumption;
	else $production_D[$i] = "&nbsp;";

	echo "\t"."<th><font color='lime'>".$production_D[$i]."</font></th>"."\n";
}
?>
</tr>
<tr>
	<td class="c" colspan="10">Usines à construire</td>
</tr>
<tr>
	<th><a>Spécialisation Batiments</a></th>
<?php

for ($i=$start ; $i<=$start+$nb_planete-1 ; $i++) {
	if (!($name[$i] == "&nbsp;" || $temperature[$i] == "&nbsp;" || $UdR[$i] == "&nbsp;" || $CSp[$i] == "&nbsp;" || $UdN[$i] == "&nbsp;" || $production_M[$i] == "&nbsp;" || $production_C[$i] == "&nbsp;" || $production_D[$i] == "&nbsp;"))
	{
		$cout_UdN = (100000 * pow(2 , $UdN[$i]) * (10 + 5 * ($production_C[$i] / $production_D[$i]) + ($production_M[$i] / $production_D[$i]))) * (( 1 / ($UdR[$i] + 1)) * pow (0.5 , ($UdN[$i] + 1)));
		$cout_UdR = (40 * pow(2 , $UdR[$i]) * (10 + 3 * ($production_C[$i] / $production_D[$i]) + 5 * ($production_M[$i] / $production_D[$i])) * (( 1 / ($UdR[$i] + 2)) * pow (0.5 , $UdN[$i])));
		if ($cout_UdN > $cout_UdR) $todo = $lang_building["UdR"];
		else $todo = $lang_building["UdN"];
		
		echo "\t"."<th><font color='lime'>".$todo."</font></th>"."\n";
	
	}
	else echo "\t"."<th><font color='lime'>&nbsp;</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Spécialisation Vaisseaux</a></th>
<?php

for ($i=$start ; $i<=$start+$nb_planete-1 ; $i++) {
	if (!($name[$i] == "&nbsp;" || $temperature[$i] == "&nbsp;" || $UdR[$i] == "&nbsp;" || $CSp[$i] == "&nbsp;" || $UdN[$i] == "&nbsp;" || $production_M[$i] == "&nbsp;" || $production_C[$i] == "&nbsp;" || $production_D[$i] == "&nbsp;"))
	{
		$cout_UdN = (100000 * pow(2 , $UdN[$i]) * (10 + 5 * ($production_C[$i] / $production_D[$i]) + ($production_M[$i] / $production_D[$i]))) * (( 1 / ($CSp[$i] + 1)) * pow (0.5 , ($UdN[$i] + 1)));
		$cout_CSp = (100 * pow(2 , $CSp[$i]) * (4 + 2 * ($production_C[$i] / $production_D[$i]) + ($production_M[$i] / $production_D[$i])) * (( 1 / ($CSp[$i] + 2)) * pow (0.5 , $UdN[$i])));
		if ($cout_UdN > $cout_CSp) $todo = $lang_building["CSp"];
		else $todo = $lang_building["UdN"];
	
		echo "\t"."<th><font color='lime'>".$todo."</font></th>"."\n";
	}
	else echo "\t"."<th><font color='lime'>&nbsp;</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Mixte</a></th>
<?php

for ($i=$start ; $i<=$start+$nb_planete-1 ; $i++) {
	if (!($name[$i] == "&nbsp;" || $temperature[$i] == "&nbsp;" || $UdR[$i] == "&nbsp;" || $CSp[$i] == "&nbsp;" || $UdN[$i] == "&nbsp;" || $production_M[$i] == "&nbsp;" || $production_C[$i] == "&nbsp;" || $production_D[$i] == "&nbsp;"))
	{
		$cout_UdN = (100000 * pow(2 , $UdN[$i]) * (10 + 5 * ($production_C[$i] / $production_D[$i]) + ($production_M[$i] / $production_D[$i]))) * (( 1 / ($CSp[$i] + 1)) * pow(0.5 , ($UdN[$i] + 1)) + ( 1 / ($CSp[$i] + 1)) * pow(0.5 , ($CSp[$i] + 1)));
		$cout_UdR_CSp = (100 * pow(2 , $CSp[$i]) * (4 + 2 * ($production_C[$i] / $production_D[$i]) + ($production_M[$i] / $production_D[$i])) + 40 * pow(2 , $CSp[$i]) * (10 + 3 * ($production_C[$i] / $production_D[$i]) + 5 * ($production_M[$i] / $production_D[$i]))) * (( 1 / ($CSp[$i] + 2)) * (pow(0.5 , $UdN[$i]) + 2 * pow(0.5 , $UdN[$i])));
		if ($cout_UdN > $cout_UdR_CSp) $todo = $lang_building["UdR"]." & ".$lang_building["CSp"];
		else $todo = $lang_building["UdN"];
	
		echo "\t"."<th><font color='lime'>".$todo."</font></th>"."\n";
	}
	else echo "\t"."<th><font color='lime'>&nbsp;</font></th>"."\n";
}
?>
</tr>
</table>
<br/>
<div align=center><font size=2>Mod Optimisatoin des Usines développée par <a href=mailto:jojolam44@hotmail.com>Jojo.lam44</a> &copy;2006</font></div>

<?php
require_once("views/page_tail.php");
?>