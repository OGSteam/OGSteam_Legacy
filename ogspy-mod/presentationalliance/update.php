<?php
/***************************************************************************
*	Filename	: update.php
*	desc.		: Page d'update du module "Présentation Alliance"
*	Authors	: Shad
*	created	: 30/05/2011
*	modified	: 30/05/2011
*	version	: 0.1
***************************************************************************/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Définitions

//define("TABLE_P_ALLY_PIC", $table_prefix."pres_alliance_pic");
//define("TABLE_P_ALLY_DATA", $table_prefix."pres_alliance_data");

// Modification de la table des mod de OGSpy
global $table_prefix;
$mod_folder = "presentationalliance";
$mod_name = "presentationalliance";
update_mod($mod_folder, $mod_name);
?>