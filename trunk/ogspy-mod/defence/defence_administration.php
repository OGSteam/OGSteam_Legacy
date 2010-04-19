<?php
/***************************************************************************
*	filename	: defence_administration.php
*	desc.		: Page d'admistration de 'Optimisation de la défence'
*	Author		: Lothadith
*	created		: 03/01/2007
*	modified	: 03/09/2007
*	version		: 0.8b
***************************************************************************/

if (!defined('IN_SPYOGAME')) { die("Passe ton chemin manant !"); }

// Mise à jour des coefficients
if (isset($pub_btSubmit_administration)) {
	if (isset($pub_1_1)) {
		$request = "UPDATE " . TABLE_DEFENCE_COEF . " set LM = '" . $pub_1_1 . "', LLE = '" . $pub_2_1 . "', LLO = '" . $pub_3_1 . "', CG = '" . $pub_4_1 . "', AI = '" . $pub_5_1 . "', LP = '" . $pub_6_1 . "', defence_coef_rapport = '" . $pub_rapport1 . "' where user_id = ".$user_data["user_id"]." AND planet_id = 1";
		$db->sql_query($request); }
	if (isset($pub_1_2)) {
		$request = "UPDATE " . TABLE_DEFENCE_COEF . " set LM = '" . $pub_1_2 . "', LLE = '" . $pub_2_2 . "', LLO = '" . $pub_3_2 . "', CG = '" . $pub_4_2 . "', AI = '" . $pub_5_2 . "', LP = '" . $pub_6_2 . "', defence_coef_rapport = '" . $pub_rapport2 . "'  where user_id = ".$user_data["user_id"]." AND planet_id = 2";
		$db->sql_query($request); }
	if (isset($pub_1_3)) {
		$request = "UPDATE " . TABLE_DEFENCE_COEF . " set LM = '" . $pub_1_3 . "', LLE = '" . $pub_2_3 . "', LLO = '" . $pub_3_3 . "', CG = '" . $pub_4_3 . "', AI = '" . $pub_5_3 . "', LP = '" . $pub_6_3 . "', defence_coef_rapport = '" . $pub_rapport3 . "'  where user_id = ".$user_data["user_id"]." AND planet_id = 3";
		$db->sql_query($request); }
	if (isset($pub_1_4)) {
		$request = "UPDATE " . TABLE_DEFENCE_COEF . " set LM = '" . $pub_1_4 . "', LLE = '" . $pub_2_4 . "', LLO = '" . $pub_3_4 . "', CG = '" . $pub_4_4 . "', AI = '" . $pub_5_4 . "', LP = '" . $pub_6_4 . "', defence_coef_rapport = '" . $pub_rapport4 . "'  where user_id = ".$user_data["user_id"]." AND planet_id = 4";
		$db->sql_query($request); }
	if (isset($pub_1_5)) {
		$request = "UPDATE " . TABLE_DEFENCE_COEF . " set LM = '" . $pub_1_5 . "', LLE = '" . $pub_2_5 . "', LLO = '" . $pub_3_5 . "', CG = '" . $pub_4_5 . "', AI = '" . $pub_5_5 . "', LP = '" . $pub_6_5 . "', defence_coef_rapport = '" . $pub_rapport5 . "'  where user_id = ".$user_data["user_id"]." AND planet_id = 5";
		$db->sql_query($request); }
	if (isset($pub_1_6)) {
		$request = "UPDATE " . TABLE_DEFENCE_COEF . " set LM = '" . $pub_1_6 . "', LLE = '" . $pub_2_6 . "', LLO = '" . $pub_3_6 . "', CG = '" . $pub_4_6 . "', AI = '" . $pub_5_6 . "', LP = '" . $pub_6_6 . "', defence_coef_rapport = '" . $pub_rapport6 . "'  where user_id = ".$user_data["user_id"]." AND planet_id = 6";
		$db->sql_query($request); }
	if (isset($pub_1_7)) {
		$request = "UPDATE " . TABLE_DEFENCE_COEF . " set LM = '" . $pub_1_7 . "', LLE = '" . $pub_2_7 . "', LLO = '" . $pub_3_7 . "', CG = '" . $pub_4_7 . "', AI = '" . $pub_5_7 . "', LP = '" . $pub_6_7 . "', defence_coef_rapport = '" . $pub_rapport7 . "'  where user_id = ".$user_data["user_id"]." AND planet_id = 7";
		$db->sql_query($request); }
	if (isset($pub_1_8)) {
		$request = "UPDATE " . TABLE_DEFENCE_COEF . " set LM = '" . $pub_1_8 . "', LLE = '" . $pub_2_8 . "', LLO = '" . $pub_3_8 . "', CG = '" . $pub_4_8 . "', AI = '" . $pub_5_8 . "', LP = '" . $pub_6_8 . "', defence_coef_rapport = '" . $pub_rapport8 . "'  where user_id = ".$user_data["user_id"]." AND planet_id = 8";
		$db->sql_query($request); }
	if (isset($pub_1_9)) {
		$request = "UPDATE " . TABLE_DEFENCE_COEF . " set LM = '" . $pub_1_9 . "', LLE = '" . $pub_2_9 . "', LLO = '" . $pub_3_9 . "', CG = '" . $pub_4_9 . "', AI = '" . $pub_5_9 . "', LP = '" . $pub_6_9 . "', defence_coef_rapport = '" . $pub_rapport9 . "'  where user_id = ".$user_data["user_id"]." AND planet_id = 9";
		$db->sql_query($request); }

	// Mise à jour de l'option concernant le simulateur sélectionné
	if (isset($pub_typ_exp)) {
		set_user_param($pub_typ_exp, "def_simulator"); }

	// Mise à jour de la flotte attaquante à laquelle on veux resister
	if (!isset($pub_attack_1)) $pub_attack_1 = 0;
	if (!isset($pub_attack_2)) $pub_attack_2 = 0;
	if (!isset($pub_attack_3)) $pub_attack_3 = 0;
	if (!isset($pub_attack_4)) $pub_attack_4 = 0;
	if (!isset($pub_attack_5)) $pub_attack_5 = 0;
	if (!isset($pub_attack_6)) $pub_attack_6 = 0;
	if (!isset($pub_attack_7)) $pub_attack_7 = 0;
	if (!isset($pub_attack_8)) $pub_attack_8 = 0;
	if (!isset($pub_attack_9)) $pub_attack_9 = 0;
	if (!isset($pub_attack_10)) $pub_attack_10 = 0;
	if (!isset($pub_attack_11)) $pub_attack_11 = 0;
	if (!isset($pub_attack_12)) $pub_attack_12 = 0;
	if (!isset($pub_attack_13)) $pub_attack_13 = 0;
	if (!isset($pub_quai)) $pub_quai = "";
	if (!isset($pub_attack_techno_armes)) $pub_attack_techno_armes = 0;
	if (!isset($pub_attack_techno_bouclier)) $pub_attack_techno_bouclier = 0;
	if (!isset($pub_attack_techno_protection)) $pub_attack_techno_protection = 0;

	$tab_rq_attack[1][15] = ($pub_quai == "actif") ? 1 : 0;

	$request = "UPDATE ".TABLE_DEFENCE_ATTACK." set attack_PT = ".$pub_attack_1.", attack_GT = ".$pub_attack_2.", attack_CLE = ".$pub_attack_3.", attack_CLO = ".$pub_attack_4.", attack_CR = ".$pub_attack_5.", attack_VB = ".$pub_attack_6.", attack_VC = ".$pub_attack_7.", attack_RE = ".$pub_attack_8.", attack_SE = ".$pub_attack_9.", attack_BO = ".$pub_attack_10.", attack_DE = ".$pub_attack_11.", attack_EM = ".$pub_attack_12.", attack_TR = ".$pub_attack_13.", attack_quai = '".$tab_rq_attack[1][15]."', attack_techno_armes = ".$pub_attack_techno_armes.", attack_techno_bouclier = ".$pub_attack_techno_bouclier.", attack_techno_protection = ".$pub_attack_techno_protection." where user_id = ".$user_data["user_id"];
	$db->sql_query($request);
	
	redirection("index.php?action=defence&subaction=administration"); }
