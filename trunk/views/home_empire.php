<?php
/***************************************************************************
*	filename	: home_empire.php
*	desc.		:
*	Author		: Kyser - http://ogsteam.fr/
*	created		: 17/12/2005
*	modified	: 30/04/2007 03:40:00
***************************************************************************/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}

require_once("includes/spacecon.php");
require_once("parameters/lang_empire.php");

$user_empire = user_get_empire();
$user_building = $user_empire["building"];
$user_defence = $user_empire["defence"];
$user_technology = $user_empire["technology"];

if(!isset($pub_view) || $pub_view=="") $view = "planets";
elseif ($pub_view == "planets" || $pub_view == "moons") $view = $pub_view;
else $view = "planets";
$start = $view=="planets" ? 1 : 10;
?>

<!-- DEBUT DU SCRIPT -->
<script language="JavaScript">
<?php
if(isset($pub_alert_empire) && $pub_alert_empire) echo 'message("Pensez à renseigner, si besoin est, les noms de planètes et les températures\nqui ne peuvent pas être récupérés par la page Empire d\'spacecon.");';

$name = $coordinates = $fields = $temperature = $reflecteur = "";
for ($i=1 ; $i<=9 ; $i++) {
	$name .= "'".$user_building[$i]["planet_name"]."', ";
	$coordinates .= "'".$user_building[$i]["coordinates"]."', ";
	$fields .= "'".$user_building[$i]["fields"]."', ";
	$temperature .= "'".$user_building[$i]["temperature"]."', ";
	$reflecteur .= "'".$user_building[$i]["ReSo"]."', ";
}

for ($i=10 ; $i<=18 ; $i++) {
	$name .= "'Lune', ";
	$coordinates .= "'', ";
	$fields .= "'1', ";
	$temperature .= "'".$user_building[$i]["temperature"]."', ";
	$reflecteur .= "'".$user_building[$i]["ReSo"]."', ";
}

echo "var name = new Array(".substr($name, 0, strlen($name)-2).");"."\n";
echo "var coordinates = new Array(".substr($coordinates, 0, strlen($coordinates)-2).");"."\n";
echo "var fields = new Array(".substr($fields, 0, strlen($fields)-2).");"."\n";
echo "var temperature = new Array(".substr($temperature, 0, strlen($temperature)-2).");"."\n";
echo "var reflecteur = new Array(".substr($reflecteur, 0, strlen($reflecteur)-2).");"."\n";
?>
var select_planet = false;

function autofill(planet_id, planet_selected) {
	document.getElementById('planet_name').style.visibility = 'visible';
	document.getElementById('planet_name').disabled = false;

	document.getElementById('coordinates').style.visibility = 'visible';
	document.getElementById('coordinates').disabled = false;

	document.getElementById('fields').style.visibility = 'visible';
	document.getElementById('fields').disabled = false;

	document.getElementById('temperature').style.visibility = 'visible';
	document.getElementById('temperature').disabled = false;

	document.getElementById('reflecteur').style.visibility = 'visible';
	document.getElementById('reflecteur').disabled = false;

	//	if (name[(planet_id-1)] == "" && coordinates[(planet_id-1)] == "" && fields[(planet_id-1)] == "" && temperature[(planet_id-1)] == "" && reflecteur[(planet_id-1)] == "") {
	//		return;
	//	}

	document.getElementById('planet_name').value = name[(planet_id-1)];
	document.getElementById('coordinates').value = coordinates[(planet_id-1)];
	document.getElementById('fields').value = fields[(planet_id-1)];
	document.getElementById('temperature').value = temperature[(planet_id-1)];
	document.getElementById('reflecteur').value = reflecteur[(planet_id-1)];

	var i = 1;
	var lign = 0;
	var id = 0;
	var lim = 40;
	if(planet_id > 9) {
		lim = 17;
		planet_id -= 9;
	}
	for(i = 1; i <= 9; i++) {
		for(lign = 1; lign <= lim; lign++) {
			id = lign*10+i;
			document.getElementById(id).style.color = 'lime';
		}
	}

	for(i = 1; i <= lim; i++) {
		id = i*10+planet_id;
		document.getElementById(id).style.color = 'yellow';
	}

	return(true);
}

