<?php

/**
* ogscalc.php - Fichier de mise à jour
* @package Calculatrice universelle
* @author Aeris
* @update xaviernuma - 2012
* @link http://www.ogsteam.fr/
**/

if(!defined('IN_SPYOGAME'))
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
	$file = file('mod/'.$path.'/version.txt');
	$db->sql_query('UPDATE '.TABLE_MOD.' SET root="'.$path.'", link="ogscalc.php", action="ogscalc", version="'.trim($file[1]).'" WHERE id="'.$pub_mod_id.'"');
}

?>