<?php
/***************************************************************************
*	filename	: defence_optimize.php
*	desc.		: Page d'Optimisation de 'Optimisation de la défence'
*	Author		: Lothadith
*	created		: 15/12/2006
*	modified	: 03/09/2007
*	version		: 0.8b
***************************************************************************/

if (!defined('IN_SPYOGAME')) { die("Passe ton chemin manant !"); }

// Déclaration des variables
$tab_cout[] = array(0, 0, 0, 0, 0, 0, 0);

// Mise à jour des défenses dans la base SQL avec contrôle de l'activité
if (isset($pub_btSubmit_rapport) && $pub_planet_id != "" && $user_building[$pub_planet_id]["planet_name"] != "") {
	if (user_set_empire_defence($pub_data, $pub_planet_id, $user_building[$pub_planet_id]["planet_name"], $user_building[$pub_planet_id]["coordinates"], $view) == false) { $pub_data = "Erreur ! Vous n'avez pas collez ici-même les informations concernant vos défenses.\nVeuillez recommencer."; }
	else { redirection("index.php?action=defence&subaction=optimize&view=" . $view); } }
else {
	if (!isset($pub_data)) { $pub_data = "Opération réalisée avec succès.\nCollez les informations concernant vos défenses ici."; }
	else { $pub_data = "Sélectionnez d'abord une planète active."; } }

// Enregistrer ou récupérer les options de l'utilisateur
if (!isset($pub_opt_def_opt)) { $pub_opt_def_opt=get_user_param("def_select"); }
else { if ($pub_opt_def_opt == "attaque" || $pub_opt_def_opt == "bouclier") { set_user_param($pub_opt_def_opt, "def_select"); } }

if (empty($pub_result)) { $pub_result = get_user_param("def_zero_active"); }
else
{
	if ($pub_zero_active == "actif") { $pub_result = 1; set_user_param(1, "def_zero_active"); }
	else { $pub_result = 0; set_user_param(0, "def_zero_active"); } }

// Sélection de la vue
if(!isset($pub_view) || $pub_view=="") $view = "planets";
elseif ($pub_view == "planets" || $pub_view == "moons") $view = $pub_view;
else $view = "planets";
$start = $view=="planets" ? 1 : 10;

// Mise à jour des groupes d'unités fixés par l'utilisateur
if (isset($pub_btSubmit_unit) && $pub_planet_id != "" && $user_building[$pub_planet_id]["planet_name"] != "") {
	save_units($view);
	$pub_data = "Opération réalisée avec succès.\nCollez les informations concernant vos défenses ici."; }

// Mise à jour du tableau user_defence_fix
change_user_defence_fix();

echo "<script type='text/javascript'>";
// Création du tableau JavaScript des flottes si le module est activé.
if (isset($user_flottes)) {
	convert_tab_php($user_flottes, "flottes"); }
else {
	echo "flottes = 0;\n"; }

// Création du tableau JavaScript des attaques à contrer.
convert_tab_php($tab_rq_attack, "attack");
echo "</script>\n";
?>
<script language="javascript" src="mod/defence/functions.js"></script>

<table width="100%">
<tr>
	<td align="center">
		<table width="100%">
		<tr>
			<td align="center" class="c" colspan="10">Choix du lieu des défenses</td>
		</tr>
		<tr>
<?php
// Affichage des onglets d'entête
if ($view == "planets") {
	echo "<th colspan='5'><a>Planètes</a></th>";
	echo "<td style='cursor:pointer' class='c' align='center' colspan='5' onClick=\"window.location = 'index.php?action=defence&subaction=optimize&view=moons';\"><a><font color='lime'>Lunes</font></a></td>"; }
else {
	echo "<td style='cursor:pointer' class='c' align='center' colspan='5' onClick=\"window.location = 'index.php?action=defence&subaction=optimize&view=planets';\"><a><font color='lime'>Planètes</font></a></td>";
	echo "<th colspan='5'><a>Lunes</a></th>"; }
