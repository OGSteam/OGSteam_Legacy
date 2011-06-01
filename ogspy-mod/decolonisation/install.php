<?php
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $server_config;

require_once("mod/decolonisation/lang/lang_fr.php");
//if (file_exists("mod/decolonisation/lang/lang_".$server_config['language'].".php")) require_once("mod/decolonisation/lang/lang_".$server_config['language'].".php");

// Ajout du module dans la table des mod de OGSpy
$is_ok = false;
$mod_folder = "decolonisation";
$is_ok = install_mod($mod_folder);
if ($is_ok == true)
	{
		//si besoin de creer des tables, a faire ici
	}
else
	{
		echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
	}



?>
