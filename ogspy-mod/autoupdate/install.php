<?php
/** $Id$ **/
/**
* install.php Fichier d'installation
* @package [MOD] AutoUpdate
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 1.0c
* created	: 27/10/2006
* modified	: 18/01/2007
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}
// Ajout du module dans la table des mod de OGSpy
$is_ok = false;
$mod_folder = "autoupdate";
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
