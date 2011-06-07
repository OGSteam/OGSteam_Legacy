<?php
/**
* uninstall.php
* @package recherchealliance
* @author Shad
* @version 1.0
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @description Fichier de désinstallation du mod recherchealliance
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $db;
$mod_uninstall_name = "recherchealliance";
uninstall_mod($mod_uninstall_name,$mod_uninstall_table);
?>