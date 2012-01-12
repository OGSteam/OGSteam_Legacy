<html>
<head>
<title>Calcul Ressources</title>
<LINK rel="stylesheet" type="text/css" href="mod/CalculRessources/styles_CalculR.css">
</head>
<body>
<?php
/***************************************************************************
*	filename	: Index.php
*	desc.		: CalculRessources
*	Author		: varius9
*	created		: 03/09/2008
*	modified	: 07/01/2012
***************************************************************************/
if (!defined('IN_SPYOGAME')) {die("Hacking attempt");}

global $db, $table_prefix;
//definition des tables
define("TABLE_CALCULRESS_USER",$table_prefix."mod_calculress");
define("TABLE_CALCUL_BESOIN", $table_prefix."mod_calculbesoin");

//On regarde si le mod est activé + on recupère la racine :
$query = "SELECT `root` FROM `".TABLE_MOD."` WHERE `action`='CalculRessources' AND `active`='1' LIMIT 1";
$isActive = $db->sql_numrows($db->sql_query($query)); // mod actif ?
//On vérifie que le mod est activé
if(!$isActive) die('Mod désactivé !');

// définition du dossier du modules
$result = $db->sql_query($query);
list($root) = $db->sql_fetch_row($result);
define("FOLDEREXP","mod/".$root."/");

//On ajoute l'action dans le log

// Inclusion des fonctions :
if (isset ($pub_page)) {
if ($pub_page == "changelog") {include(FOLDEREXP."changelog.php"); exit();}}

require_once(FOLDEREXP."functions.php");

$user_empire = user_get_empire(); // récupération des infos empire
$user_building = $user_empire["building"];
$line = $user_data["user_name"]." se connecte sur le mod Calcul Ressources";
$fichier = "log_".date("ymd").'.log';
$nb_planet = find_nb_planete_user();
$start = 101;
$moon_start = 201;

