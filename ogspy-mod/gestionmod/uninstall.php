<?php
/**
* install.php Fichier de mise à jour du MOD Gestion MOD
* @package Gestion MOD
* @author Kal Nightmare
* @link http://www.ogsteam.fr
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}
global $db;

$mod_uninstall_name ="gestionmod";
uninstall_mod($mod_uninstall_name,$mod_uninstall_table);
?>
