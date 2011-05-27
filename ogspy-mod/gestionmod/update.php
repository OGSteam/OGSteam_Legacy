<?php
/**
* update.php Fichier de mise à jour du MOD Gestion MOD
* @package Gestion MOD
* @author Kal Nightmare
* @link http://www.ogsteam.fr
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}
global $db;

$mod_folder = "gestionmod";
$mod_name = "gestionmod";
update_mod($mod_folder,$mod_name);
?>