if (isset ($pub_depuis_ajax)) {
	if ($pub_depuis_ajax=="1"){  // Appel depuis l'ajax Mise à jour de la DB (car &depuis_ajax=1)
		$planet_id = $pub_planet_id;
		$metal = $pub_metal;
		$cristal = $pub_cristal;
		$deut = $pub_deut;

/* $request = "SELECT metal FROM ".TABLE_CALCULRESS_USER." WHERE user_id = ".$user['id']." and planet_id = ".$home['id'];
if ($sql-&gt;check($request) == 0) {   //nouvel enregistrement
     $request = "INSERT INTO ".TABLE_CALCULRESS_USER." (user_id, planet_id, metal, cristal, deut) VALUES (".$user['id'].", ".$home['id'].", ".$data['ressources'][0].", ".$data['ressources'][1].", ".$data['ressources'][2].")";
     $sql->query($request);
} else { // enregistrement existant
     $request = "UPDATE ".TABLE_CALCULRESS_USER." set metal = ".$data['ressources'][0].", cristal = ".$data['ressources'][1].", deut = ".$data['ressources'][2]." WHERE user_id = ".$user['id']." and planet_id = ".$home['id'];
     $sql->query($request);
}

$request = "REPLACE INTO ".TABLE_CALCULRESS_USER." set metal = ".$data['ressources'][0].", cristal = ".$data['ressources'][1].", deut = ".$data['ressources'][2]." WHERE user_id = ".$user['id']." and planet_id = ".$home['id'];
$sql->query($request); */

		If ($planet_id > 0) {
			$result = $db->sql_query("SELECT metal FROM ".TABLE_CALCULRESS_USER." WHERE user_id = ".$user_data['user_id']." and planet_id = ".$planet_id);
			if ($db->sql_numrows($result) == 0) {   //nouvel enregistrement
				if ($pub_mem==0) {
					$request = "INSERT INTO ".TABLE_CALCULRESS_USER." (user_id, planet_id, `date_heure`, metal, cristal, deut) VALUES (".$user_data['user_id'].", ".$planet_id.", '".date('Y-m-d H:i:s')."',  ".$metal.", ".$cristal.", ".$deut.")";
					$db->sql_query($request);}
				else {
					$request = "INSERT INTO ".TABLE_CALCULRESS_USER." (user_id, planet_id, metal1, cristal1, deut1) VALUES (".$user_data['user_id'].", ".$planet_id.", ".$metal.", ".$cristal.", ".$deut.")";
					$db->sql_query($request);}
				}
			else { // enregistrement existant
				if ($pub_mem==0) {
					$request = "UPDATE ".TABLE_CALCULRESS_USER." set `date_heure` = '".date('Y-m-d H:i:s')."', metal = ".$metal.", cristal = ".$cristal.", deut = ".$deut." WHERE user_id = ".$user_data['user_id']." and planet_id = ".$planet_id;
					$db->sql_query($request);}
				else {
					$request = "UPDATE ".TABLE_CALCULRESS_USER." set metal1 = ".$metal.", cristal1 = ".$cristal.", deut1 = ".$deut." WHERE user_id = ".$user_data['user_id']." and planet_id = ".$planet_id;
					$db->sql_query($request);}
				}		
			if ($pub_mem==0) {
				$var = date('j M y  G:i');
				echo "|user_build_dh[".($planet_id-1)."]='".$var."';|"."\n";
				echo "document.forms['post2'].elements['DateH".$planet_id."'].value = '".$var."';|"."\n";}
		}
//		$line = "/*".date("d/m/Y H:i:s").'*/ '.$line." ajax1";
//		write_file(PATH_LOG_TODAY.$fichier, "a", $line);
		} //exit();
	else if ($pub_depuis_ajax=="2"){  // Appel depuis l'ajax RAZ
			$mem = $pub_mem;
			if ($mem == "-1") {
				$request = "TRUNCATE TABLE ".TABLE_CALCULRESS_USER;
				$db->sql_query($request);}
			else {
				for ($i=$start; $i<=$start+$nb_planet-1 ; $i++) {
					$result = $db->sql_query("SELECT planet_id FROM ".TABLE_CALCULRESS_USER." WHERE user_id = ".$user_data['user_id']." and planet_id = ".$i);
					if ($db->sql_numrows($result)> 0) { 
						if ($mem == "0") {
							$request = "UPDATE ".TABLE_CALCULRESS_USER." set `date_heure` = '', metal = 0, cristal = 0, deut = 0 WHERE user_id = ".$user_data['user_id']." and planet_id = ".$i;
							$db->sql_query($request);}
						else if ($mem == "1") {
							$request = "UPDATE ".TABLE_CALCULRESS_USER." set metal1 = 0, cristal1 = 0, deut1 = 0 WHERE user_id = ".$user_data['user_id']." and planet_id = ".$i;
							$db->sql_query($request);}
					}}
				for ($i=$moon_start; $i<=$moon_start+$nb_planet-1 ; $i++) {
					$result = $db->sql_query("SELECT planet_id FROM ".TABLE_CALCULRESS_USER." WHERE user_id = ".$user_data['user_id']." and planet_id = ".$i);
					if ($db->sql_numrows($result)> 0) { 
						if ($mem == "0") {
							$request = "UPDATE ".TABLE_CALCULRESS_USER." set `date_heure` = '', metal = 0, cristal = 0, deut = 0 WHERE user_id = ".$user_data['user_id']." and planet_id = ".$i;
							$db->sql_query($request);}
						else if ($mem == "1") {
							$request = "UPDATE ".TABLE_CALCULRESS_USER." set metal1 = 0, cristal1 = 0, deut1 = 0 WHERE user_id = ".$user_data['user_id']." and planet_id = ".$i;
							$db->sql_query($request);}
					}}
				}
		if ($mem=="0" || $mem=="-1") echo ":Vue(0);:\n"; else echo ":Vue(1);:\n"; 
		exit();}
	else if ($pub_depuis_ajax=="3"){
		$choix = $pub_choix_type;
		$request = "select * from ".TABLE_CALCUL_BESOIN." where `type_construction` = '".$choix."' order by id";
		$result = $db->sql_query($request);
		echo ":".$db->sql_numrows($result).":";
		echo "document.resultat.list_const.options.length = 0;:";
		echo "document.resultat.list_const.options[document.resultat.list_const.options.length] = new Option('','');:"."\n";
		while ($row = $db->sql_fetch_assoc($result)) {
			echo "document.resultat.list_const.options[document.resultat.list_const.options.length] = new Option('".$row["construction"]."','".$row["construction"]."');:"."\n";}
		exit();}
	else if ($pub_depuis_ajax=="4"){
		$obj1 = $pub_obj1;
		$obj2 = $pub_obj2;
		$niv = $pub_niv;
		$request = "select * from ".TABLE_CALCUL_BESOIN." where `construction` = '".$obj2."'"; //`type_construction` = '".$obj1."' and 
		$result = $db->sql_query($request);
		$row = $db->sql_fetch_assoc($result); //1 seul enregistrement possible
		$coef = $row["coef"];
		echo ":document.forms.resultat.Obj_metal.value = format(".Besoin($row["base_metal"],$niv,$coef).");";
		echo ":document.forms.resultat.Obj_cristal.value = format(".Besoin($row["base_cristal"],$niv,$coef).");";
		echo ":document.forms.resultat.Obj_deut.value = format(".Besoin($row["base_deut"],$niv,$coef).");:";
		exit();}
		}
else {
	$line = "/*".date("d/m/Y H:i:s").'*/ '.$line;
	write_file(PATH_LOG_TODAY.$fichier, "a", $line);
}// Fin Appel AJAX.

require_once("views/page_header.php");
?>

<!-- DEBUT DU SCRIPT -->
<script language="JavaScript">
<?php

$name = $coordinates = "";
$coord = $ressM = $ressC = $ressD = $ressM1 = $ressC1 = $ressD1 = ""; // Initialisation des variables, pour eviter l'erreur PHP-8
$dh = "";

for ($i=$start ; $i<=$start+$nb_planet-1 ; $i++) {
	$name .= "'".$user_building[$i]["planet_name"]."', ";
	$coordinates .= "'".$user_building[$i]["coordinates"]."', ";
}
for ($i=$moon_start ; $i<=$moon_start+$nb_planet-1 ; $i++) {
	$name .= "'".$user_building[$i]["planet_name"]."', ";
	$coordinates .= "'".$user_building[$i]["coordinates"]."', ";
}

