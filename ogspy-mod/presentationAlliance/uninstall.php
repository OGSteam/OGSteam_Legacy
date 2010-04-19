<?php
/***************************************************************************
*	Filename	: uninstall.php
*	desc.		: Page de désintallation du module "Présentation Alliance"
*	Authors	: Sylar - sylar@ogsteam.fr
*	created	: 23/02/2008
*	modified	: 25/02/2008
*	version	: 0.1
***************************************************************************/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Définitions
global $db,$table_prefix;
define("TABLE_P_ALLY_PIC", $table_prefix."pres_alliance_pic");
define("TABLE_P_ALLY_DATA", $table_prefix."pres_alliance_data");

// Suppression de la table des images
$db->sql_query("DROP TABLE IF EXISTS ".TABLE_P_ALLY_PIC.";");

// Suppression de la table des champs
$db->sql_query("DROP TABLE IF EXISTS ".TABLE_P_ALLY_DATA.";");

// Modification de la table des mod de OGSpy
$db->sql_query("DELETE FROM ".TABLE_MOD." WHERE title='presentation_alliance'");
?>