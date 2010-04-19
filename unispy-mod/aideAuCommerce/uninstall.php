<?php
/**
* uninstall.php 
* @package Attaques
* @author Verité
* @link http://www.ogsteam.fr
*/

define("IN_SPYOGAME", true);
if (!defined('IN_UNISPY2')) {
	require_once("common.php");
}
$query = "DELETE FROM ".TABLE_MOD." WHERE action='convertisseur'";
$db->sql_query($query);
?>
