<?php


if (!defined('IN_SPYOGAME'))
    die("Hacking attempt");

// fichier commun
require_once ("mod/bigbrother/common.php");

// Xtense
define("TABLE_XTENSE_CALLBACKS", $table_prefix . "xtense_callbacks");


// On récupère l'id du mod pour xtense...
$query = "SELECT id FROM " . TABLE_MOD . " WHERE action='bigbrother'";
$result = $db->sql_query($query);
list($mod_id) = $db->sql_fetch_row($result);

// On regarde si la table xtense_callbacks existe :
$query = 'SHOW TABLES LIKE "' . TABLE_XTENSE_CALLBACKS . '"';
$result = $db->sql_query($query);
if ($db->sql_numrows($result) != 0) {
    //Le mod xtense 2 est installé !
    //Maintenant on regarde si cdr est dedans normalement oui mais on est jamais trop prudent...
    $query = 'SELECT * FROM ' . TABLE_XTENSE_CALLBACKS . ' WHERE mod_id = ' . $mod_id;
    $result = $db->sql_query($query);
    if ($db->sql_numrows($result) != 0) {
        // Il est  dedans alors on l'enlève :
        $query = 'DELETE FROM ' . TABLE_XTENSE_CALLBACKS . ' WHERE mod_id = ' . $mod_id;
        $db->sql_query($query);
        //echo "<script>alert('".$lang['xtense_gone']."')</script>";
    }
}


$mod_uninstall_name = "bigbrother";

$requests[] = "DROP TABLE IF EXISTS  " . TABLE_PLAYER . "; ";
$requests[] = "DROP TABLE IF EXISTS  " . TABLE_STORY_PLAYER . "; ";
$requests[] = "DROP TABLE IF EXISTS  " . TABLE_STORY_ALLY . " ;";
$requests[] = "DROP TABLE IF EXISTS  " . TABLE_ALLY . " ;";
$requests[] = "DROP TABLE IF EXISTS  " . TABLE_UNI . " ;";
$requests[] = "DROP TABLE IF EXISTS  " . TABLE_RPR . "; ";
$requests[] = "DROP TABLE IF EXISTS  " . TABLE_RPF . "; ";
$requests[] = "DROP TABLE IF EXISTS  " . TABLE_RPP . " ;";

//config
$requests[] = "DELETE FROM " . TABLE_CONFIG .
    " WHERE config_name = 'bigbrother'";

// on injecte toutes les requetes
foreach ($requests as $request) {
    $db->sql_query($request);
}


// le cache :
generate_config_cache();
uninstall_mod($mod_uninstall_name, $mod_uninstall_table);

?>
