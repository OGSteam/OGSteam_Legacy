<?php
/***************************************************************************
*	filename	: flotte_ajout.php
*	desc.		:
*	Author		: 1.03
*	created		: 
*	modified	: 
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

// def de qq variable
//define("TABLE_MOD_FLOTTES", $table_prefix."mod_flottes");

// insertion des fonctions flotte
require_once("./mod/flottes/function_flottes.php");
//require_once("./mod/flottes/flottes_inc.php");
require_once("./mod/flottes/flottes_lang.php");
require_once("./includes/".$phpfonc.".php");

global $CF,$CFO,$CFU,$CFP,$CFA,$CB1,$CB2,$CB3,$CB4,$CB5,$GA,$PLA;

buttons_bar($pub_subaction);

$user_flottes = user_get_empire();
$user_building = $user_flottes["building"];

$affplanet=compte_planet($user_data['user_id'],$nplapage,$gameselect);
//var_dump($nplapage, $affplanet[0], $affplanet[1], $affplanet[2], $affplanet[3], $user_building, $view, $pub_view);

$nb_planete = find_nb_planete_user();

//require_once("parameters/lang_empire.php");

if(!isset($pub_view) || $pub_view=="") $view = "0";
else $view = $pub_view;

?>
<form action='index.php' method='POST' name='form'>
<input type='hidden' name='action' value='flottes' >
<input type='hidden' name='permit' value='change' >
<table width="100%">
	<tr><td colspan='15'>&nbsp;</td></tr>
<!--  selection planète  -->
<tr>
<?php
if ($affplanet[1]==0) {
	$nbcol1=$affplanet[2];
}
else {
	$nbcol1=($nplapage+1)-($affplanet[2]*$affplanet[1]);
}
for ($i=0 ; $i<=$affplanet[1] ; $i++) {
	if ($view == $i) {
		echo "<th colspan='".$nbcol1."'><a>".$lib_page[$i]."</a></th>";
	} 
	else {
		echo "<td class='c' align='center' colspan='".$affplanet[2]."' onClick=\"window.location = 'index.php?action=flottes&subaction=insert&view=".$i."';\"><a style='cursor:pointer'><font color='lime'>".$lib_page[$i]."</font></a></td>";
	}
}

?>
	<!--<th colspan="5" onClick="window.location = 'index.php?action=home&view=planets';"><center><a style='cursor:pointer'>Planètes</a></center></th>
	<th colspan="5" onClick="window.location = 'index.php?action=home&view=moons';"><center><a style='cursor:pointer'>Lunes</a></center></th>-->
	</tr>

<tr>
	<th width="10%"><a>Sélectionnez une planete</a></th>
<?php
$idp=0;
$liste_planet='';

for ($i=0 ; $i<=$affplanet[1] ; $i++) {
	if ($view == $i) {
		$start = $view=="0" ? 101 : ($view*$nplapage)+1;
	} 
	else {
		$start = $view=="1" ? 201 : ($view*$nplapage)+1;
	}

for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	if ($i < ($nb_planete+$start))
		$liste_planet.=	'<th width="7%"><input name="planet_id" value='.$i.' type="radio" onclick="select_planet = autofill('.$i.');if (document.getElementById(\'empire\').checked == true) document.getElementById(\'building\').checked=true;" id="'.$i.'"></th>';
	else
		$liste_planet.= '<th width="7%">&nbsp;</th>';
	}

echo $liste_planet;


?>
</tr>
<tr>
	<th width="6%"><a>Nom</a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	if ($i < ($nb_planete+$start)) {
		$name = $user_building[$i]["planet_name"];
		echo "\t"."<th width='8%'><label for='".$i."'>".$name."</label></th>"."\n";
	} else 
		echo "\t<th width='8%'>&nbsp;</th>\n";
}
?>
</tr>
<tr>
	<th><a>Coordonnées</a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	if ($i < ($nb_planete+$start)) {
		$il=$i;
		$coordinates = $user_building[$i]["coordinates"];
		if ($coordinates == "" || ($user_building[$i]["planet_name"] == "" && $view=="1")) $coordinates = "&nbsp;";
		else $coordinates = "[".$coordinates."]";
//		if ($view=="1") $il=$i+$nplapage;
//			else $il=$i;
		echo "\t"."<th><label for='".$il."'>".$coordinates."</label></th>"."\n";
	} else
		echo "\t<th>&nbsp;</th>\n";
}

?>
</tr>

<!--  Fin selection planète -->

	
	<tr><td colspan='19'>&nbsp;</td></tr>
	
	<tr></tr><b>
	<td class='c' colspan='19'>Insertion de la partie "Flottes"</td></b>
	<tr></tr>
	<tr>
	<th colspan='19'>
	<textarea  name='ship' rows="20" id='ship' onFocus='clear_box()'>Je sélectionne une planète et copie ici la partie "Flottes"</textarea><br>
	<input type='submit' name='add_ship' value='Nouvelle insertion'>&nbsp; &nbsp;<input type='submit' name='add_ship' value='Supprimer cette flotte'>
	</th></tr>
	<tr><td colspan='19'>&nbsp;</td></tr>
	<td></td>
	<tr></tr>
<?php 
}
?>
</table>
</form>