<?php
/***************************************************************************
*	filename	: calculs.php
*	package		: Mod Ressources
*	version		: 0.1
*	desc.			: Calcul des ressources disponibles.
*	Authors		: Scaler - http://ogsteam.fr
*	created		: 11/08/2006
*	modified	: 01:50 01/06/2009
***************************************************************************/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

require_once('includes/config.php');

if (isset($pub_save)) {
	// Suppression de la sauvegarde précédente
	$query = "DELETE FROM `".$table_prefix."mod_ressources_hide` WHERE user_id=".$user_data['user_id'];
	$db->sql_query($query);
	$query = "DELETE FROM `".$table_prefix."mod_ressources_trade` WHERE user_id=".$user_data['user_id'];
	$db->sql_query($query);
	$query = "DELETE FROM `".$table_prefix."mod_ressources_construction` WHERE user_id=".$user_data['user_id'];
	$db->sql_query($query);
	// Sauvegarde des ressources cachées
	$i = 0;
	while (isset(${"pub_cache_type".$i})) {
		$query = "INSERT INTO `".$table_prefix."mod_ressources_hide` (user_id, type, level) VALUES (".$user_data['user_id'].", ".${"pub_cache_type".$i}.", ".${"pub_cache_level".$i++}.")";
		$db->sql_query($query);
	}
	// Sauvegarde des échanges
	$i = 0;
	while (isset(${"pub_echange_type".$i})) {
		$query = "INSERT INTO `".$table_prefix."mod_ressources_trade` (user_id, type, metal, crystal, deuterium, metal_rate, crystal_rate, deuterium_rate) VALUES (".$user_data['user_id'].", ".${"pub_echange_type".$i}.", ".${"pub_echange_metal".$i}.", ".${"pub_echange_crystal".$i}.", ".${"pub_echange_deuterium".$i}.", ".${"pub_echange_metal_r".$i}.", ".${"pub_echange_crystal_r".$i}.", ".${"pub_echange_deuterium_r".$i++}.")";
		$db->sql_query($query);
	}
	//Sauvegarde des constructions
	$i = 0;
	while (isset(${"pub_construction_type".$i})) {
		$query = "INSERT INTO `".$table_prefix."mod_ressources_construction` (user_id, type, level) VALUES (".$user_data['user_id'].", ".${"pub_construction_type".$i}.", ".${"pub_construction_level".$i++}.")";
		$db->sql_query($query);
	}
}

foreach ($lang['ressources_construction'] as $val) $buildings[] = "&nbsp;&nbsp;".$val;
$buildings[0] = $lang['ressources_construction'][0];
$buildings[19] = $lang['ressources_construction'][19];
$buildings[35] = $lang['ressources_construction'][35];
$buildings[50] = $lang['ressources_construction'][50];

$trades = $lang['ressources_trade'];

$sep_mille = $lang['ressources_thousands_separator'];

// Récupération des informations de l'empire
$user_empire = user_get_empire();
$user_building = $user_empire["building"];
$nbre_planete = 0;
for ($i=1; $i<=9; $i++) {
	if ($user_building[$i][0]) {
		$nbre_planete += 1;
		$planete[$nbre_planete] = $i;
		if ($user_building[$i+9]['planet_name']) $lune[$nbre_planete] = 1;
		else $lune[$nbre_planete] = 0;
	}
}
$planete[0] = 0;

// Récupération des informations des ressources
$ressources[0] = array("metal" => 0, "crystal" => 0, "deuterium" => 0);
for($i=1;$i<=$nbre_planete;$i++) {
	$ressources[$planete[$i]] = array("metal" => 0, "crystal" => 0, "deuterium" => 0, "timestamp" => time());
	if ($lune[$i] == 1) $ressources[$planete[$i]+9] = array("metal" => 0, "crystal" => 0, "deuterium" => 0);
}
define("TABLE_USER_RESSOURCES",$table_prefix."user_ressources");
$quet = mysql_query("SELECT planet_id, timestamp, metal, crystal, deuterium FROM ".TABLE_USER_RESSOURCES." WHERE user_id = ".$user_data["user_id"]);
while ($row = mysql_fetch_assoc($quet)) $ressources[$row["planet_id"]] = array("metal" => $row["metal"], "crystal" => $row["crystal"], "deuterium" => $row["deuterium"], "timestamp" => $row["timestamp"]);

// Récuperation des informations sur les mines
$planet = array("planet_id" => "", "M_percentage" => 0, "C_percentage" => 0, "D_percentage" => 0, "CES_percentage" => 100, "CEF_percentage" => 100, "Sat_percentage" => 100);
$quet = mysql_query("SELECT planet_id, M_percentage, C_percentage, D_percentage, CES_percentage, CEF_percentage, Sat_percentage FROM ".TABLE_USER_BUILDING." WHERE user_id = ".$user_data["user_id"]." AND planet_id < 10 ORDER BY planet_id");
while ($row = mysql_fetch_assoc($quet)) {
	$arr = $row;
	unset($arr["planet_id"]);
	$user_percentage[$row["planet_id"]] = $arr;
}

// Récupération des informations sur les technologies
if ($user_empire["technology"]) $user_technology = $user_empire["technology"];
else $user_technology = '0';

// Récupération des informations sur les officiers
$query = mysql_fetch_assoc(mysql_query("SELECT `off_ingenieur`, `off_geologue` FROM ".TABLE_USER." WHERE `user_id` = ".$user_data["user_id"]));
$ingenieur = 1 + $query["off_ingenieur"] / 10;
$geologue = 1 + $query["off_geologue"] / 10;

// Récupération des informations sur la vitesse univers
$query = mysql_fetch_assoc(mysql_query("SELECT `config_value` FROM ".TABLE_CONFIG." WHERE config_name = 'speed_uni'"));
// pour les version d'OGSpy jusqu'à 3.04b, par défaut : 1
// pour l'uni 50 français qui est à vitesse *2, il faut donc mettre... 2 !
if (!$query["config_value"]) $query["config_value"] = 1;
$vitesse = $query["config_value"];

// Calcul des hangars
$hangars[0]["metal"] = 0;
$hangars[0]["crystal"] = 0;
$hangars[0]["deuterium"] = 0;
for($i=1;$i<=$nbre_planete;$i++) {
	$hangars[$planete[$i]]["metal"] = 100000 + 50000 * floor(pow(1.6, $user_building[$planete[$i]]["HM"]));
	$hangars[$planete[$i]]["crystal"] = 100000 + 50000 * floor(pow(1.6, $user_building[$planete[$i]]["HC"]));
	$hangars[$planete[$i]]["deuterium"] = 100000 + 50000 * floor(pow(1.6, $user_building[$planete[$i]]["HD"]));
	$hangars[0]["metal"] += $hangars[$planete[$i]]["metal"];
	$hangars[0]["crystal"] += $hangars[$planete[$i]]["crystal"];
	$hangars[0]["deuterium"] += $hangars[$planete[$i]]["deuterium"];
}

// Calcul de la production et des ressources actualisées
$production[0] = array("metal" => 0, "crystal" => 0, "deuterium" => 0);
for($i=1;$i<=$nbre_planete;$i++) {
	$prod_energie = round((round(($user_percentage[$planete[$i]]["CES_percentage"] / 100) * (floor(20 * $user_building[$planete[$i]]["CES"] * pow(1.1, $user_building[$planete[$i]]["CES"])))) + round(($user_percentage[$planete[$i]]["CEF_percentage"] / 100) * (floor(30 * $user_building[$planete[$i]]["CEF"] * pow(1.05 + 0.01 * $user_technology["NRJ"], $user_building[$planete[$i]]["CEF"])))) + floor(($user_percentage[$planete[$i]]["Sat_percentage"] / 100) * ($user_building[$planete[$i]]["Sat"] * floor($user_building[$planete[$i]]["temperature"] / 4 + 20)))) * $ingenieur);
	$conso_energie = ceil(($user_percentage[$planete[$i]]["M_percentage"] / 100) * (ceil(10 * $user_building[$planete[$i]]["M"] * pow(1.1, $user_building[$planete[$i]]["M"])))) + ceil(($user_percentage[$planete[$i]]["C_percentage"] / 100) * (ceil(10 * $user_building[$planete[$i]]["C"] * pow(1.1, $user_building[$planete[$i]]["C"])))) + ceil(($user_percentage[$planete[$i]]["D_percentage"] / 100) * (ceil(20 * $user_building[$planete[$i]]["D"] * pow(1.1, $user_building[$planete[$i]]["D"]))));
	if ($conso_energie == 0) $conso_energie = 1;
	$energie = $prod_energie - $conso_energie;
	$energie_tot = $prod_energie;
	$ratio = floor(($prod_energie / $conso_energie) * 100) / 100;
	if ($ratio > 1) $ratio = 1;
	$production[$planete[$i]]["metal"] = $vitesse * floor((20 + round(($user_percentage[$planete[$i]]["M_percentage"] / 100) * $ratio * floor(30 * $user_building[$planete[$i]]["M"] * pow(1.1, $user_building[$planete[$i]]["M"])))) * $geologue);
	$production[$planete[$i]]["crystal"] = $vitesse * floor((10 + round(($user_percentage[$planete[$i]]["C_percentage"] / 100) * $ratio * floor(20 * $user_building[$planete[$i]]["C"] * pow(1.1, $user_building[$planete[$i]]["C"])))) * $geologue);
	$production[$planete[$i]]["deuterium"] = $vitesse * floor((round(($user_percentage[$planete[$i]]["D_percentage"] / 100) * $ratio * floor(10 * $user_building[$planete[$i]]["D"] * pow(1.1, $user_building[$planete[$i]]["D"]) * (-0.002 * $user_building[$planete[$i]]["temperature"] + 1.28))) * $geologue) - round(($user_percentage[$planete[$i]]["CEF_percentage"] / 100) * 10 * $user_building[$planete[$i]]["CEF"] * pow(1.1, $user_building[$planete[$i]]["CEF"])));
	$temps = (time() - $ressources[$planete[$i]]["timestamp"]) / 3600;
	$ressources[$planete[$i]]["metal"] += max(min(round($production[$planete[$i]]["metal"] * $temps), $hangars[$planete[$i]]["metal"] - $ressources[$planete[$i]]["metal"]), 0);
	$ressources[$planete[$i]]["crystal"] += min(round($production[$planete[$i]]["crystal"] * $temps), max($hangars[$planete[$i]]["crystal"] - $ressources[$planete[$i]]["crystal"], 0));
	$ressources[$planete[$i]]["deuterium"] += min(round($production[$planete[$i]]["deuterium"] * $temps), max($hangars[$planete[$i]]["deuterium"] - $ressources[$planete[$i]]["deuterium"], 0));
	$production[0]["metal"] += $production[$planete[$i]]["metal"];
	$production[0]["crystal"] += $production[$planete[$i]]["crystal"];
	$production[0]["deuterium"] += $production[$planete[$i]]["deuterium"];
	$ressources[0]["metal"] += $ressources[$planete[$i]]["metal"];
	$ressources[0]["crystal"] += $ressources[$planete[$i]]["crystal"];
	$ressources[0]["deuterium"] += $ressources[$planete[$i]]["deuterium"];
	if ($lune[$i] == 1) {
		$ressources[0]["metal"] += $ressources[$planete[$i]+9]["metal"];
		$ressources[0]["crystal"] += $ressources[$planete[$i]+9]["crystal"];
		$ressources[0]["deuterium"] += $ressources[$planete[$i]+9]["deuterium"];
	}
}
$ressources[0]["timestamp"] = 0;
?>

