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

//D�finitions
global $db, $table_prefix;

//on ins�re les donn�es du mod, dans la table mod. Module r�serv� aux administrateurs
$is_ok = false;
$mod_folder = "copylocal";
$is_ok = install_mod ($mod_folder);
if ($is_ok == true)
	{
		// On traite des donn�es si necessaire
	}
else
	{
		echo  "<script>alert('D�sol�, un probl�me a eu lieu pendant l'installation, corrigez les probl�mes survenue et r�essayez.');</script>";
	}

?>