?>
		</tr>
		<form method="POST" name="sub_optimize" enctype="multipart/form-data" action="index.php?action=defence&subaction=optimize&view=<?php echo $view; ?>">
		<tr>
			<th><a>Collez les infos ici</a></th>
			<th colspan="8"><textarea name="data" rows="2" onFocus="clear_text2()"><?php echo $pub_data; ?></textarea></th>
			<th><input onmouseover="this.T_WIDTH=210;this.T_TEMP=0;return escape('&lt;table width=&quot;200&quot;&gt;&lt;tr&gt;&lt;td align=&quot;center&quot; class=&quot;c&quot;&gt;Information&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;th align=&quot;center&quot;&gt;Enregistrement de votre rapport sur la plan&egrave;te s&eacute;lectionn&eacute;e.&lt;/th&gt;&lt;/tr&gt;&lt;/table&gt;')" style='cursor:pointer' name="btSubmit_rapport" type="submit" value="Envoyer"></th>
		</tr>
		<tr>
			<th><a>Sélectionnez une planete</a></th>
			<th><input style='cursor:pointer' name="planet_id" value="<?php echo $view=="planets" ? 1 : 1+9; ?>" type="radio" onclick="autofill(<?php echo $view=="planets" ? 1 : 1+9; ?>);"><?php if($view=="moons") echo "<br />".$user_building[1]["planet_name"]; ?></th>
			<th><input style='cursor:pointer' name="planet_id" value="<?php echo $view=="planets" ? 2 : 2+9; ?>" type="radio" onclick="autofill(<?php echo $view=="planets" ? 2 : 2+9; ?>);"><?php if($view=="moons") echo "<br />".$user_building[2]["planet_name"]; ?></th>
			<th><input style='cursor:pointer' name="planet_id" value="<?php echo $view=="planets" ? 3 : 3+9; ?>" type="radio" onclick="autofill(<?php echo $view=="planets" ? 3 : 3+9; ?>);"><?php if($view=="moons") echo "<br />".$user_building[3]["planet_name"]; ?></th>
			<th><input style='cursor:pointer' name="planet_id" value="<?php echo $view=="planets" ? 4 : 4+9; ?>" type="radio" onclick="autofill(<?php echo $view=="planets" ? 4 : 4+9; ?>);"><?php if($view=="moons") echo "<br />".$user_building[4]["planet_name"]; ?></th>
			<th><input style='cursor:pointer' name="planet_id" value="<?php echo $view=="planets" ? 5 : 5+9; ?>" type="radio" onclick="autofill(<?php echo $view=="planets" ? 5 : 5+9; ?>);"><?php if($view=="moons") echo "<br />".$user_building[5]["planet_name"]; ?></th>
			<th><input style='cursor:pointer' name="planet_id" value="<?php echo $view=="planets" ? 6 : 6+9; ?>" type="radio" onclick="autofill(<?php echo $view=="planets" ? 6 : 6+9; ?>);"><?php if($view=="moons") echo "<br />".$user_building[6]["planet_name"]; ?></th>
			<th><input style='cursor:pointer' name="planet_id" value="<?php echo $view=="planets" ? 7 : 7+9; ?>" type="radio" onclick="autofill(<?php echo $view=="planets" ? 7 : 7+9; ?>);"><?php if($view=="moons") echo "<br />".$user_building[7]["planet_name"]; ?></th>
			<th><input style='cursor:pointer' name="planet_id" value="<?php echo $view=="planets" ? 8 : 8+9; ?>" type="radio" onclick="autofill(<?php echo $view=="planets" ? 8 : 8+9; ?>);"><?php if($view=="moons") echo "<br />".$user_building[8]["planet_name"]; ?></th>
			<th><input style='cursor:pointer' name="planet_id" value="<?php echo $view=="planets" ? 9 : 9+9; ?>" type="radio" onclick="autofill(<?php echo $view=="planets" ? 9 : 9+9; ?>);"><?php if($view=="moons") echo "<br />".$user_building[9]["planet_name"]; ?></th>
		</tr>
		<tr>
			<td align="center" class="c" colspan="10">Vue d'ensemble de votre empire</td>
		</tr>
		<tr>
			<th><a>Nom</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$name = $user_building[$i]["planet_name"];
	$id = 100 + $i;
	echo "\t"."<th width='9%'><input type='hidden' id='".$id."' value='".$name."'><a>".$name."</a></th>"."\n"; }
?>
		</tr>
		<tr>
			<th><a>Coordonnées</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$coordinates = $user_building[$i]["coordinates"];
	if ($coordinates == "" || ($user_building[$i+9]["planet_name"] == "" && $view=="moons")) $coordinates = "&nbsp;";
	else $coordinates = "[".$coordinates."]";
	echo "\t"."<th>".$coordinates."</th>"."\n"; }
?>
		</tr>
		<tr>
			<td align="center" class="c" colspan="10">Production théorique</td>
		</tr>
		<tr>
			<th><a>Métal</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$M = $user_building[$i]["M"];
	if ($M != "") $production = production("M", $M);
	else $production = "&nbsp";
	$tab_cout[$i][3] = $production;
	echo "\t"."<th>".$production."</th>"."\n"; }
