<?
/***************************************************************************
*	filename	: recherche.php
*	version		: 0.5
*	desc.			: Calcul des points à partir des rapports d'espionnages et déduction de la flotte.
*	Authors		: Scaler - http://ogsteam.fr
*	created		: 12:56 01/11/2007
*	modified	: 14:03 08/01/2010
***************************************************************************/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");
$error = 0;
$error2 = Array(0,0,0);
require_once("includes/ogame.php");

// Fonction de filtrage des caracteres 'sensibles' pour les requetes mysql
function sql_filter($in) {
	return mysql_real_escape_string(str_replace(array(';','(',')',chr(39),'"','`','|'),'',$in));
}
$search = FALSE; $target = 'player';
if (isset($pub_target)) $target = sql_filter($pub_target);
if (isset($pub_pandoresearch)) $search = sql_filter($pub_pandoresearch);

$points_flotte = array("PT"=>4, "GT"=>12, "CLE"=>4, "CLO"=>10, "CR"=>29, "VB"=>60, "VC"=>40, "REC"=>18, "SE"=>1, "BMD"=>90, "SAT"=>2.5, "DST"=>125, "EDLM"=>10000, "TRA"=>85);
$flotte = array("PT"=>0, "GT"=>0, "CLE"=>0, "CLO"=>0, "CR"=>0, "VB"=>0, "VC"=>0, "REC"=>0, "SE"=>0, "BMD"=>0, "SAT"=>0, "DST"=>0, "EDLM"=>0, "TRA"=>0);
$points_building = array("M"=>75, "C"=>72, "D"=>300, "CES"=>105, "CEF"=>1440, "UdR"=>720, "UdN"=>1600000, "CSp"=>700, "HM"=>1000, "HC"=>1500, "HD"=>2000, "Lab"=>800, "Ter"=>150000, "Silo"=>41000, "BaLu"=>80000, "Pha"=>80000, "PoSa"=>8000000, "DdR"=>60000);
$puissance_building = array("M"=>1.5, "C"=>1.6, "D"=>1.5, "CES"=>1.5, "CEF"=>1.8, "UdR"=>2, "UdN"=>2, "CSp"=>2, "HM"=>2, "HC"=>2, "HD"=>2, "Lab"=>2, "Ter"=>2, "Silo"=>2, "BaLu"=>2, "Pha"=>2, "PoSa"=>2, "DdR"=>2);
$points_defence = array("LM"=>2, "LLE"=>2, "LLO"=>8, "CG"=>37, "AI"=>8, "LP"=>130, "PB"=>20, "GB"=>100, "MIC"=>10, "MIP"=>25);
$points_technology = array("Esp"=>1.4, "Ordi"=>1, "Armes"=>1, "Bouclier"=>.8, "Protection"=>1, "NRJ"=>1.2, "Hyp"=>6, "RC"=>1, "RI"=>6.6, "PH"=>36, "Laser"=>.3, "Ions"=>1.4, "Plasma"=>7, "RRI"=>800, "Astrophysique"=>16, "Graviton"=>0);
$puissance_technology = array("Esp"=>2, "Ordi"=>2, "Armes"=>2, "Bouclier"=>2, "Protection"=>2, "NRJ"=>2, "Hyp"=>2, "RC"=>2, "RI"=>2, "PH"=>2, "Laser"=>2, "Ions"=>2, "Plasma"=>2, "RRI"=>2, "Astrophysique"=>1.75, "Graviton"=>0);
$technologies = array("Esp"=>0, "Ordi"=>0, "Armes"=>0, "Bouclier"=>0, "Protection"=>0, "NRJ"=>0, "Hyp"=>0, "RC"=>0, "RI"=>0, "PH"=>0, "Laser"=>0, "Ions"=>0, "Plasma"=>0, "RRI"=>0, "Astrophysique"=>0, "Graviton"=>0);
$techno_necessaires = array("PT"=>array("RC"=>2), "GT"=>array("RC"=>6), "CLE"=>array("RC"=>1), "CLO"=>array("Protection"=>2, "RI"=>2), "CR"=>array("RI"=>4, "Ions"=>2), "VB"=>array("PH"=>4), "VC"=>array("RI"=>3), "REC"=>array("RC"=>6, "Bouclier"=>2), "SE"=>array("Esp"=>2, "RC"=>3), "BMD"=>array("RI"=>6, "Plasma"=>5), "DST"=>array("Hyp"=>5, "PH"=>6), "EDLM"=>array("Hyp"=>6, "PH"=>7, "Graviton"=>1), "TRA"=>array("Hyp"=>5, "PH"=>5, "Laser"=>12));
$points = array("flottes"=>0, "batiments"=>0, "defenses"=>0, "recherches"=>0);

$sep_mille = $lang['pandore_thousands_separator'];
$date_format = $lang['pandore_date_format'];

// Recherche de la simulation enregistrée
if (isset($pub_id)) {
	$pub_id = sql_filter($pub_id);
	$simulation = mysql_fetch_assoc(mysql_query("SELECT joueur, points_general, points_flotte, points_recherches, PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, SAT, DST, EDLM, TRA, flottes, flottes_manquantes, user_name FROM `".$table_prefix."mod_pandore` WHERE id = '".$pub_id."'"));
	$search = $simulation['joueur'];
}

// Recherche du nom du joueur dans le cas d'une recherche de coordonnées
$coordonnees = Array();
if (count(explode(":",$search)) == 3) $target = 'coord';
if ($search) $nom = $search;
if ($search && $target == 'coord') {
	$coord = explode(":",$search);
	if (count($coord) != 3) $error = 4;
	else {
		$res = mysql_fetch_assoc(mysql_query("SELECT player FROM ".TABLE_UNIVERSE." WHERE galaxy = '".$coord[0]."' AND system = '".$coord[1]."' AND row = '".$coord[2]."'"));
		if (!$res || $res["player"]=="") $error = 3;
		$nom = $res["player"];
	}
}

// Recherche des planètes du joueur
if ($search && ($error == 0 || $error == 4)) {
	$res = mysql_query("SELECT galaxy, system, row, name, moon FROM ".TABLE_UNIVERSE." WHERE player = '".$nom."' ORDER BY galaxy ASC, system ASC, row ASC");
	while ($coords = mysql_fetch_assoc($res)) {
		$coords["moon"] == 0 ? $coords["moon"] = FALSE : $coords["moon"] = $lang['pandore_moon'];
		$coordonnees[] = Array ($coords["galaxy"].':'.$coords["system"].':'.$coords["row"],$coords["name"],0,$coords["moon"],0);
	}
	if ($error != 4) {
		if (count($coordonnees) == 0) $error = 2;
		//if (count($coordonnees) > $planet_max) $error = 1;
	} elseif (count($coordonnees) > 0) {
		$error = 0;
		$target = 'player';
	}
}