function clear_text2() {
	if (document.post2.data.value == "Empire & Bâtiments & Laboratoire & Défenses") {
		document.post2.data.value = "";
	}
}

function message(msg) {
	alert("\n"+msg);
}
</script>
<!-- FIN DU SCRIPT -->

<table width="100%">
<tr>
	<td class="c" colspan="10">Collez les informations et sélectionnez une planète pour les y assigner</td>
</tr>
<tr>
<?php
if ($view == "planets") {
	echo "<th colspan='5'><a>Planètes</a></th>";
	echo "<td class='c' align='center' colspan='5' onClick=\"window.location = 'index.php?action=home&view=moons';\"><a style='cursor:pointer'><font color='lime'>Lunes</font></a></td>";
}
else {
	echo "<td class='c' align='center' colspan='5' onClick=\"window.location = 'index.php?action=home&view=planets';\"><a style='cursor:pointer'><font color='lime'>Planètes</font></a></td>";
	echo "<th colspan='5'><a>Lunes</a></th>";
}
?>
	<!--<th colspan="5" onClick="window.location = 'index.php?action=home&view=planets';"><center><a style='cursor:pointer'>Planètes</a></center></th>
	<th colspan="5" onClick="window.location = 'index.php?action=home&view=moons';"><center><a style='cursor:pointer'>Lunes</a></center></th>-->
	</tr>
<form method="POST" name="post2" enctype="multipart/form-data" action="index.php">
<tr>
	<input type="hidden" name="action" value="set_empire">
	<input type="hidden" name="view" value="<?php echo $view; ?>">
	<th><a>Collez les infos ici</a></th>
	<th colspan="5"><textarea name="data" rows="2"  onFocus="clear_text2()">Empire & Bâtiments & Laboratoire & Défenses</textarea></th>	
	<th colspan="3"><input name="typedata" value="E" id="empire" type="radio"/ checked><a>Empire</a> (<?php echo $view=="moons" ? "lunes" : "planètes"; ?>)&nbsp;<?php echo help("home_commandant");?><br />
	<input name="typedata" id="building" value="B" type="radio" onclick="if(!select_planet) message('Vous devez sélectionner une planète');"> <a>Bâtiments</a><input name="typedata" value="D" type="radio" onclick="if(!select_planet) message('Vous devez selectionner une planete');"> <a>Défenses</a>
	<?php if($view=="planets") echo '<input name="typedata" value="T" type="radio"> <a>Technologies</a>' ?></th>
	<th><input type="submit" value="Envoyer"></th>