?>
		</tr>
		<tr>
			<th><a>Cristal</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$C = $user_building[$i]["C"];
	if ($C != "") $production = production("C", $C);
	else $production = "&nbsp";
	$tab_cout[$i][4] = $production;
	echo "\t"."<th>".$production."</th>"."\n"; }
?>
		</tr>
		<tr>
			<th><a>Deutérium</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$D = $user_building[$i]["D"];
	$temperature = $user_building[$i]["temperature"];
	$CEF = $user_building[$i]["CEF"];
	$CEF_consumption = consumption("CEF", $CEF);
	if ($D != "") $production = production("D", $D, $temperature) - $CEF_consumption;
	else $production = "&nbsp";
	$tab_cout[$i][5] = $production;
	echo "\t"."<th>".$production."</th>"."\n"; }
?>
		</tr>
		<tr>
			<td align="center" class="c" colspan="10">Défenses optimisées sur 
				<select onmouseover="this.T_WIDTH=310;this.T_TEMP=0;return escape('&lt;table width=&quot;300&quot;&gt;&lt;tr&gt;&lt;td align=&quot;center&quot; class=&quot;c&quot;&gt;Information&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;th align=&quot;center&quot;&gt;S&eacute;lectionnez ici le mode d\'optimisation d&eacute;sir&eacute;.&lt;br /&gt;---oOo---&lt;br /&gt;Vous pouvez &eacute;quilibrer, au choix, vos d&eacute;fenses sur :&lt;br /&gt;- Les valeurs d\'attaque des unit&eacute;s&lt;br /&gt;- Les valeurs de bouclier des unit&eacute;s&lt;br /&gt;---oOo---&lt;br /&gt;Vous obtiendrez entre parenth&egrave;ses le nombre d\'unit&eacute; &agrave; cr&eacute;er.&lt;/th&gt;&lt;/tr&gt;&lt;/table&gt;')" name="opt_def_opt" onchange="this.form.submit();">
					<option title="Optimisation sur les valeurs d'attaque des unités" value="attaque" <?php echo $pub_opt_def_opt == "attaque" ? "selected='selected'" : "";?>>la puissance de feu</option>
					<option title="Optimisation sur les valeurs de bouclier des unités" value="bouclier" <?php echo $pub_opt_def_opt == "bouclier" ? "selected='selected'" : "";?>>la valeur des boucliers</option></select> (à produire)
				<input name="result" type="hidden" value="-1"></td>
		</tr>
		<tr>
			<th><a><?php echo $lang_defence["LM"]; ?></a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	cout_unit_fix($i);
	$LM = $user_defence[$i]["LM"];
	if ($LM == "") {
		$LM = 0;
		$opt = $opt_fix = 0; }
	else {
		$opt = get_optimize_defence($user_defence[$i], 0, "LM", $pub_opt_def_opt, $i);
		$opt_fix = get_optimize_defence($user_defence_fix[$i], 0, "LM", $pub_opt_def_opt, $i); }
	
	if ($user_defence_fix[$i]["LM"] <= $opt + $LM) {
		$user_defence_fix[$i]["LM"] = 0;
		if ($opt_fix > $opt) { $opt = $opt_fix; }
		$result = ($opt > 0) ? $LM . " (". $opt . ")" : $LM;
		$color = "lime"; }
	else {
		$result = $LM . " --> " . $user_defence_fix[$i]["LM"];
		$opt = 0;
		$color = "#5CCCE8"; }
	
	set_cout_optimize_defence($i, 0, $opt);
	$user_defence_const[$i]["LM"] = $opt;
	
	$name = $user_building[$i]["planet_name"];
	if ($name == "" && $result == 0) { $result = ""; }

	echo "\t<th><input type='hidden' id='1".($i+1-$start)."' value='" . $result . "'><font color='" . $color . "' id='col_1".($i+1-$start)."'>" . $result . "</th>\n"; }
?>
		</tr>
		<tr>
			<th><a><?php echo $lang_defence["LLE"]; ?></a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$LLE = $user_defence[$i]["LLE"];
	if ($LLE == "") {
		$LLE = 0;
		$opt = $opt_fix = 0; }
	else {
		$opt = get_optimize_defence($user_defence[$i], 1, "LLE", $pub_opt_def_opt, $i);
		$opt_fix = get_optimize_defence($user_defence_fix[$i], 1, "LLE", $pub_opt_def_opt, $i); }
	
	if ($user_defence_fix[$i]["LLE"] <= $opt + $LLE) {
		$user_defence_fix[$i]["LLE"] = 0;
		if ($opt_fix > $opt) { $opt = $opt_fix; }
		$result = ($opt > 0) ? $LLE . " (". $opt . ")" : $LLE;
		$color = "lime"; }
	else {
		$result = $LLE . " --> " . $user_defence_fix[$i]["LLE"];
		$opt = 0;
		$color = "#5CCCE8"; }
	
	set_cout_optimize_defence($i, 1, $opt);
	$user_defence_const[$i]["LLE"] = $opt;
	
	$name = $user_building[$i]["planet_name"];
	if ($name == "" && $result == 0) { $result = ""; }

	echo "\t<th><input type='hidden' id='2".($i+1-$start)."' value='" . $result . "'><font color='" . $color . "' id='col_2".($i+1-$start)."'>" . $result . "</th>\n"; }
