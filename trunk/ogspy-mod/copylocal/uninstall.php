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
//D�finitions
global $db,$table_prefix;

//Suppression des param�tres de configuration et bbcodes
$query="DELETE FROM ".TABLE_MOD." WHERE `action`='copylocal'";
$db->sql_query($query);

?>