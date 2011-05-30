<?php
/**
* uninstall.php du mod MAJ
* @package MAJ
* @author ben.12
* @link http://www.ogsteam.fr
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}
global $db, $table_prefix;
define("TABLE_FRAME", $table_prefix."mod_frames");

$mod_uninstall_name = "nom du mode";
$mod_uninstall_table = $table_prefix."mod_frames";
uninstall_mod ($mod_uninstall_name, $mod_uninstall_table);
?>