?>
		</tr>
		<tr>
			<th><a><?php echo $lang_defence["LLO"]; ?></a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$LLO = $user_defence[$i]["LLO"];
	if ($LLO == "") {
		$LLO = 0;
		$opt = $opt_fix = 0; }
	else {
		$opt = get_optimize_defence($user_defence[$i], 2, "LLO", $pub_opt_def_opt, $i);
		$opt_fix = get_optimize_defence($user_defence_fix[$i], 2, "LLO", $pub_opt_def_opt, $i); }
	
	if ($user_defence_fix[$i]["LLO"] <= $opt + $LLO) {
		$user_defence_fix[$i]["LLO"] = 0;
		if ($opt_fix > $opt) { $opt = $opt_fix; }
		$result = ($opt > 0) ? $LLO . " (". $opt . ")" : $LLO;
		$color = "lime"; }
	else {
		$result = $LLO . " --> " . $user_defence_fix[$i]["LLO"];
		$opt = 0;
		$color = "#5CCCE8"; }
	
	set_cout_optimize_defence($i, 2, $opt);
	$user_defence_const[$i]["LLO"] = $opt;
	
	$name = $user_building[$i]["planet_name"];
	if ($name == "" && $result == 0) { $result = ""; }

	echo "\t<th><input type='hidden' id='3".($i+1-$start)."' value='" . $result . "'><font color='" . $color . "' id='col_3".($i+1-$start)."'>" . $result . "</th>\n"; }
?>
		</tr>
		<tr>
			<th><a><?php echo $lang_defence["CG"]; ?></a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$CG = $user_defence[$i]["CG"];
	if ($CG == "") {
		$CG = 0;
		$opt = $opt_fix = 0; }
	else {
		$opt = get_optimize_defence($user_defence[$i], 3, "CG", $pub_opt_def_opt, $i);
		$opt_fix = get_optimize_defence($user_defence_fix[$i], 3, "CG", $pub_opt_def_opt, $i); }
	
	if ($user_defence_fix[$i]["CG"] <= $opt + $CG) {
		$user_defence_fix[$i]["CG"] = 0;
		if ($opt_fix > $opt) { $opt = $opt_fix; }
		$result = ($opt > 0) ? $CG . " (". $opt . ")" : $CG;
		$color = "lime"; }
	else {
		$result = $CG . " --> " . $user_defence_fix[$i]["CG"];;
		$opt = 0;
		$color = "#5CCCE8"; }
	
	set_cout_optimize_defence($i, 3, $opt);
	$user_defence_const[$i]["CG"] = $opt;
	
	$name = $user_building[$i]["planet_name"];
	if ($name == "" && $result == 0) { $result = ""; }

	echo "\t<th><input type='hidden' id='4".($i+1-$start)."' value='" . $result . "'><font color='" . $color . "' id='col_4".($i+1-$start)."'>" . $result . "</th>\n"; }
?>
		</tr>
		<tr>
			<th><a><?php echo $lang_defence["AI"]; ?></a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$AI = $user_defence[$i]["AI"];
	if ($AI == "") {
		$AI = 0;
		$opt = $opt_fix = 0; }
	else {
		$opt = get_optimize_defence($user_defence[$i], 4, "AI", $pub_opt_def_opt, $i);
		$opt_fix = get_optimize_defence($user_defence_fix[$i], 4, "AI", $pub_opt_def_opt, $i); }
	
	if ($user_defence_fix[$i]["AI"] <= $opt + $AI) {
		$user_defence_fix[$i]["AI"] = 0;
		if ($opt_fix > $opt) { $opt = $opt_fix; }
		$result = ($opt > 0) ? $AI . " (". $opt . ")" : $AI;
		$color = "lime"; }
	else {
		$result = $AI . " --> " . $user_defence_fix[$i]["AI"];
		$opt = 0;
		$color = "#5CCCE8"; }
	
	set_cout_optimize_defence($i, 4, $opt);
	$user_defence_const[$i]["AI"] = $opt;
	
	$name = $user_building[$i]["planet_name"];
	if ($name == "" && $result == 0) { $result = ""; }

	echo "\t<th><input type='hidden' id='5".($i+1-$start)."' value='" . $result . "'><font color='" . $color . "' id='col_5".($i+1-$start)."'>" . $result . "</th>\n"; }
