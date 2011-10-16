<?php
/**
* update.php
* @package Mod Cdr
* @author Machine
* @co-author Capi
* @version 1.62
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @description Fichier de mise à jour du mod Cdr
*/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $db, $table_prefix;
$mod_folder = "recycleur";
$mod_name = "recycleurs";
update_mod($mod_folder, $mod_name);
?>