?>

<script type="text/javascript">
function valid_number_coef(activ_obj)
{
	if (valid_number(activ_obj)) {
		if (parseInt(activ_obj.value) < 0 || parseInt(activ_obj.value) > 100) {
			activ_obj.value = activ_obj.defaultValue;
			alert("Saisissez un nombre entre 0 et 100 dans les boîtes de la première colonne de vos planètes.");
			return false; } }
	else {
		return false; }
	
	return true;
}

function valid_number(activ_obj)
{
	if (is_number(activ_obj) == false) {
		activ_obj.value = activ_obj.defaultValue;
		return false; }
	
	return true;
}

function fct_cut_zero(str_value)
{
	if (str_value.split(".").length == 2) {
		for (icount = str_value.length - 1; icount > 0; icount--) {
			Char = str_value.charAt(icount);
			if (Char != "0") {
				if (Char != ".") {
					return str_value.slice(0, icount + 1);
				}
				else {
					return str_value.slice(0, icount);
				}
			icount = 0;
			}
		}
	}
	
	return str_value;
}

function on_blur_pc(activ_obj, id_planet, unit_rapport)
{
	valid_number_coef(activ_obj);
	var calc = document.getElementById("rapport"+id_planet).value * unit_rapport * (activ_obj.value / 100);
	document.getElementById(activ_obj.name+"_nb").value = fct_cut_zero(calc.toString().slice(0, 6));
}

