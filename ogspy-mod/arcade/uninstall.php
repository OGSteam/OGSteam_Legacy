<?php
/**
* uninstall.php : Desinstallation du Module Arcade
* @author ericalens <ericalens@ogsteam.fr> http://www.ogsteam.fr
* @copyright OGSteam 2006 
* @version 2.0
* @package Arcade
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}
global $db, $table_prefix;

$mod_uninstall_name = "Arcade";
$mod_uninstall_table = $table_prefix."arcade".', '.$table_prefix."arcade_ban".', '.$table_prefix."arcade_game".', '.$table_prefix."arcade_online".', '.$table_prefix."arcade_tourgame".', '.$table_prefix."arcade_tournament".', '.$table_prefix."arcade_tourscore";
uninstall_mod ($mod_uninstall_name, $mod_uninstall_table);

// Suppression des variables de configuration du module dans la table de config
$query="DELETE FROM ".TABLE_CONFIG." WHERE config_name like 'arcade_%'";
$db->sql_query($query);

?>
