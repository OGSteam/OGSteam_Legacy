<?php
/**
* install.php 
* @package ocartomips
* @author 
* @update ianouf
* @link http://www.ogsteam.fr
*/

//Ce fichier installe le module d'ocartomips
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
global $db;

$mod_folder = "ocartomips";
$is_ok = install_mod ($mod_folder);
if ($is_ok == true)
	{
		// Si besoin de creer des tables, � faire ici
	}
else
	{
		echo  "<script>alert('D�sol�, un probl�me a eu lieu pendant l'installation, corrigez les probl�mes survenue et r�essayez.');</script>";
	}
?>
