<?php

/**
* update.php Fichier de mise � jour du MOD Gestion MOD
* @package Gestion MOD
* @author Kal Nightmare
* @Mise � jour par xaviernuma 2012
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME')) 
{
    die("Hacking attempt");
}

global $db;

$mod_folder = "gestionmod";
$mod_name = "gestionmod";
update_mod($mod_folder,$mod_name);

?>