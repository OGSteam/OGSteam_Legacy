<?php
/**
* update.php 
* @package Attaques
* @author Verité
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME') && !defined('IN_UNISPY2')) {
	die("Hacking attempt");
}
global $db;

if (file_exists('mod/convertisseur/version.txt')) {
	$version_txt = file('mod/convertisseur/version.txt');
	}

$query = "UPDATE ".TABLE_MOD." SET version='".trim($version_txt[1])."' WHERE action='convertisseur'";
$db->sql_query($query);
?>

