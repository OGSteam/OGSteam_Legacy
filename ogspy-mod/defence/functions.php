<?php
/***************************************************************************
*	filename	: functions.php
*	desc.		: Fonctions nécessaires à 'Optimisation de la défence'
*	Author		: Lothadith
*	created		: 15/12/2006
*	modified	: 03/09/2007
*	version		: 0.8b
***************************************************************************/

if (!defined('IN_SPYOGAME')) { die("Passe ton chemin manant !"); }

/***************************************************************************
*	Accès à la base SQL
***************************************************************************/
// Résupération des données utilisateur
function get_user_param($champ)
{
	global $db, $user_data;
	$request = "SELECT " . $champ . " FROM " . TABLE_DEFENCE_OPTION . " where user_id = ".$user_data["user_id"];
	$result = $db->sql_query($request);
	if ($db->sql_numrows($result) != 0) {
		$row = $db->sql_fetch_assoc($result);
		return $row[$champ]; }
	else {
		if ($champ == "def_select") {
			$request = "INSERT INTO " . TABLE_DEFENCE_OPTION . " (user_id, " . $champ . ") VALUES (" . $user_data["user_id"] . ", 'attaque')";
			$db->sql_query($request); 
			return "attaque"; }
		elseif ($champ == "def_simulator") {
			$request = "INSERT INTO " . TABLE_DEFENCE_OPTION . " (user_id, " . $champ . ") VALUES (" . $user_data["user_id"] . ", 'speedsim')";
			$db->sql_query($request); 
			return "attaque"; }
		else {
			$request = "INSERT INTO " . TABLE_DEFENCE_OPTION . " (user_id, " . $champ . ") VALUES (" . $user_data["user_id"] . ", '0')";
			$db->sql_query($request); 
			return "0"; } }
}

// Enregistrement des données utilisateur
function set_user_param($new_param, $champ)
{
	global $db, $user_data;
	$request = "SELECT " . $champ . " FROM " . TABLE_DEFENCE_OPTION . " where user_id = ".$user_data["user_id"];
	$result = $db->sql_query($request);
	$request = "UPDATE " . TABLE_DEFENCE_OPTION . " set " . $champ . " = '" . $new_param . "' where user_id = ".$user_data["user_id"];
	$db->sql_query($request);
}

// Résupération des données concernant le module
function get_info_mod($info) {
	global $db, $pub_action;
	$sql = "SELECT * FROM ".TABLE_MOD." WHERE action = '".$pub_action."' LIMIT 1";
	$query = $db->sql_query($sql);
	$fetch = $db->sql_fetch_assoc($query);
	return $fetch[$info];
}

// Résupération des données concernant la défense
function init_tab_def()
{
	global $db;
	$request = "SELECT * FROM " . TABLE_DEFENCE . " ORDER BY `defence_id`";
	$result = $db->sql_query($request);
	$defence_rows = array();
	while ( $row = $db->sql_fetch_assoc($result) ) { $defence_rows[] = $row; }
	
	return $defence_rows;
}