$ress = array(false, "user_id" => "", "date_heure" => "", "planet_id" => "", "metal" => 0, "cristal" => 0, "deut" => 0, "metal1" => 0, "cristal1" => 0, "deut1" => 0);
$request = "select * from ".TABLE_CALCULRESS_USER." where user_id = ".$user_data["user_id"];
$request .= " order by planet_id";
$result = $db->sql_query($request); // or die ("Erreur SQL !".$request."<br>".mysql_error());
$user_ress = array_fill(1, $nb_planet*2, $ress);
while ($row = $db->sql_fetch_assoc($result)) {
		$arr = $row;
		unset($arr["planet_id"]);
		unset($arr["date_heure"]);
		unset($arr["metal"]);
		unset($arr["cristal"]);
		unset($arr["deut"]);
		unset($arr["metal1"]);
		unset($arr["cristal1"]);
		unset($arr["deut1"]);
		$user_ress[$row["planet_id"]] = $row;
		$user_ress[$row["planet_id"]][0] = true;
	}

for ($i=$start ; $i<=$start+$nb_planet-1 ; $i++) {
	if (isset($user_building[$i]["coordinates"])){  // Test de l'existance des données (toujours pour eviter le PHP-8)
		$coord .= "'".$user_building[$i]["coordinates"]."', ";
		$dh .= "'".date('j M y  G:i',strtotime($user_ress[$i]["date_heure"]))."', ";
		$ressM .= "'".$user_ress[$i]["metal"]."', ";
		$ressC .= "'".$user_ress[$i]["cristal"]."', ";
		$ressD .= "'".$user_ress[$i]["deut"]."', ";
		$ressM1 .= "'".$user_ress[$i]["metal1"]."', ";
		$ressC1 .= "'".$user_ress[$i]["cristal1"]."', ";
		$ressD1 .= "'".$user_ress[$i]["deut1"]."', ";
	}
}
for ($i=$moon_start ; $i<=$moon_start+$nb_planet-1 ; $i++) {
	if (isset($user_building[$i]["coordinates"])){  // Test de l'existance des données (toujours pour eviter le PHP-8)
		$coord .= "'".$user_building[$i]["coordinates"]."', ";
		$dh .= "'".date('j M y  G:i',strtotime($user_ress[$i]["date_heure"]))."', ";
		$ressM .= "'".$user_ress[$i]["metal"]."', ";
		$ressC .= "'".$user_ress[$i]["cristal"]."', ";
		$ressD .= "'".$user_ress[$i]["deut"]."', ";
		$ressM1 .= "'".$user_ress[$i]["metal1"]."', ";
		$ressC1 .= "'".$user_ress[$i]["cristal1"]."', ";
		$ressD1 .= "'".$user_ress[$i]["deut1"]."', ";
	}
}

echo "var name = new Array(".substr($name, 0, strlen($name)-2).");"."\n";
echo "var coordinates = new Array(".substr($coordinates, 0, strlen($coordinates)-2).");"."\n";
echo "var nb_planet = ".$nb_planet.";"."\n";
echo "var user_build_coord = new Array(".substr($coord, 0, strlen($coord)-2).");"."\n";
echo "var user_build_dh = new Array(".substr($dh, 0, strlen($dh)-2).");"."\n";
echo "var user_build_metal = new Array(".substr($ressM, 0, strlen($ressM)-2).");"."\n";
echo "var user_build_cristal = new Array(".substr($ressC, 0, strlen($ressC)-2).");"."\n";
echo "var user_build_deut = new Array(".substr($ressD, 0, strlen($ressD)-2).");"."\n";
echo "var user_build_metal1 = new Array(".substr($ressM1, 0, strlen($ressM1)-2).");"."\n";
echo "var user_build_cristal1 = new Array(".substr($ressC1, 0, strlen($ressC1)-2).");"."\n";
echo "var user_build_deut1 = new Array(".substr($ressD1, 0, strlen($ressD1)-2).");"."\n";

?>
var coord_planet = "";
var type_planet = "";
var select_planet = 0;

function create_list(choix_type) {
	var xhr_object = null;
	if (window.XMLHttpRequest) 
		xhr_object = new XMLHttpRequest();
	else if (window.ActiveXObject) 
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
	else {alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
		return;}

	var data = "choix_type=" + choix_type;
	xhr_object.open("POST","index.php?action=CalculRessources&depuis_ajax=3", true);
	xhr_object.onreadystatechange = function() {
      if(xhr_object.readyState == 4) {
		var tmp = xhr_object.responseText.split(":");
		var nb=parseInt(tmp[1])+3;
		for (var i=2; i<=nb; i++)  {eval(tmp[i]);} //alert(i+"-"+tmp[i]);
		}
      }
	xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr_object.send(data);
}

function Calcul_Besoin(obj1,obj2,niv) {
if (niv <= 0) {alert("Merci de renseigner la case Niveau ou Qté avec un entier"); return;}
	var xhr_object = null;
	if (window.XMLHttpRequest) 
		xhr_object = new XMLHttpRequest();
	else if (window.ActiveXObject) 
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
	else {alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
		return;}

	var data = "obj1="+obj1+"&obj2="+obj2+"&niv="+niv;
	xhr_object.open("POST","index.php?action=CalculRessources&depuis_ajax=4", true);
	xhr_object.onreadystatechange = function() {
    	if(xhr_object.readyState == 4) {
      		var tmp = xhr_object.responseText.split(":");
			for (var i=1; i<=3; i++) {eval(tmp[i]);}
		Calcul_Ress (0);}
	}
	xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr_object.send(data);
}

function format(valeur) {
	if (isNaN(parseInt(valeur))){alert('format numérique svp'); return 0;}
	var tmpNumStr = new String(valeur);
	var iStart = tmpNumStr.length;
	iStart -= 3;
	while (iStart >= 1) {
		tmpNumStr = tmpNumStr.substring(0,iStart) + " " + tmpNumStr.substring(iStart,tmpNumStr.length);
		iStart -= 3;}
	return tmpNumStr;}

