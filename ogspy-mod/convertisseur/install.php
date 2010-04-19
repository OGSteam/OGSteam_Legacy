<?php
/**
* install.php 
* @package convertisseur
* @author Mirtador
* @link http://www.ogsteam.fr
*/

//Ce fichier installe la version 1 du module de aide au commerce


if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

global $db;

if (file_exists('mod/convertisseur/version.txt')) {
	$version_txt = file('mod/convertisseur/version.txt');
	}

$query = "INSERT INTO ".TABLE_MOD." ( title, menu, action, root, link, version, active) VALUES ( 'Aide au commerce', 'Convertisseur <br> de ressources', 'convertisseur', 'convertisseur', 'index.php', '".trim($version_txt[1])."', '1')";
$db->sql_query($query);

?>