// Enregistrement des données concernant la défense
function user_set_empire_defence($data, $planet_id, $planet_name, $coordinates, $view) {
	global $db, $user_data, $lang_defence;

	$planet_name = trim($planet_name) != "" ? trim($planet_name) : "Inconnu";
	if (!check_var($planet_name, "Galaxy")) $planet_name = "";
	$coordinates_ok = "";
	if (sizeof(explode(":", $coordinates)) == 3 || sizeof(explode(".", $coordinates)) == 3) {
		if (sizeof(explode(":", $coordinates)) == 3) @list($galaxy, $system, $row) = explode(":", $coordinates);
		if (sizeof(explode(".", $coordinates)) == 3) @list($galaxy, $system, $row) = explode(".", $coordinates);
		if (intval($galaxy) >= 1 && intval($galaxy) <= 9 &&  intval($system) >= 1 &&  intval($system) <= 499 &&  intval($row) >= 1 &&  intval($row) <= 15) {
			$coordinates_ok = $coordinates; } }

	$planet_id = intval($planet_id);
	if (($view=="planets" && ($planet_id < 1 || $planet_id > 9)) || ($view=="lunes" && ($planet_id < 10 || $planet_id > 18))) {
		redirection("index.php?action=message&id_message=set_empire_failed_data&info"); }

	$link_defence = array($lang_defence["LM"] => "LM", $lang_defence["LLE"] => "LLE", $lang_defence["LLO"] => "LLO",
	$lang_defence["CG"] => "CG", $lang_defence["AI"] => "AI", $lang_defence["LP"] => "LP",
	$lang_defence["PB"] => "PB", $lang_defence["GB"] => "GB",
	$lang_defence["MIC"] => "MIC", $lang_defence["MIP"] => "MIP");

	$defences = array("LM" => 0, "LLE" => 0,	"LLO" => 0,
	"CG" => 0, "AI" => 0, "LP" => 0,
	"PB" => 0, "GB" => 0,
	"MIC" => 0, "MIP" => 0);

	$lines = explode(chr(10), str_replace('.','',$data));

	$OK = false;
	foreach ($lines as $line) {
		$arr = array();
		$line = trim($line);

		if (ereg("^(.*) \(([[:space:][:digit:]]{1,9}|[[:digit:]]{1,9}) disponible", $line, $arr)) { 
			list($string, $defence, $level) = $arr;

			$defence = trim($defence);
			$level = trim(str_replace("disponible(s)", "", $level));
			if (isset($link_defence[$defence])) {
				$OK = true;
				$defences[$link_defence[$defence]] = $level; } } }

	if ($OK) {
		$request = "delete from ".TABLE_USER_DEFENCE." where user_id = ".$user_data["user_id"]." and planet_id= ".$planet_id;
		$db->sql_query($request);

		$request = "insert into ".TABLE_USER_DEFENCE." (user_id, planet_id, LM, LLE, LLO, CG, AI, LP, PB, GB, MIC, MIP)";
		$request .= " values (".$user_data["user_id"].", ".$planet_id.", ".$defences["LM"].", ".$defences["LLE"].",".$defences["LLO"].", ".$defences["CG"].", ".$defences["AI"].", ".$defences["LP"].", ".$defences["PB"].", ".$defences["GB"].", ".$defences["MIC"].", ".$defences["MIP"].")";
		$db->sql_query($request);
		return true; }
	
	else { return false; }
}

