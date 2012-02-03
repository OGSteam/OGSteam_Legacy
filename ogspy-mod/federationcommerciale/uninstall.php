<?php
/**
* uninstall.php 
* @package Attaques
* @author Verité
* @link http://www.ogsteam.fr
*/

define("IN_SPYOGAME", true);
require_once("common.php");

if (!defined('IN_SPYOGAME')) die("Hacking Attemp!");
 
global $db, $table_prefix;
$mod_uninstall_name = "Federation Commerciale";
$mod_uninstall_table = $table_prefix.'federation_commercial'.','.$table_prefix.'federation_commercial_vente'.','.$table_prefix.'federation_commercial_participants';
uninstall_mod ($mod_uninstall_name, $mod_uninstall_table);
?>
