<?php
/***************************************************************************
*	filename	: uninstall.php
*   package     : Copy_local
*	desc.		: Script de desinstallation du module
*	Author		: ericc - http://www.ogsteam.fr/
*	created		: 03/04/2008
*	modified	:
***************************************************************************/

//L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
//Définitions
global $db,$table_prefix;

//Suppression des paramètres de configuration et bbcodes
$mod_uninstall_name = "copylocal";
uninstall_mod($mod_uninstall_name,$mod_uninstall_table);

?>