// Recherche des rapports d'espionnages sur les planètes
$espionnage = -1;
if ($search && $error == 0) {
	$rapport_date_min = time();
	for ($i = 0; $i < count($coordonnees); $i++) {
		$res = mysql_query("SELECT * FROM ".TABLE_PARSEDSPY." WHERE coordinates = '".$coordonnees[$i][0]."' ORDER BY dateRE ASC");
		while ($rapport = mysql_fetch_assoc($res)) {
			$d = 0;
			$j = $i;
			if ($rapport['M'] <= 0 && $rapport['C'] <= 0 && $rapport['D'] <= 0 && $rapport['CES'] <= 0 && $rapport['CEF'] <= 0 && $rapport['UdN'] <= 0 && $rapport['Lab'] <= 0 && $rapport['Ter'] <= 0 && $rapport['Silo'] <= 0) $j += count($coordonnees);
			$coordonnees[$i][5] = $rapport['PoSa'];
			foreach ($rapport as $key => $value) {
				if ($value != -1 && $key != 'dateRE') $rapports[$j][$key] = $value;
				elseif ($value == -1 && $key != 'dateRE') {
					$rapports[$j][$key] = 0;
					if ($key != 'activite' && $key != 'Esp' && $key != 'Ordi' && $key != 'Armes' && $key != 'Bouclier' && $key != 'Protection' && $key != 'NRJ' && $key != 'Hyp' && $key != 'RC' && $key != 'RI' && $key != 'PH' && $key != 'Laser' && $key != 'Ions' && $key != 'Plasma' && $key != 'RRI' && $key != 'Graviton' && $key != 'Astrophysique') $d = 1;
				}
				if ($key == 'Esp') $espionnage = max($value, $espionnage);
			}
			if ($d == 0) $rapports[$j]["dateRE"] = $rapport["dateRE"];
			else {
				$rapports[$j]["dateRE"] = 1;
				$error2[2] = 1;
			}
		}
		(isset($rapports) && isset($rapports[$i])) ? $coordonnees[$i][2] = $rapports[$i]["dateRE"] : $error2[1] = 1;
		if ($coordonnees[$i][3]) {
			if (isset($rapports[$i + count($coordonnees)]["planet_name"])) {
				$coordonnees[$i][3] = $rapports[$i + count($coordonnees)]["planet_name"];
				$coordonnees[$i][4] = $rapports[$i + count($coordonnees)]["dateRE"];
			} else $error2[1] = 1;
		}
		$rapport_date_min = min($rapport_date_min, $coordonnees[$i][2]);
		if ($coordonnees[$i][3]) $rapport_date_min = min($rapport_date_min, $coordonnees[$i][4]);
	}
}

// Recherche des classements du joueur
if ($search && $error == 0) {
	$class_gene = mysql_fetch_assoc(mysql_query("SELECT datadate, points, rank FROM ".TABLE_RANK_PLAYER_POINTS." WHERE player = '".$nom."' ORDER BY datadate DESC LIMIT 1"));
	$class_flotte = mysql_fetch_assoc(mysql_query("SELECT datadate, points, rank FROM ".TABLE_RANK_PLAYER_FLEET." WHERE player = '".$nom."' ORDER BY datadate DESC LIMIT 1"));
	$class_techno = mysql_fetch_assoc(mysql_query("SELECT datadate, points, rank FROM ".TABLE_RANK_PLAYER_RESEARCH." WHERE player = '".$nom."' ORDER BY datadate DESC LIMIT 1"));
	if (!$class_gene || !$class_flotte || !$class_techno) $error2[0] = 1;
}
if (isset($class_gene) && $class_gene) {
	$class_gene["date"] = date($date_format,$class_gene["datadate"]);
	$r_pt = max(min(255, round((time() - $class_gene["datadate"] - 86400) / 2033)), 0);
} else {
	$class_gene["points"] = 0;
	$class_gene["rank"] = 0;
	$class_gene["date"] = FALSE;
	$r_pt = 255;
}
if (isset($class_techno) && $class_techno) {
	$class_techno["date"] = date($date_format,$class_techno["datadate"]);
	$r_t = max(min(255, round((time() - $class_techno["datadate"] - 86400) / 2033)), 0);
} else {
	$class_techno["points"] = 0;
	$class_techno["rank"] = 0;
	$class_techno["date"] = FALSE;
	$r_t = 255;
}
if (isset($class_flotte) && $class_flotte) {
	$class_flotte["date"] = date($date_format,$class_flotte["datadate"]);
	$r_f = max(min(255, round((time() - $class_flotte["datadate"] - 86400) / 2033)), 0);
} else {
	$class_flotte["points"] = 0;
	$class_flotte["rank"] = 0;
	$class_flotte["date"] = FALSE;
	$r_f = 255;
}

// Calcul du nombre de flottes et des points flottes, bâtiments, défenses
if ($search && $error == 0 && isset($rapports)) {
	foreach ($rapports as $re) {
		foreach ($points_flotte as $key => $value) {
			if ($re[$key] > 0) {
				$flotte[$key] += $re[$key];
				$points["flottes"] += $re[$key] * $points_flotte[$key];
			}
		}
		foreach ($points_building as $key => $value) {
			if ($re[$key] > 0) $points["batiments"] += floor($points_building[$key] * (1 - pow($puissance_building[$key], $re[$key])) / ((1 - $puissance_building[$key]) * 1000));
		}
		foreach ($points_defence as $key => $value) {
			if ($re[$key] > 0) $points["defenses"] += $points_defence[$key] * $re[$key];
		}
	}
}

// Calcul du nombre de recherches et des points recherches
if ($search && $error == 0 && isset($rapports)) {
	foreach ($points_technology as $key => $value) {
		foreach ($rapports as $re) $technologies[$key] = max($re[$key], $technologies[$key]);
		$points["recherches"] += floor($points_technology[$key] * (1 - pow($puissance_technology[$key], $technologies[$key])) / (1 - $puissance_technology[$key]));
		if ($key == "Astrophysique")
			$planet_max= 1 + round($technologies[$key]/2);
	}
}

// Calcul des points manquants
if ($search && $error == 0) $points_manquants = $class_gene["points"] - $points["batiments"] - $points["defenses"] - $points["recherches"] - $points["flottes"];

// Flottes constructibles
if ($search && $error == 0) {
	foreach ($techno_necessaires as $key => $value) {
		$flotte_const[$key] = 1;
		foreach ($value as $key2 => $value2) {
			if ($technologies[$key2] < $value2) $flotte_const[$key] = 0;
		}
	}
	$flotte_const['SAT'] = 0;
}

// Calcul du nombre de sondes necessaires
if ($search && $error == 0) {
	$user_empire = user_get_empire();
	$user_empire["technology"] ? $user_technology = $user_empire["technology"] : $espionnage = -1;
	if ($espionnage == -1) {
		$nb_sondes[0] = $nb_sondes[1] = 'inconnu';
	} else {
		$N = $espionnage - $user_technology['NRJ'];
		$nb_sondes[1] = 5 + pow($N, 2);
		if ($N < 0) $nb_sondes[1] = max(1, 9 + 3 * $N);
		$nb_sondes[0] = max(1, $nb_sondes[1] - 2);
	}
}