?>
		</tr>
		<tr>
			<th><a><?php echo $lang_defence["LP"]; ?></a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$LP = $user_defence[$i]["LP"];
	if ($LP == "") {
		$LP = 0;
		$opt = $opt_fix = 0; }
	else {
		$opt = get_optimize_defence($user_defence[$i], 5, "LP", $pub_opt_def_opt, $i);
		$opt_fix = get_optimize_defence($user_defence_fix[$i], 5, "LP", $pub_opt_def_opt, $i); }
	
	if ($user_defence_fix[$i]["LP"] <= $opt + $LP) {
		$user_defence_fix[$i]["LP"] = 0;
		if ($opt_fix > $opt) { $opt = $opt_fix; }
		$result = ($opt > 0) ? $LP . " (". $opt . ")" : $LP;
		$color = "lime"; }
	else {
		$result = $LP . " --> " . $user_defence_fix[$i]["LP"];
		$opt = 0;
		$color = "#5CCCE8"; }
	
	set_cout_optimize_defence($i, 5, $opt);
	$user_defence_const[$i]["LP"] = $opt;
	
	$name = $user_building[$i]["planet_name"];
	if ($name == "" && $result == 0) { $result = ""; }
	
	echo "\t<th><input type='hidden' id='6".($i+1-$start)."' value='" . $result . "'><font color='" . $color . "' id='col_6".($i+1-$start)."'>" . $result . "</th>\n"; }
echo "\t\t</tr>";
	
echo "\t\t<tr><th><a>".$lang_defence["PB"]."</a></th>";
	for ($i=$start ; $i<=$start+8 ; $i++) {
		$PB = $user_defence[$i]["PB"];
		if ($user_technology["Bouclier"] > 1 && $user_building[$i]["CSp"] > 0 && $PB == "0") {
			set_cout_optimize_defence($i, 6, 1);
			$user_defence_const[$i]["PB"] = 1;
			$PB = "0 (1)"; }
		if ($user_building[$i]["planet_name"] == "") { $PB = ""; }
		echo "\t<th><input type='hidden' id='7".($i+1-$start)."' value='" . $PB . "'><font color='lime' id='col_7".($i+1-$start)."'>" . $PB . "</th>\n"; }
echo "\t\t</tr>";

echo "\t\t<tr><th><a>".$lang_defence["GB"]."</a></th>";
	for ($i=$start ; $i<=$start+8 ; $i++) {
		$GB = $user_defence[$i]["GB"];
		if ($user_technology["Bouclier"] > 5 && $user_building[$i]["CSp"] > 5 && $GB == "0") {
			set_cout_optimize_defence($i, 7, 1);
			$user_defence_const[$i]["GB"] = 1;
			$GB = "0 (1)"; }
		if ($user_building[$i]["planet_name"] == "") { $GB = ""; }
		echo "\t<th><input type='hidden' id='8".($i+1-$start)."' value='" . $GB . "'><font color='lime' id='col_8".($i+1-$start)."'>" . $GB. "</th>\n"; }
echo "\t\t</tr>";

echo "\t\t<tr>";
echo "<th><select onmouseover=\"this.T_WIDTH=310;this.T_TEMP=0;return escape('&lt;table width=&quot;300&quot;&gt;&lt;tr&gt;&lt;td align=&quot;center&quot; class=&quot;c&quot;&gt;Information&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;th align=&quot;center&quot;&gt;Vous devez pr&eacute;alablement s&eacute;lectionner une plan&egrave;te valide afin d\'y fixer une unit&eacute;.&lt;br /&gt;---oOo---&lt;br /&gt;Vos valeurs ne seront retenues que si elles sont strictement sup&eacute;rieures &agrave; celles des unit&eacute;s apr&egrave;s optimisation.&lt;br /&gt;---oOo---&lt;br /&gt;Apr&egrave;s enregistrement, vous obtiendrez en bleu le nombre initial d\'unit&eacute;s suivi de --> et de la valeur cible du nombre d\'unit&eacute;s choisi.&lt;/th&gt;&lt;/tr&gt;&lt;/table&gt;')\" name='opt_def_fixe' id='opt_def_fixe' onchange='fix_defence(0)'>";
echo "<option id='0' value='fixer_0'>Fixer</option>";
echo "<option id='1' value='" . $lang_defence["LM"] . "'>" . $lang_defence["LM"] . "</option>";
echo "<option id='2' value='" . $lang_defence["LLE"] . "'>" . $lang_defence["LLE"] . "</option>";
echo "<option id='3' value='" . $lang_defence["LLO"] . "'>" . $lang_defence["LLO"] . "</option>";
echo "<option id='4' value='" . $lang_defence["CG"] . "'>" . $lang_defence["CG"] . "</option>";
echo "<option id='5' value='" . $lang_defence["AI"] . "'>" . $lang_defence["AI"] . "</option>";
echo "<option id='6' value='" . $lang_defence["LP"] . "'>" . $lang_defence["LP"] . "</option>";
echo "</select></th>";