// Enregistrement des unités fixées par l'utilisateur
function save_units($view)
{
	global $db, $user_data, $lang_defence, $pub_opt_def_opt, $user_defence, $user_defence_fix, $pub_opt_def_fixe;
	global $pub_fixer_1, $pub_fixer_2, $pub_fixer_3, $pub_fixer_4, $pub_fixer_5, $pub_fixer_6, $pub_fixer_7, $pub_fixer_8, $pub_fixer_9;
	
	switch ($pub_opt_def_fixe) {
		case $lang_defence["LM"] :
			$idef = 0;
			$new_param1 = "LM";
			break;
		case $lang_defence["LLE"] :
			$idef = 1;
			$new_param1 = "LLE";
			break;
		case $lang_defence["LLO"] :
			$idef = 2;
			$new_param1 = "LLO";
			break;
		case $lang_defence["CG"] :
			$idef = 3;
			$new_param1 = "CG";
			break;
		case $lang_defence["AI"] :
			$idef = 4;
			$new_param1 = "AI";
			break;
		case $lang_defence["LP"] :
			$idef = 5;
			$new_param1 = "LP";
			break;
		default :
			$new_param1 = "";
			return false; }
	
	if ($view == "planets") {
		if (isset($pub_fixer_1)) { $iplanet = 1; $champ1 = "def_p1_unit"; $champ2 = "def_p1_nb"; $new_param2 = $pub_fixer_1; }
		if (isset($pub_fixer_2)) { $iplanet = 2; $champ1 = "def_p2_unit"; $champ2 = "def_p2_nb"; $new_param2 = $pub_fixer_2; }
		if (isset($pub_fixer_3)) { $iplanet = 3; $champ1 = "def_p3_unit"; $champ2 = "def_p3_nb"; $new_param2 = $pub_fixer_3; }
		if (isset($pub_fixer_4)) { $iplanet = 4; $champ1 = "def_p4_unit"; $champ2 = "def_p4_nb"; $new_param2 = $pub_fixer_4; }
		if (isset($pub_fixer_5)) { $iplanet = 5; $champ1 = "def_p5_unit"; $champ2 = "def_p5_nb"; $new_param2 = $pub_fixer_5; }
		if (isset($pub_fixer_6)) { $iplanet = 6; $champ1 = "def_p6_unit"; $champ2 = "def_p6_nb"; $new_param2 = $pub_fixer_6; }
		if (isset($pub_fixer_7)) { $iplanet = 7; $champ1 = "def_p7_unit"; $champ2 = "def_p7_nb"; $new_param2 = $pub_fixer_7; }
		if (isset($pub_fixer_8)) { $iplanet = 8; $champ1 = "def_p8_unit"; $champ2 = "def_p8_nb"; $new_param2 = $pub_fixer_8; }
		if (isset($pub_fixer_9)) { $iplanet = 9; $champ1 = "def_p9_unit"; $champ2 = "def_p9_nb"; $new_param2 = $pub_fixer_9; } }
	else {
		if (isset($pub_fixer_1)) { $iplanet = 1; $champ1 = "def_l1_unit"; $champ2 = "def_l1_nb"; $new_param2 = $pub_fixer_1; }
		if (isset($pub_fixer_2)) { $iplanet = 2; $champ1 = "def_l2_unit"; $champ2 = "def_l2_nb"; $new_param2 = $pub_fixer_2; }
		if (isset($pub_fixer_3)) { $iplanet = 3; $champ1 = "def_l3_unit"; $champ2 = "def_l3_nb"; $new_param2 = $pub_fixer_3; }
		if (isset($pub_fixer_4)) { $iplanet = 4; $champ1 = "def_l4_unit"; $champ2 = "def_l4_nb"; $new_param2 = $pub_fixer_4; }
		if (isset($pub_fixer_5)) { $iplanet = 5; $champ1 = "def_l5_unit"; $champ2 = "def_l5_nb"; $new_param2 = $pub_fixer_5; }
		if (isset($pub_fixer_6)) { $iplanet = 6; $champ1 = "def_l6_unit"; $champ2 = "def_l6_nb"; $new_param2 = $pub_fixer_6; }
		if (isset($pub_fixer_7)) { $iplanet = 7; $champ1 = "def_l7_unit"; $champ2 = "def_l7_nb"; $new_param2 = $pub_fixer_7; }
		if (isset($pub_fixer_8)) { $iplanet = 8; $champ1 = "def_l8_unit"; $champ2 = "def_l8_nb"; $new_param2 = $pub_fixer_8; }
		if (isset($pub_fixer_9)) { $iplanet = 9; $champ1 = "def_l9_unit"; $champ2 = "def_l9_nb"; $new_param2 = $pub_fixer_9; } }
	
	if ($new_param2 <= $user_defence[$iplanet][$new_param1] + get_optimize_defence($user_defence_fix[$iplanet], $idef, $new_param1, $pub_opt_def_opt, $iplanet)) {$new_param1 = ""; $new_param2 = "";}
	
	if ($champ1 != "" && $champ2 != "") {
		$request = "UPDATE " . TABLE_DEFENCE_OPTION . " set " . $champ1 . " = '" . $new_param1 . "', " . $champ2 . " = '" . $new_param2 . "' where user_id = ".$user_data["user_id"];
		$db->sql_query($request); }
}

// Résupération des données concernant les coefficients
function get_coef() {
	global $db, $user_data;
	$sql = "SELECT planet_id, LM, LLE, LLO, CG, AI, LP, defence_coef_rapport FROM ".TABLE_DEFENCE_COEF." WHERE user_id = '".$user_data["user_id"]."'";
	$query = $db->sql_query($sql);
	if ($db->sql_numrows($query) == 0) {
		for ($i=1; $i<10; $i++) {
			$sql = "INSERT INTO " . TABLE_DEFENCE_COEF . " (user_id, planet_id) VALUES (" . $user_data["user_id"] . ", ".$i.")";
			$db->sql_query($sql); }
		$sql = "SELECT * FROM ".TABLE_DEFENCE_COEF." WHERE user_id = '".$user_data["user_id"]."'";
		$query = $db->sql_query($sql); }
	
	$defence_coef[] = array();
	while ( $row = $db->sql_fetch_assoc($query) ) { $defence_coef[] = $row; }
	
	return $defence_coef;
}

// Récupération des données concernant les flottes si le module est activé
function get_flottes() {
	global $db, $user_data;
	$sql = "SELECT planet_name, coordinates, PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, SAT, DST, EDLM, TRA FROM ".TABLE_MOD_FLOTTES." WHERE user_id = ".$user_data["user_id"];
	$query = $db->sql_query($sql);
	if ($db->sql_numrows($query) != 0) {	
		$flottes[] = array();
		while ( $row = $db->sql_fetch_row($query) ) {
			$flottes[] = $row; } }
	
	return $flottes;
}