function on_blur_nb(activ_obj, id_unit, id_planet, unit_rapport)
{
	var calc;
	valid_number(activ_obj);
	if (activ_obj.value <= unit_rapport * document.getElementById("rapport"+id_planet).value) {
		imax = 0;
		calc_init = calc_max = (activ_obj.value / (unit_rapport * document.getElementById("rapport"+id_planet).value)) * 100;
		for (i=1 ; i<7 ; i++) {
			calc_comp = (document.getElementById(i+"_"+id_planet+"_nb").value / ((document.getElementById("tab_rq_def6").value / document.getElementById("tab_rq_def" + i).value) * document.getElementById("rapport"+id_planet).value)) * 100;
			if (calc_comp >= calc_max) {
				calc_max = calc_comp;
				imax = i;
			}
		}
		if (imax != id_unit) {
			if (document.getElementById(imax+"_"+id_planet).value != 100) {
				on_blur_nb_set_value(document.getElementById(imax+"_"+id_planet+"_nb"), imax, id_planet, (document.getElementById("tab_rq_def6").value / document.getElementById("tab_rq_def" + imax).value)); }
			else {
				document.getElementById(id_unit+"_"+id_planet).value = fct_cut_zero(calc_init.toString().slice(0, 6)); }
		}
		else {
			on_blur_nb_set_value(activ_obj, id_unit, id_planet, unit_rapport);
		}
	}
	else {
		on_blur_nb_set_value(activ_obj, id_unit, id_planet, unit_rapport);
	}
}

function on_blur_nb_set_value(activ_obj, id_unit, id_planet, unit_rapport) {
	document.getElementById(id_unit+"_"+id_planet).value = 100;
	if (activ_obj.value / unit_rapport >= 1) {
		document.getElementById("rapport"+id_planet).value = activ_obj.value / unit_rapport;
	}
	else {
		document.getElementById("rapport"+id_planet).value = 1;
	}
	for (i=1 ; i<7 ; i++) {
		if (i != id_unit) {
			calc = ( document.getElementById(i+"_"+id_planet+"_nb").value / ((document.getElementById("tab_rq_def6").value / document.getElementById("tab_rq_def" + i).value) * document.getElementById("rapport"+id_planet).value)) * 100;
			document.getElementById(i+"_"+id_planet).value = fct_cut_zero(calc.toString().slice(0, 6));
		}
	}
}
</script>

<table width="100%">
<tr>
	<td align="center">
		<table width="100%">
		<tr>
			<td align="center" class="c" colspan="19">Vos planètes</td>
		</tr>
		<form method="POST" name="sub_administration" enctype="multipart/form-data" action="index.php?action=defence&subaction=administration">
		<tr>
			<th><a>Nom</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$name = $user_building[$i]["planet_name"];
	$id = 100 + $i;
	echo "\t"."<th width='9%' id='" . $id . "' value='" . $name . "' colspan='2'><a>".$name."</a><input type='hidden' id='rapport".$i."' name='rapport".$i."' value='".$tab_rq_coef[$i]["defence_coef_rapport"]."'></th>"."\n"; }