// Javascript pour l'estimation
echo "<script type='text/javascript'>\n";
echo "function search_focus () {\n\tdocument.getElementById('pandoresearch').focus();\n}\n";
if ($search && $error == 0) :
?>
valeur_flotte = new Array();
techno_necessaires = new Array();
technologies = new Array();
flotte_const = new Array();
flottes = new Array();
nom_flotte = new Array();
ordre_flotte = new Array(8, 10, 0, 2, 3, 1, 7, 4, 6, 5, 13, 9, 11, 12);
flotte_ordre = new Array(2, 5, 3, 4, 7, 9, 8, 6, 0, 11, 1,12, 13, 10);
<?php
$i = -1;
foreach ($points_flotte as $key => $value) {
	echo "valeur_flotte[".++$i."] = ".$points_flotte[$key].";\n";
	echo "flottes[".$i."] = ".$flotte[$key].";\n";
	echo "nom_flotte[".$i."] = '".$key."';\n";
	$j = -1;
	echo "techno_necessaires[".$i."] = new Array();\n";
	foreach ($points_technology as $key2 => $value2) {
		if (isset($techno_necessaires[$key][$key2]) && $techno_necessaires[$key][$key2] > 0) echo "techno_necessaires[".$i."][".++$j."] = ".$techno_necessaires[$key][$key2].";\n";
		else echo "techno_necessaires[".$i."][".++$j."] = 0;\n";
	}
}
$i = 0;
foreach ($technologies as $key => $value) echo "technologies[".$i++."] = ".$value.";\n";
echo "r_pt = ".$r_pt.";\n";
echo "r_t = ".$r_t.";\n";
echo "class_gene = new Array('".$class_gene['date']."', ".$class_gene['points'].");\n";
echo "class_techno = new Array('".$class_techno['date']."', ".$class_techno['points'].");\n";
echo "class_vaisseaux = new Array('".$class_flotte['date']."', ".$class_flotte['points'].");\n";
echo "points = new Array(".$points["batiments"].", ".$points["defenses"].", ".$points["recherches"].", ".($class_gene["points"] - $points["batiments"] - $points["defenses"] - $points["recherches"]).");\n";
echo "techno = ".array_sum($technologies).";";
?>

// Affichage des technologies
function ouverture() (document.getElementById('menu_technologies').style.display == 'block') ? document.getElementById('menu_technologies').style.display = 'none' : document.getElementById('menu_technologies').style.display = 'block';

// Réinitialisation des valeurs
function init() {
document.getElementById('points_recherches').value = points[2];
<?php foreach ($points_technology as $key => $value) echo "document.getElementById('".$key."').value = ".$technologies[$key].";\n";?>
nombre_recherches = techno;
calculs(3);
}
function init_points_general() {
document.getElementById('points_general').value = class_gene[1];
calculs(0);
}
function init_points_batiments() {
document.getElementById('points_batiments').value = points[0];
calculs(0);
}
function init_points_defenses() {
document.getElementById('points_defenses').value = points[1];
calculs(0);
}
function init_points_recherches() {
document.getElementById('points_recherches').value = points[2];
<?php foreach ($points_technology as $key => $value) echo "document.getElementById('".$key."').value = ".$technologies[$key].";\n";?>
nombre_recherches = techno;
calculs(0);
}
function init_points_vaisseaux() {
document.getElementById('points_flotte').value = class_gene[2] - points_batiments - points_defenses - points_recherches;
calculs();
}
function init_nombre_flotte() {
document.getElementById('nombre_flotte').value = class_vaisseaux[1];
calculs();
}

