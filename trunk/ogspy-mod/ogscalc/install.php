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
    exit('Hacking Attempt!');
}

$mod_folder = 'ogscalc';

if (install_mod($mod_folder)) 
{
	// Si besoin de cr�er des tables, � faire ici
}
else 
{
	echo '<script>alert(\'Un probl�me a eu lieu pendant l\\\'installation du mod, corrigez les probl�mes survenus et r�essayez.\');</script>';
}

?>