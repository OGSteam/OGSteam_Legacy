<?php
/***************************************************************************
*	filename	: defence.php
*	desc.		: Page principale de 'Optimisation de la d�fence'
*	Author		: Lothadith
*	created		: 03/01/2007
*	modified	: 03/09/2007
*	version		: 0.8b
***************************************************************************/

if (!defined('IN_SPYOGAME')) { die("Passe ton chemin manant !"); }

/***************************************************************************
*	desc.		: Le memento du blaireau
***************************************************************************/

/***************************************************************************
*	Cas 1		: Langue fran�aise
*	desc.		: A coder
*	Objectif	: Donner la possibilit� aux autochtones de comprendre les textes
*	Priorit�	: 0
***************************************************************************/

/***************************************************************************
*	Cas 2		: Les lunes
*	desc.		: Se renseigner
*	Objectif	: Tester l'outil sur les lunes
*	Priorit�	: 5
***************************************************************************/

/***************************************************************************
*	Cas 3		: Permettre l'optimisation en fonction des ressources � prot�ger
*	desc.		: A coder
*	Objectif	: En r�flexion
*			: Comment faire ...
*	Priorit�	: 3
***************************************************************************/

/***************************************************************************
*	Cas 5		: Les plan�tes bougent
*	desc.		: A coder
*	Objectif	: En r�flexion
*			: Modifier les tables du mod si l'id des plan�tes a boug� suite � suppression ou � simple mouvement
*	Priorit�	: 5
***************************************************************************/

// Fichiers requis
require_once("parameters/lang_empire.php");
require_once("views/page_header.php");
require_once("includes/ogame.php");
require_once("mod/defence/functions.php");

// Compl�ment au fichier config.php
define("TABLE_DEFENCE", $table_prefix."defence");
define("TABLE_DEFENCE_OPTION", $table_prefix."defence_option");
define("TABLE_DEFENCE_COEF", $table_prefix."defence_coef");
define("TABLE_DEFENCE_ATTACK", $table_prefix."defence_attack");
define("TABLE_MOD_FLOTTES", $table_prefix."mod_flottes");

// Contr�le de l'insertion du module
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='defence' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

// Contr�le de l'existence du module "Flottes"
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='mod_flottes' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) {
	$user_flottes = null; }
else {
	$user_flottes = get_flottes(); }

// D�claration des variables globales
$user_empire = user_get_empire();
$user_building = $user_empire["building"];
$user_technology = $user_empire["technology"];
$user_defence = $user_defence_fix = $user_empire["defence"];
$tab_rq_def = init_tab_def();
$tab_rq_coef = get_coef();
$tab_rq_attack = get_attack();
?>

<script type="text/javascript">
function valid_number_unit(activ_obj)
{
	if (is_number(activ_obj) == false) {
		activ_obj.value = 0; }
}

function is_number(activ_obj)
{
	var ValidChars = "0123456789.";
	var IsNumber=true;
	var Char;
	
	if(activ_obj.value == "") {
		return false; }
	
	if(activ_obj.value.split(".").length > 2) {
		alert("Saisissez un nombre valide.");
		return false; }

	for (i = 0; i < activ_obj.value.length; i++) {
		Char = activ_obj.value.charAt(i);
		if (ValidChars.indexOf(Char) == -1) {
			alert("Saisissez un nombre valide.");
			return false; } }
	
	return true;
}
</script>

<table width="100%">
<tr>
	<td align="center">
		<table>
		<tr align="center">
<?php
if (!isset($pub_subaction)) $pub_subaction = "optimize";

if ($pub_subaction != "optimize") {
	echo "\t\t\t"."<td style='cursor:pointer' class='c' width='150' onclick=\"window.location = 'index.php?action=defence&subaction=optimize';\">";
	echo "<a><font color='lime'>Optimisation</font></a>";
	echo "</td>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Optimisation</a>";
	echo "</th>";
}

if ($pub_subaction != "administration") {
	echo "\t\t\t"."<td style='cursor:pointer' class='c' width='150' onclick=\"window.location = 'index.php?action=defence&subaction=administration';\">";
	echo "<a><font color='lime'>Administration</font></a>";
	echo "</td>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Administration</a>";
	echo "</th>";
}
?>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
<?php
switch ($pub_subaction) {
	case "optimize" :
	require_once("defence_optimize.php");
	break;

	case "administration" :
	require_once("defence_administration.php");
	break;
}
?>
	</td>
</tr>
</table>

<?php
require_once("views/page_tail.php");
?>