// Récupération des données concernant les flottes si le module est activé
function get_attack() {
	global $db, $user_data;
	$sql = "SELECT * FROM ".TABLE_DEFENCE_ATTACK." WHERE user_id = ".$user_data["user_id"];
	$query = $db->sql_query($sql);
	if ($db->sql_numrows($query) == 0) {
		$sql = "INSERT INTO ".TABLE_DEFENCE_ATTACK." (user_id) VALUES (".$user_data["user_id"].")";
		$db->sql_query($sql);
		$sql = "SELECT * FROM ".TABLE_DEFENCE_ATTACK." WHERE user_id = ".$user_data["user_id"];
		$query = $db->sql_query($sql); }
	
	$attack[] = array();
	while ( $row = $db->sql_fetch_row($query) ) { $attack[] = $row; }
	
	return $attack;
}

/***************************************************************************
*	Fonctions propres
***************************************************************************/
// Optimisation de la défense
function get_optimize_defence($tab_user_defs, $i_def, $s_def, $choice, $planet_id)
{
	global $tab_rq_def, $tab_rq_coef;
	
	if ($tab_user_defs[$s_def] == 0 and get_user_param("def_zero_active") == 0) { return ""; }
	
	$is_max = 0;
	$opt_def = 0;
	
	if ($tab_rq_coef[$planet_id]["LM"] != 0 ) { $is_max = $tab_user_defs["LM"] * $tab_rq_def[0][$choice] / ($tab_rq_coef[$planet_id]["LM"] / 100); }
	if ($is_max > $opt_def) $opt_def=$is_max;
	if ($tab_rq_coef[$planet_id]["LLE"] != 0 ) { $is_max = $tab_user_defs["LLE"] * $tab_rq_def[1][$choice] / ($tab_rq_coef[$planet_id]["LLE"] / 100); }
	if ($is_max > $opt_def) $opt_def=$is_max;
	if ($tab_rq_coef[$planet_id]["LLO"] != 0 ) { $is_max = $tab_user_defs["LLO"] * $tab_rq_def[2][$choice] / ($tab_rq_coef[$planet_id]["LLO"] / 100); }
	if ($is_max > $opt_def) $opt_def=$is_max;
	if ($tab_rq_coef[$planet_id]["CG"] != 0 ) { $is_max = $tab_user_defs["CG"] * $tab_rq_def[3][$choice] / ($tab_rq_coef[$planet_id]["CG"] / 100); }
	if ($is_max > $opt_def) $opt_def=$is_max;
	if ($tab_rq_coef[$planet_id]["AI"] != 0 ) { $is_max = $tab_user_defs["AI"] * $tab_rq_def[4][$choice] / ($tab_rq_coef[$planet_id]["AI"] / 100); }
	if ($is_max > $opt_def) $opt_def=$is_max;
	if ($tab_rq_coef[$planet_id]["LP"] != 0 ) { $is_max = $tab_user_defs["LP"] * $tab_rq_def[5][$choice] / ($tab_rq_coef[$planet_id]["LP"] / 100); }
	if ($is_max > $opt_def) $opt_def=$is_max;
	
	if ($choice=="bouclier") {
		$is_max = $tab_user_defs["PB"] * $tab_rq_def[6][$choice];
		if ($is_max > $opt_def) $opt_def=$is_max;
		$is_max = $tab_user_defs["GB"] * $tab_rq_def[7][$choice];
		if ($is_max > $opt_def) $opt_def=$is_max; }
	
	$result = round((($opt_def/$tab_rq_def[$i_def][$choice])*($tab_rq_coef[$planet_id][$s_def] / 100)) - $tab_user_defs[$s_def]);
	
	return ($result < 0) ? 0 : $result;
}

// Coût de l'optimisation de la défense
function set_cout_optimize_defence($i_planet, $i_def, $unit_nb)
{
	global $tab_rq_def, $tab_cout;
	
	$tab_cout[$i_planet][0] += $unit_nb * $tab_rq_def[$i_def]["metal"];
	$tab_cout[$i_planet][1] += $unit_nb * $tab_rq_def[$i_def]["cristal"];
	$tab_cout[$i_planet][2] += $unit_nb * $tab_rq_def[$i_def]["deut"];
}

