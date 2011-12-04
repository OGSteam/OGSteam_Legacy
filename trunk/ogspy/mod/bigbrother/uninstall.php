<?php


if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// fichier commun
require_once ("mod/bigbrother/common.php");

// Xtense
define("TABLE_XTENSE_CALLBACKS", $table_prefix . "xtense_callbacks");


// On récupère l'id du mod pour xtense...
$query = "SELECT id FROM ".TABLE_MOD." WHERE action='bigbrother'";
$result = $db->sql_query($query);
list($mod_id) = $db->sql_fetch_row($result);

// On regarde si la table xtense_callbacks existe :
$query = 'SHOW TABLES LIKE "'.TABLE_XTENSE_CALLBACKS.'"';
$result = $db->sql_query($query);
if ($db->sql_numrows($result) != 0) {
	//Le mod xtense 2 est installé !
	//Maintenant on regarde si cdr est dedans normalement oui mais on est jamais trop prudent...
	$query = 'SELECT * FROM '.TABLE_XTENSE_CALLBACKS.' WHERE mod_id = '.$mod_id;
	$result = $db->sql_query($query);
	if ($db->sql_numrows($result) != 0) {
		// Il est  dedans alors on l'enlève :
		$query = 'DELETE FROM '.TABLE_XTENSE_CALLBACKS.' WHERE mod_id = '.$mod_id;
		$db->sql_query($query);
	//echo "<script>alert('".$lang['xtense_gone']."')</script>";
	}
}
// todo supp le cache
//echo "<script>alert(".$lang['xtense_gone'].")</script>";

$mod_uninstall_name = "bigbrother";
$mod_uninstall_table = TABLE_PLAYER.','.TABLE_STORY_PLAYER.' ,'.TABLE_STORY_ALLY.' ,'.TABLE_ALLY.' ,'.TABLE_UNI.' ,'.TABLE_RPR.' ,'.TABLE_RPF.' ,'.TABLE_RPP;




// remise en etat de la base :
//joueur
//$requests[] = "ALTER TABLE ".TABLE_RANK_PLAYER_POINTS." DROP id_player ";
//$requests[] = "ALTER TABLE ".TABLE_RANK_PLAYER_FLEET." DROP id_player ";
//$requests[] = "ALTER TABLE ".TABLE_RANK_PLAYER_RESEARCH." DROP id_player ";
//alliance
//$requests[] = "ALTER TABLE ".TABLE_RANK_ALLY_POINTS." DROP id_ally ";
//$requests[] = "ALTER TABLE ".TABLE_RANK_ALLY_FLEET." DROP id_ally ";
//$requests[] = "ALTER TABLE ".TABLE_RANK_ALLY_RESEARCH." DROP id_ally ";

//modif system solaire
//$requests[] = "ALTER TABLE ".TABLE_UNIVERSE." DROP id_ally "; // null => pas encore mis a jour 0 pas d alliance -1 alliance du detenteur de compte ogspy 
//$requests[] = "ALTER TABLE ".TABLE_UNIVERSE." DROP id_player";

//config
$requests[] = "DELETE FROM ".TABLE_CONFIG." WHERE config_name = 'bigbrother'";

// on injecte toutes les requetes
foreach ($requests as $request) {
	$db->sql_query($request);
}



// le cache :
generate_config_cache();
uninstall_mod($mod_uninstall_name, $mod_uninstall_table);

?>