function format_this(valeur, this_) {
	valeur = return_num(valeur);
	var tmpNumStr = new String(valeur);
	var iStart = tmpNumStr.length;
	iStart -= 3;
	while (iStart >= 1) {
		tmpNumStr = tmpNumStr.substring(0,iStart) + " " + tmpNumStr.substring(iStart,tmpNumStr.length);
		iStart -= 3;}
	this_.value= tmpNumStr;

	if (this_.name.indexOf("Obj_metal") >= 0)
		Obj_M = valeur;
	else if (this_.name.indexOf("Obj_cristal") >= 0)
		Obj_C = valeur;
	else if (this_.name.indexOf("Obj_deut") >= 0)
		Obj_D = valeur;
	Calcul_Ress(0);
}

function return_num(valeur) {
	valeur = valeur.replace(/\s+/g,"");
	valeur = valeur.replace(/\./g,"");
	valeur = parseInt(valeur);
	if (isNaN(valeur)) return 0; else return valeur;}

function ExtraitCoord(msg) {
	var pos1 = msg.indexOf("Position[")+9;
	var tmp = msg.substring(pos1,pos1+10)
	pos1 = tmp.indexOf("]P");
	tmp = tmp.substring(0,pos1);
	return tmp;}

function ExtraitTypePlanet(msg) {
	if (msg.indexOf("Lune \"") > 0) return "Lune"; else return "Planète";}

function IndicePlanet(typeP,coordP) {
	var tmp = "";
	if (typeP != "Planète" && typeP != "Lune") {
		return 0;}
	else if (typeP == "Planète") {
		for (i=0; i<=19 ; i++) {
			if (user_build_coord[i] == coordP) return i+1;}}
	else {
		for (i=20; i<=39 ; i++) {
			if (user_build_coord[i] == coordP) return i+1;}}
	return 0;}

function requestRess(f) {
var xhr_object = null;
var pos1 = 0;
var pos2 = 0;
var tmp1 = "";

var tmp = f.elements["datas"].value;
type_planet = ExtraitTypePlanet(tmp);
tmp = tmp.replace(/\s+/g,"");
coord_planet = ExtraitCoord(tmp);
select_planet = IndicePlanet(type_planet,coord_planet);
if (select_planet == 0)
	alert("Aucune information valide, merci de recoller la page générale");
else {
	tmp = f.elements["datas"].value;
	pos1 = tmp.indexOf("Energie")+7;
	tmp = tmp.substr(pos1,100);
	pos1 = tmp.indexOf("OGame")-4;
	tmp = tmp.substring(0,pos1);
	tmp = tmp.split(" ");
	user_build_metal[select_planet-1] = return_num(tmp[0]);
	user_build_cristal[select_planet-1] = return_num(tmp[1]);
	user_build_deut[select_planet-1] = return_num(tmp[2]);
	f.elements["metal" + select_planet].value = user_build_metal[select_planet-1];
	f.elements["cristal" + select_planet].value = user_build_cristal[select_planet-1];
	f.elements["deut" + select_planet].value = user_build_deut[select_planet-1];
	
	ecrit_bd(select_planet,0);
	f.elements["datas"].value = type_planet +" "+ coord_planet +" envoyé en position " + select_planet +" Mémoire 0\n-- Copie de la vue générale à coller ici --";
	}
}

function ecrit_bd(planet, mem) {
	var xhr_object = null;
	if (window.XMLHttpRequest) 
		xhr_object = new XMLHttpRequest();
	else if (window.ActiveXObject) 
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
	else {alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
		return;}

	var data = "planet_id="+planet;
	data += "&mem="+mem;
	if (mem==0) {
		data += "&metal="+user_build_metal[planet-1];
		data += "&cristal="+user_build_cristal[planet-1];
		data += "&deut="+user_build_deut[planet-1];}
	else {
		data += "&metal="+user_build_metal1[planet-1];
		data += "&cristal="+user_build_cristal1[planet-1];
		data += "&deut="+user_build_deut1[planet-1];}

	xhr_object.open("POST","index.php?action=CalculRessources&depuis_ajax=1", true);
	if (mem==0) {
		xhr_object.onreadystatechange = function() {
    		if(xhr_object.readyState == 4) {
      			var tmp = xhr_object.responseText.split("|");
				for (var i=1; i<=2; i++) {eval(tmp[i]);}
		}}
	}
	xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr_object.send(data);
}

</script>
<!-- FIN DU SCRIPT -->

<table>
<form method="POST" name="post2" action="" enctype="multipart/form-data">
<tr>
	<th colspan="2">
    <textarea name="datas" rows="2" onclick='javascript: this.value="";' cols="20">-- Copie de la vue générale à coller ici --</textarea></th>
	<th><input type="button" value="Envoyer" onclick="javascript: requestRess(this.form)"></th>
	<th><input type="button" value="Tout cocher" onclick="javascript: tout_cocher(true)">
	<input type="button" value="Tout décocher" onclick="javascript: tout_cocher(false)"></th>
	<th><input type="button" value="RAZ Total" onclick="javascript: RAZ(-1)">
	<input type="button" style='color: black; background-color: lime' value="RAZ Mem0" onclick="javascript: RAZ(0)">
	<input type="button" style='color: black; background-color: yellow' value="RAZ Mem1" onclick="javascript: RAZ(1)">
	</th>
	<th><input type="button" style='color: black; background-color: lime' value="Vue Mem0" onclick="javascript: Vue(0)">
	<input type="button" style='color: black; background-color: yellow' value="Vue Mem1" onclick="javascript: Vue(1)"></th>
	<th colspan="1">Mod <FONT COLOR="#FFFF00">Calcul Ressources</FONT> créé par <a>Aeris</a><br>Repris par ==></th>
	<th colspan="1"><a href=mailto:varius9@free.fr><img src="mod/CalculRessources/VariusSign.jpg"></a></th>
	<th><a href="index.php?action=CalculRessources&page=changelog">Changelog</a></th>