for ($i=$start ; $i<=$start+8 ; $i++) {
	$name = $user_building[$i]["planet_name"];
	$affichage = ($name == "") ? "&nbsp;" : "<input align='center' style='cursor:pointer' type='text' id='fixer_" . $i . "' name='fixer_" . $i ."' size='10' maxlength='10' disabled onBlur='javascript:valid_number_unit(this);'>";

	echo "\t"."<th>" . $affichage . "</th>"; }
?>
		</tr>
		<tr>
			<th><input onmouseover="this.T_WIDTH=210;this.T_TEMP=0;return escape('&lt;table width=&quot;200&quot;&gt;&lt;tr&gt;&lt;td align=&quot;center&quot; class=&quot;c&quot;&gt;Information&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;th align=&quot;center&quot;&gt;Exporter les donn&eacute;es concernant votre plan&egrave;te vers l\'outil de simulation de votre choix.&lt;/th&gt;&lt;/tr&gt;&lt;/table&gt;')" style='cursor:pointer' name="btSubmit_export" id="btSubmit_export" type="button" value="Simulateur" onclick="open_simulator('<?php echo get_user_param("def_simulator"); ?>', <?php echo $user_technology['Armes']; ?>, <?php echo $user_technology['Bouclier']; ?>, <?php echo $user_technology['Protection']; ?>, flottes, attack);"></th>
			<th colspan="3"><input onmouseover="this.T_WIDTH=210;this.T_TEMP=0;return escape('&lt;table width=&quot;200&quot;&gt;&lt;tr&gt;&lt;td align=&quot;center&quot; class=&quot;c&quot;&gt;Information&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;th align=&quot;center&quot;&gt;Utiliser les valeurs finales pour la simulation.&lt;/th&gt;&lt;/tr&gt;&lt;/table&gt;')" style='cursor:pointer' name="simu" id="simu" type="checkbox"> Simuler sur les valeurs finales</th>
			<th colspan="2">&nbsp;</th>
			<th colspan="3"><input onmouseover="this.T_WIDTH=210;this.T_TEMP=0;return escape('&lt;table width=&quot;200&quot;&gt;&lt;tr&gt;&lt;td align=&quot;center&quot; class=&quot;c&quot;&gt;Information&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;th align=&quot;center&quot;&gt;Prise en compte (ou non) des groupes d\'unit&eacute;s &agrave; 0&lt;/th&gt;&lt;/tr&gt;&lt;/table&gt;')" style='cursor:pointer' name="zero_active" value="actif" type="checkbox" <?php echo $pub_result == 0 ? "" : "checked"; ?> onclick="this.form.submit();"> Pris en compte des défenses à 0</th>
			<th><input onmouseover="this.T_WIDTH=210;this.T_TEMP=0;return escape('&lt;table width=&quot;200&quot;&gt;&lt;tr&gt;&lt;td align=&quot;center&quot; class=&quot;c&quot;&gt;Information&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;th align=&quot;center&quot;&gt;Enregistrement de vos unit&eacute;s &agrave; fixer sur la plan&egrave;te s&eacute;lectionn&eacute;e.&lt;/th&gt;&lt;/tr&gt;&lt;/table&gt;')" style='cursor:pointer' name="btSubmit_unit" id="btSubmit_unit" type="submit" value="Envoyer"></th>
		</tr></form>
		<tr>
			<td align="center" class="c" colspan="10">Coûts</td>
		</tr>
		<tr>
			<th><a>Métal</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$color = (($tab_cout[$i][0] >= $tab_cout[$i][1]) && ($tab_cout[$i][0] >= $tab_cout[$i][2]) && ($tab_cout[$i][0] != 0)) ? "Red" : "lime";
	$name = $user_building[$i]["planet_name"];
	$affichage = ($name == "") ? "&nbsp;" : "<font color='" . $color . "' id='8".($i+1-$start)."'>". $tab_cout[$i][0] . "</font>";
	echo "\t<th>" . $affichage ."</th>\n"; }
