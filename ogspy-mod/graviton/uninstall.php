<?php
/**
* Desinstallation du module
* @package graviton
* @author Aeris
* @link http://board.ogsteam.fr
 */
if (!defined('IN_SPYOGAME')) die('Hacking attempt'); 

$mod_uninstall_name = "graviton";
uninstall_mod($mod_uninstall_name,$mod_uninstall_table);

?>
