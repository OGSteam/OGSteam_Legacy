<?php
/***************************************************************************
*	filename	: install.php
*   package     : Copy_local
*	desc.		: Script d'installation du module
*	Author		: ericc - http://www.ogsteam.fr/
*	created		: 10/03/2008
*	modified	: 05/04/2008
***************************************************************************/
/*
* This work is hereby released into the Public Domain.
* To view a copy of the public domain dedication,
* visit http://creativecommons.org/licenses/publicdomain/ or send a letter to
* Creative Commons, 559 Nathan Abbott Way, Stanford, California 94305, USA.
*
*/

//L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//Définitions
global $db, $table_prefix;

//on insère les données du mod, dans la table mod. Module réservé aux administrateurs
$is_ok = false;
$mod_folder = "copylocal";
$is_ok = install_mod ($mod_folder);
if ($is_ok == true)
	{
		// On traite des données si necessaire
	}
else
	{
		echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
	}

?>