</tr>
<tr>
	<th width="10%"><a>Sélectionnez une planète</a></th>
	<th width="10%"><input name="planet_id" value="<?php echo $view=="planets" ? 1 : 1+9; ?>" type="radio" onclick="select_planet = autofill(<?php echo $view=="planets" ? 1 : 1+9; ?>);if (document.getElementById('empire').checked == true) document.getElementById('building').checked=true;"><?php if($view=="moons") echo "<br />".$user_building[1]["planet_name"]; ?></th>
	<th width="10%"><input name="planet_id" value="<?php echo $view=="planets" ? 2 : 2+9; ?>" type="radio" onclick="select_planet = autofill(<?php echo $view=="planets" ? 2 : 2+9; ?>);if (document.getElementById('empire').checked == true) document.getElementById('building').checked=true;"><?php if($view=="moons") echo "<br />".$user_building[2]["planet_name"]; ?></th>
	<th width="10%"><input name="planet_id" value="<?php echo $view=="planets" ? 3 : 3+9; ?>" type="radio" onclick="select_planet = autofill(<?php echo $view=="planets" ? 3 : 3+9; ?>);if (document.getElementById('empire').checked == true) document.getElementById('building').checked=true;"><?php if($view=="moons") echo "<br />".$user_building[3]["planet_name"]; ?></th>
	<th width="10%"><input name="planet_id" value="<?php echo $view=="planets" ? 4 : 4+9; ?>" type="radio" onclick="select_planet = autofill(<?php echo $view=="planets" ? 4 : 4+9; ?>);if (document.getElementById('empire').checked == true) document.getElementById('building').checked=true;"><?php if($view=="moons") echo "<br />".$user_building[4]["planet_name"]; ?></th>
	<th width="10%"><input name="planet_id" value="<?php echo $view=="planets" ? 5 : 5+9; ?>" type="radio" onclick="select_planet = autofill(<?php echo $view=="planets" ? 5 : 5+9; ?>);if (document.getElementById('empire').checked == true) document.getElementById('building').checked=true;"><?php if($view=="moons") echo "<br />".$user_building[5]["planet_name"]; ?></th>
	<th width="10%"><input name="planet_id" value="<?php echo $view=="planets" ? 6 : 6+9; ?>" type="radio" onclick="select_planet = autofill(<?php echo $view=="planets" ? 6 : 6+9; ?>);if (document.getElementById('empire').checked == true) document.getElementById('building').checked=true;"><?php if($view=="moons") echo "<br />".$user_building[6]["planet_name"]; ?></th>
	<th width="10%"><input name="planet_id" value="<?php echo $view=="planets" ? 7 : 7+9; ?>" type="radio" onclick="select_planet = autofill(<?php echo $view=="planets" ? 7 : 7+9; ?>);if (document.getElementById('empire').checked == true) document.getElementById('building').checked=true;"><?php if($view=="moons") echo "<br />".$user_building[7]["planet_name"]; ?></th>
	<th width="10%"><input name="planet_id" value="<?php echo $view=="planets" ? 8 : 8+9; ?>" type="radio" onclick="select_planet = autofill(<?php echo $view=="planets" ? 8 : 8+9; ?>);if (document.getElementById('empire').checked == true) document.getElementById('building').checked=true;"><?php if($view=="moons") echo "<br />".$user_building[8]["planet_name"]; ?></th>
	<th width="10%"><input name="planet_id" value="<?php echo $view=="planets" ? 9 : 9+9; ?>" type="radio" onclick="select_planet = autofill(<?php echo $view=="planets" ? 9 : 9+9; ?>);if (document.getElementById('empire').checked == true) document.getElementById('building').checked=true;"><?php if($view=="moons") echo "<br />".$user_building[9]["planet_name"]; ?></th>
</tr>
<tr>
<?php
if($view == "planets") {
?>
	<th><a>Nom de la planète</a></th>
	<th><input type="text" id="planet_name" name="planet_name" size="15" maxlength="20" disabled></th>
	<th><a>Coordonnées (par ex 3:100:10)</a></th>
	<th><input type="text" id="coordinates" name="coordinates" size="10" maxlength="10" disabled></th>
	<th><a>Nombre de cases</a></th>
	<th><input type="text" id="fields" name="fields" size="8" maxlength="3" disabled></th>
	<th><a>Température Max</a></th>
	<th><input type="text" id="temperature" name="temperature" size="8" maxlength="3" disabled></th>
	<th><a>Nombre de réflecteurs</a></th>
	<th><input type="text" id="reflecteur" name="reflecteur" size="8" maxlength="5" disabled></th>
<?php
} // fin de si view="planets"
else {
?>
	<th></th>
	<input type="hidden" id="planet_name" name="planet_name" disabled>
	<input type="hidden" id="fields" name="fields" disabled>
	<input type="hidden" id="coordinates" name="coordinates" disabled>
	<th colspan="2"><a>Température Max</a></th>
	<th><input type="text" id="temperature" name="temperature" size="8" maxlength="3" disabled></th>
	<th colspan="2"><a>Réflecteur</a></th>
	<th><input type="text" id="reflecteur" name="reflecteur" size="8" maxlength="5" disabled></th>
	<th></th>
	<th></th>
	<th></th>
<?php
} // fin de sinon view="planets"
?>
</tr>
<!-- DEBUT DU SCRIPT -->
<script language="JavaScript">
document.getElementById('planet_name').style.visibility='hidden';
document.getElementById('coordinates').style.visibility='hidden';
document.getElementById('fields').style.visibility='hidden';
document.getElementById('temperature').style.visibility='hidden';
document.getElementById('reflecteur').style.visibility='hidden';
</script>
<!-- FIN DU SCRIPT -->
</form>
<tr>
	<td class="c" colspan="10">Vue d'ensemble de votre empire</td>
