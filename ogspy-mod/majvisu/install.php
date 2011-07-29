<?php
/**
* install.php 
* @package majvisu
* @author 
* @update ianouf
* @link http://www.ogsteam.fr
*/

//Ce fichier installe le module de majvisu
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
global $db;

$mod_folder = "majvisu";
$is_ok = install_mod ($mod_folder);
if ($is_ok == true)
	{
		// Si besoin de creer des tables, à faire ici
	}
else
	{
		echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
	}
?>
