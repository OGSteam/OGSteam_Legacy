<?php

/**
* install.php Fichier de mise à jour du MOD Gestion MOD
* @package Gestion MOD
* @author Kal Nightmare
* @Mise à jour par xaviernuma 2012
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME')) 
{
    die("Hacking attempt");
}

global $db;
$is_ok = false;
$mod_folder = "gestionmod";
$is_ok = install_mod ($mod_folder);

if ($is_ok == true)
{
	// Si besoin de creer des tables, à faire ici
}
else
{
	echo  '<script type="text/javascript">>alert(\'Désolé, un problème a eu lieu pendant l\\\'installation, corrigez les problèmes survenue et réessayez.\');</script>';
}
	
?>