</tr>
<tr>
	<th>&nbsp;</th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	echo "<th>";
	if (!isset($pub_view) || $pub_view == "planets")
	echo "<input type='image' title='Déplacer la planète ".$user_building[$i]["planet_name"]." vers la gauche' src='images/previous.png' onclick=\"window.location = 'index.php?action=move_planet&planet_id=".$i."&view=".$view."&left';\">&nbsp;&nbsp";
	echo "<input type='image' title='Supprimer la planète ".$user_building[$i]["planet_name"]."' src='images/drop.png' onclick=\"window.location = 'index.php?action=del_planet&planet_id=".$i."&view=".$view."';\">&nbsp;&nbsp;";
	if (!isset($pub_view) || $pub_view == "planets")
	echo "<input type='image' title='Déplacer la planète ".$user_building[$i]["planet_name"]." vers la droite' src='images/next.png' onclick=\"window.location = 'index.php?action=move_planet&planet_id=".$i."&view=".$view."&right';\">";
	echo "</th>";
}
?>
</tr>
<tr>
	<th><a>Nom</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$name = $user_building[$i]["planet_name"];
	if ($name == "") $name = "&nbsp;";

	echo "\t"."<th><a>".$name."</a></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Coordonnées</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$coordinates = $user_building[$i]["coordinates"];
	if ($coordinates == "" || ($user_building[$i+9]["planet_name"] == "" && $view=="moons")) $coordinates = "&nbsp;";
	else $coordinates = "[".$coordinates."]";

	echo "\t"."<th>".$coordinates."</th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Cases</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$fields = $user_building[$i]["fields"];
	if ($fields == "0") $fields = 0;
	$fields_used = $user_building[$i]["fields_used"];
	$CrAt = $user_building[$i]["CrAt"];
	if ($CrAt == "") $CrAt = 0;

	echo "\t"."<th>".$fields_used." / ". ($fields!=0 ? ($fields+3*$CrAt) : "") ."</th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Température</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$temperature = $user_building[$i]["temperature"];
	if ($temperature == "") $temperature = "&nbsp;";

	echo "\t"."<th>".$temperature."</th>"."\n";
}

if($view == "planets") {
?>
</tr>
<tr>
	<td class="c" colspan="10">Production théorique</td>
</tr>
<tr>
	<th><a>Acier</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$M = $user_building[$i]["M"];
	if ($M != "") $production = production("M", $M);
	else $production = "&nbsp";

	echo "\t"."<th>".$production."</th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Silicium</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$C = $user_building[$i]["C"];
	if ($C != "") $production = production("C", $C);
	else $production = "&nbsp";

	echo "\t"."<th>".$production."</th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Deutéride</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$D = $user_building[$i]["D"];
	$temperature = $user_building[$i]["temperature"];
	$CEF = $user_building[$i]["CEF"];
	$CEF_consumption = consumption("CEF", $CEF);
	if ($D != "") $production = production("D", $D, $temperature) - $CEF_consumption;
	else $production = "&nbsp";

	echo "\t"."<th>".$production."</th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Energie</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$CES = $user_building[$i]["CES"];
	$CEF = $user_building[$i]["CEF"];
	$ReSo = $user_building[$i]["ReSo"];
	$temperature = $user_building[$i]["temperature"];

	$production_CES = $production_CEF = $production_ReSo = 0;
	$production_CES = production("CES", $CES);
	$production_CEF = production("CEF", $CEF);
	$production_ReSo = production_ReSo($temperature) * $ReSo;

	$production = $production_CES + $production_CEF + $production_ReSo;
	if ($production == 0) $production = "&nbsp";

	echo "\t"."<th>".$production."</th>"."\n";
}
?>
</tr>
<tr>
	<td class="c" colspan="10">Bâtiments</td>