?>
		</tr>
		<tr>
			<th><a>Coordonnées</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$coordinates = $user_building[$i]["coordinates"];
	if ($coordinates == "" || ($user_building[$i+9]["planet_name"] == "" && $view=="moons")) $coordinates = "&nbsp;";
	else $coordinates = "[".$coordinates."]";
	echo "\t"."<th colspan='2'>".$coordinates."</th>"."\n"; }
?>
		</tr>
		<tr>
			<td align="center" class="c" colspan="19">Coefficients de calcul (en pourcentage et en nombre) de vos unités</td>
		</tr>
		<tr>
			<th><a><?php echo $lang_defence["LM"]."<input type='hidden' id='tab_rq_def1' value='".$tab_rq_def[0][get_user_param('def_select')]."'>"; ?></a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$name = $user_building[$i]["planet_name"];
	$calc_nb = $tab_rq_def[5][get_user_param("def_select")]/$tab_rq_def[0][get_user_param("def_select")];
	$affichage_pc = ($name == "") ? "&nbsp;" : "<input style='cursor:pointer' type='text' id='1_".$i."' name='1_".$i."' size='6' maxlength='6' value='".$tab_rq_coef[$i]["LM"]."' onChange='javascript:on_blur_pc(this, ".$i.", ".$calc_nb.");' tabindex=".$i.">";
	$calc_nb *= $tab_rq_coef[$i]["defence_coef_rapport"] * ($tab_rq_coef[$i]["LM"] / 100);
	$affichage_nb = ($name == "") ? "&nbsp;" : "<input style='cursor:pointer' type='text' id='1_".$i."_nb' size='6' maxlength='6' value='".substr($calc_nb, 0, 6)."' onChange='javascript:on_blur_nb(this, 1, ".$i.", ".$calc_nb.");' tabindex=".($i+9).">";
	echo "\t"."<th>" . $affichage_pc . "</th><th>" . $affichage_nb . "</th>"."\n"; }
?>
		</tr>
		<tr>
			<th><a><?php echo $lang_defence["LLE"]."<input type='hidden' id='tab_rq_def2' value='".$tab_rq_def[1][get_user_param('def_select')]."'>"; ?></a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$name = $user_building[$i]["planet_name"];
	$calc_nb = $tab_rq_def[5][get_user_param("def_select")]/$tab_rq_def[1][get_user_param("def_select")];
	$affichage_pc = ($name == "") ? "&nbsp;" : "<input style='cursor:pointer' type='text' id='2_".$i."' name='2_".$i."' size='6' maxlength='6' value='".$tab_rq_coef[$i]["LLE"]."' onChange='javascript:on_blur_pc(this, ".$i.", ".$calc_nb.");'>";
	$calc_nb *= $tab_rq_coef[$i]["defence_coef_rapport"] * ($tab_rq_coef[$i]["LLE"] / 100);
	$affichage_nb = ($name == "") ? "&nbsp;" : "<input style='cursor:pointer' type='text' id='2_".$i."_nb' size='6' maxlength='6' value='".substr($calc_nb, 0, 6)."' onChange='javascript:on_blur_nb(this, 2, ".$i.", ".$calc_nb.");'>";
	echo "\t"."<th>" . $affichage_pc . "</th><th>" . $affichage_nb . "</th>"."\n"; }
?>
		</tr>
		<tr>
			<th><a><?php echo $lang_defence["LLO"]."<input type='hidden' id='tab_rq_def3' value='".$tab_rq_def[2][get_user_param('def_select')]."'>"; ?></a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$name = $user_building[$i]["planet_name"];
	$calc_nb = $tab_rq_def[5][get_user_param("def_select")]/$tab_rq_def[2][get_user_param("def_select")];
	$affichage_pc = ($name == "") ? "&nbsp;" : "<input style='cursor:pointer' type='text' id='3_".$i."' name='3_".$i."' size='6' maxlength='6' value='".$tab_rq_coef[$i]["LLO"]."' onChange='javascript:on_blur_pc(this, ".$i.", ".$calc_nb.");'>";
	$calc_nb *= $tab_rq_coef[$i]["defence_coef_rapport"] * ($tab_rq_coef[$i]["LLO"] / 100);
	$affichage_nb = ($name == "") ? "&nbsp;" : "<input style='cursor:pointer' type='text' id='3_".$i."_nb' size='6' maxlength='6' value='".substr($calc_nb, 0, 6)."' onChange='javascript:on_blur_nb(this, 3, ".$i.", ".$calc_nb.");'>";
	echo "\t"."<th>" . $affichage_pc . "</th><th>" . $affichage_nb . "</th>"."\n"; }