// Calcul des points
function calculs(type) {
if (isNaN(parseFloat(document.getElementById('points_general').value)) || parseFloat(document.getElementById('points_general').value) < 0) document.getElementById('points_general').value = class_gene[1];
class_gene[2] = parseFloat(document.getElementById('points_general').value);
if (isNaN(parseFloat(document.getElementById('points_batiments').value)) || parseFloat(document.getElementById('points_batiments').value) < 0) document.getElementById('points_batiments').value = points[0];
points_batiments = parseFloat(document.getElementById('points_batiments').value);
if (isNaN(parseFloat(document.getElementById('points_defenses').value)) || parseFloat(document.getElementById('points_defenses').value) < 0) document.getElementById('points_defenses').value = points[1];
points_defenses = parseFloat(document.getElementById('points_defenses').value);
if (isNaN(parseFloat(document.getElementById('points_recherches').value)) || parseFloat(document.getElementById('points_recherches').value) < 0) document.getElementById('points_recherches').value = points[2];
points_recherches = parseFloat(document.getElementById('points_recherches').value);
if (isNaN(parseFloat(document.getElementById('points_flotte').value)) || parseFloat(document.getElementById('points_flotte').value) < 0) document.getElementById('points_flotte').value = points[3];
points_flotte = parseFloat(document.getElementById('points_flotte').value);
if (isNaN(parseFloat(document.getElementById('nombre_flotte').value)) || parseFloat(document.getElementById('nombre_flotte').value) < 0) document.getElementById('nombre_flotte').value = class_vaisseaux[1];
nombre_flotte = parseFloat(document.getElementById('nombre_flotte').value);
if (type == 2) {
	points_recherches = 0;
	nombre_recherches = 0;
}
type_techno = 0;
<?php
$i = 0;
foreach ($technologies as $key => $value) {
	echo "if (isNaN(parseFloat(document.getElementById('".$key."').value)) || parseFloat(document.getElementById('".$key."').value) < 0) document.getElementById('".$key."').value = ".$value.";\n";
	echo $key." = parseFloat(document.getElementById('".$key."').value);\ntechnologies[".$i++."] = ".$key.";\n";
	echo "if (type == 2) {\n\tpoints_recherches += Math.floor(".$points_technology[$key]." * (1 - Math.pow(".$puissance_technology[$key].", ".$key.")) / (1 - ".$puissance_technology[$key]."));\n\tnombre_recherches += ".$key.";\n}\n";
	echo "if (".$key." != ".$value.") type_techno = 1;\n";
}
?>
document.getElementById('points_recherches').value = points_recherches;
if (type < 3) points_flotte = class_gene[2] - points_batiments - points_defenses - points_recherches;
document.getElementById('points_flotte').value = points_flotte;
document.getElementById('nombre_flotte').value = nombre_flotte;
total_points = 0;
total_flottes = 0;
for (i=0;i<valeur_flotte.length;i++) {
	flotte_const[i] = 1;
	for (j=0;j<technologies.length && flotte_const[i]!=0;j++) {
		if (technologies[j] < techno_necessaires[i][j]) flotte_const[i] = 0;
	}
	if (isNaN(parseFloat(document.getElementById(nom_flotte[i]).value)) || parseFloat(document.getElementById(nom_flotte[i]).value) < 0) document.getElementById(nom_flotte[i]).value = flottes[i];
	flottes[i] = parseFloat(document.getElementById(nom_flotte[i]).value);
	total_flottes += flottes[i];
	total_points += flottes[i] * valeur_flotte[i];
}
flotte_const[10] = 0;
i = 0;
debut_flotte = 0;
fin_flotte = 13;
while (!flotte_const[ordre_flotte[i]] && debut_flotte < 13) {
	debut_flotte = ++i;
}
i = 13;
while (!flotte_const[ordre_flotte[i]] && fin_flotte > debut_flotte) {
	fin_flotte = --i;
}
points_manquants = points_flotte - total_points;
flottes_manquantes = nombre_flotte - total_flottes;
for (i=0;i<valeur_flotte.length;i++) {
	if (flotte_ordre[i] <= debut_flotte) maximum = flottes[i] + Math.max(0, Math.min(flottes_manquantes, Math.max(0, Math.floor((flottes_manquantes * valeur_flotte[ordre_flotte[fin_flotte]] - points_manquants) / (valeur_flotte[ordre_flotte[fin_flotte]] - valeur_flotte[i])))));
	else if (flotte_ordre[i] >= fin_flotte) maximum = flottes[i] + Math.max(0, Math.min(flottes_manquantes, Math.max(0, Math.floor((points_manquants - flottes_manquantes * valeur_flotte[ordre_flotte[debut_flotte]]) / (valeur_flotte[i] - valeur_flotte[ordre_flotte[debut_flotte]])))));
	else maximum = flottes[i] + Math.max(0, Math.min(flottes_manquantes, Math.floor(Math.min((flottes_manquantes * valeur_flotte[ordre_flotte[fin_flotte]] - points_manquants) / (valeur_flotte[ordre_flotte[fin_flotte]] - valeur_flotte[i]), (points_manquants - flottes_manquantes * valeur_flotte[ordre_flotte[debut_flotte]]) / (valeur_flotte[i] - valeur_flotte[ordre_flotte[debut_flotte]])))));
	if (flotte_const[i] == 0) {
		maximum = 0;
		if (i == 10) maximum = flottes[10];
		(navigator.appName == 'Netscape') ? document.getElementById(nom_flotte[i]).style.MozOpacity = .25 : document.getElementById(nom_flotte[i]).filters.alpha.opacity = 25;
	} else (navigator.appName == 'Netscape') ? document.getElementById(nom_flotte[i]).style.MozOpacity = 1 : document.getElementById(nom_flotte[i]).filters.alpha.opacity = 100;
	document.getElementById('max_' + nom_flotte[i]).innerHTML = format(maximum);
	document.getElementById(nom_flotte[i]).value = flottes[i];
}
if (class_gene[2] == class_gene[1]) {
	(class_gene[0]) ? document.getElementById('class_general').innerHTML = '<?php echo $lang['pandore_points_rank_of']; ?> <font title="<?php echo $lang['pandore_update_date']; ?>" style="color: rgb(' + String(r_pt) + ', ' + String(255 - r_pt) + ',0);">' + String(class_gene[0]) + '</font>' : document.getElementById('class_general').innerHTML = '<?php echo sprintf($lang['pandore_points_rank_unavailable'],'<font style="color: red;">','</font>'); ?>';
	document.getElementById('nom_general').innerHTML = '<?php echo $lang['pandore_points_total']; ?>';
} else {
	document.getElementById('class_general').innerHTML = '<?php echo $lang['pandore_custom_points_total']; ?>';
	document.getElementById('nom_general').innerHTML = '<a><div title="<?php echo $lang['pandore_reset_points_total']; ?>" style="cursor: pointer;"><?php echo $lang['pandore_points_total']; ?></div></a>';
}
(points_batiments != points[0]) ? document.getElementById('nom_batiments').innerHTML = '<a><div title="<?php echo $lang['pandore_reset_buildings_points']; ?>" style="cursor: pointer;"><?php echo $lang['pandore_buildings_points']; ?></div></a>' : document.getElementById('nom_batiments').innerHTML = '<?php echo $lang['pandore_buildings_points']; ?>';
(points_defenses != points[1]) ? document.getElementById('nom_defenses').innerHTML = '<a><div title="<?php echo $lang['pandore_reset_defenses_points']; ?>" style="cursor: pointer;"><?php echo $lang['pandore_defenses_points']; ?></div></a>' : document.getElementById('nom_defenses').innerHTML = '<?php echo $lang['pandore_defenses_points']; ?>';
ligne1 = '<div style="display: table-row;"><div style="display: table-cell; vertical-align: middle;"><img style="width: 32px; height: 32px;" src="./mod/pandore/icons/';
ligne2 = ' <font title="<?php echo $lang['pandore_update_date']; ?>" style="color: rgb(' + String(r_t) + ',' + String(255 - r_t) + ',0);">' + String(class_techno[0]) + '</font></div></div>';
(points_recherches != points[2] || type_techno == 1) ? document.getElementById('nom_recherches').innerHTML = '<a><div title="<?php echo $lang['pandore_reset_research_clic']; ?>" onclick="javascript:init_points_recherches()" style="cursor: pointer;"><a><?php echo $lang['pandore_reset_research']; ?> (' + String(nombre_recherches) + '&nbsp;/&nbsp;' + String(techno) + ')</div></a>' : document.getElementById('nom_recherches').innerHTML = '';
if (class_techno[0]) {
	(nombre_recherches == techno) ? document.getElementById('class_recherches').innerHTML = ligne1 + 'ok.png" alt="<?php echo $lang['pandore_ok']." :"; ?>" / ></div>\n\t\t<div style="display: table-cell; vertical-align: middle; padding-left: 5px; text-align: left;"><?php echo $lang['pandore_good_number_research']; ?>' + ligne2 : document.getElementById('class_recherches').innerHTML = ligne1 + 'error.png" alt="<?php echo $lang['pandore_warning']." :"; ?>" / ></div>\n\t\t<div style="display: table-cell; vertical-align: middle; padding-left: 5px; text-align: left;"><?php echo $lang['pandore_bad_number_research']; ?>' + ligne2;
} else document.getElementById('class_recherches').innerHTML = ligne1 + 'error.png" alt="<?php echo $lang['pandore_warning']." :"; ?>" / ></div>\n\t\t<div style="display: table-cell; vertical-align: middle; padding-left: 5px; text-align: left;"><?php echo sprintf($lang['pandore_research_rank_unavailable'],'<font style="color: red;">','</font>'); ?></div>';
(points_flotte != class_gene[2] - points_batiments - points_defenses - points_recherches) ? document.getElementById('nom_vaisseaux').innerHTML = '<a><div title="<?php echo $lang['pandore_reset_fleet_points']; ?>" style="cursor: pointer;"><?php echo $lang['pandore_calculated_fleet_points']; ?></div></a>' : document.getElementById('nom_vaisseaux').innerHTML = '<?php echo $lang['pandore_calculated_fleet_points']; ?>';
if (nombre_flotte == class_vaisseaux[1]) {
	(class_vaisseaux[0]) ? document.getElementById('class_vaisseaux').innerHTML = '<?php echo $lang['pandore_fleet_rank_of']; ?> <font title="<?php echo $lang['pandore_update_date']; ?>" style="color: rgb(' + String(r_pt) + ', ' + String(255 - r_pt) + ',0);">' + String(class_vaisseaux[0]) + '</font>' : document.getElementById('class_vaisseaux').innerHTML = '<?php echo sprintf($lang['pandore_fleet_rank_unavailable'],'<font style="color: red;">','</font>'); ?>';
	document.getElementById('nom_flotte').innerHTML = '<?php echo $lang['pandore_fleet_number']; ?>';
} else {
	document.getElementById('class_vaisseaux').innerHTML = '<?php echo $lang['pandore_custom_fleet_number']; ?>';
	document.getElementById('nom_flotte').innerHTML = '<a><div title="<?php echo $lang['pandore_reset_fleet_number']; ?>" style="cursor: pointer;"><?php echo $lang['pandore_fleet_number']; ?></div></a>';
}
document.getElementById('points').innerHTML = format(Math.floor(total_points));
document.getElementById('points_manquants').innerHTML = format(points_manquants);
document.getElementById('flottes').innerHTML = format(total_flottes);
document.getElementById('flottes_manquantes').innerHTML = format(flottes_manquantes);
document.getElementById('points_in').value = Math.floor(total_points);
document.getElementById('points_manquants_in').value = points_manquants;
document.getElementById('flottes_in').value = total_flottes;
document.getElementById('flottes_manquantes_in').value = flottes_manquantes;
}

