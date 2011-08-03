<?php
/**
 * uninstall.php 
 * @package Guerres
 * @author Verité
 * @link http://www.ogsteam.fr
 * @version 0.2e
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

//L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//Définitions
global $db;
global $table_prefix;
define("TABLE_GUERRES_LISTE", $table_prefix."guerres_listes");
define("TABLE_GUERRES_ATTAQUES", $table_prefix."guerres_attaques");
define("TABLE_GUERRES_RECYCLAGES", $table_prefix."guerres_recyclages");
	
$mod_uninstall_name = "guerres";
$mod_uninstall_table = $table_prefix."guerres_listes".','.$table_prefix."guerres_attaques".','.$table_prefix."guerres_recyclages";
uninstall_mod($mod_uninstall_name,$mod_uninstall_table);


?>