?>
		</tr>
		<tr>
			<th><a><?php echo $lang_defence["CG"]."<input type='hidden' id='tab_rq_def4' value='".$tab_rq_def[3][get_user_param('def_select')]."'>"; ?></a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$name = $user_building[$i]["planet_name"];
	$calc_nb = $tab_rq_def[5][get_user_param("def_select")]/$tab_rq_def[3][get_user_param("def_select")];
	$affichage_pc = ($name == "") ? "&nbsp;" : "<input style='cursor:pointer' type='text' id='4_".$i."' name='4_".$i."' size='6' maxlength='6' value='".$tab_rq_coef[$i]["CG"]."' onChange='javascript:on_blur_pc(this, ".$i.", ".$calc_nb.");'>";
	$calc_nb *= $tab_rq_coef[$i]["defence_coef_rapport"] * ($tab_rq_coef[$i]["CG"] / 100);
	$affichage_nb = ($name == "") ? "&nbsp;" : "<input style='cursor:pointer' type='text' id='4_".$i."_nb' size='6' maxlength='6' value='".substr($calc_nb, 0, 6)."' onChange='javascript:on_blur_nb(this, 4, ".$i.", ".$calc_nb.");'>";
	echo "\t"."<th>" . $affichage_pc . "</th><th>" . $affichage_nb . "</th>"."\n"; }
?>
		</tr>
		<tr>
			<th><a><?php echo $lang_defence["AI"]."<input type='hidden' id='tab_rq_def5' value='".$tab_rq_def[4][get_user_param('def_select')]."'>"; ?></a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$name = $user_building[$i]["planet_name"];
	$calc_nb = $tab_rq_def[5][get_user_param("def_select")]/$tab_rq_def[4][get_user_param("def_select")];
	$affichage_pc = ($name == "") ? "&nbsp;" : "<input style='cursor:pointer' type='text' id='5_".$i."' name='5_".$i."' size='6' maxlength='6' value='".$tab_rq_coef[$i]["AI"]."' onChange='javascript:on_blur_pc(this, ".$i.", ".$calc_nb.");'>";
	$calc_nb *= $tab_rq_coef[$i]["defence_coef_rapport"] * ($tab_rq_coef[$i]["AI"] / 100);
	$affichage_nb = ($name == "") ? "&nbsp;" : "<input style='cursor:pointer' type='text' id='5_".$i."_nb' size='6' maxlength='6' value='".substr($calc_nb, 0, 6)."' onChange='javascript:on_blur_nb(this, 5, ".$i.", ".$calc_nb.");'>";
	echo "\t"."<th>" . $affichage_pc . "</th><th>" . $affichage_nb . "</th>"."\n"; }
?>
		</tr>
		<tr>
			<th><a><?php echo $lang_defence["LP"]."<input type='hidden' id='tab_rq_def6' value='".$tab_rq_def[5][get_user_param('def_select')]."'>"; ?></a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$name = $user_building[$i]["planet_name"];
	$calc_nb = $tab_rq_def[5][get_user_param("def_select")]/$tab_rq_def[5][get_user_param("def_select")];
	$affichage_pc = ($name == "") ? "&nbsp;" : "<input style='cursor:pointer' type='text' id='6_".$i."' name='6_".$i."' size='6' maxlength='6' value='".$tab_rq_coef[$i]["LP"]."' onChange='javascript:on_blur_pc(this, ".$i.", ".$calc_nb.");'>";
	$calc_nb *= $tab_rq_coef[$i]["defence_coef_rapport"] * ($tab_rq_coef[$i]["LP"] / 100);
	$affichage_nb = ($name == "") ? "&nbsp;" : "<input style='cursor:pointer' type='text' id='6_".$i."_nb' size='6' maxlength='6' value='".substr($calc_nb, 0, 6)."' onChange='javascript:on_blur_nb(this, 6, ".$i.", ".$calc_nb.");'>";
	echo "\t"."<th>" . $affichage_pc . "</th><th>" . $affichage_nb . "</th>"."\n"; }