// Fonction de mise en forme des chiffres
function format(x) {
var signe = '';
if (x < 0) {
	x = Math.abs(x);
	signe = '-';
}
var str = x.toString(), n = str.length;
if (n < 4) return (signe + x)
else return (signe + ((n % 3) ? str.substr(0, n % 3) + '<?php echo $lang['pandore_thousands_separator'];?>' : '')) + str.substr(n % 3).match(new RegExp('[0-9]{3}', 'g')).join('<?php echo $lang['pandore_thousands_separator'];?>');
}

// Lancement du script au chargement de la page
window.onload = function() {Biper(); search_focus(); init();}
<?php else:?>
window.onload = function() {Biper(); search_focus();}
<?php endif;?>
</script>
<div style="display: table;">
<div style="display: table-row;">
<div align="center" style="display: table-cell; vertical-align: middle; width: 350px;">
<form action='./?action=pandore' method='post'>
<table>
	<tr>
		<td class='c' align='center'><?php echo $lang['pandore_search']; ?></td>
		<th><input type='text' name='pandoresearch' id='pandoresearch' size='14' maxlength='20' <?php if ($search) echo "value='".$search."' ";?>/></th>
	</tr>
	<tr>
		<td class='c' align='center'><?php echo $lang['pandore_target']; ?></td>
		<th>
			<select name='target'>
				<option value='player'<?php if ($target == 'player') echo " selected='selected'"; echo ">".$lang['pandore_player']; ?></option>
				<option value='coord'<?php if ($target == 'coord') echo " selected='selected'"; echo ">".$lang['pandore_coordinates']; ?></option>
			</select>
		</th>
	</tr>
	<tr><th colspan="2"><input type='submit' name='go' title='<?php echo $lang['pandore_send']."' value='".$lang['pandore_send']; ?>'/></th></tr>
