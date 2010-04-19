<?php
/***************************************************************************
*	Filename	: config.php
*	desc.		: Page de configuration du module "Présentation Alliance"
*	Authors	: Sylar - sylar@ogsteam.fr
*	created	: 23/02/2008
*	modified	: 25/02/2008
*	version	: 0.1
***************************************************************************/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
/*/ <---------- Enlever l'étoile pour activer le debug
define('DEBUG','1');//*/

// Définitions
global $table_prefix;
define("TABLE_P_ALLY_PIC", $table_prefix."pres_alliance_pic");
define("TABLE_P_ALLY_DATA", $table_prefix."pres_alliance_data");
define("FOLDER_MOD", "mod/presentation_alliance");
define("FOLDER_INC", FOLDER_MOD."/includes");
define("FOLDER_PAGES", FOLDER_MOD."/pages");
define("FOLDER_BKGND", FOLDER_MOD."/fonds");
define("FOLDER_FONT", FOLDER_MOD."/polices");
define("FOLDER_IMG", FOLDER_MOD."/images");
define("FOLDER_OUTPUT", FOLDER_MOD."/output");
define("FILE_FOOTER", FOLDER_PAGES."/footer.php");

// Test si le dossier de sortie existe, sinon le créer
if(!is_dir(FOLDER_OUTPUT)) @mkdir(FOLDER_OUTPUT);

// Chargement des fichiers nécessaires
require_once(FOLDER_INC."/police.php");
require_once(FOLDER_INC."/lecturebase.php");
require_once(FOLDER_INC."/ecriture_image2.php");
require_once(FOLDER_INC."/update.php");

// Tableau du menu
$menu = Array( 	Array("titre" => "Accueil", "lien" => "accueil", "admin"=>0),
						Array("titre" => "Edition", "lien" => "edition", "admin"=>0),
						Array("titre" => "Admin", "lien" => "admin", "admin"=>1)			);

// Routine de debug_log
function debug_log($texte,$print=0){
	global $debug_log;
	if(defined('DEBUG')&&DEBUG==1) 
		if($print==0)
			$debug_log .= $texte."<br/>";
		else	
			echo $debug_log;
}
?>