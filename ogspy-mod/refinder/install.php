<?php
//L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//Définitions
global $db, $table_prefix;

//on insère les données du mod, dans la table mod. Module réservé aux administrateurs
$is_ok = false;
$mod_folder = "refinder";
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