</table>
</form>
<br />
<?php
// Affichage des erreurs de recherche
if ($error == 4) echo "</div></div></div><fieldset><legend>".$lang['pandore_error']."</legend>\n\t<center>\n\t\t<div style='max-width: 80%;'>\n\t\t\t<div style='display: table-cell; vertical-align: middle;'><img style='width: 128px; height: 128px;' src='./mod/pandore/icons/error.png' alt='".$lang['pandore_error']." :' /></div>\n\t\t\t<div style='display: table-cell; vertical-align: middle; padding-left: 5px; text-align: left;'>".$lang['pandore_error_coord']."</div>\n\t\t</div>\n\t</center>\n</fieldset>\n";
if ($error == 3) echo "</div></div></div><fieldset><legend>".$lang['pandore_error']."</legend>\n\t<center>\n\t\t<div style='max-width: 80%;'>\n\t\t\t<div style='display: table-cell; vertical-align: middle;'><img style='width: 128px; height: 128px;' src='./mod/pandore/icons/error.png' alt='".$lang['pandore_error']." :' /></div>\n\t\t\t<div style='display: table-cell; vertical-align: middle; padding-left: 5px; text-align: left;'>".$lang['pandore_error_player']." [".$search."].</div>\n\t\t</div>\n\t</center>\n</fieldset>\n";
if ($error == 2) echo "</div></div></div><fieldset><legend>".$lang['pandore_error']."</legend>\n\t<center>\n\t\t<div style='max-width: 80%;'>\n\t\t\t<div style='display: table-cell; vertical-align: middle;'><img style='width: 128px; height: 128px;' src='./mod/pandore/icons/error.png' alt='".$lang['pandore_error']." :' /></div>\n\t\t\t<div style='display: table-cell; vertical-align: middle; padding-left: 5px; text-align: left;'>".sprintf($lang['pandore_error_no_planete'],$search)."</div>\n\t\t</div>\n\t</center>\n</fieldset>\n";
if ($error == 1) {
	echo "</div></div></div><fieldset><legend>".$lang['pandore_error']."</legend>\n\t<center>\n\t\t<div style='max-width: 80%;'>\n\t\t\t<div style='display: table-cell; vertical-align: middle;'><img style='width: 128px; height: 128px;' src='./mod/pandore/icons/error.png' alt='".$lang['pandore_error']." :' /></div>\n\t\t\t<div style='display: table-cell; vertical-align: middle; padding-left: 5px; text-align: left;'>".sprintf($lang['pandore_error_planete'],$planet_max,$nom)."<br />";
	for ($i = 0; $i < count($coordonnees); $i++) {
		echo "[".$coordonnees[$i][0]."] ";
	}
	echo "</div>\n\t\t</div>\n\t</center>\n</fieldset>\n";
}
// Si pas d'erreur, afficher le résultat lorsqu'une recherche est lancée
if ($search && $error == 0) {
	// Affichage du nom, des classements et du tableau des coordonnées trouvées
	echo "<form action='./?action=pandore&page=enregistrements' method='post'>\n<table>\n\t<tr>\n\t\t<td class='c' align='center' style='min-width: 120px'>".$lang['pandore_player']."</td>\n\t\t<th style='min-width: 100px; cursor: pointer;' onclick='window.open(&quot;?action=search&type_search=player&string_search=".$nom."&quot;)' target='_blank' title='".$lang['pandore_link_search']."'><a style='display: block;'>".$nom."</a><input type='hidden' name='joueur' value='".$nom."' /></th>\n\t</tr>\n\t<tr>\n\t\t<td class='c' align='center'>".$lang['pandore_rank_points']."</td>\n\t\t<th>".number_format($class_gene['rank'], '', '', $lang['pandore_thousands_separator'])."<input type='hidden' name='classement_general' value='".$class_gene['rank']."' /></th>\n\t</tr>\n\t\t<td class='c' align='center'>".$lang['pandore_rank_fleet']."</td>\n\t\t<th>".number_format($class_flotte['rank'], '', '', $lang['pandore_thousands_separator'])."<input type='hidden' name='classement_flotte' value='".$class_flotte['rank']."' /></th>\n\t</tr>\n\t<tr>\n\t\t<td class='c' align='center'>".$lang['pandore_rank_research']."</td>\n\t\t<th>".number_format($class_techno['rank'], '', '', $lang['pandore_thousands_separator'])."<input type='hidden' name='classement_recherche' value='".$class_techno['rank']."' /></th>\n\t</tr>\n</table>\n<br /><br />\n<span id='sondage'></span>\n<table>\n\t<tr>\n\t\t<td></td>\n\t\t<td class='c' align='center'>".$lang['pandore_coordinates']."</td><td class='c' align='center'>".$lang['pandore_planets']."</td>\n\t\t<td class='c' align='center'>".$lang['pandore_moons']."</td>\n\t</tr>\n";
	$i = 0;
	$row = 'b';
	foreach ($coordonnees as $coord) {
		$coord_p = date($date_format,$coord[2]);
		$r_p = max(min(255, round((time() - $coord[2] - 86400) / 2033)), 0);
		$coord_l = date($date_format,$coord[4]);
		$r_l = max(min(255, round((time() - $coord[4] - 86400) / 2033)), 0);
		if ($coord[2] == 0) $coord_p = $lang['pandore_no_report'];
		if ($coord[4] == 0) $coord_l = $lang['pandore_no_report'];
		if ($coord[2] == 1) $coord_p = $lang['pandore_incomplete_report'];
		if ($coord[4] == 1) $coord_l = $lang['pandore_incomplete_report'];
		$coords = explode(":",$coord[0]);
		echo "\t<tr>\n\t\t<td rowspan='2' class='".$row."' style='text-align: center; vertical-align: middle; background-image: none;'>".++$i."</td>\n\t\t<td rowspan='2' class='".$row."' style='text-align: center; vertical-align: middle; background-image: none; cursor: pointer;' onclick='window.open(&quot;?action=galaxy&galaxy=".$coords[0]."&system=".$coords[1]."&quot;)' target='_blank' title='".$lang['pandore_link_galaxy']."'><a>".$coord[0]."</a></td>\n\t\t<td class='".$row."' style='text-align: center; vertical-align: middle; background-image: none;'>";
		if ($coord[2] != 0) echo "<a href='#' onclick='window.open(&quot;?action=show_reportspy&galaxy=".$coords[0]."&system=".$coords[1]."&row=".$coords[2]."&quot;,&quot;_blank&quot;,&quot;width=640, height=480, toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=0&quot;);return(false)' title='".$lang['pandore_link_spy']."' style='display: block;'>".$coord[1]."</a></td>\n";
		else echo $coord[1]."</td>\n";
		if ($coord[3]) {
			echo "\t\t<td class='".$row."' style='text-align: center; vertical-align: middle; background-image: none;'>";
			if ($coord[4] != 0) {
				echo "<a href='#' onclick='window.open(&quot;?action=show_reportspy&galaxy=".$coords[0]."&system=".$coords[1]."&row=".$coords[2]."&quot;,&quot;_blank&quot;,&quot;width=640, height=480, toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=0&quot;);return(false)' title='".$lang['pandore_link_spy']."' style='display: block;'>".$coord[3];
				if ($coord[5] > 0) echo " <span title='".$lang['pandore_jump_gate']."'>(".$lang['pandore_jump_gate_short'].")</span>";
				echo "</a></td>\n\t</tr>\n";
			}
			else echo $coord[3]."</td>\n\t</tr>\n";
		} else echo "\t\t<td rowspan='2' class='".$row."' style='text-align: center; vertical-align: middle; background-image: none;'></td>\n\t</tr>\n";
		echo "\t<tr>\n\t\t<td class='".$row."' style='text-align: center; vertical-align: middle; background-image: none;' title='".$lang['pandore_last_complete_report_date']."'><font style='color: rgb(".$r_p.",".(255 - $r_p).",0);'>".$coord_p."</font></td>\n";
		if ($coord[3]) echo "\t\t<td class='".$row."' style='text-align: center; vertical-align: middle; background-image: none;' title='".$lang['pandore_last_complete_report_date']."'><font style='color: rgb(".$r_l.",".(255 - $r_l).",0);'>".$coord_l."</font></td>\n";
		echo "\t</tr>\n";
		($row == 'b') ? $row = 'f' : $row = 'b';
	}

	
	// Affichage des avertissements sur le nombre de planètes
	if ($i == 1) echo "\t<tr>\n\t\t<td colspan='4' class='".$row."' style='vertical-align: middle;'><div style='display: table-cell; vertical-align: middle;'><img style='width: 64px; height: 64px;' src='./mod/pandore/icons/warning.png' alt='".$lang['pandore_warning']." :' /></div>\n\t\t<div style='display: table-cell; vertical-align: middle; padding-left: 5px; text-align: left;'>".$lang['pandore_warning_one_planete']."<br />".$lang['pandore_warning_ride_universe']."</div></td>\n\t</tr>\n";
	elseif ($i == $planet_max) echo "\t<tr>\n\t\t<td colspan='4' class='".$row."' style='vertical-align: middle;'><div style='display: table-cell; vertical-align: middle;'><img style='width: 64px; height: 64px;' src='./mod/pandore/icons/ok.png' alt='".$lang['pandore_warning']." :' /></div>\n\t\t<div style='display: table-cell; vertical-align: middle; padding-left: 5px; text-align: left;'>".$lang['pandore_warning_all_planete']."</div></td>\n\t</tr>\n";
	elseif ($i < $planet_max) echo "\t<tr>\n\t\t<td colspan='4' class='".$row."' style='vertical-align: middle;'><div style='display: table-cell; vertical-align: middle;'><img style='width: 64px; height: 64px;' src='./mod/pandore/icons/warning.png' alt='".$lang['pandore_warning']." :' /></div>\n\t\t<div style='display: table-cell; vertical-align: middle; padding-left: 5px; text-align: left;'>".sprintf($lang['pandore_warning_less_planetes'],$i,$planet_max)."<br />".$lang['pandore_warning_ride_universe']."</div></td>\n\t</tr>\n";
	elseif ($i > $planet_max) {
		echo "\t<tr>\n\t\t<td colspan='4' class='".$row."' style='vertical-align: middle;'><div style='display: table-cell; vertical-align: middle;'><img style='width: 64px; height: 64px;' src='./mod/pandore/icons/error.png' alt='".$lang['pandore_error_planete']." :' /></div>\n\t\t<div style='display: table-cell; vertical-align: middle; padding-left: 5px; text-align: left;'>".sprintf($lang['pandore_error_planete'],$planet_max,$nom);
		for ($i = 0; $i < count($coordonnees); $i++)
			echo "[".$coordonnees[$i][0]."] ";
		echo "</div></td>\n\t</tr>\n";
	}
	// Affichage du nombre de sondes nécessaires
	echo "\t<tr>\n\t\t<td colspan='4' class='c' style='text-align: center;'>".$lang['pandore_probe_number']."</td>\n\t</tr>\n\t<tr>\n\t\t<td colspan='3' class='".$row."' style='text-align: center;'>".$lang['pandore_buildings']."</td>\n\t\t<td class='".$row."' style='text-align: center;'>".$nb_sondes[0]."</td>\n\t</tr>\n";
	($row == 'b') ? $row = 'f' : $row = 'b';
	echo "\t<tr>\n\t\t<td colspan='3' class='".$row."' style='text-align: center;'>".$lang['pandore_researchs']."</td>\n\t\t<td class='".$row."' style='text-align: center;'>".$nb_sondes[1]."</td>\n\t</tr>\n";
	echo "</table>\n";
	// Affichage des points
	echo "<br />\n<table style='width: 350px;'><tr><td class='c' align='center' style='width: 70%;' onclick='javascript:init_points_general()'><span id='nom_general'>".$lang['pandore_points_total']."</span></td><th><input type='text' name='points_general' id='points_general' size='11' maxlength='9' onblur='javascript:calculs(0)' value='-' style='text-align: center;' /></th></tr>\n";
	echo "\t<tr><th colspan='2'><span id='class_general'>".sprintf($lang['pandore_points_rank_unavailable'],"<font style='color: red;'>","</font>")."</span></th></tr>\n";
	echo "\t<tr><td class='c' align='center' onclick='javascript:init_points_batiments()'><span id='nom_batiments'>".$lang['pandore_buildings_points']."</span></td><th><input type='text' id='points_batiments' size='11' maxlength='9' onblur='javascript:calculs(0)' value='-' style='text-align: center;' /></th></tr>\n";
	echo "\t<tr><td class='c' align='center' onclick='javascript:init_points_defenses()'><span id='nom_defenses'>".$lang['pandore_defenses_points']."</span></td><th><input type='text' id='points_defenses' size='11' maxlength='9' onblur='javascript:calculs(0)' value='-' style='text-align: center;' /></th></tr>\n";
	echo "\t<tr><td class='c' align='center' title='".$lang['pandore_research_menu']."' onclick='javascript:ouverture()' style='cursor: pointer;'><a style='display: block;'>".$lang['pandore_research_points']."</a></td><th><input type='text' name='points_recherches' id='points_recherches' size='11' maxlength='9' onblur='javascript:calculs(1)' value='-' style='text-align: center;' /></th></tr>\n";
	echo "\t<tr>\n\t\t<th colspan='2'><span id='nom_recherches'></span><div id='menu_technologies' style='display: none;'>\n\t\t\t<table style='border: 0pt;' width='100%'>\n";
	foreach ($points_technology as $key => $value) {
		echo "\t\t\t\t<tr><td align='right'>".$lang['pandore_'.$key]."</td><td><input type='text' id='".$key."' size='4' maxlength='2' onblur='javascript:calculs(2)' value='-' style='text-align: center;' /></td></tr>\n";
	}
	echo "\t\t\t</table></div>\n\t\t<span id='class_recherches'><div style='display: table-row;'><div style='display: table-cell; vertical-align: middle;'><img style='width: 32px; height: 32px;' src='./mod/pandore/icons/ok.png' alt='Ok :' /></div>\n\t\t<div style='display: table-cell; vertical-align: middle; padding-left: 5px; text-align: left;'>Le nombre de technologies correspond avec le classement recherche du <font title='".$lang['pandore_update_date']."' style='color: rgb(".$r_t.",".(255 - $r_t).",0);'>".$class_techno["date"]."</font></div></div></span></th>\n\t</tr>\n";
	echo "\t<tr><td class='c' align='center' onclick='javascript:init_points_vaisseaux()'><span id='nom_vaisseaux'>".$lang['pandore_calculated_fleet_points']."</span></td><th><input type='text' name='points_flotte' id='points_flotte' size='11' maxlength='9' onblur='javascript:calculs(3)' value='";
	if (isset($simulation)) echo $simulation['points_flotte'];
	echo "' style='text-align: center;' /></th></tr>\n";
	echo "\t<tr><td class='c' align='center' onclick='javascript:init_nombre_flotte()'><span id='nom_flotte'>".$lang['pandore_fleet_number']."</span></td><th><input type='text' id='nombre_flotte' size='11' maxlength='9' onblur='javascript:calculs()' value='";
	if (isset($simulation)) echo $simulation['flottes_manquantes'] + $simulation['flottes'];
	echo "' style='text-align: center;' /></th></tr>\n";
	echo "\t<tr><th colspan='2'><span id='class_vaisseaux'>Classement vaisseaux <font style='color: red;'>indisponible</font></span></th></tr>\n</table>\n";
	// Affichage du nombre de vaisseaux
	echo "</div><div style='display: table-cell; vertical-align: middle; padding-left: 50px;'>\n<table>\n\t<tr>\n\t\t<td class='c' align='center'>".$lang['pandore_fleets']."</td><td class='c' align='center'>".$lang['pandore_spyed']."</td><td class='c' align='center'>".$lang['pandore_maximum']."</td><td class='c' align='center' onmouseover=\"Tip('<table width=&quot;200&quot;><tr><td style=&quot;text-align:center&quot; class=&quot;c&quot;>".$lang['pandore_help']."</td></tr><tr><th style=&quot;text-align:center&quot;><a>".$lang['pandore_assumed_help']."</a></th></tr></table>')\" onmouseout='UnTip()'><img style='cursor: help;' src='images/help_2.png' />&nbsp;".$lang['pandore_assumed']."</td>\n\t</tr>\n";
	$row = 'b';
	foreach ($points_flotte as $key => $value) {
		echo "\t<tr>\n\t\t<td class='".$row."' style='text-align: center; background-image: none;'>".$lang['pandore_'.$key]."</td>\n\t\t<td class='".$row."' style='text-align: center; background-image: none;'>".number_format($flotte[$key], 0, ',', $sep_mille)."</td>\n\t\t<td class='".$row."' style='text-align: center; background-image: none;'><span name ='max_".$key."' id='max_".$key."'></span></td>\n\t\t<td class='".$row."' style='text-align: center; background-image: none;'><input type='text' name='".$key."' id='".$key."' size='10' maxlength='8' onblur='javascript:calculs()' value='";
		if (isset($simulation)) echo $simulation[$key];
		echo "' style='text-align: center;' /></td>\n\t</tr>\n";
		$row == 'b' ? $row = 'f' : $row = 'b';
	}
	echo "\t<tr>\n\t\t<td class='c' align='center'>".$lang['pandore_fleet_points']."</td>\n\t\t<td class='b' align='center'>".number_format(floor($points["flottes"]), 0, ',', $sep_mille)."</td>\n\t\t<td class='b' align='center'>-</td>\n\t\t<td class='b' align='center'><span id='points'></span><input type='hidden' name='points' id='points_in'/></td>\n\t</tr>\n";
	echo "\t<tr>\n\t\t<td class='c' align='center'>".$lang['pandore_missing_points']."</td>\n\t\t<td class='b' align='center'><span id='points_manquants_sondes'>".number_format($class_gene["points"] - $points["batiments"] - $points["defenses"] - $points["recherches"] - $points["flottes"], 0, ',', $sep_mille)."</span></td>\n\t\t<td class='b' align='center'>-</td>\n\t\t<td class='b' align='center'><span id='points_manquants'></span><input type='hidden' name='points_manquants' id='points_manquants_in'/></td>\n\t</tr>\n";
	echo "\t<tr>\n\t\t<td class='c' align='center'>".$lang['pandore_fleet_number']."</td>\n\t\t<td class='b' align='center'>".number_format(array_sum($flotte), 0, ',', $sep_mille)."</td>\n\t\t<td class='b' align='center'>-</td>\n\t\t<td class='b' align='center'><span id='flottes'></span><input type='hidden' name='flottes' id='flottes_in'/></td>\n\t</tr>\n";
	echo "\t<tr>\n\t\t<td class='c' align='center'>".$lang['pandore_missing_fleet']."</td>\n\t\t<td class='b' align='center'><span id='flottes_manquantes_sondes'>".number_format($class_flotte["points"] - array_sum($flotte), 0, ',', $sep_mille)."</span></td>\n\t\t<td class='b' align='center'>-</td>\n\t\t<td class='b' align='center'><span id='flottes_manquantes'></span><input type='hidden' name='flottes_manquantes' id='flottes_manquantes_in'/></td>\n\t</tr>\n";
	echo "<tr><td /><td /><td /><td class='c' align='center'><input type='submit' name='save' title='".$lang['pandore_save']."' value='".$lang['pandore_save']."'></td></tr>\n";
	echo "</table></form></div></div></div>\n";
	// Affichage des erreurs dues à un manque d'informations
	if ($error2[1] == 1) {
		echo "</div></div></div><br />\n<fieldset><legend>".$lang['pandore_error']."</legend>\n\t<center>\n\t\t<div style='max-width: 80%;'>\n\t\t\t<div style='display: table-cell; vertical-align: middle;'><img style='width: 128px; height: 128px;' src='./mod/pandore/icons/stop.png' alt='".$lang['pandore_error']." :' /></div>\n\t\t\t<div style='display: table-cell; vertical-align: middle; padding-left: 5px; text-align: left;'>".$lang['pandore_error_missing_reports']."<br />".$lang['pandore_error_respy']."<br />";
		for ($i = 0; $i < count($coordonnees); $i++) {
			$k = Array(0,0);
			for ($j = 0; isset($rapports) && $j < count($rapports); $j++) {
				if (isset($rapports[$j]) && $rapports[$j]["coordinates"] == $coordonnees[$i][0] && substr($rapports[$j]["planet_name"], 0, 10) == substr($coordonnees[$i][1], 0, 10)) $k[0] = 1;
				if (isset($rapports[$j + count($coordonnees)]) && $rapports[$j + count($coordonnees)]["coordinates"] == $coordonnees[$i][0] && substr($rapports[$j + count($coordonnees)]["planet_name"], 0, 10) == substr($coordonnees[$i][3], 0, 10)) $k[1] = 1;
			}
			if ($k[0] == 0) echo "[".$coordonnees[$i][0]."] ";
			if ($k[1] == 0 && $coordonnees[$i][3]) echo "[".$coordonnees[$i][0]."&nbsp;".$lang['pandore_moon']."] ";
		}
		echo "</div>\n\t\t</div>\n\t</center>\n</fieldset>\n";
	}
	if ($error2[2] == 1) {
		echo "</div></div></div><br />\n<fieldset><legend>".$lang['pandore_error']."</legend>\n\t<center>\n\t\t<div style='max-width: 80%;'>\n\t\t\t<div style='display: table-cell; vertical-align: middle;'><img style='width: 128px; height: 128px;' src='./mod/pandore/icons/stop.png' alt='".$lang['pandore_error']." :' /></div>\n\t\t\t<div style='display: table-cell; vertical-align: middle; padding-left: 5px; text-align: left;'>".$lang['pandore_error_incomplete_reports']."<br />".$lang['pandore_error_respy']."<br />";
		for ($i = 0; $i < count($coordonnees); $i++) {
			if ($coordonnees[$i][2] == 1) echo "[".$coordonnees[$i][0]."] ";
			if ($coordonnees[$i][4] == 1) echo "[".$coordonnees[$i][0]."&nbsp;".$lang['pandore_moon']."] ";
		}
		echo "</div>\n\t\t</div>\n\t</center>\n</fieldset>\n";
	}
	if ($error2[0] == 1) {
		echo "</div></div></div><br />\n<fieldset><legend>".$lang['pandore_error']."</legend>\n\t<center>\n\t\t<div style='max-width: 80%;'>\n\t\t\t<div style='display: table-cell; vertical-align: middle;'><img style='width: 128px; height: 128px;' src='./mod/pandore/icons/stop.png' alt='".$lang['pandore_error']." :' /></div>\n\t\t\t<div style='display: table-cell; vertical-align: middle; padding-left: 5px; text-align: left;'>".sprintf($lang['pandore_error_unknown_player'],$nom)."<br />".$lang['pandore_error_update_rankings']."<br />";
		if (!$class_gene["date"]) echo $lang['pandore_error_points_ranking'];
		if (!$class_flotte["date"]) {
			if ((!$class_gene["date"]) && (!$class_flotte["date"]) && (!$class_techno["date"])) echo ", ";
			elseif (!$class_gene["date"]) echo " ".$lang['pandore_and']." ";
			echo $lang['pandore_error_fleet_ranking'];
			$comp = 1;
		}
		if (!$class_techno["date"]) {
			if ((!$class_gene["date"]) || (!$class_flotte["date"])) echo " ".$lang['pandore_and']." ";
			echo $lang['pandore_error_research_ranking'];
		}
		echo ".</div>\n\t\t</div>\n\t</center>\n</fieldset>\n";
	}
	if (array_sum($error2) == 0) {
		// Affichage des avertissements de péremption
		if (time() - $rapport_date_min >= 604800) {
			echo "<br />\n<fieldset><legend>".$lang['pandore_warning']."</legend>\n\t<center>\n\t\t<div style='max-width: 80%;'>\n\t\t\t<div style='display: table-cell; vertical-align: middle;'><img style='width: 128px; height: 128px;' src='./mod/pandore/icons/warning.png' alt='".$lang['pandore_warning']." :' /></div>\n\t\t\t<div style='display: table-cell; vertical-align: middle; padding-left: 5px; text-align: left;'>".$lang['pandore_warning_old_reports']."<br />".$lang['pandore_warning_respy']."<br />";
			for ($i = 0; $i < count($coordonnees); $i++) {
				if (time()-$coordonnees[$i][2] >= 604800) echo "[".$coordonnees[$i][0]."] ";
				if ($coordonnees[$i][3] && time()-$coordonnees[$i][4] >= 604800) echo "[".$coordonnees[$i][0]."&nbsp;".$lang['pandore_moon']."] ";
			}
			echo "</div>\n\t\t</div>\n\t</center>\n</fieldset>\n";
		}
		if (time() - min($class_gene["datadate"], $class_flotte["datadate"], $class_techno["datadate"]) >= 604800) {
			echo "<br />\n<fieldset><legend>".$lang['pandore_warning']."</legend>\n\t<center>\n\t\t<div style='max-width: 80%;'>\n\t\t\t<div style='display: table-cell; vertical-align: middle;'><img style='width: 128px; height: 128px;' src='./mod/pandore/icons/warning.png' alt='".$lang['pandore_warning']." :' /></div>\n\t\t\t<div style='display: table-cell; vertical-align: middle; padding-left: 5px; text-align: left;'>".$lang['pandore_warning_old_rankings']."<br />".$lang['pandore_warning_update_rankings']."<br />";
				if (time()-$class_gene["datadate"] >= 604800) echo $lang['pandore_error_points_ranking'];
				if (time()-$class_flotte["datadate"] >= 604800) {
					if ((time()-$class_gene["datadate"] >= 604800) && (time()-$class_flotte["datadate"] >= 604800) && (time()-$class_techno["datadate"] >= 604800)) echo ", ";
					elseif (time()-$class_gene["datadate"] >= 604800) echo " ".$lang['pandore_and']." ";
					echo $lang['pandore_error_fleet_ranking'];
					$comp = 1;
				}
				if (time()-$class_techno["datadate"] >= 604800) {
					if ((time()-$class_gene["datadate"] >= 604800) || (time()-$class_flotte["datadate"] >= 604800)) echo " ".$lang['pandore_and']." ";
					echo $lang['pandore_error_research_ranking'];
				}
			echo ".</div>\n\t\t</div>\n\t</center>\n</fieldset>\n";
		}
	}
} else echo "</div></div></div>";
?>
<br /><br />
