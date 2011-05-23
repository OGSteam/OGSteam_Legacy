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
$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active, admin_only) VALUES ('', 'Copie Locale', 'Copie Locale', 'copylocal', 'copy_local', 'index.php', '0.2a', '1', '1')";
$db->sql_query($query);

?>