<script language='javascript'>
// Définition des variables globales du javascript
var ressource = new Array();
var ressources = new Array();
var productions = new Array();
var hangars = new Array();
var lune = new Array();
var metal = new Array();
var crystal = new Array();
var deuterium = new Array();
var flotte = new Array(5000,25000,20000,1000000);
<?php
echo "var batiment_nom = new Array('";
foreach ($lang['ressources_construction'] as $val) echo $val."', '";
echo "');\nvar echange_nom = new Array('";
foreach ($lang['ressources_trade'] as $val) echo $val."', '";
echo "');\n";
?>
var batiment_metal = new Array(0,60,48,225,75,900,400,1000000,400,2000,2000,2000,200,0,20000,20000,20000,20000,2000000,0,200,0,800,200,1000,0,0,400,2000,10000,200,1000,2000,240000,4000,0,2000,6000,3000,6000,20000,45000,10000,10000,0,50000,0,60000,5000000,30000,0,2000,1500,6000,20000,2000,50000,10000,50000,8000,12500);
var batiment_crystal = new Array(0,15,24,75,30,360,120,500000,200,0,1000,2000,400,50000,40000,20000,40000,40000,4000000,0,1000,400,200,600,0,800,4000,0,4000,20000,100,300,4000,400000,8000,0,2000,6000,1000,4000,7000,15000,20000,6000,1000,25000,2000,50000,4000000,40000,0,0,0.5,2,15000,6000,50000,10000,50000,0,2500);
var batiment_deuterium = new Array(0,0,0,0,0,180,200,100000,100,0,0,0,200,100000,0,1000,20000,20000,2000000,0,200,600,0,0,0,400,2000,600,600,6000,0,100,1000,160000,4000,0,0,0,0,0,2000,0,10000,2000,0,15000,500,15000,1000000,15000,0,0,0,0,200,6000,30000,0,0,2000,10000);
var batiment_puis = new Array(0,1.5,1.6,1.5,1.5,1.8,2,2,2,2,2,2,2,2,2,2,2,2,2,0,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
var batiment_maxi = new Array(0,47,41,44,47,28,25,14,25,23,23,23,25,17,18,19,18,18,12,0,24,24,24,24,24,24,22,24,22,19,26,24,22,15,21,0,1000000,1000000,1000000,1000000,500000,222222,500000,1000000,666666,1000000,1000000,166666,2000,250000,0,1000000,1000000,1000000,500000,1000000,200000,18,18,1000000,800000);
var caches = new Array();
var echanges = new Array();
var constructions = new Array();
var cache = new Array(0,0,0);
var echange = new Array(0,0,0);
var construction = new Array(0,0,0);
metal_lunes = crystal_lunes = deuterium_lunes = 0;
<?php
for ($i=0;$i<=$nbre_planete;$i++) {
	echo "ressources[".$i."] = new Array(".$ressources[$planete[$i]]["metal"].",".$ressources[$planete[$i]]["crystal"].",".$ressources[$planete[$i]]["deuterium"].",".$ressources[$planete[$i]]["timestamp"].");\n";
	echo "productions[".$i."] = new Array(".$production[$planete[$i]]["metal"].",".$production[$planete[$i]]["crystal"].",".$production[$planete[$i]]["deuterium"].");\n";
	echo "hangars[".$i."] = new Array(".$hangars[$planete[$i]]["metal"].",".$hangars[$planete[$i]]["crystal"].",".$hangars[$planete[$i]]["deuterium"].");\n";
	if ($i !=0 && $lune[$i] == 1) {
		echo "ressources[".($i + 9)."] = new Array(".$ressources[$planete[$i]+9]["metal"].",".$ressources[$planete[$i]+9]["crystal"].",".$ressources[$planete[$i]+9]["deuterium"].",".$ressources[$planete[$i]+9]["timestamp"].");\n";
		echo "metal_lunes += ".$ressources[$planete[$i]+9]["metal"].";\n";
		echo "crystal_lunes += ".$ressources[$planete[$i]+9]["crystal"].";\n";
		echo "deuterium_lunes += ".$ressources[$planete[$i]+9]["deuterium"].";\n";
		echo "lune[".$i."] = 1;\n";
	} else echo "lune[".$i."] = 0;\n";
	echo "ressource[".$i."] = new Array();\n";
}
echo "var month = new Array(";
foreach ($lang['ressources_months'] as $val) echo "'".$val."', ";
echo "'');\n";
echo "vitesse = ".$vitesse.";\n";
echo "nbre_planete = ".$nbre_planete.";\n";
?>

// Fonctions d'incrémentation automatique des ressources
temps = 0;
function init() setInterval('compteur()',2000);
function compteur() {
temps += 2;
ressource[0][0] = metal_lunes;
ressource[0][1] = crystal_lunes;
ressource[0][2] = deuterium_lunes;
for (i=1;i<=nbre_planete;i++) {
	ressource[i][0] = ressources[i][0] + Math.min(Math.round(temps * productions[i][0] / 3600), Math.max(hangars[i][0] - ressources[i][0], 0));
	ressource[i][1] = ressources[i][1] + Math.min(Math.round(temps * productions[i][1] / 3600), Math.max(hangars[i][1] - ressources[i][1], 0));
	ressource[i][2] = ressources[i][2] + Math.min(Math.round(temps * productions[i][2] / 3600), Math.max(hangars[i][2] - ressources[i][2], 0));
	document.getElementById('metal' + i).innerHTML = format(ressource[i][0]);
	document.getElementById('crystal' + i).innerHTML = format(ressource[i][1]);
	document.getElementById('deuterium' + i).innerHTML = format(ressource[i][2]);
	if (ressource[i][0] >= hangars[i][0]) document.getElementById('metal' + i).style.color = document.getElementById('hangar_metal' + i).style.color = 'red';
	if (ressource[i][1] >= hangars[i][1]) document.getElementById('crystal' + i).style.color = document.getElementById('hangar_crystal' + i).style.color = 'red';
	if (ressource[i][2] >= hangars[i][2]) document.getElementById('deuterium' + i).style.color = document.getElementById('hangar_deuterium' + i).style.color = 'red';
	ressource[0][0] += ressource[i][0];
	ressource[0][1] += ressource[i][1];
	ressource[0][2] += ressource[i][2];
}
document.getElementById('metal0').innerHTML = format(ressource[0][0]);
document.getElementById('crystal0').innerHTML = format(ressource[0][1]);
document.getElementById('deuterium0').innerHTML = format(ressource[0][2]);
if (caches.length + echanges.length > 0) {
	document.getElementById('cache_metal_total').innerHTML = format(ressource[0][0] + cache[0] + echange[0]);
	document.getElementById('cache_crystal_total').innerHTML = format(ressource[0][1] + cache[1] + echange[1]);
	document.getElementById('cache_deuterium_total').innerHTML = format(ressource[0][2] + cache[2] + echange[2]);
}
if (constructions.length > 0) {
	document.getElementById('construction_metal_total').innerHTML = format(ressource[0][0] + cache[0] + echange[0] + construction[0]);
	document.getElementById('construction_crystal_total').innerHTML = format(ressource[0][1] + cache[1] + echange[1] + construction[1]);
	document.getElementById('construction_deuterium_total').innerHTML = format(ressource[0][2] + cache[2] + echange[2] + construction[2]);
}
f_transport();
}

// Fonction de calcul du nombre de vaisseaux nécessaire au transport des ressources
function f_transport(a) {
var transports = new Array();
transports[0] = 0;
for (i=1;i<=nbre_planete;i++) {
	transports[0] += transports[i] = Math.ceil((ressource[i][0] + ressource[i][1] + ressource[i][2]) / flotte[document.getElementById('transport').value]);
	document.getElementById('transport' + i).innerHTML = format(transports[i]);
	if (constructions.length > 0) document.getElementById('transport_construction' + i).innerHTML = format(Math.ceil((metal[i] + crystal[i] + deuterium[i]) / flotte[document.getElementById('transport').value]));
	else document.getElementById('transport_construction' + i).innerHTML = '';
	if (lune[i] == 1) {
		transports[0] += transports[i + 9] = Math.ceil((ressources[i + 9][0] + ressources[i + 9][1] + ressources[i + 9][2]) / flotte[document.getElementById('transport').value]);
		document.getElementById('transport' + (i + 9)).innerHTML = format(transports[i + 9]);
	}
}
document.getElementById('transport0').innerHTML = format(transports[0]);
ligne = '';
for (i=0;i<caches.length;i++) {
	ligne += '<tr style="border: none"><td style="border: none; height: 21px; text-align: center">' + format(Math.ceil(caches[i][2] / flotte[document.getElementById('transport').value])) + '</td></tr>';
}
document.getElementById('cache_transport').innerHTML = '<table style="border: none; width: 100%; border-spacing: 0px">' + ligne + '</table>';
ligne = '';
for (i=0;i<echanges.length;i++) {
	if (echanges[i][0] == 0) val = Math.ceil(Math.max(Math.abs(echanges[i][1]), Math.abs(echanges[i][2] + echanges[i][3])) / flotte[document.getElementById('transport').value]);
	if (echanges[i][0] == 1) val = Math.ceil(Math.max(Math.abs(echanges[i][2]), Math.abs(echanges[i][1] + echanges[i][3])) / flotte[document.getElementById('transport').value]);
	if (echanges[i][0] == 2) val = Math.ceil(Math.max(Math.abs(echanges[i][3]), Math.abs(echanges[i][1] + echanges[i][2])) / flotte[document.getElementById('transport').value]);
	if (echanges[i][0] == 3) val = Math.ceil((echanges[i][1] + echanges[i][2] + echanges[i][3]) / flotte[document.getElementById('transport').value]);
	ligne += '<tr style="border: none"><td style="border: none; height: 21px; text-align: center">' + format(val) + '</td></tr>';
	transports[0] += val;
}
document.getElementById('echange_transport').innerHTML = '<table style="border: none; width: 100%; border-spacing: 0px">' + ligne + '</table>';
document.getElementById('cache_transport_total').innerHTML = format(transports[0]);
ligne = '';
for (i=0;i<constructions.length;i++) {
	ligne += '<tr style="border: none"><td style="border: none; height: 21px; text-align: center">' + format(Math.ceil(constructions[i][2] / flotte[document.getElementById('transport').value])) + '</td></tr>';
}
document.getElementById('construction_transport').innerHTML = '<table style="border: none; width: 100%; border-spacing: 0px">' + ligne + '</table>';
if (constructions.length > 0) document.getElementById('construction_transport_total').innerHTML = '&nbsp;<br>' + format(Math.ceil((Math.max(metal[0] + cache[0] + echange[0] + construction[0],0) + Math.max(crystal[0] + cache[1] + echange[1] + construction[1],0) + Math.max(deuterium[0] + cache[2] + echange[2] + construction[2],0)) / flotte[document.getElementById('transport').value]));
else document.getElementById('construction_transport_total').innerHTML = '';
}

// Fonction d'ajout/suppression de ressources cachées
function f_cache(a) {
if (caches.length >= 20 && a < 0) {
	alert("<?php echo $lang['ressources_hide_max'];?>");
	return;
}
if (parseFloat(document.getElementById('cache').value) == -1 && a < 0) return;
techno = 0;
for (i=0;i<caches.length;i++) {
	if (isNaN(parseFloat(document.getElementById('cache_batiment' + i).value))) document.getElementById('cache_batiment' + i).value = caches[i][1];
	caches[i][1] = Math.min(Math.max(parseFloat(document.getElementById('cache_batiment' + i).value),1),batiment_maxi[caches[i][0]]);
	if (caches[i][0] > 18) techno = 1;
}
if (!isNaN(parseFloat(a))) {
	if (a == -1) {
		if (parseFloat(document.getElementById('cache').value) < 19 || techno == 0) caches[caches.length] = new Array(parseFloat(document.getElementById('cache').value), 1, 0);
		else alert("<?php echo $lang['ressources_research_max'];?>");
	} else {
		j = 0;
		caches2 = caches;
		caches = new Array();
		for (i=0;i<caches2.length;i++) {
			if (i != a) caches[j++] = caches2[i];
		}
	}
}
ligne_batiment = ligne_metal = ligne_crystal = ligne_deuterium = '';
cache[0] = cache[1] = cache[2] = 0;
for (i=0;i<caches.length;i++) {
	ligne_batiment += '<tr style="border: none"><td style="border: none; height: 21px; text-align: left; white-space: nowrap"><img style="cursor: pointer;vertical-align: middle;" src="images/cross.png" onClick="javascript: f_cache (' + i + ')" title="<?php echo $lang['ressources_delete'];?>" alt="x" />&nbsp;' + batiment_nom[caches[i][0]] + '&nbsp;<input type="hidden" name="cache_type' + i + '" value="' + caches[i][0] + '" /><input type="text" id="cache_batiment' + i + '" name="cache_level' + i + '" size="2" maxlength="2" onBlur="javascript: f_cache ()" value="' + caches[i][1] + '" title="<?php echo $lang['ressources_level'];?>" /></td><tr>';
	cache[0] += metal_batiment = Math.floor(batiment_metal[caches[i][0]] * Math.pow(batiment_puis[caches[i][0]],caches[i][1]-1));
	ligne_metal += '<tr style="border: none"><td style="border: none; height: 21px; text-align: center">' + format(metal_batiment) + '</td></tr>';
	cache[1] += crystal_batiment = Math.floor(batiment_crystal[caches[i][0]] * Math.pow(batiment_puis[caches[i][0]],caches[i][1]-1));
	ligne_crystal += '<tr style="border: none"><td style="border: none; height: 21px; text-align: center">' + format(crystal_batiment) + '</td></tr>';
	cache[2] += deuterium_batiment = Math.floor(batiment_deuterium[caches[i][0]] * Math.pow(batiment_puis[caches[i][0]],caches[i][1]-1));
	ligne_deuterium += '<tr style="border: none"><td style="border: none; height: 21px; text-align: center">' + format(deuterium_batiment) + '</td></tr>';
	caches[i][2] = metal_batiment + crystal_batiment + deuterium_batiment;
}
document.getElementById('cache_batiment').innerHTML = '<table style="border: none; width: 100%; border-spacing: 0px">' + ligne_batiment + '</table>';
document.getElementById('cache_metal').innerHTML = '<table style="border: none; width: 100%; border-spacing: 0px">' + ligne_metal + '</table>';
document.getElementById('cache_crystal').innerHTML = '<table style="border: none; width: 100%; border-spacing: 0px">' + ligne_crystal + '</table>';
document.getElementById('cache_deuterium').innerHTML = '<table style="border: none; width: 100%; border-spacing: 0px">' + ligne_deuterium + '</table>';
for (i=0;i<caches.length;i++) document.getElementById('cache_batiment' + i).value = caches[i][1];
if (caches.length + echanges.length == 0) document.getElementById('cache_metal_total').innerHTML = document.getElementById('cache_crystal_total').innerHTML = document.getElementById('cache_deuterium_total').innerHTML = '';
else {
	document.getElementById('cache_metal_total').innerHTML = format(ressource[0][0] + cache[0] + echange[0]);
	document.getElementById('cache_crystal_total').innerHTML = format(ressource[0][1] + cache[1] + echange[1]);
	document.getElementById('cache_deuterium_total').innerHTML = format(ressource[0][2] + cache[2] + echange[2]);
}
if (constructions.length > 0) f_construction();
}

// Fonction d'ajout/suppression des échanges
function f_echange(a) {
if (echanges.length >= 20 && a < 0) {
	alert("<?php echo $lang['ressources_trade_max'];?>");
	return;
}
if (parseFloat(document.getElementById('echange').value) == -1 && a < 0) return;
for (i=0;i<echanges.length;i++) {
	if (isNaN(parseFloat(document.getElementById('echange_metal' + i).value))) document.getElementById('echange_metal' + i).value = echanges[i][1];
	if (isNaN(parseFloat(document.getElementById('echange_crystal' + i).value))) document.getElementById('echange_crystal' + i).value = echanges[i][2];
	if (isNaN(parseFloat(document.getElementById('echange_deuterium' + i).value))) document.getElementById('echange_deuterium' + i).value = echanges[i][3];
	echanges[i][1] = parseFloat(document.getElementById('echange_metal' + i).value);
	echanges[i][2] = parseFloat(document.getElementById('echange_crystal' + i).value);
	echanges[i][3] = parseFloat(document.getElementById('echange_deuterium' + i).value);
	if (echanges[i][0] != 3) {
		if (isNaN(parseFloat(document.getElementById('echange_metal_r' + i).value))) document.getElementById('echange_metal_r' + i).value = echanges[i][4];
		if (isNaN(parseFloat(document.getElementById('echange_crystal_r' + i).value))) document.getElementById('echange_crystal_r' + i).value = echanges[i][5];
		if (isNaN(parseFloat(document.getElementById('echange_deuterium_r' + i).value))) document.getElementById('echange_deuterium_r' + i).value = echanges[i][6];
		echanges[i][4] = parseFloat(document.getElementById('echange_metal_r' + i).value);
		echanges[i][5] = parseFloat(document.getElementById('echange_crystal_r' + i).value);
		echanges[i][6] = parseFloat(document.getElementById('echange_deuterium_r' + i).value);
	}
}
if (!isNaN(parseFloat(a))) {
	if (a == -1) echanges[echanges.length] = new Array(parseFloat(document.getElementById('echange').value),0,0,0,300,200,100);
	else {
		j = 0;
		echanges2 = echanges;
		echanges = new Array();
		for (i=0;i<echanges2.length;i++) {
			if (i != a) echanges[j++] = echanges2[i];
		}
	}
}
ligne_echange = ligne_metal = ligne_crystal = ligne_deuterium = '';
for (i=0;i<echanges.length;i++) {
	ligne_echange += '<tr style="border: none"><td style="border: none; height: 21px; text-align: left; white-space: nowrap"><img style="cursor: pointer;vertical-align: middle;" src="images/cross.png" onClick="javascript: f_echange (' + i + ')" title="<?php echo $lang['ressources_delete'];?>" alt="x" />&nbsp;' + echange_nom[echanges[i][0]] + '<input type="hidden" name="echange_type' + i + '" value="' + echanges[i][0] + '" />';
	if (echanges[i][0] != 3) ligne_echange += '&nbsp;<input type="text" id="echange_metal_r' + i + '" name="echange_metal_r' + i + '" size="3" maxlength="3" onBlur="javascript: echange_calcul (' + i + ',' + echanges[i][0] + ')" value="' + echanges[i][4] + '" title="<?php echo $lang['ressources_metal_ratio'];?>" />&nbsp;<input type="text" id="echange_crystal_r' + i + '" name="echange_crystal_r' + i + '" size="3" maxlength="3" onBlur="javascript: echange_calcul (' + i + ',' + echanges[i][0] + ')" value="' + echanges[i][5] + '" title="<?php echo $lang['ressources_crystal_ratio'];?>" />&nbsp;<input type="text" id="echange_deuterium_r' + i + '" name="echange_deuterium_r' + i + '" size="3" maxlength="3" onBlur="javascript: echange_calcul (' + i + ',' + echanges[i][0] + ')" value="' + echanges[i][6] + '" title="<?php echo $lang['ressources_deut_ratio'];?>" />';
	else ligne_echange += '<input type="hidden" name="echange_metal_r' + i + '" value="0" /><input type="hidden" name="echange_crystal_r' + i + '" value="0" /><input type="hidden" name="echange_deuterium_r' + i + '" value="0" />';
	ligne_echange += '</td><tr>';
	if (echanges[i][0] == 0) ligne_metal += '<tr style="border: none"><td style="border: none; height: 21px; text-align: center"><span id="echange_metal' + i + '">' + format(echanges[i][1]) + '</span><input type="hidden" id="echange_metal_hidden' + i + '" name="echange_metal' + i + '" value="' + echanges[i][1] + '" /></td></tr>';
	else ligne_metal += '<tr style="border: none"><td style="border: none; height: 21px; text-align: center"><input type="text" id="echange_metal' + i + '" name="echange_metal' + i + '" size="10" maxlength="10" onBlur="javascript: echange_calcul (' + i + ',' + echanges[i][0] + ')" value="' + echanges[i][1] + '" /></td></tr>';
	if (echanges[i][0] == 1) ligne_crystal += '<tr style="border: none"><td style="border: none; height: 21px; text-align: center"><span id="echange_crystal' + i + '">' + format(echanges[i][2]) + '</span><input type="hidden" id="echange_crystal_hidden' + i + '" name="echange_crystal' + i + '" value="' + echanges[i][2] + '" /></td></tr>';
	else ligne_crystal += '<tr style="border: none"><td style="border: none; height: 21px; text-align: center"><input type="text" id="echange_crystal' + i + '" name="echange_crystal' + i + '" size="10" maxlength="10" onBlur="javascript: echange_calcul (' + i + ',' + echanges[i][0] + ')" value="' + echanges[i][2] + '" /></td></tr>';
	if (echanges[i][0] == 2) ligne_deuterium += '<tr style="border: none"><td style="border: none; height: 21px; text-align: center"><span id="echange_deuterium' + i + '">' + format(echanges[i][3]) + '</span><input type="hidden" id="echange_deuterium_hidden' + i + '" name="echange_deuterium' + i + '" value="' + echanges[i][3] + '" /></td></tr>';
	else ligne_deuterium += '<tr style="border: none"><td style="border: none; height: 21px; text-align: center"><input type="text" id="echange_deuterium' + i + '" name="echange_deuterium' + i + '" size="10" maxlength="10" onBlur="javascript: echange_calcul (' + i + ',' + echanges[i][0] + ')" value="' + echanges[i][3] + '" /></td></tr>';
}
echange[0] = echange[1] = echange[2] = 0;
for (i=0;i<echanges.length;i++) {
	echange[0] += echanges[i][1];
	echange[1] += echanges[i][2];
	echange[2] += echanges[i][3];
}
document.getElementById('echange_echange').innerHTML = '<table style="border: none; width: 100%; border-spacing: 0px">' + ligne_echange + '</table>';
document.getElementById('echange_metal').innerHTML = '<table style="border: none; width: 100%; border-spacing: 0px">' + ligne_metal + '</table>';
document.getElementById('echange_crystal').innerHTML = '<table style="border: none; width: 100%; border-spacing: 0px">' + ligne_crystal + '</table>';
document.getElementById('echange_deuterium').innerHTML = '<table style="border: none; width: 100%; border-spacing: 0px">' + ligne_deuterium + '</table>';
if (caches.length + echanges.length == 0) document.getElementById('cache_metal_total').innerHTML = document.getElementById('cache_crystal_total').innerHTML = document.getElementById('cache_deuterium_total').innerHTML = '';
else {
	document.getElementById('cache_metal_total').innerHTML = format(ressource[0][0] + cache[0] + echange[0]);
	document.getElementById('cache_crystal_total').innerHTML = format(ressource[0][1] + cache[1] + echange[1]);
	document.getElementById('cache_deuterium_total').innerHTML = format(ressource[0][2] + cache[2] + echange[2]);
}
if (constructions.length > 0) f_construction();
}

// Fonction de calcul des échanges
function echange_calcul(i,b) {
if (b != 0 && isNaN(parseFloat(document.getElementById('echange_metal' + i).value))) document.getElementById('echange_metal' + i).value = echanges[i][1];
if (b != 1 && isNaN(parseFloat(document.getElementById('echange_crystal' + i).value))) document.getElementById('echange_crystal' + i).value = echanges[i][2];
if (b != 2 && isNaN(parseFloat(document.getElementById('echange_deuterium' + i).value))) document.getElementById('echange_deuterium' + i).value = echanges[i][3];
if (b != 0) echanges[i][1] = parseFloat(document.getElementById('echange_metal' + i).value);
if (b != 1) echanges[i][2] = parseFloat(document.getElementById('echange_crystal' + i).value);
if (b != 2) echanges[i][3] = parseFloat(document.getElementById('echange_deuterium' + i).value);
if (echanges[i][0] != 3) {
	var type = new Array("metal","crystal","deuterium");
	if (isNaN(parseFloat(document.getElementById('echange_metal_r' + i).value)) || parseFloat(document.getElementById('echange_metal_r' + i).value) < 1) document.getElementById('echange_metal_r' + i).value = echanges[i][4];
	if (isNaN(parseFloat(document.getElementById('echange_crystal_r' + i).value)) || parseFloat(document.getElementById('echange_crystal_r' + i).value) < 1) document.getElementById('echange_crystal_r' + i).value = echanges[i][5];
	if (isNaN(parseFloat(document.getElementById('echange_deuterium_r' + i).value)) || parseFloat(document.getElementById('echange_deuterium_r' + i).value) < 1) document.getElementById('echange_deuterium_r' + i).value = echanges[i][6];
	echanges[i][4] = parseFloat(document.getElementById('echange_metal_r' + i).value);
	echanges[i][5] = parseFloat(document.getElementById('echange_crystal_r' + i).value);
	echanges[i][6] = parseFloat(document.getElementById('echange_deuterium_r' + i).value);
	echanges[i][b + 1] = - Math.round(echanges[i][b + 4] * (echanges[i][1 + (1 + b) % 3] / echanges[i][4 + (1 + b) % 3] + echanges[i][1 + (2 + b) % 3] / echanges[i][4 + (2 + b) % 3]));
	document.getElementById('echange_' + type[b] + i).innerHTML = format(echanges[i][b + 1]);
	document.getElementById('echange_' + type[b] + '_hidden' + i).value = echanges[i][b + 1];
}
echange[0] = echange[1] = echange[2] = 0;
for (i=0;i<echanges.length;i++) {
	echange[0] += echanges[i][1];
	echange[1] += echanges[i][2];
	echange[2] += echanges[i][3];
}
document.getElementById('cache_metal_total').innerHTML = format(ressource[0][0] + cache[0] + echange[0]);
document.getElementById('cache_crystal_total').innerHTML = format(ressource[0][1] + cache[1] + echange[1]);
document.getElementById('cache_deuterium_total').innerHTML = format(ressource[0][2] + cache[2] + echange[2]);
if (constructions.length > 0) f_construction();
}

// Fonction d'ajout/suppression de constructions
function f_construction(a) {
if (constructions.length >= 20 && a < 0) {
	alert("<?php echo $lang['ressources_construction_max'];?>");
	return;
}
if (parseFloat(document.getElementById('construction').value) == -1 && a < 0) return;
for (i=0;i<constructions.length;i++) {
	if (isNaN(parseFloat(document.getElementById('construction_batiment' + i).value))) document.getElementById('construction_batiment' + i).value = constructions[i][1];
	constructions[i][1] = Math.min(Math.max(parseFloat(document.getElementById('construction_batiment' + i).value),1),batiment_maxi[constructions[i][0]]);
}
if (!isNaN(parseFloat(a))) {
	if (a == -1) {
		constructions[constructions.length] = new Array(parseFloat(document.getElementById('construction').value), 1, 0);
	} else {
		j = 0;
		constructions2 = constructions;
		constructions = new Array();
		for (i=0;i<constructions2.length;i++) {
			if (i != a) constructions[j++] = constructions2[i];
		}
	}
}
ligne_batiment = ligne_metal = ligne_crystal = ligne_deuterium = '';
construction[0] = construction[1] = construction[2] = 0;
for (i=0;i<constructions.length;i++) {
	title = '<?php echo $lang['ressources_level'];?>';
	maxi = 2;
	if (constructions[i][0] > 35) {
		title = '<?php echo $lang['ressources_quantity'];?>';
		maxi = 6;
	}
	ligne_batiment += '<tr style="border: none"><td style="border: none; height: 21px; text-align: left; white-space: nowrap"><img style="cursor: pointer;vertical-align: middle;" src="images/cross.png" onClick="javascript: f_construction (' + i + ')" title="<?php echo $lang['ressources_delete'];?>" alt="x" />&nbsp;' + batiment_nom[constructions[i][0]] + '&nbsp;<input type="hidden" name="construction_type' + i + '" value="' + constructions[i][0] + '" /><input type="text" id="construction_batiment' + i + '" name="construction_level' + i + '" size="' + maxi + '" maxlength="' + maxi + '" onBlur="javascript: f_construction ()" value="' + constructions[i][1] + '" title="'+ title + '" /></td><tr>';
	if (constructions[i][0] < 35) {
		construction[0] += metal_batiment = - Math.floor(batiment_metal[constructions[i][0]] * Math.pow(batiment_puis[constructions[i][0]],constructions[i][1]-1));
		construction[1] += crystal_batiment = - Math.floor(batiment_crystal[constructions[i][0]] * Math.pow(batiment_puis[constructions[i][0]],constructions[i][1]-1));
		construction[2] += deuterium_batiment = - Math.floor(batiment_deuterium[constructions[i][0]] * Math.pow(batiment_puis[constructions[i][0]],constructions[i][1]-1));
	} else {
		construction[0] += metal_batiment = - Math.floor(batiment_metal[constructions[i][0]] * constructions[i][1]);
		construction[1] += crystal_batiment = - Math.floor(batiment_crystal[constructions[i][0]] * constructions[i][1]);
		construction[2] += deuterium_batiment = - Math.floor(batiment_deuterium[constructions[i][0]] * constructions[i][1]);
	}
	constructions[i][2] = - metal_batiment - crystal_batiment - deuterium_batiment;
	ligne_metal += '<tr style="border: none"><td style="border: none; height: 21px; text-align: center">' + format(metal_batiment) + '</td></tr>';
	ligne_crystal += '<tr style="border: none"><td style="border: none; height: 21px; text-align: center">' + format(crystal_batiment) + '</td></tr>';
	ligne_deuterium += '<tr style="border: none"><td style="border: none; height: 21px; text-align: center">' + format(deuterium_batiment) + '</td></tr>';
}
document.getElementById('construction_batiment').innerHTML = '<table style="border: none; width: 100%; border-spacing: 0px">' + ligne_batiment + '</table>';
document.getElementById('construction_metal').innerHTML = '<table style="border: none; width: 100%; border-spacing: 0px">' + ligne_metal + '</table>';
document.getElementById('construction_crystal').innerHTML = '<table style="border: none; width: 100%; border-spacing: 0px">' + ligne_crystal + '</table>';
document.getElementById('construction_deuterium').innerHTML = '<table style="border: none; width: 100%; border-spacing: 0px">' + ligne_deuterium + '</table>';
for (i=0;i<constructions.length;i++) document.getElementById('construction_batiment' + i).value = constructions[i][1];
if (constructions.length == 0) {
	document.getElementById('construction_metal_total').innerHTML = document.getElementById('construction_crystal_total').innerHTML = document.getElementById('construction_deuterium_total').innerHTML = document.getElementById('metal_construction_total').innerHTML = document.getElementById('crystal_construction_total').innerHTML = document.getElementById('deuterium_construction_total').innerHTML = '';
	for (j=1;j<=nbre_planete;j++) document.getElementById('metal_construction' + j).innerHTML = document.getElementById('crystal_construction' + j).innerHTML = document.getElementById('deuterium_construction' + j).innerHTML = '';
} else {
	document.getElementById('construction_metal_total').innerHTML = format(ressource[0][0] + cache[0] + echange[0] + construction[0]);
	document.getElementById('construction_crystal_total').innerHTML = format(ressource[0][1] + cache[1] + echange[1] + construction[1]);
	document.getElementById('construction_deuterium_total').innerHTML = format(ressource[0][2] + cache[2] + echange[2] + construction[2]);
}
if (constructions.length > 0) f_date();
else document.getElementById('construction_date').innerHTML = '';
f_transport();
}

// Fonction de calcul de la date de construction
function f_date() {
time = new Array(0,0,0);
var da = new Date().getTime();
for (j=0;j<3;j++) time[j] = da - 3600000 * (ressource[0][j] + cache[j] + echange[j] + construction[j]) / productions[0][j];
var d = new Date(Math.max(time[0],time[1],time[2],da));
document.getElementById('construction_date').innerHTML = '<?php echo $lang['ressources_construction_date'];?><br />' + d.getDate().toString().padLeft('0', 2) + "&nbsp;" + month[d.getMonth()] + "&nbsp;" + d.getFullYear() + "&nbsp;" + d.getHours().toString().padLeft('0', 2) + ":" + d.getMinutes().toString().padLeft('0', 2) + ":" + d.getSeconds().toString().padLeft('0', 2);
metal[0] = crystal[0] = deuterium[0] = 0;
for (i=1;i<=nbre_planete;i++) {
	metal[0] += metal[i] = ressource[i][0] + Math.round((d - da) * productions[i][0] / 3600000);
	crystal[0] += crystal[i] = ressource[i][1] + Math.round((d - da) * productions[i][1] / 3600000);
	deuterium[0] += deuterium[i] = ressource[i][2] + Math.round((d - da) * productions[i][2] / 3600000);
	document.getElementById('metal_construction' + i).innerHTML = format(metal[i]);
	document.getElementById('crystal_construction' + i).innerHTML = format(crystal[i]);
	document.getElementById('deuterium_construction' + i).innerHTML = format(deuterium[i]);
	if (metal[i] > hangars[i][0]) document.getElementById('metal_construction' + i).style.color = 'red';
	else document.getElementById('metal_construction' + i).style.color = '';
	if (crystal[i] > hangars[i][1]) document.getElementById('crystal_construction' + i).style.color = 'red';
	else document.getElementById('crystal_construction' + i).style.color = '';
	if (deuterium[i] > hangars[i][2]) document.getElementById('deuterium_construction' + i).style.color = 'red';
	else document.getElementById('deuterium_construction' + i).style.color = '';
	if (lune[i] == 1) {
		metal[0] += ressources[i+9][0];
		crystal[0] += ressources[i+9][1];
		deuterium[0] += ressources[i+9][2];
	}
}
document.getElementById('metal_construction_total').innerHTML = format(Math.max(metal[0] + cache[0] + echange[0] + construction[0],0));
document.getElementById('crystal_construction_total').innerHTML = format(Math.max(crystal[0] + cache[1] + echange[1] + construction[1],0));
document.getElementById('deuterium_construction_total').innerHTML = format(Math.max(deuterium[0] + cache[2] + echange[2] + construction[2],0));
}

// Fonction pour rajouter un zéro devant un chiffre
String.prototype.padLeft = function(strChar, intLength) {
var str = this + '';
if (strChar.length > 0) {
	while (str.length < intLength) str = strChar + str;
}
return str;
}

// Fonction de sélection des planètes
function selection (sel) {
if (sel == 0) sel = false;
else sel = true;
for (i=1;i<=nbre_planete;i++) {
	document.getElementById('planet' + i).checked = sel;
	if (lune[i] == 1) document.getElementById('planet' + (i + 9)).checked = sel;
}
}

// Fonction de mise en forme des nombres
function format(x) {
var signe = '';
if (x < 0) {
	x = Math.abs(x);
	signe = '-';
}
var str = x.toString(), n = str.length;
if (n < 4) return (signe + x);
else return (signe + ((n % 3) ? str.substr(0, n % 3) + '<?php echo $sep_mille;?>' : '')) + str.substr(n % 3).match(new RegExp('[0-9]{3}', 'g')).join('<?php echo $sep_mille;?>');
}

// Lancement des scripts
window.onload = function () {Biper(); init();}// compteur();
</script>


<!-- Affichage -->
<form action='' method='post'>
<table width='100%'>
	<tr>
		<td class='c' colspan='2' rowspan='2' style='text-align: center' width='10%'><!--table width='100%' style='border: none'><tr><th style='border: none; background: none'><img style='cursor: pointer;vertical-align: middle;' src='images/action_delete.png' onClick='javascript: selection(0)' alt='<?php echo $lang['ressources_none'];?>' title='<?php echo $lang['ressources_none'];?>' /></th><th style='border: none; background: none'--><?php echo $lang['ressources_planete'];?><!--/th><th style='border: none; background: none'><img style='cursor: pointer;vertical-align: middle;' src='images/action_check.png' onClick='javascript: selection(1)' alt='".$lang['ressources_all']."' title='<?php echo $lang['ressources_all'];?>' /></th></tr></table--></td>
		<td class='c' colspan='3' style='text-align: center'><?php echo $lang['ressources_ressources'];?></td>
		<td class='c' colspan='1' style='text-align: center'>Transport</td>
		<td class='c' colspan='3' style='text-align: center'><?php echo $lang['ressources_production'];?></td>
		<td class='c' colspan='3' style='text-align: center'><?php echo $lang['ressources_storage'];?></td>
	</tr>
	<tr>
<?php
for ($i=1;$i<=3;$i++) {
	echo "\t\t<td class='c' style='text-align: center; width: 10%'>".$lang['ressources_metal']."</td>\n";
	echo "\t\t<td class='c' style='text-align: center; width: 10%'>".$lang['ressources_crystal']."</td>\n";
	echo "\t\t<td class='c' style='text-align: center; width: 10%'>".$lang['ressources_deuterium']."</td>\n";
	if ($i == 1) {
		echo "\t\t<td class='c' style='text-align: center'><select id='transport' onChange='javascript: f_transport(1)'>\n";
		echo "\t\t\t<option value='0'>".$lang['ressources_SCS']."</option>\n";
		echo "\t\t\t<option value='1' selected='selected'>".$lang['ressources_LCS']."</option>\n";
		echo "\t\t\t<option value='2'>".$lang['ressources_Rec']."</option>\n";
		echo "\t\t\t<option value='3'>".$lang['ressources_RIP']."</option>\n";
		echo "\t\t</select></td>\n";
	}
}
echo "\t</tr>\n";
$row = 'f';
for($i=1;$i<=$nbre_planete;$i++) {
	$name[$planete[$i]] = $user_building[$planete[$i]]["planet_name"];
	if ($name[$planete[$i]] == "") $name[$planete[$i]] = "&nbsp;";
	else $name[$planete[$i]] .= "<br />[".$user_building[$planete[$i]]["coordinates"]."]";
	$color = max(min(255, round((time() - $ressources[$planete[$i]]["timestamp"] - 86400) / 2033)), 0);
	//echo "\t<tr>\n\t\t<td class='".$row."' style='text-align: center'><input type='checkbox' id='planet".$i."' title='".$lang['ressources_take_into']."' checked='checked' /></td>\n";
	//echo "\t\t<td class='".$row."' style='text-align: center; color: rgb(".$color.",".(255 - $color).",0)' title='".$lang['ressources_update']."&nbsp;".strftime('%d&nbsp;%b&nbsp;%H:%M:%S', $ressources[$planete[$i]]["timestamp"])."'>".$name[$planete[$i]]."</td>\n";
	echo "\t\t<td class='".$row."' colspan='2' style='text-align: center; color: rgb(".$color.",".(255 - $color).",0)' title='".$lang['ressources_update']."&nbsp;".strftime('%d&nbsp;%b&nbsp;%H:%M:%S', $ressources[$planete[$i]]["timestamp"])."'>".$name[$planete[$i]]."</td>\n";
	$color_metal = '';
	$color_crystal = '';
	$color_deuterium = '';
	if ($ressources[$planete[$i]]["metal"] >= $hangars[$planete[$i]]["metal"]) $color_metal = "; color: red'";
	if ($ressources[$planete[$i]]["crystal"] >= $hangars[$planete[$i]]["crystal"]) $color_crystal = "; color: red'";
	if ($ressources[$planete[$i]]["deuterium"] >= $hangars[$planete[$i]]["deuterium"]) $color_deuterium = "; color: red'";
	echo "\t\t<td class='".$row."' style='text-align: center".$color_metal."'><span id='metal".$i."'>".formate_number($ressources[$planete[$i]]["metal"], 0, ',', $sep_mille)."</span><br /><span id='metal_construction".$i."' title='".$lang['ressources_metal_const_date']."'></span></td>\n";
	echo "\t\t<td class='".$row."' style='text-align: center".$color_crystal."'><span id='crystal".$i."'>".formate_number($ressources[$planete[$i]]["crystal"], 0, ',', $sep_mille)."</span><br /><span id='crystal_construction".$i."' title='".$lang['ressources_crystal_const_date']."'></span></td>\n";
	echo "\t\t<td class='".$row."' style='text-align: center".$color_deuterium."'><span id='deuterium".$i."'>".formate_number($ressources[$planete[$i]]["deuterium"], 0, ',', $sep_mille)."</span><br /><span id='deuterium_construction".$i."' title='".$lang['ressources_deut_const_date']."'></span></td>\n";
	echo "\t\t<td class='".$row."' style='text-align: center'><span id='transport".$i."'>".formate_number(ceil(($ressources[$planete[$i]]["metal"] + $ressources[$planete[$i]]["crystal"] + $ressources[$planete[$i]]["deuterium"]) / 25000), 0, ',', $sep_mille)."</span><br /><span id='transport_construction".$i."'></span></td>\n";
	echo "\t\t<td class='".$row."' style='text-align: center'>".formate_number($production[$planete[$i]]["metal"], 0, ',', $sep_mille)."</td>\n";
	echo "\t\t<td class='".$row."' style='text-align: center'>".formate_number($production[$planete[$i]]["crystal"], 0, ',', $sep_mille)."</td>\n";
	echo "\t\t<td class='".$row."' style='text-align: center'>".formate_number($production[$planete[$i]]["deuterium"], 0, ',', $sep_mille)."</td>\n";
	if (($hangars[$planete[$i]]["metal"] - $ressources[$planete[$i]]["metal"]) / $production[$planete[$i]]["metal"] < 24 && $color_metal == "") $color_metal = "; color: orange' title='".$lang['ressources_less_24h']."'";
	echo "\t\t<td class='".$row."' style='text-align: center".$color_metal."' id='hangar_metal".$i."'>".formate_number($hangars[$planete[$i]]["metal"], 0, ',', $sep_mille)."<br />";
	echo strftime('%d&nbsp;%b&nbsp;%H:%M:%S', time() + 3600 * ($hangars[$planete[$i]]["metal"] - $ressources[$planete[$i]]["metal"]) / $production[$planete[$i]]["metal"])."</td>\n";
	if (($hangars[$planete[$i]]["crystal"] - $ressources[$planete[$i]]["crystal"]) / $production[$planete[$i]]["crystal"] < 24 && $color_crystal == "") $color_crystal = "; color: orange' title='".$lang['ressources_less_24h']."'";
	echo "\t\t<td class='".$row."' style='text-align: center".$color_crystal."' id='hangar_crystal".$i."'>".formate_number($hangars[$planete[$i]]["crystal"], 0, ',', $sep_mille)."<br />";
	echo strftime('%d&nbsp;%b&nbsp;%H:%M:%S', time() + 3600 * ($hangars[$planete[$i]]["crystal"] - $ressources[$planete[$i]]["crystal"]) / $production[$planete[$i]]["crystal"])."</td>\n";
	if (($hangars[$planete[$i]]["deuterium"] - $ressources[$planete[$i]]["deuterium"]) / $production[$planete[$i]]["deuterium"] < 24 && $color_deuterium == "") $color_deuterium = "; color: orange' title='".$lang['ressources_less_24h']."'";
	echo "\t\t<td class='".$row."' style='text-align: center".$color_deuterium."' id='hangar_deuterium".$i."'>".formate_number($hangars[$planete[$i]]["deuterium"], 0, ',', $sep_mille)."<br />";
	echo strftime('%d&nbsp;%b&nbsp;%H:%M:%S', time() + 3600 * ($hangars[$planete[$i]]["deuterium"] - $ressources[$planete[$i]]["deuterium"]) / $production[$planete[$i]]["deuterium"])."</td>\n";
	echo "\t</tr>\n";
	if ($lune[$i] == 1) {
		$name[$planete[$i]+9] = $user_building[$planete[$i]+9]["planet_name"];
		if ($name[$planete[$i]+9] == "") $name[$planete[$i]+9] = "&nbsp;";
		$color = max(min(255, round((time() - $ressources[$planete[$i]+9]["timestamp"] - 86400) / 2033)), 0);
		//echo "\t\t<td class='".$row."' style='text-align: center'><input type='checkbox' id='planet".($i+9)."' title='".$lang['ressources_take_into']."' checked='checked' /></td>\n";
		//echo "\t\t<td class='".$row."' style='text-align: center; color: rgb(".$color.",".(255 - $color).",0)' title='".$lang['ressources_update']."&nbsp;".strftime('%d&nbsp;%b&nbsp;%H:%M:%S', $ressources[$planete[$i]+9]["timestamp"])."'>".$name[$planete[$i]+9]." (Lune)</td>\n";
		echo "\t\t<td class='".$row."' colspan='2' style='text-align: center; color: rgb(".$color.",".(255 - $color).",0)' title='".$lang['ressources_update']."&nbsp;".strftime('%d&nbsp;%b&nbsp;%H:%M:%S', $ressources[$planete[$i]+9]["timestamp"])."'>".$name[$planete[$i]+9]." (Lune)</td>\n";
		echo "\t\t<td class='".$row."' style='text-align: center'>".formate_number($ressources[$planete[$i]+9]["metal"], 0, ',', $sep_mille)."</td>\n";
		echo "\t\t<td class='".$row."' style='text-align: center'>".formate_number($ressources[$planete[$i]+9]["crystal"], 0, ',', $sep_mille)."</td>\n";
		echo "\t\t<td class='".$row."' style='text-align: center'>".formate_number($ressources[$planete[$i]+9]["deuterium"], 0, ',', $sep_mille)."</td>\n";
		echo "\t\t<td class='".$row."' style='text-align: center' id='transport".($i + 9)."'>".formate_number(ceil(($ressources[$planete[$i]+9]["metal"] + $ressources[$planete[$i]+9]["crystal"] + $ressources[$planete[$i]+9]["deuterium"]) / 25000), 0, ',', $sep_mille)."</td>\n";
		for ($j=1;$j<=6;$j++) echo "\t\t<td class='".$row."'></td>\n";
		echo "\t</tr>\n";
	}
	if ($row == 'b') $row = 'f';
	else $row = 'b';
}
echo "\t<tr>\n\t\t<td class='c' colspan='2' style='text-align: center'><a>".$lang['ressources_total']."</a></td>\n";
echo "\t\t<td class='c' style='text-align: center' id='metal0'>".formate_number($ressources[0]["metal"], 0, ',', $sep_mille)."</td>\n";
echo "\t\t<td class='c' style='text-align: center' id='crystal0'>".formate_number($ressources[0]["crystal"], 0, ',', $sep_mille)."</td>\n";
echo "\t\t<td class='c' style='text-align: center' id='deuterium0'>".formate_number($ressources[0]["deuterium"], 0, ',', $sep_mille)."</td>\n";
echo "\t\t<td class='c' style='text-align: center' id='transport0'>".formate_number(ceil(($ressources[0]["metal"] + $ressources[0]["crystal"] + $ressources[0]["deuterium"]) / 25000), 0, ',', $sep_mille)."</td>\n";
echo "\t\t<td class='c' style='text-align: center'>".formate_number($production[0]["metal"], 0, ',', $sep_mille)."</td>\n";
echo "\t\t<td class='c' style='text-align: center'>".formate_number($production[0]["crystal"], 0, ',', $sep_mille)."</td>\n";
echo "\t\t<td class='c' style='text-align: center'>".formate_number($production[0]["deuterium"], 0, ',', $sep_mille)."</td>\n";
echo "\t\t<td class='c' style='text-align: center'>".formate_number($hangars[0]["metal"], 0, ',', $sep_mille)."</td>\n";
echo "\t\t<td class='c' style='text-align: center'>".formate_number($hangars[0]["crystal"], 0, ',', $sep_mille)."</td>\n";
echo "\t\t<td class='c' style='text-align: center'>".formate_number($hangars[0]["deuterium"], 0, ',', $sep_mille)."</td>\n";
echo "\t</tr>\n\t<tr>\n";
echo "\t\t<th colspan='2' style='text-align: center'><table style='border: none; border-spacing: 0px'><tr style='border: none'><td style='border: none'><select id='cache' style='width: 120px'>\n";
echo "\t\t\t<option value='-1' selected='selected' disabled='disabled'>".$lang['ressources_hidden_ressources']."</option>\n";
$i = 0;
foreach ($buildings as $value) {
	$dis = "";
	if ($i == 0 || $i == 19) $dis = " disabled='disabled'";
	if ($i < 35) echo "\t\t\t<option value='".$i++."'".$dis.">&nbsp;&nbsp;".$value."</option>\n";
}
?>
		</select></td><td style='border: none'><img style='cursor: pointer; vertical-align: middle' src='images/action_add.png' onClick='javascript: f_cache(-1)' title='<?php echo $lang['ressources_add_hidden'];?>' alt='+' /></tr></table></th>
		<th style='text-align: center' id='cache_metal'></th>
		<th style='text-align: center' id='cache_crystal'></th>
		<th style='text-align: center' id='cache_deuterium'></th>
		<th style='text-align: center' id='cache_transport'></th>
		<th colspan='4' style='text-align: center' id='cache_batiment'></th>
		<th colspan='2' rowspan='5' style='text-align: center; background: none; border: none'><input type='submit' name='save' value='<?php echo $lang['ressources_save'];?>' title='<?php echo $lang['ressources_save_erase'];?>' /></th>
	</tr>
	<tr>
		<th colspan='2' style='text-align: center'><table style='border: none; border-spacing: 0px'><tr style='border: none'><td style='border: none'><select id='echange' style='width: 120px'>
			<option value='-1' selected='selected' disabled='disabled'><?php echo $lang['ressources_trades'];?></option>
<?php
$i = 0;
foreach ($trades as $value) echo "\t\t\t<option value='".$i++."'".$dis.">&nbsp;&nbsp;".$value."</option>\n";
?>
		</select></td><td style='border: none'><img style='cursor: pointer; vertical-align: middle' src='images/action_add.png' onClick='javascript: f_echange(-1)' title='<?php echo $lang['ressources_add_trade'];?>' alt='+' /></tr></table></th>
		<th style='text-align: center' id='echange_metal'></th>
		<th style='text-align: center' id='echange_crystal'></th>
		<th style='text-align: center' id='echange_deuterium'></th>
		<th style='text-align: center' id='echange_transport'></th>
		<th colspan='4' style='text-align: center' id='echange_echange'></th>
	</tr>
	<tr>
		<td class='c' colspan='2' style='text-align: center'><a><?php echo $lang['ressources_total'];?></a></td>
		<td class='c' style='text-align: center' id='cache_metal_total'></td>
		<td class='c' style='text-align: center' id='cache_crystal_total'></td>
		<td class='c' style='text-align: center' id='cache_deuterium_total'></td>
		<td class='c' style='text-align: center' id='cache_transport_total'></td>
		<td class='c' colspan='4'></td>
	</tr>
	<tr>
		<th colspan='2' style='text-align: center'><table style='border: none; border-spacing: 0px'><tr style='border: none'><td style='border: none'><select id='construction' style='width: 120px'>
			<option value='-1' selected='selected' disabled='disabled'><?php echo $lang['ressources_constructions'];?></option>
<?php
$i = 0;
foreach ($buildings as $value) {
	$dis = "";
	if ($i == 0 || $i == 19 || $i == 35 || $i == 50) $dis = " disabled='disabled'";
	echo "\t\t\t<option value='".$i."'".$dis.">&nbsp;&nbsp;".$value."</option>\n";
	$i++;
}
?>
		</select></td><td style='border: none'><img style='cursor: pointer; vertical-align: middle' src='images/action_add.png' onClick='javascript: f_construction(-1)' title='<?php echo $lang['ressources_add_construction'];?>' alt='+' /></tr></table></th>
		<th style='text-align: center' id='construction_metal'></th>
		<th style='text-align: center' id='construction_crystal'></th>
		<th style='text-align: center' id='construction_deuterium'></th>
		<th style='text-align: center' id='construction_transport'></th>
		<th colspan='4' style='text-align: center' id='construction_batiment'></th>
	</tr>
	<tr>
		<td class='c' colspan='2' style='text-align: center'><a><?php echo $lang['ressources_total'];?></a></td>
		<td class='c' style='text-align: center'><span id='construction_metal_total'></span><br /><span id='metal_construction_total' title='<?php echo $lang['ressources_metal_construction'];?>'></span></td>
		<td class='c' style='text-align: center'><span id='construction_crystal_total'></span><br /><span id='crystal_construction_total' title='<?php echo $lang['ressources_crystal_construction'];?>'></span></td>
		<td class='c' style='text-align: center'><span id='construction_deuterium_total'></span><br /><span id='deuterium_construction_total' title='<?php echo $lang['ressources_deut_construction'];?>'></span></td>
		<td class='c' style='text-align: center' id='construction_transport_total'></td>
		<td class='c' colspan='4' id='construction_date'></td>
	</tr>
</table>
</form>
<br /><br />
<script language='javascript'>
<?php
// Chargement de la sauvegarde des ressources cachées
$query = "SELECT * FROM `".$table_prefix."mod_ressources_hide` WHERE user_id=".$user_data['user_id']." ORDER BY id ASC";
$quet = mysql_query($query);
$i = 0;
echo "ligne_batiment = ligne_metal = ligne_crystal = ligne_deuterium = '';\n";
while ($row = mysql_fetch_assoc($quet)) {
	echo "caches[".$i."] = Array(".$row['type'].", ".$row['level'].", 0);\n";
	echo "ligne_batiment += '<tr style=\"border: none\"><td style=\"border: none; height: 21px; text-align: left; white-space: nowrap\"><img style=\"cursor: pointer;vertical-align: middle;\" src=\"images/cross.png\" onClick=\"javascript: f_cache(".$i.")\" title=\"".$lang['ressources_delete']."\" alt=\"x\" />&nbsp;' + batiment_nom[caches[".$i."][0]] + '&nbsp;<input type=\"hidden\" name=\"cache_type".$i."\" value=\"' + caches[".$i."][0] + '\" /><input type=\"text\" id=\"cache_batiment".$i."\" name=\"cache_level".$i."\" size=\"2\" maxlength=\"2\" onBlur=\"javascript: f_cache()\" value=\"' + caches[".$i."][1] + '\" title=\"".$lang['ressources_level']."\" /></td><tr>';\n";
	echo "cache[0] += metal_batiment = Math.floor(batiment_metal[caches[".$i."][0]] * Math.pow(batiment_puis[caches[".$i."][0]],caches[".$i."][1]-1));\n";
	echo "ligne_metal += '<tr style=\"border: none\"><td style=\"border: none; height: 21px; text-align: center\">' + format(metal_batiment) + '</td></tr>';\n";
	echo "cache[1] += crystal_batiment = Math.floor(batiment_crystal[caches[".$i."][0]] * Math.pow(batiment_puis[caches[".$i."][0]],caches[".$i."][1]-1));\n";
	echo "ligne_crystal += '<tr style=\"border: none\"><td style=\"border: none; height: 21px; text-align: center\">' + format(crystal_batiment) + '</td></tr>';\n";
	echo "cache[2] += deuterium_batiment = Math.floor(batiment_deuterium[caches[".$i."][0]] * Math.pow(batiment_puis[caches[".$i."][0]],caches[".$i."][1]-1));\n";
	echo "ligne_deuterium += '<tr style=\"border: none\"><td style=\"border: none; height: 21px; text-align: center\">' + format(deuterium_batiment) + '</td></tr>';\n";
	echo "document.getElementById('cache_batiment').innerHTML = '<table style=\"border: none; width: 100%; border-spacing: 0px\">' + ligne_batiment + '</table>';\n";
	echo "caches[".$i."][2] = metal_batiment + crystal_batiment + deuterium_batiment;\n";
}
echo "document.getElementById('cache_metal').innerHTML = '<table style=\"border: none; width: 100%; border-spacing: 0px\">' + ligne_metal + '</table>';\n";
echo "document.getElementById('cache_crystal').innerHTML = '<table style=\"border: none; width: 100%; border-spacing: 0px\">' + ligne_crystal + '</table>';\n";
echo "document.getElementById('cache_deuterium').innerHTML = '<table style=\"border: none; width: 100%; border-spacing: 0px\">' + ligne_deuterium + '</table>';\n";
// Chargemennt de la sauvegarde des échanges
$query = "SELECT * FROM `".$table_prefix."mod_ressources_trade` WHERE user_id=".$user_data['user_id']." ORDER BY id ASC";
$quet = mysql_query($query);
$i = 0;
echo "ligne_echange = ligne_metal = ligne_crystal = ligne_deuterium = '';\n";
while ($row = mysql_fetch_assoc($quet)) {
	echo "echanges[".$i."] = Array(".$row['type'].", ".$row['metal'].", ".$row['crystal'].", ".$row['deuterium'].", ".$row['metal_rate'].", ".$row['crystal_rate'].", ".$row['deuterium_rate'].");\n";
	echo "ligne_echange += '<tr style=\"border: none\"><td style=\"border: none; height: 21px; text-align: left; white-space: nowrap\"><img style=\"cursor: pointer;vertical-align: middle;\" src=\"images/cross.png\" onClick=\"javascript: f_echange(".$i.")\" title=\"".$lang['ressources_delete']."\" alt=\"x\" />&nbsp;' + echange_nom[echanges[".$i."][0]] + '<input type=\"hidden\" name=\"echange_type".$i."\" value=\"' + echanges[".$i."][0] + '\" />';\n";
	echo "if (echanges[".$i."][0] != 3) ligne_echange += '&nbsp;<input type=\"text\" id=\"echange_metal_r".$i."\" name=\"echange_metal_r".$i."\" size=\"3\" maxlength=\"3\" onBlur=\"javascript: echange_calcul(".$i.",' + echanges[".$i."][0] + ')\" value=\"' + echanges[".$i."][4] + '\" title=\"".$lang['ressources_metal_ratio']."\" />&nbsp;<input type=\"text\" id=\"echange_crystal_r".$i."\" name=\"echange_crystal_r".$i."\" size=\"3\" maxlength=\"3\" onBlur=\"javascript: echange_calcul(".$i.",' + echanges[".$i."][0] + ')\" value=\"' + echanges[".$i."][5] + '\" title=\"".$lang['ressources_crystal_ratio']."\" />&nbsp;<input type=\"text\" id=\"echange_deuterium_r".$i."\" name=\"echange_deuterium_r".$i."\" size=\"3\" maxlength=\"3\" onBlur=\"javascript: echange_calcul(".$i.",' + echanges[".$i."][0] + ')\" value=\"' + echanges[".$i."][6] + '\" title=\"".$lang['ressources_deut_ratio']."\" />';\n";
	echo "else ligne_echange += '<input type=\"hidden\" name=\"echange_metal_r".$i."\" value=\"0\" /><input type=\"hidden\" name=\"echange_crystal_r".$i."\" value=\"0\" /><input type=\"hidden\" name=\"echange_deuterium_r".$i."\" value=\"0\" />';\n";
	echo "ligne_echange += '</td><tr>';\n";
	echo "if (echanges[".$i."][0] == 0) ligne_metal += '<tr style=\"border: none\"><td style=\"border: none; height: 21px; text-align: center\"><span id=\"echange_metal".$i."\">' + format(echanges[".$i."][1]) + '</span><input type=\"hidden\" id=\"echange_metal_hidden".$i."\" name=\"echange_metal".$i."\" value=\"' + echanges[".$i."][1] + '\" /></td></tr>';\n";
	echo "else ligne_metal += '<tr style=\"border: none\"><td style=\"border: none; height: 21px; text-align: center\"><input type=\"text\" id=\"echange_metal".$i."\" name=\"echange_metal".$i."\" size=\"10\" maxlength=\"10\" onBlur=\"javascript: echange_calcul(".$i.",' + echanges[".$i."][0] + ')\" value=\"' + echanges[".$i."][1] + '\" /></td></tr>';\n";
	echo "if (echanges[".$i."][0] == 1) ligne_crystal += '<tr style=\"border: none\"><td style=\"border: none; height: 21px; text-align: center\"><span id=\"echange_crystal".$i."\">' + format(echanges[".$i."][2]) + '</span><input type=\"hidden\" id=\"echange_crystal_hidden".$i."\" name=\"echange_crystal".$i."\" value=\"' + echanges[".$i."][2] + '\" /></td></tr>';\n";
	echo "else ligne_crystal += '<tr style=\"border: none\"><td style=\"border: none; height: 21px; text-align: center\"><input type=\"text\" id=\"echange_crystal".$i."\" name=\"echange_crystal".$i."\" size=\"10\" maxlength=\"10\" onBlur=\"javascript: echange_calcul(".$i.",' + echanges[".$i."][0] + ')\" value=\"' + echanges[".$i."][2] + '\" /></td></tr>';\n";
	echo "if (echanges[".$i."][0] == 2) ligne_deuterium += '<tr style=\"border: none\"><td style=\"border: none; height: 21px; text-align: center\"><span id=\"echange_deuterium".$i."\">' + format(echanges[".$i."][3]) + '</span><input type=\"hidden\" id=\"echange_deuterium_hidden".$i."\" name=\"echange_deuterium".$i."\" value=\"' + echanges[".$i."][3] + '\" /></td></tr>';\n";
	echo "else ligne_deuterium += '<tr style=\"border: none\"><td style=\"border: none; height: 21px; text-align: center\"><input type=\"text\" id=\"echange_deuterium".$i."\" name=\"echange_deuterium".$i."\" size=\"10\" maxlength=\"10\" onBlur=\"javascript: echange_calcul(".$i.",' + echanges[".$i."][0] + ')\" value=\"' + echanges[".$i."][3] + '\" /></td></tr>';\n";
	echo "echange[0] += echanges[".$i."][1];\n";
	echo "echange[1] += echanges[".$i."][2];\n";
	echo "echange[2] += echanges[".$i++."][3];\n";
}
echo "document.getElementById('echange_echange').innerHTML = '<table style=\"border: none; width: 100%; border-spacing: 0px\">' + ligne_echange + '</table>';\n";
echo "document.getElementById('echange_metal').innerHTML = '<table style=\"border: none; width: 100%; border-spacing: 0px\">' + ligne_metal + '</table>';\n";
echo "document.getElementById('echange_crystal').innerHTML = '<table style=\"border: none; width: 100%; border-spacing: 0px\">' + ligne_crystal + '</table>';\n";
echo "document.getElementById('echange_deuterium').innerHTML = '<table style=\"border: none; width: 100%; border-spacing: 0px\">' + ligne_deuterium + '</table>';\n";
echo "if (caches.length + echanges.length > 0) {\n";
echo "\tdocument.getElementById('cache_metal_total').innerHTML = format(ressource[0][0] + cache[0] + echange[0]);\n";
echo "\tdocument.getElementById('cache_crystal_total').innerHTML = format(ressource[0][1] + cache[1] + echange[1]);\n";
echo "\tdocument.getElementById('cache_deuterium_total').innerHTML = format(ressource[0][2] + cache[2] + echange[2]);\n";
echo "}\n";
// Chargement de la sauvegarde des constructions
$query = "SELECT * FROM `".$table_prefix."mod_ressources_construction` WHERE user_id=".$user_data['user_id']." ORDER BY id ASC";
$quet = mysql_query($query);
$i = 0;
echo "ligne_batiment = ligne_metal = ligne_crystal = ligne_deuterium = '';\n";
while ($row = mysql_fetch_assoc($quet)) {
	echo "constructions[".$i."] = Array(".$row['type'].", ".$row['level'].");\n";
	echo "title = '".$lang['ressources_level']."';\nmaxi = 2;\n";
	echo "if (constructions[".$i."][0] > 35) {\n\ttitle = '".$lang['ressources_quantity']."';\n\tmaxi = 6;\n}\n";
	echo "ligne_batiment += '<tr style=\"border: none\"><td style=\"border: none; height: 21px; text-align: left; white-space: nowrap\"><img style=\"cursor: pointer;vertical-align: middle;\" src=\"images/cross.png\" onClick=\"javascript: f_construction (".$i.")\" title=\"".$lang['ressources_delete']."\" alt=\"x\" />&nbsp;' + batiment_nom[constructions[".$i."][0]] + '&nbsp;<input type=\"hidden\" name=\"construction_type".$i."\" value=\"' + constructions[".$i."][0] + '\" /><input type=\"text\" id=\"construction_batiment".$i."\" name=\"construction_level".$i."\" size=\"' + maxi + '\" maxlength=\"' + maxi + '\" onBlur=\"javascript: f_construction ()\" value=\"' + constructions[".$i."][1] + '\" title=\"'+ title + '\" /></td><tr>';\n";
	echo "if (constructions[".$i."][0] < 35) {\n";
	echo "\tconstruction[0] += metal_batiment = - Math.floor(batiment_metal[constructions[".$i."][0]] * Math.pow(batiment_puis[constructions[".$i."][0]],constructions[".$i."][1]-1));\n";
	echo "\tconstruction[1] += crystal_batiment = - Math.floor(batiment_crystal[constructions[".$i."][0]] * Math.pow(batiment_puis[constructions[".$i."][0]],constructions[".$i."][1]-1));\n";
	echo "\tconstruction[2] += deuterium_batiment = - Math.floor(batiment_deuterium[constructions[".$i."][0]] * Math.pow(batiment_puis[constructions[".$i."][0]],constructions[".$i."][1]-1));\n";
	echo "} else {\n";
	echo "\tconstruction[0] += metal_batiment = - Math.floor(batiment_metal[constructions[".$i."][0]] * constructions[".$i."][1]);\n";
	echo "\tconstruction[1] += crystal_batiment = - Math.floor(batiment_crystal[constructions[".$i."][0]] * constructions[".$i."][1]);\n";
	echo "\tconstruction[2] += deuterium_batiment = - Math.floor(batiment_deuterium[constructions[".$i."][0]] * constructions[".$i."][1]);\n";
	echo "}\n";
	echo "ligne_metal += '<tr style=\"border: none\"><td style=\"border: none; height: 21px; text-align: center\">' + format(metal_batiment) + '</td></tr>';\n";
	echo "ligne_crystal += '<tr style=\"border: none\"><td style=\"border: none; height: 21px; text-align: center\">' + format(crystal_batiment) + '</td></tr>';\n";
	echo "ligne_deuterium += '<tr style=\"border: none\"><td style=\"border: none; height: 21px; text-align: center\">' + format(deuterium_batiment) + '</td></tr>';\n";
	echo "constructions[".$i++."][2] = - metal_batiment - crystal_batiment - deuterium_batiment;\n";
}
?>
document.getElementById('construction_batiment').innerHTML = '<table style=\"border: none; width: 100%; border-spacing: 0px\">' + ligne_batiment + '</table>';
document.getElementById('construction_metal').innerHTML = '<table style=\"border: none; width: 100%; border-spacing: 0px\">' + ligne_metal + '</table>';
document.getElementById('construction_crystal').innerHTML = '<table style=\"border: none; width: 100%; border-spacing: 0px\">' + ligne_crystal + '</table>';
document.getElementById('construction_deuterium').innerHTML = '<table style=\"border: none; width: 100%; border-spacing: 0px\">' + ligne_deuterium + '</table>';
for (i=0;i<constructions.length;i++) document.getElementById('construction_batiment' + i).value = constructions[i][1];
compteur();
if (constructions.length > 0) {
	document.getElementById('construction_metal_total').innerHTML = format(ressource[0][0] + cache[0] + echange[0] + construction[0]);
	document.getElementById('construction_crystal_total').innerHTML = format(ressource[0][1] + cache[1] + echange[1] + construction[1]);
	document.getElementById('construction_deuterium_total').innerHTML = format(ressource[0][2] + cache[2] + echange[2] + construction[2]);
	f_construction();
}
</script>
