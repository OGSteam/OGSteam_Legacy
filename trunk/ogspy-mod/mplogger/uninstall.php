<?php
/**
 * uninstall.php 

Script de désintallation

 * @package MP_Logger
 * @author Sylar
 * @link http://www.ogsteam.fr
 * @version : 0.1
 * dernière modification : 16.10.07
 * Module de capture des messages entre joueurs
 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
include("mpl_includes.php");

global $db, $table_prefix;
$mod_uninstall_name = "mp_logger";
$mod_uninstall_table = $table_prefix.$mod_name.'_config'.', '.$table_prefix.$mod_name;
uninstall_mod($mod_uninstall_name, $mod_uninstall_table);
?>