?>
		</tr>
		<tr>
			<th><a>Cristal</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$color = (($tab_cout[$i][1] >= $tab_cout[$i][0]) && ($tab_cout[$i][1] >= $tab_cout[$i][2]) && ($tab_cout[$i][1] != 0)) ? "Red" : "lime";
	$name = $user_building[$i]["planet_name"];
	$affichage = ($name == "") ? "&nbsp;" : "<font color='" . $color . "' id='8".($i+1-$start)."'>". $tab_cout[$i][1] . "</font>";
	echo "\t<th>" . $affichage ."</font></th>\n"; }
?>
		</tr>
		<tr>
			<th><a>Deutérium</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$color = (($tab_cout[$i][2] >= $tab_cout[$i][0]) && ($tab_cout[$i][2] >= $tab_cout[$i][1]) && ($tab_cout[$i][2] != 0)) ? "Red" : "lime";
	$name = $user_building[$i]["planet_name"];
	$affichage = ($name == "") ? "&nbsp;" : "<font color='" . $color . "' id='8".($i+1-$start)."'>". $tab_cout[$i][2] . "</font>";
	echo "\t<th>" . $affichage ."</font></th>\n"; }
?>
		</tr>
		<tr>
			<td align="center" class="c" colspan="10">Temps de production</td>
		</tr>
		<tr>
			<th><a>Métal</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$CSp = $user_building[$i]["CSp"];
	if ($CSp == "") $CSp = "&nbsp;";
	
	if($view == "planets") {
		$UdN = $user_building[$i]["UdN"];
		if ($UdN == "") $UdN = "&nbsp;"; }
	
	$tab_cout[$i][6] = 7200*($tab_cout[$i][0]+$tab_cout[$i][1])/5000/pow(2,$UdN)/(1+$CSp);
	
	if ($user_building[$i]["planet_name"] != "") { $result = ($tab_cout[$i][3] == 0) ? $tab_cout[$i][0] : $tab_cout[$i][0] / $tab_cout[$i][3]; }
	else { $result = "&nbsp;"; }
	$color = (($result >= (($tab_cout[$i][4] == 0) ? $tab_cout[$i][1] : $tab_cout[$i][1] / $tab_cout[$i][4])) && ($result >= (($tab_cout[$i][5] == 0) ? $tab_cout[$i][2] : $tab_cout[$i][2] / $tab_cout[$i][5])) && ($result * 3600) >= $tab_cout[$i][6]) ? "Red" : "lime";
	echo "\t"."<th><font color='" . $color . "' id='11".($i+1-$start)."'>". convert_time($result * 3600) . "</font></th>"."\n"; }
?>
		</tr>
		<tr>
			<th><a>Cristal</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	if ($user_building[$i]["planet_name"] != "") { $result = ($tab_cout[$i][4] == 0) ? $tab_cout[$i][1] : $tab_cout[$i][1] / $tab_cout[$i][4]; }
	else { $result = "&nbsp;"; }
	$color = (($result >= (($tab_cout[$i][3] == 0) ? $tab_cout[$i][0] : $tab_cout[$i][0] / $tab_cout[$i][3])) && ($result >= (($tab_cout[$i][5] == 0) ? $tab_cout[$i][2] : $tab_cout[$i][2] / $tab_cout[$i][5])) && ($result * 3600) >= $tab_cout[$i][6]) ? "Red" : "lime";
	echo "\t"."<th><font color='" . $color . "' id='12".($i+1-$start)."'>". convert_time($result * 3600) . "</font></th>"."\n"; }
?>
		</tr>
		<tr>
			<th><a>Deutérium</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	if ($user_building[$i]["planet_name"] != "") { $result = ($tab_cout[$i][5] == 0) ? $tab_cout[$i][2] : $tab_cout[$i][2] / $tab_cout[$i][5]; }
	else { $result = "&nbsp;"; }
	$color = (($result >= (($tab_cout[$i][3] == 0) ? $tab_cout[$i][0] : $tab_cout[$i][0] / $tab_cout[$i][3])) && ($result >= (($tab_cout[$i][4] == 0) ? $tab_cout[$i][1] : $tab_cout[$i][1] / $tab_cout[$i][4])) && ($result * 3600) >= $tab_cout[$i][6]) ? "Red" : "lime";
	echo "\t"."<th><font color='" . $color . "' id='13".($i+1-$start)."'>". convert_time($result * 3600) . "</font></th>"."\n"; }
