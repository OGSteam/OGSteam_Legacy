<?php
/** $Id$ **/
/**
* 
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Création du template & initialisation des variables
if (file_exists($user_data['user_skin'].'\templates\home_simulation.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\home_simulation.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\home_simulation.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\home_simulation.tpl');
}
else
{
    $tpl = new template('home_simulation.tpl');
}
$tpl_var = Array();

$user_empire = user_get_empire();
$user_building = $user_empire["building"];
$user_defence = $user_empire["defence"];
$user_fleet = $user_empire["fleet"];
if ($user_empire["technology"]) $user_technology = $user_empire["technology"];
else $user_technology = '0';

// Recuperation des pourcentages
$planet = array("planet_id" => "", "M_percentage" => 0, "C_percentage" => 0, "D_percentage" => 0, "CES_percentage" => 0, "CEF_percentage" => 0, "Sat_percentage" => 0);
$quet = mysql_query("SELECT planet_id, M_percentage, C_percentage, D_percentage, CES_percentage, CEF_percentage, Sat_percentage FROM ".TABLE_USER_BUILDING." WHERE user_id = ".$user_data["user_id"]." AND planet_id < 10 ORDER BY planet_id");
$user_percentage = array_fill(1, 9, $planet);
while ($row = mysql_fetch_assoc($quet)) {
	$arr = $row;
	unset($arr["planet_id"]);
	$user_percentage[$row["planet_id"]] = $arr;
}

$lab_max = 0;
for ($i=1 ; $i<=9 ; $i++) {
	// Nom des planètes
	$tpl_var["name{$i}"] = ($user_building[$i]["planet_name"]=="")?"-":$user_building[$i]["planet_name"];
	// Coordonnée
	$tpl_var["coordinates{$i}"] = ($user_building[$i]["coordinates"]=="")?"&nbsp;":"[{$user_building[$i]["coordinates"]}]";
	// Cases
	$fields = ($user_building[$i]["fields"]=="0")?"?":$user_building[$i]["fields"];
	$tpl_var["fields{$i}"] = ($user_building[$i]["fields_used"]>0)?"{$user_building[$i]["fields_used"]} / {$fields}":"&nbsp;";
	// Température
	$tpl_var["temperature{$i}"] = ($user_building[$i]["temperature"]=="")?"&nbsp;":$user_building[$i]["temperature"];
	// CES
	$tpl_var["CES{$i}"] = $user_building[$i]["CES"];
	$tpl_var["CES_{$i}_percentage_options"] = get_options_list($user_percentage[$i]['CES_percentage']);
	// CEF
	$tpl_var["CEF{$i}"] = $user_building[$i]["CEF"];
	$tpl_var["CEF_{$i}_percentage_options"] = get_options_list($user_percentage[$i]['CEF_percentage']);
	// Satellite
	$tpl_var["Sat{$i}"] = ($user_building[$i]["Sat"]!="")?$user_building[$i]["Sat"]:"0";
	$tpl_var["Sat_{$i}_percentage_options"] = get_options_list($user_percentage[$i]['Sat_percentage']);
	// Metal
	$tpl_var["M{$i}"] = $user_building[$i]["M"];
	$tpl_var["M_{$i}_percentage_options"] = get_options_list($user_percentage[$i]['M_percentage']);
	// Cristal
	$tpl_var["C{$i}"] = $user_building[$i]["C"];
	$tpl_var["C_{$i}_percentage_options"] = get_options_list($user_percentage[$i]['C_percentage']);
	// deuterium
	$tpl_var["D{$i}"] = $user_building[$i]["D"];
	$tpl_var["D_{$i}_percentage_options"] = get_options_list($user_percentage[$i]['D_percentage']);
	// Building
	$tpl_var["building_{$i}_value"] = implode(array_slice($user_building[$i],11,-2), "&lt;&gt;");
	if($lab_max < $user_building[$i]["Lab"]) $lab_max = $user_building[$i]["Lab"];
	// Defence
	$tpl_var["defence_{$i}_value"] = implode($user_defence[$i], "&lt;&gt;");
	// Flottes
	$tpl_var["fleet_{$i}_value"] = implode($user_fleet[$i], "&lt;&gt;");
	// Lunes
	$tpl_var["lune_b_{$i}_value"] = ($user_building[$i+9])?implode(array_slice($user_building[$i+9],11,-2,true), "&lt;&gt;"):"0";
	$tpl_var["lune_d_{$i}_value"] = ($user_defence[$i+9])?implode($user_defence[$i+9], "&lt;&gt;"):"0";
	$tpl_var["lune_f_{$i}_value"] = ($user_fleet[$i+9])?implode($user_fleet[$i+9], "&lt;&gt;"):"0";
}
// technologie
for ($i=1 ; $i<=9 ; $i++) {
	if($user_empire["technology"]!=NULL && $user_building[$i]["Lab"] == $lab_max) {
		$tpl_var["techno_value"] = implode($user_empire["technology"], "&lt;&gt;");
		$tpl_var["techno_{$i}"] = "-";
	}	else $tpl_var["techno_{$i}"] = "&nbsp;";
}

// Inscription des variables
$tpl->SimpleVar($tpl_var);

// Simple Variable
$tpl->SimpleVar(Array(
	"user_technology_NRJ" => $user_technology['NRJ'],
	"server_config_speed_uni" => $server_config['speed_uni'],
	"user_data_off_ingenieur" => $user_data["off_ingenieur"],
	"user_data_off_geologue" => $user_data["off_geologue"],
));

//Affichage Template
$tpl->parse();


function get_options_list($value){
	$tmp = "";
	for ($j=100 ; $j>=0 ; $j=$j-10) {
		$tmp .= "<option value='{$j}'";
		$tmp .= ($value==$j)? " selected='selected'>":">";
		$tmp .= "{$j}%</option>";
	}
	return $tmp;
}
