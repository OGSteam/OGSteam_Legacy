<?php
/**
* update.php 
* @package convertisseur
* @author Mirtador
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
global $db;

if (file_exists('mod/convertisseur/version.txt')) {
	$version_txt = file('mod/convertisseur/version.txt');
	}

$query = "UPDATE ".TABLE_MOD." SET version='".trim($version_txt[1])."' WHERE action='convertisseur'";
$db->sql_query($query);
?>

