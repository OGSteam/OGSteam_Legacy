<?php
/**
* update.php 
* @package commerce
* @author Mirtador
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME')){ die("Hacking attempt"); }

global $db;

if (file_exists('mod/commerce/version.txt')) {
	$version_txt = file('mod/commerce/version.txt');
	}

$query = "UPDATE ".TABLE_MOD." SET version='".trim($version_txt[1])."' WHERE action='commerce'";
$db->sql_query($query);
?>