// Ajout du coût des unités fixées
function cout_unit_fix($i_planet)
{
	global $tab_rq_def, $view, $tab_cout, $user_defence;
	
	$lieu = (($view == "planets") ? "p" . $i_planet : "l" . ($i_planet - 9));
	$unit_fix = get_user_param("def_" . $lieu . "_unit");
	if (isset($unit_fix)) {
		$unit_nb = get_user_param("def_" . $lieu . "_nb");
		switch ($unit_fix) {
			case "LM":
				if ($unit_nb > $user_defence[$i_planet]["LM"]) {
					$unit_nb -= $user_defence[$i_planet]["LM"];
					set_cout_optimize_defence($i_planet, 0, $unit_nb); }
				break;
			case "LLE":
				if ($unit_nb > $user_defence[$i_planet]["LLE"]) {
					$unit_nb -= $user_defence[$i_planet]["LLE"];
					set_cout_optimize_defence($i_planet, 1, $unit_nb); }
				break;
			case "LLO":
				if ($unit_nb > $user_defence[$i_planet]["LLO"]) {
					$unit_nb -= $user_defence[$i_planet]["LLO"];
					set_cout_optimize_defence($i_planet, 2, $unit_nb); }
				break;
			case "CG":
				if ($unit_nb > $user_defence[$i_planet]["CG"]) {
					$unit_nb -= $user_defence[$i_planet]["CG"];
					set_cout_optimize_defence($i_planet, 3, $unit_nb); }
				break;
			case "AI":
				if ($unit_nb > $user_defence[$i_planet]["AI"]) {
					$unit_nb -= $user_defence[$i_planet]["AI"];
					set_cout_optimize_defence($i_planet, 4, $unit_nb); }
				break;
			case "LP":
				if ($unit_nb > $user_defence[$i_planet]["LP"]) {
					$unit_nb -= $user_defence[$i_planet]["LP"];
					set_cout_optimize_defence($i_planet, 5, $unit_nb); }
				break;
			default:
				break; } }
}

// Modification du tableau user_defence_fix
function change_user_defence_fix()
{
	global $user_defence_fix, $user_defence, $view;
	
	for ($i=1 ; $i<=9 ; $i++) {
		$lieu = (($view == "planets") ? "p" : "l") . $i;
		$unit_fix = get_user_param("def_" . $lieu . "_unit");
		if (isset($unit_fix)) {
			$unit_nb = get_user_param("def_" . $lieu . "_nb");
			switch ($unit_fix) {
				case "LM":
					$user_defence_fix[$i]["LM"] = $unit_nb;
					break;
				case "LLE":
					$user_defence_fix[$i]["LLE"] = $unit_nb;
					break;
				case "LLO":
					$user_defence_fix[$i]["LLO"] = $unit_nb;
					break;
				case "CG":
					$user_defence_fix[$i]["CG"] = $unit_nb;
					break;
				case "AI":
					$user_defence_fix[$i]["AI"] = $unit_nb;
					break;
				case "LP":
					$user_defence_fix[$i]["LP"] = $unit_nb;
					break;
				default:
					break; } } }
}

/***************************************************************************
*	Fonctions pouvant faire l'objet d'une intégration dans le logiciel maître
***************************************************************************/
// Formater un nombre de secondes en jour heure minute seconde
function convert_time($value)
{
	$jour = floor($value / 86400);
	$heure = floor(($value - ($jour * 86400)) / 3600);
	$minute = floor(($value - ($jour * 86400) - ($heure * 3600)) / 60);
	$seconde = round($value - ($jour * 86400) - ($heure * 3600) - ($minute * 60));
	
	$result = (($jour > 0) ? $jour . "j " : "");
	$result .= (($heure > 0) ? $heure . "h " : "");
	$result .= (($minute > 0) ? $minute . "m " : "");
	$result .= (($seconde > 0) ? $seconde . "s" : "");
	
	return ($result);
}

// Convertir un tableau PHP en un tableau JS
function convert_tab_php($tabPHP, $tabJS) {
   echo $tabJS." = new Array();\n";
   for($i = 0; $i < count($tabPHP); $i++) {
      if(!is_array($tabPHP[$i])) {
         echo $tabJS."[".$i."] = '".$tabPHP[$i]."';\n"; }
      else {
         convert_tab_php($tabPHP[$i], $tabJS."[".$i."]"); } }

   return;
}

?>
