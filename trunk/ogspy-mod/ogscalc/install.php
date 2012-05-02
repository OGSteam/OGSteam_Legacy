<?php

/**
* install.php - Fichier d'installation
* @package Calculatrice universelle
* @author Aeris
* @update xaviernuma - 2012
* @link http://www.ogsteam.fr/
**/

if (!defined('IN_SPYOGAME'))
{ 
	die("Hacking attempt");
}

// Recherche du nom du dossier.
if(file_exists('mod/ogscalc/version.txt'))
{
	$path = 'ogscalc';
}
elseif(file_exists('mod/OGSCalc/version.txt'))
{
	$path = 'OGSCalc';
}

if(isset($path)) 
{
	global $db;
	$file = file('mod/'.$path.'/version.txt' );
	
	// Suppression de la ligne, dans la table des mods. (au cas où...)
	$db->sql_query("DELETE FROM ".TABLE_MOD." WHERE title='OGSCalc'");
	
	// Ajout de la même ligne.
	$query = 'INSERT INTO ' . TABLE_MOD . ' (title, menu, action, root, link, version, active) VALUES ';
	$query .= '("OGSCalc", "OGSCalc", "ogscalc", "' . $path . '", "ogscalc.php", "' . trim ( $file[1] )  . '", 1)';
	$db->sql_query($query);
}

?>