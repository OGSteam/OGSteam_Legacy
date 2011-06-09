<?php
/**
* uninstall.php 
* @package autonomie
* @author Mirtador
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME')) die('Hacking attempt');
global $db;
$mod_uninstall_name = "autnomie";
uninstall_mod($mod_uninstall_name,$mod_uninstall_table);

?>
