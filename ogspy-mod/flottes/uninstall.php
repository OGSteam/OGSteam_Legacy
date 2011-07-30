<?php
/*************************************************************************** 
*   filename    : uninstall.php
*   desc.       : fichier de desinstallation du mod flottes
*   Author      : Conrad
*   created     : -
*   modified    : AirBAT, Zanfib
*   last modif. : added Xtense2 interaction
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db, $table_prefix;

define("TABLE_MOD_FLOTTES", $table_prefix."mod_flottes");
define("TABLE_MOD_FLOTTES_ADM", $table_prefix."mod_flottes_admin");
define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");
define("TABLE_GROUP", $table_prefix."group");

// On recupere l'id du mod pour Xtense V2
$query = "SELECT id, version FROM ".TABLE_MOD." WHERE action='flottes'";
$resultid = $db->sql_query($query);
list($mod_id, $version) = $db->sql_fetch_row($resultid);

$mod_uninstall_name = "flottes";
$mod_uninstall_table = 	TABLE_MOD_FLOTTES.', '.TABLE_MOD_FLOTTES_ADM;
uninstall_mod($mod_uninstall_name,$mod_uninstall_table);

echo $mod_id;
$request = "DELETE FROM ".TABLE_GROUP." WHERE group_name='mod_flottes'";
$db->sql_query($request);

// Suppression de la liaison entre Xtense v2 et Flottes

// On regarde si la table xtense_callbacks existe :
$query = 'show tables like "'.TABLE_XTENSE_CALLBACKS.'" ';
$result = $db->sql_query($query);
if($result != 0){

    // on regarde si Flottes est inscrit dedans
    $result = $db->sql_query("Select * From ".TABLE_XTENSE_CALLBACKS." where mod_id = $mod_id");

    // S'il est dedans, on l'enleve
    if($db->sql_numrows($result) != 0)
        $db->sql_query("DELETE FROM ".TABLE_XTENSE_CALLBACKS." where mod_id = $mod_id");
		echo("<script> alert('La compatibilité du mod Flottes avec le mod Xtense2 a été désinstallée !') </script>");
}

?>