?>
		</tr>
		<tr>
			<td align="center" class="c" colspan="19">Votre simulateur préféré</td>
		</tr>
		<tr>
			<th><a>Export</a></td>
			<th colspan="9"><input style='cursor:pointer' name="typ_exp" value="speedsim" type="radio" <?php echo get_user_param("def_simulator") == "speedsim" ? " CHECKED" : ""; ?> >&nbsp;vers SpeedSim Online</td>
			<th colspan="9"><input style='cursor:pointer' name="typ_exp" value="dragosim" type="radio" <?php echo get_user_param("def_simulator") == "dragosim" ? " CHECKED" : ""; ?> >&nbsp;vers DragoSim</td>
		</tr>
<?php
if (isset($user_flottes)) {
	echo "<tr><td align='center' class='c' colspan='19'>Votre flotte (commun à toutes les planètes ... Pour le moment.)</td></tr>";
	echo "<tr><th><a>Laisser à quai</a></th>";
	echo "<th colspan='2'><input style='cursor:pointer' name='quai' id='quai' type='checkbox' value='actif'";
	echo ($tab_rq_attack[1][15] == 1) ? ' CHECKED></th>' : '></th>';
	echo "<th colspan='16'>&nbsp;</th></tr>"; }
?>
		<tr>
			<td align="center" class="c" colspan="19">Technologie de l'adversaire (communes à toutes les planètes ... Pour le moment.)</td>
		</tr>
		<tr>
			<th><a><?php echo $lang_technology["Armes"]; ?></a></th>
			<th colspan="2"><input align='center' style='cursor:pointer' type='text' id='attack_techno_armes' name='attack_techno_armes' size='2' maxlength='2' value='<?php echo $tab_rq_attack[1][16]; ?>' onBlur='javascript:valid_number_unit(this);'></th>
			<th colspan="16">&nbsp;</th>
		</tr>
		<tr>
			<th><a><?php echo $lang_technology["Bouclier"]; ?></a></th>
			<th colspan="2"><input align='center' style='cursor:pointer' type='text' id='attack_techno_bouclier' name='attack_techno_bouclier' size='2' maxlength='2' value='<?php echo $tab_rq_attack[1][17]; ?>' onBlur='javascript:valid_number_unit(this);'></th>
			<th colspan="16">&nbsp;</th>
		</tr>
		<tr>
			<th><a><?php echo $lang_technology["Protection"]; ?></a></th>
			<th colspan="2"><input align='center' style='cursor:pointer' type='text' id='attack_techno_protection' name='attack_techno_protection' size='2' maxlength='2' value='<?php echo $tab_rq_attack[1][18]; ?>' onBlur='javascript:valid_number_unit(this);'></th>
			<th colspan="16">&nbsp;</th>
		</tr>
		<tr>
			<td align="center" class="c" colspan="19">La flotte à laquelle vous voulez résister (commun à toutes les planètes ... Pour le moment.)</td>
		</tr>
		<tr>
			<th><a>Petit transporteur</a></th>
			<th colspan="2"><input align='center' style='cursor:pointer' type='text' id='attack_1' name='attack_1' size='10' maxlength='10' value='<?php echo $tab_rq_attack[1][2]; ?>' onBlur='javascript:valid_number_unit(this);'></th>
			<th colspan="16">&nbsp;</th>
		</tr>
		<tr>
			<th><a>Grand transporteur</a></th>
			<th colspan="2"><input align='center' style='cursor:pointer' type='text' id='attack_2' name='attack_2' size='10' maxlength='10' value='<?php echo $tab_rq_attack[1][3]; ?>' onBlur='javascript:valid_number_unit(this);'></th>
			<th colspan="16">&nbsp;</th>
		</tr>
		<tr>
			<th><a>Chasseur léger</a></th>
			<th colspan="2"><input align='center' style='cursor:pointer' type='text' id='attack_3' name='attack_3' size='10' maxlength='10' value='<?php echo $tab_rq_attack[1][4]; ?>' onBlur='javascript:valid_number_unit(this);'></th>
			<th colspan="16">&nbsp;</th>
		</tr>
		<tr>
			<th><a>Chasseur lourd</a></th>
			<th colspan="2"><input align='center' style='cursor:pointer' type='text' id='attack_4' name='attack_4' size='10' maxlength='10' value='<?php echo $tab_rq_attack[1][5]; ?>' onBlur='javascript:valid_number_unit(this);'></th>
			<th colspan="16">&nbsp;</th>
		</tr>
		<tr>
			<th><a>Croiseur</a></th>
			<th colspan="2"><input align='center' style='cursor:pointer' type='text' id='attack_5' name='attack_5' size='10' maxlength='10' value='<?php echo $tab_rq_attack[1][6]; ?>' onBlur='javascript:valid_number_unit(this);'></th>
			<th colspan="16">&nbsp;</th>
		</tr>
		<tr>
			<th><a>Vaisseau de bataille</a></th>
			<th colspan="2"><input align='center' style='cursor:pointer' type='text' id='attack_6' name='attack_6' size='10' maxlength='10' value='<?php echo $tab_rq_attack[1][7]; ?>' onBlur='javascript:valid_number_unit(this);'></th>
			<th colspan="16">&nbsp;</th>
		</tr>
		<tr>
			<th><a>Vaisseau de colonisation</a></th>
			<th colspan="2"><input align='center' style='cursor:pointer' type='text' id='attack_7' name='attack_7' size='10' maxlength='10' value='<?php echo $tab_rq_attack[1][8]; ?>' onBlur='javascript:valid_number_unit(this);'></th>
			<th colspan="16">&nbsp;</th>
		</tr>
		<tr>
			<th><a>Recycleur</a></th>
			<th colspan="2"><input align='center' style='cursor:pointer' type='text' id='attack_8' name='attack_8' size='10' maxlength='10' value='<?php echo $tab_rq_attack[1][9]; ?>' onBlur='javascript:valid_number_unit(this);'></th>
			<th colspan="16">&nbsp;</th>
		</tr>
		<tr>
			<th><a>Sonde espionnage</a></th>
			<th colspan="2"><input align='center' style='cursor:pointer' type='text' id='attack_9' name='attack_9' size='10' maxlength='10' value='<?php echo $tab_rq_attack[1][10]; ?>' onBlur='javascript:valid_number_unit(this);'></th>
			<th colspan="16">&nbsp;</th>
		</tr>
		<tr>
			<th><a>Bombardier</a></th>
			<th colspan="2"><input align='center' style='cursor:pointer' type='text' id='attack_10' name='attack_10' size='10' maxlength='10' value='<?php echo $tab_rq_attack[1][11]; ?>' onBlur='javascript:valid_number_unit(this);'></th>
			<th colspan="16">&nbsp;</th>
		</tr>
		<tr>
			<th><a>Destructeur</a></th>
			<th colspan="2"><input align='center' style='cursor:pointer' type='text' id='attack_11' name='attack_11' size='10' maxlength='10' value='<?php echo $tab_rq_attack[1][12]; ?>' onBlur='javascript:valid_number_unit(this);'></th>
			<th colspan="16">&nbsp;</th>
		</tr>
		<tr>
			<th><a>Etoile de la mort</a></th>
			<th colspan="2"><input align='center' style='cursor:pointer' type='text' id='attack_11' name='attack_12' size='10' maxlength='10' value='<?php echo $tab_rq_attack[1][13]; ?>' onBlur='javascript:valid_number_unit(this);'></th>
			<th colspan="16">&nbsp;</th>
		</tr>
		<tr>
			<th><a>Traqueur</a></th>
			<th colspan="2"><input align='center' style='cursor:pointer' type='text' id='attack_12' name='attack_13' size='10' maxlength='10' value='<?php echo $tab_rq_attack[1][14]; ?>' onBlur='javascript:valid_number_unit(this);'></th>
			<th colspan="16">&nbsp;</th>
		</tr>
		<tr>
			<td align="center" class="c" colspan="19"><input  style='cursor:pointer' name="btreset_administration" type="reset" value="Annuler">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input  style='cursor:pointer' name="btSubmit_administration" type="submit" value="Enregistrer"></td>
		</tr>
		</form>
		</table>
	</td>
</tr>
</table>
<?php
require_once("mod/defence/defence_footer.php");
?>