</tr>
<tr><th width="5%"><a>A Sommer</a></th>
<?php
for ($i=$start ; $i<=$start+$nb_planet-1; $i++) {
		echo "\t"."<th width='5%'><label><input type='checkbox' name='checkbox".$i."' value='".$i."' onclick=Calcul_Ress(this.value)></label></th>"."\n";}
?>
</tr><tr><th><a>Nom Planète</a></th>
<?php
for ($i=$start ; $i<=$start+$nb_planet-1; $i++) {
	echo "\t"."<th style='font-size: 10pt;	font-weight: bold; color: cyan;'>".$user_building[$i]["planet_name"]."</th>"."\n";}
?>
</tr><tr><th><a>Coordonnées</a></th>
<?php
for ($i=$start ; $i<=$start+$nb_planet-1; $i++) {
	echo "\t"."<th>".$user_building[$i]["coordinates"]."</th>"."\n";}
?>
</tr><tr><th><font color='violet'><FONT SIZE="3"><U>L</U>it=>/=><U>E</U>crit</FONT></font>
<br><font color='lime'>Mem0/<font color='yellow'>Mem1</font></th>
<?php
for ($i=$start ; $i<=$start+$nb_planet-1; $i++) {
	echo "\t"."<th class='c' align='center'><input width='15%' style='color: black; background-color: lime' type='button' value='Lit0=>' onclick='javascript: reload(".$i.");'>   <input style='color: black; background-color: lime' type='button' value='=>Ecrit0' onclick='javascript: upload(".$i.");'>
	<br><input style='color: black; background-color: yellow' type='button' value='Lit1=>' onclick='javascript: reload_1(".$i.");'>   <input style='color: black; background-color: yellow' type='button' value='=>Ecrit1' onclick='javascript: upload_1(".$i.");'></th>"."\n";}
?>
</tr><tr><th>Date/Heure</th>
<?php
for ($i=$start ; $i<=$start+$nb_planet-1; $i++) {
	echo "\t"."<th><label><input style='text-align: center;' name='DateH".$i."' value=".date('"j M y  G:i"',strtotime($user_ress[$i]["date_heure"]))." disabled='false'></label></th>"."\n";}
?>
</tr><tr><th>Métal:</th>
<?php
for ($i=$start ; $i<=$start+$nb_planet-1; $i++) {
	echo "\t"."<th><label><input style='text-align: center;' name='metal".$i."' value=".$user_ress[$i]["metal"]."></label></th>"."\n";}
?>
</tr><tr><th>Cristal:</th>
<?php
for ($i=$start ; $i<=$start+$nb_planet-1; $i++) {
	echo "\t"."<th><label><input style='text-align: center;' name='cristal".$i."' value=".$user_ress[$i]["cristal"]."></label></th>"."\n";}
?>
</tr><tr><th>Deuterium:</th>
<?php
for ($i=$start ; $i<=$start+$nb_planet-1; $i++) {
	echo "\t"."<th><label><input style='text-align: center;' name='deut".$i."' value=".$user_ress[$i]["deut"]."></label></th>"."\n";}
?>
</tr><tr><th width="7%"><a>Nb GT</a></th>
<?php
for ($i=$start ; $i<=$start+$nb_planet-1; $i++) {
	echo "\t"."<th><label><input class='menu_on' name='NbGT".$i."' value=0 size='10' disabled='false'></label></th>"."\n";}
?>
</tr><tr><th width="7%"><a>A Sommer</a></th>
<?php
for ($i=$moon_start ; $i<=$moon_start+$nb_planet-1; $i++) {
	echo "\t"."<th><label><input type='checkbox' name='checkbox".$i."' value='".$i."' onclick=Calcul_Ress(this.value)></label></th>"."\n";}
?>
</tr><th><a>Nom Lune</a></th>
<?php
for ($i=$moon_start ; $i<=$moon_start+$nb_planet-1; $i++) {
	$name = $user_building[$i]["planet_name"];
	if ($name == "") $name = "&nbsp;";
	echo "\t"."<th style='font-size: 10pt;	font-weight: bold; color: cyan;'><a>".$name."</a></th>"."\n";}
?>
</tr><tr><th><font color='violet'><FONT SIZE="3"><U>L</U>it=>/=><U>E</U>crit</FONT></font>
<br><font color='lime'>Mem0/<font color='yellow'>Mem1</font></th>
<?php
for ($i=$moon_start ; $i<=$moon_start+$nb_planet-1; $i++) {
	echo "\t"."<th class='c' align='center'><input width='15%' style='color: black; background-color: lime' type='button' value='Lit0=>' onclick='javascript: reload(".$i.");'>   <input style='color: black; background-color: lime' type='button' value='=>Ecrit0' onclick='javascript: upload(".$i.");'>
	<br><input style='color: black; background-color: yellow' type='button' value='Lit1=>' onclick='javascript: reload_1(".$i.");'>   <input style='color: black; background-color: yellow' type='button' value='=>Ecrit1' onclick='javascript: upload_1(".$i.");'></th>"."\n";}
?>
</tr><tr><th>Date/Heure</th>
<?php
for ($i=$moon_start ; $i<=$moon_start+$nb_planet-1; $i++) {
	echo "\t"."<th><label><input style='text-align: center;' name='DateH".$i."' value=".date('"j M y  G:i"',strtotime($user_ress[$i]["date_heure"]))." disabled='false'></label></th>"."\n";}
?>
</tr><tr><th>Métal:</th>
<?php
for ($i=$moon_start ; $i<=$moon_start+$nb_planet-1; $i++) {
	echo "\t"."<th><label><input style='text-align: center;' name='metal".$i."' value=".$user_ress[$i]["metal"]."></label></th>"."\n";}
?>
</tr><tr><th>Cristal:</th>
<?php
for ($i=$moon_start ; $i<=$moon_start+$nb_planet-1; $i++) {
	echo "\t"."<th><label><input style='text-align: center;' name='cristal".$i."' value=".$user_ress[$i]["cristal"]."></label></th>"."\n";}
?>
</tr><tr><th>Deuterium:</th>
<?php
for ($i=$moon_start ; $i<=$moon_start+$nb_planet-1; $i++) {
	echo "\t"."<th><label><input style='text-align: center;' name='deut".$i."' value=".$user_ress[$i]["deut"]."></label></th>"."\n";}
?>
</tr><tr><th width="7%"><a>Nb GT</a></th>
<?php
for ($i=$moon_start ; $i<=$moon_start+$nb_planet-1; $i++) {
	echo "\t"."<th><label><input style='text-align: center;' name='NbGT".$i."' value=0 size='10' disabled='false'></label></th>"."\n";}
?>
</tr>
</form>
</table>
<center>
<table BGCOLOR='red' BORDER="2" WIDTH="90%">
<CAPTION style='font-size: 10pt; font-weight: bold; color: black; background-color: red;'><B>Sommes des ressources cochées</B></CAPTION>
<form method="POST" name="resultat" action="" enctype="multipart/form-data">
	<tr><th width="9%"></th><th width="7%"><a>Total</a></th><th width="3%"><a>Nb GT</a></th><th width="3%"><a>Nb PT</a></th>
	<th width="7%"><a>Ecart</a></th><th width="6%"><a>Besoin Objectif</a></th><th width="10%"><a>Choix Objectif</a></th></tr>
	<tr>
	<th class='titre_obj'>Somme Métal :</th>
	<th><input class='obj' name="Somme_metal" value="" size="20" disabled="false"></th>
	<th><input class='obj' name="NbGT_metal" value="" size="6" disabled="false"></th>
	<th><input class='obj' name="NbPT_metal" value="" size="6" disabled="false"></th>
	<th><input class='obj' name="Ecart_metal" value="" size="8" disabled="false"></th>
	<th><input class='obj' name="Obj_metal" value="0" size="12" onBlur="format_this(this.value,this)"></th>
	<th class='titre_obj'>
		<div>Type :
			<select onchange="create_list(this.value)" name="list_batiment">
				<option selected="Batiment Lune"></option>
				<option value="Batiment">Batiments</option>
				<option value="Batiment Lune">Batiments Lune</option>
				<option value="Techno">Technos</option>
				<option value="Defenses">Défenses</option>
				<option value="Flottes">Flottes</option>
			</select>
		</div>
	</th></tr>
	<tr><th class='titre_obj'>Somme Cristal :</th>
	<th><input class='obj' name="Somme_cristal" value="" size="20" disabled="false"></th>
	<th><input class='obj' name="NbGT_cristal" value="" size="6" disabled="false"></th>
	<th><input class='obj' name="NbPT_cristal" value="" size="6" disabled="false"></th>
	<th><input class='obj' name="Ecart_cristal" value="" size="8" disabled="false"></th>
	<th><input class='obj' name="Obj_cristal" value="0" size="12" onBlur="format_this(this.value,this)"></th>
	<th class='titre_obj'>
		<div>Constructions :
			<select onchange="Calcul_Besoin(document.resultat.list_batiment.value, this.value, return_num(document.resultat.niveau.value))" name="list_const"> 
			</select>
		</div>
	</th></tr>
	<tr><th class='titre_obj'>Somme Deut :</th>
	<th><input class='obj' name="Somme_deut" value="" size="20" disabled="false"></th>
	<th><input class='obj' name="NbGT_deut" value="" size="6" disabled="false"></th>
	<th><input class='obj' name="NbPT_deut" value="" size="6" disabled="false"></th>
	<th><input class='obj' name="Ecart_deut" value="" size="8" disabled="false"></th>
	<th><input class='obj' name="Obj_deut" value="0" size="12" onBlur="format_this(this.value,this)"></th>
	<th class='titre_obj'>Niveau ou Qté</th>
	</tr>
	<tr><th class='titre_obj'>Total :</th>
	<th><input class='obj' name="total_ress" value="" size="20" disabled="false"></th>
	<th><input class='obj' name="total_GT" value="" size="6"  disabled="false"></th>
	<th><input class='obj' name="total_PT" value="" size="6"  disabled="false"></th>
	<th></th>
	<th><input type="button" value="Refresh" onclick="Calcul_Besoin(document.resultat.list_batiment.value, document.resultat.list_const.value, return_num(document.resultat.niveau.value))"></th>
	<th><input class='obj' name="niveau" value=1 size="5" onchange="Calcul_Besoin(document.resultat.list_batiment.value, document.resultat.list_const.value, this.value)" onBlur="format_this(this.value,this)"></th></tr>
</form>
</table>
</center>

<!-- DEBUT DU SCRIPT -->
<SCRIPT type="text/JavaScript">
function RAZ(mem) {
	for (var i = 0; i <= nb_planet ; i++) {
		if (mem==0 || mem==-1) {
			user_build_metal[i] = 0;
			user_build_cristal[i] = 0;
			user_build_deut[i] = 0;
			user_build_dh[i]="";}
		if (mem==1 || mem==-1) {
			user_build_metal1[i] = 0;
			user_build_cristal1[i] = 0;
			user_build_deut1[i] = 0;}	
	}

	var xhr_object = null;
	if(window.XMLHttpRequest) // Firefox
		xhr_object = new XMLHttpRequest();
	else if(window.ActiveXObject) // Internet Explorer
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
	else { // XMLHttpRequest non supporté par le navigateur
		alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
		return;}
	xhr_object.open("GET","index.php?action=CalculRessources&depuis_ajax=2&mem=" + mem, true);
	xhr_object.onreadystatechange = function() {
  		if(xhr_object.readyState == 4) {
      		var tmp = xhr_object.responseText.split(":");
			eval(tmp[1]);}
	}
	xhr_object.send(null); //envoie la requéte
}

function tout_cocher(etat) {
for ($i=$start ; $i<=$start+$nb_planet-1; $i++)
	document.forms.post2.elements["checkbox"+i].checked = etat;
for ($i=$moon_start ; $i<=$moon_start+$nb_planet-1; $i++)
	document.forms.post2.elements["checkbox"+i].checked = etat;
Calcul_Ress (null);
}

function changeCouleur(num) {
if (num) {
	if (document.forms.post2.elements["checkbox"+num].checked == true) {
		document.forms["post2"].elements["metal"+num].style.color = 'red';
		document.forms["post2"].elements["cristal"+num].style.color = 'red';
		document.forms["post2"].elements["deut"+num].style.color = 'red';
		document.forms["post2"].elements["metal"+num].style.background = 'yellow';
		document.forms["post2"].elements["cristal"+num].style.background = 'yellow';
		document.forms["post2"].elements["deut"+num].style.background = 'yellow';}
	else {
		document.forms["post2"].elements["metal"+num].style.color = 'white';
		document.forms["post2"].elements["cristal"+num].style.color = 'white';
		document.forms["post2"].elements["deut"+num].style.color = 'white';
		document.forms["post2"].elements["metal"+num].style.background = 'black';
		document.forms["post2"].elements["cristal"+num].style.background = 'black';
		document.forms["post2"].elements["deut"+num].style.background = 'black';}
}}

function Calcul_Ress (num) {
var totalM = 0;
var totalC = 0;
var totalD = 0;
var totalGT = 0;
var Obj_M = 0;
var Obj_C = 0;
var Obj_D = 0;
var i = 0;
var tmp = 0;

Obj_M = return_num(document.forms.resultat.Obj_metal.value);
Obj_C = return_num(document.forms.resultat.Obj_cristal.value);
Obj_D = return_num(document.forms.resultat.Obj_deut.value);


for ($i=$start ; $i<=$start+$nb_planet-1; $i++) {
	if (document.forms.post2.elements["checkbox"+i].checked == true) {
		totalGT =0;
		tmp = parseInt(document.forms.post2.elements["metal"+i].value);
		if (!isNaN(tmp)) {totalM += tmp; totalGT = tmp;} else document.forms.post2.elements["metal"+i].value=0;
		tmp = parseInt(document.forms.post2.elements["cristal"+i].value);
		if (!isNaN(tmp)) {totalC += tmp; totalGT += tmp;} else document.forms.post2.elements["cristal"+i].value=0;
		tmp = parseInt(document.forms.post2.elements["deut"+i].value);
		if (!isNaN(tmp)) {totalD += tmp; totalGT += tmp;} else document.forms.post2.elements["deut"+i].value=0;
		document.forms.post2.elements["NbGT"+i].value = format(Math.ceil(totalGT/25000));}
	changeCouleur(i);
}
for ($i=$moon_start ; $i<=$moon_start+$nb_planet-1; $i++) {
	if (document.forms.post2.elements["checkbox"+i].checked == true) {
		totalGT =0;
		tmp = parseInt(document.forms.post2.elements["metal"+i].value);
		if (!isNaN(tmp)) {totalM += tmp; totalGT = tmp;} else document.forms.post2.elements["metal"+i].value=0;
		tmp = parseInt(document.forms.post2.elements["cristal"+i].value);
		if (!isNaN(tmp)) {totalC += tmp; totalGT += tmp;} else document.forms.post2.elements["cristal"+i].value=0;
		tmp = parseInt(document.forms.post2.elements["deut"+i].value);
		if (!isNaN(tmp)) {totalD += tmp; totalGT += tmp;} else document.forms.post2.elements["deut"+i].value=0;
		document.forms.post2.elements["NbGT"+i].value = format(Math.ceil(totalGT/25000));}
	changeCouleur(i);
}
document.forms.resultat.Somme_metal.value = format(totalM);
document.forms.resultat.Somme_cristal.value = format(totalC);
document.forms.resultat.Somme_deut.value = format(totalD);
i = totalM + totalD + totalC
document.forms.resultat.total_ress.value = format(i);
document.forms.resultat.NbGT_metal.value = format(Math.ceil(totalM/25000));
document.forms.resultat.NbGT_cristal.value = format(Math.ceil(totalC/25000));
document.forms.resultat.NbGT_deut.value = format(Math.ceil(totalD/25000));
document.forms.resultat.total_GT.value = format(Math.ceil(i/25000));
document.forms.resultat.NbPT_metal.value = format(Math.ceil(totalM/5000));
document.forms.resultat.NbPT_cristal.value = format(Math.ceil(totalC/5000));
document.forms.resultat.NbPT_deut.value = format(Math.ceil(totalD/5000));
document.forms.resultat.total_PT.value = format(Math.ceil(i/5000));
tmp = totalM - Obj_M;
if (tmp>0) document.forms.resultat.Ecart_metal.style.color = 'white';
else document.forms.resultat.Ecart_metal.style.color = 'red';
document.forms.resultat.Ecart_metal.value = format(tmp);

tmp = totalC - Obj_C;
if (tmp>0) document.forms.resultat.Ecart_cristal.style.color = 'white';
else document.forms.resultat.Ecart_cristal.style.color = 'red';
document.forms.resultat.Ecart_cristal.value = format(tmp);

tmp = totalD - Obj_D;
if (tmp>0) document.forms.resultat.Ecart_deut.style.color = 'white';
else document.forms.resultat.Ecart_deut.style.color = 'red';
document.forms.resultat.Ecart_deut.value = format(tmp);

}

function Vue(mem) {
	for ($i=$start ; $i<=$start+$nb_planet-1; $i++) {if (mem==0) reload(i); else reload_1(i);}
	for ($i=$moon_start ; $i<=$moon_start+$nb_planet-1; $i++) {if (mem==0) reload(i); else reload_1(i);}
}

function reload(select) {
if (user_build_metal[select-1] == undefined) document.forms["post2"].elements["metal"+select].value = 0;
else document.forms["post2"].elements["metal"+select].value = user_build_metal[select-1];

if (user_build_cristal[select-1] == undefined) document.forms["post2"].elements["cristal"+select].value = 0;
else document.forms["post2"].elements["cristal"+select].value = user_build_cristal[select-1];

if (user_build_deut[select-1] == undefined) document.forms["post2"].elements["deut"+select].value = 0;
else document.forms["post2"].elements["deut"+select].value = user_build_deut[select-1];

document.forms["post2"].elements["DateH"+select].value = user_build_dh[select-1];
Calcul_Ress ();}

function reload_1(select) {
if (user_build_metal1[select-1] == undefined) document.forms["post2"].elements["metal"+select].value = 0;
else document.forms["post2"].elements["metal"+select].value = user_build_metal1[select-1];

if (user_build_cristal1[select-1] == undefined) document.forms["post2"].elements["cristal"+select].value = 0;
else document.forms["post2"].elements["cristal"+select].value = user_build_cristal1[select-1];

if (user_build_deut1[select-1] == undefined) document.forms["post2"].elements["deut"+select].value = 0;
else document.forms["post2"].elements["deut"+select].value = user_build_deut1[select-1];

document.forms["post2"].elements["DateH"+select].value = "";
Calcul_Ress ();}

function upload(select) { // permet de forcer une valeur dans la BD
	var tmpM = parseInt(document.forms["post2"].elements["metal"+select].value);
	var tmpC = parseInt(document.forms["post2"].elements["cristal"+select].value);
	var tmpD = parseInt(document.forms["post2"].elements["deut"+select].value);
	if (isNaN(tmpM) || isNaN(tmpC) || isNaN(tmpD))
		alert("Mauvaise entrée dans les cellules ressources, Numérique obligatoire");
	else {
		user_build_metal[select-1] = tmpM;
		document.forms["post2"].elements["metal"+select].value = tmpM;
		user_build_cristal[select-1] = tmpC;
		document.forms["post2"].elements["cristal"+select].value = tmpC;
		user_build_deut[select-1] = tmpD;
		document.forms["post2"].elements["deut"+select].value = tmpD;
		if (document.forms.post2.elements["checkbox"+select].checked == true)
			Calcul_Ress ();
		ecrit_bd(select,0);}
}

function upload_1(select) { // permet de forcer une valeur dans la BD
	var tmpM = parseInt(document.forms["post2"].elements["metal"+select].value);
	var tmpC = parseInt(document.forms["post2"].elements["cristal"+select].value);
	var tmpD = parseInt(document.forms["post2"].elements["deut"+select].value);
	if (isNaN(tmpM) || isNaN(tmpC) || isNaN(tmpD))
		alert("Mauvaise entrée dans les cellules ressources, Numérique obligatoire");
	else {
		user_build_metal1[select-1] = tmpM;
		document.forms["post2"].elements["metal"+select].value = tmpM;
		user_build_cristal1[select-1] = tmpC;
		document.forms["post2"].elements["cristal"+select].value = tmpC;
		user_build_deut1[select-1] = tmpD;
		document.forms["post2"].elements["deut"+select].value = tmpD;
		if (document.forms.post2.elements["checkbox"+select].checked == true)
			Calcul_Ress ();
		ecrit_bd(select,1);}
}
</script>
<!-- FIN DU SCRIPT -->

<?php
require_once("./mod/calculressources/pied_CalculR.php");
require_once("views/page_tail.php");
?>
</body>
</html>