</tr>
<tr>
	<th><a>Mine de Acier</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$M = $user_building[$i]["M"];
	if ($M == "") $M = "&nbsp;";

	echo "\t"."<th><font color='lime' id='15".($i+1-$start)."'>".$M."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Mine de Silicium</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$C = $user_building[$i]["C"];
	if ($C == "") $C = "&nbsp;";

	echo "\t"."<th><font color='lime' id='16".($i+1-$start)."'>".$C."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Synthétiseur de Deutéride</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$D = $user_building[$i]["D"];
	if ($D == "") $D = "&nbsp;";

	echo "\t"."<th><font color='lime' id='17".($i+1-$start)."'>".$D."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Centrale électrique solaire</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$CES = $user_building[$i]["CES"];
	if ($CES == "") $CES = "&nbsp;";

	echo "\t"."<th><font color='lime' id='20".($i+1-$start)."'>".$CES."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Centrale électrique de fusion</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$CEF = $user_building[$i]["CEF"];
	if ($CEF == "") $CEF = "&nbsp;";

	echo "\t"."<th><font color='lime' id='21".($i+1-$start)."'>".$CEF."</font></th>"."\n";
}

} // fin de si view="planets"
else echo '</tr><tr> <td class="c" colspan="10">Bâtiments</td>';
?>
</tr>
<tr><th><a>Usine de robots</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$UdR = $user_building[$i]["UdR"];
	if ($UdR == "") $UdR = "&nbsp;";

	echo "\t"."<th><font color='lime' id='1".($i+1-$start)."'>".$UdR."</font></th>"."\n";
}

if($view == "planets") {
?>
</tr>
<tr>
	<th><a>Usine de nanites</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$UdN = $user_building[$i]["UdN"];
	if ($UdN == "") $UdN = "&nbsp;";

	echo "\t"."<th><font color='lime' id='22".($i+1-$start)."'>".$UdN."</font></th>"."\n";
}

} // fin de si view="planets"
?>
</tr>
<tr>
	<th><a>Chantier spatial</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$CSp = $user_building[$i]["CSp"];
	if ($CSp == "") $CSp = "&nbsp;";

	echo "\t"."<th><font color='lime' id='2".($i+1-$start)."'>".$CSp."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Hangar de Acier</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$HM = $user_building[$i]["HM"];
	if ($HM == "") $HM = "&nbsp;";

	echo "\t"."<th><font color='lime' id='3".($i+1-$start)."'>".$HM."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Hangar de Silicium</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$HC = $user_building[$i]["HC"];
	if ($HC == "") $HC = "&nbsp;";

	echo "\t"."<th><font color='lime' id='4".($i+1-$start)."'>".$HC."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Réservoir de Deutéride</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$HD = $user_building[$i]["HD"];
	if ($HD == "") $HD = "&nbsp;";

	echo "\t"."<th><font color='lime' id='5".($i+1-$start)."'>".$HD."</font></th>"."\n";
}

if($view == "planets") {
?>
</tr>
<tr>
	<th><a>Laboratoire de recherche</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$Lab = $user_building[$i]["Lab"];
	if ($Lab == "") $Lab = "&nbsp;";

	echo "\t"."<th><font color='lime' id='23".($i+1-$start)."'>".$Lab."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Centre de communication</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$CdC = $user_building[$i]["CdC"];
	if ($CdC == "") $CdC = "&nbsp;";

	echo "\t"."<th><font color='lime' id='24".($i+1-$start)."'>".$CdC."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Silo de missiles</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$Silo = $user_building[$i]["Silo"];
	if ($Silo == "") $Silo = "&nbsp;";

	echo "\t"."<th><font color='lime' id='25".($i+1-$start)."'>".$Silo."</font></th>"."\n";
}

} // fin de si view="planets"
else {
?>
</tr>
<tr>
	<th><a>Créateur d'atmosphère</a></th>
<?php
for ($i=10 ; $i<=18 ; $i++) {
	$CrAt = $user_building[$i]["CrAt"];
	if ($CrAt == "") $CrAt = "&nbsp;";

	echo "\t"."<th><font color='lime' id='15".($i+1-$start)."'>".$CrAt."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Capteur spatial</a></th>
<?php
for ($i=10 ; $i<=18 ; $i++) {
	$CaSp = $user_building[$i]["CaSp"];
	if ($CaSp == "") $CaSp = "&nbsp;";

	echo "\t"."<th><font color='lime' id='16".($i+1-$start)."'>".$CaSp."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Générateur de trous noir</a></th>
<?php
for ($i=10 ; $i<=18 ; $i++) {
	$GTN = $user_building[$i]["GTN"];
	if ($GTN == "") $GTN = "&nbsp;";

	echo "\t"."<th><font color='lime' id='17".($i+1-$start)."'>".$GTN."</font></th>"."\n";
}

} // fin de sinon view="planets"
?>
</tr>
<tr>
	<td class="c" colspan="10">Divers</td>
</tr>
<tr>
	<th><a>Réflecteur</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$ReSo = $user_building[$i]["ReSo"];
	if ($ReSo == "") $ReSo = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i+1-$start)."'>".$ReSo."</font></th>"."\n";
}

