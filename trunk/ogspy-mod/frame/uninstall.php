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

$query = "DROP TABLE ".TABLE_FRAME."";
$db->sql_query($query);

$query = "DELETE FROM ".TABLE_MOD." WHERE root='ModFrame'";
$db->sql_query($query);
?>
