<?php

/**
* ogscalc.php - Fichier de désinstallation
* @package Calculatrice universelle
* @author Aeris
* @update xaviernuma - 2012
* @link http://www.ogsteam.fr/
**/

if (!defined('IN_SPYOGAME'))
{ 
	die("Hacking attempt");
}

global $db;

// Suppression de la ligne, dans la table des mods.
$db->sql_query("DELETE FROM ".TABLE_MOD." WHERE title='OGSCalc'");

?>