<?php
/**
* install.php 
* @package autonomie
* @author Mirtador
* @link http://www.ogsteam.fr
*/

//Ce fichier installe le module d'autonomie


if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

global $db;

// insertion du mod (numéro de version automatique)
if (file_exists('mod/autonomie/version.txt')) {
	$version_txt = file('mod/autonomie/version.txt');

	$db->sql_query('INSERT INTO '.TABLE_MOD.' ( title, menu, action, root, link, version, active) VALUES '
		."( 'MOD Autonomie', 'Autonomie <br> de vos plan&egrave;tes', 'autonomie', 'autonomie', 'index.php', '".trim($version_txt[1])."', '1')");
}
?>