if($view == "planets") {
?>
</tr>
<tr>
	<td class="c" colspan="10">Technologies</td>
</tr>
<tr>
	<th><a>Technologie Espionnage</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$Lab = $user_building[$i]["Lab"];
	$Esp = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Esp = $user_technology["Esp"] != "" ? $user_technology["Esp"] : "0";
		$requirement = $technology_requirement["Esp"];

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

	echo "\t"."<th><font color='lime' id='26".(($i+1-$start))."'>".$Esp."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Technologie Gestion</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$Lab = $user_building[$i]["Lab"];
	$Gestion= "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Gestion= $user_technology["Gestion"] != "" ? $user_technology["Gestion"] : "0";
		$requirement = $technology_requirement["Gestion"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $Gestion= "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Gestion= "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='27".($i+1-$start)."'>".$Gestion."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Technologie Armes</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$Lab = $user_building[$i]["Lab"];
	$Armes = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Armes = $user_technology["Armes"] != "" ? $user_technology["Armes"] : "0";
		$requirement = $technology_requirement["Armes"];

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

	echo "\t"."<th><font color='lime' id='28".($i+1-$start)."'>".$Armes."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Technologie Bouclier</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$Lab = $user_building[$i]["Lab"];
	$Bouclier = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Bouclier = $user_technology["Bouclier"] != "" ? $user_technology["Bouclier"] : "0";
		$requirement = $technology_requirement["Bouclier"];

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

	echo "\t"."<th><font color='lime' id='29".($i+1-$start)."'>".$Bouclier."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Technologie Blindage</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$Lab = $user_building[$i]["Lab"];
	$Blindage = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Blindage = $user_technology["Blindage"] != "" ? $user_technology["Blindage"] : "0";
		$requirement = $technology_requirement["Blindage"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $Blindage = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Blindage = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='30".($i+1-$start)."'>".$Blindage."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Technologie Energie</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$Lab = $user_building[$i]["Lab"];
	$NRJ = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$NRJ = $user_technology["NRJ"] != "" ? $user_technology["NRJ"] : "0";
		$requirement = $technology_requirement["NRJ"];

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

	echo "\t"."<th><font color='lime' id='31".($i+1-$start)."'>".$NRJ."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Technologie Hyperespace</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$Lab = $user_building[$i]["Lab"];
	$Hyp = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Hyp = $user_technology["Hyp"] != "" ? $user_technology["Hyp"] : "0";
		$requirement = $technology_requirement["Hyp"];

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

	echo "\t"."<th><font color='lime' id='32".($i+1-$start)."'>".$Hyp."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Réacteur à combustion</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$Lab = $user_building[$i]["Lab"];
	$RC = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$RC = $user_technology["RC"] != "" ? $user_technology["RC"] : "0";
		$requirement = $technology_requirement["RC"];

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

	echo "\t"."<th><font color='lime' id='33".($i+1-$start)."'>".$RC."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Réacteur à impulsion</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$Lab = $user_building[$i]["Lab"];
	$RI = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$RI = $user_technology["RI"] != "" ? $user_technology["RI"] : "0";
		$requirement = $technology_requirement["RI"];

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

	echo "\t"."<th><font color='lime' id='34".($i+1-$start)."'>".$RI."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Propulsion hyperespace</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$Lab = $user_building[$i]["Lab"];
	$PH = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$PH = $user_technology["PH"] != "" ? $user_technology["PH"] : "0";
		$requirement = $technology_requirement["PH"];

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

	echo "\t"."<th><font color='lime' id='35".($i+1-$start)."'>".$PH."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Technologie Laser</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$Lab = $user_building[$i]["Lab"];
	$Laser = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Laser = $user_technology["Laser"] != "" ? $user_technology["Laser"] : "0";
		$requirement = $technology_requirement["Laser"];

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

	echo "\t"."<th><font color='lime' id='36".($i+1-$start)."'>".$Laser."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Technologie Ions</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$Lab = $user_building[$i]["Lab"];
	$Ions = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Ions = $user_technology["Ions"] != "" ? $user_technology["Ions"] : "0";
		$requirement = $technology_requirement["Ions"];

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

	echo "\t"."<th><font color='lime' id='37".($i+1-$start)."'>".$Ions."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Technologie Plasma</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$Lab = $user_building[$i]["Lab"];
	$Plasma = "&nbsp;";
	if ($user_building[$i][0] == true) {
		$Plasma = $user_technology["Plasma"] != "" ? $user_technology["Plasma"] : "0";
		$requirement = $technology_requirement["Plasma"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key === 0) {
				if ($Lab < $value){ $Plasma = "-";} 
			}
			elseif ($user_technology[$key] < $value) {
				$Plasma = "-";
			}
			next($requirement);
		}
	}
	echo "\t"."<th><font color='lime' id='38".($i+1-$start)."'>".$Plasma."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Technologie Anti-matiere</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$Lab = $user_building[$i]["Lab"];
	$Antimatiere = "&nbsp;";

	if ($user_building[$i][0] == true) {
		$Antimatiere = $user_technology["Antimatiere"] != "" ? $user_technology["Antimatiere"] : "0";
		$requirement = $technology_requirement["Antimatiere"];

		while ($value = current($requirement)) {
			$key = key($requirement);
			if ($key == 0) {
				if ($Lab < $value) $Antimatiere = "-";
			}
			elseif ($user_technology[$key] < $value) {
				$Antimatiere = "-";
			}
			next($requirement);
		}
	}

	echo "\t"."<th><font color='lime' id='40".($i+1-$start)."'>".$Antimatiere."</font></th>"."\n";
}
?>
</tr>
<tr>
	<td class="c" colspan="10">Défenses</td>
</tr>
<tr>
	<th><a>Canon automatique</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$CA= $user_defence[$i]["CA"];
	if ($CA == "") $CA = "&nbsp;";

	echo "\t"."<th><font color='lime' id='7".($i+1-$start)."'>".$CA."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Tourelle lance missiles</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$TLM = $user_defence[$i]["TLM"];
	if ($TLM == "") $TLM = "&nbsp;";

	echo "\t"."<th><font color='lime' id='8".($i+1-$start)."'>".$TLM."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Artillerie sol-air</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$ASA = $user_defence[$i]["ASA"];
	if ($ASA == "") $ASA = "&nbsp;";

	echo "\t"."<th><font color='lime' id='9".($i+1-$start)."'>".$ASA."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Canon à proton</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$CP = $user_defence[$i]["CP"];
	if ($CP == "") $CP = "&nbsp;";

	echo "\t"."<th><font color='lime' id='10".($i+1-$start)."'>".$CP."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Artillerie de masse</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$AM = $user_defence[$i]["AM"];
	if ($AM == "") $AM = "&nbsp;";

	echo "\t"."<th><font color='lime' id='11".($i+1-$start)."'>".$AM."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Dématérialisateur</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$Dem = $user_defence[$i]["Dem"];
	if ($Dem == "") $Dem = "&nbsp;";

	echo "\t"."<th><font color='lime' id='12".($i+1-$start)."'>".$LP."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Petit bouclier</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$PB = $user_defence[$i]["PB"];
	if ($PB == "") $PB = "&nbsp;";

	echo "\t"."<th><font color='lime' id='13".($i+1-$start)."'>".$PB."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Grand bouclier</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$GB = $user_defence[$i]["GB"];
	if ($GB == "") $GB = "&nbsp;";

	echo "\t"."<th><font color='lime' id='14".($i+1-$start)."'>".$GB."</font></th>"."\n";
}

if($view == "planets") {
?>
</tr>
<tr>
	<th><a>Missile Interception</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$MIC = $user_defence[$i]["MIC"];
	if ($MIC == "") $MIC = "&nbsp;";

	echo "\t"."<th><font color='lime' id='19".($i+1-$start)."'>".$MIC."</font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Missile Interplanétaire</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$MIP = $user_defence[$i]["MIP"];
	if ($MIP == "") $MIP = "&nbsp;";

	echo "\t"."<th><font color='lime' id='18".($i+1-$start)."'>".$MIP."</font></th>"."\n";
}

} // fin de si view="planets"
}
?>
</tr>
</table>