?>
		</tr>
		<tr>
			<th><a>Unités</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	if ($user_building[$i]["planet_name"] != "") { $result = $tab_cout[$i][6]; }
	else { $result = "&nbsp;"; }
	$color = ((($result / 3600) >= (($tab_cout[$i][3] == 0) ? $tab_cout[$i][0] : $tab_cout[$i][0] / $tab_cout[$i][3])) && (($result / 3600) >= (($tab_cout[$i][4] == 0) ? $tab_cout[$i][1] : $tab_cout[$i][1] / $tab_cout[$i][4])) && (($result / 3600) >= (($tab_cout[$i][5] == 0) ? $tab_cout[$i][2] : $tab_cout[$i][2] / $tab_cout[$i][5]))) ? "Red" : "lime";
	echo "\t"."<th><font color='" . $color . "' id='14".($i+1-$start)."'>". convert_time($result) . "</font></th>"."\n"; }
?>
		</tr>
		<tr>
			<td align="center" class="c" colspan="10">Puissance développée avant création (après)</td>
		</tr>
		<tr>
			<th><a>En attaque</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$result = ($user_defence[$i]["LM"] * $tab_rq_def[0]["attaque"]) + ($user_defence[$i]["LLE"] * $tab_rq_def[1]["attaque"]) + ($user_defence[$i]["LLO"] * $tab_rq_def[2]["attaque"]) + ($user_defence[$i]["CG"] * $tab_rq_def[3]["attaque"]) + ($user_defence[$i]["AI"] * $tab_rq_def[4]["attaque"]) + ($user_defence[$i]["LP"] * $tab_rq_def[5]["attaque"]) + ($user_defence[$i]["PB"] * $tab_rq_def[6]["attaque"]) + ($user_defence[$i]["GB"] * $tab_rq_def[7]["attaque"]);
	$result_const = ($user_defence_const[$i]["LM"] * $tab_rq_def[0]["attaque"]) + ($user_defence_const[$i]["LLE"] * $tab_rq_def[1]["attaque"]) + ($user_defence_const[$i]["LLO"] * $tab_rq_def[2]["attaque"]) + ($user_defence_const[$i]["CG"] * $tab_rq_def[3]["attaque"]) + ($user_defence_const[$i]["AI"] * $tab_rq_def[4]["attaque"]) + ($user_defence_const[$i]["LP"] * $tab_rq_def[5]["attaque"]) + ($user_defence_const[$i]["PB"] * $tab_rq_def[6]["attaque"]) + ($user_defence_const[$i]["GB"] * $tab_rq_def[7]["attaque"]);
	if ($result_const != 0) { $result = $result."<br>(".($result_const+$result).")"; }
	if ($user_building[$i]["planet_name"] == "") { $result = "&nbsp;"; }
	
	echo "\t"."<th>". $result . "</th>"."\n"; }
?>
		</tr>
			<th><a>En défense</a></th>
<?php
for ($i=$start ; $i<=$start+8 ; $i++) {
	$result = ($user_defence[$i]["LM"] * $tab_rq_def[0]["bouclier"]) + ($user_defence[$i]["LLE"] * $tab_rq_def[1]["bouclier"]) + ($user_defence[$i]["LLO"] * $tab_rq_def[2]["bouclier"]) + ($user_defence[$i]["CG"] * $tab_rq_def[3]["bouclier"]) + ($user_defence[$i]["AI"] * $tab_rq_def[4]["bouclier"]) + ($user_defence[$i]["LP"] * $tab_rq_def[5]["bouclier"]) + ($user_defence[$i]["PB"] * $tab_rq_def[6]["bouclier"]) + ($user_defence[$i]["GB"] * $tab_rq_def[7]["bouclier"]);
	$result_const = ($user_defence_const[$i]["LM"] * $tab_rq_def[0]["bouclier"]) + ($user_defence_const[$i]["LLE"] * $tab_rq_def[1]["bouclier"]) + ($user_defence_const[$i]["LLO"] * $tab_rq_def[2]["bouclier"]) + ($user_defence_const[$i]["CG"] * $tab_rq_def[3]["bouclier"]) + ($user_defence_const[$i]["AI"] * $tab_rq_def[4]["bouclier"]) + ($user_defence_const[$i]["LP"] * $tab_rq_def[5]["bouclier"]) + ($user_defence_const[$i]["PB"] * $tab_rq_def[6]["bouclier"]) + ($user_defence_const[$i]["GB"] * $tab_rq_def[7]["bouclier"]);
	if ($result_const != 0) { $result = $result."<br>(".($result_const+$result).")"; }
	if ($user_building[$i]["planet_name"] == "") { $result = "&nbsp;"; }
	
	echo "\t"."<th>". $result . "</th>"."\n"; }
?>
		</tr>
		<tr>
			<td align="center" class="c" colspan="10">&nbsp;</td>
		</tr>
		</table>
	</td>
</tr>
</table>
<?php
require_once("mod/defence/defence_footer.php");
?>
