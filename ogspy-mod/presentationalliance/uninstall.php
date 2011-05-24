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

//define("TABLE_P_ALLY_PIC", $table_prefix."pres_alliance_pic");
//define("TABLE_P_ALLY_DATA", $table_prefix."pres_alliance_data");

// Modification de la table des mod de OGSpy
global $table_prefix;
$mod_uninstall_name = "presentationalliance";
$mod_uninstall_table = $table_prefix."pres_alliance_pic".', '.$table_prefix."pres_alliance_data";
uninstall_mod($mod_unistall_name,$mod_uninstall_table);
?>